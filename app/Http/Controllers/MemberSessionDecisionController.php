<?php

namespace App\Http\Controllers;

use App\Models\MemberSessionDecision;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberSessionDecisionRequest;

class MemberSessionDecisionController extends Controller
{
    public function __construct()
    {
        $this->addMiddlewarePermissionsToFunctions(app(MemberSessionDecision::class)->getTable());
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
    public function store(MemberSessionDecisionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MemberSessionDecision  $memberSessionDecision
     * @return \Illuminate\Http\Response
     */
    public function show(MemberSessionDecision $memberSessionDecision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MemberSessionDecision  $memberSessionDecision
     * @return \Illuminate\Http\Response
     */
    public function edit(MemberSessionDecision $memberSessionDecision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MemberSessionDecision  $memberSessionDecision
     * @return \Illuminate\Http\Response
     */
    public function update(MemberSessionDecisionRequest $request, MemberSessionDecision $memberSessionDecision)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemberSessionDecision  $memberSessionDecision
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberSessionDecision $memberSessionDecision)
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
