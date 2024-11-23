<?php

use App\HelpersClasses\MessagesFlash;
use App\Models\Address;
use App\Models\Country;
use Illuminate\Support\Facades\Session;

function FilterDataRequest(){
    return  !is_null(request('filter')) ? request('filter') : [];
}

function Errors($key)
{
    return Session::has(MessagesFlash::$Errors) && isset(Session::get(MessagesFlash::$Errors)[$key])
        ? Session::get(MessagesFlash::$Errors)[$key][0] : null;
}

function Error(){
    return Session::has(MessagesFlash::$err)
        ? Session::get(MessagesFlash::$err) : null;
}

function Success(){
    return Session::has(MessagesFlash::$suc)
        ? Session::get(MessagesFlash::$suc) : null;
}

function PathStorage($path)
{
    return asset('storage/'.$path);
}

function countries(){
    return Country::query()->pluck("country_name","id")->toArray();
}

function address($id_Country){
    return Address::query()->where("country_id",$id_Country)->pluck("name","id")->toArray();
}

function Days(){
    return [
        "Sunday",
        "Monday" ,
        "Tuesday" ,
        "Wednesday",
        "Thursday",
        "Friday" ,
        "Saturday",
    ];
}

function GetNotificationIcon($Type) {
    $NotificationType = new class{} ;
    if($Type == "طلب اجازة .") {
        $NotificationType->Icon = "emoji_food_beverage" ;
        $NotificationType->Color = "Receive" ;
    } else {
        $NotificationType->Icon = "" ;
        $NotificationType->Color = "Send" ;
    }
    return $NotificationType ;
}
