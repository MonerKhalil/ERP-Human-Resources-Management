<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionReportCreate = $MyAccount->can("create_employees") || $MyAccount->can("all_employees") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    @if($IsHavePermissionReportCreate)
        <section class="MainContent__Section MainContent__Section--ReportEmployeeFormPage">
            <div class="ReportEmployeeFormPage">
                <div class="ReportEmployeeFormPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __("employeesReport") ,
                        'paths' => [[__("home") , '#'] , [__("employeesReport")]] ,
                        'summery' => __("titleEmployeesReport")
                    ])
                </div>
                <div class="ReportEmployeeFormPage__Content">
                    <div class="Row">
                        <div class="ReportEmployeeFormPage__Form">
                            <div class="Container--MainContent">
                                <div class="MessageProcessContainer">
                                    @include("System.Components.messageProcess")
                                </div>
                                <div class="Row">
                                    <div class="Card">
                                        <div class="Card__Content">
                                            <div class="Card__Inner">
                                                <div class="Card__Body">
                                                    <form class="Form Form--Dark"
                                                          action="{{route("system.employees.report.final")}}"
                                                          method="get">
                                                        @csrf
                                                        <div class="ListData">
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("basics")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div class="ListData__CustomItem pt-0">
                                                                    <div class="Row GapC-1-5">
                                                                        {{-- Main --}}
                                                                        <div class="VisibilityOption Col-12"
                                                                             data-ElementsTargetName="CreateReportBy">
                                                                            @php
                                                                                $ErrorView = Errors("from_contract_direct_date") ?? Errors("to_contract_direct_date") ??
                                                                                Errors("from_birth_date") ?? Errors("to_birth_date") ?? Errors("from_end_break_date") ??
                                                                                Errors("to_end_break_date") ?? Errors("from_decision_date") ?? Errors("to_decision_date") ??
                                                                                Errors("from_conference_date") ?? Errors("to_conference_date") ?? Errors("gender") ??
                                                                                Errors("family_status") ?? Errors("education_level_id") ?? Errors("position_id") ??
                                                                                Errors("contract_type") ?? Errors("section_id") ?? Errors("membership_type_id") ??
                                                                                Errors("type_decision_id") ?? Errors("current_job") ?? Errors("from_salary") ?? Errors("to_salary") ??
                                                                                Errors("salary");
                                                                            @endphp
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ $ErrorView }}">
                                                                                <div class="Form__Select">
                                                                                    <div class="Select__Area">
                                                                                        @include("System.Components.multiSelector" , [
                                                                                            'Name' => "_" ,
                                                                                            "NameIDs" => "ReportBY" , "DefaultValue" => "" , "Label" => __("reportBy") ,
                                                                                            "Options" => [
                                                                                                           ["Label" => __("dateOfStart") , "Value" => "Decision" , "Name" => "1"] ,
                                                                                                           /* ["Label" => "مكان العمل" , "Value" => "Decision" , "Name" => "2"] ,*/
                                                                                                           ["Label" => __("dateBirthday") , "Value" => "Decision" , "Name" => "3"] ,
                                                                                                           ["Label" => __("gender") , "Value" => "Decision" , "Name" => "4"] ,
                                                                                                           ["Label" => __("familyStatus") , "Value" => "Decision" , "Name" => "5"] ,
                                                                                                           /*["Label" => "المهنة" , "Value" => "Decision" , "Name" => "6"] ,*/
                                                                                                           ["Label" => __("finishEndServicesDate") , "Value" => "Decision" , "Name" => "7"] ,
                                                                                                           ["Label" => __("contractType") , "Value" => "Decision" , "Name" => "8"] ,
                                                                                                           /*["Label" => "الحاصلين على التأمين" , "Value" => "Decision" , "Name" => "9"] ,*/
                                                                                                           ["Label" => __("degree") , "Value" => "Decision" , "Name" => "10"] ,
                                                                                                           ["Label" => __("languageSkills") , "Value" => "Decision" , "Name" => "11"] ,
                                                                                                           ["Label" => __("memberships") , "Value" => "Decision" , "Name" => "12"] ,
                                                                                                           /*["Label" => "تاريخ العمل لاول مرة" , "Value" => "Decision" , "Name" => "13"] ,*/
                                                                                                           ["Label" => __("jobPosition") , "Value" => "Decision" , "Name" => "14"] ,
                                                                                                           /*["Label" => "تاريخ المكافئات" , "Value" => "Decision" , "Name" => "15"] ,*/
                                                                                                           /*["Label" => "تاريخ العقوبات" , "Value" => "Decision" , "Name" => "16"] ,*/
                                                                                                           ["Label" => __("dateConferences") , "Value" => "Decision" , "Name" => "17"] ,
                                                                                                           /*["Label" => "التقييم" , "Value" => "Decision" , "Name" => "18"] ,*/
                                                                                                           /*["Label" => "العمل الاضافي" , "Value" => "Decision" , "Name" => "19"] ,*/
                                                                                                           ["Label" => __("salaryRange") , "Value" => "Decision" , "Name" => "20"] ,
                                                                                                           ["Label" => __("salaryLimit") , "Value" => "Decision" , "Name" => "21"] ,
                                                                                                           /*["Label" => "الفئة الوظيفية" , "Value" => "Decision" , "Name" => "22"] ,*/
                                                                                                           /*["Label" => "الدرجة العملية" , "Value" => "Decision" , "Name" => "23"] ,*/
                                                                                                           ["Label" => __("departmentDepend") , "Value" => "Decision" , "Name" => "24"] ,
                                                                                                           ["Label" => __("decisionTypeApplyOnEmployee") , "Value" => "Decision" , "Name" => "25"] ,
                                                                                                           ["Label" => __("decisionTypeDateApplyOnEmployee") , "Value" => "Decision" , "Name" => "26"] ,
                                                                                                           ["Label" => __("currentJob") , "Value" => "Decision" , "Name" => "27"]
                                                                                            ]
                                                                                        ])
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Sub Date --}}
                                                        <div class="VisibilityTarget ListData"
                                                             data-TargetName="CreateReportBy"
                                                             data-TargetCheckboxName="1">
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("reportByDirectDate")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div class="Row GapC-1-5">
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="DirectWorkDateFrom"
                                                                                           name="from_contract_direct_date"
                                                                                           class="Date__Field"
                                                                                           TargetDateStartName="StartDateDirectWorkDate"
                                                                                           type="text" placeholder="@lang("startsFromDate")"
                                                                                           required>
                                                                                    <label class="Date__Label"
                                                                                           for="DirectWorkDateFrom">
                                                                                        @lang("startsFromDate")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="DirectWorkDateTo"
                                                                                           name="to_contract_direct_date"
                                                                                           class="DateEndFromStart Date__Field"
                                                                                           data-StartDateName="StartDateDirectWorkDate"
                                                                                           type="text" placeholder="@lang("endFromDate")"
                                                                                           required>
                                                                                    <label class="Date__Label"
                                                                                           for="DirectWorkDateTo">
                                                                                        @lang("endFromDate")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="VisibilityTarget ListData"
                                                             data-TargetName="CreateReportBy"
                                                             data-TargetCheckboxName="3">
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("reportByBirthdayDate")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div class="Row GapC-1-5">
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="BirthdayDateFrom"
                                                                                           class="Date__Field"
                                                                                           TargetDateStartName="StartDateBirthdayDate"
                                                                                           name="from_birth_date"
                                                                                           type="text" placeholder="@lang("startsFromDate")"
                                                                                           required>
                                                                                    <label class="Date__Label"
                                                                                           for="BirthdayDateFrom">
                                                                                        @lang("startsFromDate")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="BirthdayDateTo"
                                                                                           name="to_birth_date"
                                                                                           class="DateEndFromStart Date__Field"
                                                                                           data-StartDateName="StartDateBirthdayDate"
                                                                                           type="text" placeholder="@lang("endFromDate")"
                                                                                           required>
                                                                                    <label class="Date__Label"
                                                                                           for="BirthdayDateTo">
                                                                                        @lang("endFromDate")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="VisibilityTarget ListData"
                                                             data-TargetName="CreateReportBy"
                                                             data-TargetCheckboxName="7">
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("reportByExpiryDate")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div class="Row GapC-1-5">
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="ServiceEndDateFrom"
                                                                                           name="from_end_break_date"
                                                                                           class="Date__Field"
                                                                                           TargetDateStartName="StartDateServiceEndDate"
                                                                                           type="text" placeholder="@lang("startsFromDate")"
                                                                                           required>
                                                                                    <label class="Date__Label"
                                                                                           for="ServiceEndDateFrom">
                                                                                        @lang("startsFromDate")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="ServiceEndDateTo"
                                                                                           name="to_end_break_date"
                                                                                           class="DateEndFromStart Date__Field"
                                                                                           data-StartDateName="StartDateServiceEndDate"
                                                                                           type="text" placeholder="@lang("endFromDate")"
                                                                                           required>
                                                                                    <label class="Date__Label"
                                                                                           for="ServiceEndDateTo">
                                                                                        @lang("endFromDate")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="VisibilityTarget ListData"
                                                             data-TargetName="CreateReportBy"
                                                             data-TargetCheckboxName="26">
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("reportByReportingDate")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div class="Row GapC-1-5">
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="DecisionDateFrom"
                                                                                           name="from_decision_date"
                                                                                           class="Date__Field"
                                                                                           TargetDateStartName="StartDateDecisionDate"
                                                                                           type="text" placeholder="@lang("startsFromDate")"
                                                                                           required>
                                                                                    <label class="Date__Label"
                                                                                           for="DecisionDateFrom">
                                                                                        @lang("startsFromDate")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="DecisionDateTo"
                                                                                           name="to_decision_date"
                                                                                           class="DateEndFromStart Date__Field"
                                                                                           data-StartDateName="StartDateDecisionDate"
                                                                                           type="text" placeholder="@lang("endFromDate")"
                                                                                           required>
                                                                                    <label class="Date__Label"
                                                                                           for="DecisionDateTo">
                                                                                        @lang("endFromDate")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{--                                                    <div class="VisibilityTarget ListData"--}}
                                                        {{--                                                         data-TargetName="CreateReportBy"--}}
                                                        {{--                                                         data-TargetCheckboxName="13">--}}
                                                        {{--                                                        <div class="ListData__Head">--}}
                                                        {{--                                                            <h4 class="ListData__Title">--}}
                                                        {{--                                                                تقرير حسب تاريخ العمل لاول مرة--}}
                                                        {{--                                                            </h4>--}}
                                                        {{--                                                        </div>--}}
                                                        {{--                                                        <div class="ListData__Content">--}}
                                                        {{--                                                            <div class="Row GapC-1-5">--}}
                                                        {{--                                                                <div class="Col-4-md Col-6-sm">--}}
                                                        {{--                                                                    <div class="Form__Group">--}}
                                                        {{--                                                                        <div class="Form__Date">--}}
                                                        {{--                                                                            <div class="Date__Area">--}}
                                                        {{--                                                                                <input id="WorkDateForFirstTimeFrom"--}}
                                                        {{--                                                                                       class="Date__Field"--}}
                                                        {{--                                                                                       TargetDateStartName="WorkDateForFirstTime"--}}
                                                        {{--                                                                                       type="text" placeholder="@lang("startsFromDate")"--}}
                                                        {{--                                                                                       required>--}}
                                                        {{--                                                                                <label class="Date__Label"--}}
                                                        {{--                                                                                       for="WorkDateForFirstTimeFrom">@lang("startsFromDate")</label>--}}
                                                        {{--                                                                            </div>--}}
                                                        {{--                                                                        </div>--}}
                                                        {{--                                                                    </div>--}}
                                                        {{--                                                                </div>--}}
                                                        {{--                                                                <div class="Col-4-md Col-6-sm">--}}
                                                        {{--                                                                    <div class="Form__Group">--}}
                                                        {{--                                                                        <div class="Form__Date">--}}
                                                        {{--                                                                            <div class="Date__Area">--}}
                                                        {{--                                                                                <input id="WorkDateForFirstTimeTo"--}}
                                                        {{--                                                                                       class="DateEndFromStart Date__Field"--}}
                                                        {{--                                                                                       data-StartDateName="WorkDateForFirstTime"--}}
                                                        {{--                                                                                       type="text" placeholder="@lang("endFromDate")"--}}
                                                        {{--                                                                                       required>--}}
                                                        {{--                                                                                <label class="Date__Label"--}}
                                                        {{--                                                                                       for="WorkDateForFirstTimeTo">@lang("endFromDate")</label>--}}
                                                        {{--                                                                            </div>--}}
                                                        {{--                                                                        </div>--}}
                                                        {{--                                                                    </div>--}}
                                                        {{--                                                                </div>--}}
                                                        {{--                                                            </div>--}}
                                                        {{--                                                        </div>--}}
                                                        {{--                                                    </div>--}}
                                                        {{--                                                    <div class="VisibilityTarget ListData"--}}
                                                        {{--                                                         data-TargetName="CreateReportBy"--}}
                                                        {{--                                                         data-TargetCheckboxName="15">--}}
                                                        {{--                                                        <div class="ListData__Head">--}}
                                                        {{--                                                            <h4 class="ListData__Title">--}}
                                                        {{--                                                                تقرير حسب تاريخ الكافئة--}}
                                                        {{--                                                            </h4>--}}
                                                        {{--                                                        </div>--}}
                                                        {{--                                                        <div class="ListData__Content">--}}
                                                        {{--                                                            <div class="Row GapC-1-5">--}}
                                                        {{--                                                                <div class="Col-4-md Col-6-sm">--}}
                                                        {{--                                                                    <div class="Form__Group">--}}
                                                        {{--                                                                        <div class="Form__Date">--}}
                                                        {{--                                                                            <div class="Date__Area">--}}
                                                        {{--                                                                                <input id="BonusDateFrom"--}}
                                                        {{--                                                                                       class="Date__Field"--}}
                                                        {{--                                                                                       TargetDateStartName="BonusDate"--}}
                                                        {{--                                                                                       type="text" placeholder="@lang("startsFromDate")"--}}
                                                        {{--                                                                                       required>--}}
                                                        {{--                                                                                <label class="Date__Label"--}}
                                                        {{--                                                                                       for="BonusDateFrom">@lang("startsFromDate")</label>--}}
                                                        {{--                                                                            </div>--}}
                                                        {{--                                                                        </div>--}}
                                                        {{--                                                                    </div>--}}
                                                        {{--                                                                </div>--}}
                                                        {{--                                                                <div class="Col-4-md Col-6-sm">--}}
                                                        {{--                                                                    <div class="Form__Group">--}}
                                                        {{--                                                                        <div class="Form__Date">--}}
                                                        {{--                                                                            <div class="Date__Area">--}}
                                                        {{--                                                                                <input id="BonusDateTo"--}}
                                                        {{--                                                                                       class="DateEndFromStart Date__Field"--}}
                                                        {{--                                                                                       data-StartDateName="BonusDate"--}}
                                                        {{--                                                                                       type="text" placeholder="@lang("endFromDate")"--}}
                                                        {{--                                                                                       required>--}}
                                                        {{--                                                                                <label class="Date__Label"--}}
                                                        {{--                                                                                       for="BonusDateTo">@lang("endFromDate")</label>--}}
                                                        {{--                                                                            </div>--}}
                                                        {{--                                                                        </div>--}}
                                                        {{--                                                                    </div>--}}
                                                        {{--                                                                </div>--}}
                                                        {{--                                                            </div>--}}
                                                        {{--                                                        </div>--}}
                                                        {{--                                                    </div>--}}
                                                        {{--                                                    <div class="VisibilityTarget ListData"--}}
                                                        {{--                                                         data-TargetName="CreateReportBy"--}}
                                                        {{--                                                         data-TargetCheckboxName="16">--}}
                                                        {{--                                                        <div class="ListData__Head">--}}
                                                        {{--                                                            <h4 class="ListData__Title">--}}
                                                        {{--                                                                تقرير حسب تاريخ العقوبة--}}
                                                        {{--                                                            </h4>--}}
                                                        {{--                                                        </div>--}}
                                                        {{--                                                        <div class="ListData__Content">--}}
                                                        {{--                                                            <div class="Row GapC-1-5">--}}
                                                        {{--                                                                <div class="Col-4-md Col-6-sm">--}}
                                                        {{--                                                                    <div class="Form__Group">--}}
                                                        {{--                                                                        <div class="Form__Date">--}}
                                                        {{--                                                                            <div class="Date__Area">--}}
                                                        {{--                                                                                <input id="PunishmentDateFrom"--}}
                                                        {{--                                                                                       class="Date__Field"--}}
                                                        {{--                                                                                       TargetDateStartName="PunishmentDate"--}}
                                                        {{--                                                                                       type="text" placeholder="@lang("startsFromDate")"--}}
                                                        {{--                                                                                       required>--}}
                                                        {{--                                                                                <label class="Date__Label"--}}
                                                        {{--                                                                                       for="PunishmentDateFrom">@lang("startsFromDate")</label>--}}
                                                        {{--                                                                            </div>--}}
                                                        {{--                                                                        </div>--}}
                                                        {{--                                                                    </div>--}}
                                                        {{--                                                                </div>--}}
                                                        {{--                                                                <div class="Col-4-md Col-6-sm">--}}
                                                        {{--                                                                    <div class="Form__Group">--}}
                                                        {{--                                                                        <div class="Form__Date">--}}
                                                        {{--                                                                            <div class="Date__Area">--}}
                                                        {{--                                                                                <input id="PunishmentDateTo"--}}
                                                        {{--                                                                                       class="DateEndFromStart Date__Field"--}}
                                                        {{--                                                                                       data-StartDateName="PunishmentDate"--}}
                                                        {{--                                                                                       type="text" placeholder="@lang("endFromDate")"--}}
                                                        {{--                                                                                       required>--}}
                                                        {{--                                                                                <label class="Date__Label"--}}
                                                        {{--                                                                                       for="PunishmentDateTo">--}}
                                                        {{--                                                                                    @lang("endFromDate")</label>--}}
                                                        {{--                                                                            </div>--}}
                                                        {{--                                                                        </div>--}}
                                                        {{--                                                                    </div>--}}
                                                        {{--                                                                </div>--}}
                                                        {{--                                                            </div>--}}
                                                        {{--                                                        </div>--}}
                                                        {{--                                                    </div>--}}
                                                        <div class="VisibilityTarget ListData"
                                                             data-TargetName="CreateReportBy"
                                                             data-TargetCheckboxName="17">
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("reportByDateConferences")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div class="Row GapC-1-5">
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="CoursesDateFrom"
                                                                                           class="Date__Field"
                                                                                           name="from_conference_date"
                                                                                           TargetDateStartName="CoursesDate"
                                                                                           type="text" placeholder="@lang("startsFromDate")"
                                                                                           required>
                                                                                    <label class="Date__Label"
                                                                                           for="CoursesDateFrom">@lang("startsFromDate")</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="CoursesDateTo"
                                                                                           class="DateEndFromStart Date__Field"
                                                                                           data-StartDateName="CoursesDate"
                                                                                           name="to_conference_date"
                                                                                           type="text" placeholder="@lang("endFromDate")"
                                                                                           required>
                                                                                    <label class="Date__Label"
                                                                                           for="CoursesDateTo">
                                                                                        @lang("endFromDate")</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{--                                                    <div class="VisibilityTarget ListData">--}}
                                                        {{--                                                        <div class="ListData__Head"--}}
                                                        {{--                                                             data-TargetName="CreateReportBy"--}}
                                                        {{--                                                             data-TargetCheckboxName="18">--}}
                                                        {{--                                                            <h4 class="ListData__Title">--}}
                                                        {{--                                                                تقرير حسب تاريخ التقييم--}}
                                                        {{--                                                            </h4>--}}
                                                        {{--                                                        </div>--}}
                                                        {{--                                                        <div class="ListData__Content">--}}
                                                        {{--                                                            <div class="Row GapC-1-5">--}}
                                                        {{--                                                                <div class="Col-4-md Col-6-sm">--}}
                                                        {{--                                                                    <div class="Form__Group">--}}
                                                        {{--                                                                        <div class="Form__Date">--}}
                                                        {{--                                                                            <div class="Date__Area">--}}
                                                        {{--                                                                                <input id="evaluationDateFrom"--}}
                                                        {{--                                                                                       class="Date__Field"--}}
                                                        {{--                                                                                       TargetDateStartName="evaluationDate"--}}
                                                        {{--                                                                                       type="text" placeholder="@lang("startsFromDate")"--}}
                                                        {{--                                                                                       required>--}}
                                                        {{--                                                                                <label class="Date__Label"--}}
                                                        {{--                                                                                       for="evaluationDateFrom">@lang("startsFromDate")</label>--}}
                                                        {{--                                                                            </div>--}}
                                                        {{--                                                                        </div>--}}
                                                        {{--                                                                    </div>--}}
                                                        {{--                                                                </div>--}}
                                                        {{--                                                                <div class="Col-4-md Col-6-sm">--}}
                                                        {{--                                                                    <div class="Form__Group">--}}
                                                        {{--                                                                        <div class="Form__Date">--}}
                                                        {{--                                                                            <div class="Date__Area">--}}
                                                        {{--                                                                                <input id="evaluationDateTo"--}}
                                                        {{--                                                                                       class="DateEndFromStart Date__Field"--}}
                                                        {{--                                                                                       data-StartDateName="evaluationDate"--}}
                                                        {{--                                                                                       type="text" placeholder="@lang("endFromDate")"--}}
                                                        {{--                                                                                       required>--}}
                                                        {{--                                                                                <label class="Date__Label"--}}
                                                        {{--                                                                                       for="evaluationDateTo">--}}
                                                        {{--                                                                                    @lang("endFromDate")</label>--}}
                                                        {{--                                                                            </div>--}}
                                                        {{--                                                                        </div>--}}
                                                        {{--                                                                    </div>--}}
                                                        {{--                                                                </div>--}}
                                                        {{--                                                            </div>--}}
                                                        {{--                                                        </div>--}}
                                                        {{--                                                    </div>--}}
                                                        {{--                                                    <div class="VisibilityTarget ListData"--}}
                                                        {{--                                                         data-TargetName="CreateReportBy"--}}
                                                        {{--                                                         data-TargetCheckboxName="19">--}}
                                                        {{--                                                        <div class="ListData__Head">--}}
                                                        {{--                                                            <h4 class="ListData__Title">--}}
                                                        {{--                                                                تقرير حسب تاريخ العمل الاضافي--}}
                                                        {{--                                                            </h4>--}}
                                                        {{--                                                        </div>--}}
                                                        {{--                                                        <div class="ListData__Content">--}}
                                                        {{--                                                            <div class="Row GapC-1-5">--}}
                                                        {{--                                                                <div class="Col-4-md Col-6-sm">--}}
                                                        {{--                                                                    <div class="Form__Group">--}}
                                                        {{--                                                                        <div class="Form__Date">--}}
                                                        {{--                                                                            <div class="Date__Area">--}}
                                                        {{--                                                                                <input id="OvertimeDateFrom"--}}
                                                        {{--                                                                                       class="Date__Field"--}}
                                                        {{--                                                                                       TargetDateStartName="OvertimeDate"--}}
                                                        {{--                                                                                       type="text" placeholder="@lang("startsFromDate")"--}}
                                                        {{--                                                                                       required>--}}
                                                        {{--                                                                                <label class="Date__Label"--}}
                                                        {{--                                                                                       for="OvertimeDateFrom">@lang("startsFromDate")</label>--}}
                                                        {{--                                                                            </div>--}}
                                                        {{--                                                                        </div>--}}
                                                        {{--                                                                    </div>--}}
                                                        {{--                                                                </div>--}}
                                                        {{--                                                                <div class="Col-4-md Col-6-sm">--}}
                                                        {{--                                                                    <div class="Form__Group">--}}
                                                        {{--                                                                        <div class="Form__Date">--}}
                                                        {{--                                                                            <div class="Date__Area">--}}
                                                        {{--                                                                                <input id="OvertimeDateTo"--}}
                                                        {{--                                                                                       class="DateEndFromStart Date__Field"--}}
                                                        {{--                                                                                       data-StartDateName="OvertimeDate"--}}
                                                        {{--                                                                                       type="text" placeholder="@lang("endFromDate")"--}}
                                                        {{--                                                                                       required>--}}
                                                        {{--                                                                                <label class="Date__Label"--}}
                                                        {{--                                                                                       for="OvertimeDateTo">--}}
                                                        {{--                                                                                    @lang("endFromDate")</label>--}}
                                                        {{--                                                                            </div>--}}
                                                        {{--                                                                        </div>--}}
                                                        {{--                                                                    </div>--}}
                                                        {{--                                                                </div>--}}
                                                        {{--                                                            </div>--}}
                                                        {{--                                                        </div>--}}
                                                        {{--                                                    </div>--}}
                                                        {{-- Employee Information --}}
                                                        <div class="VisibilityTarget ListData"
                                                             data-TargetName="CreateReportBy"
                                                             data-TargetCheckboxName="4,5,10,14">
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("reportByEmployeeInformation")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div class="Row GapC-1-5">
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         data-TargetName="CreateReportBy"
                                                                         data-TargetCheckboxName="4">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Select">
                                                                                <div class="Select__Area">
                                                                                    @php
                                                                                        $GenderTypes = [] ;
                                                                                        foreach ($gender as $Index => $GenderType) {
                                                                                            array_push($GenderTypes , [ "Label" => $GenderType ,
                                                                                                 "Value" => $GenderType] ) ;
                                                                                        }
                                                                                    @endphp
                                                                                    @include("System.Components.selector" , [
                                                                                            'Name' => "gender" , "DefaultValue" => "" ,
                                                                                            "Label" => __("gender") , "Required" => "true",
                                                                                            "Options" => $GenderTypes
                                                                                        ])
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         data-TargetName="CreateReportBy"
                                                                         data-TargetCheckboxName="5">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Select">
                                                                                <div class="Select__Area">
                                                                                    @php
                                                                                        $FamilyStatus = [] ;
                                                                                        foreach ($family_status as $Level) {
                                                                                            array_push($FamilyStatus , [ "Label" => $Level
                                                                                                , "Value" => $Level , "Name" => "family_status[]"] ) ;
                                                                                        }
                                                                                    @endphp

                                                                                    @include("System.Components.multiSelector" , [
                                                                                        'Name' => "_" , "Required" => "true" ,
                                                                                        "NameIDs" => "FamilyStatusID" ,
                                                                                        "DefaultValue" => "" , "Label" => __("familyStatus") ,
                                                                                        "Options" => $FamilyStatus
                                                                                    ])
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    {{--                                                                <div class="Col-4-md Col-6-sm">--}}
                                                                    {{--                                                                    <div class="Form__Group">--}}
                                                                    {{--                                                                        <div class="Form__Select">--}}
                                                                    {{--                                                                            <div class="Select__Area">--}}
                                                                    {{--                                                                                @include("System.Components.selector" , [--}}
                                                                    {{--                                                                                    'Name' => "Type" , "Required" => "true" ,--}}
                                                                    {{--                                                                                    "DefaultValue" => "" , "Label" => "المهنة" ,--}}
                                                                    {{--                                                                                    "Options" => [--}}
                                                                    {{--                                                                                        ["Label" => "فرونت" , "Value" => "Decision"] ,--}}
                                                                    {{--                                                                                        ["Label" => "باك" , "Value" => "Decision"]--}}
                                                                    {{--                                                                                    ]--}}
                                                                    {{--                                                                                ])--}}
                                                                    {{--                                                                            </div>--}}
                                                                    {{--                                                                        </div>--}}
                                                                    {{--                                                                    </div>--}}
                                                                    {{--                                                                </div>--}}
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         data-TargetName="CreateReportBy"
                                                                         data-TargetCheckboxName="10">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Select">
                                                                                <div class="Select__Area">
                                                                                    @php
                                                                                        $EducationLevel = [] ;
                                                                                        foreach ($education_level as $index=>$Level) {
                                                                                            array_push($EducationLevel , [ "Label" => $Level
                                                                                                , "Value" => $index , "Name" => "education_level_id[]"] ) ;
                                                                                        }
                                                                                    @endphp

                                                                                    @include("System.Components.multiSelector" , [
                                                                                            'Name' => "_" , "NameIDs" => "EducationID" ,
                                                                                            "DefaultValue" => "" , "Label" => __("degree") ,
                                                                                            "Options" => $EducationLevel
                                                                                        ])
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         data-TargetName="CreateReportBy"
                                                                         data-TargetCheckboxName="14">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Select">
                                                                                <div class="Select__Area">
                                                                                    @php
                                                                                        $Positions = [] ;
                                                                                        foreach ($position as $index=>$ItemPosition) {
                                                                                            array_push($Positions , [ "Label" => $ItemPosition
                                                                                                , "Value" => $index , "Name" => "position_id[]" ]) ;
                                                                                        }
                                                                                    @endphp

                                                                                    @include("System.Components.multiSelector" , [
                                                                                            'Name' => "_" , "Required" => "true" ,
                                                                                            "NameIDs" => "PositionID" , "DefaultValue" => "" ,
                                                                                            "Label" => __("jobPosition") ,
                                                                                            "Options" => $Positions
                                                                                        ])
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Work Employee Information --}}
                                                        <div class="VisibilityTarget ListData"
                                                             data-TargetName="CreateReportBy"
                                                             data-TargetCheckboxName="8,12,22,24,25,27">
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("reportByEmployeeInformationWork")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div class="Row GapC-1-5">
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         data-TargetName="CreateReportBy"
                                                                         data-TargetCheckboxName="8">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Select">
                                                                                <div class="Select__Area">
                                                                                    @php
                                                                                        $ContractType = [] ;
                                                                                        foreach ($contract_type as $Type) {
                                                                                            array_push($ContractType , [ "Label" => $Type ,
                                                                                                 "Value" => $Type]) ;
                                                                                        }
                                                                                    @endphp

                                                                                    @include("System.Components.selector" , [
                                                                                            'Name' => "contract_type" , "Required" => "true" ,
                                                                                            "DefaultValue" => "" , "Label" => __("contractType") ,
                                                                                            "Options" => $ContractType
                                                                                        ])
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    {{--                                                                <div class="VisibilityTarget Col-4-md Col-6-sm"--}}
                                                                    {{--                                                                     data-TargetName="CreateReportBy"--}}
                                                                    {{--                                                                     data-TargetCheckboxName="18">--}}
                                                                    {{--                                                                    <div class="VisibilityOption Form__Group"--}}
                                                                    {{--                                                                         data-ElementsTargetName="EvaluationBy">--}}
                                                                    {{--                                                                        <div class="Form__Select">--}}
                                                                    {{--                                                                            <div class="Select__Area">--}}
                                                                    {{--                                                                                @php--}}
                                                                    {{--                                                                                    $TypesEvaluation = [] ;--}}
                                                                    {{--                                                                                    foreach ($typeEvaluation as $index=>$Type) {--}}
                                                                    {{--                                                                                        array_push($TypesEvaluation , [ "Label" => $Type--}}
                                                                    {{--                                                                                            , "Value" => $index , "Name" => "typeEvaluation[".$index."]"] ) ;--}}
                                                                    {{--                                                                                    }--}}
                                                                    {{--                                                                                @endphp--}}

                                                                    {{--                                                                                @include("System.Components.multiSelector" , [--}}
                                                                    {{--                                                                                        'Name' => "_" , "NameIDs" => "EvaluationTypeID" ,--}}
                                                                    {{--                                                                                        "DefaultValue" => "" , "Label" => "انواع التقييم المرادة" ,--}}
                                                                    {{--                                                                                        "Options" => $TypesEvaluation--}}
                                                                    {{--                                                                                    ])--}}
                                                                    {{--                                                                            </div>--}}
                                                                    {{--                                                                        </div>--}}
                                                                    {{--                                                                    </div>--}}
                                                                    {{--                                                                </div>--}}
                                                                    {{--                                                                @foreach($typeEvaluation as $Index=>$typeEvaluationItem)--}}
                                                                    {{--                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"--}}
                                                                    {{--                                                                         data-TargetName="EvaluationBy"--}}
                                                                    {{--                                                                         data-TargetCheckboxName="typeEvaluation[{{$Index}}]">--}}
                                                                    {{--                                                                        <div class="Form__Group"--}}
                                                                    {{--                                                                             data-ErrorBackend="{{ Errors($typeEvaluationItem) }}">--}}
                                                                    {{--                                                                            <div class="Form__Input">--}}
                                                                    {{--                                                                                <div class="Input__Area">--}}
                                                                    {{--                                                                                    <input id="EvaluationValue_{{ $typeEvaluationItem }}" class="Input__Field"--}}
                                                                    {{--                                                                                           type="number" name="{{ $typeEvaluationItem }}"--}}
                                                                    {{--                                                                                           min="1" max="10"--}}
                                                                    {{--                                                                                           placeholder="درجة ال@lang($typeEvaluationItem)">--}}
                                                                    {{--                                                                                    <label class="Input__Label"--}}
                                                                    {{--                                                                                           for="EvaluationValue_{{ $typeEvaluationItem }}">--}}
                                                                    {{--                                                                                        درجة ال@lang($typeEvaluationItem)--}}
                                                                    {{--                                                                                    </label>--}}
                                                                    {{--                                                                                </div>--}}
                                                                    {{--                                                                            </div>--}}
                                                                    {{--                                                                        </div>--}}
                                                                    {{--                                                                    </div>--}}
                                                                    {{--                                                                @endforeach--}}
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         data-TargetName="CreateReportBy"
                                                                         data-TargetCheckboxName="24">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Select">
                                                                                <div class="Select__Area">
                                                                                    @php
                                                                                        $Departments = [] ;
                                                                                        foreach ($sections as $index=>$Type) {
                                                                                            array_push($Departments , [ "Label" => $Type
                                                                                                , "Value" => $index , "Name" => "section_id[]"]) ;
                                                                                        }
                                                                                    @endphp

                                                                                    @include("System.Components.multiSelector" , [
                                                                                            'Name' => "_" , "Required" => "true" ,
                                                                                            "NameIDs" => "SessionID" , "DefaultValue" => "" ,
                                                                                            "Label" => __("departmentDepend") ,
                                                                                            "Options" => $Departments
                                                                                        ])
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         data-TargetName="CreateReportBy"
                                                                         data-TargetCheckboxName="12">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Select">
                                                                                <div class="Select__Area">
                                                                                    @php
                                                                                        $MemberShip = [] ;
                                                                                        foreach ($membership_type as $index=>$Type) {
                                                                                            array_push($MemberShip , [ "Label" => $Type
                                                                                                , "Value" => $index , "Name" => "membership_type_id[]"]) ;
                                                                                        }
                                                                                    @endphp

                                                                                    @include("System.Components.multiSelector" , [
                                                                                            'Name' => "_" , "Required" => "true" ,
                                                                                            "NameIDs" => "MemberShipID" , "DefaultValue" => "" ,
                                                                                            "Label" => __("memberships") ,
                                                                                            "Options" => $MemberShip
                                                                                        ])
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         data-TargetName="CreateReportBy"
                                                                         data-TargetCheckboxName="25">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Select">
                                                                                <div class="Select__Area">
                                                                                    @php
                                                                                        $TypeDecision = [] ;
                                                                                        foreach ($type_decision as $index=>$Type) {
                                                                                            array_push($TypeDecision , [ "Label" => $Type
                                                                                                , "Value" => $index , "Name" => "type_decision_id[]"]) ;
                                                                                        }
                                                                                    @endphp

                                                                                    @include("System.Components.multiSelector" , [
                                                                                            'Name' => "_" , "Required" => "true" ,
                                                                                            "NameIDs" => "DecisionID" , "DefaultValue" => "" ,
                                                                                            "Label" => __("typeOfDecisions") ,
                                                                                            "Options" => $TypeDecision
                                                                                        ])
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         data-TargetName="CreateReportBy"
                                                                         data-TargetCheckboxName="27">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Input">
                                                                                <div class="Input__Area">
                                                                                    <input id="CurrentJobID" class="Input__Field"
                                                                                           type="text" name="current_job"
                                                                                           placeholder="@lang("currentJob")">
                                                                                    <label class="Input__Label" for="CurrentJobID">
                                                                                        @lang("currentJob")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Salary Employee Information --}}
                                                        <div class="VisibilityTarget ListData"
                                                             data-TargetName="CreateReportBy"
                                                             data-TargetCheckboxName="20,21">
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("reportByEmployeeSalaryInformation")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div class="Row GapC-1-5">
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         data-TargetName="CreateReportBy"
                                                                         data-TargetCheckboxName="20">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Input">
                                                                                <div class="Input__Area">
                                                                                    <input id="FromSalary" class="Input__Field"
                                                                                           type="number" name="from_salary"
                                                                                           placeholder="@lang("fromSalary")">
                                                                                    <label class="Input__Label" for="FromSalary">
                                                                                        @lang("fromSalary")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         data-TargetName="CreateReportBy"
                                                                         data-TargetCheckboxName="20">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Input">
                                                                                <div class="Input__Area">
                                                                                    <input id="ToSalary" class="Input__Field"
                                                                                           type="number" name="to_salary"
                                                                                           placeholder="الى الراتب">
                                                                                    <label class="Input__Label" for="ToSalary">
                                                                                        @lang("toSalary")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         data-TargetName="CreateReportBy"
                                                                         data-TargetCheckboxName="21">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Input">
                                                                                <div class="Input__Area">
                                                                                    <input id="TopSalary" class="Input__Field"
                                                                                           type="number" name="salary"
                                                                                           placeholder="سقف الراتب">
                                                                                    <label class="Input__Label" for="TopSalary">
                                                                                        @lang("maximumSalary")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="VisibilityTarget ListData"
                                                             data-TargetName="CreateReportBy"
                                                             data-TargetCheckboxName="11"
                                                             id="ReportLanguage">
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("reportByLanguageInformation")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div id="MainComponentLanguage">
                                                                    <div class="CloneItem ListData__Group"
                                                                         data-NameElement="LangData">
                                                                        <div class="Row GapC-1-5">
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group LanguageName">
                                                                                    <div class="Form__Select">
                                                                                        <div class="Select__Area">
                                                                                            @php
                                                                                                $LangList = [] ;
                                                                                                foreach ($language as $Index => $LangItem) {
                                                                                                    array_push($LangList , [
                                                                                                        "Label" => $LangItem , "Value" => $Index]) ;
                                                                                                }
                                                                                            @endphp
                                                                                            @include("System.Components.selector" , [
                                                                                                'Name' => "_" , "Required" => "true" ,
                                                                                                "DefaultValue" => "" , "Label" => __("selectedLanguage") ,
                                                                                                "Options" => $LangList
                                                                                            ])
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            @php
                                                                                $LangList = [] ;
                                                                                foreach ($language_skills_read_write
                                                                                as $LangSkill) {
                                                                                    array_push($LangList , [
                                                                                        "Label" => $LangSkill
                                                                                        , "Value" => $LangSkill]) ;
                                                                                }
                                                                            @endphp
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group LanguageWrite">
                                                                                    <div class="Form__Select">
                                                                                        <div class="Select__Area">
                                                                                            @include("System.Components.selector" , [
                                                                                                'Name' => "_" , "Required" => "true" ,
                                                                                                "DefaultValue" => "" , "Label" => __("writingSkill") ,
                                                                                                "Options" => $LangList
                                                                                            ])
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group LanguageRead">
                                                                                    <div class="Form__Select">
                                                                                        <div class="Select__Area">
                                                                                            @include("System.Components.selector" , [
                                                                                                'Name' => "_" , "Required" => "true" ,
                                                                                                "DefaultValue" => "" , "Label" => __("readingSkill") ,
                                                                                                "Options" => $LangList
                                                                                            ])
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="ParentClone"
                                                                     data-NameElement="LangData"></div>
                                                                <div class="Row GapC-1-5">
                                                                    <div class="Col-12 Center">
                                                                        <i class="ButtonCloneForm material-icons Button Button--Primary"
                                                                           data-TargetElementName="LangData"
                                                                           data-IsCloneClear="true"
                                                                           id="AddLanguageButton"
                                                                           title="Add Another Day">add</i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Button Submit --}}
                                                        <div class="Row">
                                                            <div class="Col">
                                                                <div class="Form__Group">
                                                                    <div class="Form__Button">
                                                                        <button class="Button Send"
                                                                                type="submit">
                                                                            @lang("viewResult")
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
