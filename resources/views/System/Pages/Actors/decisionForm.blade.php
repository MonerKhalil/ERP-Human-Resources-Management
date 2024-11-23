<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionDecisionCreate = $MyAccount->can("create_decisions") || $MyAccount->can("all_decisions") ;
    $IsHavePermissionDecisionEdit = $MyAccount->can("update_decisions") || $MyAccount->can("all_decisions") ;
?>

@extends("System.Pages.globalPage")

@php
    $IncrementValue = $DecrementValue = $IncrementRate = $DecrementRate = null ;
    if(isset($decision) && $decision["effect_salary"] == "increment") {
        $IncrementValue = $decision["value"] ;
        $IncrementRate = $decision["rate"] ;
    } else if(isset($decision) && $decision["effect_salary"] == "decrement") {
        $DecrementValue = $decision["value"] ;
        $DecrementRate = $decision["rate"] ;
    }
@endphp

@section("ContentPage")
    @if((isset($decision) && $IsHavePermissionDecisionEdit) ||
        (!isset($decision) && $IsHavePermissionDecisionCreate))
        <section class="MainContent__Section MainContent__Section--AddDecisionPage">
            <div class="AddDecisionPage">
                <div class="AddUserPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __("decisionForm") ,
                        'paths' => [[__("home") , '#'] , [__("decisionForm")]] ,
                        'summery' => __("titleDecisionForm")
                    ])
                </div>
                <div class="AddUserPage__Content">
                    <div class="ViewUsers__Content">
                        <div class="Row">
                            <div class="AddUserPage__Form">
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
                                                              action="{{isset($decision) ? route("system.decisions.update" , $decision["id"])
                                                                : route("system.decisions.store")}}"
                                                              enctype="multipart/form-data"
                                                              method="post">
                                                            @csrf
                                                            <input name="session_decision_id"
                                                                   value="{{(isset($decision)) ? $decision["session_decision_id"] : $session_decisions["id"]}}" hidden>
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
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("employees") }}">
                                                                                    <div class="Form__Select">
                                                                                        <div class="Select__Area">
                                                                                            @php
                                                                                                $Employees = [] ;
                                                                                                foreach ($employees as $Employee) {
                                                                                                    $IsEmployeeSelected = false ;
                                                                                                    if(isset($decision))
                                                                                                        foreach ($decision->employees as $EmployeeSelected)
                                                                                                            if($EmployeeSelected["id"] == $Employee["id"]) {
                                                                                                                $IsEmployeeSelected = true ;
                                                                                                                break ;
                                                                                                            }

                                                                                                    array_push($Employees , [
                                                                                                        "Label" => $Employee["first_name"].$Employee["last_name"] ,
                                                                                                        "IsChecked" => $IsEmployeeSelected
                                                                                                        , "Value" => $Employee["id"] , "Name" => "employees[]"] ) ;
                                                                                                }
                                                                                            @endphp
                                                                                            {{--                                                                                            $decision->employees--}}
                                                                                            @include("System.Components.multiSelector" , [
                                                                                                'Name' => "_" ,
                                                                                                "NameIDs" => "EmployeesID" ,
                                                                                                "DefaultValue" => "" , "Label" => "المطبق عليهم القرار" ,
                                                                                                "Options" => $Employees
                                                                                            ])
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("type_decision_id") }}">
                                                                                    <div class="VisibilityOption Form__Select"
                                                                                         data-ElementsTargetName="DecisionFieldTarget">
                                                                                        <div class="Select__Area">
                                                                                            @php
                                                                                                $DecisionTypes = [] ;
                                                                                                foreach ($type_decisions as $Index=>$DecisionType) {
                                                                                                    array_push($DecisionTypes , [ "Label" => $DecisionType
                                                                                                        , "Value" => $Index ]) ;
                                                                                                }
                                                                                            @endphp
                                                                                            @include("System.Components.selector" , [
                                                                                                'Name' => "type_decision_id" , "Required" => "true" ,
                                                                                                "DefaultValue" => isset($decision) ? $decision["type_decision_id"] : ""
                                                                                                 , "Label" => __("decisionType") ,
                                                                                                "Options" => $DecisionTypes
                                                                                            ])
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("number") }}">
                                                                                    <div class="Form__Input">
                                                                                        <div class="Input__Area">
                                                                                            <input id="DecisionNumber" class="Input__Field" type="number"
                                                                                                   value="{{(isset($decision)) ? $decision["number"] : ""}}"
                                                                                                   name="number" placeholder="@lang("decisionNumber")" required>
                                                                                            <label class="Input__Label" for="DecisionNumber">@lang("decisionNumber")</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("date") }}">
                                                                                    <div class="Form__Date">
                                                                                        <div class="Date__Area">
                                                                                            <input id="DateDecision" class="DateMinToday Date__Field"
                                                                                                   TargetDateStartName="StartDateDecision"
                                                                                                   value="{{isset($decision) ? $decision["date"] : ""}}"
                                                                                                   type="date" name="date"
                                                                                                   placeholder="@lang("dateDecision")" required>
                                                                                            <label class="Date__Label" for="DateDecision">@lang("dateDecision")</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("end_date_decision") }}">
                                                                                    <div class="Form__Date">
                                                                                        <div class="Date__Area">
                                                                                            <input id="DateDecisionEnd"
                                                                                                   class="DateEndFromStart Date__Field"
                                                                                                   data-StartDateName="StartDateDecision"
                                                                                                   value="{{(isset($decision) && ($decision["end_date_decision"] != null)) ?
                                                                                                    $decision["end_date_decision"] : ""}}"
                                                                                                   type="date" name="end_date_decision"
                                                                                                   placeholder="@lang("dateDecisionEnd")">
                                                                                            <label class="Date__Label" for="DateDecisionEnd">
                                                                                                @lang("dateDecisionEnd")
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("image") }}">
                                                                                    <div class="Form__UploadFile">
                                                                                        <div class="UploadFile__Area">
                                                                                            {{--                                                                                        <input type="file"--}}
                                                                                            {{--                                                                                               id="DecisionImage"--}}
                                                                                            {{--                                                                                               name="image"--}}
                                                                                            {{--                                                                                               class="UploadFile__Field"--}}
                                                                                            {{--                                                                                               value="{{(isset($decision)) ? PathStorage($decision["image"]) : "" }}"--}}
                                                                                            {{--                                                                                               accept="image/png, image/gif, image/jpeg, image/jpg, image/svg"--}}
                                                                                            {{--                                                                                               placeholder="صورة عن القرار">--}}
                                                                                            @include("System.Components.fileUpload" , [
                                                                                                "FieldID" => "DecisionImage" ,
                                                                                                "FieldName" => "image" ,
                                                                                                "DefaultData" => (isset($decision)) ? PathStorage($decision["image"]) : ""  ,
                                                                                                "LabelField" => __("decisionPhoto") ,
                                                                                                "AcceptFiles" => "image/png, image/gif, image/jpeg, image/jpg, image/svg"
                                                                                            ])
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="VisibilityOption Col-4-md Col-6-sm"
                                                                                 @if(isset($decision))
                                                                                 data-VisibilityDefault="{{$decision["effect_salary"]}}"
                                                                                 @endif
                                                                                 data-ElementsTargetName="BonesPunishmentFields">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("effect_salary") ?? Errors("value") ?? Errors("rate") }}">
                                                                                    <div class="Form__Select">
                                                                                        <div class="Select__Area">
                                                                                            @php
                                                                                                $EffectDecisionTypes = [] ;
                                                                                                foreach ($type_effects as $EffectType) {
                                                                                                    array_push($EffectDecisionTypes , [ "Label" => $EffectType
                                                                                                        , "Value" => $EffectType ]) ;
                                                                                                }
                                                                                            @endphp
                                                                                            @include("System.Components.selector" , [
                                                                                                'Name' => "effect_salary" , "Required" => "true" ,
                                                                                                "DefaultValue" => (isset($decision) ? $decision["effect_salary"] : "")
                                                                                                , "Label" => __("salaryEffectType") ,
                                                                                                "Options" => $EffectDecisionTypes
                                                                                            ])
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                                 data-TargetName="BonesPunishmentFields"
                                                                                 data-TargetValue="decrement">
                                                                                <div class="Form__Group">
                                                                                    <div class="Form__Input">
                                                                                        <div class="Input__Area">
                                                                                            <input id="DiscountAmountFinancial" class="Input__Field" type="number"
                                                                                                   value="{{ $DecrementRate ?? "" }}"
                                                                                                   name="rate" placeholder="{{ __("discountRateIncentives") }}" required>
                                                                                            <label class="Input__Label" for="DiscountAmountFinancial">
                                                                                                @lang("discountRateIncentives")
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="VisibilityTarget Col-4-md Col-6-sm"
                                                                                 data-TargetName="BonesPunishmentFields"
                                                                                 data-TargetValue="increment">
                                                                                <div class="Form__Group">
                                                                                    <div class="Form__Input">
                                                                                        <div class="Input__Area">
                                                                                            <input id="IncreasesAmountFinancial" class="Input__Field" type="number"
                                                                                                   value="{{ $IncrementRate ?? "" }}"
                                                                                                   name="rate" placeholder="{{ __("rateIncentivesExtra") }}" required>
                                                                                            <label class="Input__Label" for="IncreasesAmountFinancial">
                                                                                                @lang("rateIncentivesExtra")
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
                                                                        <label for="DecisionEditor">
                                                                            @lang("decisionContent")
                                                                        </label>
                                                                    </h4>
                                                                </div>
                                                                <div class="ListData__Content">
                                                                    <div class="ListData__CustomItem">
                                                                        <div class="Row">
                                                                            <div class="Col">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("content") }}">
                                                                                    <div class="Form__TextEditor">
                                                                                        <div class="TextEditor__Area">
                                                                                            <div class="trumbowyg-dark">
                                                                                        <textarea id="DecisionEditor"
                                                                                                  class="TextEditor TextEditor__Field"
                                                                                                  placeholder="@lang("decisionContent")"
                                                                                                  name="content" required>
                                                                                            @if(isset($decision))
                                                                                                {{$decision["content"]}}
                                                                                            @endif
                                                                                        </textarea>
                                                                                            </div>
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
                                                                                @lang("addDecision")
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

@section("extraScripts")
    @if((isset($decision) && $IsHavePermissionDecisionEdit) ||
        (!isset($decision) && $IsHavePermissionDecisionCreate))
        {{-- JS Trumbowyg --}}
        <script src="{{asset("System/Assets/Lib/trumbowyg/dist/trumbowyg.min.js")}}"></script>
        @if(app()->getLocale()==="ar")
            <script src="{{asset("System/Assets/Lib/trumbowyg/dist/langs/ar.min.js")}}"></script>
        @endif
    @endif
@endsection
