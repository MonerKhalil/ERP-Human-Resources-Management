<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionWorkSettingRead = $MyAccount->can("read_work_settings") || $MyAccount->can("all_work_settings") ;
    $IsHavePermissionWorkSettingEdit = $MyAccount->can("update_work_settings") || $MyAccount->can("all_work_settings") ;
    $IsHavePermissionWorkSettingDelete = $MyAccount->can("delete_work_settings") || $MyAccount->can("all_work_settings") ;
    $IsHavePermissionWorkSettingExport = $MyAccount->can("export_work_settings") || $MyAccount->can("all_work_settings") ;
    $IsHavePermissionWorkSettingCreate = $MyAccount->can("create_work_settings") || $MyAccount->can("all_work_settings") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    @if((isset($workSetting) && $IsHavePermissionWorkSettingEdit) ||
        (!isset($workSetting) && $IsHavePermissionWorkSettingCreate))
        <section class="MainContent__Section MainContent__Section--SettingWorkForm">
            <div class="SettingWorkFormPage">
                <div class="SettingWorkFormPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => isset($workSetting) ? __("editWorkSetting") : __("addWorkSetting") ,
                        'paths' => [[__("home") , '#'] , ['Page']] ,
                        'summery' => __("titleAddWorkSetting")
                    ])
                </div>
                <div class="SettingWorkFormPage__Content">
                    <div class="FormSetting__Content">
                        <div class="Row">
                            <div class="SettingWorkFormPage__Form">
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
                                                              action="{{ (isset($workSetting)) ? route("system.work_settings.update" , $workSetting["id"])
                                                                    :  route("system.work_settings.store") }}"
                                                              method="post">
                                                            @csrf
                                                            @if(isset($workSetting))
                                                                @method("put")
                                                            @endif
                                                            <div class="ListData">
                                                                <div class="ListData__Content">
                                                                    <div class="ListData__Head">
                                                                        <h4 class="ListData__Title">
                                                                            @lang("basicWorkSettingInfo")
                                                                        </h4>
                                                                    </div>
                                                                    <div class="ListData__CustomItem">
                                                                        <div class="Row GapC-1-5">
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("name") }}">
                                                                                    <div class="Form__Input">
                                                                                        <div class="Input__Area">
                                                                                            <input id="WorkSettingName" class="Input__Field"
                                                                                                   type="text" name="name"
                                                                                                   @if(isset($workSetting))
                                                                                                   value="{{ $workSetting["name"] }}"
                                                                                                   @endif
                                                                                                   placeholder="@lang("workSettingName")" required>
                                                                                            <label class="Input__Label" for="WorkSettingName">
                                                                                                @lang("workSettingName")
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("work_hours_from") }}">
                                                                                    <div class="Form__Date">
                                                                                        <div class="Date__Area">
                                                                                            <input id="StartWorkFrom"
                                                                                                   class="TimeNoDate Date__Field"
                                                                                                   type="time" name="work_hours_from"
                                                                                                   placeholder="@lang("workSettingStartDate)"
                                                                                                   @if(isset($workSetting))
                                                                                                   value="{{ $workSetting["work_hours_from"] ?? "" }}"
                                                                                                   @endif
                                                                                                   required>
                                                                                            <label class="Date__Label"
                                                                                                   for="StartWorkFrom">
                                                                                                @lang("workSettingStartDate")
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("work_hours_to") }}">
                                                                                    <div class="Form__Date">
                                                                                        <div class="Date__Area">
                                                                                            <input id="EndWorkIn"
                                                                                                   class="TimeNoDate Date__Field"
                                                                                                   type="time" name="work_hours_to"
                                                                                                   @if(isset($workSetting))
                                                                                                   value="{{ $workSetting["work_hours_to"] ?? "" }}"
                                                                                                   @endif
                                                                                                   placeholder="@lang("workSettingEndDate")"
                                                                                                   required>
                                                                                            <label class="Date__Label"
                                                                                                   for="EndWorkIn">
                                                                                                @lang("workSettingEndDate")
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("days") }}">
                                                                                    <div class="Form__Select">
                                                                                        <div class="Select__Area">
                                                                                            @php
                                                                                                $Days = [] ;
                                                                                                if(isset($workSetting)) {
                                                                                                    $ListDays = explode(",",$workSetting["days_leaves_in_weeks"]) ;
                                                                                                    foreach ($days as $Day) {
                                                                                                        $IsChecked = false ;
                                                                                                        foreach ($ListDays as $DayItem)
                                                                                                            if($DayItem == $Day)
                                                                                                                $IsChecked = true ;
                                                                                                        array_push($Days , [ "Name" => "days[]" ,
                                                                                                             "IsChecked" => $IsChecked ,
                                                                                                             "Label" => $Day ,
                                                                                                             "Value" => $Day]) ;
                                                                                                    }
                                                                                                } else {
                                                                                                    foreach ($days as $Day)
                                                                                                        array_push($Days , [ "Name" => "days[]" ,
                                                                                                             "Label" => $Day ,
                                                                                                             "Value" => $Day]) ;
                                                                                                }
                                                                                            @endphp
                                                                                            @include("System.Components.multiSelector" , [
                                                                                                'Name' => "_" , "NameIDs" => "DaysID" ,
                                                                                                "Required" => "true" ,
                                                                                                "Label" => __("holidaysDayWant") ,
                                                                                                "Options" => $Days
                                                                                            ])
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("late_enter_allowance_per_minute") }}">
                                                                                    <div class="Form__Input">
                                                                                        <div class="Input__Area">
                                                                                            <input id="LateAllowanceMinute" class="Input__Field"
                                                                                                   @if(isset($workSetting))
                                                                                                   value="{{ $workSetting["late_enter_allowance_per_minute"] }}"
                                                                                                   @endif
                                                                                                   type="number" name="late_enter_allowance_per_minute"
                                                                                                   placeholder="@lang("lateAllowanceMinute")" required>
                                                                                            <label class="Input__Label" for="LateAllowanceMinute">
                                                                                                @lang("lateAllowanceMinute")
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("early_out_allowance_per_minute") }}">
                                                                                    <div class="Form__Input">
                                                                                        <div class="Input__Area">
                                                                                            <input id="EarlyAllowanceMinute" class="Input__Field"
                                                                                                   @if(isset($workSetting))
                                                                                                   value="{{ $workSetting["early_out_allowance_per_minute"] }}"
                                                                                                   @endif
                                                                                                   type="number" name="early_out_allowance_per_minute"
                                                                                                   placeholder="@lang("earlyAllowanceMinute")" required>
                                                                                            <label class="Input__Label" for="EarlyAllowanceMinute">
                                                                                                @lang("earlyAllowanceMinute")
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("salary_default") }}">
                                                                                    <div class="Form__Input">
                                                                                        <div class="Input__Area">
                                                                                            <input id="SalaryExtra" class="Input__Field"
                                                                                                   type="number" name="salary_default"
                                                                                                   @if(isset($workSetting))
                                                                                                        value="{{ $workSetting["salary_default"] }}"
                                                                                                   @endif
                                                                                                   placeholder="@lang("DefaultSalary")" required>
                                                                                            <label class="Input__Label" for="SalaryExtra">
                                                                                                @lang("DefaultSalary")
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("rate_deduction_from_salary") }}">
                                                                                    <div class="Form__Input">
                                                                                        <div class="Input__Area">
                                                                                            <input id="RateDiscountLate" class="Input__Field"
                                                                                                   type="number" name="rate_deduction_from_salary"
                                                                                                   @if(isset($workSetting))
                                                                                                        value="{{ $workSetting["rate_deduction_from_salary"] }}"
                                                                                                   @endif
                                                                                                   min="0" max="100"
                                                                                                   placeholder="@lang("RateValueDiscountLate")" required>
                                                                                            <label class="Input__Label" for="RateDiscountLate">
                                                                                                @lang("RateValueDiscountLate")
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("type_discount_minuteOrHour") }}">
                                                                                    <div class="Form__Select">
                                                                                        <div class="Select__Area">
                                                                                            @php
                                                                                                $Options = [] ;
                                                                                                 array_push($Options , [ "Label" => __("minutes") , "Value" => "minute"]) ;
                                                                                                 array_push($Options , [ "Label" => __("hours") , "Value" => "hour"]) ;
                                                                                            @endphp

                                                                                            @include("System.Components.selector" , [
                                                                                                'Name' => "type_discount_minuteOrHour" , "Required" => "true" ,
                                                                                                "DefaultValue" => isset($workSetting) ? $workSetting["type_discount_minuteOrHour"] : ""
                                                                                                , "Label" => __("DiscountBy") ,
                                                                                                "Options" => $Options
                                                                                            ])
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("rate_deduction_attendance_dont_check_out") }}">
                                                                                    <div class="Form__Input">
                                                                                        <div class="Input__Area">
                                                                                            <input id="RateDiscountForCheckOut" class="Input__Field"
                                                                                                   type="number" name="rate_deduction_attendance_dont_check_out"
                                                                                                   @if(isset($workSetting))
                                                                                                        value="{{ $workSetting["rate_deduction_attendance_dont_check_out"] }}"
                                                                                                   @endif
                                                                                                   min="0" max="100"
                                                                                                   placeholder="@lang("rate_deduction_attendance_dont_check_out")" required>
                                                                                            <label class="Input__Label" for="RateDiscountForCheckOut">
                                                                                                @lang("rate_deduction_attendance_dont_check_out")
                                                                                            </label>
                                                                                        </div>
                                                                                        <label class="Form__Tips" for="RateDiscountForCheckOut">
                                                                                            <small>
                                                                                                @lang("Title_rate_deduction_attendance_dont_check_out")
                                                                                            </small>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-12">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("description") }}">
                                                                                    <div class="Form__Textarea">
                                                                                        <div class="Textarea__Area">
                                                                                        <textarea id="Description" name="description"
                                                                                                  class="Textarea__Field"
                                                                                                  placeholder="@lang("workSettingDescription")"
                                                                                                  rows="3">@if(isset($workSetting)){{ $workSetting["description"] ?? "" }}@endif</textarea>
                                                                                            <label class="Textarea__Label"
                                                                                                   for="Description">
                                                                                                @lang("workSettingDescription")
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="Row">
                                                                <div class="Col">
                                                                    <div class="Form__Group">
                                                                        <div class="Form__Button">
                                                                            <button class="Button Send"
                                                                                    type="submit">
                                                                                @lang("AdjustWorkSettingType")
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
            </div>
        </section>
    @endif
@endsection
