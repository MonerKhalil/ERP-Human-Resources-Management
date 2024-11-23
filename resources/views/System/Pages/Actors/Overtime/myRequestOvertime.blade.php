<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionOverTimeRead = !is_null(auth()->user()->employee["id"]) ;
    $IsHavePermissionOverTimeEdit = !is_null(auth()->user()->employee["id"]) ;
    $IsHavePermissionOverTimeDelete = !is_null(auth()->user()->employee["id"]) ;
    $IsHavePermissionOverTimeExport = $MyAccount->can("export_overtimes") || $MyAccount->can("all_overtimes") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    @if($IsHavePermissionOverTimeRead)
        <section class="MainContent__Section MainContent__Section--NewTypeViewPage">
            <div class="NewTypeViewPage">
                <div class="NewTypeViewPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' =>  __("viewMyOvertimeRequest").__($status) ,
                        'paths' => [[__("home") , '#'] , [__("viewMyOvertimeRequest")]] ,
                        'summery' => __("titleViewMyOvertimeRequest")
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
                                        @if($IsHavePermissionOverTimeExport)
                                            <form name="PrintAllTablePDF"
                                                  action="{{route("system.overtimes_admin.export.pdf")}}"
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
                                                  action="{{route("system.overtimes_admin.export.xls")}}"
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
                                                                    if($IsHavePermissionOverTimeExport) {
                                                                        array_push($AllOptions , [
                                                                            "Label" => __("printRowsAsPDF")
                                                                            , "Action" => route("system.overtimes_admin.export.pdf")
                                                                            , "Method" => "post"
                                                                        ]);
                                                                        array_push($AllOptions , [
                                                                            "Label" => __("printRowsAsExcel")
                                                                            , "Action" => route("system.overtimes_admin.export.xls")
                                                                            , "Method" => "post"
                                                                        ]);
                                                                    }
                                                                    if($IsHavePermissionOverTimeDelete)
                                                                        array_push($AllOptions , [
                                                                            "Label" => __("normalDelete")
                                                                            , "Action" => route("system.overtimes.remove.multi.request")
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
                                                                    <th class="Item__Col">@lang("overtimeType")</th>
                                                                    <th class="Item__Col">@lang("startDateFrom")</th>
                                                                    <th class="Item__Col">@lang("endDateFrom")</th>
                                                                    <th class="Item__Col">@lang("isItHour")</th>
                                                                    <th class="Item__Col">@lang("vocationTimeStart")</th>
                                                                    <th class="Item__Col">@lang("vocationTimeEnd")</th>
                                                                    <th class="Item__Col">@lang("stateRequest")</th>
                                                                    <th class="Item__Col">@lang("more")</th>
                                                                </tr>
                                                                @foreach($data as $Index=>$RequestOvertime)
                                                                    <tr class="Item DataItem">
                                                                        <td class="Item__Col Item__Col--Check">
                                                                            <input id="OvertimeRequest_{{ $RequestOvertime["id"] }}"
                                                                                   class="CheckBoxItem" type="checkbox" hidden
                                                                                   name="ids[]" value="{{ $RequestOvertime["id"] }}" >
                                                                            <label for="OvertimeRequest_{{ $RequestOvertime["id"] }}"
                                                                                   class="CheckBoxRow">
                                                                                <i class="material-icons ">
                                                                                    check_small
                                                                                </i>
                                                                            </label>
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $RequestOvertime["id"] }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $RequestOvertime->overtime_type["name"] }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $RequestOvertime["from_date"] }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $RequestOvertime["to_date"] }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            @if($RequestOvertime["is_hourly"])
                                                                                نعم
                                                                            @else
                                                                                لا
                                                                            @endif
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $RequestOvertime["from_time"] ?? "_" }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $RequestOvertime["to_time"] ?? "_" }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            @lang($RequestOvertime["status"])
                                                                        </td>
                                                                        <td class="Item__Col MoreDropdown">
                                                                            <i class="material-icons Popper--MoreMenuTable MenuPopper IconClick More__Button"
                                                                               data-MenuName="RequestOvertime_{{ $RequestOvertime["id"] }}">
                                                                                more_horiz
                                                                            </i>
                                                                            <div class="Popper--MoreMenuTable MenuTarget Dropdown"
                                                                                 data-MenuName="RequestOvertime_{{ $RequestOvertime["id"] }}">
                                                                                <ul class="Dropdown__Content">
                                                                                    <li>
                                                                                        <a href="{{ route("system.overtimes.show.overtime" , $RequestOvertime["id"]) }}"
                                                                                           class="Dropdown__Item">
                                                                                            @lang("viewDetails")
                                                                                        </a>
                                                                                    </li>
                                                                                    @if($IsHavePermissionOverTimeEdit)
                                                                                        @if($RequestOvertime["status"] == "pending")
                                                                                            <li>
                                                                                                <a href="{{ route("system.overtimes.edit.overtime" , $RequestOvertime["id"]) }}"
                                                                                                   class="Dropdown__Item">
                                                                                                    @lang("editRequest")
                                                                                                </a>
                                                                                            </li>
                                                                                        @endif
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
    @if($IsHavePermissionOverTimeRead)
        @php
            $OvertimeTypes = [] ;
            foreach ($overtimesType as $Index=>$OvertimeItem) {
                array_push($OvertimeTypes , [ "Label" => $OvertimeItem
                    , "Value" => $Index ]) ;
            }
        @endphp
        @php
            $IsHourlySelect = [] ;

            array_push($IsHourlySelect , [ "Label" => "نعم"
                    , "Value" => "1" ]) ;

            array_push($IsHourlySelect , [ "Label" => "لا"
                    , "Value" => "0" ]) ;
        @endphp
        @php

            $FilterItems = [] ;

            array_push($FilterItems , ['Type' => 'select' , 'Info' =>
               ['Name' => "filter[overtime_type]" , 'Placeholder' => __("overtimeType") ,
               "Options" => $OvertimeTypes] ]) ;

            array_push($FilterItems , ['Type' => 'dateRange' , 'Info' =>
                    ['Name' => "end_date_decision" , 'Placeholder' => __("overtimeDate")
                    , "StartDateName" => "filter[start_date_filter]" , "EndDateName" => "filter[end_date_filter]"] ]);

        @endphp
        @include("System.Components.searchForm" , [
           'InfoForm' => ["Route" => "" , "Method" => "get"] ,
           'FilterForm' => $FilterItems
       ])
    @endif
@endsection
