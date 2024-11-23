@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--AddEOSPage">
        <div class="AddEOSPage">
            <div class="AddEOSPage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __('RegisterEmployeeEOS') ,
                    'paths' => [['employees End Of Service' , '#'] , ['EOS']] ,
                    'summery' => __('RegisterEOSPage')
                ])
            </div>
        </div>
        <div class="AddEOSPagePrim__Content">
            <div class="Row">
                <div class="AddEOSPage__Form">
                    <div class="Container--MainContent">
                        <div class="MessageProcessContainer">
                            @include("System.Components.messageProcess")
                        </div>
                        <div class="Row">
                            <div class="EOSPage__Information">
                                <div class="Card">
                                    <div class="Card__Content">
                                        <div class="Card__Inner">
                                            <div class="Card__Header">
                                                <div class="Card__Title">
                                                    <h3>@lang("EofInfo")</h3>
                                                </div>
                                            </div>
                                            <form class="Form Form--Dark" action="{{route("system.data_end_services.store")}}" method="post">
                                                @csrf
                                                <div class="Row GapC-1-5">
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Select">
                                                                <div class="Select__Area">
                                                                    @php
                                                                        $EmployeesList = [] ;
                                                                                        foreach ($employees as $Employee) {
                                                                                            array_push($EmployeesList , [
                                                                                                "Label" => $Employee["first_name"].$Employee["last_name"]
                                                                                                , "Value" => $Employee["id"] ]) ;
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
                                                                        $reasons = [] ;
                                                                                        foreach ($reason as $index=>$reason1) {
                                                                                            array_push($reasons , [
                                                                                                "Label" => $reason1
                                                                                                , "Value" => $index ]) ;
                                                                                        }
                                                                    @endphp
                                                                    @include("System.Components.selector" , ['Name' => "reason" , "Required" => "true" , "Label" => __('EOSReason'),"DefaultValue" => "",
                                                                                "Options" => $reasons,])
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Date">
                                                                <div class="Date__Area">
                                                                    <input id="EOSStartDate"
                                                                           class="Date__Field"
                                                                           type="text"
                                                                           name="start_break_date"
                                                                           placeholder="@lang("EOSStartDate")" required>
                                                                    <label class="Date__Label"
                                                                           for="EOSStartDate">@lang("EOSStartDate")</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Date">
                                                                <div class="Date__Area">
                                                                    <input id="EOSEndDate"
                                                                           class="Date__Field"
                                                                           type="text"
                                                                           name="end_break_date"
                                                                           placeholder="@lang("EOSEndDate")" required>
                                                                    <label class="Date__Label"
                                                                           for="EOSEndDate">@lang("EOSEndDate")</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Select">
                                                                <div class="Select__Area">
                                                                    @php
                                                                        $reasons = [] ;
                                                                                        foreach ($decision as $index=>$reason1) {
                                                                                            array_push($reasons , [
                                                                                                "Label" => $reason1
                                                                                                , "Value" => $index ]) ;
                                                                                        }
                                                                    @endphp
                                                                    @include("System.Components.selector" , ['Name' => "decision_id" , "Required" => "true" , "Label" => __('decisionNumber'),"DefaultValue" => "",
                                                                                "Options" => $reasons,])
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

{{--                                                    <div class="Col-4-md Col-6-sm">--}}
{{--                                                        <div class="Form__Group">--}}
{{--                                                            <div class="Form__Input">--}}
{{--                                                                <div class="Input__Area">--}}
{{--                                                                    <input id="decisionNumber"--}}
{{--                                                                           class="Input__Field"--}}
{{--                                                                           type="number"--}}
{{--                                                                           name="decision_id"--}}
{{--                                                                           placeholder="@lang("decisionNumber")" required>--}}
{{--                                                                    <label class="Input__Label"--}}
{{--                                                                           for="decisionNumber">@lang("decisionNumber")</label>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="Col-4-md Col-6-sm">--}}
{{--                                                        <div class="Form__Group">--}}
{{--                                                            <div class="Form__Date">--}}
{{--                                                                <div class="Date__Area">--}}
{{--                                                                    <input id="decisionDate"--}}
{{--                                                                           class="Date__Field"--}}
{{--                                                                           type="text"--}}
{{--                                                                           name="decisionDate"--}}
{{--                                                                           placeholder="@lang("decisionDate")">--}}
{{--                                                                    <label class="Date__Label"--}}
{{--                                                                           for="decisionDate">@lang("decisionDate")</label>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
                                                    <div class="Col-12-xs">
                                                        <div class="Form__Group">
                                                            <div class="Form__Button">
                                                                <button class="Button Send"
                                                                        type="submit">@lang("saveEOS")</button>
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
