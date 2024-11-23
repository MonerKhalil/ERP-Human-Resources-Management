<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionPublicHolidayRead = $MyAccount->can("read_public_holidays") || $MyAccount->can("all_public_holidays") ;
    $IsHavePermissionPublicHolidayEdit = $MyAccount->can("update_public_holidays") || $MyAccount->can("all_public_holidays") ;
    $IsHavePermissionPublicHolidayDelete = $MyAccount->can("delete_public_holidays") || $MyAccount->can("all_public_holidays") ;
    $IsHavePermissionPublicHolidayExport = $MyAccount->can("export_public_holidays") || $MyAccount->can("all_public_holidays") ;
    $IsHavePermissionPublicHolidayCreate = $MyAccount->can("create_public_holidays") || $MyAccount->can("all_public_holidays") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    @if($IsHavePermissionPublicHolidayRead)
        <section class="MainContent__Section MainContent__Section--ViewPublicHolidayPage">
            <div class="ViewPublicHolidayPage">
                <div class="ViewPublicHolidayPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __("viewAllPublicHoliday") ,
                        'paths' => [[__("home") , '#'] , [__("viewAllPublicHoliday")]] ,
                        'summery' => __("titleViewAllPublicHoliday")
                    ])
                </div>
                <div class="ViewPublicHolidayPage__Content">
                    <div class="Container--MainContent">
                        <div class="MessageProcessContainer">
                            @include("System.Components.messageProcess")
                        </div>
                        <div class="Row">
                            <div class="Col">
                                <div class="Card ViewPublicHolidayPage__TableUsers">
                                    <div class="Table">
                                        @if($IsHavePermissionPublicHolidayExport)
                                            <form name="PrintAllTablePDF"
                                                  action="{{route("system.public_holidays.export.pdf")}}"
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
                                                  action="{{route("system.public_holidays.export.xls")}}"
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
                                                                    if($IsHavePermissionPublicHolidayExport) {
                                                                        array_push($AllOptions , [
                                                                            "Label" => __("printRowsAsPDF")
                                                                            , "Action" => route("system.public_holidays.export.pdf")
                                                                            , "Method" => "post"
                                                                        ]);
                                                                        array_push($AllOptions , [
                                                                            "Label" => __("printRowsAsExcel")
                                                                            , "Action" => route("system.public_holidays.export.xls")
                                                                            , "Method" => "post"
                                                                        ]);
                                                                    }
                                                                    if($IsHavePermissionPublicHolidayDelete)
                                                                        array_push($AllOptions , [
                                                                             "Label" => __("removePublicHoliday") ,
                                                                             "Action" => route("system.public_holidays.multi.delete") ,
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
                                                                    @if($IsHavePermissionPublicHolidayExport)
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
                                                <div class="Card__Inner p0">
                                                    @if(count($data) > 0)
                                                        <div class="Table__ContentTable">
                                                            <table class="Center Table__Table" >
                                                                <tr class="Item HeaderList">
                                                                    <th class="Item__Col Item__Col--Check">
                                                                        <input id="ItemRow_Main" class="CheckBoxItem"
                                                                               type="checkbox" hidden>
                                                                        <label for="ItemRow_Main" class="CheckBoxRow">
                                                                            <i class="material-icons">
                                                                                check_small
                                                                            </i>
                                                                        </label>
                                                                    </th>
                                                                    <th class="Item__Col">#</th>
                                                                    <th class="Item__Col">@lang("publicHolidayName")</th>
                                                                    <th class="Item__Col">@lang("publicHolidayStartDate")</th>
                                                                    <th class="Item__Col">@lang("publicHolidayEndDate")</th>
                                                                    <th class="Item__Col">@lang("more")</th>
                                                                </tr>
                                                                @foreach($data as $Index=>$HolidayItem)
                                                                    <tr class="Item DataItem">
                                                                        <td class="Item__Col Item__Col--Check">
                                                                            <input id="MoreRequestVacations_{{$HolidayItem["id"]}}"
                                                                                   class="CheckBoxItem" type="checkbox"
                                                                                   name="ids[]" value="{{$HolidayItem["id"]}}" hidden>
                                                                            <label for="MoreRequestVacations_{{$HolidayItem["id"]}}"
                                                                                   class="CheckBoxRow">
                                                                                <i class="material-icons">
                                                                                    check_small
                                                                                </i>
                                                                            </label>
                                                                        </td>
                                                                        <td class="Item__Col">{{$HolidayItem["id"]}}</td>
                                                                        <td class="Item__Col">{{$HolidayItem["name"]}}</td>
                                                                        <td class="Item__Col">{{$HolidayItem["start_date"]}}</td>
                                                                        <td class="Item__Col">{{$HolidayItem["end_date"]}}</td>
                                                                        <td class="Item__Col MoreDropdown">
                                                                            @php
                                                                                $StartDate = \Carbon\Carbon::parse($HolidayItem["start_date"]);
                                                                                $EndDate = \Carbon\Carbon::parse($HolidayItem["end_date"]);
                                                                                $NowDate = \Carbon\Carbon::now();
                                                                                $isCanEdit = $NowDate->lt($StartDate) && $NowDate->lt($EndDate) ;
                                                                            @endphp
                                                                            @if($IsHavePermissionPublicHolidayEdit && $isCanEdit)
                                                                                <i class="material-icons Popper--MoreMenuTable MenuPopper IconClick More__Button"
                                                                                   data-MenuName="AllVacationsView_{{$HolidayItem["id"]}}">
                                                                                    more_horiz
                                                                                </i>
                                                                                <div class="Popper--MoreMenuTable MenuTarget Dropdown"
                                                                                     data-MenuName="AllVacationsView_{{$HolidayItem["id"]}}">
                                                                                    <ul class="Dropdown__Content">
                                                                                        @if($IsHavePermissionPublicHolidayEdit)
                                                                                            <li>
                                                                                                <a href="{{route("system.public_holidays.edit" , $HolidayItem["id"])}}"
                                                                                                   class="Dropdown__Item">
                                                                                                    @lang("editPublicHolidayInfo")
                                                                                                </a>
                                                                                            </li>
                                                                                        @endif
                                                                                    </ul>
                                                                                </div>
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    @else
                                                        @include("System.Components.noData")
                                                    @endif
                                                </div>
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
    @if($IsHavePermissionPublicHolidayRead)
        @include("System.Components.searchForm" , [
           'InfoForm' => ["Route" => "" , "Method" => "get"] ,
           'FilterForm' => [

               ['Type' => 'text' , 'Info' =>
                   ['Name' => "filter[name]" , 'Placeholder' => __("publicHolidayName")] ] ,

               ['Type' => 'dateRange' , 'Info' => ['Placeholder' => __("publicHolidayDate") ,
                     'StartDateName' => "filter[start_date_filter]" , 'EndDateName' => "filter[end_date_filter]"
                    ]
               ] ,
           ]
       ])
    @endif
@endsection
