<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionDecisionRead = $MyAccount->can("read_decisions") || $MyAccount->can("all_decisions") ;
    $IsHavePermissionDecisionEdit = $MyAccount->can("update_decisions") || $MyAccount->can("all_decisions") ;
    $IsHavePermissionDecisionDelete = $MyAccount->can("delete_decisions") || $MyAccount->can("all_decisions") ;
    $IsHavePermissionDecisionExport = $MyAccount->can("export_decisions") || $MyAccount->can("all_decisions") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    @if($IsHavePermissionDecisionRead)
        <section class="MainContent__Section MainContent__Section--NewTypeViewPage">
            <div class="NewTypeViewPage">
                <div class="NewTypeViewPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __("ViewAllDecisionEvaluation") ,
                        'paths' => [['Home' , '#'] , ['Page']] ,
                        'summery' => __("TitleViewAllDecisionEvaluation")
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
                                        @if($IsHavePermissionDecisionExport)
                                            <form name="PrintAllTablePDF"
                                                  action="{{ route("system.session_decisions.export.pdf") }}"
                                                  class="FilterForm"
                                                  method="post">
                                                @csrf
                                                @foreach(FilterDataRequest() as $Index=>$FilterItem)
                                                    @if(!is_null($FilterItem))
                                                        <input type="hidden" name="filter[{{ $Index }}]" value="{{ $FilterItem }}"/>
                                                    @endif
                                                @endforeach
                                            </form>
                                            <form name="PrintAllTableXlsx"
                                                  action="{{ route("system.session_decisions.export.xls") }}"
                                                  class="FilterForm"
                                                  method="post">
                                                @csrf
                                                @foreach(FilterDataRequest() as $Index=>$FilterItem)
                                                    @if(!is_null($FilterItem))
                                                        <input type="hidden" name="filter[{{ $Index }}]" value="{{ $FilterItem }}"/>
                                                    @endif
                                                @endforeach
                                            </form>
                                        @endif
                                        <form action="#" method="post">
                                            @csrf
                                            <div class="Card__InnerGroup">
                                                <div class="Card__Inner py1">
                                                    <div class="Table__Head">
                                                        <div class="Card__ToolsGroup">
                                                            <div class="Card__Tools Table__BulkTools">
                                                                @php
                                                                    $AllOptions = [] ;
                                                                    if($IsHavePermissionDecisionExport) {
                                                                        array_push($AllOptions , [
                                                                        "Label" => __("printRowsAsPDF") ,
                                                                         "Action" => route("system.session_decisions.export.pdf") ,
                                                                         "Method" => "post"
                                                                    ]);
                                                                        array_push($AllOptions , [
                                                                            "Label" => __("printRowsAsExcel") ,
                                                                            "Action" => route("system.session_decisions.export.xls") ,
                                                                            "Method" => "post"
                                                                        ]);
                                                                    }
                                                                    if($IsHavePermissionDecisionDelete)
                                                                        array_push($AllOptions , [
                                                                            "Label" => __("normalDelete")
                                                                            , "Action" => route("system.session_decisions.multi.delete")
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
                                                                    @if($IsHavePermissionDecisionExport)
                                                                        <li>
                                                                            <span class="SearchTools__Separate"></span>
                                                                        </li>
                                                                        <li class="Table__PrintMenu">
                                                                            <i class="material-icons IconClick PrintMenu__Button"
                                                                               title="Print">print</i>
                                                                            <div class="Dropdown PrintMenu__Menu">
                                                                                <ul class="Dropdown__Content">
                                                                                    <li class="Dropdown__Item">
                                                                                        <a href="javascript:document.PrintAllTablePDF.submit()">
                                                                                            @lang("printTablePDFFile")
                                                                                        </a>
                                                                                    </li>
                                                                                    <li class="Dropdown__Item">
                                                                                        <a href="javascript:document.PrintAllTableXlsx.submit()">
                                                                                            @lang("printTableXlsxFile")
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(count($decisions) > 0)
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
                                                                        @lang("decisionNumber")
                                                                    </th>
                                                                    <th class="Item__Col">
                                                                        @lang("dateDecision")
                                                                    </th>
                                                                    <th class="Item__Col">
                                                                        @lang("dateDecisionEnd")
                                                                    </th>
                                                                    <th class="Item__Col">
                                                                        @lang("salaryEffectType")
                                                                    </th>
                                                                    <th class="Item__Col">
                                                                        @lang("ValueEffect")
                                                                    </th>
                                                                    <th class="Item__Col">
                                                                        @lang("RateEffect")
                                                                    </th>
                                                                    <th class="Item__Col">
                                                                        @lang("more")
                                                                    </th>
                                                                </tr>
                                                                @foreach($decisions as $DecisionItem)
                                                                    <tr class="Item DataItem">
                                                                        <td class="Item__Col Item__Col--Check">
                                                                            <input id="EvaluationID_{{ $DecisionItem["id"] }}"
                                                                                   class="CheckBoxItem" type="checkbox"
                                                                                   name="ids[]" value="{{ $DecisionItem["id"] }}" hidden>
                                                                            <label for="EvaluationID_{{ $DecisionItem["id"] }}"
                                                                                   class="CheckBoxRow">
                                                                                <i class="material-icons ">
                                                                                    check_small
                                                                                </i>
                                                                            </label>
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $DecisionItem["id"] }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $DecisionItem["number"] }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $DecisionItem["date"] }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $DecisionItem["end_date_decision"] }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $DecisionItem["effect_salary"] }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $DecisionItem["value"] ?? "-" }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $DecisionItem["rate"] ?? "-" }}
                                                                        </td>
                                                                        <td class="Item__Col MoreDropdown">
                                                                            <i class="material-icons Popper--MoreMenuTable MenuPopper IconClick More__Button"
                                                                               data-MenuName="MoreEvaluationOption_{{ $DecisionItem["id"] }}">
                                                                                more_horiz
                                                                            </i>
                                                                            <div class="Popper--MoreMenuTable MenuTarget Dropdown"
                                                                                 data-MenuName="MoreEvaluationOption_{{ $DecisionItem["id"] }}">
                                                                                <ul class="Dropdown__Content">
                                                                                    <li>
                                                                                        <a href="{{ route("system.decisions.show" , $DecisionItem["id"]) }}"
                                                                                           class="Dropdown__Item">
                                                                                            @lang("viewDetails")
                                                                                        </a>
                                                                                    </li>
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
                                                            "PaginationData" => $decisions ,
                                                            "PartsViewNum" => 5
                                                        ])
                                                        @include("System.Components.paginationSelect" , [
                                                            "PaginationData" => $decisions
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
    @if($IsHavePermissionDecisionRead)
        @php
            $TypeEffect = [] ;
            foreach ($type_effects as $EffectItem) {
                array_push($TypeEffect , [ "Label" => $EffectItem , "Value" => $EffectItem ]) ;
            }
        @endphp
        @include("System.Components.searchForm" , [
            'InfoForm' => ["Route" => "" , "Method" => "get"] ,
            'FilterForm' => [ ['Type' => 'number' , 'Info' =>
                    ['Name' => "filter[id]" , 'Placeholder' => __("decisionID")] ] ,
                    ['Type' => 'number' , 'Info' =>
                    ['Name' => "filter[number]" , 'Placeholder' => __("decisionNumber")] ] ,
                    ['Type' => 'dateRange' , 'Info' =>
                        ['Name' => "date" , 'Placeholder' => __("dateDecision")
                        , "StartDateName" => "filter[start_date]" , "EndDateName" => "filter[end_date]"] ] ,
                    ['Type' => 'dateRange' , 'Info' =>
                       ['Name' => "end_date_decision" , 'Placeholder' => __("dateDecisionEnd")
                       , "StartDateName" => "filter[start_date_filter]" , "EndDateName" => "filter[end_date_filter]"] ] ,
                    ['Type' => 'select' , 'Info' =>
                    ['Name' => "filter[effect_salary]" , 'Placeholder' => __("salaryEffectType") , "Options" => $TypeEffect] ] ,
                    ['Type' => 'number' , 'Info' =>
                    ['Name' => "filter[value]" , 'Placeholder' => __("ValueEffect")] ] ,
                    ['Type' => 'number' , 'Info' =>
                    ['Name' => "filter[rate]" , 'Placeholder' => __("RateEffect")] ] ,
                ]
        ])
    @endif
@endsection
