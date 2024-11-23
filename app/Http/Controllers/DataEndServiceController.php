<?php

namespace App\Http\Controllers;

use App\Exports\TableCustomExport;
use App\HelpersClasses\ExportPDF;
use App\HelpersClasses\MyApp;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\DataEndServiceRequest;
use App\Models\DataEndService;
use App\Models\Decision;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class DataEndServiceController extends Controller
{
    public const NameBlade = "System.Pages.Actors.HR_Manager.employeeEndOfServiceForm";
    public const Folder = "data_end_services";
    public const IndexRoute = "system.data_end_services.index";

    public function __construct()
    {
        $table = app(DataEndService::class)->getTable();
        $this->addMiddlewarePermissionsToFunctions($table);
        $this->middleware(["permission:create_".$table."|all_".$table])->only(["create","store","createFromEmployee"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $DataEnd = DataEndService::with(["employee","decision"])->whereNotNull("decision_id");
        if (isset($request->filter["name_employee"]) && !is_null($request->filter["name_employee"])){
            $DataEnd = $DataEnd->whereHas("employee",function ($q) use ($request){
                $q->where("first_name","Like","%".$request->filter["name_employee"])
                ->orWhere("last_name","Like","%".$request->filter["name_employee"]);
            });
        }
        if (isset($request->filter["number_decision"]) && !is_null($request->filter["number_decision"])){
            $DataEnd = $DataEnd->whereHas("decision",function ($q) use ($request){
                $q->where("number",$request->filter["number_decision"]);
            });
        }
        $reason = DataEndService::Reasons();
        $data = MyApp::Classes()->Search->getDataFilter($DataEnd);
        return $this->responseSuccess("System.Pages.Actors.HR_Manager.viewEmployeesEOF",compact("data",'reason'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::query()->select(["first_name","last_name","id"])->get();
//        dd($employees);
        $decision = Decision::query()->pluck("number","id")->toArray();
        $reason = DataEndService::Reasons();
        return $this->responseSuccess("System.Pages.Actors.HR_Manager.employeeEndOfServiceForm",compact("employees","reason", "decision"));
    }

    public function createFromEmployee($employee){
        $employee = Employee::query()->findOrFail($employee);
        $decisions = Decision::query()->pluck("name","id")->toArray();
        $reason = DataEndService::Reasons();
        return $this->responseSuccess("",compact("employee","reason","decisions"));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DataEndServiceRequest $request)
    {
        DataEndService::create($request->validated());
        return $this->responseSuccess(null,null,"create",self::IndexRoute);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataEndService  $dataEndService
     * @return \Illuminate\Http\Response
     */
    public function show(DataEndService $dataEndService)
    {
        $dataEndService = DataEndService::with(["employee","decision"])->findOrFail($dataEndService->id);
        return $this->responseSuccess("System.Pages.Actors.HR_Manager.viewEmployeeEOF",compact("dataEndService"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataEndService  $dataEndService
     * @return \Illuminate\Http\Response
     */
    public function edit(DataEndService $dataEndService)
    {
        $dataEndService = DataEndService::with(["employee","decision"])->findOrFail($dataEndService->id);
        $employee = Employee::query()->select(["first_name","last_name","id"])->get();
        $decision = Decision::query()->pluck("number","id")->toArray();
        $reason = DataEndService::Reasons();
        return $this->responseSuccess("System.Pages.Actors.HR_Manager.editEOF",compact("dataEndService","employee","reason", "decision"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DataEndService  $dataEndService
     * @return \Illuminate\Http\Response
     */
    public function update(DataEndServiceRequest $request, DataEndService $dataEndService)
    {
        $dataEndService->update($request->validated());
        return $this->responseSuccess(null,null,"update",self::IndexRoute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataEndService  $dataEndService
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataEndService $dataEndService)
    {
        $dataEndService->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function MultiDelete(Request $request)
    {
        $request->validate([
            "ids" => ["array","required"],
            "ids.*" => ["required",Rule::exists("data_end_services","id")],
        ]);
        DataEndService::query()->whereIn("id",$request->ids)->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function ExportXls(BaseRequest $request)
    {
        $data = $this->MainExportData($request);
        return Excel::download(new TableCustomExport($data['head'],$data['body']),"dataEndService.xlsx");
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
            "ids.*" => ["sometimes",Rule::exists("data_end_services","id")],
        ]);
        $query = DataEndService::with(["employee","decision"]);
        $query = isset($request->ids) ? $query->whereIn("id",$request->ids) : $query;
        if (isset($request->filter["name_employee"]) && !is_null($request->filter["name_employee"])){
            $query = $query->whereHas("employee",function ($q) use ($request){
                $q->where("first_name","Like","%".$request->filter["name_employee"])
                    ->orWhere("last_name","Like","%".$request->filter["name_employee"]);
            });
        }
        if (isset($request->filter["number_decision"]) && !is_null($request->filter["number_decision"])){
            $query = $query->whereHas("decision",function ($q) use ($request){
                $q->where("number",$request->filter["number_decision"]);
            });
        }
        $data = MyApp::Classes()->Search->getDataFilter($query,null,true);
        $head = [
            [
                "head"=> "employee",
                "relationFunc" => "employee",
                "key" => "name",
            ],
            [
                "head"=> "decision",
                "relationFunc" => "decision",
                "key" => "number",
            ],
            "reason","reason_other","start_break_date","end_break_date",
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }
}
