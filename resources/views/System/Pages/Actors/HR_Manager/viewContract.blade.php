@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--AddContractPage">
        <div class="AddContractPage">
            <div class="AddContractPage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __('showEmployeeContract') ,
                    'paths' => [['Contracts' , '#'] , ['New Contract']] ,
                    'summery' => __('showContractsPage')
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
                                            <form class="Form Form--Dark">
                                                <div class="Row GapC-1-5">
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("firstName")</span>
                                                                <span class="Data_Value">{{$contract->employee["first_name"]." ".$contract->employee["last_name"]}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("contractType")</span>
                                                                <span class="Data_Value">{{$contract->contract_type}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("contractNumber")</span>
                                                                <span class="Data_Value">{{$contract->contract_number}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("baseSalary")</span>
                                                                <span class="Data_Value">{{$contract->salary}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("dateOfContract")</span>
                                                                <span class="Data_Value">{{$contract->contract_date}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("dateOfExpiration")</span>
                                                                <span class="Data_Value">{{$contract->contract_finish_date}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("dateOfStart")</span>
                                                                <span class="Data_Value">{{$contract->contract_direct_date}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("DepartmentName")</span>
                                                                <span class="Data_Value">{{$contract->section->name}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
{{--                                                    <div class="Col-4-md Col-6-sm">--}}
{{--                                                        <div class="ListData__Content">--}}
{{--                                                            <div class="Data_Col">--}}
{{--                                                                            <span--}}
{{--                                                                                class="Data_Label">@lang("managerName")</span>--}}
{{--                                                                <span class="Data_Value">Anas</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
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
