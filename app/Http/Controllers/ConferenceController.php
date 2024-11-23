<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\Exports\TableCustomExport;
use App\HelpersClasses\ExportPDF;
use App\HelpersClasses\MyApp;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\ConferenceRequest;
use App\Models\Conference;
use App\Models\ConferenceEmployee;
use App\Models\Employee;
use App\Models\SessionDecision;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ConferenceController extends Controller
{
    public const NameBlade = "System.Pages.Actors.HR_Manager.viewCourses";
    public const IndexRoute = "system.conferences.index";

    public function __construct()
    {
        $this->addMiddlewarePermissionsToFunctions(app(Conference::class)->getTable());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MyApp::Classes()->Search->getDataFilter(Conference::query());
        return $this->responseSuccess(self::NameBlade,compact("data"));
    }

    public function EmployeeConference($employee){
        $employee = Employee::query()->find($employee);
        $query = Conference::query()->whereHas("employees",function ($q)use ($employee){
            return $q->where("id",$employee->id);
        });
        $data = MyApp::Classes()->Search->getDataFilter($query);
        return $this->responseSuccess(self::NameBlade,compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = countries();
        $types = ["course","conference"];
        $employees = Employee::query()->select(["id","first_name","last_name"])->get();
        return $this->responseSuccess("System.Pages.Actors.HR_Manager.addCourse",compact("employees","types","countries"));
    }

    /**
     * @throws MainException
     */
    public function store(ConferenceRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = Arr::except($request->validated(), ["employees"]);
            $Conference = Conference::query()->create($data);
            $employees = array_unique($request->employees);
            $Conference->employees()->attach($employees);
            DB::commit();
            return $this->responseSuccess(null,null,"create",self::IndexRoute);
        }catch (\Exception $exception){
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }

    public function show(Conference $conference)
    {
        $conference = Conference::with(["employees","address"])
            ->findOrFail($conference->id);
        return $this->responseSuccess("System.Pages.Actors.HR_Manager.viewCourse",compact("conference"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conference  $conference
     * @return \Illuminate\Http\Response
     */
    public function edit(Conference $conference)
    {
        $countries = countries();
        $types = ["course","conference"];
        $employees = Employee::query()->select(["id","first_name","last_name"])->get();
        $conference = Conference::with(["employees","address"])
            ->findOrFail($conference->id);
        return $this->responseSuccess("System.Pages.Actors.HR_Manager.editCourse",compact("employees","types","countries",'conference'));
    }

    public function update(ConferenceRequest $request, Conference $conference)
    {
        try {
            DB::beginTransaction();
            $data = Arr::except($request->validated(), ["employees"]);
            $conference->update($data);
            if (isset($request->employees)){
                $employees = array_unique($request->employees);
                $conference->employees()->sync($employees);
            }
            DB::commit();
            return $this->responseSuccess(null,null,"update",self::IndexRoute);
        }catch (\Exception $exception){
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conference  $conference
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conference $conference)
    {
        $related = ConferenceEmployee::query()->where("conference_id",$conference->id)->first();
        if (!is_null($related)){
            throw new MainException(__("err_cascade_delete") . "employees");
        }
        $conference->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function MultiDelete(Request $request)
    {
        $request->validate([
            "ids" => ["array","required"],
            "ids.*" => ["required",Rule::exists("conferences","id")],
        ]);
        foreach ($request->ids as $id){
            $related = ConferenceEmployee::query()->where("conference_id",$id)->first();
            if (!is_null($related)){
                throw new MainException(__("err_cascade_delete") . "employees");
            }
        }
        Conference::query()->whereIn("id",$request->ids)->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
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
            "ids.*" => ["sometimes",Rule::exists("conferences","id")],
        ]);
        $query = Conference::with(["address"]);
        $query = isset($request->ids) ? $query->whereIn("id",$request->ids) : $query;
        $data = MyApp::Classes()->Search->getDataFilter($query,null,true);
        $head = [
            "name","type","start_date","end_date", "rate_effect_salary",[
                "head"=> "address",
                "relationFunc" => "address",
                "key" => "name",
            ],"address_details","name_party"
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }
}
