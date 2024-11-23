<?php
$MyAccount = auth()->user();
$MyAccount = auth()->user();
$IsUserEmployee = !is_null($MyAccount->employee["id"]);
$IsHavePermissionRoleRead = $MyAccount->can("read_roles") || $MyAccount->can("all_roles");
$IsHavePermissionRoleCreate = $MyAccount->can("create_roles") || $MyAccount->can("all_roles");
$IsHavePermissionUsersRead = $MyAccount->can("read_users") || $MyAccount->can("all_users");
$IsHavePermissionUsersCreate = $MyAccount->can("create_users") || $MyAccount->can("all_users");
$IsHavePermissionSessionCreate = $MyAccount->can("create_session_decisions") || $MyAccount->can("all_session_decisions");
$IsHavePermissionSessionRead = $MyAccount->can("read_session_decisions") || $MyAccount->can("all_session_decisions");
$IsHavePermissionEvaluationCreate = $MyAccount->can("create_employee_evaluations") || $MyAccount->can("all_employee_evaluations");
$IsHavePermissionEvaluationRead = $MyAccount->can("read_employee_evaluations") || $MyAccount->can("all_employee_evaluations");
$IsHavePermissionSessionExRead = $MyAccount->can("read_section_externals") || $MyAccount->can("all_section_externals");
$IsHavePermissionSessionExCreate = $MyAccount->can("create_section_externals") || $MyAccount->can("all_section_externals");
$IsHavePermissionSessionInCreate = $MyAccount->can("create_sections") || $MyAccount->can("all_sections");
$IsHavePermissionSessionInRead = $MyAccount->can("read_sections") || $MyAccount->can("all_sections");
$IsHavePermissionPublicHolidayCreate = $MyAccount->can("create_public_holidays") || $MyAccount->can("all_public_holidays");
$IsHavePermissionPublicHolidayRead = $MyAccount->can("read_public_holidays") || $MyAccount->can("all_public_holidays");
$IsHavePermissionAttendanceRead = $MyAccount->can("read_attendances") || $MyAccount->can("all_attendances");
$IsHavePermissionReportCreate = $MyAccount->can("create_employees") || $MyAccount->can("all_employees");
$IsHavePermissionCompanySettingRead = $MyAccount->can("read_company_settings") || $MyAccount->can("all_company_settings");
$IsHavePermissionWorkSettingCreate = $MyAccount->can("create_work_settings") || $MyAccount->can("all_work_settings");
$IsHavePermissionWorkSettingRead = $MyAccount->can("read_work_settings") || $MyAccount->can("all_work_settings");
$IsHavePermissionVacationTypeRead = $MyAccount->can("read_leave_types") || $MyAccount->can("all_leave_types");
$IsHavePermissionVacationTypeCreate = $MyAccount->can("create_leave_types") || $MyAccount->can("all_leave_types");
$IsHavePermissionVacationCreate = $MyAccount->can("create_leaves") || $MyAccount->can("all_leaves");
$IsHavePermissionVacationRead = $MyAccount->can("read_leaves") || $MyAccount->can("all_leaves");
$IsHavePermissionOverTimeTypeRead = $MyAccount->can("read_overtime_types") || $MyAccount->can("all_overtime_types");
$IsHavePermissionOverTimeTypeCreate = $MyAccount->can("create_overtime_types") || $MyAccount->can("all_overtime_types");
$IsHavePermissionOverTimeCreate = $MyAccount->can("create_overtimes") || $MyAccount->can("all_overtimes");
$IsHavePermissionOverTimeRead = $MyAccount->can("read_overtimes") || $MyAccount->can("all_overtimes");
$IsHavePermissionDecisionTypeCreate = $MyAccount->can("create_type_decisions") || $MyAccount->can("all_type_decisions");
$IsHavePermissionDecisionTypeRead = $MyAccount->can("read_type_decisions") || $MyAccount->can("all_type_decisions");

$IsHavePermissionEmployeeCreate = $MyAccount->can("create_employees") || $MyAccount->can("all_employees");
$IsHavePermissionEmployeeRead = $MyAccount->can("read_employees") || $MyAccount->can("all_employees");
$IsHavePermissionContractsCreate = $MyAccount->can("create_contracts") || $MyAccount->can("all_contracts");
$IsHavePermissionContractsRead = $MyAccount->can("read_contracts") || $MyAccount->can("all_contracts");
$IsHavePermissionCoursesCreate = $MyAccount->can("create_conferences") || $MyAccount->can("all_conferences");
$IsHavePermissionCoursesRead = $MyAccount->can("read_conferences") || $MyAccount->can("all_conferences");
$IsHavePermissionEofCreate = $MyAccount->can("create_data_end_services") || $MyAccount->can("all_data_end_services");
$IsHavePermissionEofRead = $MyAccount->can("read_data_end_services") || $MyAccount->can("all_data_end_services");
$IsHavePermissionCorrespondenceCreate = $MyAccount->can("create_correspondences") || $MyAccount->can("all_correspondences");
$IsHavePermissionCorrespondenceRead = $MyAccount->can("read_correspondences") || $MyAccount->can("all_correspondences");

?>

<nav class="NavigationsMenu Open">
    <div class="NavigationsMenu__Wrap">
        <div class="NavigationsMenu__Content">
            <header class="NavigationsMenu__Header">
                <div class="Logo">
                    <a href="#" title="ERP Epic">
                        <img src="{{asset("System/Assets/Images/Logo.png")}}"
                             alt="#" class="Logo__Image">
                        <span class="Logo__SystemName">ERP Epic</span>
                    </a>
                </div>
                <i class="material-icons IconClick NavigationsMenu__CloseMenu">close</i>
            </header>
            <main class="NavigationsMenu__Navigations">
                <ul class="NavigationsMenu__NavigationsGroup">
                    <li class="NavigationsGroup__Title">
                        <span class="Title">@lang("main")</span>
                    </li>
                    <li class="NavigationsGroup__NavItem">
                        <div class="Title">
                            <a href="{{route("home")}}" class="NavName">
                                <i class="material-icons Icon">
                                    home
                                </i>
                                <span class="Label">@lang("HomePage")</span>
                            </a>
                        </div>
                    </li>
                </ul>
                <ul class="NavigationsMenu__NavigationsGroup">
                    <li class="NavigationsGroup__Title">
                        <span class="Title">@lang("admin")</span>
                    </li>
                    <li class="NavigationsGroup__NavItem">
                        <div class="Title">
                            <a href="{{route("audit.show")}}" class="NavName">
                                <i class="material-icons Icon">
                                    track_changes
                                </i>
                                <span class="Label">@lang("auditTrack")</span>
                            </a>
                        </div>
                    </li>
                    @if($IsHavePermissionRoleRead && $IsHavePermissionRoleCreate)
                        <li class="NavigationsGroup__GroupItem">
                            <div class="Title">
                                <div class="NavName">
                                    <i class="material-icons Icon">
                                        grade
                                    </i>
                                    <span class="Label">@lang("roles")</span>
                                </div>
                                <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                            </div>
                            <ul class="NavigationsGroup__SubItems">
                                @if($IsHavePermissionRoleRead)
                                    <li class="NavigationsGroup__NavItem">
                                        <div class="Title">
                                            <a href="{{route("roles.index")}}" class="NavName">
                                                <span class="Label">@lang("viewRoles")</span>
                                            </a>
                                        </div>
                                    </li>
                                @endif
                                @if($IsHavePermissionRoleCreate)
                                    <li class="NavigationsGroup__NavItem">
                                        <div class="Title">
                                            <a href="{{route("roles.create")}}" class="NavName">
                                                <span class="Label">@lang("addRole")</span>
                                            </a>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if($IsHavePermissionUsersRead && $IsHavePermissionUsersCreate)
                        <li class="NavigationsGroup__GroupItem">
                            <div class="Title">
                                <div class="NavName">
                                    <i class="material-icons Icon">
                                        group
                                    </i>
                                    <span class="Label">@lang("users")</span>
                                </div>
                                <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                            </div>
                            <ul class="NavigationsGroup__SubItems">
                                @if($IsHavePermissionUsersRead)
                                    <li class="NavigationsGroup__NavItem">
                                        <div class="Title">
                                            <a href="{{route("users.index")}}" class="NavName">
                                                <span class="Label">@lang("viewUsers")</span>
                                            </a>
                                        </div>
                                    </li>
                                @endif
                                @if($IsHavePermissionUsersCreate)
                                    <li class="NavigationsGroup__NavItem">
                                        <div class="Title">
                                            <a href="{{route("users.create")}}" class="NavName">
                                                <span class="Label">@lang("addUser")</span>
                                            </a>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                </ul>
                <ul class="NavigationsMenu__NavigationsGroup">
                    <li class="NavigationsGroup__Title">
                        <span class="Title">@lang("resumeSection")</span>
                    </li>

                    <li class="NavigationsGroup__GroupItem">
                        <div class="Title">
                            <div class="NavName">
                                <i class="material-icons Icon">
                                    badge
                                </i>
                                <span class="Label">@lang("employees")</span>
                            </div>
                            <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                        </div>
                        <ul class="NavigationsGroup__SubItems">
                            @if($IsHavePermissionEmployeeRead)
                                <li class="NavigationsGroup__NavItem">
                                    <div class="Title">
                                        <a href="{{route("system.employees.index")}}" class="NavName">
                                            <span class="Label">@lang("viewEmployees")</span>
                                        </a>
                                    </div>
                                </li>
                            @endif
                            @if($IsHavePermissionEmployeeCreate)
                                <li class="NavigationsGroup__NavItem">
                                    <div class="Title">
                                        <a href="{{route("system.employees.create")}}" class="NavName">
                                            <span class="Label">@lang("addEmployee")</span>
                                        </a>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>
                    <li class="NavigationsGroup__GroupItem">
                        <div class="Title">
                            <div class="NavName">
                                <i class="material-icons Icon">
                                    description
                                </i>
                                <span class="Label">@lang("contracts")</span>
                            </div>
                            <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                        </div>
                        <ul class="NavigationsGroup__SubItems">
                            @if($IsHavePermissionContractsRead)
                                <li class="NavigationsGroup__NavItem">
                                    <div class="Title">
                                        <a href="{{route("system.employees.contract.index")}}" class="NavName">
                                            <span class="Label">@lang("viewContracts")</span>
                                        </a>
                                    </div>
                                </li>
                            @endif
                            @if($IsHavePermissionContractsCreate)
                                <li class="NavigationsGroup__NavItem">
                                    <div class="Title">
                                        <a href="{{route("system.employees.contract.create")}}" class="NavName">
                                            <span class="Label">@lang("addContract")</span>
                                        </a>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>
                    <li class="NavigationsGroup__GroupItem">
                        <div class="Title">
                            <div class="NavName">
                                <i class="material-icons Icon">
                                    menu_book
                                </i>
                                <span class="Label">@lang("courses")</span>
                            </div>
                            <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                        </div>
                        <ul class="NavigationsGroup__SubItems">
                            @if($IsHavePermissionCoursesRead)
                                <li class="NavigationsGroup__NavItem">
                                    <div class="Title">
                                        <a href="{{route("system.conferences.index")}}" class="NavName">
                                            <span class="Label">@lang("viewCourses")</span>
                                        </a>
                                    </div>
                                </li>
                            @endif
                            @if($IsHavePermissionCoursesCreate)
                                <li class="NavigationsGroup__NavItem">
                                    <div class="Title">
                                        <a href="{{route("system.conferences.create")}}" class="NavName">
                                            <span class="Label">@lang("addCourse")</span>
                                        </a>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>
                    <li class="NavigationsGroup__GroupItem">
                        <div class="Title">
                            <div class="NavName">
                                <i class="material-icons Icon">
                                    description
                                </i>
                                <span class="Label">@lang("EmployeesEOF")</span>
                            </div>
                            <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                        </div>
                        <ul class="NavigationsGroup__SubItems">
                            @if($IsHavePermissionEofRead)
                                <li class="NavigationsGroup__NavItem">
                                    <div class="Title">
                                        <a href="{{route("system.data_end_services.index")}}" class="NavName">
                                            <span class="Label">@lang("viewEOF")</span>
                                        </a>
                                    </div>
                                </li>
                            @endif
                            @if($IsHavePermissionEofCreate)
                                <li class="NavigationsGroup__NavItem">
                                    <div class="Title">
                                        <a href="{{route("system.data_end_services.create")}}" class="NavName">
                                            <span class="Label">@lang("addEOF")</span>
                                        </a>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @if($IsHavePermissionSessionRead || $IsHavePermissionSessionCreate)
                        <li class="NavigationsGroup__GroupItem">
                            <div class="Title">
                                <div class="NavName">
                                    <i class="material-icons Icon">
                                        groups_2
                                    </i>
                                    <span class="Label">@lang("decisionsSession")</span>
                                </div>
                                <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                            </div>
                            <ul class="NavigationsGroup__SubItems">
                                @if($IsHavePermissionSessionRead)
                                    <li class="NavigationsGroup__NavItem">
                                        <div class="Title">
                                            <a href="{{route("system.session_decisions.index")}}" class="NavName">
                                                <span class="Label">@lang("viewSessions")</span>
                                            </a>
                                        </div>
                                    </li>
                                @endif
                                @if($IsHavePermissionSessionCreate)
                                    <li class="NavigationsGroup__NavItem">
                                        <div class="Title">
                                            <a href="{{route("system.session_decisions.create")}}" class="NavName">
                                                <span class="Label">@lang("addSession")</span>
                                            </a>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if($IsHavePermissionDecisionTypeCreate || $IsHavePermissionDecisionTypeRead)
                        <li class="NavigationsGroup__GroupItem">
                            <div class="Title">
                                <div class="NavName">
                                    <i class="material-icons Icon">
                                        note_add
                                    </i>
                                    <span class="Label">@lang("DecisionType")</span>
                                </div>
                                <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                            </div>
                            <ul class="NavigationsGroup__SubItems">
                                @if($IsHavePermissionDecisionTypeRead)
                                    <li class="NavigationsGroup__NavItem">
                                        <div class="Title">
                                            <a href="{{route("system.type_decisions.index")}}" class="NavName">
                                                <span class="Label">@lang("ViewAllDecisionType")</span>
                                            </a>
                                        </div>
                                    </li>
                                @endif
                                @if($IsHavePermissionDecisionTypeCreate)
                                    <li class="NavigationsGroup__NavItem">
                                        <div class="Title">
                                            <a href="{{route("system.type_decisions.create")}}" class="NavName">
                                                <span class="Label">@lang("CreateNewDecisionType")</span>
                                            </a>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if($IsHavePermissionEvaluationCreate || $IsHavePermissionEvaluationRead)
                        <li class="NavigationsGroup__GroupItem">
                            <div class="Title">
                                <div class="NavName">
                                    <i class="material-icons Icon">
                                        edit_note
                                    </i>
                                    <span class="Label">@lang("Evaluations")</span>
                                </div>
                                <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                            </div>
                            <ul class="NavigationsGroup__SubItems">
                                <li class="NavigationsGroup__NavItem">
                                    <div class="Title">
                                        @if($IsHavePermissionEvaluationCreate)
                                            <a href="{{ route("system.evaluation.employee.create") }}" class="NavName">
                                                <!-- User -->
                                                <span class="Label">
                                                @lang("CreateNewEmployeeEvaluation")
                                            </span>
                                            </a>
                                        @endif
                                        @if($IsHavePermissionEvaluationRead)
                                            <a href="{{ route("system.evaluation.employee.index") }}" class="NavName">
                                                <!-- User -->
                                                <span class="Label">
                                                @lang("ViewAllEmployeeAdded")
                                            </span>
                                            </a>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if($IsHavePermissionSessionInCreate || $IsHavePermissionSessionInRead ||
                        $IsHavePermissionSessionExCreate || $IsHavePermissionSessionExRead)
                        <li class="NavigationsGroup__GroupItem">
                            <div class="Title">
                                <div class="NavName">
                                    <i class="material-icons Icon">
                                        meeting_room
                                    </i>
                                    <span class="Label">@lang("departments")</span>
                                </div>
                                <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                            </div>
                            <ul class="NavigationsGroup__SubItems">
                                <li class="NavigationsGroup__NavItem">
                                    <div class="Title">
                                        @if($IsHavePermissionSessionInCreate)
                                            <a href="{{ route("system.sections.create") }}" class="NavName">
                                                <!-- User -->
                                                <span class="Label">
                                                @lang("addNewSection")
                                            </span>
                                            </a>
                                        @endif
                                        @if($IsHavePermissionSessionInRead)
                                            <a href="{{ route("system.sections.index") }}" class="NavName">
                                                <!-- User -->
                                                <span class="Label">
                                                @lang("viewAllDepartments")
                                            </span>
                                            </a>
                                        @endif
                                        @if($IsHavePermissionSessionExCreate)
                                            <a href="{{ route("system.section_externals.create") }}" class="NavName">
                                                <!-- User -->
                                                <span class="Label">
                                                    اضافة قسم خارجي جديد
                                                </span>
                                            </a>
                                        @endif
                                        @if($IsHavePermissionSessionExRead)
                                            <a href="{{ route("system.section_externals.index") }}" class="NavName">
                                            <span class="Label">
                                                عرض جميع الاقسام الخارجية
                                            </span>
                                            </a>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if($IsHavePermissionPublicHolidayCreate || $IsHavePermissionPublicHolidayRead)
                        <li class="NavigationsGroup__GroupItem">
                            <div class="Title">
                                <div class="NavName">
                                    <i class="material-icons Icon">
                                        weekend
                                    </i>
                                    <span class="Label">@lang("publicHoliday")</span>
                                </div>
                                <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                            </div>
                            <ul class="NavigationsGroup__SubItems">
                                <li class="NavigationsGroup__NavItem">
                                    <div class="Title">
                                        @if($IsHavePermissionPublicHolidayCreate)
                                            <a href="{{ route("system.public_holidays.create") }}" class="NavName">
                                                <!-- User -->
                                                <span class="Label">
                                                @lang("addNewHoliday")
                                            </span>
                                            </a>
                                        @endif
                                        @if($IsHavePermissionPublicHolidayRead)
                                            <a href="{{ route("system.public_holidays.index") }}" class="NavName">
                                                <!-- User -->
                                                <span class="Label">
                                                @lang("viewAllHoliday")
                                            </span>
                                            </a>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <li class="NavigationsGroup__GroupItem">
                        <div class="Title">
                            <div class="NavName">
                                <i class="material-icons Icon">
                                    groups_2
                                </i>
                                <span class="Label">@lang("correspondences")</span>
                            </div>
                            <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                        </div>
                        <ul class="NavigationsGroup__SubItems">
                            @if($IsHavePermissionCorrespondenceRead)
                                <li class="NavigationsGroup__NavItem">
                                    <div class="Title">
                                        <a href="{{route("correspondences.index")}}" class="NavName">
                                            <span class="Label">عرض المراسلات</span>
                                        </a>
                                    </div>
                                </li>
                            @endif
                            @if($IsHavePermissionCorrespondenceCreate)
                                <li class="NavigationsGroup__NavItem">
                                    <div class="Title">
                                        <a href="{{route("correspondences.create")}}" class="NavName">
                                            <span class="Label">إضافة مراسلة</span>
                                        </a>
                                    </div>
                                </li>
                            @endif
                            {{--                            <li class="NavigationsGroup__NavItem">--}}
                            {{--                                <div class="Title">--}}
                            {{--                                    <a href="{{route("correspondences_dest.create")}}" class="NavName">--}}
                            {{--                                        <span class="Label">إضافة وجهة</span>--}}
                            {{--                                    </a>--}}
                            {{--                                </div>--}}
                            {{--                            </li>--}}
                        </ul>
                    </li>
                    @if($IsHavePermissionAttendanceRead || $IsUserEmployee)
                        <li class="NavigationsGroup__GroupItem">
                            <div class="Title">
                                <div class="NavName">
                                    <i class="material-icons Icon">
                                        login
                                    </i>
                                    <span class="Label">@lang("Attendance")</span>
                                </div>
                                <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                            </div>
                            <ul class="NavigationsGroup__SubItems">
                                @if($IsUserEmployee)
                                    <li class="NavigationsGroup__NavItem">
                                        <div class="Title">
                                            <a href="{{ route("system.attendances.create") }}" class="NavName">
                                                <span class="Label">@lang("RegisterAttendance")</span>
                                            </a>
                                        </div>
                                    </li>
                                @endif
                                @if($IsHavePermissionAttendanceRead)
                                    {{--  View Attendance Inforamtion Admin  --}}
                                    <li class="NavigationsGroup__NavItem">
                                        <div class="Title">
                                            <a href="{{ route("system.attendances.index") }}" class="NavName">
                                                <span class="Label">@lang("ViewAttendaceInfoAdmin")</span>
                                            </a>
                                        </div>
                                    </li>
                                @endif
                                @if($IsUserEmployee)
                                    {{--  View Attendance Inforamtion Employee  --}}
                                    <li class="NavigationsGroup__NavItem">
                                        <div class="Title">
                                            <a href="{{ route("system.attendances.employee") }}" class="NavName">
                                                <span class="Label">@lang("ViewAllMyAttendance")</span>
                                            </a>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                </ul>
                @if($IsUserEmployee)
                    <ul class="NavigationsMenu__NavigationsGroup">
                        <li class="NavigationsGroup__Title">
                            <span class="Title">@lang("Payroll")</span>
                        </li>
                        <li class="NavigationsGroup__GroupItem">
                            <div class="Title">
                                <div class="NavName">
                                    <i class="material-icons Icon">
                                        payments
                                    </i>
                                    <span class="Label">
                                    @lang("payroll")
                                </span>
                                </div>
                                <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                            </div>
                            <ul class="NavigationsGroup__SubItems">
                                <li class="NavigationsGroup__NavItem">
                                    <div class="Title">
                                        <a href="{{ route("system.payroll.salary.me") }}" class="NavName">
                                        <span class="Label">
                                            @lang("viewVocationsRequest")
                                        </span>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @endif
                @if($IsHavePermissionVacationRead || $IsHavePermissionVacationCreate
                    || $IsUserEmployee || $IsHavePermissionVacationTypeRead
                    || $IsHavePermissionVacationTypeCreate)
                    <ul class="NavigationsMenu__NavigationsGroup">
                        <li class="NavigationsGroup__Title">
                            <span class="Title">@lang("vocations")</span>
                        </li>
                        @if($IsHavePermissionVacationRead || $IsHavePermissionVacationCreate
                            || $IsUserEmployee)
                            <li class="NavigationsGroup__GroupItem">
                                <div class="Title">
                                    <div class="NavName">
                                        <i class="material-icons Icon">
                                            emoji_food_beverage
                                        </i>
                                        <span class="Label">
                                    @lang("operation")
                                </span>
                                    </div>
                                    <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                                </div>
                                <ul class="NavigationsGroup__SubItems">
                                    @if($IsHavePermissionVacationRead)
                                        <li class="NavigationsGroup__NavItem">
                                            <div class="Title">
                                                <a href="{{ route("system.leaves_admin.index") }}" class="NavName">
                                                    <!-- Admin -->
                                                    <span class="Label">
                                            @lang("viewVocationsRequest")
                                        </span>
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                    @if($IsHavePermissionVacationCreate)
                                        <li class="NavigationsGroup__NavItem">
                                            <div class="Title">
                                                <a href="{{ route("system.leaves_admin.create") }}" class="NavName">
                                    <span class="Label">
                                        @lang("insertAdministrativeVacation")
                                    </span>
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                    @if($IsUserEmployee)
                                        <li class="NavigationsGroup__NavItem">
                                            <div class="Title">
                                                <a href="{{ route("system.leaves.create.request") }}" class="NavName">
                                    <span class="Label">
                                        @lang("requestVocation")
                                    </span>
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        @if($IsUserEmployee)
                            <li class="NavigationsGroup__GroupItem">
                                <div class="Title">
                                    <div class="NavName">
                                        <i class="material-icons Icon">
                                            emoji_food_beverage
                                        </i>
                                        <span class="Label">
                                    @lang("aboutVocation")
                                </span>
                                    </div>
                                    <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                                </div>
                                <ul class="NavigationsGroup__SubItems">
                                    <li class="NavigationsGroup__NavItem">
                                        <div class="Title">
                                            <a href="{{ route("system.leaves.all.status" , "pending") }}"
                                               class="NavName">
                                                <!-- User -->
                                                <span class="Label">
                                            @lang("vocationsPending")
                                        </span>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="NavigationsGroup__NavItem">
                                        <div class="Title">
                                            <a href="{{ route("system.leaves.all.status" , "approve") }}"
                                               class="NavName">
                                                <!-- User -->
                                                <span class="Label">
                                            @lang("vocationsAccept")
                                        </span>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="NavigationsGroup__NavItem">
                                        <div class="Title">
                                            <a href="{{ route("system.leaves.all.status" , "reject") }}"
                                               class="NavName">
                                                <!-- User -->
                                                <span class="Label">
                                            @lang("vocationsReject")
                                        </span>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="NavigationsGroup__NavItem">
                                        <div class="Title">
                                            <a href="{{ route("system.leaves.show.leavesType") }}" class="NavName">
                                                <!-- User -->
                                                <span class="Label">@lang("viewVacationAvailable")</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if($IsHavePermissionVacationTypeRead || $IsHavePermissionVacationTypeCreate)
                            <li class="NavigationsGroup__GroupItem">
                                <div class="Title">
                                    <div class="NavName">
                                        <i class="material-icons Icon">
                                            emoji_food_beverage
                                        </i>
                                        <span class="Label">
                                    @lang("vocationsType")
                                </span>
                                    </div>
                                    <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                                </div>
                                <ul class="NavigationsGroup__SubItems">
                                    @if($IsHavePermissionVacationTypeRead)
                                        <li class="NavigationsGroup__NavItem">
                                            <div class="Title">
                                                <!-- Admin -->
                                                <a href="{{ route("system.leave_types.index") }}" class="NavName">
                                        <span class="Label">
                                            @lang("viewVocationsType")
                                        </span>
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                    @if($IsHavePermissionVacationTypeCreate)
                                        <li class="NavigationsGroup__NavItem">
                                            <div class="Title">
                                                <!-- User -->
                                                <a href="{{ route("system.leave_types.create") }}" class="NavName">
                                    <span class="Label">
                                        @lang("addNewType")
                                    </span>
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    </ul>
                @endif
                @if($IsHavePermissionOverTimeTypeRead || $IsHavePermissionOverTimeTypeCreate
                    || $IsHavePermissionOverTimeCreate || $IsHavePermissionOverTimeRead || $IsUserEmployee)
                    <ul class="NavigationsMenu__NavigationsGroup">
                        <li class="NavigationsGroup__Title">
                        <span class="Title">
                            @lang("overtime")
                        </span>
                        </li>
                        @if($IsUserEmployee || $IsHavePermissionOverTimeRead || $IsHavePermissionOverTimeCreate)
                            <li class="NavigationsGroup__GroupItem">
                                <div class="Title">
                                    <div class="NavName">
                                        <i class="material-icons Icon">
                                            more_time
                                        </i>
                                        <span class="Label">
                                    @lang("operation")
                                </span>
                                    </div>
                                    <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                                </div>
                                <ul class="NavigationsGroup__SubItems">
                                    @if($IsUserEmployee)
                                        <li class="NavigationsGroup__NavItem">
                                            <div class="Title">
                                                <a href="{{ route("system.overtimes.create.request") }}"
                                                   class="NavName">
                                                    <!-- User -->
                                                    <span class="Label">
                                            @lang("addRequest")
                                        </span>
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                    @if($IsHavePermissionOverTimeRead)
                                        <li class="NavigationsGroup__NavItem">
                                            <div class="Title">
                                                <a href="{{ route("system.overtimes_admin.index") }}" class="NavName">
                                                    <!-- Admin -->
                                                    <span class="Label">
                                        @lang("viewAllRequest")
                                    </span>
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                    @if($IsHavePermissionOverTimeCreate)
                                        <li class="NavigationsGroup__NavItem">
                                            <div class="Title">
                                                <a href="{{ route("system.overtimes_admin.create") }}" class="NavName">
                                                    <!-- User -->
                                                    <span class="Label">
                                        @lang("insertAdministrativeOvertime")
                                    </span>
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        @if($IsUserEmployee)
                            <li class="NavigationsGroup__GroupItem">
                                <div class="Title">
                                    <div class="NavName">
                                        <i class="material-icons Icon">
                                            more_time
                                        </i>
                                        <span class="Label">
                                    @lang("aboutMyOvertime")
                                </span>
                                    </div>
                                    <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                                </div>
                                <ul class="NavigationsGroup__SubItems">
                                    @if($IsUserEmployee)
                                        <li class="NavigationsGroup__NavItem">
                                            <div class="Title">
                                                <a href="{{ route("system.overtimes.all.status" , "pending") }}"
                                                   class="NavName">
                                                    <!-- User -->
                                                    <span class="Label">
                                            @lang("viewMyRequestPending")
                                        </span>
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                    @if($IsUserEmployee)
                                        <li class="NavigationsGroup__NavItem">
                                            <div class="Title">
                                                <a href="{{ route("system.overtimes.all.status" , "approve") }}"
                                                   class="NavName">
                                                    <!-- User -->
                                                    <span class="Label">
                                        @lang("viewMyRequestAccept")
                                    </span>
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                    @if($IsUserEmployee)
                                        <li class="NavigationsGroup__NavItem">
                                            <div class="Title">
                                                <a href="{{ route("system.overtimes.all.status" , "reject") }}"
                                                   class="NavName">
                                                    <!-- User -->
                                                    <span class="Label">
                                        @lang("viewMyRequestReject")
                                    </span>
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        @if($IsHavePermissionOverTimeTypeCreate || $IsHavePermissionOverTimeTypeRead)
                            <li class="NavigationsGroup__GroupItem">
                                <div class="Title">
                                    <div class="NavName">
                                        <i class="material-icons Icon">
                                            more_time
                                        </i>
                                        <span class="Label">
                                    @lang("viewOvertimeType")
                                </span>
                                    </div>
                                    <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                                </div>
                                <ul class="NavigationsGroup__SubItems">
                                    @if($IsHavePermissionOverTimeTypeCreate)
                                        <li class="NavigationsGroup__NavItem">
                                            <div class="Title">
                                                <a href="{{ route("system.overtime_types.create") }}" class="NavName">
                                                    <!-- User -->
                                                    <span class="Label">
                                            @lang("addNewType")
                                        </span>
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                    @if($IsHavePermissionOverTimeTypeRead)
                                        <li class="NavigationsGroup__NavItem">
                                            <div class="Title">
                                                <a href="{{ route("system.overtime_types.index") }}" class="NavName">
                                                    <!-- User -->
                                                    <span class="Label">
                                        @lang("viewAllTypes")
                                    </span>
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    </ul>
                @endif
                @if($IsHavePermissionReportCreate)
                    <ul class="NavigationsMenu__NavigationsGroup">
                        <li class="NavigationsGroup__Title">
                        <span class="Title">
                            @lang("report")
                        </span>
                        </li>
                        <li class="NavigationsGroup__NavItem">
                            <div class="Title">
                                <a href="{{route("system.employees.report")}}" class="NavName">
                                    <i class="material-icons Icon">
                                        description
                                    </i>
                                    <span class="Label">
                                    @lang("employeesReport")
                                </span>
                                </a>
                            </div>
                        </li>
                    </ul>
                @endif
                @if($IsHavePermissionCompanySettingRead || $IsHavePermissionWorkSettingCreate
                    || $IsHavePermissionWorkSettingRead)
                    <ul class="NavigationsMenu__NavigationsGroup">
                        <li class="NavigationsGroup__Title">
                        <span class="Title">
                            @lang("setting")
                        </span>
                        </li>
                        @if($IsHavePermissionCompanySettingRead)
                            <li class="NavigationsGroup__NavItem">
                                <div class="Title">
                                    <a href="{{route("system.company_settings.show")}}" class="NavName">
                                        <i class="material-icons Icon">
                                            widgets
                                        </i>
                                        <span class="Label">
                                    @lang("companySetting")
                                </span>
                                    </a>
                                </div>
                            </li>
                        @endif
                        @if($IsHavePermissionWorkSettingCreate || $IsHavePermissionWorkSettingRead)
                            <li class="NavigationsGroup__GroupItem">
                                <div class="Title">
                                    <div class="NavName">
                                        <i class="material-icons Icon">
                                            room_preferences
                                        </i>
                                        <span class="Label">
                                    @lang("workSetting")
                                </span>
                                    </div>
                                    <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                                </div>
                                <ul class="NavigationsGroup__SubItems">
                                    <li class="NavigationsGroup__NavItem">
                                        <div class="Title">
                                            @if($IsHavePermissionWorkSettingCreate)
                                                <a href="{{ route("system.work_settings.create") }}"
                                                   class="NavName">
                                                    <!-- User -->
                                                    <span class="Label">
                                            @lang("addNewWorkSetting")
                                        </span>
                                                </a>
                                            @endif
                                            @if($IsHavePermissionWorkSettingRead)
                                                <a href="{{ route("system.work_settings.index") }}"
                                                   class="NavName">
                                                    <!-- User -->
                                                    <span class="Label">
                                            @lang("viewAllWorkSetting")
                                        </span>
                                                </a>
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                @endif
                <ul class="NavigationsMenu__NavigationsGroup Visible-phoneLandscape">
                    <li class="NavigationsGroup__Title">
                        <span class="Title">@lang("app")</span>
                    </li>
                    <li class="NavigationsGroup__NavItem">
                        <div class="Title">
                            <a href="#" class="NavName">
                                <i class="material-icons Icon">
                                    notifications
                                </i>
                                <span class="Label">@lang("notification")</span>
                            </a>
                        </div>
                    </li>
                    <li class="NavigationsGroup__GroupItem">
                        <div class="Title">
                            <div class="NavName">
                                <i class="material-icons Icon">language</i>
                                <span class="Label">@lang("language")</span>
                            </div>
                            <span class="material-icons ArrowRight">
                                play_arrow
                            </span>
                        </div>
                        <ul class="NavigationsGroup__SubItems">
                            <li class="NavigationsGroup__NavItem">
                                <div class="Title">
                                    <a href="{{route("lang.change","en")}}" class="NavName">
                                        <span class="Label">@lang("english")</span>
                                    </a>
                                </div>
                            </li>
                            <li class="NavigationsGroup__NavItem">
                                <div class="Title">
                                    <a href="{{route("lang.change","ar")}}" class="NavName">
                                        <span class="Label">@lang("arabic")</span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="NavigationsMenu__NavigationsGroup Visible-phoneLandscape">
                    <li class="NavigationsGroup__Title">
                        <span class="Title">@lang("account")</span>
                    </li>
                    <li class="NavigationsGroup__NavItem">
                        <div class="Title">
                            <a href="{{route("profile.show")}}" class="NavName">
                                <i class="material-icons Icon">
                                    assignment_ind
                                </i>
                                <span class="Label">@lang("profile")</span>
                            </a>
                        </div>
                    </li>
                    <li class="NavigationsGroup__NavItem">
                        <div class="Title">
                            <a href="#" class="AnchorSubmit NavName"
                               data-form="logOutSystem">
                                <i class="material-icons Icon">
                                    logout
                                </i>
                                <span class="Label">@lang("signout")</span>
                            </a>
                            <form action="{{route("logout")}}"
                                  class="logoutForm"
                                  name="logOutSystem" method="post">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </main>
            <footer class="NavigationsMenu__Footer">

            </footer>
        </div>
    </div>
</nav>
