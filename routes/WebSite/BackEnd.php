<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CorrespondenceController;
use App\Http\Controllers\CorrespondenceSourceDestController;
use App\Http\Controllers\DataEndServiceController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DecisionController;
use App\Http\Controllers\EducationDataController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeEvaluationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageSkillController;
use App\Http\Controllers\LeaveAdminController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\OverTimeAdminController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\OvertimeTypeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\PositionEmployeeController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\PublicHolidayController;
use App\Http\Controllers\ReportEmployeeController;
use App\Http\Controllers\RequestEndServiceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionExternalController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\SessionDecisionController;
use App\Http\Controllers\TypeDecisionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkSettingController;
use App\Models\Leave;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get("", [HomeController::class, "HomeView"])->name("home");
    Route::prefix("user")->controller(ProfileUserController::class)->group(function () {
        /*===========================================
        =         Start Profile User Routes        =
       =============================================*/

        Route::get("profile", "ShowProfile")->name("profile.show");
        Route::post("profile/update", "UpdateProfile")->name('profile.update');

        /*===========================================
        =         End Profile User Routes        =
       =============================================*/


        /*===========================================
        =         Start Notification Routes        =
       =============================================*/

        Route::prefix("notifications")->controller(NotificationsController::class)
            ->group(function () {
                Route::get("show", "getNotifications")->name("notifications.show");
                Route::get("update/get","getNotificationsUpdate")->name("notifications.update");
                Route::delete("clear", "clearNotifications")->name("notifications.clear");
                Route::put("edit/read", "editNotificationsToRead")->name("notifications.edit");
                Route::delete("remove/notify", "removeNotification")->name("notify.remove");
            });
        Route::get("audit/show", [AuditController::class, "AllNotificationsAuditUserShow"])->name("audit.show");
        Route::get("audit/show/{audit}", [AuditController::class, "showAudit"])->name("audit.show.single");

        /*===========================================
        =         End Notification Routes        =
       =============================================*/

    });

    /*===========================================
    =         Start Users Routes        =
   =============================================*/

    Route::resource("users", UserController::class)->except(["edit", "update"]);
    Route::prefix('users')->controller(UserController::class)->group(function () {
        Route::post('export/xlsx', "ExportXls")->name("users.xls");
        Route::post('export/pdf', "ExportPDF")->name("users.pdf");
        Route::post("update/{user}", "update")->name("users.update");
        Route::delete("multi/delete", "MultiUsersDelete")->name("users.multi.delete");
        Route::delete("force_delete/{user}", "forceDelete")->name("users.force_delete");
        Route::delete("multi/force_delete", "MultiUsersForceDelete")->name("users.multi.force_delete");
    });

    /*===========================================
    =         End Users Routes        =
   =============================================*/

    Route::resource("roles", RoleController::class);
    Route::delete("roles/multi/delete", [RoleController::class, "MultiDelete"])->name("roles.multi.delete");
    /*===========================================
        =         Start System Routes        =
   =============================================*/

    Route::prefix("system")->name("system.")->group(function () {
        /*===========================================
            =         Start Settings Routes        =
        =============================================*/

        Route::prefix("company_settings")->name("company_settings.")
            ->controller(CompanySettingController::class)->group(function () {
                Route::get("show", "show")->name("show");
                Route::put("edit", "edit")->name("edit");
            });
        Route::resource("work_settings", WorkSettingController::class);
        Route::prefix("work_settings")->name("work_settings.")
            ->controller(WorkSettingController::class)->group(function () {
                Route::post('export/xlsx', "ExportXls")->name("export.xls");
                Route::post('export/pdf', "ExportPDF")->name("export.pdf");
                Route::delete("multi/delete", "MultiDelete")->name("multi.delete");
            });
        /*===========================================
            =         End Settings Routes        =
        =============================================*/

        /*===========================================
            =         Start Decisions Routes        =
        =============================================*/
        Route::resource('type_decisions', TypeDecisionController::class)->except([
            "show"
        ]);
        Route::delete("type_decisions/multi/delete", [TypeDecisionController::class, "MultiDelete"])->name("type_decisions.multi.delete");
        Route::resource('session_decisions', SessionDecisionController::class);
        Route::prefix("session_decisions")->name("session_decisions.")
            ->controller(SessionDecisionController::class)->group(function () {
                Route::post('export/xlsx', "ExportXls")->name("export.xls");
                Route::post('export/pdf', "ExportPDF")->name("export.pdf");
                Route::delete("multi/delete", "MultiDelete")->name("multi.delete");
            });
        Route::resource('decisions', DecisionController::class)->except(["update"]);
        Route::post("decisions/{decision}", [DecisionController::class, "update"])->name("decisions.update");
        Route::prefix("decisions")->name("decisions.")
            ->controller(DecisionController::class)->group(function () {
                Route::get("print/pdf/{decision}", "PrintDecision")->name("print.pdf");
                Route::post('export/xlsx', "ExportXls")->name("export.xls");
                Route::post('export/pdf', "ExportPDF")->name("export.pdf");
                Route::delete("multi/delete", "MultiDelete")->name("multi.delete");
            });
        Route::get("decisions/create/session_decisions/{session_decisions}", [DecisionController::class, "addDecisions"])->name("decisions.session_decisions.add");
        Route::get("decisions/show/session_decisions/{session_decisions}", [DecisionController::class, "showDecisionsSession"])->name("decisions.session_decisions.show");

        /*===========================================
            =         End Decisions Routes        =
       =============================================*/
        Route::resource('conferences', ConferenceController::class);
        Route::prefix("conferences")->name("conferences.")
            ->controller(ConferenceController::class)->group(function () {
                Route::get('{employee}', "EmployeeConference")->name("show.employee");
                Route::post('export/xlsx', "ExportXls")->name("export.xls");
                Route::post('export/pdf', "ExportPDF")->name("export.pdf");
                Route::delete("multi/delete", "MultiDelete")->name("multi.delete");
            });

        Route::resource('sections', SectionsController::class);
        Route::prefix("sections")->name("sections.")
            ->controller(SectionsController::class)->group(function () {
                Route::post('export/xlsx', "ExportXls")->name("export.xls");
                Route::post('export/pdf', "ExportPDF")->name("export.pdf");
                Route::delete("multi/delete", "MultiDelete")->name("multi.delete");
            });

        Route::resource('section_externals', SectionExternalController::class);
        Route::prefix("section_externals")->name("section_externals.")
            ->controller(SectionExternalController::class)->group(function () {
                Route::post('export/xlsx', "ExportXls")->name("export.xls");
                Route::post('export/pdf', "ExportPDF")->name("export.pdf");
                Route::delete("multi/delete", "MultiDelete")->name("multi.delete");
            });

        Route::prefix("request_end_services")->name("request_end_services.")
            ->controller(RequestEndServiceController::class)->group(function () {
                Route::get("all", "allRequest")->name("index");
                Route::get("show/my/requests/{employee?}", "showMyRequest")->name("show.my.request");
                Route::get("create", "create")->name("create");
                Route::post("store", "store")->name("store");
                Route::get("show/{request}", "showRequest")->name("show.request");
                Route::post("accept/{id_request}", "accept")->name("accept.request");
                Route::delete("cancel/multi", "cancelMultiRequest")->name("multi.cancel.request");
            });

        Route::resource('data_end_services', DataEndServiceController::class);
        Route::prefix("data_end_services")->name("data_end_services.")
            ->controller(DataEndServiceController::class)->group(function () {
                Route::get("add/employee/{employee}", "createFromEmployee")->name("employee.create");
                Route::post('export/xlsx', "ExportXls")->name("export.xls");
                Route::post('export/pdf', "ExportPDF")->name("export.pdf");
                Route::delete("multi/delete", "MultiDelete")->name("multi.delete");
            });

        Route::resource('positions', PositionController::class)->except("show");
        Route::prefix("positions")->name("positions.")
            ->controller(PositionController::class)->group(function () {
                Route::post('export/xlsx', "ExportXls")->name("export.xls");
                Route::post('export/pdf', "ExportPDF")->name("export.pdf");
                Route::delete("multi/delete", "MultiDelete")->name("multi.delete");
            });

        Route::resource('public_holidays', PublicHolidayController::class)->except("show");
        Route::prefix("public_holidays")->name("public_holidays.")
            ->controller(PublicHolidayController::class)->group(function () {
                Route::post('export/xlsx', "ExportXls")->name("export.xls");
                Route::post('export/pdf', "ExportPDF")->name("export.pdf");
                Route::delete("multi/delete", "MultiDelete")->name("multi.delete");
            });

        Route::resource('position_employees', PositionEmployeeController::class);
        Route::prefix("position_employees")->name("position_employees.")
            ->controller(PositionEmployeeController::class)->group(function () {
                Route::delete("multi/delete", "MultiDelete")->name("multi.delete");
            });

        Route::resource('overtime_types', OvertimeTypeController::class);
        Route::delete("overtime_types/multi/delete", [OvertimeTypeController::class, "MultiDelete"])->name("overtime_types.multi.delete");

        Route::resource('overtimes_admin', OverTimeAdminController::class)->except(["show", "edit"]);
        Route::prefix("overtimes_admin")->name("overtimes_admin.")
            ->controller(OverTimeAdminController::class)->group(function () {
                Route::post('export/xlsx', "ExportXls")->name("export.xls");
                Route::post('export/pdf', "ExportPDF")->name("export.pdf");
                Route::delete("multi/delete", "MultiDelete")->name("multi.delete");
                Route::post("status/change/overtimes/{status}", "changeStatus")
                    ->whereIn("status", ["approve", "reject"])
                    ->name("overtime.status.change");
            });

        Route::prefix("overtimes")->name("overtimes.")
            ->controller(OvertimeController::class)->group(function () {
                Route::get("all/{status?}", "ShowOvertimes")
                    ->whereIn("status", Leave::status())
                    ->name("all.status");
                Route::get("show/{overtime}", "Show")->name("show.overtime");
                Route::get("edit/{overtime}", "Edit")->name("edit.overtime");
                Route::put("update/{overtime}", "updateRequestOvertime")->name("update.overtime");
                Route::get("request/create", "createRequestOvertime")->name("create.request");
                Route::post("request/store", "Store")->name("store.request");
                Route::delete("request/delete/{overtime}", "Destroy")->name("remove.request");
                Route::delete("request/delete/multi", "MultiDestroy")->name("remove.multi.request");
            });


        /*===========================================
            =         Start Employees Routes        =
       =============================================*/

        Route::resource('employees', EmployeeController::class)->except([
            "show", "edit", "update",
        ]);
        #Report
        Route::get("employees/report", [ReportEmployeeController::class, "showCreateReport"])->name("employees.report");
        Route::get("employees/report/final", [ReportEmployeeController::class, "Report"])->name("employees.report.final");
        Route::post("employees/report/xlsx", [ReportEmployeeController::class, "ReportXlsx"])->name("employees.report.xlsx");
        Route::post("employees/report/pdf", [ReportEmployeeController::class, "ReportPdf"])->name("employees.report.pdf");
        #Print Pdf and Xlsx
        Route::post('employees/export/xlsx', [EmployeeController::class, "ExportXls"])->name("employees.export.xls");
        Route::post('employees/export/pdf', [EmployeeController::class, "ExportPDF"])->name("employees.export.pdf");
        Route::delete("employees/multi/delete", [EmployeeController::class, "MultiDelete"])->name("employees.multi.delete");
        Route::get("employees/show/{employee?}", [EmployeeController::class, "show"])->name("employees.show");
        Route::get("employees/edit/{employee?}", [EmployeeController::class, "edit"])->name("employees.edit");
        Route::post("employees/update/{employee?}", [EmployeeController::class, "update"])->name("employees.update");
        #contact_data
        Route::post("employees/edit/contact/{contact}", [ContactController::class, "updateContact"])->name("employees.contact.update");
        Route::post("employees/add/contact_document/{contact}", [ContactController::class, "addContactDocument"])->name("employees.contact_document.add");
        Route::post("employees/edit/contact_document/{contact_document}", [ContactController::class, "updateContactDocument"])->name("employees.contact_document.update");
        #education_data
        Route::post("employees/edit/education_data/{education_data}", [EducationDataController::class, "updateEducationData"])->name("employees.education_data.update");
        Route::post("employees/add/education_document/{education_data}", [EducationDataController::class, "addEducationDocument"])->name("employees.education_document.add");
        Route::post("employees/edit/education_document/{education_document}", [EducationDataController::class, "updateContactDocument"])->name("employees.education_document.update");
        /*===========================================
            =         End Employees Routes        =
       =============================================*/

        /*===========================================
        =            Start Leaves Routes        =
        =============================================*/

        Route::resource('leave_types', LeaveTypeController::class);
        Route::prefix("leave_types")->name("leave_types.")
            ->controller(LeaveTypeController::class)->group(function () {
                Route::post('export/xlsx', "ExportXls")->name("export.xls");
                Route::post('export/pdf', "ExportPDF")->name("export.pdf");
                Route::delete("multi/delete", "MultiDelete")->name("multi.delete");
            });
        Route::resource('leaves_admin', LeaveAdminController::class)->except(["show", "edit"]);
        Route::prefix("leaves_admin")->name("leaves_admin.")
            ->controller(LeaveAdminController::class)->group(function () {
                Route::post('export/xlsx', "ExportXls")->name("export.xls");
                Route::post('export/pdf', "ExportPDF")->name("export.pdf");
                Route::delete("multi/delete", "MultiDelete")->name("multi.delete");
                Route::post("status/change/leaves/{status}", "changeStatus")
                    ->whereIn("status", ["approve", "reject"])
                    ->name("leave.status.change");
            });
        Route::prefix("leaves")->name("leaves.")
            ->controller(LeaveController::class)->group(function () {
                Route::get("all/{status?}", "ShowLeaves")
                    ->whereIn("status", Leave::status())
                    ->name("all.status");
                Route::get("show/{leave}", "Show")->name("show.leave");
                Route::get("edit/{leave}", "Edit")->name("edit.leave");
                Route::put("update/{leave}", "updateRequestLeave")->name("update.leave");
                Route::get("request/create", "createRequestLeave")->name("create.request");
                Route::post("request/store", "Store")->name("store.request");
                Route::delete("request/delete/{leave}", "Destroy")->name("remove.request");
                Route::delete("request/delete/multi", "MultiDestroy")->name("remove.multi.request");
                Route::get("show/leaves_type/action/count", "LeavesTypeShow")->name("show.leavesType");
                Route::get("count/leaves/{leave_type}", "CountLeavesByType")->name("show.count.leave.leaveType");
            });

        /*===========================================
        =        End Leaves Routes         =
       =============================================*/

        /*===========================================
        =        Start Evaluation Employee Routes         =
       =============================================*/

        Route::prefix("evaluation/employee")->name("evaluation.employee.")->controller(EmployeeEvaluationController::class)
        ->group(function (){
            Route::get("show/all","index")->name("index");
            Route::get("show/{evaluation}","showEvaluation")->name("show.evaluation");
            Route::get("show/{evaluation}/details","showEvaluationDetails")->name("show.evaluation.details");
            Route::get("show/{evaluation}/decisions","showEvaluationDecisions")->name("show.evaluation.decisions");
            Route::get("create","create")->name("create");
            Route::post("store","store")->name("store");
            Route::get("show/add/employee/{evaluation}","showEvaluationAdd")->name("show.add.evaluation");
            Route::post("store/employee/{evaluation}","storeEvaluationAdd")->name("store.evaluation");
            Route::get("show/add/decision/{evaluation}","addDecisionEvaluationShowPage")->name("show.add.decision.evaluation");
            Route::post("store/decision","storeDecisionEvaluation")->name("store.decision.evaluation");
            Route::delete("destroy/{evaluation}","destroy")->name("destroy.evaluation");
            Route::delete("multi/destroy/evaluation","MultiDelete")->name("multi.destroy.evaluation");
        });

        /*===========================================
        =        End Evaluation Employee Routes         =
       =============================================*/


        /*===========================================
        =        Start Attendance Employee Routes         =
       =============================================*/

        Route::prefix("attendances")->name("attendances.")
            ->controller(AttendanceController::class)->group(function () {
                Route::get("create","create")->name("create");
                Route::post("store/{type}","store")->name("store.type")
                    ->whereIn("type",["check_in","check_out"]);
                Route::get("all/employees","index")->name("index");
                Route::get("all/employee","employeeAttendances")->name("employee");
                Route::post('export/xlsx', "ExportXls")->name("export.xls");
                Route::post('export/pdf', "ExportPDF")->name("export.pdf");
                Route::delete("multi/delete", "MultiDelete")->name("multi.delete");
                Route::delete("delete/{attendance}", "destroy")->name("delete");
            });

        /*===========================================
        =        End Attendance Employee Routes         =
       =============================================*/


        /*===========================================
        =        Start Payroll Employee Routes         =
       =============================================*/

        Route::prefix("payroll")->name("payroll.")
            ->controller(PayrollController::class)->group(function (){
                Route::get("salary/me","salaryDetails")->name("salary.me");
                Route::get("salary/{employee}","salaryDetailsEmployee")->name("salary.employee");
                Route::post('export/xlsx', "ExportXls")->name("export.xls");
                Route::post('export/pdf', "ExportPDF")->name("export.pdf");
            });

        /*===========================================
        =        End Payroll Employee Routes         =
       =============================================*/


        /*===========================================
           =        contract languageSkill membership Routes        =
          =============================================*/
        Route::group(['as' => 'employees.',], function () {
            Route::resource('contract', ContractController::class)->except([
                "show", "edit", "update",
            ]);
            Route::resource('languageSkill', LanguageSkillController::class)->except([
                "show", "edit", "update",
            ]);
            Route::resource('membership', MembershipController::class)->except([
                "show", "edit", "update",
            ]);
        });

        Route::get("contract/show/{contract}", [ContractController::class, "show"])->name("employees.contract.show");
        Route::get("contract/edit/{contract}", [ContractController::class, "edit"])->name("employees.contract.edit");
        Route::post("contract/update/{contract}", [ContractController::class, "update"])->name("employees.contract.update");
        Route::delete("contract/multi/delete", [ContractController::class, "MultiContractsDelete"])->name("employees.contract.multi.delete");
        Route::post('contract/export/xlsx', [ContractController::class, "ExportXls"])->name("employees.contract.export.xls");
        Route::post('contract/export/pdf', [ContractController::class, "ExportPDF"])->name("employees.contract.export.pdf");

        Route::get("languageSkill/show/{languageSkill?}", [LanguageSkillController::class, "show"])->name("employees.languageSkill.show");
        Route::get("languageSkill/edit/{languageSkill?}", [LanguageSkillController::class, "edit"])->name("employees.languageSkill.edit");
        Route::post("languageSkill/update/{languageSkill?}", [LanguageSkillController::class, "update"])->name("employees.languageSkill.update");
        Route::delete("languageSkill/multi/delete", [LanguageSkillController::class, "MultiLanguageDelete"])->name("employees.languageSkill.multi.delete");
        Route::post('export/xlsx', [LanguageSkillController::class, "ExportXls"])->name("employees.languageSkill.export.xls");
        Route::post('export/pdf', [LanguageSkillController::class, "ExportPDF"])->name("employees.languageSkill.export.pdf");

        Route::get("membership/show/{membership?}", [MembershipController::class, "show"])->name("employees.membership.show");
        Route::get("membership/edit/{membership?}", [MembershipController::class, "edit"])->name("employees.membership.edit");
        Route::post("membership/update/{membership?}", [MembershipController::class, "update"])->name("employees.membership.update");
        Route::delete("membership/multi/delete", [MembershipController::class, "MultiMembershipDelete"])->name("employees.membership.multi.delete");
        Route::post('export/xlsx', [MembershipController::class, "ExportXls"])->name("employees.membership.export.xls");
        Route::post('export/pdf', [MembershipController::class, "ExportPDF"])->name("employees.membership.export.pdf");

        Route::get('contract/data/trash', [ContractController::class, 'trash'])
            ->name('employees.contract.trash');
        Route::put('contract/{contract}/restore', [ContractController::class, 'restore'])
            ->name('employees.contract.restore');
        Route::delete('contract/{contract}/force-delete', [ContractController::class, 'forceDelete'])
            ->name('employees.contract.force-delete');

        Route::get('language/data/trash', [LanguageSkillController::class, 'trash'])
            ->name('employees.language_skill.trash');
        Route::put('language/{language}/restore', [LanguageSkillController::class, 'restore'])
            ->name('employees.language_skill.restore');
        Route::delete('language/{language}/force-delete', [LanguageSkillController::class, 'forceDelete'])
            ->name('employees.language_skill.force-delete');

        Route::get('membership/data/trash', [MembershipController::class, 'trash'])
            ->name('membership.trash');
        Route::put('membership/{membership}/restore', [MembershipController::class, 'restore'])
            ->name('membership.restore');
        Route::delete('membership/{membership}/force-delete', [MembershipController::class, 'forceDelete'])
            ->name('membership.force-delete');
    });

    Route::resource('correspondences', CorrespondenceController::class);
    Route::prefix("correspondences")->name("correspondences.")
        ->controller(CorrespondenceController::class)->group(function () {
            Route::post('export/xlsx', "ExportXls")->name("export.xls");
            Route::post('export/pdf', "ExportPDF")->name("export.pdf");
            Route::delete("multi/delete", "MultiDelete")->name("multi.delete");
        });
    Route::resource('correspondences_dest', CorrespondenceSourceDestController::class)->except("edit", "update",);
    Route::get("transaction/create/correspondences_dest/{correspondences_id}", [CorrespondenceSourceDestController::class, "addTransaction"])->name("transaction.correspondences_dest.add");
    Route::post("transaction/send/legalopinion/{correspondences_id}", [LegalController::class, "sendLegalOpinion"])->name("transaction.legalopinion.send");//the bottom send correspndence to legal section
    Route::put("transaction/add/legalopinion", [LegalController::class, "addLegalOpinion"])->name("transaction.legalopinion.add");


    /*===========================================
    =         End System Routes        =
   =============================================*/

    Route::get("file/download", function (\Illuminate\Http\Request $request) {
        $request->validate(["file" => ["required", "url"]]);
        return \App\HelpersClasses\MyApp::Classes()->storageFiles->downloadFile($request->file);
    })->name("file.download");
    /*===========================================
    =         Start Ajax Routes        =
   =============================================*/

    Route::prefix("ajax")->controller(AjaxController::class)->group(function () {
        Route::get("get/address", "getAllAddressCountry")->name("get.address");
        Route::get("get/employee", "getEmployeesSection")->name("get.employee");
    });

    /*===========================================
    =         End Ajax Routes        =
   =============================================*/
});
