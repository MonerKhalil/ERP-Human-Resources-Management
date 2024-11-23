<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionVacationRead = $MyAccount->can("read_leaves") || $MyAccount->can("all_leaves") ;
    $IsHavePermissionVacationEdit = $MyAccount->can("update_leaves") || $MyAccount->can("all_leaves") ;
    $IsHavePermissionVacationDelete = $MyAccount->can("delete_leaves") || $MyAccount->can("all_leaves") ;
    $IsHavePermissionVacationExport = $MyAccount->can("export_leaves") || $MyAccount->can("all_leaves") ;
    $IsHavePermissionVacationCreate = $MyAccount->can("create_leaves") || $MyAccount->can("all_leaves") ;
    $IsHavePermissionVacationDecisionState = $MyAccount->can("all_leaves") ;
?>

@extends("System.Pages.globalPage")

@php
    $ListIDVacations = [] ;
    $ListIDVacationsIsHour = [] ;
    $ListIDVacationsDays = [] ;
    $ListIDVacationsOpening = [] ;
    $TypeVacations = [] ;
    foreach ($leave_types as $Index=>$LeaveItem) {
        array_push($TypeVacations , [ "Label" => $LeaveItem["name"]
            , "Value" => $LeaveItem["id"] ]) ;
        array_push($ListIDVacations , $LeaveItem["id"]) ;
        if(!$LeaveItem["leave_limited"]) {
            array_push($ListIDVacationsOpening , $LeaveItem["id"]) ;
        } else {
            if($LeaveItem["is_hourly"])
                array_push($ListIDVacationsIsHour , $LeaveItem["id"]) ;
            else if($LeaveItem["can_take_hours"])
                array_push($ListIDVacationsOpening , $LeaveItem["id"]) ;
            else
                array_push($ListIDVacationsDays , $LeaveItem["id"]) ;
        }
    }
@endphp

@section("ContentPage")
    @if($IsHavePermissionVacationCreate)
        <section class="MainContent__Section MainContent__Section--VacationRequestPage">
            <div class="VacationRequestPage">
                <div class="VacationRequestPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __("insertAdministrativeVacation") ,
                        'paths' => [[__("home") , '#'] , [__("insertAdministrativeVacation")]] ,
                        'summery' => __("titleInsertAdministrativeVacation")
                    ])
                </div>
                <div class="VacationRequestPage__Content">
                    <div class="Row">
                        <div class="VacationRequestPage__Form">
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
                                                          action="{{ route("system.leaves_admin.store") }}"
                                                          method="post">
                                                        @csrf
                                                        <div class="ListData">
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("basics")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div class="ListData__CustomItem">
                                                                    <div class="Row GapC-1-5">
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group">
                                                                                <div class="Form__Select">
                                                                                    <div class="Select__Area">
                                                                                        @php
                                                                                            $Employees = [] ;
                                                                                            foreach ($employees as $Index=>$Employee) {
                                                                                                array_push($Employees ,
                                                                                                 [ "Label" => $Employee["first_name"]." ".$Employee["last_name"]
                                                                                                    , "Value" => $Employee["id"]
                                                                                                ]) ;
                                                                                            }
                                                                                        @endphp

                                                                                        @include("System.Components.selector" , [
                                                                                            'Name' => "employee_id" , "Required" => "true" ,
                                                                                            "DefaultValue" => "", "Label" => __("employeeWantVocation") ,
                                                                                            "Options" => $Employees
                                                                                        ])
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div id="VacationType" class="Col-4-md Col-6-sm">
                                                                            @php
                                                                                $ErrorView = Errors("from_date") ?? Errors("to_date") ?? Errors("can_from_hour")
                                                                                ?? Errors("can_to_hour") ?? Errors("from_hour") ?? Errors("to_hour") ?? Errors("description") ;
                                                                            @endphp
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ $ErrorView }}">
                                                                                <div class="VisibilityOption Form__Select"
                                                                                     data-ElementsTargetName="TypeVacation">
                                                                                    <div class="Select__Area">
                                                                                        @include("System.Components.selector" , [
                                                                                            'Name' => "leave_type_id" , "Required" => "true" ,
                                                                                            "DefaultValue" => "", "Label" => __("vocationTypeWant") ,
                                                                                            "Options" => $TypeVacations
                                                                                        ])
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="VisibilityTarget ListData"
                                                             id="VacationListDate"
                                                             data-TargetName="TypeVacation"
                                                             data-TargetValue="{{join("," , $ListIDVacations)}}">
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("vocationTimeAndDate")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div class="Row GapC-1-5">
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="VacationFromDate"
                                                                                           class="DateMinToday Date__Field"
                                                                                           TargetDateStartName="StartDateVacation"
                                                                                           type="date" name="from_date"
                                                                                           placeholder="@lang("vocationStartDate")"
                                                                                           required>
                                                                                    <label class="Date__Label" for="VacationFromDate">
                                                                                        @lang("vocationStartDate")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="VacationToDate"
                                                                                           class="DateEndFromStart Date__Field"
                                                                                           type="date" name="to_date"
                                                                                           data-StartDateName="StartDateVacation"
                                                                                           placeholder="@lang("vocationEndDate")"
                                                                                           required>
                                                                                    <label class="Date__Label" for="VacationToDate">
                                                                                        @lang("vocationEndDate")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Is Opening -->
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         id="VacationNaturalID"
                                                                         data-TargetName="TypeVacation"
                                                                         data-TargetValue="{{join("," , $ListIDVacationsOpening)}}">
                                                                        <div class="Form__Group">
                                                                            <div class="VisibilityOption Form__Select"
                                                                                 data-ElementsTargetName="VacationNaturalFields">
                                                                                <div class="Select__Area">
                                                                                    @include("System.Components.selector" , [
                                                                                        'Name' => "VacationNatural" , "Required" => "true" ,
                                                                                        "DefaultValue" => "", "Label" => __("vocationType") ,
                                                                                        "Options" => [
                                                                                            ["Label" => __("completed") , "Value" => "0"] ,
                                                                                            ["Label" => __("part") , "Value" => "1"]
                                                                                        ]
                                                                                    ])
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         data-TargetName="VacationNaturalFields"
                                                                         data-TargetValue="1">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="VacationStartTime"
                                                                                           class="TimeNoDate Date__Field"
                                                                                           type="text" name="can_from_hour"
                                                                                           placeholder="@lang("vocationTimeStart")"
                                                                                           required>
                                                                                    <label class="Date__Label"
                                                                                           for="VacationStartTime">
                                                                                        @lang("vocationTimeStart")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         data-TargetName="VacationNaturalFields"
                                                                         data-TargetValue="1">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="VacationEndTime"
                                                                                           class="TimeNoDate Date__Field"
                                                                                           type="text" name="can_to_hour"
                                                                                           placeholder="@lang("vocationTimeEnd")"
                                                                                           required>
                                                                                    <label class="Date__Label"
                                                                                           for="VacationEndTime">
                                                                                        @lang("vocationTimeEnd")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Is Hourly -->
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         data-TargetName="TypeVacation"
                                                                         data-TargetValue="{{join("," , $ListIDVacationsIsHour)}}">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="VacationStartTime"
                                                                                           class="TimeNoDate Date__Field"
                                                                                           type="text" name="from_hour"
                                                                                           placeholder="@lang("vocationTimeStart")"
                                                                                           required>
                                                                                    <label class="Date__Label"
                                                                                           for="VacationStartTime">
                                                                                        @lang("vocationTimeStart")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                         data-TargetName="TypeVacation"
                                                                         data-TargetValue="{{join("," , $ListIDVacationsIsHour)}}">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="VacationEndTime"
                                                                                           class="TimeNoDate Date__Field"
                                                                                           type="text" name="to_hour"
                                                                                           placeholder="@lang("vocationTimeEnd")"
                                                                                           required>
                                                                                    <label class="Date__Label"
                                                                                           for="VacationEndTime">
                                                                                        @lang("vocationTimeEnd")
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Description -->
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Input">
                                                                                <div class="Input__Area">
                                                                                    <input id="ReasonVacation" class="Input__Field"
                                                                                           type="text" name="description"
                                                                                           placeholder="@lang("vocationReason")">
                                                                                    <label class="Input__Label" for="ReasonVacation">
                                                                                        @lang("vocationReason")
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
                                                                <div class="Form__Group">
                                                                    <div class="Form__Button">
                                                                        <button class="Button Send"
                                                                                type="submit">@lang("insertVocation")</button>
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
