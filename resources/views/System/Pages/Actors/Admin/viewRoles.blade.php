<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionRead = $MyAccount->can("read_roles") || $MyAccount->can("all_roles") ;
    $IsHavePermissionEdit = $MyAccount->can("update_roles") || $MyAccount->can("all_roles") ;
    $IsHavePermissionDelete = $MyAccount->can("delete_roles") || $MyAccount->can("all_roles") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    @if($IsHavePermissionRead)
        <section class="MainContent__Section MainContent__Section--ViewUsers">
            <div class="ViewUsers">
                <div class="ViewUsers__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __("viewRoles") ,
                        'paths' => [[__("home") , '#'] , [__("viewRoles")]] ,
                        'summery' => __("titleViewRoles")
                    ])
                </div>
                <div class="ViewUsers__Content">
                    <div class="Container--MainContent">
                        <div class="MessageProcessContainer">
                            @include("System.Components.messageProcess")
                        </div>
                        <div class="Row">
                            <div class="Col">
                                <div class="Card ViewUsers__TableUsers">
                                    <div class="Table">
                                        <form action="#" method="post">
                                            @csrf
                                            <div class="Card__InnerGroup">
                                                <div class="Card__Inner py1">
                                                    <div class="Table__Head">
                                                        <div class="Card__ToolsGroup">
                                                            @if($IsHavePermissionDelete)
                                                                <div class="Card__Tools Table__BulkTools">
                                                                    @include("System.Components.bulkAction" , [
                                                                        "Options" => [ [
                                                                            "Label" => __("normalDelete")
                                                                            , "Action" => route("roles.multi.delete")
                                                                            , "Method" => "delete"
                                                                        ] ]
                                                                    ])
                                                                </div>
                                                            @endif
                                                            <div class="Card__Tools Card__SearchTools">
                                                                <ul class="SearchTools">
                                                                    <li title="Filter">
                                                                        <i class="OpenPopup material-icons IconClick SearchTools__FilterIcon"
                                                                           data-popUp="SearchAbout">
                                                                            filter_list
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
                                                            <div class="Table__Table">
                                                                <div class="Item HeaderList">
                                                                    <div class="Item__Col Item__Col--Check">
                                                                        <input id="ItemRow_Main" class="CheckBoxItem"
                                                                               type="checkbox" hidden>
                                                                        <label for="ItemRow_Main" class="CheckBoxRow">
                                                                            <i class="material-icons ">
                                                                                check_small
                                                                            </i>
                                                                        </label>
                                                                    </div>
                                                                    <div class="Item__Col">#</div>
                                                                    <div class="Item__Col"><span>@lang("roleName")</span></div>
                                                                    <div class="Item__Col"><span>@lang("createDate")</span></div>
                                                                    <div class="Item__Col"><span>@lang("more")</span></div>
                                                                </div>
                                                                @foreach($data as $Role)
                                                                    <div class="Item DataItem">
                                                                        <div class="Item__Col Item__Col--Check">
                                                                            <input id="ItemRow_{{$Role["id"]}}"
                                                                                   class="CheckBoxItem" type="checkbox"
                                                                                   name="ids[]" value="{{$Role["id"]}}" hidden>
                                                                            <label for="ItemRow_{{$Role["id"]}}" class="CheckBoxRow">
                                                                                <i class="material-icons ">
                                                                                    check_small
                                                                                </i>
                                                                            </label>
                                                                        </div>
                                                                        <div class="Item__Col">{{$Role["id"]}}</div>
                                                                        <div class="Item__Col">{{$Role["name"]}}</div>
                                                                        <div class="Item__Col">{{$Role["created_at"]}}</div>
                                                                        <div class="Item__Col {{ $IsHavePermissionEdit ? "MoreDropdown" : "" }} ">
                                                                            @if($IsHavePermissionEdit)
                                                                                <i class="material-icons Popper--MoreMenuTable MenuPopper IconClick More__Button"
                                                                                   data-MenuName="RoleMore_{{$Role["id"]}}">
                                                                                    more_horiz
                                                                                </i>
                                                                                <div class="Popper--MoreMenuTable MenuTarget Dropdown"
                                                                                     data-MenuName="RoleMore_{{$Role["id"]}}">
                                                                                    <ul class="Dropdown__Content">
                                                                                        <li>
                                                                                            <a href="{{route("roles.edit" , $Role["id"])}}"
                                                                                               class="Dropdown__Item">
                                                                                                @lang("viewDetails")
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
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
    @if($IsHavePermissionRead)
        @include("System.Components.searchForm" , [
        'InfoForm' => ["Route" => "" , "Method" => "get"] ,
        'FilterForm' => [ ['Type' => 'text' , 'Info' =>
                ['Name' => "filter[name]" , 'Placeholder' => __("roleName")]] , ['Type' => 'number' , 'Info' =>
                    ['Name' => "filter[id]" , 'Placeholder' => __("id")]
                ] , ['Type' => 'dateRange' , 'Info' => ['Placeholder' => __("createDate") ,
                 'StartDateName' => "filter[start_date_filter]" , 'EndDateName' => "filter[end_date_filter]"
                ]
            ] ]
    ])
        @include("System.Components.fileOptions")
    @endif
@endsection
