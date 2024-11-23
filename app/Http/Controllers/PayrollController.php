<?php

namespace App\Http\Controllers;

use App\Exports\TableCustomExport;
use App\HelpersClasses\ExportPDF;
use App\HelpersClasses\MyApp;
use App\Http\Requests\BaseRequest;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class PayrollController extends Controller
{
    public const NameBlade = "System/Pages/Actors/Payroll/payrollDetailsAdmin";

    public function __construct()
    {
        $this->middleware("employee")->only("salaryDetails");
        $this->middleware(["permission:all_payrolls"])->only(["create","store"]);
    }

    private function MainQuery($request ,$employee_id){
        $payroll = Payroll::with("employee")
            ->where("employee_id",$employee_id);

        if (isset($request->year) && !is_null($request->year)){
            $payroll = $payroll->whereYear("created_at",$request->year);
        }

        if (isset($request->month) && !is_null($request->month)){
            if (is_null($request->year)){
                $payroll = $payroll
                    ->whereYear("created_at",now()->year)
                    ->whereMonth("created_at",$request->month);
            }else{
                $payroll = $payroll->whereMonth("created_at",$request->month);
            }
        }else{
            $payroll = $payroll
                ->whereYear("created_at",now()->year)
                ->whereMonth("created_at",now()->month);
        }
        return $payroll->orderByDesc("created_at");
    }

    public function salaryDetails(Request $request){
        $employee = auth()->user()->employee;
        $data = $this->MainQuery($request,$employee->id)->first();
        $year = $request->year ?? now()->year;
        $month = $request->month ?? now()->month;
        return $this->responseSuccess("System/Pages/Actors/Payroll/payrollDetails",
            compact("data","employee","year","month"));
    }

    public function salaryDetailsEmployee(Request $request,$employee){
        $employee = Employee::query()->findOrFail($employee);
        $data = $this->MainQuery($request,$employee->id)->first();
        $year = $request->year ?? now()->year;
        $month = $request->month ?? now()->month;
        return $this->responseSuccess(self::NameBlade ,
            compact("data","employee","year","month"));
    }

    public function ExportXls(BaseRequest $request)
    {
        $data = $this->MainExportData($request);
        return Excel::download(new TableCustomExport($data['head'],$data['body']),"payrolls.xlsx");
    }

    public function ExportPDF(BaseRequest $request) {
        $request->validate([
            "employee_id" => ["required",Rule::exists("employees","id")],
        ]);
        $employee = Employee::query()->find($request->employee_id);
        $data = $this->MainQuery($request,$employee->id)->first();
        $year = $request->year ?? now()->year;
        $month = $request->month ?? now()->month;
        return $this->responseSuccess("System/Pages/Actors/Payroll/PDF_payrollDetailsAdmin" ,
            compact("data","employee","year","month"));
    }

    /**
     * @param Request $request
     * @return array
     * @author moner khalil
     */
    private function MainExportData(Request $request): array
    {
        $request->validate([
            "employee_id" => ["required",Rule::exists("employees","id")],
        ]);
        $query = $this->mainQuery($request,$request->employee_id);

        if (isset($request->employee_id) && !is_null($request->employee_id)){
            $query = $query->where("employee_id",$request->employee_id);
        }

        $data = [$query->first()];

        $head = [
            [
                "head"=> "employee",
                "relationFunc" => "employee",
                "key" => "name",
            ],
            "total_salary","default_salary",
            "overtime_minute","overtime_value","bonuses_decision","penalties_decision",
            "absence_days","absence_days_value",
            "count_leaves_unpaid","leaves_unpaid_value","count_leaves_effect_salary","leaves_effect_salary_value",
            "position_employee_value","conferences_employee_value",
            "education_value",
            "minutes_late_entry","minutes_late_entry_value",
            "minutes_early_exit","minutes_early_exit_value",
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }

}
