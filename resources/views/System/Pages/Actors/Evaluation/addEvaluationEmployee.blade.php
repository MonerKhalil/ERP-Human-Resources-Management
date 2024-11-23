<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionEvaluationCreate = $MyAccount->can("create_employee_evaluations") || $MyAccount->can("all_employee_evaluations") ;
?>


@extends("System.Pages.globalPage")

@section("ContentPage")
    @if($IsHavePermissionEvaluationCreate)
        <section class="MainContent__Section MainContent__Section--RequestOvertimeForm">
            <div class="RequestOvertimeForm">
                <div class="RequestOvertimeForm__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __("EvaluationEmployee") ,
                        'paths' => [['Home' , '#'] , ['Page']] ,
                        'summery' => __("TitleAddEvaluation")
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
                                                              action="{{ route("system.evaluation.employee.store.evaluation" , $evaluation["id"]) }}"
                                                              method="post">
                                                            @csrf
                                                            <input type="hidden" value="{{ $evaluation["id"] }}" name="evaluation_id">
                                                            <div class="ListData">
                                                                <div class="ListData__Head">
                                                                    <h4 class="ListData__Title">
                                                                        @lang("EvaluationDegree")
                                                                    </h4>
                                                                </div>
                                                                <div class="ListData__Content">
                                                                    <div class="ListData__CustomItem">
                                                                        <div class="Row GapC-1-5">
                                                                            @foreach($typeEvaluation as $typeEvaluationItem)
                                                                                <div class="Col-4-md Col-6-sm">
                                                                                    <div class="Form__Group"
                                                                                         data-ErrorBackend="{{ Errors($typeEvaluationItem) }}">
                                                                                        <div class="Form__Input">
                                                                                            <div class="Input__Area">
                                                                                                <input id="{{ $typeEvaluationItem }}" class="Input__Field"
                                                                                                       type="number" name="{{ $typeEvaluationItem }}"
                                                                                                       min="1" max="10"
                                                                                                       placeholder="@lang("DegreeThe")@lang($typeEvaluationItem)">
                                                                                                <label class="Input__Label"
                                                                                                       for="{{ $typeEvaluationItem }}">
                                                                                                    @lang("DegreeThe")@lang($typeEvaluationItem)
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
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
    @endif
@endsection
