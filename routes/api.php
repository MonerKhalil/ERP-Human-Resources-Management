<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CorrespondenceSourceDestController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LanguageSkillController;
use App\Http\Controllers\MembershipController;
use App\Models\ConferenceEmployee;
use App\Models\Decision;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 *****************************test********************
 */

/*
 *****************************test********************
 */
Route::post("mmm",[\App\Http\Controllers\SectionsController::class,"show"]);
Route::get("xxx",function (){
    $bonusesDecision = ConferenceEmployee::with("conference")
        ->where("employee_id",1)->get()->unique(["employee_id","conference_id"]);
    dd($bonusesDecision);
});

Route::post("xxxc",[CorrespondenceSourceDestController::class,"store"]);
