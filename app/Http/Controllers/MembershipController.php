<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\HelpersClasses\MyApp;
use App\Models\Employee;
use App\Models\Membership;
use App\Http\Controllers\Controller;
use App\Http\Requests\MembershipRequest;
use App\Models\Membership_type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use PHPUnit\Exception;

class MembershipController extends Controller
{
    const Folder = "users";
    const IndexRoute = "employees.membership.index";
//    public function __construct()
//    {
//        $this->addMiddlewarePermissionsToFunctions(app(Membership::class)->getTable());
//    }


    public function index()
    {
        $membership = MyApp::Classes()->Search->getDataFilter(Membership::query());
        return $this->responseSuccess("", compact("membership"));
    }


    public function create()
    {
        $membership_types = Membership_type::query()->pluck('name', 'id')->toArray();
        return $this->responseSuccess("", compact('membership_types'));
    }


    public function store(MembershipRequest $request)
    {
        try {
            DB::beginTransaction();
            Membership::create($request->validated());
            DB::commit();
            return $this->responseSuccess(null, null, "create", self::IndexRoute);
        } catch (Exception $exception) {
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }


    public function show($membership = null)
    {

        $membershipQuery = Membership::with(["employee"]);
        $membership = is_null($membership) ? $membershipQuery->where("employee_id",
            Employee::where("user_id", Auth()->id())->pluck("id"))->firstOrFail()
            : $membershipQuery->findOrFail($membership);
        return $this->responseSuccess("", compact("membership"));
    }


    public function edit($membership = null)
    {

        $data = Membership_type::query()->pluck('name', 'id')->toArray();

        $membershipQuery = Membership::with(["employee"]);
        $data['membership'] = is_null($membership) ?
            $membershipQuery->where("employee_id", Employee::where("user_id", Auth()->id())->pluck("id"))->firstOrFail()
            : $membershipQuery->findOrFail($membership);
        return $this->responseSuccess("", $data);
    }


    public function update(MembershipRequest $request, $membership)
    {
        $membershipQuery = Membership::query();
        $employee_id =is_null($membership)? Employee::where("user_id", Auth()->id())->pluck("id"):null;
        $membership = is_null($membership) ? $membershipQuery->where("employee_id",$employee_id)->firstOrFail()
            : $membershipQuery->findOrFail($membership);
        $membership->update($request->validated());
        return $this->responseSuccess(null,null,"update",self::IndexRoute);
    }

    public function destroy($membership)
    {
        Membership::destroy($membership);
        return $this->responseSuccess(null, null, "delete", self::IndexRoute);
    }


    public function trash()
    {
        $contracts = Membership::onlyTrashed()->paginate();
        return $this->responseSuccess(null, compact('contracts'));
    }

    public function restore($id)
    {
        $contract = Membership::onlyTrashed()->findOrFail($id);
        $contract->restore();

    }

    public function forceDelete($id)
    {
        $contract = Membership::onlyTrashed()->findOrFail($id);
        $contract->forceDelete();
        return $this->responseSuccess(null, null, "delete", self::IndexRoute);
    }
    public function MultiMembershipDelete(Request $request)
    {
        $request->validate([
            "ids" => ["required", "array"],
            "ids.*" => ["required", Rule::exists("contracts", "id")],
        ]);
        try {
            DB::beginTransaction();
            Membership::query()->whereIn("id", $request->ids)->delete();
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
            "ids.*" => ["required", Rule::exists("contracts", "id")],
        ]);


        $query = Membership::query();
        $query = isset($request->ids) ? $query->whereIn("id",$request->ids) : $query;
        $data = MyApp::Classes()->Search->getDataFilter($query,null,true);
        $head = [
            [
                "head" => "membership_type",
                "relationFunc" => "membership_type",
                "key" => "name",
            ] ,
            [
                "head"=> "name_employee",
                "relationFunc" => "employee",
                "key" => "name",
            ],
             "number_membership", "branch", "date_start", "date_end","created_at",
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }
}
