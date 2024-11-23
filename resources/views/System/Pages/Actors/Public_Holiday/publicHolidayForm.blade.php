<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionPublicHolidayRead = $MyAccount->can("read_public_holidays") || $MyAccount->can("all_public_holidays") ;
    $IsHavePermissionPublicHolidayEdit = $MyAccount->can("update_public_holidays") || $MyAccount->can("all_public_holidays") ;
    $IsHavePermissionPublicHolidayDelete = $MyAccount->can("delete_public_holidays") || $MyAccount->can("all_public_holidays") ;
    $IsHavePermissionPublicHolidayExport = $MyAccount->can("export_public_holidays") || $MyAccount->can("all_public_holidays") ;
    $IsHavePermissionPublicHolidayCreate = $MyAccount->can("create_public_holidays") || $MyAccount->can("all_public_holidays") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    @if((isset($publicHoliday) && $IsHavePermissionPublicHolidayEdit) ||
        (!isset($publicHoliday) && $IsHavePermissionPublicHolidayCreate))
        <section class="MainContent__Section MainContent__Section--PublicHolidayForm">
            <div class="PublicHolidayFormPage">
                <div class="PublicHolidayFormPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => isset($publicHoliday) ? __("editPublicHoliday") : __("addNewPublicHoliday") ,
                        'paths' => [[__("home") , '#'] , ['Page']] ,
                        'summery' => __("titleAddNewPublicHoliday")
                    ])
                </div>
                <div class="PublicHolidayFormPage__Content">
                    <div class="Row">
                        <div class="PublicHolidayFormPage__Form">
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
                                                          action="{{ isset($publicHoliday) ? route("system.public_holidays.update" , $publicHoliday["id"])
                                                                : route("system.public_holidays.store") }}"
                                                          method="post">
                                                        @csrf
                                                        @if(isset($publicHoliday))
                                                            @method("put")
                                                        @endif
                                                        <div class="ListData" >
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("basicPublicHoliday")
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
                                                                                        <input id="PublicHolidayName" class="Input__Field"
                                                                                               type="text" name="name"
                                                                                               value="{{ isset($publicHoliday) ? $publicHoliday["name"] : "" }}"
                                                                                               placeholder="@lang("publicHolidayName")" required>
                                                                                        <label class="Input__Label" for="PublicHolidayName">
                                                                                            @lang("publicHolidayName")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("start_date") }}">
                                                                                <div class="Form__Date">
                                                                                    <div class="Date__Area">
                                                                                        <input id="PublicHolidayDate_S" class="DateMinToday Date__Field"
                                                                                               TargetDateStartName="StartDatePublicHoliday"
                                                                                               value="{{isset($publicHoliday) ? $publicHoliday["start_date"] : ""}}"
                                                                                               type="date" name="start_date"
                                                                                               placeholder="@lang("startDateFrom")" required>
                                                                                        <label class="Date__Label" for="PublicHolidayDate_S">
                                                                                            @lang("startDateFrom")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("end_date") }}">
                                                                                <div class="Form__Date">
                                                                                    <div class="Date__Area">
                                                                                        <input id="PublicHolidayDate_E"
                                                                                               class="DateEndFromStart Date__Field"
                                                                                               data-StartDateName="StartDatePublicHoliday"
                                                                                               value="{{isset($publicHoliday) ? $publicHoliday["end_date"] : ""}}"
                                                                                               type="date" name="end_date" required
                                                                                               placeholder="@lang("endDateFrom")">
                                                                                        <label class="Date__Label" for="PublicHolidayDate_E">
                                                                                            @lang("endDateFrom")
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
                                                                            @if(isset($publicHoliday))
                                                                                @lang("editPublicHolidayInfo")
                                                                            @else
                                                                                @lang("addNewHoliday")
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
