<?php

namespace App\Http\Controllers;

use App\HelpersClasses\MyApp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class NotificationsController extends Controller
{
    public function getNotifications(Request $request){
        $user = auth()->user();
        $data = match ($request->input("status")) {
            "Read" => $user->readNotifications(),
            "unRead" => $user->unreadNotifications(),
            default => $user->notifications(),
        };
        $data = MyApp::Classes()->Search->dataPaginate($data->whereNot("data->type","audit"));
        return $this->responseSuccess("System/Pages/Actors/notification" ,
            compact("data"));
    }

    public function clearNotifications(){
        auth()->user()->notifications()->delete();
        return $this->responseSuccess(null,null,"delete",MyApp::RouteHome);
    }

    /*
    * @descriptions : Ajax Request -> Work Update Notification To Read
    */
    public function editNotificationsToRead()
    {
        auth()->user()->unreadNotifications()->update([
            "read_at"=>Carbon::now()
        ]);
        return response()->json(["message"=>"Success Read Notification"]);
    }

    /*
    * @descriptions : Ajax Request -> Work Update Notification To Read
    */
    public function removeNotification(Request $request)
    {
        $notify = auth()->user()->notifications()->where("id",$request->id_notify)->first();
        if (!is_null($notify)){
            $notify->delete();
            return response()->json(["message"=>"Success Read Notification"]);
        }
        return response()->json(["error"=>"dont exists id Notification"]);
    }

    public function getNotificationsUpdate(Request $request)
    {
        if (is_null($request->id_notify)){
            $notifications = auth()->user()->notifications()
                ->orderByDesc("created_at")
                ->get();
        }else{
            $notifications = auth()->user()->notifications()
                ->where("id","<",$request->id_notify)
                ->whereNot("data->type","audit")
                ->orderByDesc("created_at")
                ->get();
        }
        return response()->json(["notifications" => $notifications]);
    }

}
