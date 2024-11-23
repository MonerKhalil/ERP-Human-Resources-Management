<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionSessionInRead = $MyAccount->can("read_sections") || $MyAccount->can("all_sections") ;
    $IsHavePermissionSessionInEdit = $MyAccount->can("update_sections") || $MyAccount->can("all_sections") ;
    $IsHavePermissionSessionInDelete = $MyAccount->can("delete_sections") || $MyAccount->can("all_sections") ;
    $IsHavePermissionSessionInExport = $MyAccount->can("export_sections") || $MyAccount->can("all_sections") ;
    $IsHavePermissionSessionInCreate = $MyAccount->can("create_sections") || $MyAccount->can("all_sections") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    @if($IsHavePermissionSessionInRead)
        <section class="MainContent__Section MainContent__Section--ViewSectionPage">
            <div class="ViewSectionPage">
                <div class="ViewSectionPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __("viewAllSection") ,
                        'paths' => [[__("home") , '#'] , [__("viewAllSection")]] ,
                        'summery' => __("titleViewAllSection")
                    ])
                </div>
                <div class="ViewSectionPage__Content">
                    <div class="Container--MainContent">
                        <div class="MessageProcessContainer">
                            @include("System.Components.messageProcess")
                        </div>
                        <div class="Row">
                            <div class="Col">
                                <div class="Card ViewSectionPage__TableUsers">
                                    <div class="Table">
                                        @if($IsHavePermissionSessionInExport)
                                            <form name="PrintAllTablePDF"
                                                  action="{{route("system.sections.export.pdf")}}"
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
                                                  action="{{route("system.sections.export.xls")}}"
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
                                                                    if($IsHavePermissionSessionInExport) {
                                                                        array_push($AllOptions , [
                                                                            "Label" => __("printRowsAsPDF")
                                                                            , "Action" => route("system.sections.export.pdf")
                                                                            , "Method" => "post"
                                                                        ]);
                                                                        array_push($AllOptions , [
                                                                            "Label" => __("printRowsAsExcel")
                                                                            , "Action" => route("system.sections.export.xls")
                                                                            , "Method" => "post"
                                                                        ]);
                                                                    }
                                                                    if($IsHavePermissionSessionInDelete)
                                                                        array_push($AllOptions , [
                                                                            "Label" => __("normalDelete")
                                                                            , "Action" => route("system.sections.multi.delete")
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
                                                                    @if($IsHavePermissionSessionInExport)
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
                                                                    <th class="Item__Col">@lang("sectionName")</th>
                                                                    <th class="Item__Col">@lang("managerSection")</th>
                                                                    <th class="Item__Col">@lang("locationSection")</th>
                                                                    <th class="Item__Col">@lang("createSectionDate")</th>
                                                                    <th class="Item__Col">@lang("more")</th>
                                                                </tr>
                                                                @foreach($data as $Index=>$Section)
                                                                    <tr class="Item DataItem">
                                                                        <td class="Item__Col Item__Col--Check">
                                                                            <input id="MoreRequestVacations_{{$Section["id"]}}"
                                                                                   class="CheckBoxItem" type="checkbox"
                                                                                   name="ids[]" value="{{$Section["id"]}}" hidden>
                                                                            <label for="MoreRequestVacations_{{$Section["id"]}}"
                                                                                   class="CheckBoxRow">
                                                                                <i class="material-icons">
                                                                                    check_small
                                                                                </i>
                                                                            </label>
                                                                        </td>
                                                                        <td class="Item__Col">{{$Section["id"]}}</td>
                                                                        <td class="Item__Col">{{$Section["name"]}}</td>
                                                                        <td class="Item__Col">
                                                                            {{$Section->moderator["first_name"].$Section->moderator["last_name"]}}
                                                                        </td>
                                                                        <td class="Item__Col">{{$Section->address["name"]}}</td>
                                                                        <td class="Item__Col">{{$Section["created_at"]}}</td>
                                                                        <td class="Item__Col MoreDropdown">
                                                                            <i class="material-icons Popper--MoreMenuTable MenuPopper IconClick More__Button"
                                                                               data-MenuName="AllVacationsView_{{$Section["id"]}}">
                                                                                more_horiz
                                                                            </i>
                                                                            <div class="Popper--MoreMenuTable MenuTarget Dropdown"
                                                                                 data-MenuName="AllVacationsView_{{$Section["id"]}}">
                                                                                <ul class="Dropdown__Content">
                                                                                    <li>
                                                                                        <a href="{{route("system.sections.show" , $Section["id"])}}"
                                                                                           class="Dropdown__Item">
                                                                                            @lang("viewDetails")
                                                                                        </a>
                                                                                    </li>
                                                                                    @if($IsHavePermissionSessionInEdit)
                                                                                        <li>
                                                                                            <a href="{{route("system.sections.edit" , $Section["id"])}}"
                                                                                               class="Dropdown__Item">
                                                                                                @lang("editTheSectionInfo")
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
    @if($IsHavePermissionSessionInRead)
        @php
            $Employees = [] ;
            foreach ($employees as $Employee) {
                array_push($Employees , [ "Label" => $Employee["first_name"]." ".$Employee["last_name"]
                    , "Value" => $Employee["id"] ]) ;
            }
        @endphp
        @php
            $Countries = [] ;
            foreach ($countries as $Index=>$Country) {
                array_push($Countries , [ "Label" => $Country
                    , "Value" => $Index ]) ;
            }
        @endphp
        @include("System.Components.searchForm" , [
           'InfoForm' => ["Route" => "" , "Method" => "get"] ,
           'FilterForm' => [

               ['Type' => 'text' , 'Info' =>
                   ['Name' => "filter[name]" , 'Placeholder' => __("sectionName")] ] ,

               ['Type' => 'select' , 'Info' =>
                   ['Name' => "filter[moderator_id]" , 'Placeholder' => __("managerSection") ,
                   "Options" => $Employees] ] ,

               ['Type' => 'select' , 'Info' =>
                   ['Name' => "filter[address_id]" , 'Placeholder' => __("locationSection") ,
                   "Options" => $Countries] ] ,
           ]
       ])
    @endif
@endsection
