<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionDecisionTypeRead = $MyAccount->can("read_type_decisions") || $MyAccount->can("all_type_decisions") ;
    $IsHavePermissionDecisionTypeEdit = $MyAccount->can("update_type_decisions") || $MyAccount->can("all_type_decisions") ;
    $IsHavePermissionDecisionTypeDelete = $MyAccount->can("delete_type_decisions") || $MyAccount->can("all_type_decisions") ;
    $IsHavePermissionDecisionTypeExport = $MyAccount->can("export_type_decisions") || $MyAccount->can("all_type_decisions") ;
    $IsHavePermissionDecisionTypeCreate = $MyAccount->can("create_type_decisions") || $MyAccount->can("all_type_decisions") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    @if($IsHavePermissionDecisionTypeRead)
        <section class="MainContent__Section MainContent__Section--ViewDecision">
            <div class="ViewDecision">
                <div class="ViewDecision__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => "عرض جميع انواع التقارير" ,
                        'paths' => [[__("home") , '#'] , [__("viewDecision")]] ,
                        'summery' => __("titleViewDecision")
                    ])
                </div>
                <div class="ViewDecision__Content">
                    <div class="Container--MainContent">
                        <div class="MessageProcessContainer">
                            @include("System.Components.messageProcess")
                        </div>
                        <div class="Row">
                            <div class="Col">
                                <div class="Card ViewDecision__TableUsers">
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
                                                                    if($IsHavePermissionDecisionTypeDelete)
                                                                        array_push($AllOptions , [
                                                                                "Label" => __("normalDelete")
                                                                                , "Action" => route("system.type_decisions.multi.delete")
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
                                                            <table class="Center Table__Table">
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
                                                                    <th class="Item__Col">اسم النوع</th>
                                                                    <th class="Item__Col">@lang("more")</th>
                                                                </tr>
                                                                @foreach($data as $DecisionTypeData)
                                                                    <tr class="Item DataItem">
                                                                        <td class="Item__Col Item__Col--Check">
                                                                            <input id="{{$DecisionTypeData["id"]}}"
                                                                                   class="CheckBoxItem" type="checkbox"
                                                                                   name="ids[]" value="{{$DecisionTypeData["id"]}}" hidden>
                                                                            <label for="{{$DecisionTypeData["id"]}}" class="CheckBoxRow">
                                                                                <i class="material-icons ">
                                                                                    check_small
                                                                                </i>
                                                                            </label>
                                                                        </td>
                                                                        <td class="Item__Col">{{$DecisionTypeData["id"]}}</td>
                                                                        <td class="Item__Col">{{$DecisionTypeData["name"]}}</td>
                                                                        <td class="Item__Col MoreDropdown">
                                                                            @if($IsHavePermissionDecisionTypeEdit)
                                                                                <i class="material-icons Popper--MoreMenuTable MenuPopper IconClick More__Button"
                                                                                   data-MenuName="MoreDecision_{{$DecisionTypeData["id"]}}">
                                                                                    more_horiz
                                                                                </i>
                                                                                <div class="Popper--MoreMenuTable MenuTarget Dropdown"
                                                                                     data-MenuName="MoreDecision_{{$DecisionTypeData["id"]}}">
                                                                                    <ul class="Dropdown__Content">
                                                                                        <li>
                                                                                            <a href="{{route("system.type_decisions.edit" , $DecisionTypeData["id"])}}"
                                                                                               class="Dropdown__Item">
                                                                                                تعديل النوع
                                                                                            </a>
                                                                                        </li>
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
    @if($IsHavePermissionDecisionTypeRead)
        @include("System.Components.searchForm" , [
            'InfoForm' => ["Route" => "" , "Method" => "get"] ,
            'FilterForm' => [ ['Type' => 'text' , 'Info' =>
                    ['Name' => "filter[name]" , 'Placeholder' => "اسم النوع"] ] ,
                ]
        ])
    @endif
@endsection
