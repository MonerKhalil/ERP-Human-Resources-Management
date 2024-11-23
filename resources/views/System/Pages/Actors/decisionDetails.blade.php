<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionDecisionRead = $MyAccount->can("read_decisions") || $MyAccount->can("all_decisions") ;
    $IsHavePermissionDecisionEdit = $MyAccount->can("update_decisions") || $MyAccount->can("all_decisions") ;
    $IsHavePermissionDecisionDelete = $MyAccount->can("delete_decisions") || $MyAccount->can("all_decisions") ;
    $IsHavePermissionDecisionExport = $MyAccount->can("export_decisions") || $MyAccount->can("all_decisions") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--DecisionDetailsPage">
        <div class="DecisionDetailsPage">
            <div class="DecisionDetailsPage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __("decisionDetails") ,
                    'paths' => [[__("home") , '#'] , [__("decisionDetails")]] ,
                    'summery' => __("titleDecisionDetails")
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
                                    @if($IsHavePermissionDecisionRead)
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
                                                        @lang("decisionType")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$decision->type_decision["name"]}}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("decisionNumber")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$decision["number"]}}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        المطبق عليهم القرار
                                                    </span>
                                                        <span class="Data_Value">
                                                        @php
                                                            $EmployeesList = "" ;
                                                            foreach ($decision->employees as $Employee) {
                                                                if($EmployeesList !== "")
                                                                    $EmployeesList = $EmployeesList." , " ;
                                                                $EmployeesList = $EmployeesList.$Employee["first_name"]
                                                                ." ".$Employee["last_name"] ;
                                                            }
                                                        @endphp
                                                            {{ ($EmployeesList != "") ? $EmployeesList : "-" }}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("dateDecision")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$decision["date"]}}
                                                    </span>
                                                    </div>
                                                </div>
                                                @if($decision["effect_salary"] != "none")
                                                    <div class="ListData__Item ListData__Item--NoAction">
                                                        <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("salaryEffectType")
                                                    </span>
                                                            <span class="Data_Value">
                                                        {{$decision["effect_salary"]}}
                                                    </span>
                                                        </div>
                                                    </div>
                                                    @if($decision["effect_salary"] == "increment")
                                                        <div class="ListData__Item ListData__Item--NoAction">
                                                            <div class="Data_Col">
                                                            <span class="Data_Label">
                                                                @lang("amountSalaryExtra")
                                                            </span>
                                                                <span class="Data_Value">
                                                                {{$decision["value"]}}
                                                            </span>
                                                            </div>
                                                        </div>
                                                        <div class="ListData__Item ListData__Item--NoAction">
                                                            <div class="Data_Col">
                                                            <span class="Data_Label">
                                                                @lang("amountIncentivesExtra")
                                                            </span>
                                                                <span class="Data_Value">
                                                                {{$decision["rate"]}}
                                                            </span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="ListData__Item ListData__Item--NoAction">
                                                            <div class="Data_Col">
                                                            <span class="Data_Label">
                                                                @lang("amountDiscountSalary")
                                                            </span>
                                                                <span class="Data_Value">
                                                                {{$decision["value"]}}
                                                            </span>
                                                            </div>
                                                        </div>
                                                        <div class="ListData__Item ListData__Item--NoAction">
                                                            <div class="Data_Col">
                                                            <span class="Data_Label">
                                                                @lang("discountRateIncentives")
                                                            </span>
                                                                <span class="Data_Value">
                                                                {{$decision["rate"]}}
                                                            </span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("decisionPhoto")
                                                    </span>
                                                        <a href="{{PathStorage($decision["image"])}}"
                                                           class="venobox Data_Value">
                                                            @lang("clickForViewImage")
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("createOnSystem")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$decision["created_at"]}}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("updateOnSystem")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$decision["updated_at"]}}
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ListData NotResponsive">
                                            <div class="ListData__Head">
                                                <h4 class="ListData__Title">
                                                    @lang("decisionContent")
                                                </h4>
                                            </div>
                                            <div class="PrintPage__TextEditorContent">
                                                <div class="TextEditorContent">
                                                    <div class="TextEditorContent__Content">
                                                        <div class="Card Content">
                                                            <div class="Card__Inner">
                                                                {!! $decision["content"] !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="ListData">
                                        <div class="ListData__Head">
                                            <h4 class="ListData__Title">
                                                @lang("operationDecision")
                                            </h4>
                                        </div>
                                        <div class="ListData__Content">
                                            <div class="Card__Inner px0">
                                                @if($IsHavePermissionDecisionExport)
                                                    <a href="{{route("system.decisions.print.pdf" , $decision["id"])}}"
                                                       class="Button Button--Primary">
                                                        @lang("decisionPrint")
                                                    </a>
                                                @endif
                                                @if($IsHavePermissionDecisionEdit)
                                                    <a href="{{route("system.decisions.edit" , $decision["id"])}}"
                                                       class="Button Button--Primary">
                                                        @lang("decisionEdit")
                                                    </a>
                                                @endif
                                                @if($IsHavePermissionDecisionDelete)
                                                    <form class="Form"
                                                          style="display: inline-block" method="post"
                                                          action="{{route("system.decisions.destroy" , $decision["id"])}}">
                                                        @csrf
                                                        @method("delete")
                                                        <button type="submit" class="Button Button--Danger">
                                                            @lang("removeDecision")
                                                        </button>
                                                    </form>
                                                @endif
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
    @if($IsHavePermissionDecisionRead)
        {{-- JS VenoBox --}}
        <script src="{{asset("System/Assets/Lib/venobox/dist/venobox.min.js")}}"></script>
    @endif
@endsection
