@extends("System.Pages.globalPage")

{{--@php--}}
{{--dd($data)--}}
{{--@endphp--}}

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--AddContractPage">
        <div class="AddContractPage">
            <div class="AddContractPage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __('RegisterEmployeeContract') ,
                    'paths' => [['Contracts' , '#'] , ['New Contract']] ,
                    'summery' => __('RegisterContractsPage')
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
                                            <form class="Form Form--Dark" action="{{route("system.employees.contract.store")}}" method="post">
                                                @csrf
                                                <div class="Row GapC-1-5">
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Select">
                                                                <div class="Select__Area">
                                                                    @php
                                                                        $EmployeesList = [] ;
                                                                        foreach ($employees_names as $id=>$name) {
                                                                            array_push($EmployeesList , [
                                                                                "Label" => $name
                                                                                , "Value" => $id ]) ;
                                                                        }
                                                                    @endphp
                                                                    @include("System.Components.selector" , ['Name' => "employee_id" , "Required" => "true" , "Label" => __('employeeName'),"DefaultValue" => "",
                                                                                "Options" => $EmployeesList,])
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
                                                                        foreach ($contract_type as $index=>$type) {
                                                                            array_push($CotnractTypes , [
                                                                                "Label" => $type
                                                                                , "Value" => $type]);
                                                                        }
                                                                    @endphp
                                                                    @include("System.Components.selector" , ['Name' => "contract_type" , "Required" => "true" , "Label" => __('contractType'),"DefaultValue" => "",
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
                                                                           placeholder="@lang("contractNumber")" required>
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
                                                                           placeholder="@lang("baseSalary")" required>
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
                                                                           TargetDateStartName="ContractDate"
                                                                           type="text"
                                                                           name="contract_date"
                                                                           placeholder="@lang("dateOfContract")" required>
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
                                                                           type="text"
                                                                           data-StartDateName="ContractDate"
                                                                           name="contract_finish_date"
                                                                           placeholder="@lang("dateOfExpiration")" required>
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
                                                                           class="DateEndFromStart Date__Field"
                                                                           data-StartDateName="ContractDate"
                                                                           type="text"
                                                                           name="contract_direct_date"
                                                                           placeholder="@lang("dateOfStart")" required>
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
                                                                    @include("System.Components.selector" , ['Name' => "section_id" , "Required" => "true" , "Label" => __('DepartmentName'),"DefaultValue" => "",
                                                                                "OptionsValues" => $sections,])
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
{{--                                                    <div class="Col-4-md Col-6-sm">--}}
{{--                                                        <div class="Form__Group">--}}
{{--                                                            <div class="Form__Select">--}}
{{--                                                                <div class="Select__Area">--}}
{{--                                                                    @include("System.Components.selector" , ['Name' => "managerName" , "Required" => "true" , "Label" => __('managerName'),"DefaultValue" => "",--}}
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
