<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\HelpersClasses\MyApp;
use App\Http\Requests\OvertimeRequest;
use App\Models\Leave;
use App\Models\Overtime;
use App\Models\OvertimeType;
use App\Services\OverTimeCheckService;
use App\Services\SendNotificationRequestOverTime;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OvertimeController extends Controller
{
    public const NameBlade = "System/Pages/Actors/Overtime/myRequestOvertime";
    public const IndexRoute = "system.overtimes.all.status";

    public function ShowOvertimes(Request $request, string $status = "pending"){
        $overtimesType = OvertimeType::query()->pluck("name","id")->toArray();
        $statusOvertimes = Leave::status();
        $user = auth()->user()->employee;
        if (is_null($user)){
            throw new MainException("the user is not Employee...");
        }
        $query = match ($status) {
            "approve" => $user->overtimes(),
            "reject" => $user->overtimes_reject(),
            "pending" => $user->overtimes_pending(),
        };
        if (isset($request->filter["start_date_filter"]) && !is_null($request->filter["start_date_filter"])
            && isset($request->filter["end_date_filter"]) && !is_null($request->filter["end_date_filter"]) ){
            $fromDate = MyApp::Classes()->stringProcess->DateFormat($request->filter["start_date_filter"]);
            $toDate = MyApp::Classes()->stringProcess->DateFormat($request->filter["end_date_filter"]);
            if ( is_string($fromDate) && is_string($toDate) && ($fromDate <= $toDate) ){
                $query = $query->where(function ($query) use ($fromDate,$toDate){
                    $query->whereBetween('from_date', [$fromDate, $toDate])
                        ->orWhereBetween('to_date', [$fromDate, $toDate])
                        ->orWhere(function ($query) use ($fromDate, $toDate) {
                            $query->where('from_date', '<', $fromDate)
                                ->where('to_date', '>', $toDate);
                        });
                });
            }
        }
        if (isset($request->filter["overtime_type"]) && !is_null($request->filter["overtime_type"])){
            $query = $query->where("overtime_type_id",$request->filter["overtime_type"]);
        }
        $data = MyApp::Classes()->Search->dataPaginate($query);
        return $this->responseSuccess(self::NameBlade ,
            compact("data","overtimesType","statusOvertimes","status"));
    }

    public function createRequestOvertime(){
        $overtimesType = OvertimeType::query()->pluck("name","id")->toArray();
        return $this->responseSuccess("System/Pages/Actors/Overtime/OvertimeForm" ,
            compact("overtimesType"));
    }

    public function Store(OvertimeRequest $request,OverTimeCheckService $checkService,SendNotificationRequestOverTime $notificationRequestOverTime)
    {
        $employee = auth()->user()->employee;
        if (is_null($employee)){
            throw new MainException("the user is not Employee...");
        }
        $overtimeType = OvertimeType::query()->find($request->overtime_type_id);
        $data = $checkService->MainCheckCanOvertime($employee,$overtimeType,$request);
        $overtime = Overtime::create([
            "employee_id" => $employee->id,
            "overtime_type_id" => $overtimeType->id,
            "from_date" => $data->fromDate,
            "to_date" => $data->toDate,
            "count_days" => $data->countDays,
            "from_time" => $data->fromTime,
            "to_time" => $data->toTime,
            "count_hours_in_days" => $data->count_hours_in_days,
            "is_hourly" => $request->is_hourly,
            "description" => $request->description,
        ]);
        $notificationRequestOverTime->sendNotify($employee,$overtimeType,route("system.overtimes.show.overtime",$overtime->id));
        return $this->responseSuccess(null,null,"create",self::IndexRoute);
    }

    public function Show(Overtime $overtime){
        if (!$overtime->canShow()){
            throw new AuthorizationException(__("err_permission"));
        }
        $overtime = Overtime::with(["overtime_type","employee"])->findOrFail($overtime->id);
        return $this->responseSuccess("System/Pages/Actors/Overtime/OvertimeDetails" ,
            compact("overtime"));
    }

    public function Edit(Overtime $overtime){
        if (!$overtime->canEdit()){
            throw new AuthorizationException(__("err_permission"));
        }
        $overtime = Overtime::with(["overtime_type","employee"])->findOrFail($overtime->id);
        $overtimesType = OvertimeType::query()->pluck("name","id")->toArray();
        return $this->responseSuccess("System/Pages/Actors/Overtime/OvertimeForm" ,
            compact("overtime","overtimesType"));
    }

    public function updateRequestOvertime(OvertimeRequest $request,Overtime $overtime,OverTimeCheckService $checkService,SendNotificationRequestOverTime $notificationRequestOverTime){
        if (!$overtime->canEdit()){
            throw new AuthorizationException(__("err_permission"));
        }
        $employee = auth()->user()->employee;
        $overtimeType = OvertimeType::query()->find($request->overtime_type_id);
        $data = $checkService->MainCheckCanOvertime($employee,$overtimeType,$request);
        $overtime->update([
            "employee_id" => $employee->id,
            "overtime_type_id" => $overtimeType->id,
            "from_date" => $data->fromDate,
            "to_date" => $data->toDate,
            "count_days" => $data->countDays,
            "from_time" => $data->fromTime,
            "to_time" => $data->toTime,
            "count_hours_in_days" => $data->count_hours_in_days,
            "is_hourly" => $request->is_hourly,
            "description" => $request->description,
        ]);
        $notificationRequestOverTime->sendNotify($employee,$overtimeType,route("system.overtimes.show.overtime",$overtime->id));
        return $this->responseSuccess(null,null,"update",self::IndexRoute);
    }

    public function Destroy(Overtime $overtime){
        if (!$overtime->canDelete()){
            throw new AuthorizationException(__("err_permission"));
        }
        $overtime->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function MultiDestroy(Request $request){
        $request->validate([
            "ids" => ["array","required"],
            "ids.*" => ["required",Rule::exists("overtimes","id")],
        ]);
        $employee = auth()->user()->employee;
        if (is_null($employee)){
            throw new MainException("the user is not Employee...");
        }
        Overtime::query()->where("employee_id",$employee->id)
            ->where("status","pending")
            ->whereIn("id",$request->ids)
            ->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }
}
