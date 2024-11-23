<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConferenceEmployeeRequest;
use App\Models\ConferenceEmployee;
use Illuminate\Http\Request;

class ConferenceEmployeeController extends Controller
{
    public function __construct()
    {
        $this->addMiddlewarePermissionsToFunctions(app(ConferenceEmployee::class)->getTable());
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
    public function store(ConferenceEmployeeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConferenceEmployee  $conferenceEmployee
     * @return \Illuminate\Http\Response
     */
    public function show(ConferenceEmployee $conferenceEmployee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConferenceEmployee  $conferenceEmployee
     * @return \Illuminate\Http\Response
     */
    public function edit(ConferenceEmployee $conferenceEmployee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ConferenceEmployee  $conferenceEmployee
     * @return \Illuminate\Http\Response
     */
    public function update(ConferenceEmployeeRequest $request, ConferenceEmployee $conferenceEmployee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConferenceEmployee  $conferenceEmployee
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConferenceEmployee $conferenceEmployee)
    {
        //
    }

    public function MultiDelete(Request $request)
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
