<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionVacationEdit = !is_null(auth()->user()->employee["id"]) ;
    $IsHavePermissionVacationCreate = !is_null(auth()->user()->employee["id"]) ;
?>

@extends("System.Pages.globalPage")

@php
    //dd($leave);
    $ListIDVacations = [] ;
    $ListIDVacationsIsHour = [] ;
    $ListIDVacationsDays = [] ;
    $ListIDVacationsOpening = [] ;
    $TypeVacations = [] ;
    foreach ($leave_types as $Index=>$LeaveItem) {
        array_push($TypeVacations , [ "Label" => $LeaveItem["name"]
            , "Value" => $LeaveItem["id"] ]) ;
        array_push($ListIDVacations , $LeaveItem["id"]) ;
        if(!$LeaveItem["leave_limited"])
            array_push($ListIDVacationsOpening , $LeaveItem["id"]) ;
        else {
            if($LeaveItem["is_hourly"])
                array_push($ListIDVacationsIsHour , $LeaveItem["id"]) ;
            else if($LeaveItem["can_take_hours"])
                array_push($ListIDVacationsOpening , $LeaveItem["id"]) ;
            else
                array_push($ListIDVacationsDays , $LeaveItem["id"]) ;
        }
    }

    $IsOpen = $IsHour = $IsDays = false ;

    if(isset($leave)) {

        if(!$leave->leave_type["leave_limited"])
            $IsOpen = true ;
        else {
            if($leave->leave_type["is_hourly"])
                $IsHour = true ;
            else if($leave->leave_type["can_take_hours"])
                $IsOpen = true ;
            else
                $IsDays = true ;
        }

    }


@endphp

@section("ContentPage")
    @if((isset($leave) && $IsHavePermissionVacationEdit) ||
            (!isset($leave) && $IsHavePermissionVacationCreate))
        <section class="MainContent__Section MainContent__Section--VacationRequestPage">
            <div class="VacationRequestPage">
                <div class="VacationRequestPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => (isset($leave)) ? __("editVocation") : __("requestVocation") ,
                        'paths' => [[__("home") , '#'] , ['Page']] ,
                        'summery' => (isset($leave)) ? __("TitleVocationRequestEdit") : __("titleVocationRequest")
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
                                                          action="{{ (isset($leave)) ? route("system.leaves.update.leave" , $leave["id"]) : route("system.leaves.store.request") }}"
                                                          method="post">
                                                        @csrf
                                                        @if(isset($leave))
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
                                                                    <div id="VacationType" class="Col-4-md Col-6-sm">
                                                                        @php
                                                                            $ErrorView = Errors("from_date") ?? Errors("to_date") ?? Errors("can_from_hour")
                                                                            ?? Errors("can_to_hour") ?? Errors("from_hour") ?? Errors("to_hour") ?? Errors("description") ;
                                                                        @endphp
                                                                        <div class="Form__Group"
                                                                             data-ErrorBackend="{{ $ErrorView }}">
                                                                            <div class="VisibilityOption Form__Select"
                                                                                 @if(isset($leave))
                                                                                 data-VisibilityDefault="{{ $leave["leave_type_id"] }}"
                                                                                 @endif
                                                                                 data-ElementsTargetName="TypeVacation">
                                                                                <div class="Select__Area">
                                                                                    @include("System.Components.selector" , [
                                                                                        'Name' => "leave_type_id" , "Required" => "true" ,
                                                                                        "DefaultValue" => isset($leave) ? $leave["leave_type_id"] : "" ,
                                                                                        "Label" => __("vocationTypeWant") ,
                                                                                        "Options" => $TypeVacations
                                                                                    ])
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
                                                                        <div class="Form__Group" >
                                                                            <div class="Form__Date">
                                                                                <div class="Date__Area">
                                                                                    <input id="VacationFromDate"
                                                                                           class="DateMinToday Date__Field"
                                                                                           TargetDateStartName="StartDateVacation"
                                                                                           type="date" name="from_date"
                                                                                           value="{{ isset($leave) ? $leave["from_date"] : "" }}"
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
                                                                                           value="{{ isset($leave) ? $leave["to_date"] : "" }}"
                                                                                           placeholder="تاريخ نهاية الاجازة"
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
                                                                        <div class="Form__Group" >
                                                                            @php
                                                                                $IsChecked = false ;
                                                                                $ValueSelected = -1 ;
                                                                                if(isset($leave) && $IsOpen) {
                                                                                    $IsChecked = true ;
                                                                                    if(isset($leave["from_time"]) && isset($leave["to_time"]))
                                                                                        $ValueSelected = 1 ;
                                                                                    else
                                                                                        $ValueSelected = 0 ;
                                                                                }
                                                                            @endphp
                                                                            <div class="VisibilityOption Form__Select"
                                                                                 data-VisibilityDefault="{{ ($IsChecked) ? $ValueSelected : "" }}"
                                                                                 data-ElementsTargetName="VacationNaturalFields">
                                                                                <div class="Select__Area">
                                                                                    @include("System.Components.selector" , [
                                                                                        'Name' => "VacationNatural" , "Required" => "true" ,
                                                                                        "DefaultValue" => ($IsChecked) ? $ValueSelected : "" ,
                                                                                        "Label" => __("vocationType") ,
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
                                                                                           type="time" name="can_from_hour"
                                                                                           placeholder="@lang("vocationTimeStart")"
                                                                                           @if(isset($leave) && $IsOpen && isset($leave["from_time"]))
                                                                                           value="{{ $leave["from_time"] }}"
                                                                                           @endif
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
                                                                                           type="time" name="can_to_hour"
                                                                                           placeholder="@lang("vocationTimeEnd")"
                                                                                           @if(isset($leave) && $IsOpen && isset($leave["to_time"]))
                                                                                           value="{{ $leave["to_time"] }}"
                                                                                           @endif
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
                                                                                           type="time" name="from_hour"
                                                                                           @if(isset($leave) && $IsHour && isset($leave["from_time"]))
                                                                                           value="{{ $leave["from_time"] }}"
                                                                                           @endif
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
                                                                                           type="time" name="to_hour"
                                                                                           placeholder="@lang("vocationTimeEnd")"
                                                                                           @if(isset($leave) && $IsHour && isset($leave["to_time"]))
                                                                                           value="{{ $leave["to_time"] }}"
                                                                                           @endif
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
                                                                                           value="{{ isset($leave) ? ($leave["description"] ?? "") : "" }}"
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
                                                                        <button class="Button Send" type="submit">
                                                                            @if(isset($leave))
                                                                                @lang("editVocation")
                                                                            @else
                                                                                @lang("requestVocation")
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
