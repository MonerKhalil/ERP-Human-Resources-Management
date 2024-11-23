<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\Exports\TableCustomExport;
use App\HelpersClasses\ExportPDF;
use App\HelpersClasses\MyApp;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\WorkSettingRequest;
use App\Models\Employee;
use App\Models\WorkSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class WorkSettingController extends Controller
{
    public const NameBlade = "System/Pages/Actors/Setting/Work/workSettingView";
    public const IndexRoute = "system.work_settings.index";

    public function __construct()
    {
        $this->addMiddlewarePermissionsToFunctions(app(WorkSetting::class)->getTable());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $days = \Days();
        $data = MyApp::Classes()->Search->getDataFilter(WorkSetting::query());
        return $this->responseSuccess(self::NameBlade,compact("data","days"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $days = Days();
        return $this->responseSuccess("System/Pages/Actors/Setting/Work/workSettingForm" ,
            compact("days"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkSettingRequest $request)
    {
        $daysLeaves = $request->days;
        $h_from = Carbon::parse($request->work_hours_from)->format("H:i:s");
        $h_to = Carbon::parse($request->work_hours_to)->format("H:i:s");
        if (is_null($daysLeaves)){
            $count_days_work_in_weeks = count(Days());
        }else{
            $count_days_work_in_weeks = count(Days()) - count($daysLeaves);
        }
        $count_hours_work_in_days = Carbon::createFromFormat("H:i:s",$h_to)->diffInHours($h_from);
        $daysLeaves = implode(",",$daysLeaves);
        WorkSetting::create([
            "name" => $request->name,
            "count_hours_work_in_days" => $count_hours_work_in_days,
            "count_days_work_in_weeks" => $count_days_work_in_weeks,
            "days_leaves_in_weeks" => $daysLeaves,
            "work_hours_from" => $h_from,
            "work_hours_to" => $h_to,
            "description" => $request->description,
            "late_enter_allowance_per_minute" => $request->late_enter_allowance_per_minute,
            "early_out_allowance_per_minute" => $request->early_out_allowance_per_minute,
            "salary_default" => $request->salary_default,
            "rate_deduction_from_salary" => $request->rate_deduction_from_salary,
            "type_discount_minuteOrHour" => $request->type_discount_minuteOrHour,
            "rate_deduction_attendance_dont_check_out" => $request->rate_deduction_attendance_dont_check_out,
        ]);
        return $this->responseSuccess(null,null,"create",self::IndexRoute);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkSetting  $workSetting
     * @return \Illuminate\Http\Response
     */
    public function show(WorkSetting $workSetting)
    {
        return $this->responseSuccess("System/Pages/Actors/Setting/Work/workSettingDetails" ,
            compact("workSetting"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkSetting  $workSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkSetting $workSetting)
    {
        $days = Days();
        return $this->responseSuccess("System/Pages/Actors/Setting/Work/workSettingForm" ,
            compact("days","workSetting"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkSetting  $workSetting
     * @return \Illuminate\Http\Response
     */
    public function update(WorkSettingRequest $request, WorkSetting $workSetting)
    {
        $daysLeaves = $request->days;
        $h_from = Carbon::parse($request->work_hours_from)->format("H:i:s");
        $h_to = Carbon::parse($request->work_hours_to)->format("H:i:s");
        if (is_null($daysLeaves)){
            $count_days_work_in_weeks = count(Days());
        }else{
            $count_days_work_in_weeks = count(Days()) - count($daysLeaves);
        }
        $count_hours_work_in_days = Carbon::createFromFormat("H:i:s",$h_to)->diffInHours($h_from);
        $daysLeaves = implode(",",$daysLeaves);
        $workSetting->update([
            "name" => $request->name,
            "count_hours_work_in_days" => $count_hours_work_in_days,
            "count_days_work_in_weeks" => $count_days_work_in_weeks,
            "days_leaves_in_weeks" => $daysLeaves,
            "work_hours_from" => $h_from,
            "work_hours_to" => $h_to,
            "late_enter_allowance_per_minute" => $request->late_enter_allowance_per_minute,
            "early_out_allowance_per_minute" => $request->early_out_allowance_per_minute,
            "description" => is_null($request->description) ? $workSetting->description : $request->description,
            "salary_default" => $request->salary_default,
            "rate_deduction_from_salary" => $request->rate_deduction_from_salary,
            "type_discount_minuteOrHour" => $request->type_discount_minuteOrHour,
            "rate_deduction_attendance_dont_check_out" => $request->rate_deduction_attendance_dont_check_out,
        ]);
        return $this->responseSuccess(null,null,"update",self::IndexRoute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkSetting  $workSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkSetting $workSetting)
    {
        $relatedEmployees = Employee::query()->where("work_setting_id",$workSetting->id)->first();
        if (!is_null($relatedEmployees)){
            throw new MainException(__("err_cascade_delete") . "employees");
        }
        $workSetting->delete();
        return $this->responseSuccess(null,null,"update",self::IndexRoute);
    }

    public function MultiDelete(Request $request)
    {
        $request->validate([
            "ids" => ["array","required"],
            "ids.*" => ["required",Rule::exists("work_settings","id")],
        ]);
        foreach ($request->ids as $id){
            $relatedEmployees = Employee::query()->where("work_setting_id",$id)->first();
            if (!is_null($relatedEmployees)){
                throw new MainException(__("err_cascade_delete") . "employees");
            }
        }
        WorkSetting::query()->whereIn("id",$request->ids)->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function ExportXls(BaseRequest $request)
    {
        $data = $this->MainExportData($request);
        return Excel::download(new TableCustomExport($data['head'],$data['body']),"work_settings.xlsx");
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
            "ids.*" => ["sometimes",Rule::exists("work_settings","id")],
        ]);
        $query = WorkSetting::query();
        $query = isset($request->ids) ? $query->whereIn("id",$request->ids) : $query;
        $data = MyApp::Classes()->Search->getDataFilter($query,null,true);
        $head = [
            "name","count_days_work_in_weeks","count_hours_work_in_days",
            "days_leaves_in_weeks",
            "work_hours_from","work_hours_to","description","min_overtime_hours",
            "late_enter_allowance_per_minute","early_out_allowance_per_minute"
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }
}
