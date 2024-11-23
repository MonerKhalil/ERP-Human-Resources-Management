<?php

use App\HelpersClasses\Permissions;

$users = Permissions::ExceptPermissions("users",["export"]);
$roles = Permissions::ExceptPermissions("roles",["export"]);
$employees = Permissions::getPermissions("employees");
$type_decisions = Permissions::ExceptPermissions("type_decisions",["export"]);
$session_decisions = Permissions::getPermissions("session_decisions");
$decisions = Permissions::getPermissions("decisions");
$conferences = Permissions::getPermissions("conferences");
$sections = Permissions::getPermissions("sections");
$positions = Permissions::getPermissions("positions");
$position_employees = Permissions::ExceptPermissions("position_employees",["export"]);
$data_end_services = Permissions::getPermissions("data_end_services");
$request_end_services = Permissions::OnlyPermissions("request_end_services",["create","all","export"]);
$leave_types = Permissions::getPermissions("leave_types");
$leaves = Permissions::getPermissions("leaves");
$company_settings = Permissions::OnlyPermissions("company_settings",["all","read"]);
$work_settings = Permissions::getPermissions("work_settings");
$public_holidays = Permissions::getPermissions("public_holidays");
$overtime_types = Permissions::getPermissions("overtime_types");
$overtimes = Permissions::getPermissions("overtimes");
$section_externals = Permissions::getPermissions("section_externals");
$employee_evaluations = Permissions::getPermissions("employee_evaluations");
$contracts = Permissions::getPermissions("contracts");
$correspondences = Permissions::getPermissions("correspondences");
$correspondence_source_dests = Permissions::getPermissions("correspondence_source_dests");
$languages = Permissions::getPermissions("languages");
$language_skills = Permissions::getPermissions("language_skills");
$membership_types= Permissions::getPermissions("membership_types");
$memberships= Permissions::getPermissions("memberships");
$attendances= Permissions::getPermissions("attendances");
$payrolls = Permissions::OnlyPermissions("payrolls",["all"]);

return array_merge($users,$roles,$employees
,$session_decisions,$type_decisions,$decisions,$sections,
$conferences,$positions,$position_employees,$data_end_services,$request_end_services,
$leave_types,$leaves,$contracts,$correspondences,$correspondence_source_dests,$overtime_types,$overtimes,
$languages,$language_skills,$membership_types,$memberships, $company_settings,$work_settings,$public_holidays,
$section_externals,$employee_evaluations,$attendances,$payrolls,
[
    #addPermissions
    #Example : "read_model"...
]);
