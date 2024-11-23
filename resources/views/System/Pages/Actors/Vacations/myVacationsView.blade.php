<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionVacationRead = !is_null(auth()->user()->employee["id"]) ;
    $IsHavePermissionVacationEdit = !is_null(auth()->user()->employee["id"]) ;
    $IsHavePermissionVacationDelete = !is_null(auth()->user()->employee["id"]) ;
    $IsHavePermissionVacationExport = $MyAccount->can("export_leaves") || $MyAccount->can("all_leaves") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    @if($IsHavePermissionVacationRead)
        <section class="MainContent__Section MainContent__Section--ViewVacationsPage">
            <div class="ViewVacationsPage">
                <div class="ViewVacationsPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __("viewMyVocations")." ".__($status) ,
                        'paths' => [[__("home") , '#'] , [__("viewMyVocations")]] ,
                        'summery' => __("titleViewMyVocations")
                    ])
                </div>
                <div class="ViewVacationsPage__Content">
                    <div class="Container--MainContent">
                        <div class="MessageProcessContainer">
                            @include("System.Components.messageProcess")
                        </div>
                        <div class="Row">
                            <div class="Col">
                                <div class="Card ViewVacationsPage__TableUsers">
                                    <div class="Table">
                                        @if($IsHavePermissionVacationExport)
                                            <form name="PrintAllTablePDF"
                                                  action="{{ route("system.leave_types.export.pdf") }}"
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
                                                  action="{{ route("system.leave_types.export.xls") }}"
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
                                                                    if($IsHavePermissionVacationExport) {
                                                                        array_push($AllOptions , [
                                                                            "Label" => __("printRowsAsPDF")
                                                                            , "Action" => route("system.leave_types.export.pdf")
                                                                            , "Method" => "post"
                                                                        ]);
                                                                        array_push($AllOptions , [
                                                                            "Label" => __("printRowsAsExcel")
                                                                            , "Action" => route("system.leave_types.export.xls")
                                                                            , "Method" => "post"
                                                                        ]);
                                                                    }
                                                                    if($IsHavePermissionVacationDelete)
                                                                        array_push($AllOptions , [
                                                                            "Label" => __("removeAllVocations") ,
                                                                            "Action" => route("system.leave_types.multi.delete") ,
                                                                            "Method" => "delete"
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
                                                                    @if($IsHavePermissionVacationExport)
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
                                                @if(count($data) > 0)
                                                    <div class="Card__Inner p0">
                                                        <div class="Table__ContentTable">
                                                            <table class="Center Table__Table" >
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
                                                                    <th class="Item__Col">@lang("vocationTypeWant")</th>
                                                                    <th class="Item__Col">@lang("fromDate")</th>
                                                                    <th class="Item__Col">@lang("vocationDaysNumber")</th>
                                                                    <th class="Item__Col">@lang("fromTime")</th>
                                                                    <th class="Item__Col">@lang("toTime")</th>
                                                                    <th class="Item__Col">@lang("stateRequest")</th>
                                                                    <th class="Item__Col">@lang("dateResponse")</th>
                                                                    <th class="Item__Col">@lang("more")</th>
                                                                </tr>
                                                                @foreach($data as $RequestItem)
                                                                    <tr class="Item DataItem">
                                                                        <td class="Item__Col Item__Col--Check">
                                                                            <input id="MoreRequestVacations_{{$RequestItem["id"]}}"
                                                                                   class="CheckBoxItem" type="checkbox"
                                                                                   name="ids[]" value="{{$RequestItem["id"]}}" hidden>
                                                                            <label for="MoreRequestVacations_{{$RequestItem["id"]}}"
                                                                                   class="CheckBoxRow">
                                                                                <i class="material-icons ">
                                                                                    check_small
                                                                                </i>
                                                                            </label>
                                                                        </td>
                                                                        <td class="Item__Col">{{ $RequestItem["id"] }}</td>
                                                                        <td class="Item__Col">{{ $RequestItem->leave_type["name"] ?? "(محذوف)" }}</td>
                                                                        <td class="Item__Col">{{ $RequestItem["from_date"] }}</td>
                                                                        <td class="Item__Col">{{ $RequestItem["count_days"] }}</td>
                                                                        <td class="Item__Col">{{ $RequestItem["from_time"] ?? "_" }}</td>
                                                                        <td class="Item__Col">{{ $RequestItem["to_time"] ?? "_" }}</td>
                                                                        <td class="Item__Col">{{ $RequestItem["status"] }}</td>
                                                                        <td class="Item__Col">{{ $RequestItem["date_update_status"] ?? "_" }}</td>
                                                                        <td class="Item__Col MoreDropdown">
                                                                            <i class="material-icons Popper--MoreMenuTable MenuPopper IconClick More__Button"
                                                                               data-MenuName="AllVacationsView_{{$RequestItem["id"]}}">
                                                                                more_horiz
                                                                            </i>
                                                                            <div class="Popper--MoreMenuTable MenuTarget Dropdown"
                                                                                 data-MenuName="AllVacationsView_{{$RequestItem["id"]}}">
                                                                                <ul class="Dropdown__Content">
                                                                                    @if($IsHavePermissionVacationEdit)
                                                                                        @if($RequestItem["status"] == "pending")
                                                                                            <li>
                                                                                                <a href="{{ route("system.leaves.edit.leave" , $RequestItem["id"]) }}"
                                                                                                   class="Dropdown__Item">
                                                                                                    @lang("editVacationRequest")
                                                                                                </a>
                                                                                            </li>
                                                                                        @endif
                                                                                    @endif
                                                                                    <li>
                                                                                        <a href="{{ route("system.leaves.show.leave" , $RequestItem["id"]) }}"
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
    @if($IsHavePermissionVacationRead)
        @php
            $LeaveTypes = [] ;
            foreach ($leavesType as $Index=>$TypeItem) {
                array_push($LeaveTypes , [ "Label" => $TypeItem
                    , "Value" => $Index ]) ;
            }
        @endphp
        @php
            $FilterItems = [] ;

            array_push($FilterItems , ['Type' => 'select' , 'Info' =>
                        ['Name' => "filter[leave_type]" , 'Placeholder' => __("vocationTypeWant") ,
                        "Options" => $LeaveTypes] ]);

            array_push($FilterItems , ['Type' => 'dateRange' , 'Info' =>
                    ['Name' => "end_date_decision" , 'Placeholder' => __("VocationDate")
                    , "StartDateName" => "filter[start_date_filter]" , "EndDateName" => "filter[end_date_filter]"] ]);

        @endphp
        @include("System.Components.searchForm" , [
           'InfoForm' => ["Route" => "" , "Method" => "get"] ,
           'FilterForm' => $FilterItems
       ])
    @endif
@endsection
