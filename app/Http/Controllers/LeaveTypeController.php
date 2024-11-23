<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\Exports\TableCustomExport;
use App\HelpersClasses\ExportPDF;
use App\HelpersClasses\MyApp;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\LeaveTypeRequest;
use App\Models\Leave;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;


class LeaveTypeController extends Controller
{
    public const NameBlade = "System/Pages/Actors/Vacations/vacationTypesView";
    public const IndexRoute = "system.leave_types.index";

    public function __construct()
    {
        $this->addMiddlewarePermissionsToFunctions(app(LeaveType::class)->getTable());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $gender = LeaveType::gender();
        $type_effect_salary = LeaveType::type_effect_salary();
        $data = MyApp::Classes()->Search->getDataFilter(LeaveType::query());
        return $this->responseSuccess(self::NameBlade
            ,compact("data","type_effect_salary","gender"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gender = LeaveType::gender();
        $type_effect_salary = LeaveType::type_effect_salary();
        return $this->responseSuccess("System/Pages/Actors/Vacations/newTypeForm"
            ,compact("gender","type_effect_salary"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeaveTypeRequest $request)
    {
        LeaveType::create($request->validated());
        return $this->responseSuccess(null,null,"create",self::IndexRoute);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveType $leaveType)
    {
        return $this->responseSuccess("System/Pages/Actors/Vacations/vacationTypeDetails"
            ,compact("leaveType"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveType $leaveType)
    {
        $gender = LeaveType::gender();
        $type_effect_salary = LeaveType::type_effect_salary();
        return $this->responseSuccess("System/Pages/Actors/Vacations/newTypeForm"
            ,compact("leaveType","gender","type_effect_salary"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function update(LeaveTypeRequest $request, LeaveType $leaveType)
    {
        if ($request->type_effect_salary !=="effect_salary"){
            $effect_salary = 0;
        }else{
            $effect_salary = $request->rate_effect_salary;
        }
        if ($request->is_hourly != "true" && $request->is_hourly != 1){
            $max_hours_per_day = 0;
        }
        else{
            $max_hours_per_day = is_null($request->max_hours_per_day) ? $leaveType->max_hours_per_day : $request->max_hours_per_day;
        }
        if ($request->leave_limited != "true" && $request->leave_limited != 1){
            $max_hours_per_day = 0;
            $max_days_per_years = 0;
        }else{
            $max_days_per_years = is_null($request->max_days_per_years) ? $leaveType->max_days_per_years : $request->max_days_per_years;
        }
        if ($request->number_years_services_increment_days!==null){
            $count_days_increment_days = $request->count_days_increment_days;
        }else{
            $count_days_increment_days = 0;
        }
        $leaveType->update([
            "name" => is_null($request->name) ? $leaveType->name : $request->name,
            "type_effect_salary" => $request->type_effect_salary,
            "rate_effect_salary" => $effect_salary,
            "gender" => $request->gender,
            "is_hourly" => $request->is_hourly,
            "leave_limited" => $request->leave_limited,
            "max_hours_per_day" => $max_hours_per_day,
            "max_days_per_years" => $max_days_per_years,
            "years_employee_services" => $request->years_employee_services,
            "number_years_services_increment_days" => $request->number_years_services_increment_days,
            "count_days_increment_days" => $count_days_increment_days,
            "count_available_in_service" => $request->count_available_in_service,
            "can_take_hours" => $request->can_take_hours,
        ]);
        return $this->responseSuccess(null,null,"update",self::IndexRoute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeaveType $leaveType)
    {
        if (!is_null($leaveType->leaves()->first())){
            throw new MainException(__("err_delete_exist_type_in_requests"));
        }
        $leaveType->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function MultiDelete(Request $request)
    {
        $request->validate([
            "ids" => ["array","required"],
            "ids.*" => ["required",Rule::exists("leave_types","id")],
        ]);
        try {
            DB::beginTransaction();
            foreach ($request->ids as $id){
                $leaveType = LeaveType::query()->find($id);
                if (!is_null($leaveType->leaves()->first())){
                    throw new MainException(__("err_delete_exist_type_in_requests"));
                }
                $leaveType->delete();
            }
            DB::commit();
            return $this->responseSuccess(null,null,"delete",self::IndexRoute);
        }catch (\Exception $exception){
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }

    public function ExportXls(BaseRequest $request)
    {
        $data = $this->MainExportData($request);
        return Excel::download(new TableCustomExport($data['head'],$data['body']),"conference.xlsx");
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
            "ids.*" => ["sometimes",Rule::exists("leave_types","id")],
        ]);
        $query = LeaveType::query();
        $query = isset($request->ids) ? $query->whereIn("id",$request->ids) : $query;
        $data = MyApp::Classes()->Search->getDataFilter($query,null,true);
        $head = [
            "name","type_effect_salary","rate_effect_salary",
            "max_days_per_years", "max_days_per_month","years_employee_services",
            "gender","leave_limited","can_hours",
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }
}
