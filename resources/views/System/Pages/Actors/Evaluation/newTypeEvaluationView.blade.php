<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionEvaluationRead = $MyAccount->can("read_employee_evaluations") || $MyAccount->can("all_employee_evaluations") ;
    $IsHavePermissionEvaluationEdit = $MyAccount->can("update_employee_evaluations") || $MyAccount->can("all_employee_evaluations") ;
    $IsHavePermissionEvaluationDelete = $MyAccount->can("delete_employee_evaluations") || $MyAccount->can("all_employee_evaluations") ;
    $IsHavePermissionEvaluationExport = $MyAccount->can("export_employee_evaluations") || $MyAccount->can("all_employee_evaluations") ;
    $IsHavePermissionEvaluationCreate = $MyAccount->can("create_employee_evaluations") || $MyAccount->can("all_employee_evaluations") ;
    $IsHavePermissionDecisionRead = $MyAccount->can("read_decisions") || $MyAccount->can("all_decisions") ;
    $IsHavePermissionDecisionCreate = $MyAccount->can("create_decisions") || $MyAccount->can("all_decisions") ;
?>


@extends("System.Pages.globalPage")

@section("ContentPage")
    @if($IsHavePermissionEvaluationRead)
        <section class="MainContent__Section MainContent__Section--NewTypeViewPage">
            <div class="NewTypeViewPage">
                <div class="NewTypeViewPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __("ViewAllEvaluation") ,
                        'paths' => [['Home' , '#'] , ['Page']] ,
                        'summery' => __("TitleAllEvaluation")
                    ])
                </div>
                <div class="NewTypeViewPage__Content">
                    <div class="Container--MainContent">
                        <div class="MessageProcessContainer">
                            @include("System.Components.messageProcess")
                        </div>
                        <div class="Row">
                            <div class="Col">
                                <div class="Card NewTypeViewPage__TableUsers">
                                    <div class="Table">
                                        <form action="#" method="post">
                                            @csrf
                                            <div class="Card__InnerGroup">
                                                <div class="Card__Inner py1">
                                                    <div class="Table__Head">
                                                        <div class="Card__ToolsGroup">
                                                            <div class="Card__Tools Table__BulkTools">
                                                                @php
                                                                    $AllOptions = [] ;
                                                                    if($IsHavePermissionEvaluationDelete)
                                                                        array_push($AllOptions , [
                                                                            "Label" => __("normalDelete")
                                                                            , "Action" => route("system.evaluation.employee.multi.destroy.evaluation")
                                                                            , "Method" => "delete"
                                                                    ]);
                                                                @endphp
                                                                @include("System.Components.bulkAction" , [
                                                                    "Options" => $AllOptions
                                                                ])
                                                            </div>
                                                            <div class="Card__Tools Card__SearchTools">
                                                                <ul class="SearchTools">
                                                                    <li>
                                                                        <i class="OpenPopup material-icons IconClick SearchTools__FilterIcon"
                                                                           data-popUp="SearchAbout">filter_list
                                                                        </i>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(count($data) > 0)
                                                    <div class="Card__Inner p0">
                                                        <div class="Table__ContentTable">
                                                            <table class="Table__Table" >
                                                                <tr class="Item HeaderList">
                                                                    <th class="Item__Col Item__Col--Check">
                                                                        <input id="ItemRow_Main" class="CheckBoxItem"
                                                                               type="checkbox" hidden>
                                                                        <label for="ItemRow_Main" class="CheckBoxRow">
                                                                            <i class="material-icons ">
                                                                                check_small
                                                                            </i>
                                                                        </label>
                                                                    </th>
                                                                    <th class="Item__Col">#</th>
                                                                    <th class="Item__Col">
                                                                        @lang("employeeName")
                                                                    </th>
                                                                    <th class="Item__Col">
                                                                        @lang("StartEmployeeEvaluation")
                                                                    </th>
                                                                    <th class="Item__Col">
                                                                        @lang("EndEmployeeEvaluation")
                                                                    </th>
                                                                    <th class="Item__Col">
                                                                        @lang("CreateDateEvaluation")
                                                                    </th>
                                                                    <th class="Item__Col">
                                                                        @lang("more")
                                                                    </th>
                                                                </tr>
                                                                @foreach($data as $Index => $EvaluationType)
                                                                    <tr class="Item DataItem">
                                                                        <td class="Item__Col Item__Col--Check">
                                                                            <input id="EvaluationID_{{ $EvaluationType["id"] }}"
                                                                                   class="CheckBoxItem" type="checkbox"
                                                                                   name="ids[]" value="{{ $EvaluationType["id"] }}" hidden>
                                                                            <label for="EvaluationID_{{ $EvaluationType["id"] }}" class="CheckBoxRow">
                                                                                <i class="material-icons ">
                                                                                    check_small
                                                                                </i>
                                                                            </label>
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $EvaluationType["id"] }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $EvaluationType->employee["first_name"].$EvaluationType->employee["last_name"] }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $EvaluationType["evaluation_date"] }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $EvaluationType["next_evaluation_date"] }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $EvaluationType["created_at"] }}
                                                                        </td>
                                                                        <td class="Item__Col MoreDropdown">
                                                                            <i class="material-icons Popper--MoreMenuTable MenuPopper IconClick More__Button"
                                                                               data-MenuName="MoreEvaluationOption_{{ $EvaluationType["id"] }}">
                                                                                more_horiz
                                                                            </i>
                                                                            <div class="Popper--MoreMenuTable MenuTarget Dropdown"
                                                                                 data-MenuName="MoreEvaluationOption_{{ $EvaluationType["id"] }}">
                                                                                <ul class="Dropdown__Content">
                                                                                    <li>
                                                                                        <a href="{{ route("system.evaluation.employee.show.evaluation.details" , $EvaluationType["id"]) }}"
                                                                                           class="Dropdown__Item">
                                                                                            @lang("viewDetails")
                                                                                        </a>
                                                                                    </li>
                                                                                    @if($IsHavePermissionDecisionCreate)
                                                                                        <li>
                                                                                            <a href="{{ route("system.evaluation.employee.show.add.decision.evaluation" , $EvaluationType["id"]) }}"
                                                                                               class="Dropdown__Item">
                                                                                                @lang("AddDecisionForEmployee")
                                                                                            </a>
                                                                                        </li>
                                                                                    @endif
                                                                                    @if($IsHavePermissionEvaluationCreate)
                                                                                        @php
                                                                                            $IsCanEvaluation = false ;
                                                                                            foreach ($EvaluationType->enter_evaluation_employee as $EmployeeInfo)
                                                                                                if($EmployeeInfo->employee["user_id"] === Auth()->user()["id"]) {
                                                                                                    $IsCanEvaluation = true ;
                                                                                                    break ;
                                                                                                }
                                                                                        @endphp
                                                                                        @if($IsCanEvaluation)
                                                                                            <li>
                                                                                                <a href="{{ route("system.evaluation.employee.show.add.evaluation" , $EvaluationType["id"]) }}"
                                                                                                   class="Dropdown__Item">
                                                                                                    @lang("AddEvaluationForEmployee")
                                                                                                </a>
                                                                                            </li>
                                                                                        @endif
                                                                                    @endif
                                                                                    <li>
                                                                                        <a href="{{ route("system.evaluation.employee.show.evaluation" , $EvaluationType["id"]) }}"
                                                                                           class="Dropdown__Item">
                                                                                            @lang("ViewEvaluationEmployee")
                                                                                        </a>
                                                                                    </li>
                                                                                    @if($IsHavePermissionDecisionRead)
                                                                                        <li>
                                                                                            <a href="{{ route("system.evaluation.employee.show.evaluation.decisions" , $EvaluationType["id"]) }}"
                                                                                               class="Dropdown__Item">
                                                                                                @lang("ViewDecisionEmployee")
                                                                                            </a>
                                                                                        </li>
                                                                                    @endif
                                                                                </ul>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                @else
                                                    @include("System.Components.noData")
                                                @endif
                                                <div class="Card__Inner">
                                                    <div class="Card__Pagination">
                                                        @include("System.Components.paginationNum" , [
                                                            "PaginationData" => $data ,
                                                            "PartsViewNum" => 5
                                                        ])
                                                        @include("System.Components.paginationSelect" , [
                                                            "PaginationData" => $data
                                                        ])
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
        </section>
    @endif
@endsection

@section("PopupPage")
    @if($IsHavePermissionEvaluationRead)
        @include("System.Components.searchForm" , [
        'InfoForm' => ["Route" => "" , "Method" => "get"] ,
        'FilterForm' => [ ['Type' => 'number' , 'Info' =>
                ['Name' => "filter[id]" , 'Placeholder' => __("NumberEvaluation")] ] ,
                ['Type' => 'text' , 'Info' =>
                ['Name' => "filter[employee_name]" , 'Placeholder' => __("employeeName")] ] ,
                ['Type' => 'dateSingle' , 'Info' =>
                    ['Name' => "filter[evaluation_date]" , 'Placeholder' => __("StartEmployeeEvaluation")] ] ,
                ['Type' => 'dateSingle' , 'Info' =>
                   ['Name' => "filter[next_evaluation_date]" , 'Placeholder' => __("EndEmployeeEvaluation") ] ]
        ]
    ])
    @endif
@endsection
