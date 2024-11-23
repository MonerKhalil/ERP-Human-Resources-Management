<?php

namespace App\Http\Controllers;

use App\Exports\TableCustomExport;
use App\HelpersClasses\ExportPDF;
use App\HelpersClasses\MyApp;
use App\Http\Requests\AttendanceRequest;
use App\Http\Requests\BaseRequest;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Sections;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{

    public const NameBlade = "System/Pages/Actors/Attendance/viewAttendancesAdmin";
    public const IndexRoute = "system.attendances.index";


    public function __construct()
    {
        $table = app(Attendance::class)->getTable();
        $this->middleware("employee")->only(["employeeAttendances","store","create"]);
        $this->middleware(["permission:read_".$table."|all_".$table])->only(["index"]);
        $this->middleware(["permission:delete_".$table."|all_".$table])->only(["destroy","MultiDelete"]);
        $this->middleware(["permission:export_".$table."|all_".$table])->only(["ExportPDF","ExportXls"]);
    }

    private function mainQuery($request){
        $data = Attendance::with(["employee"]);
        if ((isset($request->filter["name_employee"]) && !is_null($request->filter["name_employee"])) ||
            (isset($request->filter["section"]) && !is_null($request->filter["section"]))){
            $data = $data->whereHas("employee",function ($q) use ($request){
                if ((isset($request->filter["name_employee"]) && !is_null($request->filter["name_employee"]))){
                    $q = $q->where(function($query) use ($request){
                            return $query->where("first_name","Like","%".$request->filter["name_employee"])
                                ->orWhere("last_name","Like","%".$request->filter["name_employee"]);
                        });
                }
                if ((isset($request->filter["section"]) && !is_null($request->filter["section"]))){
                    $q = $q->where("section_id",$request->filter["section"]);
                }
                return $q;
            });
        }
        $num = isset($request->filter["number"]) && is_numeric($request->filter["number"]) ? $request->filter["number"] : "0";
        if (isset($request->filter["typeAttendance"]) && $request->filter["typeAttendance"] == "early_exit"){
            $data = $data->where("early_exit_per_minute",">=",$num);
        }
        elseif (isset($request->filter["typeAttendance"]) && $request->filter["typeAttendance"] == "late_entry"){
            $data = $data->where("late_entry_per_minute",">=","0");
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
        $typeAttendance = ["early_exit","late_entry"];
        $sections = Sections::query()->pluck("name","id")->toArray();
        $data = MyApp::Classes()->Search->getDataFilter($this->mainQuery($request));
        return $this->responseSuccess(self::NameBlade ,
            compact("data","sections","typeAttendance"));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|null
     */
    public function employeeAttendances(Request $request){
        $employee_id = auth()->user()->employee->id;
        $typeAttendance = ["early_exit","late_entry"];
        $employee = Employee::with("section")->findOrFail($employee_id);
        $attendances = Attendance::query()->where("employee_id",$employee->id);
        if (isset($request->filter["typeAttendance"]) && $request->filter["typeAttendance"] == "early_exit"){
            $attendances = $attendances->where("early_exit_per_minute",">","0");
        }
        elseif (isset($request->filter["typeAttendance"]) && $request->filter["typeAttendance"] == "late_entry"){
            $attendances = $attendances->where("late_entry_per_minute",">","0");
        }
        $data = MyApp::Classes()->Search->getDataFilter($attendances);
        return $this->responseSuccess("System/Pages/Actors/Attendance/viewAttendancesEmployee" ,
            compact("data","employee","typeAttendance"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = auth()->user()->employee;
        $attendance = Attendance::query()->whereDate("created_at",now())
            ->where("employee_id",$employee->id)->firstOrCreate([]
                , ["employee_id" => $employee->id,"created_at" => now()]);
        return $this->responseSuccess("System/Pages/Actors/Attendance/addAttendanceRecord"
            ,compact("employee","attendance"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($type,AttendanceService $attendanceService)
    {
        if ($type == "check_in"){
            $data = $attendanceService->checkIn();
        }else{
            $data = $attendanceService->checkOut();
        }
        return $this->responseSuccess(null,null,"","system.attendances.employee");
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function MultiDelete(Request $request)
    {
        $request->validate([
            "ids" => ["array","required"],
            "ids.*" => ["required",Rule::exists("attendances","id")],
        ]);
        Attendance::query()->whereIn("id",$request->ids)->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function ExportXls(BaseRequest $request)
    {
        $data = $this->MainExportData($request);
        return Excel::download(new TableCustomExport($data['head'],$data['body']),"attendances.xlsx");
    }

    public function ExportPDF(BaseRequest $request) {
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
            "ids.*" => ["sometimes",Rule::exists("attendances","id")],
        ]);
        $query = $this->mainQuery($request);
        if (isset($request->employee_id) && !is_null($request->employee_id)){
            $query = $query->where("employee_id",$request->employee_id);
        }
        $query = isset($request->ids) ? $query->whereIn("id",$request->ids) : $query;

        $data = MyApp::Classes()->Search->getDataFilter($query,null,true);

        $head = [
            [
                "head"=> "employee",
                "relationFunc" => "employee",
                "key" => "name",
            ],
            "check_in","check_out","hours_work", "created_at",
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }
}
