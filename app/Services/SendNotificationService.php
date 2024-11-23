<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\User;
use App\Notifications\MainNotification;
use Illuminate\Support\Facades\Notification;

class SendNotificationService
{
    /**
     * @param array $usersId
     * @param string $typeNotify
     * @param string $message
     * @param $route
     * @param Employee|null $employee
     * @author moner khalil
     */
    public function sendNotify(array $usersId, string $typeNotify, string $message, $route, ?Employee $employee = null){
        $data = [
            "from" => auth()->user()->name,
            "body" => $message,
            "date" => now(),
            "route_name" => $route,
        ];
        if (!is_null($employee)){
            $data["employee_name"] = $employee->first_name . "-" . $employee->last_name;
        }
        $users = User::query()->whereIn("id",$usersId)->get();
        Notification::send($users,new MainNotification($data,$typeNotify));
    }
}
