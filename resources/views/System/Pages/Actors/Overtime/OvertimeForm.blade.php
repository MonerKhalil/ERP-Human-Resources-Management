<?php
    $MyAccount = auth()->user() ;
    $IsMyOverTime = (!is_null(auth()->user()->employee["id"]));
    $IsHavePermissionOverTimeRead = $MyAccount->can("read_overtimes") || $MyAccount->can("all_overtimes") ;
    $IsHavePermissionOverTimeEdit = $MyAccount->can("update_overtimes") || $MyAccount->can("all_overtimes") ;
    $IsHavePermissionOverTimeDelete = $MyAccount->can("delete_overtimes") || $MyAccount->can("all_overtimes") ;
    $IsHavePermissionOverTimeExport = $MyAccount->can("export_overtimes") || $MyAccount->can("all_overtimes") ;
    $IsHavePermissionOverTimeCreate = $MyAccount->can("create_overtimes") || $MyAccount->can("all_overtimes") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    @if((isset($overtime) && ($IsHavePermissionOverTimeEdit || $IsMyOverTime)) ||
        (!isset($overtime) && ($IsHavePermissionOverTimeCreate || $IsMyOverTime)))
        <section class="MainContent__Section MainContent__Section--RequestOvertimeForm">
            <div class="RequestOvertimeForm">
                <div class="RequestOvertimeForm__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => isset($overtime) ? __("editOvertimeRequest") : ((isset($employees)) ? __("insertAdministrativeOvertime") : __("addOvertimeRequest") ) ,
                        'paths' => [[__("home") , '#'] , ['Page']] ,
                        'summery' => __("titleAddOvertimeRequest")
                    ])
                </div>
                <div class="RequestOvertimeForm__Content">
                    <div class="ViewUsers__Content">
                        <div class="Row">
                            <div class="RequestOvertimeForm__Form">
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
                                                              @if(isset($employees))
                                                              action="{{ isset($overtime) ? route("system.overtimes_admin.update" , $overtime["id"]) : route("system.overtimes_admin.store") }}"
                                                              @else
                                                              action="{{ isset($overtime) ? route("system.overtimes.update.overtime" , $overtime["id"]) : route("system.overtimes.store.request") }}"
                                                              @endif
                                                              method="post">
                                                            @csrf
                                                            @if(isset($overtime))
                                                                @method("put")
                                                            @endif
                                                            <div class="ListData">
                                                                <div class="ListData__Head">
                                                                    <h4 class="ListData__Title">
                                                                        @lang("basics")
                                                                    </h4>
                                                                </div>
                                                                <div class="ListData__Content">
                                                                    <div class="Row GapC-1-5">
                                                                        @if(isset($employees))
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("salary_in_hours") }}">
                                                                                    <div class="Form__Select">
                                                                                        <div class="Select__Area">
                                                                                            @php
                                                                                                $Employees = [] ;
                                                                                                foreach ($employees as $Employee) {
                                                                                                    array_push($Employees , [ "Label" => $Employee["first_name"]." ".$Employee["last_name"]
                                                                                                        , "Value" => $Employee["id"] ]) ;
                                                                                                }
                                                                                            @endphp
                                                                                            @include("System.Components.selector" , [
                                                                                                'Name' => "employee_id" , "Required" => "true" ,
                                                                                                "DefaultValue" => "" , "Label" => __("employeeName") ,
                                                                                                "Options" => $Employees
                                                                                            ])
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("salary_in_hours") }}">
                                                                                <div class="Form__Select">
                                                                                    <div class="Select__Area">
                                                                                        @php
                                                                                            $TypesOvertime = [] ;
                                                                                            foreach ($overtimesType as $Index=>$OvertimeItem) {
                                                                                                array_push($TypesOvertime , [ "Label" => $OvertimeItem
                                                                                                    , "Value" => $Index ]) ;
                                                                                            }
                                                                                        @endphp
                                                                                        @include("System.Components.selector" , [
                                                                                            'Name' => "overtime_type_id" , "Required" => "true" ,
                                                                                            "DefaultValue" => isset($overtime) ? $overtime["overtime_type_id"] : "" ,
                                                                                            "Label" => __("overtimeType") ,
                                                                                            "Options" => $TypesOvertime
                                                                                        ])
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("salary_in_hours") }}">
                                                                                <div class="Form__Date">
                                                                                    <div class="Date__Area">
                                                                                        <input id="FromStartDate" class="DateMinToday Date__Field"
                                                                                               TargetDateStartName="StartDateRequest"
                                                                                               type="date" name="from_date"
                                                                                               value="{{ isset($overtime) ? $overtime["from_date"] : "" }}"
                                                                                               placeholder="@lang("startDateFrom")" required>
                                                                                        <label class="Date__Label" for="FromStartDate">
                                                                                            @lang("startDateFrom")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("salary_in_hours") }}">
                                                                                <div class="Form__Date">
                                                                                    <div class="Date__Area">
                                                                                        <input id="ToEndDate"
                                                                                               class="DateEndFromStart Date__Field"
                                                                                               data-StartDateName="StartDateRequest"
                                                                                               value="{{ isset($overtime) ? $overtime["to_date"] : "" }}"
                                                                                               type="date" name="to_date"
                                                                                               placeholder="@lang("endDateFrom")">
                                                                                        <label class="Date__Label" for="ToEndDate">
                                                                                            @lang("endDateFrom")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="VisibilityOption Col-4-md Col-6-sm"
                                                                             data-VisibilityDefault="{{ isset($overtime) ? ($overtime["is_hourly"] ? "1" : "0") : "" }}"
                                                                             data-ElementsTargetName="HourlyFields">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("salary_in_hours") ?? Errors("salary_in_hours") ?? Errors("salary_in_hours") }}">
                                                                                <div class="Form__Select">
                                                                                    <div class="Select__Area">
                                                                                        @include("System.Components.selector" , [
                                                                                            'Name' => "is_hourly" , "Required" => "true" ,
                                                                                            "DefaultValue" => isset($overtime) ? ($overtime["is_hourly"] ? "1" : "0") : "" ,
                                                                                            "Label" => __("determineHourOvertime") ,
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
                                                                             data-TargetName="HourlyFields"
                                                                             data-TargetValue="1">
                                                                            <div class="Form__Group">
                                                                                <div class="Form__Date">
                                                                                    <div class="Date__Area">
                                                                                        <input id="OvertimeStartTime"
                                                                                               class="TimeNoDate Date__Field"
                                                                                               type="time" name="from_time"
                                                                                               placeholder="@lang("vocationTimeStart")"
                                                                                               value="{{ isset($overtime) ? $overtime["from_time"] : "" }}"
                                                                                               required>
                                                                                        <label class="Date__Label"
                                                                                               for="OvertimeStartTime">
                                                                                            @lang("vocationTimeStart")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                             data-TargetName="HourlyFields"
                                                                             data-TargetValue="1">
                                                                            <div class="Form__Group">
                                                                                <div class="Form__Date">
                                                                                    <div class="Date__Area">
                                                                                        <input id="OvertimeEndTime"
                                                                                               class="TimeNoDate Date__Field"
                                                                                               type="time" name="to_time"
                                                                                               placeholder="@lang("vocationTimeEnd")"
                                                                                               value="{{ isset($overtime) ? $overtime["to_time"] : "" }}"
                                                                                               required>
                                                                                        <label class="Date__Label"
                                                                                               for="OvertimeEndTime">
                                                                                            @lang("vocationTimeEnd")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-12">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("salary_in_hours") }}">
                                                                                <div class="Form__Textarea">
                                                                                    <div class="Textarea__Area">
                                                                                        <textarea id="ReasonOverTime" class="Textarea__Field"
                                                                                                  name="description" rows="3"
                                                                                                  placeholder="@lang("reasonOvertime")">{{ isset($overtime) ? ($overtime["description"] ?? "") : "" }}</textarea>
                                                                                        <label class="Textarea__Label"
                                                                                               for="ReasonOverTime">
                                                                                            @lang("reasonOvertime")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="Row">
                                                                <div class="Col">
                                                                    <div class="Form__Group"
                                                                         data-ErrorBackend="{{ Errors("salary_in_hours") }}">
                                                                        <div class="Form__Button">
                                                                            <button class="Button Send" type="submit">
                                                                                @if(isset($overtime))
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
            </div>
        </section>
    @endif
@endsection
