<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionVacationTypeRead = $MyAccount->can("read_leave_types") || $MyAccount->can("all_leave_types") ;
    $IsHavePermissionVacationTypeEdit = $MyAccount->can("update_leave_types") || $MyAccount->can("all_leave_types") ;
    $IsHavePermissionVacationTypeDelete = $MyAccount->can("delete_leave_types") || $MyAccount->can("all_leave_types") ;
    $IsHavePermissionVacationTypeExport = $MyAccount->can("export_leave_types") || $MyAccount->can("all_leave_types") ;
    $IsHavePermissionVacationTypeCreate = $MyAccount->can("create_leave_types") || $MyAccount->can("all_leave_types") ;
?>


@extends("System.Pages.globalPage")

@section("ContentPage")
    @if((isset($leaveType) && $IsHavePermissionVacationTypeEdit) ||
        (!isset($leaveType) && $IsHavePermissionVacationTypeCreate))
        <section class="MainContent__Section MainContent__Section--NewTypeVacationForm">
            <div class="NewTypeVacationForm">
                <div class="NewTypeVacationForm__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => isset($leaveType) ? __("vocationFormEdit") : __("vocationForm") ,
                        'paths' => [[__("home") , '#'] , [__("vocationForm")]] ,
                        'summery' => isset($leaveType) ? __("TitleVocationFormEdit") : __("titleVocationForm")
                    ])
                </div>
                <div class="NewTypeVacationForm__Content">
                    <div class="Row">
                        <div class="NewTypeVacationForm__Form">
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
                                                          action="{{ isset($leaveType) ? route("system.leave_types.update" , $leaveType["id"])
                                                                : route("system.leave_types.store") }}"
                                                          method="post">
                                                        @csrf
                                                        @if(isset($leaveType))
                                                            @method("put")
                                                        @endif
                                                        <div class="ListData" >
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("basicVocationTypeInfo")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div class="ListData__CustomItem">
                                                                    <div class="Row GapC-1-5">
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("name") }}">
                                                                                <div class="Form__Input">
                                                                                    <div class="Input__Area">
                                                                                        <input id="VacationName" class="Input__Field"
                                                                                               type="text" name="name"
                                                                                               value="{{ isset($leaveType) ? $leaveType["name"] : "" }}"
                                                                                               placeholder="@lang("vocationName")" required>
                                                                                        <label class="Input__Label" for="VacationName">
                                                                                            @lang("vocationName")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("type_effect_salary") }}">
                                                                                <div class="VisibilityOption Form__Select"
                                                                                     data-VisibilityDefault="{{ isset($leaveType) ? $leaveType["type_effect_salary"] : "" }}"
                                                                                     data-ElementsTargetName="VacationTypeFields">
                                                                                    <div class="Select__Area">
                                                                                        @php
                                                                                            $TypeEffectSalary = [] ;
                                                                                            foreach ($type_effect_salary as $TypeEffect) {
                                                                                                array_push($TypeEffectSalary , [ "Label" => $TypeEffect ,
                                                                                                     "Value" => $TypeEffect] ) ;
                                                                                            }
                                                                                        @endphp
                                                                                        @include("System.Components.selector" , [
                                                                                            'Name' => "type_effect_salary" , "Required" => "true" ,
                                                                                            "DefaultValue" => isset($leaveType) ? $leaveType["type_effect_salary"] : "" ,
                                                                                             "Label" => __("vocationType") ,
                                                                                            "Options" => $TypeEffectSalary
                                                                                        ])
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("leave_limited") }}">
                                                                                <div class="VisibilityOption Form__Select"
                                                                                     data-VisibilityDefault="{{ isset($leaveType) ? $leaveType["leave_limited"] : "" }}"
                                                                                     data-ElementsTargetName="VacationTypeLimited">
                                                                                    <div class="Select__Area">
                                                                                        @include("System.Components.selector" , [
                                                                                            'Name' => "leave_limited" , "Required" => "true" ,
                                                                                            "DefaultValue" => isset($leaveType) ? $leaveType["leave_limited"] : "" ,
                                                                                            "Label" => __("vocationDays") ,
                                                                                            "Options" => [
                                                                                                [ "Label" => __("vocationOpen") , "Value" => "0"] ,
                                                                                                [ "Label" => __("vocationClose") , "Value" => "1"]
                                                                                            ]
                                                                                        ])
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                             data-TargetName="VacationTypeLimited"
                                                                             data-TargetValue="1">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("max_days_per_years") }}">
                                                                                <div class="Form__Input">
                                                                                    <div class="Input__Area">
                                                                                        <input id="VacationDurationYear" class="Input__Field"
                                                                                               type="number" name="max_days_per_years"
                                                                                               value="{{ isset($leaveType) ? $leaveType["max_days_per_years"] : "" }}"
                                                                                               min="1" max="365" required
                                                                                               placeholder="@lang("vocationDaysInYear")">
                                                                                        <label class="Input__Label" for="VacationDurationYear">
                                                                                            @lang("vocationDaysInYear")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        {{--                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"--}}
                                                                        {{--                                                                         data-TargetName="VacationTypeLimited"--}}
                                                                        {{--                                                                         data-TargetValue="1">--}}
                                                                        {{--                                                                        <div class="Form__Group">--}}
                                                                        {{--                                                                            <div class="Form__Input">--}}
                                                                        {{--                                                                                <div class="Input__Area">--}}
                                                                        {{--                                                                                    <input id="VacationMonthAllow" class="Input__Field"--}}
                                                                        {{--                                                                                           type="text" name="max_days_per_month"--}}
                                                                        {{--                                                                                           min="1" max="31" required--}}
                                                                        {{--                                                                                           value="{{ isset($leaveType) ? $leaveType["max_days_per_month"] : "" }}"--}}
                                                                        {{--                                                                                           placeholder="عدد الايام المسموحة بالشهر">--}}
                                                                        {{--                                                                                    <label class="Input__Label" for="VacationMonthAllow">--}}
                                                                        {{--                                                                                        عدد الايام المسموحة بالشهر--}}
                                                                        {{--                                                                                    </label>--}}
                                                                        {{--                                                                                </div>--}}
                                                                        {{--                                                                            </div>--}}
                                                                        {{--                                                                        </div>--}}
                                                                        {{--                                                                    </div>--}}
                                                                        <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                             data-TargetName="VacationTypeLimited"
                                                                             data-TargetValue="1">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("is_hourly") }}">
                                                                                <div class="VisibilityOption Form__Select"
                                                                                     data-VisibilityDefault="{{ isset($leaveType) ? $leaveType["is_hourly"] : "" }}"
                                                                                     data-ElementsTargetName="VacationIsHour">
                                                                                    <div class="Select__Area">
                                                                                        @include("System.Components.selector" , [
                                                                                            'Name' => "is_hourly" , "Required" => "true" ,
                                                                                            "DefaultValue" => isset($leaveType) ? $leaveType["is_hourly"] : "" ,
                                                                                             "Label" => __("vocationHourly") ,
                                                                                            "Options" => [
                                                                                                [ "Label" => __("yes") , "Value" => "1"] ,
                                                                                                [ "Label" => __("no") , "Value" => "0"]
                                                                                            ]
                                                                                        ])
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                             data-TargetName="VacationIsHour"
                                                                             data-TargetValue="0">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("can_take_hours") }}">
                                                                                <div class="Form__Select">
                                                                                    <div class="Select__Area">
                                                                                        @include("System.Components.selector" , [
                                                                                            'Name' => "can_take_hours" , "Required" => "true" ,
                                                                                            "DefaultValue" => isset($leaveType) ? $leaveType["can_take_hours"] : "" ,
                                                                                             "Label" => __("vocationHourlyOpening") ,
                                                                                            "Options" => [
                                                                                                [ "Label" => __("yes") , "Value" => "1"] ,
                                                                                                [ "Label" => __("no") , "Value" => "0"]
                                                                                            ]
                                                                                        ])
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                             data-TargetName="VacationIsHour"
                                                                             data-TargetValue="1">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("max_hours_per_day") }}">
                                                                                <div class="Form__Input">
                                                                                    <div class="Input__Area">
                                                                                        <input id="VacationDurationHour" class="Input__Field"
                                                                                               type="number" name="max_hours_per_day"
                                                                                               min="1" max="12" required
                                                                                               value="{{ isset($leaveType) ? $leaveType["max_hours_per_day"] : "" }}"
                                                                                               placeholder="@lang("vocationHourlyDetermineCanTaken")">
                                                                                        <label class="Input__Label" for="VacationDurationHour">
                                                                                            @lang("vocationHourlyDetermineCanTaken")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ListData">
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("employeeInfoForVocation")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div class="ListData__CustomItem">
                                                                    <div class="Row GapC-1-5">
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("years_employee_services") }}">
                                                                                <div class="Form__Select">
                                                                                    <div class="Select__Area">
                                                                                        <div class="Form__Input">
                                                                                            <div class="Input__Area">
                                                                                                <input id="ExperienceYears" class="Input__Field"
                                                                                                       type="number" name="years_employee_services"
                                                                                                       min="0" required
                                                                                                       value="{{ isset($leaveType) ? $leaveType["years_employee_services"] : "" }}"
                                                                                                       placeholder="@lang("yearEmployeeWork")">
                                                                                                <label class="Input__Label" for="ExperienceYears">
                                                                                                    @lang("yearEmployeeWork")
                                                                                                </label>
                                                                                            </div>
                                                                                            <label class="Form__Tips"
                                                                                                   for="ExperienceYears">
                                                                                                <small>
                                                                                                    @lang("summeryYearEmployeeWork")
                                                                                                </small>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("number_years_services_increment_days") }}">
                                                                                <div class="Form__Select">
                                                                                    <div class="Select__Area">
                                                                                        <div class="Form__Input">
                                                                                            <div class="Input__Area">
                                                                                                <input id="ExperienceYearsExtra" class="Input__Field"
                                                                                                       type="number" name="number_years_services_increment_days"
                                                                                                       min="1" required
                                                                                                       value="{{ isset($leaveType) ? $leaveType["number_years_services_increment_days"] : "" }}"
                                                                                                       placeholder="عدد سنوات العمل الاضافية">
                                                                                                <label class="Input__Label" for="ExperienceYearsExtra">
                                                                                                    @lang("yearEmployeeWorkExtra")
                                                                                                </label>
                                                                                            </div>
                                                                                            <label class="Form__Tips"
                                                                                                   for="ExperienceYearsExtra">
                                                                                                <small>
                                                                                                    @lang("summeryYearEmployeeWorkExtra")
                                                                                                </small>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("count_available_in_service") }}">
                                                                                <div class="Form__Select">
                                                                                    <div class="Select__Area">
                                                                                        <div class="Form__Input">
                                                                                            <div class="Input__Area">
                                                                                                <input id="MaxExperienceYearsExtra" class="Input__Field"
                                                                                                       type="number" name="count_available_in_service"
                                                                                                       value="{{ isset($leaveType) ? $leaveType["count_available_in_service"] : "" }}"
                                                                                                       placeholder="@lang("vocationTernPlus")" min="1" required>
                                                                                                <label class="Input__Label" for="MaxExperienceYearsExtra">
                                                                                                    @lang("vocationTernPlus")
                                                                                                </label>
                                                                                            </div>
                                                                                            <label class="Form__Tips"
                                                                                                   for="MaxExperienceYearsExtra">
                                                                                                <small>
                                                                                                    @lang("summeryVocationTernPlus")
                                                                                                </small>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("count_days_increment_days") }}">
                                                                                <div class="Form__Select">
                                                                                    <div class="Select__Area">
                                                                                        <div class="Form__Input">
                                                                                            <div class="Input__Area">
                                                                                                <input id="VacationDaysExtra" class="Input__Field" min="1"
                                                                                                       type="number" name="count_days_increment_days"
                                                                                                       value="{{ isset($leaveType) ? $leaveType["count_days_increment_days"] : "" }}"
                                                                                                       placeholder="@lang("vocationDaysAdded")">
                                                                                                <label class="Input__Label" for="VacationDaysExtra">
                                                                                                    @lang("vocationDaysAdded")
                                                                                                </label>
                                                                                            </div>
                                                                                            <label class="Form__Tips"
                                                                                                   for="VacationDaysExtra">
                                                                                                <small>
                                                                                                    @lang("summeryVocationDaysAdded")
                                                                                                </small>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("gender") }}">
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
                                                                                                'Name' => "gender" ,
                                                                                                "DefaultValue" => isset($leaveType) ? $leaveType["gender"] : "" ,
                                                                                                "Label" => __("gender") , "Required" => "true",
                                                                                                "Options" => $GenderTypes
                                                                                            ])
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                             data-TargetName="VacationTypeFields"
                                                                             data-TargetValue="effect_salary">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("rate_effect_salary") }}">
                                                                                <div class="Form__Input">
                                                                                    <div class="Input__Area">
                                                                                        <input id="SalaryDiscount" class="Input__Field"
                                                                                               type="number" name="rate_effect_salary"
                                                                                               value="{{ isset($leaveType) ? $leaveType["rate_effect_salary"] : "" }}"
                                                                                               min="0" max="100" required
                                                                                               placeholder="@lang("reteDiscountForOneDay")">
                                                                                        <label class="Input__Label" for="SalaryDiscount">
                                                                                            @lang("reteDiscountForOneDay")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="Row GapC-1-5">
                                                            <div class="Col">
                                                                <div class="Form__Group">
                                                                    <div class="Form__Button">
                                                                        <button class="Button Send"
                                                                                type="submit">
                                                                            @lang("addNewType")
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
