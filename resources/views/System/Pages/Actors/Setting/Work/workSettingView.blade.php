<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionWorkSettingRead = $MyAccount->can("read_work_settings") || $MyAccount->can("all_work_settings") ;
    $IsHavePermissionWorkSettingEdit = $MyAccount->can("update_work_settings") || $MyAccount->can("all_work_settings") ;
    $IsHavePermissionWorkSettingDelete = $MyAccount->can("delete_work_settings") || $MyAccount->can("all_work_settings") ;
    $IsHavePermissionWorkSettingExport = $MyAccount->can("export_work_settings") || $MyAccount->can("all_work_settings") ;
    $IsHavePermissionWorkSettingCreate = $MyAccount->can("create_work_settings") || $MyAccount->can("all_work_settings") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    @if($IsHavePermissionWorkSettingRead)
        <section class="MainContent__Section MainContent__Section--SettingWorkView">
            <div class="SettingWorkViewPage">
                <div class="SettingWorkViewPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __("viewAllWorkSetting") ,
                        'paths' => [[__("home") , '#'] , [__("viewAllWorkSetting")]] ,
                        'summery' => __("titleViewAllWorkSetting")
                    ])
                </div>
                <div class="SettingWorkViewPage__Content">
                    <div class="Container--MainContent">
                        <div class="MessageProcessContainer">
                            @include("System.Components.messageProcess")
                        </div>
                        <div class="Row">
                            <div class="Col">
                                <div class="Card SettingWorkViewPage__TableUsers">
                                    <div class="Table">
                                        @if($IsHavePermissionWorkSettingExport)
                                            <form name="PrintAllTablePDF"
                                                  action="{{route("system.work_settings.export.pdf")}}"
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
                                                  action="{{route("system.work_settings.export.xls")}}"
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
                                                                    if($IsHavePermissionWorkSettingExport) {
                                                                        array_push($AllOptions , [
                                                                            "Label" => __("printRowsAsPDF")
                                                                            , "Action" => route("system.work_settings.export.pdf")
                                                                            , "Method" => "post"
                                                                        ]);
                                                                        array_push($AllOptions , [
                                                                            "Label" => __("printRowsAsExcel")
                                                                            , "Action" => route("system.work_settings.export.xls")
                                                                            , "Method" => "post"
                                                                        ]);
                                                                    }
                                                                    if($IsHavePermissionWorkSettingDelete)
                                                                        array_push($AllOptions , [
                                                                           "Label" => __("normalDelete")
                                                                            , "Action" => route("system.work_settings.multi.delete")
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
                                                                    @if($IsHavePermissionWorkSettingExport)
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
                                                            <table class="Center Table__Table">
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
                                                                    <th class="Item__Col">@lang("nameType")</th>
                                                                    <th class="Item__Col">@lang("workSettingDays")</th>
                                                                    <th class="Item__Col">@lang("hoursWorkSetting")</th>
                                                                    <th class="Item__Col">@lang("workSettingStartDate")</th>
                                                                    <th class="Item__Col">@lang("workSettingEndDate")</th>
                                                                    <th class="Item__Col">@lang("DefaultSalary")</th>
                                                                    <th class="Item__Col">@lang("RateValueDiscountLate")</th>
                                                                    <th class="Item__Col">@lang("DiscountBy")</th>
                                                                    <th class="Item__Col">@lang("more")</th>
                                                                </tr>
                                                                @foreach($data as $DataItem)
                                                                    <tr class="Item DataItem">
                                                                        <td class="Item__Col Item__Col--Check">
                                                                            <input id="{{$DataItem["id"]}}"
                                                                                   class="CheckBoxItem" type="checkbox"
                                                                                   name="ids[]" value="{{$DataItem["id"]}}" hidden>
                                                                            <label for="{{$DataItem["id"]}}" class="CheckBoxRow">
                                                                                <i class="material-icons">
                                                                                    check_small
                                                                                </i>
                                                                            </label>
                                                                        </td>
                                                                        <td class="Item__Col">{{ $DataItem["id"] }}</td>
                                                                        <td class="Item__Col">{{ $DataItem["name"] }}</td>
                                                                        <td class="Item__Col">{{ $DataItem["count_days_work_in_weeks"] }}</td>
                                                                        <td class="Item__Col">{{ $DataItem["count_hours_work_in_days"] }}</td>
                                                                        <td class="Item__Col">{{ $DataItem["work_hours_from"] }}</td>
                                                                        <td class="Item__Col">{{ $DataItem["work_hours_to"] }}</td>
                                                                        <td class="Item__Col">{{ $DataItem["salary_default"] }}</td>
                                                                        <td class="Item__Col">{{ $DataItem["rate_deduction_from_salary"] }}</td>
                                                                        <td class="Item__Col">{{ $DataItem["type_discount_minuteOrHour"] }}</td>
                                                                        <td class="Item__Col MoreDropdown">
                                                                            <i class="material-icons Popper--MoreMenuTable MenuPopper IconClick More__Button"
                                                                               data-MenuName="MoreDecision_{{$DataItem["id"]}}">
                                                                                more_horiz
                                                                            </i>
                                                                            <div class="Popper--MoreMenuTable MenuTarget Dropdown"
                                                                                 data-MenuName="MoreDecision_{{$DataItem["id"]}}">
                                                                                <ul class="Dropdown__Content">
                                                                                    <li>
                                                                                        <a href="{{route("system.work_settings.show" , $DataItem["id"])}}"
                                                                                           class="Dropdown__Item">
                                                                                            @lang("viewDetails")
                                                                                        </a>
                                                                                    </li>
                                                                                    @if($IsHavePermissionWorkSettingEdit)
                                                                                        <li>
                                                                                            <a href="{{route("system.work_settings.edit" , $DataItem["id"])}}"
                                                                                               class="Dropdown__Item">
                                                                                                @lang("editType")
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
    @if($IsHavePermissionWorkSettingRead)

        @php
            $Options = [] ;
            array_push($Options , [ "Label" => __("minutes") , "Value" => "minute"]) ;
            array_push($Options , [ "Label" => __("hours") , "Value" => "hour"]) ;
        @endphp

        @include("System.Components.searchForm" , [
            'InfoForm' => ["Route" => "" , "Method" => "get"] ,
            'FilterForm' => [
                ['Type' => 'text' , 'Info' =>
                    ['Name' => "filter[name]" , 'Placeholder' => __("nameType")] ] ,
                ['Type' => 'number' , 'Info' =>
                    ['Name' => "filter[count_days_work_in_weeks]" , 'Placeholder' => __("workSettingDays")] ] ,
                ['Type' => 'number' , 'Info' =>
                    ['Name' => "filter[count_hours_work_in_days]" , 'Placeholder' => __("hoursWorkSetting")] ] ,
                ['Type' => 'NormalTime' , 'Info' =>
                    ['Name' => "filter[work_hours_from]" , 'Placeholder' => __("workSettingStartDate")] ] ,
                ['Type' => 'NormalTime' , 'Info' =>
                    ['Name' => "filter[work_hours_to]" , 'Placeholder' => __("workSettingEndDate")] ] ,
               ['Type' => 'number' , 'Info' =>
                    ['Name' => "filter[salary_default]" , 'Placeholder' => __("DefaultSalary")] ] ,
               ['Type' => 'number' , 'Info' =>
                    ['Name' => "filter[rate_deduction_from_salary]" , 'Placeholder' => __("RateValueDiscountLate")] ] ,
                ['Type' => 'select' , 'Info' =>
                        ['Name' => "filter[type_discount_minuteOrHour]" , 'Placeholder' => __("DiscountBy") ,
                        "Options" => $Options] ]
            ]
        ])
    @endif
@endsection
