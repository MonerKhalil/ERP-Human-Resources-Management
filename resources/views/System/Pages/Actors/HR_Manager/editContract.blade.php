@extends("System.Pages.globalPage")

{{--@php--}}
{{--dd($data)--}}
{{--@endphp--}}

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--AddContractPage">
        <div class="AddContractPage">
            <div class="AddContractPage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __('editEmployeeContract') ,
                    'paths' => [['Contracts' , '#'] , ['New Contract']] ,
                    'summery' => __('editContractsPage')
                ])
            </div>
        </div>
        <div class="AddContractPagePrim__Content">
            <div class="Row">
                <div class="AddContractPage__Form">
                    <div class="Container--MainContent">
                        <div class="MessageProcessContainer">
                            @include("System.Components.messageProcess")
                        </div>
                        <div class="Row">
                            <div class="ContractPage__Information">
                                <div class="Card">
                                    <div class="Card__Content">
                                        <div class="Card__Inner">
                                            <div class="Card__Header">
                                                <div class="Card__Title">
                                                    <h3>@lang("contractInfo")</h3>
                                                </div>
                                            </div>
                                            <form class="Form Form--Dark" action="{{route("system.employees.contract.update",$data["contract"]["id"])}}" method="post">
                                                @csrf
                                                <div class="Row GapC-1-5">
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Select">
                                                                <div class="Select__Area">
                                                                    @include("System.Components.selector" , ['Name' => "employee_id" , "Required" => "true" , "Label" => __('employeeName'),
                                                                        "DefaultValue" => isset($data["contract"])? $data["contract"]["employee_id"] : "",
                                                                                "OptionsValues" => $data['employees_names'],])
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Select">
                                                                <div class="Select__Area">
                                                                    @php
                                                                        $CotnractTypes = [] ;
                                                                        $default_value = "";
                                                                        foreach ($data['contract_type'] as $index=>$type) {
                                                                            if($type == $data['contract']['contract_type']){
                                                                                $default_value = $type;
                                                                            }
                                                                            array_push($CotnractTypes , [
                                                                                "Label" => $type
                                                                                , "Value" => $type ]) ;
                                                                        }
                                                                    @endphp
                                                                    @include("System.Components.selector" , ['Name' => "contract_type" , "Required" => "true" , "Label" => __('contractType') ,
                                                                        "DefaultValue" =>isset($data["contract"])? $default_value : "",
                                                                                "Options" => $CotnractTypes])
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Input">
                                                                <div class="Input__Area">
                                                                    <input id="contract_number"
                                                                           class="Input__Field"
                                                                           type="number"
                                                                           name="contract_number"
                                                                           @if(isset($data))
                                                                           value="{{$data["contract"]["contract_number"]}}"
                                                                           @endif
                                                                           placeholder="@lang("contractNumber")">
                                                                    <label class="Input__Label"
                                                                           for="contract_number">@lang("contractNumber")</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Input">
                                                                <div class="Input__Area">
                                                                    <input id="salary"
                                                                           class="Input__Field"
                                                                           type="number"
                                                                           name="salary"
                                                                           @if(isset($data))
                                                                           value="{{$data["contract"]["salary"]}}"
                                                                           @endif
                                                                           placeholder="@lang("baseSalary")">
                                                                    <label class="Input__Label"
                                                                           for="salary">@lang("baseSalary")</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Date">
                                                                <div class="Date__Area">
                                                                    <input id="contract_date"
                                                                           class="Date__Field"
                                                                           type="text"
                                                                           TargetDateStartName="ContractDate"
                                                                           name="contract_date"
                                                                           @if(isset($data))
                                                                           value="{{$data["contract"]["contract_date"]}}"
                                                                           @endif
                                                                           placeholder="@lang("dateOfContract")">
                                                                    <label class="Date__Label"
                                                                           for="contract_date">@lang("dateOfContract")</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Date">
                                                                <div class="Date__Area">
                                                                    <input id="contract_finish_date"
                                                                           class="DateEndFromStart Date__Field"
                                                                           data-StartDateName="ContractDate"
                                                                           type="text"
                                                                           name="contract_finish_date"
                                                                           @if(isset($data))
                                                                           value="{{$data["contract"]["contract_finish_date"]}}"
                                                                           @endif
                                                                           placeholder="@lang("dateOfExpiration")">
                                                                    <label class="Date__Label"
                                                                           for="contract_finish_date">@lang("dateOfExpiration")</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Date">
                                                                <div class="Date__Area">
                                                                    <input id="contract_direct_date"
                                                                           class="Date__Field"
                                                                           type="text"
                                                                           TargetDateStartName="ContractDate"
                                                                           name="contract_direct_date"
                                                                           @if(isset($data))
                                                                           value="{{$data["contract"]["contract_direct_date"]}}"
                                                                           @endif
                                                                           placeholder="@lang("dateOfStart")">
                                                                    <label class="Date__Label"
                                                                           for="contract_direct_date">@lang("dateOfStart")</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Select">
                                                                <div class="Select__Area">
                                                                    @php
                                                                        $Sections = [] ;
                                                                        foreach ($data['sections'] as $Index => $Item) {
                                                                            array_push($Sections , [ "Label" => $Item ,
                                                                                 "Value" => $Index] ) ;
                                                                        }
                                                                    @endphp
                                                                    @include("System.Components.selector" , ['Name' => "section_id" , "Required" => "true" , "Label" => __('DepartmentName'),"DefaultValue" =>
                                                                        isset($data["contract"])? $data["contract"]['section_id'] : "",
                                                                                "Options" => $Sections,])
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
{{--                                                    <div class="Col-4-md Col-6-sm">--}}
{{--                                                        <div class="Form__Group">--}}
{{--                                                            <div class="Form__Select">--}}
{{--                                                                <div class="Select__Area">--}}
{{--                                                                    @php--}}
{{--                                                                    dd($data["contract"]);--}}
{{--                                                                    @endphp--}}
{{--                                                                    @include("System.Components.selector" , ['Name' => "managerName" , "Required" => "true" ,--}}
{{--                                                                             "Label" => __('managerName'),"DefaultValue" => "",--}}
{{--                                                                                "OptionsValues" => $employees_names,])--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
                                                    <div class="Col-12-xs">
                                                        <div class="Form__Group">
                                                            <div class="Form__Button">
                                                                <button class="Button Send"
                                                                        type="submit">@lang("saveContract")</button>
                                                            </div>
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
            </div>
        </div>
    </section>
@endsection
