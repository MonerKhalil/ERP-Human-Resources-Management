<?php

namespace App\Console\Tasks;

use App\Models\Attendance;
use App\Models\ConferenceEmployee;
use App\Models\Decision;
use App\Models\Education_data;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Overtime;
use App\Models\Payroll;
use App\Models\PositionEmployee;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;

class EditSalaryEmployees extends MainClassTasks
{
    public function mainProcess(Schedule $schedule)
    {
        $schedule->call(function (){
            do{
                $temp = $this->EditSalary();
            }while(!$temp);
        })->dailyAt("23:30");
//        })->dailyAt("15:44");
    }

    private function EditSalary(){
        try {
            DB::beginTransaction();
            $employees = $this->getEmployees();
            foreach ($employees as $employee){
                $employee_id = $employee->id;
                $workSetting = $employee->work_setting;
                $salary = Employee::salary($employee_id);
                $overTimes = $this->salaryOverTime($employee_id);//array// + salary
                $bonusesDecision = $this->salaryDecision($employee_id,$salary,"increment");// + salary
                $penaltiesDecision = $this->salaryDecision($employee_id,$salary,"decrement");// - salary
                $positionEmployee = $this->salaryPositionEmployee($employee_id,$salary);// + salary
                $conferencesEmployee = $this->salaryConferencesEmployee($employee_id,$salary);// + salary
                $educationValue = $this->salaryEducationValue($employee_id,$salary);// + salary
                $absenceValue = $this->salaryAbsence($employee_id,$salary);//array// - salary
                $leavesUnpaidValue = $this->salaryLeavesUnpaidValue($employee_id,$salary);//array// - salary
                $leavesEffectSalaryValue = $this->salaryLeavesEffectSalaryValue($employee_id,$salary);//array// - salary
                $late_entry_and_early_exit = $this->salary_late_entry_and_early_exit($employee,$salary,$workSetting);//array//- salary
                $payroll = Payroll::query()->where("employee_id",$employee_id)
                    ->whereYear("created_at",now()->year)
                    ->whereMonth("created_at",now()->month)
                    ->whereDay("created_at",now()->day)
                    ->first();
                $finalSalary =
                    ($salary + $overTimes["valueFinalOvertime"] + $bonusesDecision + $positionEmployee + $conferencesEmployee + $educationValue)
                    -
                    ($penaltiesDecision + $absenceValue["salaryAbsence"]
                        + $leavesUnpaidValue["leaves_unpaid_value"] + $leavesEffectSalaryValue["leaves_effect_salary_value"]
                        + $late_entry_and_early_exit["minutes_late_entry_value"] + $late_entry_and_early_exit["minutes_early_exit_value"]);
                if ($finalSalary<0){
                    $finalSalary = 0;
                }
                $payroll->update([
                    "total_salary" => $finalSalary,
                    "default_salary" => $salary,
                    "overtime_minute" => $overTimes["allHours"] * 60,
                    "overtime_value" => $overTimes["valueFinalOvertime"],
                    "bonuses_decision" => $bonusesDecision,
                    "penalties_decision" => $penaltiesDecision,
                    "position_employee_value" => $positionEmployee,
                    "conferences_employee_value" => $conferencesEmployee,
                    "education_value" => $educationValue,
                    "absence_days" => $absenceValue["count_absences_days"],
                    "absence_days_value" => $absenceValue["salaryAbsence"],
                    "count_leaves_unpaid" => $leavesUnpaidValue["count_leaves_unpaid"],
                    "leaves_unpaid_value" => $leavesUnpaidValue["leaves_unpaid_value"],
                    "count_leaves_effect_salary" => $leavesEffectSalaryValue["count_leaves_effect_salary"],
                    "leaves_effect_salary_value" => $leavesEffectSalaryValue["leaves_effect_salary_value"],
                    "minutes_late_entry" => $late_entry_and_early_exit["minutes_late_entry"],
                    "minutes_late_entry_value" => $late_entry_and_early_exit["minutes_late_entry_value"],
                    "minutes_early_exit" => $late_entry_and_early_exit["minutes_early_exit"],
                    "minutes_early_exit_value" => $late_entry_and_early_exit["minutes_early_exit_value"],
                ]);
            }
            DB::commit();
            return true;
        }catch (\Exception $exception){
            DB::rollBack();
            return false;
        }
    }

    /**
     * @param $employee
     * @return float[]|int[]
     */
    private function salaryOverTime($employee){
        $work_setting = Employee::with("work_setting")->find($employee)->work_setting;
        $overtimes = Overtime::with("overtime_type")
            ->where("employee_id",$employee)
            ->where("status","approve")
            ->where(function ($q){
                return $q->where(function ($q){
                    return $q->whereYear("from_date",now()->year)
                        ->whereMonth("from_date",now()->month);
                })
                ->orWhere(function ($q){
                    return $q->whereYear("to_date",now()->year)
                        ->whereMonth("to_date",now()->month);
                });
            })->get();
        $salaryOverTime = 0;
        $finalHours = 0;
        foreach ($overtimes as $overtime){
            if ($overtime->is_hourly){
                $allHours = $overtime->count_days * $overtime->count_hours_in_days;
            }else{
                $allHours = $overtime->count_days * $work_setting->count_hours_work_in_days;
            }
            $salaryOverTime += $allHours * $overtime->overtime_type->salary_in_hours;
            $finalHours += $allHours;
        }
        return [
          "allHours" => $finalHours,
          "valueFinalOvertime" => $salaryOverTime,
        ];
    }

    private function salaryDecision($employee,$salary,$type){
        $bonusesDecision = Decision::query()
            ->whereHas("employees",function ($q)use($employee){
               return $q->where("employee_id",$employee);
            })
            ->whereDate("date",">=",now())
            ->whereDate("end_date_decision","<=",now())
            ->where("effect_salary",$type)
            ->get();
        $salaryBonusesDecision = 0;
        foreach ($bonusesDecision as $item){
            $salaryBonusesDecision += ($item->rate / 100) * $salary;
        }
        return $salaryBonusesDecision;
    }

    private function salaryPositionEmployee($employee,$salary){
        $positions = PositionEmployee::with("position")
            ->where("employee_id",$employee)
            ->whereDate("start_date",">=",now())
            ->whereDate("end_date","<=",now())
            ->get();
        $salaryPositionEmployee = 0;
        foreach ($positions as $item){
            $salaryPositionEmployee += ($item->position->rate_salary / 100) * $salary;
        }
        return $salaryPositionEmployee;
    }

    private function salaryConferencesEmployee($employee,$salary){
        $conferences = ConferenceEmployee::with("conference")
            ->where("employee_id",$employee)->get();
        $salaryConferences = 0;
        foreach ($conferences as $item){
            $salaryConferences += ($item->conference->rate_effect_salary / 100) * $salary;
        }
        return $salaryConferences;
    }

    private function salaryEducationValue($employee,$salary){
        $educations = Education_data::query()->where("employee_id",$employee)->get();
        $salaryEducation = 0;
        foreach ($educations as $education){
            $salaryEducation += ($education->amount_impact_salary / 100) * $salary;
        }
        return $salaryEducation;
    }

    private function salaryAbsence($employee,$salary){
        $absences = Attendance::query()
            ->where("employee_id",$employee)
            ->whereYear("created_at",now()->year)
            ->whereMonth("created_at",now()->month)
            ->whereNull("check_in")
            ->get();
        $salary_in_day = $salary / 30 ;
        $count_absences_days = 0;
        foreach ($absences as $absence){
            $leave = Leave::query()
                ->where("employee_id",$employee)
                ->where("status","approve")
                ->whereHas("leave_type",function ($q){
                    return $q->where("is_hourly","0");
                })
                ->whereDate("from_date",">=",$absence->created_at)
                ->whereDate("to_date","<=",$absence->created_at)
                ->first();
            if (is_null($leave)){
                $count_absences_days++;
            }
        }
        return [
            "count_absences_days" => $count_absences_days ,
            "salaryAbsence" => ( $salary_in_day * (2 * $count_absences_days) ),
        ];
    }

    private function salaryLeavesUnpaidValue($employee,$salary){
        $countLeaves = Leave::query()
            ->where("employee_id",$employee)
            ->whereHas("leave_type",function ($q){
                return $q
                    ->where("is_hourly","0")
                    ->where("type_effect_salary","unpaid");
            })
            ->where("status","approve")
            ->where(function ($q){
                return $q->where(function ($q){
                    return $q->whereYear("from_date",now()->year)
                        ->whereMonth("from_date",now()->month);
                })->orWhere(function ($q){
                    return $q->whereYear("to_date",now()->year)
                        ->whereMonth("to_date",now()->month);
                });
            })->sum("count_days");
        $salary_in_day = $salary / 30 ;
        return [
            "count_leaves_unpaid" => $countLeaves,
            "leaves_unpaid_value" => $countLeaves * $salary_in_day,
        ];
    }

    private function salaryLeavesEffectSalaryValue($employee,$salary){
        $leavesEffectSalary = Leave::query()
            ->where("employee_id",$employee)
            ->whereHas("leave_type",function ($q){
                return $q
                    ->where("is_hourly","0")
                    ->where("type_effect_salary","effect_salary");
            })
            ->where("status","approve")
            ->where(function ($q){
                return $q->where(function ($q){
                    return $q->whereYear("from_date",now()->year)
                        ->whereMonth("from_date",now()->month);
                })->orWhere(function ($q){
                    return $q->whereYear("to_date",now()->year)
                        ->whereMonth("to_date",now()->month);
                });
            })->get();
        $salaryLeavesEffectSalary = 0;
        $countLeaves = 0;
        foreach ($leavesEffectSalary as $item){
            if (!is_null($item->leave_type)){
                $countLeaves += $item->count_days;
                $salaryLeavesEffectSalary += $item->count_days * ($item->leave_type->rate_effect_salary / 100) * $salary;
            }
        }
        return [
            "count_leaves_effect_salary" => $countLeaves,
            "leaves_effect_salary_value" => $salaryLeavesEffectSalary,
        ];
    }

    private function salary_late_entry_and_early_exit($employee,$salary,$workSetting){
        $attendances = Attendance::query()
            ->where("employee_id",$employee)
            ->whereYear("created_at",now()->year)
            ->whereMonth("created_at",now()->month)
            ->whereNotNull("check_in")
            ->get();
        $minutes_late_entry = 0;
        $minutes_early_exit = 0;
        foreach ($attendances as $attendance){
            $minutes_late_entry += $attendance->late_entry_per_minute;
            $minutes_early_exit += $attendance->early_exit_per_minute;
        }
        if ($workSetting->type_discount_minuteOrHour == "minute"){
            $minutes_late_entry_value = $minutes_late_entry * ($workSetting->rate_deduction_from_salary / 100) * $salary;
            $minutes_early_exit_value = $minutes_early_exit * ($workSetting->rate_deduction_from_salary / 100) * $salary;
        }else{
            $minutes_late_entry_value = intval($minutes_late_entry/60) * ($workSetting->rate_deduction_from_salary / 100) * $salary;
            $minutes_early_exit_value = intval($minutes_early_exit/60) * ($workSetting->rate_deduction_from_salary / 100) * $salary;
        }
        return [
            "minutes_late_entry" => $minutes_late_entry,
            "minutes_late_entry_value" => $minutes_late_entry_value,
            "minutes_early_exit" => $minutes_early_exit,
            "minutes_early_exit_value" => $minutes_early_exit_value,
        ];
    }
}
