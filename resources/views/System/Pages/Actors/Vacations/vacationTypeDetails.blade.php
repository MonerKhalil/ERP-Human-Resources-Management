<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionVacationTypeRead = $MyAccount->can("read_leave_types") || $MyAccount->can("all_leave_types") ;
    $IsHavePermissionVacationTypeEdit = $MyAccount->can("update_leave_types") || $MyAccount->can("all_leave_types") ;
    $IsHavePermissionVacationTypeDelete = $MyAccount->can("delete_leave_types") || $MyAccount->can("all_leave_types") ;
    $IsHavePermissionVacationTypeExport = $MyAccount->can("export_leave_types") || $MyAccount->can("all_leave_types") ;
?>


@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--DecisionDetailsPage">
        <div class="DecisionDetailsPage">
            <div class="DecisionDetailsPage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __("vocationTypeDetails") ,
                    'paths' => [[__("home") , '#'] , [__("vocationTypeDetails")]] ,
                    'summery' => __("titleVocationTypeDetails")
                ])
            </div>
            <div class="DecisionDetailsPage__Content">
                <div class="Container--MainContent">
                    <div class="MessageProcessContainer">
                        @include("System.Components.messageProcess")
                    </div>
                    <div class="Row">
                        <div class="Col">
                            <div class="Card">
                                <div class="Card__Inner">
                                    @if($IsHavePermissionVacationTypeRead)
                                        <div class="ListData NotResponsive">
                                            <div class="ListData__Head">
                                                <h4 class="ListData__Title">
                                                    @lang("basics")
                                                </h4>
                                            </div>
                                            <div class="ListData__Content">
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("nameType")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{ $leaveType["name"] }}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("vocationType")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$leaveType["type_effect_salary"]}}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("vocationDays")
                                                    </span>
                                                        <span class="Data_Value">
                                                        @if($leaveType["leave_limited"])
                                                                @lang("vocationClose")
                                                            @else
                                                                @lang("vocationOpen")
                                                            @endif
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("vocationDaysInYear")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$leaveType["max_days_per_years"] ?? "_"}}
                                                    </span>
                                                    </div>
                                                </div>
                                                {{--                                            <div class="ListData__Item ListData__Item--NoAction">--}}
                                                {{--                                                <div class="Data_Col">--}}
                                                {{--                                                    <span class="Data_Label">--}}
                                                {{--                                                        عدد الايام المسموحة بالشهر--}}
                                                {{--                                                    </span>--}}
                                                {{--                                                    <span class="Data_Value">--}}
                                                {{--                                                        {{$leaveType["max_days_per_month"] ?? "_"}}--}}
                                                {{--                                                    </span>--}}
                                                {{--                                                </div>--}}
                                                {{--                                            </div>--}}
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("isVocationHourly")
                                                    </span>
                                                        <span class="Data_Value">
                                                        @if($leaveType["is_hourly"])
                                                                @lang("applied")
                                                            @else
                                                                @lang("notApplied")
                                                            @endif
                                                    </span>
                                                    </div>
                                                </div>

                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("isCanAppliedAsHoursNotDetermine")
                                                    </span>
                                                        <span class="Data_Value">
                                                        @if($leaveType["can_take_hours"])
                                                                @lang("yes")
                                                            @else
                                                                @lang("no")
                                                            @endif
                                                    </span>
                                                    </div>
                                                </div>

                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("vocationHourlyDetermineCanTaken")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$leaveType["max_hours_per_day"] ?? "_"}}
                                                    </span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="ListData NotResponsive">
                                            <div class="ListData__Head">
                                                <h4 class="ListData__Title">
                                                    @lang("infoAboutEmployeeWhoHasVocation")
                                                </h4>
                                            </div>
                                            <div class="ListData__Item ListData__Item--NoAction">
                                                <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("gender")
                                                    </span>
                                                    <span class="Data_Value">
                                                        {{$leaveType["gender"]}}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ListData__Content">
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("yearEmployeeWork")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$leaveType["years_employee_services"] ?? "_"}}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("yearEmployeeWorkExtra")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$leaveType["number_years_services_increment_days"] ?? "_"}}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("vocationTernPlus")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$leaveType["count_available_in_service"] ?? "_"}}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("vocationDaysAdded")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$leaveType["count_days_increment_days"] ?? "_"}}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("reteDiscountForOneDay")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$leaveType["rate_effect_salary"] ?? "_"}}
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($IsHavePermissionVacationTypeEdit || $IsHavePermissionVacationTypeDelete)
                                        <div class="ListData">
                                                <div class="ListData__Head">
                                                    <h4 class="ListData__Title">
                                                        @lang("operationOnVocationType")
                                                    </h4>
                                                </div>
                                                <div class="ListData__Content">
                                                    <div class="Card__Inner px0">
                                                        @if($IsHavePermissionVacationTypeEdit)
                                                            <a href="{{ route("system.leave_types.edit" , $leaveType["id"]) }}"
                                                               class="Button Button--Primary">
                                                                @lang("editVocationType")
                                                            </a>
                                                        @endif
                                                        @if($IsHavePermissionVacationTypeDelete)
                                                            <form class="Form"
                                                                  style="display: inline-block" method="post"
                                                                  action="{{ route("system.leave_types.destroy" , $leaveType["id"]) }}">
                                                                @csrf
                                                                @method("delete")
                                                                <button type="submit" class="Button Button--Danger">
                                                                    @lang("removeType")
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
