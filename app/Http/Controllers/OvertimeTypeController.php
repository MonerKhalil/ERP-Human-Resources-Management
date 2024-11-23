<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\HelpersClasses\MyApp;
use App\Http\Requests\OvertimeTypeRequest;
use App\Models\OvertimeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OvertimeTypeController extends Controller
{
    public const NameBlade = "System/Pages/Actors/Overtime/newTypeView";
    public const IndexRoute = "system.overtime_types.index";

    public function __construct()
    {
        $this->addMiddlewarePermissionsToFunctions(app(OvertimeType::class)->getTable());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MyApp::Classes()->Search->getDataFilter(OvertimeType::query());
        return $this->responseSuccess(self::NameBlade,compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->responseSuccess("System/Pages/Actors/Overtime/newTypeAdd");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OvertimeTypeRequest $request)
    {
        OvertimeType::query()->create($request->validated());
        return $this->responseSuccess(null,null,"create",self::IndexRoute);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OvertimeType  $overtimeType
     * @return \Illuminate\Http\Response
     */
    public function show(OvertimeType $overtimeType)
    {
        return $this->responseSuccess("System/Pages/Actors/Overtime/newTypeDetails" ,
            compact("overtimeType"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OvertimeType  $overtimeType
     * @return \Illuminate\Http\Response
     */
    public function edit(OvertimeType $overtimeType)
    {
        return $this->responseSuccess("System/Pages/Actors/Overtime/newTypeAdd" ,
            compact("overtimeType"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OvertimeType  $overtimeType
     * @return \Illuminate\Http\Response
     */
    public function update(OvertimeTypeRequest $request, OvertimeType $overtimeType)
    {
        $overtimeType->update($request->validated());
        return $this->responseSuccess(null,null,"update",self::IndexRoute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OvertimeType  $overtimeType
     * @return \Illuminate\Http\Response
     */
    public function destroy(OvertimeType $overtimeType)
    {
        if (!is_null($overtimeType->overtimes()->first())){
            throw new MainException(__("err_delete_exist_type_in_requests"));
        }
        $overtimeType->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function MultiDelete(Request $request)
    {
        $request->validate([
            "ids" => ["array","required"],
            "ids.*" => ["required",Rule::exists("overtime_types","id")],
        ]);
        try {
            DB::beginTransaction();
            foreach ($request->ids as $id){
                $overtimeType = OvertimeType::query()->find($id);
                if (!is_null($overtimeType->overtimes()->first())){
                    throw new MainException(__("err_delete_exist_type_in_requests"));
                }
                $overtimeType->delete();
            }
            DB::commit();
            return $this->responseSuccess(null,null,"delete",self::IndexRoute);
        }catch (\Exception $exception){
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }
}
