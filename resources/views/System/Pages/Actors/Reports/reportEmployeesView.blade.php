<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionReportRead = $MyAccount->can("read_employees") || $MyAccount->can("all_employees") ;
    $IsHavePermissionReportEdit = $MyAccount->can("update_employees") || $MyAccount->can("all_employees") ;
    $IsHavePermissionReportDelete = $MyAccount->can("delete_employees") || $MyAccount->can("all_employees") ;
    $IsHavePermissionReportExport = $MyAccount->can("export_employees") || $MyAccount->can("all_employees") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--ReportEmployeesView">
        <div class="ReportEmployeesView">
            <div class="ReportEmployeesView__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __("reportAboutEmployee") ,
                    'paths' => [[__("home") , '#'] , [__("reportAboutEmployee")]] ,
                    'summery' => __("titleReportAboutEmployee")
                ])
            </div>
            <div class="ReportEmployeesView__Content">
                <div class="Container--MainContent">
                    <div class="MessageProcessContainer">
                        @include("System.Components.messageProcess")
                    </div>
                    <div class="Row">
                        <div class="Col">
                            <div class="Card ReportEmployeesView__TableUsers">
                                <div class="Table">
                                    @if($IsHavePermissionReportExport)
                                        <form name="PrintAllTablePDF"
                                              action="{{ route("system.employees.report.pdf") }}"
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
                                              action="{{ route("system.employees.report.xlsx") }}"
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
                                                    <div class="Justify-Content-End Card__ToolsGroup">
                                                        <div class="Card__Tools Card__SearchTools">
                                                            <ul class="SearchTools">
                                                                @if($IsHavePermissionReportExport)
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
                                            <div class="Card__Inner p0">
                                                <div class="Table__ContentTable">
                                                    <table class="Table__Table" >
                                                        <tr class="Item HeaderList">
                                                            <th class="Item__Col">
                                                                #
                                                            </th>
                                                            <th class="Item__Col">
                                                                @lang("employeeName")
                                                            </th>
                                                            <th class="Item__Col">
                                                                @lang("gender")
                                                            </th>
                                                            <th class="Item__Col">
                                                                @lang("fileNumber")
                                                            </th>
                                                            <th class="Item__Col">
                                                                @lang("currentJob")
                                                            </th>
                                                            <th class="Item__Col">
                                                                @lang("more")
                                                            </th>
                                                        </tr>
                                                        @foreach($finalData as $RowData)
                                                            <tbody class="GroupRows">
                                                                <tr class="GroupRows__MainRow">
                                                                    <td class="Item__Col">
                                                                        {{ $RowData["id"] }}
                                                                    </td>
                                                                    <td class="Item__Col">
                                                                        {{ $RowData["first_name"]." ".$RowData["last_name"] }}
                                                                    </td>
                                                                    <td class="Item__Col">
                                                                        {{ $RowData["gender"] }}
                                                                    </td>
                                                                    <td class="Item__Col">
                                                                        1
                                                                    </td>
                                                                    <td class="Item__Col">
                                                                        {{ $RowData["current_job"] }}
                                                                    </td>
                                                                    <td class="Item__Col Item__Col--Details">
                                                                        <span class="Details__Button">@lang("details")</span>
                                                                    </td>
                                                                </tr>
                                                                <tr class="GroupRows__SubRows">
                                                                    <td class="Item__Col" colspan="6">
                                                                    <div class="Report">
                                                                        <div class="Report__Content">
                                                                            <div class="ListData NotResponsive">
                                                                                <div class="ListData__Content">
                                                                                    @foreach($dataSelected as $Index => $ReportSelected)
                                                                                        @if($Index != "gender")
                                                                                            <div class="ListData__Item ListData__Item--NoAction">
                                                                                                <div class="Data_Col">
                                                                                                    <span class="Data_Label">
                                                                                                        {{ $Index }}
                                                                                                    </span>
                                                                                                    <span class="Data_Value">
                                                                                                        {{ $ReportSelected }}
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                </tr>
                                                            </tbody>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="Card__Inner">
                                                <div class="Card__Pagination">
                                                    @include("System.Components.paginationNum" , [
                                                        "PaginationData" => $finalData ,
                                                        "PartsViewNum" => 5
                                                    ])
                                                    @include("System.Components.paginationSelect" , [
                                                        "PaginationData" => $finalData
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
@endsection
