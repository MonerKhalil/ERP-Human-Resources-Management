<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDecision;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeDecisionRequest;

class EmployeeDecisionController extends Controller
{
    public function __construct()
    {
        $this->addMiddlewarePermissionsToFunctions(app(EmployeeDecision::class)->getTable());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeDecisionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmployeeDecision  $employeeDecision
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeDecision $employeeDecision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmployeeDecision  $employeeDecision
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeDecision $employeeDecision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeDecision  $employeeDecision
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeDecisionRequest $request, EmployeeDecision $employeeDecision)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployeeDecision  $employeeDecision
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeDecision $employeeDecision)
    {
        //
    }

    public function ExportXls()
    {
        //
    }

    public function ExportPDF()
    {
        //
    }
}
