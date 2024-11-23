<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionOverTimeTypeRead = $MyAccount->can("read_overtime_types") || $MyAccount->can("all_overtime_types") ;
    $IsHavePermissionOverTimeTypeEdit = $MyAccount->can("update_overtime_types") || $MyAccount->can("all_overtime_types") ;
    $IsHavePermissionOverTimeTypeDelete = $MyAccount->can("delete_overtime_types") || $MyAccount->can("all_overtime_types") ;
    $IsHavePermissionOverTimeTypeExport = $MyAccount->can("export_overtime_types") || $MyAccount->can("all_overtime_types") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    @if($IsHavePermissionOverTimeTypeRead)
        <section class="MainContent__Section MainContent__Section--NewTypeViewPage">
            <div class="NewTypeViewPage">
                <div class="NewTypeViewPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __("viewAllOvertimeType") ,
                        'paths' => [[__("home") , '#'] , [__("viewAllOvertimeType")]] ,
                        'summery' => __("titleViewAllOvertimeType")
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
                                                                    if($IsHavePermissionOverTimeTypeDelete)
                                                                        array_push($AllOptions , [
                                                                             "Label" => __("normalDelete")
                                                                            , "Action" => route("system.overtime_types.multi.delete")
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
                                                                    <th class="Item__Col">@lang("nameType")</th>
                                                                    <th class="Item__Col">@lang("rateMaxSalaryExtra")</th>
                                                                    <th class="Item__Col">@lang("minimumHourForAcceptOvertime")</th>
                                                                    <th class="Item__Col">@lang("amountSalaryInHour")</th>
                                                                    <th class="Item__Col">@lang("more")</th>
                                                                </tr>
                                                                @foreach($data as $TypeItem)
                                                                    <tr class="Item DataItem">
                                                                        <td class="Item__Col Item__Col--Check">
                                                                            <input id="OvertimeType_{{ $TypeItem["id"] }}"
                                                                                   class="CheckBoxItem" type="checkbox"
                                                                                   name="ids[]" value="{{ $TypeItem["id"] }}" hidden>
                                                                            <label for="OvertimeType_{{ $TypeItem["id"] }}"
                                                                                   class="CheckBoxRow">
                                                                                <i class="material-icons ">
                                                                                    check_small
                                                                                </i>
                                                                            </label>
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $TypeItem["id"] }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $TypeItem["name"] }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $TypeItem["max_rate_salary"] }} %
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $TypeItem["min_hours_in_days"] }}
                                                                        </td>
                                                                        <td class="Item__Col">
                                                                            {{ $TypeItem["salary_in_hours"] }}
                                                                        </td>
                                                                        <td class="Item__Col MoreDropdown">
                                                                            <i class="material-icons Popper--MoreMenuTable MenuPopper IconClick More__Button"
                                                                               data-MenuName="TypeOvertime_{{ $TypeItem["id"] }}">
                                                                                more_horiz
                                                                            </i>
                                                                            <div class="Popper--MoreMenuTable MenuTarget Dropdown"
                                                                                 data-MenuName="TypeOvertime_{{ $TypeItem["id"] }}">
                                                                                <ul class="Dropdown__Content">
                                                                                    <li>
                                                                                        <a href="{{ route("system.overtime_types.show" , $TypeItem["id"]) }}"
                                                                                           class="Dropdown__Item">
                                                                                            @lang("viewDetails")
                                                                                        </a>
                                                                                    </li>
                                                                                    @if($IsHavePermissionOverTimeTypeEdit)
                                                                                        <li>
                                                                                            <a href="{{ route("system.overtime_types.edit" , $TypeItem["id"]) }}"
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
    @if($IsHavePermissionOverTimeTypeRead)
        @include("System.Components.searchForm" , [
            'InfoForm' => ["Route" => "" , "Method" => "get"] ,
            'FilterForm' => [
                ['Type' => 'text' , 'Info' =>
                    ['Name' => "filter[name]" , 'Placeholder' => __("nameType")] ] ,
                ['Type' => 'number' , 'Info' =>
                    ['Name' => "filter[max_rate_salary]" , 'Placeholder' => __("rateMaxSalaryExtra")] ] ,
                ['Type' => 'number' , 'Info' =>
                    ['Name' => "filter[min_hours_in_days]" , 'Placeholder' => __("minimumHourForAcceptOvertime")] ] ,
                ['Type' => 'number' , 'Info' =>
                    ['Name' => "filter[salary_in_hours]" , 'Placeholder' => __("amountSalaryInHour")] ] ,
            ]
        ])
    @endif
@endsection
