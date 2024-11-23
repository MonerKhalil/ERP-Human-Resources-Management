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
                        'mainTitle' => __("AddNewTypeEvaluation") ,
                        'paths' => [['Home' , '#'] , ['Page']] ,
                        'summery' => __("TitleNewTypeEvaluation")
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
                                                              action="{{ route("system.evaluation.employee.store") }}"
                                                              method="post">
                                                            @csrf
                                                            <div class="ListData">
                                                                <div class="ListData__Head">
                                                                    <h4 class="ListData__Title">
                                                                        @lang("EvaluationInfoNew")
                                                                    </h4>
                                                                </div>
                                                                <div class="ListData__Content">
                                                                    <div class="ListData__CustomItem">
                                                                        <div class="Row GapC-1-5">
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("evaluation_employees[]") }}">
                                                                                    <div class="Form__Select">
                                                                                        <div class="Select__Area">
                                                                                            @php
                                                                                                $EvaluationEmployees = [] ;
                                                                                                foreach ($employees as $Employee) {
                                                                                                    array_push($EvaluationEmployees , [
                                                                                                        "Label" => $Employee["first_name"].$Employee["last_name"]
                                                                                                        , "Value" => $Employee["id"] , "Name" => "evaluation_employees[]"] ) ;
                                                                                                }
                                                                                            @endphp

                                                                                            @include("System.Components.multiSelector" , [
                                                                                                'Name' => "_" , "Required" => "true" ,
                                                                                                "NameIDs" => "EvaluationEmployeesID" ,
                                                                                                "DefaultValue" => "" , "Label" => __("EmployeeWhoEvaluated") ,
                                                                                                "Options" => $EvaluationEmployees
                                                                                            ])
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("employee_id") }}">
                                                                                    <div class="Form__Select">
                                                                                        <div class="Select__Area">
                                                                                            @php
                                                                                                $Employees = [] ;
                                                                                                foreach ($employees as $Employee) {
                                                                                                    array_push($Employees , [
                                                                                                        "Label" => $Employee["first_name"].$Employee["last_name"]
                                                                                                        , "Value" => $Employee["id"]]) ;
                                                                                                }
                                                                                            @endphp

                                                                                            @include("System.Components.selector" , [
                                                                                                'Name' => "employee_id" , "DefaultValue" => "" ,
                                                                                                "Label" => __("EmployeeNeedEvaluate") , "Required" => "true",
                                                                                                "Options" => $Employees
                                                                                            ])
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("evaluation_date") }}">
                                                                                    <div class="Form__Date">
                                                                                        <div class="Date__Area">
                                                                                            <input id="StartEvaluationDate"
                                                                                                   name="evaluation_date"
                                                                                                   class="DateMinToday Date__Field"
                                                                                                   TargetDateStartName="StartEvaluationDate"
                                                                                                   type="text" placeholder="{{ __("StartEmployeeEvaluation") }}"
                                                                                                   required>
                                                                                            <label class="Date__Label"
                                                                                                   for="StartEvaluationDate">
                                                                                                @lang("StartEmployeeEvaluation")
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("next_evaluation_date") }}">
                                                                                    <div class="Form__Date">
                                                                                        <div class="Date__Area">
                                                                                            <input id="NextEvaluationDate"
                                                                                                   name="next_evaluation_date"
                                                                                                   class="DateEndFromStart Date__Field"
                                                                                                   data-StartDateName="StartEvaluationDate"
                                                                                                   type="text" placeholder="{{ __("EndEmployeeEvaluation") }}"
                                                                                                   required>
                                                                                            <label class="Date__Label"
                                                                                                   for="NextEvaluationDate">
                                                                                                @lang("EndEmployeeEvaluation")
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
                                                                                            <textarea id="NotesForEvaluation" class="Textarea__Field" name="description"
                                                                                                      rows="3" placeholder="{{ __("NotesEvaluation") }}"></textarea>
                                                                                            <label class="Textarea__Label" for="NotesForEvaluation">@lang("NotesEvaluation")</label>
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
                                                                            <button class="Button Send"
                                                                                    type="submit">@lang("AddInfoEvaluationNew")</button>
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
