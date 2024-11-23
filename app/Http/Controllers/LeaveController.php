<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\HelpersClasses\MyApp;
use App\Http\Requests\LeaveRequest;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Services\FinalDataStore;
use App\Services\LeavesProcessService;
use App\Services\SendNotificationRequestLeave;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LeaveController extends Controller
{
    public const NameBlade = "System/Pages/Actors/Vacations/myVacationsView";
    public const IndexRoute = "system.leaves.all.status";

    /**
     * @param Request $request
     * @param string $status
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|null
     * @throws MainException
     * @author moner khalil
     */
    public function ShowLeaves(Request $request, string $status = "pending"){
        $leavesType = LeaveType::query()->pluck("name","id")->toArray();
        $statusLeaves = Leave::status();
        $user = auth()->user()->employee;
        if (is_null($user)){
            throw new MainException("the user is not Employee...");
        }
        $query = match ($status) {
            "approve" => $user->leaves(),
            "reject" => $user->leaves_reject(),
            "pending" => $user->leaves_pending(),
        };
        if (isset($request->filter["start_date_filter"]) && !is_null($request->filter["start_date_filter"])
            &&isset($request->filter["end_date_filter"]) &&
            !is_null($request->filter["end_date_filter"]) ){
            $fromDate = MyApp::Classes()->stringProcess->DateFormat($request->filter["start_date_filter"]);
            $toDate = MyApp::Classes()->stringProcess->DateFormat($request->filter["end_date_filter"]);
            if ( is_string($fromDate) && is_string($toDate) && ($fromDate <= $toDate) ) {
                $query = $query->where(function ($query) use ($fromDate,$toDate) {
                    $query->whereBetween('from_date', [$fromDate, $toDate])
                        ->orWhereBetween('to_date', [$fromDate, $toDate])
                        ->orWhere(function ($query) use ($fromDate, $toDate) {
                            $query->where('from_date', '<', $fromDate)
                                ->where('to_date', '>', $toDate);
                        });
                });
            }
        }
        if (isset($request->filter["leave_type"]) && !is_null($request->filter["leave_type"])){
            $query = $query->where("leave_type_id",$request->filter["leave_type"]);
        }
        $data = MyApp::Classes()->Search->dataPaginate($query);
        return $this->responseSuccess(self::NameBlade ,
            compact("data","leavesType","statusLeaves" , "status"));
    }

    public function createRequestLeave(){
        $leave_types = LeaveType::query()->get();
        return $this->responseSuccess("System/Pages/Actors/Vacations/vacationRequest" ,
            compact("leave_types"));
    }

    /**
     * @param LeaveRequest $request
     * @param LeavesProcessService $service
     * @param SendNotificationRequestLeave $notificationRequestLeave
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|null
     * @throws MainException
     * @author moner khalil
     */
    public function Store(LeaveRequest $request, LeavesProcessService $service, SendNotificationRequestLeave $notificationRequestLeave){
        try {
            $employee = auth()->user()->employee;
            if (is_null($employee)){
                throw new MainException("the user is not Employee...");
            }
            $leave_type = LeaveType::find($request->leave_type_id);
            $checkCanLeave = $service->checkAllProcess($request,$employee,$leave_type);
            if ($checkCanLeave instanceof FinalDataStore){
                //Code Create Leave
                $leave = Leave::create([
                    "employee_id" => $employee->id,
                    "leave_type_id" => $leave_type->id,
                    "from_date" => $checkCanLeave->fromDate,
                    "to_date" => $checkCanLeave->toDate,
                    "from_time" => $checkCanLeave->fromTime,
                    "to_time" => $checkCanLeave->toTime,
                    "count_days" => $checkCanLeave->countDays,
                    "minutes" => $checkCanLeave->MinutesInDays,
                    "description" => $request->description,
                ]);
                $notificationRequestLeave->sendNotify($employee,$leave_type,route("system.leaves.show.leave",$leave->id));
                DB::commit();
                return $this->responseSuccess(null,null,"create",self::IndexRoute);
            }
            throw new MainException($checkCanLeave);
        }catch (\Exception $exception){
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }

    public function Show(Leave $leave){
        if (!$leave->canShow()){
            throw new AuthorizationException(__("err_permission"));
        }
        $leave = Leave::with(["leave_type","employee"])->findOrFail($leave->id);
        return $this->responseSuccess("System/Pages/Actors/Vacations/vacationsDetails" ,
            compact("leave"));
    }

    /**
     * @param Leave $leave
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|null
     * @throws AuthorizationException
     * @author moner khalil
     */

    public function Edit(Leave $leave)
    {
        if (!$leave->canEdit()) {
            throw new AuthorizationException(__("err_permission"));
        }
        $leave = Leave::with(["leave_type","employee"])->find($leave->id);
        $leave_types = LeaveType::query()->get();

        return $this->responseSuccess("System/Pages/Actors/Vacations/vacationRequest" ,
            compact("leave","leave_types"));
    }

    /**
     * @param LeaveRequest $request
     * @param Leave $leave
     * @param LeavesProcessService $service
     * @param SendNotificationRequestLeave $notificationRequestLeave
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|null
     * @throws MainException
     * @author moner khalil
     */
    public function updateRequestLeave(LeaveRequest $request, Leave $leave, LeavesProcessService $service, SendNotificationRequestLeave $notificationRequestLeave){
        if (!$leave->canEdit()){
            throw new AuthorizationException(__("err_permission"));
        }
        try {
            $employee = auth()->user()->employee;
            $leave_type = LeaveType::find($request->leave_type_id);
            $checkCanLeave = $service->checkAllProcess($request,$employee,$leave_type);
            if ($checkCanLeave instanceof FinalDataStore){
                //Code Create Leave
                $leave->update([
                    "employee_id" => $employee->id,
                    "leave_type_id" => $leave_type->id,
                    "from_date" => $checkCanLeave->fromDate,
                    "to_date" => $checkCanLeave->toDate,
                    "from_time" => $checkCanLeave->fromTime,
                    "to_time" => $checkCanLeave->toTime,
                    "count_days" => $checkCanLeave->countDays,
                    "minutes" => $checkCanLeave->MinutesInDays,
                    "description" => $request->description,
                    "status" => "pending",
                ]);
                $notificationRequestLeave->sendNotify($employee,$leave_type , route("system.leaves.show.leave",$leave->id));
                DB::commit();
                return $this->responseSuccess(null,null,"update",self::IndexRoute);
            }
            throw new MainException($checkCanLeave);
        }catch (\Exception $exception){
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }

    public function Destroy(Leave $leave)
    {
        if (!$leave->canDelete()){
            throw new AuthorizationException(__("err_permission"));
        }
        $leave->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function MultiDestroy(Request $request){
        $request->validate([
            "ids" => ["array","required"],
            "ids.*" => ["required",Rule::exists("leaves","id")],
        ]);
        $employee = auth()->user()->employee;
        if (is_null($employee)){
            throw new MainException("the user is not Employee...");
        }
        Leave::query()->where("employee_id",$employee->id)
            ->where("status","pending")
            ->whereIn("id",$request->ids)
            ->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function LeavesTypeShow() {
        $employee = auth()->user()->employee;
        $leaves_type = LeaveType::query()->get()->filter(function ($item)use($employee){
            if (!$item->leave_limited) {
                return true;
            }
            if ($item->gender != "any") {
                return $item->gender == $employee->gender;
            }
            $services = floor($employee->count_month_services/12);
            if ($services >= $item->years_employee_services){
                return true;
            }
            return false;
        });
        return $this->responseSuccess("System/Pages/Actors/Vacations/vacationAvailableView" ,
            compact("leaves_type"));
    }

    /**
     * @description get count leaves can use....
     * Ajax.....
     * @param $leave_type
     * @return \Illuminate\Http\JsonResponse
     * @throws MainException
     */

    public function CountLeavesByType($leave_type){
        try {
            $leave_type = LeaveType::query()->findOrFail($leave_type);
            $employee = auth()->user()->employee;
            if (is_null($employee)){
                throw new MainException("the user is not Employee...");
            }
            $mainQuery = $employee->leaves()
                ->where("leave_type_id",$leave_type->id)
                ->whereYear("created_at",date("Y"));
            $data = [];
            if (!$leave_type->leave_limited){
                $data = [
                    "leave_limited" => false,
                ];
            }else{
                //Days...
                $services = floor($employee->count_month_services/12);
                if (!is_null($leave_type->number_years_services_increment_days)
                    && !is_null($leave_type->count_days_increment_days)
                    && $services >= $leave_type->number_years_services_increment_days){
                    $daysLeaveType = $leave_type->max_days_per_years + $leave_type->count_days_increment_days;
                }else{
                    $daysLeaveType = $leave_type->max_days_per_years;
                }

                if ($leave_type->is_hourly){
                    $minutes = $mainQuery
                        ->sum(DB::raw("leaves.count_days * leaves.minutes"));
                    $hoursAllUsed = floor($minutes/60);
                    $hoursLeaveType = $daysLeaveType * $leave_type->max_hours_per_day;
                    $currentHours = $hoursLeaveType - $hoursAllUsed;
                    $data = [
                        "is_hourly" => true,
                        "currentLeave" => $currentHours,//the value is hours
                    ];
                }else{
                    $days = $mainQuery->sum("count_days");
                    if ($leave_type->can_take_hours){
                        $allMinutes = $mainQuery->sum("minutes");
                        $allMinutes *= $days;
                        $allHours = floor($allMinutes / 60);
                        $hours_work_in_days_employee = $employee->work_setting->count_hours_work_in_days;
                        $allDays = floor($allHours / $hours_work_in_days_employee);
                        $finalDays = $daysLeaveType - $allDays;
                    }else{
                        $finalDays = $daysLeaveType - $days;
                    }
                    $data = [
                        "is_hourly" => false,
                        "currentLeave" => $finalDays,//the value is days
                    ];
                }
            }
            if (!is_null($leave_type->count_available_in_service)){
                $countUsed = $mainQuery->count();
                $data["count_available_in_service"] = $leave_type->count_available_in_service - $countUsed;
            }
            return response()->json(["data" => $data]);
        }catch (\Exception $exception){
            return response()->json(["error" => $exception->getMessage()]);
        }
    }
}
