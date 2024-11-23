<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\OvertimeType;
use App\Models\User;
use App\Notifications\MainNotification;
use Illuminate\Support\Facades\Notification;

class SendNotificationRequestOverTime
{
    public function sendNotify(Employee $employee,OvertimeType $overtimeType ,$route){
        $moderator_id = $employee->section->moderator_id;
        $message = "request_overtime_msg" . "@@@@" . $overtimeType->name;
        $data = [
            "from" => $employee->name,
            "body" => $message,
            "date" => now(),
            "route_name" => $route,
        ];
        $this->sendToUsersAdminLeaves($data,$moderator_id);
    }

    private function sendToUsersAdminLeaves($data,$moderator_id){
        $users = User::query()->whereHas("roles.permissions",function ($query){
            $query->where('name', "all_overtimes");
        })->orWhere("id",$moderator_id)->get();
        Notification::send($users,new MainNotification($data,"request_overtime"));
    }
}
