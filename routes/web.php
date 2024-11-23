<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalizationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('xxx', function (Request $request) {
    return response()->view("dashboard");
});

require __DIR__.'/auth.php';
require __DIR__."/WebSite/"."FrontEnd.php";
require __DIR__."/WebSite/"."BackEnd.php";


Route::get("lang/change/{Lang}",[LocalizationController::class,"SwitchLang"])->name("lang.change");
