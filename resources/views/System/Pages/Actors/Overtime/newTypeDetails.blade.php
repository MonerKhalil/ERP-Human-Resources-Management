<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionOverTimeTypeRead = $MyAccount->can("read_overtime_types") || $MyAccount->can("all_overtime_types") ;
    $IsHavePermissionOverTimeTypeEdit = $MyAccount->can("update_overtime_types") || $MyAccount->can("all_overtime_types") ;
    $IsHavePermissionOverTimeTypeDelete = $MyAccount->can("delete_overtime_types") || $MyAccount->can("all_overtime_types") ;
    $IsHavePermissionOverTimeTypeExport = $MyAccount->can("export_overtime_types") || $MyAccount->can("all_overtime_types") ;
    $IsHavePermissionOverTimeTypeCreate = $MyAccount->can("create_overtime_types") || $MyAccount->can("all_overtime_types") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--OverTimeDetailsPage">
        <div class="OverTimeDetailsPage">
            <div class="OverTimeDetailsPage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __("viewOvertimeDetails") ,
                    'paths' => [[__("home") , '#'] , [__("viewOvertimeDetails")]] ,
                    'summery' => __("titleViewOvertimeDetails")
                ])
            </div>
            <div class="OverTimeDetailsPage__Content">
                <div class="Container--MainContent">
                    <div class="MessageProcessContainer">
                        @include("System.Components.messageProcess")
                    </div>
                    <div class="Row">
                        <div class="Col">
                            <div class="Card">
                                <div class="Card__Inner">
                                    @if($IsHavePermissionOverTimeTypeRead)
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
                                                        {{ $overtimeType["name"] }}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("rateMaxSalaryExtra")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{ $overtimeType["max_rate_salary"] }}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("minimumHourForAcceptOvertime")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{ $overtimeType["min_hours_in_days"] }}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("amountSalaryInHour")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{ $overtimeType["salary_in_hours"] }}
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($IsHavePermissionOverTimeTypeEdit || $IsHavePermissionOverTimeTypeDelete)
                                        <div class="ListData">
                                                <div class="ListData__Head">
                                                    <h4 class="ListData__Title">
                                                        @lang("operationOnOvertime")
                                                    </h4>
                                                </div>
                                                <div class="ListData__Content">
                                                    <div class="Card__Inner px0">
                                                        @if($IsHavePermissionOverTimeTypeEdit)
                                                            <a href="{{ route("system.overtime_types.edit" , $overtimeType["id"]) }}"
                                                               class="Button Button--Primary">
                                                                @lang("editType")
                                                            </a>
                                                        @endif
                                                        @if($IsHavePermissionOverTimeTypeDelete)
                                                            <form class="Form"
                                                                  style="display: inline-block" method="post"
                                                                  action="{{ route("system.overtime_types.destroy" , $overtimeType["id"]) }}">
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
