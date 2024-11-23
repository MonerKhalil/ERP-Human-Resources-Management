<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AjaxController extends Controller {

    public function getAllAddressCountry(Request $request) {

        try {
            $request->validate([
                "id_country" => ["required",Rule::exists("countries","id")]
            ]);
            return address($request->id_country);
        }catch (\Exception $exception){
            return response()->json([
                "error" => $exception->getMessage(),
            ],$exception->getCode());
        }

    }

    public function getEmployeesSection(Request $request) {

        try {
            $request->validate([
                "id_section" => ["required",Rule::exists("sections","id")]
            ]);
            return response()->json([
                "data" => Employee::query()->where("section_id",$request->id_section)->get(),
            ]);
        }catch (\Exception $exception){
            return response()->json([
                "error" => $exception->getMessage(),
            ],$exception->getCode());
        }

    }

}
