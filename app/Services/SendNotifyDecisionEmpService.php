<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\User;
use App\Notifications\MainNotification;
use Illuminate\Support\Facades\Notification;

class SendNotifyDecisionEmpService
{
    public function SendNotify(array $employees_ids,$decision){
        $users = Employee::query()->whereIn("id",$employees_ids)->pluck("user_id")->toArray();
        $users = User::query()->whereIn("id",$users)->get();
        $data = [
            "from" => auth()->user()->name,
            "body" => "decision_employee_message",
            "date" => now(),
            "route_name" => route("system.decisions.show",$decision->id),
        ];
        Notification::send($users,new MainNotification($data,"decision"));
    }
}
