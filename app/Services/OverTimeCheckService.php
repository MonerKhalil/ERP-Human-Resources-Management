<?php

namespace App\Services;

use App\Exceptions\MainException;
use App\Models\Employee;
use App\Models\OvertimeType;
use App\Models\PublicHoliday;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OverTimeCheckService
{
    /**
     * @param Employee $employee
     * @param OvertimeType $overtimeType
     * @param Request $request
     * @return StoreData
     * @throws \Exception
     * @author moner khalil
     */
    public function MainCheckCanOvertime(Employee $employee, OvertimeType $overtimeType, Request $request){

        if ($request->is_hourly){
            return $this->CheckOverTimeIsHourly($employee,$overtimeType,$request);
        }
        return $this->CheckOverTimeDays($employee,$overtimeType,$request);
    }

    private function CheckOverTimeIsHourly($employee, $overtimeType, $request){
        $from = Carbon::parse($request->from_date)->format("Y-m-d");
        $to = Carbon::parse($request->to_date)->format("Y-m-d");
        //Code Days ......
        $h_from = Carbon::parse($request->from_time)->format("H:i:s");
        $h_to = Carbon::parse($request->to_time)->format("H:i:s");
        $countDays = Carbon::createFromFormat("Y-m-d",$to)->diffInDays($from);
        $countHoursInDays = Carbon::createFromFormat("H:i:s",$h_from)->diffInHours($h_to);
        if ($overtimeType->min_hours_in_days > $countHoursInDays){
            throw new MainException(__("err_request_overtime_time"));
        }
        $Check = $this->CheckIsHourlyOvertimeSalary($overtimeType,$employee,$countHoursInDays,$countDays);
        if (is_string($Check)){
            throw new MainException($Check);
        }
        $this->CheckIsOverTimeHourInWorkHours($employee,$h_from,$h_to);
        return new StoreData($from,$to,$countDays,$h_from,$h_to,$countHoursInDays);
    }

    private function CheckIsOverTimeHourInWorkHours($employee,$h_from,$h_to){
        $work_hours_from = Carbon::createFromFormat("H:i:s",$employee->work_setting->work_hours_from);
        $work_hours_to = Carbon::createFromFormat("H:i:s",$employee->work_setting->work_hours_to);
        $h_from = Carbon::createFromFormat("H:i:s",$h_from);
        $h_to = Carbon::createFromFormat("H:i:s",$h_to);
        if (!(
            $work_hours_from->greaterThan($h_from) && $work_hours_from->greaterThan($h_to)
            && $work_hours_to->greaterThan($h_from) && $work_hours_to->greaterThan($h_to)
            )
            &&
            !(
            $work_hours_from->lessThan($h_from) && $work_hours_from->lessThan($h_to)
            && $work_hours_to->lessThan($h_from) && $work_hours_from->lessThan($h_to)
            )){
            throw new MainException(__("err_overtime_datetime_valid"));
        }
    }

    private function CheckIsHourlyOvertimeSalary($overtime_type,$employee,$countHours,$countDaysOverTime){
        $CountAllHoursOvertimeRequest = $countHours * $countDaysOverTime;
        $salaryAllHours = $CountAllHoursOvertimeRequest * $overtime_type->salary_in_hours;
        $salaryEmployee = $employee->contract()->first()->salary ?? 1;
        $RateSalary = $salaryEmployee * ($overtime_type->max_rate_salary / 100);
        if ($salaryAllHours > $RateSalary){
            return __("err_request_overtime_rate_salary");
        }
        $allRequestsOvertimeTypeByEmployeeHours = $employee->overtimes()
            ->where("overtime_type_id",$overtime_type->id)
            ->where("is_hourly",true)
            ->whereYear("created_at",date("Y"))
            ->whereMonth("created_at",date("M"))
            ->sum(DB::raw("overtimes.count_days * overtimes.count_hours_in_days"));
        $CountAllHoursOvertimeRequest += $allRequestsOvertimeTypeByEmployeeHours;
        $salaryAllHours = $CountAllHoursOvertimeRequest * $overtime_type->salary_in_hours;
        if ($salaryAllHours > $RateSalary){
            return __("err_request_overtime_rate_salary");
        }
        return true;
    }

    /*===========================================
    =        Start Check OverTimes Days         =
   =============================================*/

    private function CheckOverTimeDays($employee, $overtimeType, $request){
        $from = Carbon::parse($request->from_date)->format("Y-m-d");
        $to = Carbon::parse($request->to_date)->format("Y-m-d");
        $CountDaysOverTime = $this->CheckDaysOvertimeInHolidays($from,$to,$employee->work_setting->days_leaves_in_weeks);
        if (is_string($CountDaysOverTime)){
            throw new MainException($CountDaysOverTime);
        }
        $CheckSalary = $this->CheckDaysOvertimeSalary($overtimeType,$employee,$CountDaysOverTime);
        if (is_string($CheckSalary)){
            throw new MainException($CheckSalary);
        }
        return new StoreData($from,$to,$CountDaysOverTime);
    }

    private function CheckDaysOvertimeInHolidays($fromDate , $toDate,$daysOffEmployee){
        $Holidays = PublicHoliday::query()->where(function ($query) use ($fromDate,$toDate){
            $query->whereBetween('start_date', [$fromDate, $toDate])
                ->orWhereBetween('end_date', [$fromDate, $toDate])
                ->orWhere(function ($query) use ($fromDate, $toDate) {
                    $query->where('start_date', '<', $fromDate)
                        ->where('end_date', '>', $toDate);
                });
        })->get();
        $CanNotOvertimeDate = [];
        $period1 = CarbonPeriod::create($fromDate, $toDate);
        foreach ($period1 as $date) {
            $isOverlapping = false;
            foreach ($Holidays as $Holiday) {
                $startDate2 = $Holiday->start_date;
                $endDate2 = $Holiday->end_date;
                $period2 = CarbonPeriod::create($startDate2, $endDate2);

                if ($period2->contains($date)) {
                    $isOverlapping = true;
                    break;
                }
            }

            if (!$isOverlapping) {
                $CanNotOvertimeDate[] = $date->format('Y-m-d');
            }
        }

        $daysOffEmployee = explode(",",$daysOffEmployee);

        foreach ($CanNotOvertimeDate as $date){
            $date = date("l",strtotime($date));
            if (!in_array($date,$daysOffEmployee)){
                return __("err_request_overtime_days");
            }
        }
        return count($CanNotOvertimeDate);
    }

    private function CheckDaysOvertimeSalary($overtime_type,$employee,$countDaysOverTime){
        $countDaysWorkEmployee = $employee->work_setting->count_hours_work_in_days;
        $CountAllHoursOvertimeRequest = $countDaysOverTime * $countDaysWorkEmployee;
        $salaryAllHours = $CountAllHoursOvertimeRequest * $overtime_type->salary_in_hours;
        $salaryEmployee = $employee->contract()->first()->salary ?? 1;
        $RateSalary = $salaryEmployee * ($overtime_type->max_rate_salary / 100);
        if ($salaryAllHours > $RateSalary){
            return __("err_request_overtime_rate_salary");
        }
        $allRequestsOvertimeTypeByEmployeeDays = $employee->overtimes()
            ->where("overtime_type_id",$overtime_type->id)
            ->where("is_hourly",false)
            ->whereYear("created_at",date("Y"))
            ->whereMonth("created_at",date("M"))
            ->sum("count_days");
        $CountAllHoursOvertimeRequest += ($allRequestsOvertimeTypeByEmployeeDays * $countDaysWorkEmployee);
        $salaryAllHours = $CountAllHoursOvertimeRequest * $overtime_type->salary_in_hours;
        if ($salaryAllHours > $RateSalary){
            return __("err_request_overtime_rate_salary");
        }
        return true;
    }

    /*===========================================
    =        End Check OverTimes Days         =
   =============================================*/
}

class StoreData{
    public $fromDate,$toDate,$countDays;
    public $fromTime,$toTime,$count_hours_in_days;
    public function __construct($fromDate,$toDate,$countDays,$fromTime=null,$toTime=null,$count_hours_in_days=null)
    {
        $this->toDate = $toDate;
        $this->fromDate = $fromDate;
        $this->countDays = $countDays;
        $this->fromTime = $fromTime;
        $this->toTime = $toTime;
        $this->count_hours_in_days = $count_hours_in_days;
    }
}
