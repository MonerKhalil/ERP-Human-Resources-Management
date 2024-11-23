<?php

namespace App\Http\Controllers;

use App\Exports\TableCustomExport;
use App\HelpersClasses\ExportPDF;
use App\HelpersClasses\MyApp;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\SectionExternalRequest;
use App\Models\SectionExternal;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class SectionExternalController extends Controller
{
    public const NameBlade = "System/Pages/Actors/Sections/viewExternalSection";
    public const IndexRoute = "system.section_externals.index";

    public function __construct()
    {
        $this->addMiddlewarePermissionsToFunctions(app(SectionExternal::class)->getTable());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = countries();
        $data = MyApp::Classes()->Search->getDataFilter(SectionExternal::query());
        return $this->responseSuccess(self::NameBlade,compact("data","countries"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = countries();
        return $this->responseSuccess("System/Pages/Actors/Sections/addExternalSectionForm" ,
            compact("countries"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionExternalRequest $request)
    {
        SectionExternal::create($request->validated());
        return $this->responseSuccess(null,null,"create",self::IndexRoute);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SectionExternal  $sectionExternal
     * @return \Illuminate\Http\Response
     */
    public function show(SectionExternal $sectionExternal)
    {
        $countries = countries();
        return $this->responseSuccess("System/Pages/Actors/Sections/detailsExternalSection",
            compact("sectionExternal" , "countries"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SectionExternal  $sectionExternal
     * @return \Illuminate\Http\Response
     */
    public function edit(SectionExternal $sectionExternal)
    {
        $countries = countries();
        return $this->responseSuccess("System/Pages/Actors/Sections/addExternalSectionForm" ,
            compact("countries","sectionExternal"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SectionExternal  $sectionExternal
     * @return \Illuminate\Http\Response
     */
    public function update(SectionExternalRequest $request, SectionExternal $sectionExternal)
    {
        $sectionExternal->update($request->validated());
        return $this->responseSuccess(null,null,"update",self::IndexRoute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SectionExternal  $sectionExternal
     * @return \Illuminate\Http\Response
     */
    public function destroy(SectionExternal $sectionExternal)
    {
        $sectionExternal->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function MultiDelete(Request $request)
    {
        $request->validate([
            "ids" => ["array","required"],
            "ids.*" => ["required",Rule::exists("section_externals","id")],
        ]);
        SectionExternal::query()->whereIn("id",$request->ids)->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function ExportXls(BaseRequest $request)
    {
        $data = $this->MainExportData($request);
        return Excel::download(new TableCustomExport($data['head'],$data['body']),"sections.xlsx");
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
            "ids.*" => ["sometimes", Rule::exists("section_externals","id")],
        ]);
        $query = SectionExternal::query();
        $query = isset($request->ids) ? $query->whereIn("id",$request->ids) : $query;
        $data = MyApp::Classes()->Search->getDataFilter($query,null,true);
        $head = [
            "name",[
                "head"=> "address",
                "relationFunc" => "address",
                "key" => "name",
            ],"address_details",
            "email","fax","phone",
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }
}
