<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\Exports\TableCustomExport;
use App\HelpersClasses\ExportPDF;
use App\HelpersClasses\MyApp;
use App\Http\Requests\BaseRequest;
use App\Models\Contract;
use App\Http\Requests\ContractRequest;
use App\Models\Employee;
use App\Models\Sections;
use App\Models\User;
use App\Services\OverTimeCheckService;
use App\Services\YearsEmployeeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Exception;

class ContractController extends Controller
{
    const Folder = "users";
    const IndexRoute = "system.employees.contract.index";

    public function __construct()
    {
        $this->addMiddlewarePermissionsToFunctions(app(Contract::class)->getTable());
    }

    public function index(Request $request)
    {
        $q = Contract::with('employee');

        if (isset($request->filter["employee_name"]) && !is_null($request->filter["employee_name"])){
            $q = $q->whereHas("employee",function ($query)use($request){
                $query->where("first_name","LIKE","%".$request->filter["employee_name"]."%")
                    ->orWhere("last_name","LIKE","%".$request->filter["employee_name"]."%");
            });
        }

        $contracts = MyApp::Classes()->Search->getDataFilter($q, null, null, "contract_date");

        return $this->responseSuccess("System.Pages.Actors.HR_Manager.viewContracts", compact("contracts"));
    }

    public function create()
    {
        return $this->responseSuccess("System.Pages.Actors.HR_Manager.addContract", $this->shareByBlade());
    }

    private function shareByBlade()
    {
        $contract_type = ["permanent", "temporary"];
        // I need to add an empty option at the first
        $employees_names = Employee::query()->pluck('first_name', "id")->toArray();
        $sections = Sections::query()->pluck("name", "id")->toArray();
        return compact('contract_type', 'employees_names', 'sections');
    }

    public function store(ContractRequest $request,YearsEmployeeService $yearsEmployeeService)
    {
        try {
            DB::beginTransaction();
            Contract::create($request->validated());
            $yearsEmployeeService->updateServicesYearsEmployee($request->employee_id);
            DB::commit();
            return $this->responseSuccess(null, null, "create", self::IndexRoute);
        } catch (Exception $exception) {
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }

    public function show($contract)
    {
        $contract = Contract::with(["employee","section"])->findOrFail($contract);
        return $this->responseSuccess("System.Pages.Actors.HR_Manager.viewContract", compact("contract"));
    }

    public function edit($contract)
    {
        $data = $this->shareByBlade();
        $contract = Contract::with(["employee","section"])->findOrFail($contract);
        $data["contract"] = $contract;
//        dd($data);
        return $this->responseSuccess("System.Pages.Actors.HR_Manager.editContract", compact('data'));
    }


    public function update(ContractRequest $request, $contract,YearsEmployeeService $yearsEmployeeService)
    {
        $contract = Contract::query()->findOrFail($contract);
        try {
            DB::beginTransaction();
            $contract->update($request->validated());
            $yearsEmployeeService->updateServicesYearsEmployee($contract["employee_id"]);
            DB::commit();
            return $this->responseSuccess(null, null, "update", self::IndexRoute);
        }catch (\Exception $exception){
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }

    public function destroy($id)
    {
        Contract::query()->findOrFail($id)->delete();

        return $this->responseSuccess(null, null, "delete", self::IndexRoute);
    }


    public function trash()
    {
        $contracts = Contract::onlyTrashed()->paginate();
        return $this->responseSuccess(null, compact('contracts'));
    }

    public function restore($id)
    {
        $contract = Contract::onlyTrashed()->findOrFail($id);
        $contract->restore();

    }

    public function forceDelete($id)
    {
        $contract = Contract::onlyTrashed()->findOrFail($id);
        $contract->forceDelete();
        return $this->responseSuccess(null, null, "delete", self::IndexRoute);
    }

    public function MultiContractsDelete(Request $request)
    {
        $request->validate([
            "ids" => ["required", "array"],
            "ids.*" => ["required", Rule::exists("contracts", "id")],
        ]);
        try {
            DB::beginTransaction();
            Contract::query()->whereIn("id", $request->ids)->delete();
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
        return ExportPDF::downloadPDF($data['head'], $data['body']);
    }

    private function MainExportData(Request $request): array
    {
        $request->validate([
            "ids" => ["required", "array"],
            "ids.*" => ["required", Rule::exists("contracts", "id")],
        ]);

        $query = Contract::with(["employee","section"]);
        $query = isset($request->ids) ? $query->whereIn("id", $request->ids) : $query;
        $data = MyApp::Classes()->Search->getDataFilter($query, null, true);
        $head = [
            [
                "head" => "name_section",
                "relationFunc" => "section",
                "key" => "name",
            ],
            [
                "head" => "name_employee",
                "relationFunc" => "employee",
                "key" => "name",
            ],
            "contract_type", "contract_number", "contract_date", "contract_finish_date",
            "contract_direct_date", "salary", "created_at",
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }
}
