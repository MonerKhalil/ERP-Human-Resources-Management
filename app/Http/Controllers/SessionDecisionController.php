<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\Exports\TableCustomExport;
use App\HelpersClasses\ExportPDF;
use App\HelpersClasses\MessagesFlash;
use App\HelpersClasses\MyApp;
use App\Http\Requests\BaseRequest;
use App\Models\Decision;
use App\Models\Employee;
use App\Models\MemberSessionDecision;
use App\Models\SessionDecision;
use App\Http\Requests\SessionDecisionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class SessionDecisionController extends Controller
{
    public const NameBlade = "System.Pages.Actors.sessionView";
    public const Folder = "session_decisions";
    public const IndexRoute = "system.session_decisions.index";

    public function __construct()
    {
        $this->addMiddlewarePermissionsToFunctions(app(SessionDecision::class)->getTable());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MyApp::Classes()->Search->getDataFilter(SessionDecision::query(),null,null,"date_session");
        return $this->responseSuccess(self::NameBlade,compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::query()->select(["id","first_name","last_name"])->get();
        return $this->responseSuccess("System.Pages.Actors.sessionForm" ,
            compact("employees"));
    }


    /**
     * @throws \App\Exceptions\MainException
     */
    public function store(SessionDecisionRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = Arr::except($request->validated(),["members"]);
            if (isset($data['image'])){
                $image = MyApp::Classes()->storageFiles->Upload($data['image']);
                if (is_bool($image)){
                    MessagesFlash::Errors(__("err_image_upload"));
                    return redirect()->back();
                }
                $data['image'] = $image;
            }
            if (isset($data['file'])){
                $file = MyApp::Classes()->storageFiles->Upload($data['file']);
                if (is_bool($file)){
                    MessagesFlash::Errors(__("err_file_upload"));
                    return redirect()->back();
                }
                $data['file'] = $file;
            }
            $Session = SessionDecision::query()->create($data);
            $Session->members()->attach($request->members);
            DB::commit();
            return $this->responseSuccess(null,null,"create",self::IndexRoute);
        }catch (\Exception $exception){
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SessionDecision  $sessionDecision
     * @return \Illuminate\Http\Response
     */
    public function show(SessionDecision $sessionDecision)
    {
        $sessionDecision = SessionDecision::with(["moderator","members","decisions"])
            ->findOrFail($sessionDecision->id);
        return $this->responseSuccess("System/Pages/Actors/sessionDetails",compact("sessionDecision"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SessionDecision  $sessionDecision
     * @return \Illuminate\Http\Response
     */
    public function edit(SessionDecision $sessionDecision)
    {
        $data = SessionDecision::with(["members","moderator"])->find($sessionDecision->id);
        $employees = Employee::query()->select(["id","first_name","last_name"])->get();
        return $this->responseSuccess("System.Pages.Actors.sessionForm",compact("data",'employees'));
    }

    /**
     * @throws MainException
     */
    public function update(SessionDecisionRequest $request, SessionDecision $sessionDecision)
    {
        try {
            DB::beginTransaction();
            $data = Arr::except($request->validated(),["members"]);
            if (isset($data['image'])){
                $image = MyApp::Classes()->storageFiles->Upload($data['image']);
                if (is_bool($image)){
                    MessagesFlash::Errors(__("err_image_upload"));
                    return redirect()->back();
                }
                $data['image'] = $image;
                MyApp::Classes()->storageFiles->deleteFile($sessionDecision->image);
            }
            if (isset($data['file'])){
                $file = MyApp::Classes()->storageFiles->Upload($data['file']);
                if (is_bool($file)){
                    MessagesFlash::Errors(__("err_file_upload"));
                    return redirect()->back();
                }
                $data['file'] = $file;
                MyApp::Classes()->storageFiles->deleteFile($sessionDecision->file);
            }
            $sessionDecision->update($data);
            if (isset($request->members)){
                $sessionDecision->members()->sync($request->members);
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
     * @param  \App\Models\SessionDecision  $sessionDecision
     * @return \Illuminate\Http\Response
     */
    public function destroy(SessionDecision $sessionDecision)
    {
        if (!is_null($sessionDecision->decisions()->first())){
            throw new MainException(__("err_cascade_delete") . "decisions");
        }
        $relatedMembersSession = MemberSessionDecision::query()
            ->where("session_decision_id",$sessionDecision->id)->first();
        if (!is_null($relatedMembersSession)){
            throw new MainException(__("err_cascade_delete") . "member session decision");
        }
        $sessionDecision->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function MultiDelete(Request $request)
    {
        $request->validate([
            "ids" => ["array","required"],
            "ids.*" => ["required",Rule::exists("session_decisions","id")],
        ]);
        foreach ($request->ids as $id){
            $relatedDecision = Decision::query()->where("session_decision_id",$id)->first();
            if (!is_null($relatedDecision)){
                throw new MainException(__("err_cascade_delete") . "decisions");
            }
            $relatedMembersSession = MemberSessionDecision::query()
                ->where("session_decision_id",$id)->first();
            if (!is_null($relatedMembersSession)){
                throw new MainException(__("err_cascade_delete") . "member session decision");
            }
        }
        SessionDecision::query()->whereIn("id",$request->ids)->delete();
        return $this->responseSuccess(null,null,"delete",self::IndexRoute);
    }

    public function ExportXls(BaseRequest $request)
    {
        $data = $this->MainExportData($request);
        return Excel::download(new TableCustomExport($data['head'],$data['body']),self::Folder.".xlsx");
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
            "ids.*" => ["sometimes",Rule::exists("session_decisions","id")],
        ]);
        $query = SessionDecision::with(["moderator"]);
        $query = isset($request->ids) ? $query->whereIn("id",$request->ids) : $query;
        $data = MyApp::Classes()->Search->getDataFilter($query,null,true,"date_session");
        $head = [
            [
                "head"=> "moderator",
                "relationFunc" => "moderator",
                "key" => "name",
            ],
            "name","description","date_session", "created_at",
        ];
        return [
            "head" => $head,
            "body" => $data,
        ];
    }
}
