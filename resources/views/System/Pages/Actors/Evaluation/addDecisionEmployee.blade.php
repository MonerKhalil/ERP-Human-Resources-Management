<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionDecisionRead = $MyAccount->can("read_decisions") || $MyAccount->can("all_decisions") ;
    $IsHavePermissionDecisionEdit = $MyAccount->can("update_decisions") || $MyAccount->can("all_decisions") ;
    $IsHavePermissionDecisionDelete = $MyAccount->can("delete_decisions") || $MyAccount->can("all_decisions") ;
    $IsHavePermissionDecisionExport = $MyAccount->can("export_decisions") || $MyAccount->can("all_decisions") ;
?>



@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--RequestOvertimeForm">
        <div class="RequestOvertimeForm">
            <div class="RequestOvertimeForm__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __("addDecisionEvaluation") ,
                    'paths' => [['Home' , '#'] , ['Page']] ,
                    'summery' => __("TitleDecisionEvaluation")
                ])
            </div>
            <div class="RequestOvertimeForm__Content">
                <div class="ViewUsers__Content">
                    <div class="MessageProcessContainer">
                        @include("System.Components.messageProcess")
                    </div>
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
                                                          action="{{ route("system.evaluation.employee.store.decision.evaluation") }}"
                                                          enctype="multipart/form-data"
                                                          method="post">
                                                        @csrf
                                                        <input type="hidden" value="{{ $evaluation["id"] }}" name="evaluation_id">
                                                        <div class="ListData">
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("SessionInfo")
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
                                                                                        <input id="SessionName" class="Input__Field"
                                                                                               type="text" name="name"
                                                                                               placeholder="{{ __("sessionName") }}">
                                                                                        <label class="Input__Label"
                                                                                               for="SessionName">
                                                                                            @lang("sessionName")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                data-ErrorBackend="{{ Errors("moderator_id") }}">
                                                                                <div class="Form__Select">
                                                                                    <div class="Select__Area">
                                                                                        @php
                                                                                            $Employees = [] ;
                                                                                            foreach ($employees as $Employee) {
                                                                                                array_push($Employees , [
                                                                                                    "Label" => $Employee["first_name"].$Employee["last_name"]
                                                                                                    , "Value" => $Employee["id"] ]) ;
                                                                                            }
                                                                                        @endphp
                                                                                        @include("System.Components.selector" , [
                                                                                            'Name' => "moderator_id" , "Required" => "true" ,
                                                                                            "DefaultValue" => "" , "Label" => __("SessionModrate") ,
                                                                                            "Options" => $Employees
                                                                                        ])
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                data-ErrorBackend="{{ Errors("date_session") }}">
                                                                                <div class="Form__Date">
                                                                                    <div class="Date__Area">
                                                                                        <input id="DateSession"
                                                                                               name="date_session"
                                                                                               class="DateMinToday Date__Field"
                                                                                               type="date" placeholder="{{ __("SessionDate") }}"
                                                                                               required>
                                                                                        <label class="Date__Label"
                                                                                               for="DateSession">
                                                                                            @lang("SessionDate")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-12">
                                                                            <div class="Form__Group"
                                                                                data-ErrorBackend="{{ Errors("description") }}">
                                                                                <div class="Form__Textarea">
                                                                                    <div class="Textarea__Area">
                                                                                        <textarea id="SessionDescription" class="Textarea__Field" name="description"
                                                                                                  rows="3" placeholder="{{ __("SessionDecription") }}"></textarea>
                                                                                        <label class="Textarea__Label" for="SessionDescription">
                                                                                            @lang("SessionDecription")
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
                                                                    @lang("DecisionInfo")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div class="ListData__CustomItem">
                                                                    <div class="Row GapC-1-5">
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                data-ErrorBackend="{{ Errors("number") }}">
                                                                                <div class="Form__Input">
                                                                                    <div class="Input__Area">
                                                                                        <input id="DecisionNumber" class="Input__Field"
                                                                                               type="number" name="number"
                                                                                               min="0"
                                                                                               placeholder="{{ __("decisionNumber") }}">
                                                                                        <label class="Input__Label"
                                                                                               for="DecisionNumber">
                                                                                            @lang("decisionNumber")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                data-ErrorBackend="{{ Errors("date") }}">
                                                                                <div class="Form__Date">
                                                                                    <div class="Date__Area">
                                                                                        <input id="DateDecision"
                                                                                               name="date"
                                                                                               class="DateMinToday Date__Field"
                                                                                               TargetDateStartName="StartDateDecision"
                                                                                               type="date" placeholder="{{ __("dateDecision") }}"
                                                                                               required>
                                                                                        <label class="Date__Label"
                                                                                               for="DateDecision">
                                                                                            @lang("dateDecision")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                data-ErrorBackend="{{ Errors("end_date_decision") }}">
                                                                                <div class="Form__Date">
                                                                                    <div class="Date__Area">
                                                                                        <input id="EndDateDecision"
                                                                                               name="end_date_decision"
                                                                                               data-StartDateName="StartDateDecision"
                                                                                               class="DateEndFromStart Date__Field"
                                                                                               type="date" placeholder="{{ __("dateDecisionEnd") }}">
                                                                                        <label class="Date__Label"
                                                                                               for="EndDateDecision">
                                                                                                @lang("dateDecisionEnd")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                data-ErrorBackend="{{ Errors("image_decision") }}">
                                                                                <div class="Form__UploadFile">
                                                                                    <div class="UploadFile__Area">
                                                                                        @include("System.Components.fileUpload" , [
                                                                                            "FieldID" => "ImageDecision" ,
                                                                                            "FieldName" => "image_decision" ,
                                                                                            "DefaultData" => ""  ,
                                                                                            "LabelField" => __("decisionPhoto") ,
                                                                                            "AcceptFiles" => "image/png, image/gif, image/jpeg, image/jpg, image/svg"
                                                                                        ])
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="VisibilityOption Col-4-md Col-6-sm"
                                                                             data-ElementsTargetName="BonesPunishmentFields">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("effect_salary") ?? Errors("value") ?? Errors("rate") ?? "" }}">
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
                                                                                            "DefaultValue" => "" ,
                                                                                            "Label" => __("salaryEffectType") ,
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
                                                                                        <input id="DiscountAmountSalary" class="Input__Field" type="number"
                                                                                               name="value"
                                                                                               placeholder="{{ __("amountDiscountSalary") }}" required>
                                                                                        <label class="Input__Label"
                                                                                               for="DiscountAmountSalary">
                                                                                            @lang("amountDiscountSalary")
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
                                                                                        <input id="IncreasesAmountSalary" class="Input__Field" type="number"
                                                                                               name="value" placeholder="{{ __("amountSalaryExtra") }}" required>
                                                                                        <label class="Input__Label"
                                                                                               for="IncreasesAmountSalary">
                                                                                            {{ __("amountSalaryExtra") }}
                                                                                        </label>
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
                                                                                               min="0" max="100"
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
                                                                                               min="0" max="100"
                                                                                               name="rate" placeholder="{{ __("amountIncentivesExtra") }}" required>
                                                                                        <label class="Input__Label" for="IncreasesAmountFinancial">
                                                                                            @lang("amountIncentivesExtra")
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
                                                                    @lang("decisionContent")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div class="ListData__CustomItem">
                                                                    <div class="Row GapC-1-5">
                                                                        <div class="Col-12">
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
                                                        <div class="Row GapC-1-5">
                                                            <div class="Col-12">
                                                                <div class="Form__Group">
                                                                    <div class="Form__Button">
                                                                        <button class="Button Send" type="submit">
                                                                            @lang("EvaluationEmployee")
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
@endsection

@section("extraScripts")
    {{-- JS Trumbowyg --}}
    <script src="{{asset("System/Assets/Lib/trumbowyg/dist/trumbowyg.min.js")}}"></script>
    @if(app()->getLocale()==="ar")
        <script src="{{asset("System/Assets/Lib/trumbowyg/dist/langs/ar.min.js")}}"></script>
    @endif
@endsection
