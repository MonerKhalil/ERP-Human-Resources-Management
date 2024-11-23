<?php

namespace App\Http\Controllers;

use App\Exports\TableCustomExport;
use App\HelpersClasses\ExportPDF;
use App\HelpersClasses\MyApp;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\OverTimeAdminRequest;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Overtime;
use App\Models\OvertimeType;
use App\Models\User;
use App\Notifications\MainNotification;
use App\Services\OverTimeCheckService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class OverTimeAdminController extends Controller
{
    public const NameBlade = "System/Pages/Actors/Overtime/allOvertimeView";
    public const IndexRoute = "system.overtimes_admin.index";

    public function __construct()
    {
        $table = app(Overtime::class)->getTable();
        $this->addMiddlewarePermissionsToFunctions($table);
        $this->middleware(["permission:update_".$table."|all_".$table])->only(["changeStatus"]);
    }

    private function MainQuery($request){
        $data = Overtime::with(["overtime_type","employee"]);
        //search name employee
        if (isset($request->filter["name_employee"]) && !is_null($request->filter["name_employee"])){
            $data = $data->whereHas("employee",function ($q) use ($request){
                $q->where("first_name","Like","%".$request->filter["name_employee"])
                    ->orWhere("last_name","Like","%".$request->filter["name_employee"]);
            });
        }
        if (isset($request->filter["start_date_filter"]) && !is_null($request->filter["start_date_filter"])
            && isset($request->filter["end_date_filter"]) && !is_null($request->filter["end_date_filter"])){
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
        if (isset($request->filter["overtime_type"]) && !is_null($request->filter["overtime_type"])){
            $data = $data->where("overtime_type_id",$request->filter["overtime_type"]);
        }
        return $data;
    }

    public function index(Request $request){
        $status = Leave::status();
        $overtimes = OvertimeType::query()->pluck("name","id")->toArray();
        $data = MyApp::Classes()->Search->dataPaginate($this->MainQuery($request));
        return $this->responseSuccess(self::NameBlade ,
            compact("data","status","overtimes"));
    }

    /**
     * @param Request $request
     * @param $status
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|null
     * @author moner khalil
     */
    public function changeStatus(Request $request, $status){
        $request->validate([
            "ids" => ["required","array"],
            "ids.*" => ["required",Rule::exists("overtimes","id")],
            "reject_details" => ["nullable","string"],
        ]);
        foreach ($request->ids as $overtime){
            $overtime = Overtime::query()->find($overtime);
            if (is_null($overtime->date_update_status)){
                $overtime->update([
                    "status" => $status,
                    "reject_details" => $request->reject_details,
                    "date_update_status" => now(),
                ]);
                $message = $status == "approve" ? "accept_request_overtime" : "cancel_request_overtime";
                $user = User::query()->find($overtime->employee->user_id);
                $user->notify(new MainNotification([
                    "from" => auth()->user()->name,
                    "body" => $message,
                    "date" => now(),
                    "route_name" => route("system.overtimes.show.overtime",$overtime->id),
                ],"request_overtime"));
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
        $overtimesType = OvertimeType::query()->pluck("name","id")->toArray();
        $employees = Employee::query()->select(["id","first_name","last_name"])->get();
        return $this->responseSuccess("System/Pages/Actors/Overtime/OvertimeForm" ,
            compact("employees","overtimesType"));
    }

    public function store(OverTimeAdminRequest $request,OverTimeCheckService $checkService){
        $employee = Employee::find($request->employee_id);
        $overtimeType = OvertimeType::query()->find($request->overtime_type_id);
        $data = $checkService->MainCheckCanOvertime($employee,$overtimeType,$request);
        Overtime::create([
            "employee_id" => $employee->id,
            "overtime_type_id" => $overtimeType->id,
            "from_date" => $data->fromDate,
            "to_date" => $data->toDate,
            "count_days" => $data->countDays,
            "from_time" => $data->fromTime,
            "to_time" => $data->toTime,
            "count_hours_in_days" => $data->count_hours_in_days,
            "is_hourly" => $request->is_hourly,
            "status" => "approve",
            "date_update_status" => now(),
            "description" => $request->description,
        ]);
        return $this->responseSuccess(null,null,"create",self::IndexRoute);
    }

    public function update(OverTimeAdminRequest $request , Overtime $overtime , OverTimeCheckService $checkService){
        $employee = Employee::find($overtime->employee_id);
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
            "status" => "approve",
            "date_update_status" => now(),
            "description" => $request->description,
        ]);
        return $this->responseSuccess(null,null,"update",self::IndexRoute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function destroy(Overtime $overtime)
    {
        $overtime->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function MultiDelete(Request $request)
    {
        $request->validate([
            "ids" => ["array","required"],
            "ids.*" => ["required",Rule::exists("overtimes","id")],
        ]);
        Overtime::query()->whereIn("id",$request->ids)->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function ExportXls(BaseRequest $request)
    {
        $data = $this->MainExportData($request);
        return Excel::download(new TableCustomExport($data['head'],$data['body']),"overtimes.xlsx");
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
            "ids.*" => ["sometimes",Rule::exists("overtimes","id")],
        ]);
        $query = $this->MainQuery($request);
        $query = isset($request->ids) ? $query->whereIn("id",$request->ids) : $query;
        $data = MyApp::Classes()->Search->getDataFilter($query,null,true);
        $head = [
            [
                "head"=> "overtime_type",
                "relationFunc" => "overtime_type",
                "key" => "name",
            ],
            [
                "head"=> "employee",
                "relationFunc" => "employee",
                "key" => "name",
            ]
            ,"from_date","to_date","count_days"
            ,"from_time","to_time","count_hours_in_days","is_hourly",
            "description","status","reject_details","date_update_status",
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }

}
