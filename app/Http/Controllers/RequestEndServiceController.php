<?php

namespace App\Http\Controllers;

use App\Exceptions\MainException;
use App\HelpersClasses\MyApp;
use App\HelpersClasses\Permissions;
use App\Http\Requests\BaseRequest;
use App\Models\DataEndService;
use App\Models\Decision;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\MainNotification;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class RequestEndServiceController extends Controller
{
    public function __construct()
    {
        $table = "request_end_services";
        $this->middleware(["permission:all_".$table])->only(["allRequest"]);
        $this->middleware(["permission:create_".$table."|all_".$table])->only(["create","store"]);
        $this->middleware(["permission:all_".$table])->only(["accept","cancelMultiRequest"]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|null
     * @author moner khalil
     */
    public function allRequest(Request $request){
        $DataEnd = DataEndService::with(["employee","decision"])->where("is_request_end_services",true);
        if (isset($request->filter["name_employee"]) && !is_null($request->filter["name_employee"])){
            $DataEnd->whereHas("employee",function ($q) use ($request){
                $q->where("first_name","Like","%".$request->filter["name_employee"])
                    ->orWhere("last_name","Like","%".$request->filter["name_employee"]);
            });
        }
        if (isset($request->filter["number_decision"]) && !is_null($request->filter["number_decision"])){
            $DataEnd->whereHas("decision",function ($q) use ($request){
                $q->where("number",$request->filter["number_decision"]);
            });
        }
        $data = MyApp::Classes()->Search->getDataFilter($DataEnd);
        return $this->responseSuccess("",compact("data"));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|null
     * @throws AuthorizationException
     * @throws MainException
     * @author moner khalil
     */
    public function showMyRequest($employee = null){
        $userCurrent = auth()->user();
        if (!is_null($employee)){
            if (!$userCurrent->can("all_request_end_services")){
                throw new AuthorizationException(__("err_permission"));
            }
        }
        $employee = !is_null($employee) ? Employee::query()->findOrFail($employee) : auth()->user()->employee;
        if (is_null($employee)){
            throw new MainException("the user is not Employee...");
        }
        $DataEnd = DataEndService::query()->where("employee_id",$employee->id)
            ->where("is_request_end_services",true);
        $data = MyApp::Classes()->Search->getDataFilter($DataEnd);
        return $this->responseSuccess("",compact("data"));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|null
     * @author moner khalil
     */
    public function create(){
        $reason = "resignation";
        return $this->responseSuccess("",compact("reason"));
    }

    /**
     * @param Request $request
     * @author moner khalil
     */
    public function store(Request $request){
        $request->validate([
            "description" => ["required","string"],
            "reason" => ["required","string",Rule::in(["resignation"])]
        ]);
        $user = auth()->user()->employee;
        if (is_null($user)){
            throw new MainException("the user is not Employee...");
        }
        $requestEnd = DataEndService::create([
            "description" => $request->description,
            "reason" => $request->reason,
            "employee_id" => $user->employee->id,
            "is_request_end_services" => true,
            "is_active" => false,
        ]);
        $users = Permissions::getUsersForPermission("all_request_end_services");
        Notification::send($users,new MainNotification([
            "from" => $user->employee->name,
            "date" => now(),
            "route_name" => route("system.request_end_services.show.request",$requestEnd->id),
        ],"request_end_services"));
        return $this->responseSuccess(null,null,"create","show.my.request");
    }

    public function showRequest($request){
        $decision = Decision::query()->pluck("content","id")->toArray();
        $request = DataEndService::query()->findOrFail($request);
        if (!$request->canShow()){
            throw new AuthorizationException(__("err_permission"));
        }
        return $this->responseSuccess("...",compact("request","decision"));
    }

    public function accept(BaseRequest $request,$id_request){
        $id_request = DataEndService::with("employee")->findOrFail($id_request);
        $request->validate([
            "decision_id" => ["required",Rule::exists("decisions","id")],
            "start_break_date" => $request->dateRules(true),
            "end_break_date" => $request->afterDateOrNowRules(true,"start_break_date"),
        ]);
        $user = User::query()->find($id_request->employee->user_id);
        $user->notify(new MainNotification([
            "from" => auth()->user()->name??"-",
            "body" => "accept_request_end_services",
            "date" => now(),
            "route_name" => route("system.request_end_services.show.request",$id_request->id),
        ],"request_end_services"));
        $id_request->update([
                "decision_id" => $request->decision_id,
                "start_break_date" => $request->start_break_date,
                "end_break_date" => $request->end_break_date,
                "is_active" => true,
        ]);
        return $this->responseSuccess(null,null,"default",null,true);
    }

    public function cancelMultiRequest(Request $request){
        $request->validate([
            "ids" => ["required","array"],
            "ids.*" => ["required",Rule::exists("data_end_services","id")],
        ]);
        try {
            DB::beginTransaction();
            $requests = DataEndService::with("employee")->whereIn("id",$request->ids)
                ->where("is_request_end_services",true)->get();
            foreach ($requests as $req){
                $user = User::find($req->employee->user_id);
                $user->notify(new MainNotification([
                    "from" => auth()->user()->name ?? "-",
                    "body" => "cancel_request_end_services",
                    "date" => now(),
                    "route_name" => route("system.request_end_services.show.my.request"),
                ],"request_end_services"));
            }
            DataEndService::query()->whereIn("id",$requests->ids)
                ->where("is_request_end_services",true)->delete();
            DB::commit();
            return $this->responseSuccess(null,null,"delete",null,true);
        }catch (Exception $exception){
            DB::rollBack();
            throw new MainException($exception->getMessage());
        }
    }
}
