<?php

use Illuminate\Support\Facades\Route;

/*===========================================
	=          For Test         =
=============================================*/

Route::get('/Test-11', function () {
    return view('System/Pages/Docs/decisionPrint');
});

Route::get('/Test-10', function () {
    return view('System/Pages/Docs/tablePrint');
});


Route::get('/Test-9', function () {
    return view('System.Pages.Actors.Diwan_User.addSourceDest');
});

Route::get('/Test-14', function () {
    return view('System.Pages.Actors.Diwan_User.addOutgoingCorrespondense');
});

Route::get('/Test-15', function () {
    return view('System/Pages/Actors/Diwan_User/viewCorrespondenses');
});

Route::get('/Test-17', function () {
    return view('System/Pages/Actors/decisionView');
});

Route::get('/Test-30', function () {
    return view('System/Pages/Actors/Vacations/newTypeForm');
});

Route::get('/Test-31', function () {
    return view('System/Pages/Actors/Vacations/vacationTypesView');
});

Route::get('/Test-21', function () {
    return view('System/Pages/Actors/HR_Manager/viewEmployee');
});

Route::get('/Test-32', function () {
    return view('System/Pages/Actors/Vacations/vacationRequest');
});

Route::get('/Test-33', function () {
    return view('System/Pages/Actors/Vacations/vacationsDetails');
});

Route::get('/Test-34', function () {
    return view('System/Pages/Actors/Vacations/myVacationsView');
});

Route::get('/Test-35', function () {
    return view('System/Pages/Actors/Vacations/vacationTypeDetails');
});

Route::get('/Test-36', function () {
    return view('System/Pages/Actors/Vacations/allVacationsView');
});

Route::get('/Test-37', function () {
    return view('System/Pages/Actors/Overtime/newTypeAdd');
});

Route::get('/Test-38', function () {
    return view('System/Pages/Actors/Overtime/newTypeView');
});

Route::get('/Test-39', function () {
    return view('System/Pages/Actors/Overtime/requestOvertimeForm');
});

Route::get('/Test-40', function () {
    return view('System/Pages/Actors/Overtime/requestOvertimeView');
});

Route::get('/Test-41', function () {
    return view('System/Pages/Actors/Overtime/requestOvertimeDetails');
});

Route::get('/Test-42', function () {
    return view('System/Pages/Actors/Reports/reportEmployeesView');
});

Route::get('/Test-43', function () {
    return view('System/Pages/Docs/reportPrint');
});

Route::get('/Test-44', function () {
    return view('System/Pages/Actors/Attendance/addAttendanceRecord');
});

Route::get('/Test-45', function () {
    return view('System/Pages/Actors/Evaluation/newTypeEvaluationView');
});

Route::get('/Test-46', function () {
    return view('System/Pages/Actors/Evaluation/newTypeEvaulationDetails');
});

Route::get('/Test-47', function () {
    return view('System/Pages/Actors/Vacations/vacationAvailableView');
});

Route::get('/Test-50', function () {
    return view('System/Pages/Actors/Evaluation/newTypeEvaluationForm');
});

Route::get('/Test-51', function () {
    return view('System/Pages/Actors/Evaluation/viewDecisionsEmployee');
});

Route::get('/Test-52', function () {
    return view('System/Pages/Actors/Evaluation/viewEvaluationEmployee');
});

Route::get('/Test-53', function () {
    return view('System/Pages/Email/globalPageEmail');
});
