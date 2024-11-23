<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\User;
use App\Notifications\MainNotification;
use Illuminate\Support\Facades\Notification;

class SendNotificationRequestLeave
{
    public function sendNotify(Employee $employee,LeaveType $leaveType ,$route){
        $moderator_id = $employee->section->moderator_id;
        $message = "request_leave_msg" . "@@@@" . $leaveType->name;
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
            $query->where('name', "all_leaves");
        })->orWhere("id",$moderator_id)->get();
        Notification::send($users,new MainNotification($data,"request_leave"));
    }
}
