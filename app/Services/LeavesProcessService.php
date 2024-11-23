<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\PublicHoliday;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LeavesProcessService
{
    /**
     * @param $request
     * @param Employee $employee
     * @param LeaveType $leaveType
     * @return string|FinalDataStore
     * @author moner khaill
     */
    public function checkAllProcess($request , Employee $employee,
                    LeaveType $leaveType,$ignoreLeaveEditId = null):string|FinalDataStore{
        if (!$this->checkGender($employee,$leaveType)){
            return __("err_leaves_gender");
        }
        if ($leaveType->leave_limited){
            if ($leaveType->is_hourly){
                $Final = $this->checkCanTakeLeaveAndIsHours($request,$employee,$leaveType,$ignoreLeaveEditId);
            }else{
                $Final = $this->checkCanTakeLeave($request,$employee,$leaveType,$ignoreLeaveEditId);
            }
        }
        else{
            $Final = $this->CheckCanIsNotLimited($request,$employee,$leaveType,$ignoreLeaveEditId);
        }
        return $Final;
    }

    private function CheckCanIsNotLimited($request , Employee $employee, LeaveType $leaveType,$ignoreLeaveEditId = null){
        $from = Carbon::parse($request->from_date)->format("Y-m-d");
        $to = Carbon::parse($request->to_date)->format("Y-m-d");
        $count_days = $this->ignorePublicHolidayAndDaysOffEmployee($from,$to,$employee->work_setting->days_leaves_in_weeks);
        $leavesCaninService = $leaveType->count_available_in_service;
        if (!is_null($leavesCaninService)){
            $count_use_leaveType = $employee->leaves()->where("leave_type_id",$leaveType->id)
                ->whereYear("created_at","=",date('Y'))
                ->whereNot("id",$ignoreLeaveEditId)->count();
            if ($leavesCaninService <= $count_use_leaveType){
                return __("err_leaves_count");
            }
        }
        return new FinalDataStore($request->from_date,$request->to_date,$count_days);
    }

    private function checkCanTakeLeave($request , Employee $employee, LeaveType $leaveType,$ignoreLeaveEditId = null){
        //Check Years Services Employee
        $years_services_employee = intval($employee->count_month_services / 12);
        if ( !is_null($leaveType->years_employee_services) && ( $leaveType->years_employee_services > $years_services_employee )){
            return __("err_years_employee_services");
        }

        //leave
        $leavesCaninYears = $leaveType->max_days_per_years;
        $from = Carbon::parse($request->from_date)->format("Y-m-d");
        $to = Carbon::parse($request->to_date)->format("Y-m-d");
//        $count_days = Carbon::createFromFormat("Y-m-d",$to)->diffInDays($from);
        $count_days = $this->ignorePublicHolidayAndDaysOffEmployee($from,$to,$employee->work_setting->days_leaves_in_weeks);


        $number_leaves_for_type = $employee->leaves()->where("leave_type_id",$leaveType->id)
            ->whereYear("created_at","=",date('Y'))
            ->whereNot("id",$ignoreLeaveEditId);

        if ( !is_null($leaveType->number_years_services_increment_days) && !is_null($leaveType->count_days_increment_days) ){
            if ($leaveType->number_years_services_increment_days <= $years_services_employee){
                $leavesCaninYears += $leaveType->count_days_increment_days;
            }
        }
        if (!is_null($request->can_from_hour) && !is_null($request->can_to_hour) && $leaveType->can_take_hours){
            $fromH = Carbon::parse($request->can_from_hour)->format("H:i:s");
            $toH = Carbon::parse($request->can_to_hour)->format("H:i:s");
            //minutes in Day
            $count_minutes = Carbon::createFromFormat("H:i:s",$toH)->diffInMinutes($fromH);
            //minutes in all Days
            $all_count_minutes = $count_minutes * $count_days;
            $days = $number_leaves_for_type->sum("count_days");
            $allMinutes = $number_leaves_for_type->sum("minutes");
            $allMinutes *= $days;
            $allMinutes += $all_count_minutes;
            $allHours = floor($allMinutes / 60);
            $hours_work_in_days_employee = $employee->work_setting->count_hours_work_in_days;
            $final = floor($allHours / $hours_work_in_days_employee);
            $ObjectReturn = new FinalDataStore($request->from_date,$request->to_date,$count_days,$count_minutes,$fromH,$toH);
        }else{
            if ($count_days > $leavesCaninYears){
                return __("err_leaves_count");
            }
            $allDays = $number_leaves_for_type->sum("count_days");
            $final = $count_days + $allDays;
            $ObjectReturn = new FinalDataStore($request->from_date,$request->to_date,$count_days);
        }

        if ( $final > $leavesCaninYears ){
            return __("err_leaves_count");
        }

        $leavesCaninService = $leaveType->count_available_in_service;
        if (!is_null($leavesCaninService)){
            $count_use_leaveType = $number_leaves_for_type->count();
            if ($leavesCaninService <= $count_use_leaveType){
                return __("err_leaves_count");
            }
        }

        return $ObjectReturn;
    }

    private function checkCanTakeLeaveAndIsHours($request ,Employee $employee,LeaveType $leaveType, $ignoreLeaveEditId = null){
        $mainQuery = $employee->leaves()->where("leave_type_id",$leaveType->id)
            ->whereYear("created_at","=",date('Y'))
            ->whereNot("id",$ignoreLeaveEditId);
        //Check Years Services Employee
        $years_services_employee = intval($employee->count_month_services / 12);
        if ( !is_null($leaveType->years_employee_services) && ( $leaveType->years_employee_services > $years_services_employee )){
            return __("err_years_employee_services");
        }
        $leavesCaninService = $leaveType->count_available_in_service;
        if (!is_null($leavesCaninService)){
            $count_use_leaveType = $mainQuery->count();
            if ($leavesCaninService <= $count_use_leaveType){
                return __("err_leaves_count");
            }
        }

        //leaveType
        $max_minutes_per_day = $leaveType->max_hours_per_day * 60;
        $max_days_per_years = $leaveType->max_days_per_years;
        $max_minutes_per_years = $max_days_per_years * $max_minutes_per_day;

        //Request
        $from = Carbon::parse($request->from_date)->format("Y-m-d");
        $to = Carbon::parse($request->to_date)->format("Y-m-d");
        $count_days = $this->ignorePublicHolidayAndDaysOffEmployee($from,$to,$employee->work_setting->days_leaves_in_weeks);
        $h_from = Carbon::parse($request->from_hour)->format("H:i:s");
        $h_to = Carbon::parse($request->to_hour)->format("H:i:s");
        $count_minute_in_days = Carbon::createFromFormat("H:i:s",$h_to)->diffInMinutes($h_from);
        $allMinutes = $count_minute_in_days * $count_days;

        //Check1 for days
        if ($count_minute_in_days > $max_minutes_per_day){
            return __("err_leaves_count");
        }
        //Check2 for years
        if ($allMinutes > $max_minutes_per_years){
            return __("err_leaves_count");
        }
        //Check3 for years all minutes leaves approve
        $allMinutes_leaves_for_type = $mainQuery
            ->sum(DB::raw("leaves.count_days * leaves.minutes"));

        if (($allMinutes + $allMinutes_leaves_for_type) > $max_minutes_per_years){
            return __("err_leaves_count");
        }

        return new FinalDataStore($request->from_date,$request->to_date,$count_days,$count_minute_in_days,$h_from,$h_to);
    }

    private function checkGender(Employee $employee,LeaveType $leaveType){
        if ($leaveType->gender != "any"){
            return $employee->gender == $leaveType->gender;
        }
        return true;
    }

    private function ignorePublicHolidayAndDaysOffEmployee($fromDate , $toDate,$daysOffEmployee){
        $Holidays = PublicHoliday::query()->where(function ($query) use ($fromDate,$toDate){
            $query->whereBetween('start_date', [$fromDate, $toDate])
                ->orWhereBetween('end_date', [$fromDate, $toDate])
                ->orWhere(function ($query) use ($fromDate, $toDate) {
                    $query->where('start_date', '<', $fromDate)
                        ->where('end_date', '>', $toDate);
                });
        })->get();
        $nonOverlappingDates = [];
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
                $nonOverlappingDates[] = $date->format('Y-m-d');
            }
        }

        $daysOffEmployee = explode(",",$daysOffEmployee);

        //final Count Days Leaves
        $countDaysLeaves = 0;
        foreach ($nonOverlappingDates as $date){
            $date = date("l",strtotime($date));
            if (!in_array($date,$daysOffEmployee)){
                $countDaysLeaves++;
            }
        }
        return $countDaysLeaves;

    }
}

class FinalDataStore{
    public $fromDate,$toDate,$countDays,$MinutesInDays;
    public $fromTime,$toTime;
    public function __construct($fromDate,$toDate,$countDays,$MinutesInDays = null,$fromTime=null,$toTime=null)
    {
        $this->toDate = $toDate;
        $this->fromDate = $fromDate;
        $this->countDays = $countDays;
        $this->MinutesInDays =$MinutesInDays;
        $this->fromTime = $fromTime;
        $this->toTime = $toTime;
    }
}
