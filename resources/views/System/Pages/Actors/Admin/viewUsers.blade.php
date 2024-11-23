<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionRead = $MyAccount->can("read_users") || $MyAccount->can("all_users") ;
    $IsHavePermissionDelete = $MyAccount->can("delete_users") || $MyAccount->can("all_users") ;
?>


@extends("System.Pages.globalPage")

@section("ContentPage")
    @if($IsHavePermissionRead)
        <section class="MainContent__Section MainContent__Section--ViewUsers">
            <div class="ViewUsers">
                <div class="ViewUsers__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __("viewUsers") ,
                        'paths' => [[__("home") , '#'] , [__("viewUsers")]] ,
                        'summery' => __("titleViewUsers")
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
                                        <form name="PrintAllTablePDF"
                                              class="FilterForm"
                                              action="{{route("users.pdf")}}"
                                              method="post">
                                            @csrf
                                            @foreach(FilterDataRequest() as $Index=>$FilterItem)
                                                @if(!is_null($FilterItem))
                                                    <input type="hidden" name="filter[{{ $Index }}]" value="{{ $FilterItem }}"/>
                                                @endif
                                            @endforeach
                                        </form>
                                        <form name="PrintAllTableXlsx"
                                              action="{{route("users.xls")}}"
                                              method="post">
                                            @csrf
                                            @foreach(FilterDataRequest() as $Index=>$FilterItem)
                                                @if(!is_null($FilterItem))
                                                    <input type="hidden" name="filter[{{ $Index }}]" value="{{ $FilterItem }}"/>
                                                @endif
                                            @endforeach
                                        </form>
                                        <form action="#" method="post">
                                            @csrf
                                            <div class="Card__InnerGroup">
                                                <div class="Card__Inner py1">
                                                    <div class="Table__Head">
                                                        <div class="Card__ToolsGroup">
                                                            <div class="Card__Tools Table__BulkTools">
                                                                @if($IsHavePermissionDelete)
                                                                    @include("System.Components.bulkAction" , [
                                                                        "Options" => [ [
                                                                            "Label" => __("printRowsAsPDF")
                                                                            , "Action" => route("users.pdf")
                                                                            , "Method" => "post"
                                                                        ] , [
                                                                            "Label" => __("printRowsAsExcel")
                                                                            , "Action" => route("users.xls")
                                                                            , "Method" => "post"
                                                                        ] , [
                                                                            "Label" => __("normalDelete")
                                                                            , "Action" => route("users.multi.delete")
                                                                            , "Method" => "delete"
                                                                        ] ]
                                                                    ])
                                                                @else
                                                                    @include("System.Components.bulkAction" , [
                                                                        "Options" => [ [
                                                                            "Label" => __("printRowsAsPDF")
                                                                            , "Action" => route("users.pdf")
                                                                            , "Method" => "post"
                                                                        ] , [
                                                                            "Label" => __("printRowsAsExcel")
                                                                            , "Action" => route("users.xls")
                                                                            , "Method" => "post"
                                                                        ] ]
                                                                    ])
                                                                @endif
                                                            </div>
                                                            <div class="Card__Tools Card__SearchTools">
                                                                <ul class="SearchTools">
                                                                    <li title="Filter">
                                                                        <i class="OpenPopup material-icons IconClick SearchTools__FilterIcon"
                                                                           data-popUp="SearchAbout">filter_list
                                                                        </i>
                                                                    </li>
                                                                    <li>
                                                                        <span class="SearchTools__Separate"></span>
                                                                    </li>
                                                                    <li class="Table__PrintMenu">
                                                                        <i class="material-icons IconClick PrintMenu__Button"
                                                                           title="Print">print</i>
                                                                        <div class="Dropdown PrintMenu__Menu">
                                                                            <ul class="Dropdown__Content">
                                                                                <li class="Dropdown__Item">
                                                                                    <a class="AnchorSubmit"
                                                                                       data-form="PrintAllTablePDF">
                                                                                        @lang("printTablePDFFile")
                                                                                    </a>
                                                                                </li>
                                                                                <li class="Dropdown__Item">
                                                                                    <a class="AnchorSubmit"
                                                                                       data-form="PrintAllTableXlsx">
                                                                                        @lang("printTableXlsxFile")
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(count($users) > 0)
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
                                                                    <div class="Item__Col"><span>@lang("user")</span></div>
                                                                    <div class="Item__Col">@lang("id")</div>
                                                                    <div class="Item__Col"><span>@lang("email")</span></div>
                                                                    <div class="Item__Col"><span>@lang("createDate")</span></div>
                                                                    <div class="Item__Col"><span>@lang("more")</span></div>
                                                                </div>
                                                                @foreach($users as $User)
                                                                    <div class="Item DataItem">
                                                                        <div class="Item__Col Item__Col--Check">
                                                                            <input id="ItemRow_{{$User["id"]}}"
                                                                                   class="CheckBoxItem" type="checkbox"
                                                                                   name="users[]" value="{{$User["id"]}}" hidden>
                                                                            <label for="ItemRow_{{$User["id"]}}" class="CheckBoxRow">
                                                                                <i class="material-icons ">
                                                                                    check_small
                                                                                </i>
                                                                            </label>
                                                                        </div>
                                                                        <div class="Item__Col">{{$User["name"]}}</div>
                                                                        <div class="Item__Col">#{{$User["id"]}}</div>
                                                                        <div class="Item__Col">{{$User["email"]}}</div>
                                                                        <div class="Item__Col">{{$User["created_at"]}}</div>
                                                                        <div class="Item__Col MoreDropdown">
                                                                            <i class="material-icons Popper--MoreMenuTable MenuPopper IconClick More__Button"
                                                                               data-MenuName="UserMore_{{$User["id"]}}">
                                                                                more_horiz
                                                                            </i>
                                                                            <div class="Popper--MoreMenuTable MenuTarget Dropdown"
                                                                                 data-MenuName="UserMore_{{$User["id"]}}">
                                                                                <ul class="Dropdown__Content">
                                                                                    <li>
                                                                                        <a href="{{route("users.show" , $User["id"])}}"
                                                                                           class="Dropdown__Item">
                                                                                            @lang("viewDetails")
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
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
                                                            "PaginationData" => $users ,
                                                            "PartsViewNum" => 5
                                                        ])
                                                        @include("System.Components.paginationSelect" , [
                                                            "PaginationData" => $users
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
        'InfoForm' => ["Route" => route("users.index") , "Method" => "get"] ,
        'FilterForm' => [ ['Type' => 'text' , 'Info' =>
                ['Name' => "filter[name]" , 'Placeholder' => __("userName")]] , ['Type' => 'number' , 'Info' =>
                    ['Name' => "filter[id]" , 'Placeholder' => __("id")]
                ] , ['Type' => 'email' , 'Info' =>
                ['Name' => "filter[email]" , 'Placeholder' => __("email")]
            ] , ['Type' => 'dateRange' , 'Info' =>
                ['Placeholder' => __("createDate") ,
                 'StartDateName' => "filter[start_date]" , 'EndDateName' => "filter[end_date]"
                ]
            ] ]
    ])
        @include("System.Components.fileOptions")
    @endif
@endsection
