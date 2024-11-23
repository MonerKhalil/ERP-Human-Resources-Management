<?php

namespace App\Http\Controllers;

use App\HelpersClasses\MyApp;
use App\Http\Requests\PositionEmployeeRequest;
use App\Models\Decision;
use App\Models\Employee;
use App\Models\Position;
use App\Models\PositionEmployee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PositionEmployeeController extends Controller
{
    public const NameBlade = "";
    public const Folder = "position_employees";
    public const IndexRoute = "system.position_employees.index";

    public function __construct()
    {
        $this->addMiddlewarePermissionsToFunctions(app(PositionEmployee::class)->getTable());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $PositionEmployees = PositionEmployee::with(["position","employee","decision"]);
        $position = Position::query()->pluck("name","id")->toArray();
        $employee = Employee::query()->select(["first_name","last_name","id"])->get();
        $decision = Decision::query()->pluck("name","id")->toArray();
        $data = MyApp::Classes()->Search->getDataFilter($PositionEmployees);
        return $this->responseSuccess(self::NameBlade,compact("data",'position','decision','employee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $position = Position::query()->pluck("name","id")->toArray();
        $employee = Employee::query()->select(["first_name","last_name","id"])->get();
        $decision = Decision::query()->pluck("name","id")->toArray();
        return $this->responseSuccess("",compact("employee","position","decision"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PositionEmployeeRequest $request)
    {
        PositionEmployee::create($request->validated());
        return $this->responseSuccess(null,null,"create",self::IndexRoute);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PositionEmployee  $positionEmployee
     * @return \Illuminate\Http\Response
     */
    public function show(PositionEmployee $positionEmployee)
    {
        $positionEmployee = PositionEmployee::with(["position","employee","decision"])->findOrFail($positionEmployee->id);
        return $this->responseSuccess("...",compact("positionEmployee"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PositionEmployee  $positionEmployee
     * @return \Illuminate\Http\Response
     */
    public function edit(PositionEmployee $positionEmployee)
    {
        $position = Position::query()->pluck("name","id")->toArray();
        $employee = Employee::query()->select(["first_name","last_name","id"])->get();
        $decision = Decision::query()->pluck("name","id")->toArray();
        $positionEmployee = PositionEmployee::with(["position","employee","decision"])->findOrFail($positionEmployee->id);
        return $this->responseSuccess("...",compact("positionEmployee","employee","position","decision"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PositionEmployee  $positionEmployee
     * @return \Illuminate\Http\Response
     */
    public function update(PositionEmployeeRequest $request, PositionEmployee $positionEmployee)
    {
        $positionEmployee->update($request->validated());
        return $this->responseSuccess(null,null,"update",self::IndexRoute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PositionEmployee  $positionEmployee
     * @return \Illuminate\Http\Response
     */
    public function destroy(PositionEmployee $positionEmployee)
    {
        $positionEmployee->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function MultiDelete(Request $request)
    {
        $request->validate([
            "ids" => ["array","required"],
            "ids.*" => ["required",Rule::exists("session_decisions","id")],
        ]);
        PositionEmployee::query()->whereIn("id",$request->ids)->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }
}
