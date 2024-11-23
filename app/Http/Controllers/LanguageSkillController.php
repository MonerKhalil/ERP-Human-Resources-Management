<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\Exports\TableCustomExport;
use App\HelpersClasses\ExportPDF;
use App\HelpersClasses\MyApp;
use App\Models\Contract;
use App\Models\Employee;
use App\Models\Language_skill;
use App\Http\Controllers\Controller;
use App\Http\Requests\Language_skillRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Exception;

class LanguageSkillController extends Controller
{
    const Folder = "users";
    const IndexRoute = "employees.languageSkill.index";
//    public function __construct()
//    {
//        $this->addMiddlewarePermissionsToFunctions(app(Language_skill::class)->getTable());
//    }


    public function index(Request $request)
    {
        $q = Language_skill::with('employee');
        $language= MyApp::Classes()->Search->getDataFilter($q);
        return $this->responseSuccess("",compact("language"));
    }


    public function create()
    {
        return $this->responseSuccess("", $this->shareByBlade());
    }

    private function shareByBlade()
    {
        $read = ["Beginner", "Intermediate", "Advanced"];
        $write = ["Beginner", "Intermediate", "Advanced"];
        return compact('read', 'write');

    }

    public function store(Language_skillRequest $request)
    {
        try {
            DB::beginTransaction();
            Language_skill::create($request->validated());
            DB::commit();
            return $this->responseSuccess(null, null, "create", self::IndexRoute);
        } catch (Exception $exception) {
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }


    public function show($language_skill)
    {

        $language_skillQuery = Language_skill::with(["employee" ]);
        $lang= is_null($language_skill) ? $language_skillQuery->where("employee_id",
            Employee::where("user_id", Auth()->id())->pluck("id"))->firstOrFail()
            : $language_skillQuery->findOrFail($language_skill);
        return $this->responseSuccess("",compact("lang"));
    }

    public function edit($language_skill)
    {
        $data = $this->shareByBlade();
        $language_skillQuery = Language_skill::with(["employee" ]);
        if (is_null($language_skill)) {
            $data['language_skill']=$language_skillQuery->where("employee_id", Employee::where("user_id", Auth()->id())->pluck("id"))->firstOrFail();
        } else {
            $data['language_skill'] = $language_skillQuery->findOrFail($language_skill);
        }
        return $this->responseSuccess("", $data);
    }

    public function update(Language_skillRequest $request, $language_skill)
    {
        $employeeQuery = Language_skill::query();
        $employee_id =is_null($language_skill)? Employee::where("user_id", Auth()->id())->pluck("id"):null;
        $employee = is_null($language_skill) ? $employeeQuery->where("employee_id",$employee_id)->firstOrFail()
            : $employeeQuery->findOrFail($language_skill);
        $employee->update($request->validated());
        return $this->responseSuccess(null,null,"update",self::IndexRoute);
    }

    public function destroy($id)
    {
        Language_skill::destroy($id);
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }


    public function trash()
    {
        $contracts = Language_skill::onlyTrashed()->paginate();
        return $this->responseSuccess(null,compact('contracts'));
    }

    public function restore($id)
    {
        $contract = Language_skill::onlyTrashed()->findOrFail($id);
        $contract->restore();

    }

    public function forceDelete($id)
    {
        $contract = Language_skill::onlyTrashed()->findOrFail($id);
        $contract->forceDelete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function MultiLanguageDelete(Request $request)
    {
        $request->validate([
            "ids" => ["required", "array"],
            "ids.*" => ["required", Rule::exists("language_skills", "id")],
        ]);
        try {
            DB::beginTransaction();
            Language_skill::query()->whereIn("id", $request->ids)->delete();
            DB::commit();
            $this->responseSuccess(null, null, "delete", self::IndexRoute);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new MainException($e->getMessage());
        }
    }

    public function ExportXls(Request $request)
    {
        $data = $this->MainExportData($request);
        return Excel::download(new TableCustomExport($data['head'], $data['body']), self::Folder . ".xlsx");
    }

    public function ExportPDF(Request $request)
    {
        $data = $this->MainExportData($request);
        return ExportPDF::downloadPDF($data['head'],$data['body']);
    }

    private function MainExportData(Request $request): array
    {
        $request->validate([
            "ids" => ["required", "array"],
            "ids.*" => ["required", Rule::exists("language_skills", "id")],
        ]);


        $query = Language_skill::with(["language","employee"]);
        $query = isset($request->ids) ? $query->whereIn("id",$request->ids) : $query;
        $data = MyApp::Classes()->Search->getDataFilter($query,null,true);
        $head = [
            [
                "head" => "name_language",
                "relationFunc" => "language",
                "key" => "name",
            ] ,
            [
                "head"=> "name_employee",
                "relationFunc" => "employee",
                "key" => "name",
            ],
            "read","write","created_at",
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }
}
