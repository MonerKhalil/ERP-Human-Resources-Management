@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--ViewUsers">
        <div class="ViewUsers">
            <div class="ViewUsers__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __("viewContracts") ,
                    'paths' => [['Home' , '#'] , ['Page']] ,
                    'summery' => __("titleViewContracts")
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
                                    <form name="PrintAllTablePDF" action="employees.contract.export.pdf"
                                          class="FilterForm"
                                          method="post">
                                        @csrf
                                    </form>
                                    <form name="PrintAllTableXlsx" action="employees.contract.export.pdf"
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
                                                            @include("System.Components.bulkAction" ,[
                                                                "Options" => [ [
                                                                    "Label" => __("printRowsAsPDF") , "Action" => route("system.employees.contract.export.pdf") , "Method" => "post"
                                                                ] ,[
                                                                    "Label" => __("printRowsAsExcel") , "Action" => route("system.employees.contract.export.xls") , "Method" => "post"
                                                                ], [
                                                                    "Label" => __("normalDelete")
                                                                    , "Action" => route("system.employees.multi.delete")
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
                                            @if(count($contracts) > 0)
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
                                                                <div class="Item__Col"><span>@lang("employeeName")</span></div>
                                                                <div class="Item__Col"><span>@lang("contractType")</span></div>
                                                                <div class="Item__Col"><span>@lang("contractDate")</span></div>
                                                                <div class="Item__Col"><span>@lang("contractFinish")</span></div>
                                                            </div>
                                                            @foreach($contracts as $contract)
{{--                                                                @php--}}
{{--                                                                dd($contract);--}}
{{--                                                                @endphp--}}
                                                                <div class="Item DataItem">
                                                                    <div class="Item__Col Item__Col--Check">
                                                                        <input id="ItemRow_{{$contract["id"]}}"
                                                                               class="CheckBoxItem" type="checkbox"
                                                                               name="ids[]" value="{{$contract["id"]}}" hidden>
                                                                        <label for="ItemRow_{{$contract["id"]}}" class="CheckBoxRow">
                                                                            <i class="material-icons ">
                                                                                check_small
                                                                            </i>
                                                                        </label>
                                                                    </div>
                                                                    <div class="Item__Col">{{$contract["id"]}}</div>
                                                                    <div class="Item__Col">{{isset($contract->employee) ? $contract->employee["first_name"] : ""}}</div>
                                                                    <div class="Item__Col">{{$contract["contract_type"]}}</div>
                                                                    <div class="Item__Col">{{$contract["contract_date"]}}</div>
                                                                    <div class="Item__Col">{{$contract["contract_finish_date"]}}</div>
                                                                    <div class="Item__Col MoreDropdown">
                                                                        <i class="material-icons Popper--MoreMenuTable MenuPopper IconClick More__Button"
                                                                           data-MenuName="RoleMore_{{$contract["id"]}}">
                                                                            more_horiz
                                                                        </i>
                                                                        <div class="Popper--MoreMenuTable MenuTarget Dropdown"
                                                                             data-MenuName="RoleMore_{{$contract["id"]}}">
                                                                            <ul class="Dropdown__Content">
                                                                                <li>
                                                                                    <a href="{{route("system.employees.contract.show" , $contract["id"])}}"
                                                                                       class="Dropdown__Item">
                                                                                        @lang("viewDetails")
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="{{route("system.employees.contract.edit" , $contract["id"])}}"
                                                                                       class="Dropdown__Item">
                                                                                        @lang("editContractInfo")
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
                                                        "PaginationData" => $contracts ,
                                                        "PartsViewNum" => 5
                                                    ])
                                                    @include("System.Components.paginationSelect" , [
                                                        "PaginationData" => $contracts
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
                ['Name' => "filter[id]" , 'Placeholder' => __("contractNumber") ] ] , ['Type' => 'text' , 'Info' =>
                    ['Name' => "filter[contract_type]" , 'Placeholder' => __("contractType")]
                ]
             ]
    ])
@endsection
