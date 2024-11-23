<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanySettingRequest;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    public function __construct()
    {
        $table = app(CompanySetting::class)->getTable();
        $this->middleware(["permission:read_".$table."|all_".$table])->only(["show"]);
        $this->middleware(["permission:all_".$table])->only(["edit"]);
    }

    public function show(){
        $setting = CompanySetting::query()->first();
        return $this->responseSuccess("System/Pages/Actors/Setting/companySetting"
            ,compact("setting"));
    }

    public function edit(CompanySettingRequest $request){
        $setting = CompanySetting::query()->first();
        $setting->update($request->validated());
        return $this->responseSuccess(null,null,"update",null,true);
    }
}
