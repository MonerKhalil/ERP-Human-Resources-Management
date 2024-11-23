<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\Exports\TableCustomExport;
use App\HelpersClasses\ExportPDF;
use App\HelpersClasses\MessagesFlash;
use App\HelpersClasses\MyApp;
use App\Models\Correspondence;
use App\Http\Requests\CorrespondenceRequest;
use App\Models\Correspondence_source_dest;
use App\Services\SendNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class CorrespondenceController extends Controller
{
    const Folder = "correspondence";
    const IndexRoute = "correspondences.index";

    public function __construct()
    {
        $this->addMiddlewarePermissionsToFunctions(app(Correspondence::class)->getTable());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = Correspondence::query();
        $q->whereHas("employee", function ($emp) use ($request) {
            $emp->whereHas("section", function ($q) use ($request) {
                if (auth()->user()->can("all_correspondences")) {
                    if (isset($request->filter["section_id"]) && !is_null($request->filter["section_id"])) {
                        $q->where("id", $request->filter["section_id"]);
                    }
                } else {
                    $q->where("id", auth()->user()->employee->section_id);
                }
            });
        });

        $correspondences = MyApp::Classes()->Search->getDataFilter($q, null, null, null);
//        dd($correspondences);
        return $this->responseSuccess("System.Pages.Actors.Diwan_User.viewCorrespondenses", compact("correspondences"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->responseSuccess("System.Pages.Actors.Diwan_User.addOutgoingCorrespondense", $this->shareByBlade());
    }

    private function shareByBlade()
    {
        $type = ['internal', 'external'];
        $number_internal = Correspondence::query()->withTrashed()->latest('number_internal')->first()->number_internal ?? 0;
        if (!is_null($number_internal)) {
            $number_internal++;
        }
        $number_external = Correspondence::query()->withTrashed()->latest('number_external')->first()->number_external ?? 0;
        if (!is_null($number_external)) {
            $number_external++;
        }
        return compact('type', 'number_internal', "number_external");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CorrespondenceRequest $request)
    {
        try {
            DB::beginTransaction();


            $data = Arr::except($request->validated(), ["number_external", "number_internal"]);
            if ($request->hasFile("path_file")) {
                $path = MyApp::Classes()->storageFiles
                    ->Upload($request['path_file'], "correspondence/document_Correspondence");
                $data['path_file'] = $path;
            }
            if ($request->type == "internal") {
                $number_internal = Correspondence::query()->withTrashed()->latest('number_internal')->first()->number_internal ?? 0;
                if (!is_null($number_internal)) {
                    $number_internal++;
                }
                $data["number_internal"] = $number_internal;
            } else if ($request->type == "external") {
                $number_external = Correspondence::query()->withTrashed()->latest('number_external')->first()->number_external ?? 0;
                if (!is_null($number_external)) {
                    $number_external++;
                }
                $data["number_external"] = $number_external;
            }
            $data["employee_id"] = auth()->user()->employee->id;
            Correspondence::query()->create($data);
            DB::commit();
            return $this->responseSuccess(null, null, "create", self::IndexRoute);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Correspondence $correspondence
     * @return \Illuminate\Http\Response
     */
    public function show(Correspondence $correspondence)
    {
        $correspondence = Correspondence::with(["CorrespondenceDest"])
            ->findOrFail($correspondence->id);
        return $this->responseSuccess("System.Pages.Actors.Diwan_User.viewCorrespondence", compact("correspondence"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Correspondence $correspondence
     * @return \Illuminate\Http\Response
     */
    public function edit(Correspondence $correspondence)
    {
        $type = ['internal', 'external'];
        $number_internal = Correspondence::query()->withTrashed()->latest('number_internal')->first()->number_internal ?? 0;
        if (!is_null($number_internal)) {
            $number_internal++;
        }
        $number_external = Correspondence::query()->withTrashed()->latest('number_external')->first()->number_external ?? 0;
        if (!is_null($number_external)) {
            $number_external++;
        }

        $correspondence = Correspondence::with(["CorrespondenceDest"])
            ->findOrFail($correspondence->id);
        return $this->responseSuccess("System.Pages.Actors.Diwan_User.editCorrespondence", compact("correspondence", 'number_internal', "number_external", "type"));
    }


    public function update(CorrespondenceRequest $request, Correspondence $correspondence)
    {
        try {
            //dd("djkj");
            DB::beginTransaction();
            $data =Arr::except($request->validated(),["number_internal","number_external","type"]) ;

            if (isset($data['path_file'])) {
                $document_path = MyApp::Classes()->storageFiles->Upload($data['path_file']);
                if (is_bool($document_path)) {
                    MessagesFlash::Errors(__("err_image_upload"));
                    return redirect()->back();
                }
                $data['path_file'] = $document_path;
                MyApp::Classes()->storageFiles->deleteFile($correspondence->path_file);
            }
            $correspondence->update($data);
            DB::commit();
            return $this->responseSuccess(null, null, "update", self::IndexRoute);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Correspondence $correspondence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Correspondence $correspondence)
    {
        $related = Correspondence_source_dest::query()->where("correspondences_id",$correspondence->id)->first();
        if (!is_null($related)){
            throw new MainException(__("err_cascade_delete") . "correspondence_source_dest");
        }
        $correspondence->delete();
        return $this->responseSuccess(null, null, "delete", self::IndexRoute);
    }

    public function MultiDelete(Request $request)
    {
        $request->validate([
            "ids" => ["required", "array"],
            "ids.*" => ["required", Rule::exists("correspondences", "id")],
        ]);
        try {
            DB::beginTransaction();
            foreach ($request->ids as $id){
                $related = Correspondence_source_dest::query()->where("correspondences_id",$id)->first();
                if (!is_null($related)){
                    throw new MainException(__("err_cascade_delete") . "correspondence_source_dest");
                }
            }
            Correspondence::query()->whereIn("id", $request->ids)->delete();
            DB::commit();
            return $this->responseSuccess(null, null, "delete", self::IndexRoute);
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
            "ids.*" => ["required", Rule::exists("correspondences", "id")],
            //  "contracts.*.user_id" => ["required", Rule::exists("users", "id")],
        ]);


        $query = Correspondence::with(["CorrespondenceDest", "employee"]);
        $query = isset($request->ids) ? $query->whereIn("id", $request->ids) : $query;
        $data = MyApp::Classes()->Search->getDataFilter($query, null, true);
        $head = [
            [
                "head" => "name_employee",
                "relationFunc" => "employee",
                "key" => "name",
            ],
            "subject", "number_external", "number_internal", "date",
            "type", "summary",
            "created_at",
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }


}
