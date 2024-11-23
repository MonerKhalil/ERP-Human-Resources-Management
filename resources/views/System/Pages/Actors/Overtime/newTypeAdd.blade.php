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
    @if((isset($overtimeType) && $IsHavePermissionOverTimeTypeEdit) ||
        (!isset($overtimeType) && $IsHavePermissionOverTimeTypeCreate))
        <section class="MainContent__Section MainContent__Section--NewTypeOvertimeForm">
            <div class="NewTypeOvertimeForm">
                <div class="NewTypeOvertimeForm__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => isset($overtimeType) ? __("editOvertimeTypePage") : __("addNewOvertimeType") ,
                        'paths' => [[__("home") , '#'] , ['Page']] ,
                        'summery' => __("titleAddNewOvertimeType")
                    ])
                </div>
                <div class="NewTypeOvertimeForm__Content">
                    <div class="Row">
                        <div class="NewTypeOvertimeForm__Form">
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
                                                          action="{{ isset($overtimeType) ? route("system.overtime_types.update" , $overtimeType["id"]) : route("system.overtime_types.store") }}"
                                                          method="post">
                                                        @csrf
                                                        @if(isset($overtimeType))
                                                            @method("put")
                                                        @endif
                                                        <div class="ListData" >
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("basicOvertimeInfo")
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
                                                                                        <input id="OverTimeName" class="Input__Field"
                                                                                               type="text" name="name"
                                                                                               value="{{ isset($overtimeType) ? $overtimeType["name"] : "" }}"
                                                                                               placeholder="@lang("nameType")">
                                                                                        <label class="Input__Label" for="OverTimeName">
                                                                                            @lang("nameType")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("max_rate_salary") }}">
                                                                                <div class="Form__Input">
                                                                                    <div class="Input__Area">
                                                                                        <input id="OverTimeMaxSalary"
                                                                                               class="Input__Field"
                                                                                               type="number" name="max_rate_salary"
                                                                                               value="{{ isset($overtimeType) ? $overtimeType["max_rate_salary"] : "" }}"
                                                                                               min="1" max="100"
                                                                                               placeholder="@lang("rateMaxSalaryExtra")">
                                                                                        <label class="Input__Label"
                                                                                               for="OverTimeMaxSalary">
                                                                                            @lang("rateMaxSalaryExtra")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("min_hours_in_days") }}">
                                                                                <div class="Form__Input">
                                                                                    <div class="Input__Area">
                                                                                        <input id="OverTimeMinHour"
                                                                                               class="Input__Field"
                                                                                               type="number" name="min_hours_in_days"
                                                                                               value="{{ isset($overtimeType) ? $overtimeType["min_hours_in_days"] : "" }}"
                                                                                               min="1" max="24"
                                                                                               placeholder="@lang("minimumHourForAcceptOvertime")">
                                                                                        <label class="Input__Label"
                                                                                               for="OverTimeMinHour">
                                                                                            @lang("minimumHourForAcceptOvertime")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("salary_in_hours") }}">
                                                                                <div class="Form__Input">
                                                                                    <div class="Input__Area">
                                                                                        <input id="OverTimeHourSalary"
                                                                                               class="Input__Field" min="1"
                                                                                               type="number" name="salary_in_hours"
                                                                                               value="{{ isset($overtimeType) ? $overtimeType["salary_in_hours"] : "" }}"
                                                                                               placeholder="@lang("amountSalaryInHour")">
                                                                                        <label class="Input__Label"
                                                                                               for="OverTimeHourSalary">
                                                                                            @lang("amountSalaryInHour")
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
                                                                            @if(isset($overtimeType))
                                                                                @lang("editType")
                                                                            @else
                                                                                @lang("addNewType")
                                                                            @endif
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
