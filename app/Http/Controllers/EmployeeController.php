<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\Exports\TableCustomExport;
use App\HelpersClasses\ExportPDF;
use App\HelpersClasses\MyApp;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\DataAllEmployeeRequest;
use App\Http\Requests\EmployeeRequest;
use App\Models\Decision;
use App\Models\Education_level;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Overtime;
use App\Models\PositionEmployee;
use App\Models\Sections;
use App\Models\User;
use App\Models\WorkSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{

    const Folder = "employees";
    const IndexRoute = "system.employees.index";

    public function __construct()
    {
        $this->addMiddlewarePermissionsToFunctions(app(Employee::class)->getTable());
    }

    public function index()
    {
        $employees = MyApp::Classes()->Search->getDataFilter(Employee::query()->whereNot("user_id",auth()->id()));
        return $this->responseSuccess("System.Pages.Actors.HR_Manager.viewEmployees",compact("employees"));
    }

    public function create()
    {
        return $this->responseSuccess("System.Pages.Actors.HR_Manager.addEmployee",$this->shareByBlade());
    }

    /**
     * @param DataAllEmployeeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|null
     * @throws MainException
     * @author moner khalil
     */
    public function store(DataAllEmployeeRequest $request)
    {
        try {
            DB::beginTransaction();
            $employee = Employee::create($request->employeeData());
            $contact = $employee->contact()->create($request->contactDate());
            if (!is_null($request->document_contact)){
                foreach ($request->document_contact as $item){
                    $temp = $item;
                    if (isset($temp['document_path'])){
                        $temp['document_path'] = MyApp::Classes()->storageFiles
                            ->Upload($temp['document_path'],"employees/document_contact");
                    }
                    $contact->document_contact()->create($temp);
                }
            }
            $education_data = $employee->education_data()->create($request->educationData());
            if (!is_null($request->document_education_path)){
                foreach ($request->document_education_path as $item){
                    $temp = $item;
                    $temp = MyApp::Classes()->storageFiles->Upload($temp,"employees/document_education");
                    $education_data->document_education()->create([
                        "document_education_path" => $temp,
                    ]);
                }
            }
            DB::commit();
            return $this->responseSuccess(null,null,"create",self::IndexRoute);
        }catch (\Exception $exception){
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }

    /**
     * @param null $employee
     * @author moner khalil
     */
    public function show($employee = null)
    {
        $employeeQuery = Employee::with([
            "contact" => function($q){
                return $q->with(["document_contact","address"])->get();
            },
            "education_data" => function($q){
                return $q->with(["document_education","education_level"])->get();
            },
            "nationality_country","section","positions","contract","language_skill","user",
        ]);
        $employee = is_null($employee) ? $employeeQuery->where("user_id",auth()->id())->firstOrFail()
            : $employeeQuery->findOrFail($employee);
        return $this->responseSuccess("System.Pages.Actors.HR_Manager.viewEmployee" ,
            compact("employee"));
    }

    public function edit(Employee $employee = null)
    {
        $employeeQuery = Employee::with([
            "contact" => function($q){
                return $q->with(["document_contact","address"])->get();
            },
            "education_data" => function($q){
                return $q->with(["document_education","education_level"])->get();
            },
        ]);
        $data = $this->shareByBlade($employee->id);
        $data['employee'] = is_null($employee) ? $employeeQuery->where("user_id",auth()->id())->firstOrFail()
            : $employeeQuery->findOrFail($employee->id);
        return $this->responseSuccess("System.Pages.Actors.HR_Manager.editEmployee",$data);
    }

    public function update(EmployeeRequest $request, Employee $employee = null)
    {
        $employeeQuery = Employee::query();
        $employee = is_null($employee) ? $employeeQuery->where("user_id",auth()->id())->firstOrFail()
            : $employeeQuery->findOrFail($employee->id);
        $employee->update($request->validated());
        return $this->responseSuccess(null,null,"update",self::IndexRoute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        throw new MainException(__("err_cascade_delete") . "sections");
        $employee->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function MultiDelete(Request $request)
    {
        $request->validate([
            "ids" => ["array","required"],
            "ids.*" => ["required",Rule::exists("employees","id")],
        ]);
        throw new MainException(__("err_cascade_delete") . "sections");
        Employee::query()->whereIn("id",$request->ids)->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    private function shareByBlade($id_employee = null){
        $work_settings = WorkSetting::query()->get();
        $gender = ["male", "female"];
        $military_service = ["exempt", "performer", "in_service"];
        $family_status = ["married", "divorced", "single"];
        $address_type = ["house", "clinic", "office"];
        $document_type = ["family_card","identification","passport"];
        $education_level = Education_level::query()->pluck("name","id")->toArray();
        if(is_null($id_employee)){
            $employees = Employee::query()->pluck("user_id")->toArray();
        }else{
            $employees = Employee::query()->whereNot("id",$id_employee)->pluck("user_id")->toArray();
        }
        $users = User::query()
            ->whereNotIn("id",$employees)
            ->whereNot("id",Auth()->id())->pluck("name","id")->toArray();
        $countries = countries();
        $sections = Sections::query()->pluck("name","id")->toArray();
        return compact('sections','countries','gender','military_service'
            ,'family_status','address_type','education_level','document_type','work_settings',"users");
    }

    public function ExportXls(BaseRequest $request)
    {
        $data = $this->MainExportData($request);
        return Excel::download(new TableCustomExport($data['head'], $data['body']), self::Folder . ".xlsx");
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
            "ids.*" => ["sometimes",Rule::exists("employees","id")],
        ]);
        $query = Employee::with(["nationality_country","section"])->whereNot("user_id",auth()->id());
        $query = isset($request->ids) ? $query->whereIn("id",$request->ids) : $query;
        $data = MyApp::Classes()->Search->getDataFilter($query,null,true);
        $head = [
            [
                "head"=> "department",
                "relationFunc" => "section",
                "key" => "name",
            ],
            "name",
            [
                "head"=> "nationality",
                "relationFunc" => "nationality_country",
                "key" => "country_name",
            ],
            "NP_registration","number_national","number_self","gender","current_job","military_service", "family_status","birth_date",
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }

}
