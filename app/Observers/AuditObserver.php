<?php

namespace App\Observers;

use App\HelpersClasses\Permissions;
use App\Notifications\MainNotification;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Support\Facades\Notification;

class AuditObserver
{
    /**
     * Handle the Audit "created" event.
     *
     * @param Audit $audit
     * @return void
     */
    public function created(Audit $audit)
    {
        $auditData = $audit->toArray();
        $user = auth()->user();
        $tableName = app($auditData["auditable_type"])->getTable();
        if (!is_null($user)){
            $Data = [
                "audit_id" => $auditData['id'],
                "model_id" => $auditData['auditable_id'],
                "model_type" => $auditData["auditable_type"],
                "table_name" => $tableName,
                "user_id" => $user->id,
                "user_name" => $user->name,
                "event" => $auditData['event'],
                "old_values" => $auditData['old_values'],
                "new_values" => $auditData['new_values'],
                "date" => now(),
                "route_name" => route("audit.show.single",$auditData['id']),
            ];
            $users = Permissions::getUsersForPermission("all_".$tableName);
            Notification::send($users,new MainNotification($Data,"audit"));
        }
    }

}
