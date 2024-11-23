<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\Exports\TableCustomExport;
use App\HelpersClasses\ExportPDF;
use App\HelpersClasses\MyApp;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\PublicHolidayRequest;
use App\Models\PublicHoliday;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class PublicHolidayController extends Controller
{
    public const NameBlade = "System/Pages/Actors/Public_Holiday/publicHolidayView";
    public const IndexRoute = "system.public_holidays.index";

    public function __construct()
    {
        $this->addMiddlewarePermissionsToFunctions(app(PublicHoliday::class)->getTable());
    }

    private function MainQuery($request){
        $query = PublicHoliday::query();
        if (isset($request->filter["start_date_filter"]) && !is_null($request->filter["start_date_filter"])
            && isset($request->filter["end_date_filter"]) && !is_null($request->filter["end_date_filter"])){
            $fromDate = MyApp::Classes()->stringProcess->DateFormat($request->filter["start_date_filter"]);
            $toDate = MyApp::Classes()->stringProcess->DateFormat($request->filter["end_date_filter"]);
            if ( is_string($fromDate) && is_string($toDate) && ($fromDate <= $toDate) ){
                $query = $query->where(function ($query) use ($fromDate,$toDate){
                    $query->whereBetween('start_date', [$fromDate, $toDate])
                        ->orWhereBetween('end_date', [$fromDate, $toDate])
                        ->orWhere(function ($query) use ($fromDate, $toDate) {
                            $query->where('start_date', '<', $fromDate)
                                ->where('end_date', '>', $toDate);
                        });
                });
            }
        }
        if (isset($request->filter["name"]) && !is_null($request->filter["name"])){
            $query = $query->where("name","LIKE","%".$request->filter["name"]."%");
        }
        return $query;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = MyApp::Classes()->Search->dataPaginate($this->MainQuery($request));
        return $this->responseSuccess(self::NameBlade,compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->responseSuccess("System/Pages/Actors/Public_Holiday/publicHolidayForm");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PublicHolidayRequest $request)
    {
        PublicHoliday::create($request->validated());
        return $this->responseSuccess(null,null,"create",self::IndexRoute);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PublicHoliday  $publicHoliday
     * @return \Illuminate\Http\Response
     */
    public function show(PublicHoliday $publicHoliday)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PublicHoliday  $publicHoliday
     * @return \Illuminate\Http\Response
     */
    public function edit(PublicHoliday $publicHoliday)
    {
        return $this->responseSuccess("System/Pages/Actors/Public_Holiday/publicHolidayForm" ,
            compact('publicHoliday'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PublicHoliday  $publicHoliday
     * @return \Illuminate\Http\Response
     */
    public function update(PublicHolidayRequest $request, PublicHoliday $publicHoliday)
    {
        if ($publicHoliday->start_date >= now() && $publicHoliday->end_date <= now()){
            throw new MainException(__("err_public_holiday"));
        }
        if ($publicHoliday->start_date <= now()){
            throw new MainException(__("err_public_holiday"));
        }
        $publicHoliday->update($request->validated());
        return $this->responseSuccess(null,null,"update",self::IndexRoute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PublicHoliday  $publicHoliday
     * @return \Illuminate\Http\Response
     */
    public function destroy(PublicHoliday $publicHoliday)
    {
        $publicHoliday->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function MultiDelete(Request $request)
    {
        $request->validate([
            "ids" => ["array","required"],
            "ids.*" => ["required",Rule::exists("public_holidays","id")],
        ]);
        PublicHoliday::query()->whereIn("id",$request->ids)->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function ExportXls(BaseRequest $request)
    {
        $data = $this->MainExportData($request);
        return Excel::download(new TableCustomExport($data['head'],$data['body']),"public_holidays.xlsx");
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
            "ids.*" => ["sometimes",Rule::exists("public_holidays","id")],
        ]);
        $query = $this->MainQuery($request);
        $query = isset($request->ids) ? $query->whereIn("id",$request->ids) : $query;
        $data = MyApp::Classes()->Search->getDataFilter($query,null,true);
        $head = [
            "name","start_date","end_date",
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }
}
