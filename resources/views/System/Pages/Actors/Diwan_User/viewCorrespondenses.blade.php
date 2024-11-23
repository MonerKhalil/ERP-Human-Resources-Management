@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--ViewUsers">
        <div class="ViewUsers">
            <div class="ViewUsers__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __("viewcorrespondences") ,
                    'paths' => [['Home' , '#'] , ['Page']] ,
                    'summery' => __("titleViewCorrespondences")
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
                                    <form name="PrintAllTablePDF" action="correspondences/export/pdf"
                                          class="FilterForm"
                                          method="post">
                                        @csrf
                                    </form>
                                    <form name="PrintAllTableXlsx" action="correspondences/export/xls"
                                          class="FilterForm"
                                          method="post">
                                        @csrf
                                    </form>
                                    <form action="#" method="post">
                                        @csrf
                                        <div class="Card__InnerGroup">
                                            <div class="Card__Inner py1">
                                                <div class="Table__Head">
                                                    <div class="Card__ToolsGroup">
                                                        <div class="Card__Tools Table__BulkTools">
                                                        @include("System.Components.bulkAction" , [
                                                            "Options" => [ [
                                                                    "Label" => __("printRowsAsPDF") , "Action" => route("correspondences.export.pdf") , "Method" => "post"
                                                                ] ,[
                                                                    "Label" => __("printRowsAsExcel") , "Action" => route("correspondences.export.xls") , "Method" => "post"
                                                                ] , [
                                                                "Label" => __("normalDelete")
                                                                , "Action" => route("correspondences.multi.delete")
                                                                , "Method" => "delete"
                                                            ] ]
                                                        ])
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
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
{{--                                            @php--}}
{{--                                            dd($correspondences);--}}
{{--                                            @endphp--}}
                                            @if(count($correspondences) > 0)
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
                                                                <div class="Item__Col"><span>@lang("type")</span></div>
                                                                <div class="Item__Col"><span>@lang("externalNumber")</span></div>
                                                                <div class="Item__Col"><span>@lang("internalNumber")</span></div>
                                                                <div class="Item__Col"><span>@lang("correspondenceDate")</span></div>
                                                            </div>
                                                            @foreach($correspondences as $correspondence)
                                                                <div class="Item DataItem">
                                                                    <div class="Item__Col Item__Col--Check">
                                                                        <input id="ItemRow_{{$correspondence["id"]}}"
                                                                               class="CheckBoxItem" type="checkbox"
                                                                               name="ids[]" value="{{$correspondence["id"]}}" hidden>
                                                                        <label for="ItemRow_{{$correspondence["id"]}}" class="CheckBoxRow">
                                                                            <i class="material-icons ">
                                                                                check_small
                                                                            </i>
                                                                        </label>
                                                                    </div>
                                                                    <div class="Item__Col">{{$correspondence["id"]}}</div>
                                                                    <div class="Item__Col">{{$correspondence["type"]}}</div>
                                                                    <div class="Item__Col">{{$correspondence["number_external"]}}</div>
                                                                    <div class="Item__Col">{{$correspondence["number_internal"]}}</div>
                                                                    <div class="Item__Col">{{$correspondence["date"]}}</div>
                                                                    <div class="Item__Col MoreDropdown">
                                                                        <i class="material-icons Popper--MoreMenuTable MenuPopper IconClick More__Button"
                                                                           data-MenuName="RoleMore_{{$correspondence["id"]}}">
                                                                            more_horiz
                                                                        </i>
                                                                        <div class="Popper--MoreMenuTable MenuTarget Dropdown"
                                                                             data-MenuName="RoleMore_{{$correspondence["id"]}}">
                                                                            <ul class="Dropdown__Content">
                                                                                <li>
                                                                                    <a href="{{route("correspondences.show" , $correspondence["id"])}}"
                                                                                       class="Dropdown__Item">
                                                                                        @lang("viewDetails")
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="{{route("correspondences.edit" , $correspondence["id"])}}"
                                                                                       class="Dropdown__Item">
                                                                                        @lang("editCorrespondenceInfo")
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="{{route("transaction.correspondences_dest.add", $correspondence["id"])}}"
                                                                                       class="Dropdown__Item">
                                                                                        @lang("addTransaction")
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
                                                        "PaginationData" => $correspondences ,
                                                        "PartsViewNum" => 5
                                                    ])
                                                    @include("System.Components.paginationSelect" , [
                                                        "PaginationData" => $correspondences
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

@section("PopupPage")
    @include("System.Components.searchForm" , [
        'InfoForm' => ["Route" => "" , "Method" => "get"] ,
        'FilterForm' => [ ['Type' => 'number' , 'Info' =>
                ['Name' => "filter[id]" , 'Placeholder' => __("numberInternal") ] ]
                 , ['Type' => 'dateRange' , 'Info' =>
                ['Name' => "filter[correspondence_date]" , 'Placeholder' => __("correspondenceDate") ,
                 "StartDateName" => "filter[start_date]" , "EndDateName" => "filter[end_date]"]
            ] ]
    ])
@endsection
