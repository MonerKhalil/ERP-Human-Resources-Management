<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\Exports\TableCustomExport;
use App\HelpersClasses\ExportPDF;
use App\HelpersClasses\MyApp;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\LeaveAdminRequest;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\User;
use App\Notifications\MainNotification;
use App\Services\FinalDataStore;
use App\Services\LeavesProcessService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class LeaveAdminController extends Controller
{
    public const NameBlade = "System/Pages/Actors/Vacations/allVacationsView";
    public const IndexRoute = "system.leaves_admin.index";

    public function __construct()
    {
        $table = app(Leave::class)->getTable();
        $this->addMiddlewarePermissionsToFunctions($table);
        $this->middleware(["permission:update_".$table."|all_".$table])->only(["changeStatus"]);
    }
    private function MainQuery($request){
        $data = Leave::with(["leave_type","employee"]);
        //search name employee
        if (isset($request->filter["name_employee"]) && !is_null($request->filter["name_employee"])){
            $data = $data->whereHas("employee",function ($q) use ($request){
                $q->where("first_name","Like","%".$request->filter["name_employee"])
                    ->orWhere("last_name","Like","%".$request->filter["name_employee"]);
            });
        }
        if (isset($request->filter["start_date_filter"]) && !is_null($request->filter["start_date_filter"]) &&
            isset($request->filter["end_date_filter"]) && !is_null($request->filter["end_date_filter"])){
            $fromDate = MyApp::Classes()->stringProcess->DateFormat($request->filter["start_date_filter"]);
            $toDate = MyApp::Classes()->stringProcess->DateFormat($request->filter["end_date_filter"]);
            if ( is_string($fromDate) && is_string($toDate) && ($fromDate <= $toDate) ){
                $data = $data->where(function ($query) use ($fromDate,$toDate){
                    $query->whereBetween('from_date', [$fromDate, $toDate])
                        ->orWhereBetween('to_date', [$fromDate, $toDate])
                        ->orWhere(function ($query) use ($fromDate, $toDate) {
                            $query->where('from_date', '<', $fromDate)
                                ->where('to_date', '>', $toDate);
                        });
                });
            }
        }
        if (isset($request->filter["status"]) && !is_null($request->filter["status"])){
            $data = $data->where("status",$request->filter["status"]);
        }
        if (isset($request->filter["leave_type"]) && !is_null($request->filter["leave_type"])){
            $data = $data->where("leave_type_id",$request->filter["leave_type"]);
        }
        return $data;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $statusLeaves = Leave::status();
        $leavesType = LeaveType::query()->pluck("name","id")->toArray();
        $data = MyApp::Classes()->Search->dataPaginate($this->MainQuery($request));
        return $this->responseSuccess(self::NameBlade ,
            compact("data","statusLeaves","leavesType"));
    }

    /**
     * @param Request $request
     * @param Leave $leave
     * @param $status
     * @author moner khalil
     */

    public function changeStatus(Request $request, $status){
        $request->validate([
            "ids" => ["required","array"],
            "ids.*" => ["required",Rule::exists("leaves","id")],
            "reject_details" => ["nullable","string"],
        ]);
        foreach($request->ids as $leave) {
            $leave = Leave::query()->find($leave);
            if (is_null($leave->date_update_status)){
                $leave->update([
                    "status" => $status,
                    "reject_details" => $request->reject_details,
                    "date_update_status" => now(),
                ]);
                $message = $status == "approve" ? "accept_request_leave" : "cancel_request_leave";
                $user = User::query()->find($leave->employee->user_id);
                $user->notify(new MainNotification([
                    "from" => auth()->user()->name,
                    "body" => $message,
                    "date" => now(),
                    "route_name" => route("system.leaves.show.leave",$leave->id),
                ],"request_leave"));
            }
        }
        return $this->responseSuccess(null,null,"default",self::IndexRoute);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leave_types = LeaveType::query()->get();
        $employees = Employee::query()->select(["id","first_name","last_name"])->get();
        return $this->responseSuccess("System/Pages/Actors/Vacations/insertVacation" ,
            compact("employees","leave_types"));
    }


    /**
     * @param LeaveAdminRequest $request
     * @param LeavesProcessService $service
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|null
     * @throws MainException
     * @author moner khalil
     */
    public function store(LeaveAdminRequest $request, LeavesProcessService $service)
    {
        $employee = Employee::find($request->employee_id);
        $leave_type = LeaveType::find($request->leave_type_id);
        $checkCanLeave = $service->checkAllProcess($request,$employee,$leave_type);
        if ($checkCanLeave instanceof FinalDataStore){
            //Code Create Leave
            Leave::create([
                "employee_id" => $employee->id,
                "leave_type_id" => $leave_type->id,
                "from_date" => $checkCanLeave->fromDate,
                "to_date" => $checkCanLeave->toDate,
                "from_time" => $checkCanLeave->fromTime,
                "to_time" => $checkCanLeave->toTime,
                "count_days" => $checkCanLeave->countDays,
                "minutes" => $checkCanLeave->MinutesInDays,
                "description" => $request->description,
                "status" => "approve",
                "date_update_status" => now(),
            ]);
            return $this->responseSuccess(null,null,"create",self::IndexRoute);
        }
        throw new MainException($checkCanLeave);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Leave $leave
     * @return \Illuminate\Http\Response
     * @throws MainException
     */
    public function update(LeaveAdminRequest $request, Leave $leave, LeavesProcessService $service)
    {
        $employee = Employee::find($leave->employee_id);
        $leave_type = LeaveType::find($request->leave_type_id);
        $checkCanLeave = $service->checkAllProcess($request,$employee,$leave_type,$leave->id);
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
                "status" => "approve",
                "date_update_status" => now(),
            ]);
            return $this->responseSuccess(null,null,"update",self::IndexRoute);
        }
        throw new MainException($checkCanLeave);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave)
    {
        $leave->delete();
        return $this->responseSuccess(null,null,"create",self::IndexRoute);
    }

    public function MultiDelete(Request $request)
    {
        $request->validate([
            "ids" => ["array","required"],
            "ids.*" => ["required",Rule::exists("leaves","id")],
        ]);
        Leave::query()->whereIn("id",$request->ids)->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function ExportXls(BaseRequest $request)
    {
        $data = $this->MainExportData($request);
        return Excel::download(new TableCustomExport($data['head'],$data['body']),"leaves.xlsx");
    }

    public function ExportPDF(BaseRequest $request)
    {
        $data = $this->MainExportData($request);
        return ExportPDF::downloadPDF($data['head'],$data['body']);
    }

    /**
     * @param Request $request
     * @return array
     * @author moner khalil
     */
    private function MainExportData(Request $request): array
    {
        $request->validate([
            "ids" => ["sometimes","array"],
            "ids.*" => ["sometimes",Rule::exists("leaves","id")],
        ]);
        $query = $this->MainQuery($request);
        $query = isset($request->ids) ? $query->whereIn("id",$request->ids) : $query;
        $data = MyApp::Classes()->Search->getDataFilter($query,null,true);
        $head = [
            [
                "head"=> "leave_type",
                "relationFunc" => "leave_type",
                "key" => "name",
            ],
            [
                "head"=> "employee",
                "relationFunc" => "employee",
                "key" => "name",
            ]
            ,"from_date","to_date", "count_days",
            "count_hours","minutes",
            "description",
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }
}
