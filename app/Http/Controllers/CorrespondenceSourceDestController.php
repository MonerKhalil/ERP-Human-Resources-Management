<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\HelpersClasses\MyApp;
use App\Mail\CorrespondenceMail;
use App\Models\Correspondence;
use App\Models\Correspondence_source_dest;
use App\Http\Requests\Correspondence_source_destRequest;
use App\Models\Employee;
use App\Models\SectionExternal;
use App\Models\Sections;
use App\Services\SendNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CorrespondenceSourceDestController extends Controller
{
    const Folder = "users";
    const IndexRoute = "correspondences.index";

    public function __construct()
    {
        $this->addMiddlewarePermissionsToFunctions(app(Correspondence_source_dest::class)->getTable());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = Correspondence::type();//internal,external
        $source_dest_type = Correspondence_source_dest::source_dest_type();//type
        $external_party = SectionExternal::query()->pluck("name", "id")->toArray();//if external
        $internal_department = Sections::query()->pluck("name", "id")->toArray();//if external
        return $this->responseSuccess('System.Pages.Actors.Diwan_User.addSourceDest', compact("internal_department",
            "source_dest_type", "external_party", "type"));
    }

    public function addTransaction($Correspondence_id)
    {
        $correspondence = Correspondence::query()->where("id", $Correspondence_id)->firstOrFail();
        $type = Correspondence::type();//internal,external
        $number_external=Correspondence::query()->whereNotNull("number_external")->pluck("number_external", "id")->toArray();
        $number_internal = Correspondence::query()->whereNotNull("number_internal")->pluck("number_internal", "id")->toArray();
//        dd($number_external, $number_internal);
        $x = [];
        foreach ($number_internal as $key => $value) {
            $number_internal[$key] = 'internal ' . $value;
        }
        foreach ($number_external as $key => $value) {
            $number_external[$key] = 'external ' . $value;
        }
        $all_numbers = $number_internal + $number_external;
//        $all_numbers = array_merge($number_external, $number_internal);
        $source_dest_type = Correspondence_source_dest::source_dest_type();//type
        $external_party = SectionExternal::query()->pluck("name", "id")->toArray();//if external
        $internal_department = Sections::query()->pluck("name", "id")->toArray();//if external
        $employee_dest = Employee::query()->whereNot("user_id", Auth::id())->select(["id", "first_name", "last_name"])->get();//if internal
        return $this->responseSuccess("System.Pages.Actors.Diwan_User.addSourceDest", compact("employee_dest", "correspondence",
            "source_dest_type", "external_party", "type", "internal_department","number_external","number_internal", "all_numbers"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param SendNotificationService $sendNotificationService
     * @return \Illuminate\Http\Response
     */
    public function store(Correspondence_source_destRequest $request, SendNotificationService $sendNotificationService)
    {
        try {
            DB::beginTransaction();
            $data = Arr::except($request->validated(), ["data"]);
            if ($request->hasFile("path_file")) {
                $path = MyApp::Classes()->storageFiles
                    ->Upload($request['path_file'], "correspondence/document_Correspondence");
                $data['path_file'] = $path;
            }
            $data['current_employee_id'] = auth()->user()->employee->id;
            $data['external_party_id'] = $request->external_party_id;
            $data['internal_department_id'] = $request->internal_department_id;
          $correspondence_source_dest  =Correspondence_source_dest::query()->create($data);
            if($request->type == "external") {
            if($this->isOnlineInternet()){
    /////send mail
//                $mail=$correspondence_source_dest->external_party->mail;
//                $correspondence=Correspondence::find($correspondence_source_dest->correspondences_id);
//                Mail::to($mail)->send(new CorrespondenceMail($data,$correspondence ));
                }
            }elseif ($request->type == "internal"){
                $correspondence=Correspondence::find($correspondence_source_dest->correspondences_id);
                $idemployee=$correspondence_source_dest->internal_department->moderator->user_id;
                $sendNotificationService->sendNotify([$idemployee],"Correspondence_internal","msg_Correspondence_internal",
                    route("correspondences.index",$correspondence));
            }
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
     * @param \App\Models\Correspondence $Correspondence
     * @return \Illuminate\Http\Response
     */
    public function show(Correspondence $Correspondence)
    {
        $correspondence_transaction = Correspondence_source_dest::with(["employee_current", "employee_dest", "out_section_dest", "out_section_current"])
            ->find($Correspondence->id);
        return $this->responseSuccess(".....", compact("correspondence_transaction"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Correspondence_source_dest $correspondence_source_dest
     * @return \Illuminate\Http\Response
     */
    public function edit(Correspondence_source_dest $correspondence_source_dest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Correspondence_source_dest $correspondence_source_dest
     * @return \Illuminate\Http\Response
     */
    public function update(Correspondence_source_destRequest $request, Correspondence_source_dest $correspondence_source_dest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Correspondence_source_dest $correspondence_source_dest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Correspondence_source_dest $correspondence_source_dest)
    {
        $correspondence_source_dest->delete();
        return $this->responseSuccess(null, null, "delete", self::IndexRoute);
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

    public function isOnlineInternet($site = "www.google.com"): bool
    {
        if (@fopen($site, "r")) {
            return true;
        } else {
            return false;
        }
    }


}
