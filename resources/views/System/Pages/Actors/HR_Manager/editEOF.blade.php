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
                                            <form class="Form Form--Dark" action="{{route("system.data_end_services.update", $dataEndService["id"])}}" method="post">
                                                @csrf
                                                @method("put")
                                                <div class="Row GapC-1-5">
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Select">
                                                                <div class="Select__Area">
                                                                    @php
                                                                        $EmployeesList = [] ;
                                                                                        foreach ($employee as $Employe) {
                                                                                            array_push($EmployeesList , [
                                                                                                "Label" => $Employe["first_name"].$Employe["last_name"]
                                                                                                , "Value" => $Employe["id"] ]) ;
                                                                                        }
                                                                    @endphp
                                                                    @include("System.Components.selector" , ['Name' => "employee_id" , "Required" => "true" , "Label" => __('employeeName'),"DefaultValue" =>
                                                                        isset($dataEndService)? $dataEndService["employee_id"] : "",
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
                                                                        $default_value = "";
                                                                                        foreach ($reason as $index=>$reason1) {
                                                                                            if($reason1 == $dataEndService["reason"]){
                                                                                $default_value = $index;
                                                                            }
                                                                                            array_push($reasons , [
                                                                                                "Label" => $reason1
                                                                                                , "Value" => $index ]) ;
                                                                                        }
                                                                    @endphp
                                                                    @include("System.Components.selector" , ['Name' => "reason" , "Required" => "true" , "Label" => __('EOSReason'),"DefaultValue" =>
                                                                             isset($dataEndService)? $default_value : "",
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
                                                                           @if(isset($dataEndService))
                                                                           value="{{$dataEndService["start_break_date"]}}"
                                                                           @endif
                                                                           placeholder="@lang("EOSStartDate")">
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
                                                                           @if(isset($dataEndService))
                                                                           value="{{$dataEndService["end_break_date"]}}"
                                                                           @endif
                                                                           name="end_break_date"
                                                                           placeholder="@lang("EOSEndDate")">
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
                                                                    @include("System.Components.selector" , ['Name' => "decision_id" , "Required" => "true" , "Label" => __('decisionNumber'),
                                                                     "DefaultValue" => $dataEndService["decision_id"],
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
{{--                                                                           @if(isset($dataEndService))--}}
{{--                                                                           value="{{$dataEndService["decision_id"]}}"--}}
{{--                                                                           @endif--}}
{{--                                                                           name="decision_id"--}}
{{--                                                                           placeholder="@lang("decisionNumber")">--}}
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
