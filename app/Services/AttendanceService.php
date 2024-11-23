<?php

namespace App\Services;

use App\Exceptions\MainException;
use App\Models\Attendance;
use Illuminate\Support\Carbon;

class AttendanceService
{
    private $user ,$attendance;

    public function __construct()
    {
        $this->user = auth()->user()->employee;
        $this->attendance = Attendance::with("employee")
            ->where("employee_id",$this->user->id)
            ->whereDate("created_at",now()->toDateString())
            ->first();
    }

    public function checkIn(){

        $now = date('H:i:s');

        $cIn = Carbon::createFromFormat('H:s:i', $now);

        $workSettingEmployee = $this->user->work_setting;

        $work_hours_from = $workSettingEmployee->work_hours_from;
        $work_hours_from = Carbon::createFromFormat('H:s:i', $work_hours_from);
        $late_entry_per_minute = $cIn->greaterThan($work_hours_from) ? $cIn->diffInMinutes($work_hours_from) : 0 ;

        if (is_null($this->attendance)){
            $attendance = Attendance::create([
                "employee_id" => $this->user->id,
                "check_in" => $now,
                "late_entry_per_minute" => $late_entry_per_minute,

            ]);
        }else{
            $attendance = $this->attendance;
            if (is_null($attendance->check_in) && is_null($attendance->check_out)){
                $attendance->update([
                    "check_in" => $now,
                    "late_entry_per_minute" => $late_entry_per_minute,
                ]);
            }
        }
        return [
            "attendance" => $attendance,
            "type" => "check_in",
        ];
    }

    public function checkOut(){
        if (is_null($this->attendance)){
            Attendance::create([
                "employee_id" => $this->user->id,
            ]);
            throw new MainException(__("err_check_in_attendance"));
        }else{
            $attendance = $this->attendance;
            if (is_null($attendance->check_in)){
                throw new MainException(__("err_check_in_attendance"));
            }
            if (is_null($attendance->check_out)){
                $checkOut = now();
                $cIn = Carbon::createFromFormat('H:s:i', $attendance->check_in);
                $cOut = Carbon::createFromFormat('Y-m-d H:s:i', $checkOut);
                $workHours = $cOut->diffInHours($cIn);
                $workMinute = $workHours * 60;

                $workSettingEmployee = $this->user->work_setting;

                $work_hours_from = $workSettingEmployee->work_hours_from;
                $work_hours_from = Carbon::createFromFormat('H:s:i', $work_hours_from);
                $late_entry_per_minute = $cIn->greaterThan($work_hours_from) ? $cIn->diffInMinutes($work_hours_from) : 0 ;

                $work_hours_to = $workSettingEmployee->work_hours_to;
                $work_hours_to = Carbon::createFromFormat('H:s:i', $work_hours_to);
                $early_exit_per_minute = $cOut->lessThan($work_hours_to) ? $cOut->diffInMinutes($work_hours_to) : 0 ;

                $attendance->update([
                    "check_out" => $checkOut,
                    "hours_work" => $workHours,
                    "hours_work_per_minute" => $workMinute,
                    "late_entry_per_minute" => $late_entry_per_minute,
                    "early_exit_per_minute" => $early_exit_per_minute,
                ]);
            }
        }
        return [
            "attendance" => $attendance,
            "type" => "check_out",
        ];
    }
}
