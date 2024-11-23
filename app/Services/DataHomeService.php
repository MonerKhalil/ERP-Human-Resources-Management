<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Contract;
use App\Models\Decision;
use App\Models\Employee;
use App\Models\EvaluationMember;
use App\Models\Leave;
use App\Models\Overtime;
use App\Models\Payroll;
use App\Models\Sections;
use App\Models\SessionDecision;
use Illuminate\Support\Facades\DB;

class DataHomeService
{
    private $employee,$employee_id;

    public function __construct()
    {
        $this->employee = auth()->user()->employee;
        $this->employee_id =  !is_null($this->employee) ?  $this->employee->id : null;
    }

    /**
     * @return array
     * @author moner khalil
     */
    public function getAllData():array{
        $data = [];
        $data["admin"] = $this->processAdmin();
        $data["current_employee"] = $this->processEmployee();
        return $data;
    }

    private function processEmployee(){
        return [
            "count_days_overTime_in_month_current" => Overtime::query()
                    ->whereYear("created_at",now()->year)
                    ->whereMonth("created_at",now()->month)
                    ->where("employee_id",$this->employee_id)
                    ->where("is_hourly","0")
                    ->sum("count_days") ?? 0,
            "count_houres_overTime_in_month_current" => $this->countHoursOverTimeInMonthCurrent(),
            "count_days_attendance_in_month_current" => $this->countAttendanceCheckInInMonthCurrent(),
            "count_leaves_in_last_5_month" => $this->countLeavesInLast5Month(),
            "evaluation_avg_in_month_current" => $this->evaluationAvgInMonthCurrent(),//is object......,
            "salary" => Payroll::query()
            ->where("employee_id",$this->employee_id)
            ->whereYear("created_at",now()->year)
            ->whereMonth("created_at",now()->month)
            ->whereDay("created_at",now()->day)
            ->first()->total_salary ?? Employee::salary($this->employee_id),
        ];
    }

    private function processAdmin(){
        return [
            "count_employees" => Employee::query()->count(),
            "count_sections" => Sections::query()->count(),
            "count_sessions" => SessionDecision::query()->count(),
            "count_contracts" => Contract::query()->count(),
            "count_decisions" => Decision::query()->count(),
            "count_decisions_in_month_current" => Decision::query()
                ->whereYear("created_at",now()->year)
                ->whereMonth("created_at",now()->month)->count(),
            "count_leaves_request_pending_in_month_current" => Leave::query()
                ->whereYear("created_at",now()->year)
                ->whereMonth("created_at",now()->month)
                ->where("status","pending")->count(),
            "count_overtime_request_pending_in_month_current" => Overtime::query()
                ->whereYear("created_at",now()->year)
                ->whereMonth("created_at",now()->month)
                ->where("status","pending")->count(),
            "count_leaves_request_pending_in_day_current" => Leave::query()
                ->whereYear("created_at",now()->year)
                ->whereDay("created_at",now()->day)
                ->where("status","pending")->count(),
            "count_overtime_request_pending_in_day_current" => Overtime::query()
                ->whereYear("created_at",now()->year)
                ->whereDay("created_at",now()->day)
                ->where("status","pending")->count(),
            "count_employees_late_entry_current_day" => Attendance::query()
                ->whereYear("created_at",now()->year)
                ->whereDay("created_at",now()->day)
                ->where("late_entry_per_minute",">","0")->count(),
            "leaves_approve_by_last_5_month" => $this->countLeavesProcessMonth("approve"),//array[month] = count..
            "leaves_pending_by_last_5_month" => $this->countLeavesProcessMonth("pending"),//array[month] = count..
            "overtimes_approve_by_last_5_month" => $this->countEmployeeRequestOverTimeInMonth("approve"),//array[month] = count..
            "overtimes_pending_by_last_5_month" => $this->countEmployeeRequestOverTimeInMonth("pending"),//array[month] = count..
        ];
    }

    private function countEmployeeRequestOverTimeInMonth($type){
        $data = Overtime::query()
            ->select(DB::raw("count(*) as count"),DB::raw("month(created_at) as month"))
            ->whereYear("created_at",now()->year)
            ->where("status",$type)
            ->groupBy(DB::raw("month"))
            ->orderBy("month","desc")
            ->take(5)
            ->pluck("count","month");
        return $this->convertNumMonthToWord($data);
    }

    private function countLeavesProcessMonth($type){
        $data = Leave::query()
            ->select(DB::raw("count(*) as count"),DB::raw("month(created_at) as month"))
            ->whereYear("created_at",now()->year)
            ->where("status",$type)
            ->groupBy(DB::raw("month"))
            ->orderBy("month","desc")
            ->take(5)
            ->pluck("count","month");
        return $this->convertNumMonthToWord($data);
    }

    private function convertNumMonthToWord($data){
        foreach ($data->keys() as $key){
            $temp = date("F",mktime(0,0,0,$key,1));
            $data[$temp] = $data[$key];
            unset($data[$key]);
        }
        return $data->toArray();
    }

    //Employee
    private function countLeavesInLast5Month(){
        $data = Leave::query()
            ->select(DB::raw("count(*) as count"),DB::raw("month(created_at) as month"))
            ->whereYear("created_at",now()->year)
            ->where("status","approve")
            ->where("employee_id",$this->employee_id)
            ->groupBy(DB::raw("month"))
            ->orderBy("month","desc")
            ->take(5)
            ->pluck("count","month");
        return $this->convertNumMonthToWord($data);
    }

    private function evaluationAvgInMonthCurrent(){
        $query = "avg(performance) as performance , avg(professionalism) as professionalism,
            avg(readiness_for_development) as readiness_for_development, avg(collaboration) as collaboration,
            avg(commitment_and_responsibility) as commitment_and_responsibility,
            avg(innovation_and_creativity) as innovation_and_creativity
            ,avg(technical_skills) as technical_skills,
            avg(performance + professionalism + readiness_for_development + collaboration +
            commitment_and_responsibility + innovation_and_creativity + technical_skills) / 7 as total_avg";
        return EvaluationMember::query()
            ->select(DB::raw($query))
            ->whereHas("evaluation" ,function ($q){
                return $q->where("employee_id" , $this->employee_id);
            })
            ->whereYear("created_at",now()->year)
            ->whereMonth("created_at",now()->month)
            ->first() ?? null;
    }

    private function countHoursOverTimeInMonthCurrent(){
        $hoursOnly = Overtime::query()
            ->select(DB::raw("sum( count_hours_in_days * count_days ) as hours_all"))
            ->whereYear("created_at",now()->year)
            ->whereMonth("created_at",now()->month)
            ->where("employee_id",$this->employee_id)
            ->where("is_hourly","1")
            ->first()->hours_all ?? 0;
        $daysOnly = Overtime::query()
                ->whereYear("created_at",now()->year)
                ->whereMonth("created_at",now()->month)
                ->where("employee_id",$this->employee_id)
                ->where("is_hourly","0")
                ->sum("count_days") ?? 0;
        $count_hours_work_in_days = $this->employee->work_setting->count_hours_work_in_days ?? 0;
        $hoursDays = $daysOnly * $count_hours_work_in_days;
        return $hoursOnly + $hoursDays;

    }

    private function countAttendanceCheckInInMonthCurrent(){
        return Attendance::query()
            ->whereYear("created_at",now()->year)
            ->whereMonth("created_at",now()->month)
            ->where("employee_id",$this->employee_id)
            ->whereNotNull("check_in")->count() ?? 0;
    }

}
/*
الراتب
الاجازات
التقيمات تبعو
عدد ساعات العمل الاضافي يلي محققها لهاد الشهر
عدد ايام حضورو بهل الشهر او الساعات ما بتفرق
*/
