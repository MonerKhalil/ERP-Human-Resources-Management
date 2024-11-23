@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--AddCoursePage">
        <div class="AddCoursePage">
            <div class="AddCoursePage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => "تعديل معلومات الدورة" ,
                    'paths' => [['Courses' , '#'] , ['New Course']] ,
                    'summery' => "صفحة تعديل معلومات الدورة"
                ])
            </div>
        </div>
        <div class="AddCoursePagePrim__Content">
            <div class="Row">
                <div class="AddCoursePage__Form">
                    <div class="Container--MainContent">
                        <div class="MessageProcessContainer">
                            @include("System.Components.messageProcess")
                        </div>
                        <div class="Row">
                            <div class="CoursePage__Information">
                                <div class="Card">
                                    <div class="Card__Content">
                                        <div class="Card__Inner">
                                            <div class="Card__Header">
                                                <div class="Card__Title">
                                                    <h3>@lang("CourseInfo")</h3>
                                                </div>
                                            </div>
                                            <form class="Form Form--Dark" action="{{route("system.conferences.update",$conference["id"])}}"
                                                  method="post">
                                                @csrf
                                                @method("put")
                                                <div class="Row GapC-1-5">
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Select">
                                                                <div class="Select__Area">
                                                                    @php
                                                                        $EmployeesList = [] ;
                                                                                        //IsChecked
                                                                                        foreach ($employees as $Employees) {
                                                                                            $IsSelected = false ;
                                                                                            foreach($conference->employees as $EmployeeConference)
                                                                                                if($EmployeeConference["id"] === $Employees["id"]) {
                                                                                                    $IsSelected = true ;
                                                                                                }
                                                                                            if($IsSelected)
                                                                                                array_push($EmployeesList , [
                                                                                                    "Label" => $Employees["first_name"]." ".$Employees["last_name"]
                                                                                                    , "Value" => $Employees["id"],
                                                                                                     "IsChecked" => "true" ,
                                                                                                     "Name" => "employees[]"]);
                                                                                            else
                                                                                                 array_push($EmployeesList , [
                                                                                                    "Label" => $Employees["first_name"]." ".$Employees["last_name"]
                                                                                                    , "Value" => $Employees["id"],
                                                                                                     "Name" => "employees[]"]);
                                                                                        }
                                                                    @endphp
                                                                    @include("System.Components.multiSelector" , [
                                                                                        'Name' => "_" , "Required" => "true" ,
                                                                                        "DefaultValue" => "" , "Label" => "اسم الموظف" ,
                                                                                        "Options" => $EmployeesList ,
                                                                                        "NameIDs" => "name"
                                                                                    ])
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Select">
                                                                <div class="Select__Area">
                                                                    @php
                                                                        $courses_type = [] ;
                                                                        foreach ($types as $index=>$type) {
                                                                        array_push($courses_type , [
                                                                        "Label" => $type
                                                                        , "Value" => $type]);
                                                                        }
                                                                    @endphp
                                                                    @include("System.Components.selector" , ['Name' => "type" , "Required" => "true" , "Label" => __('type'),"DefaultValue" =>
                                                                        isset($conference)? $conference["type"] : "",
                                                                                "Options" => $courses_type,])
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Input">
                                                                <div class="Input__Area">
                                                                    <input id="courseName"
                                                                           class="Input__Field"
                                                                           type="text"
                                                                           name="name"
                                                                           value="{{isset($conference) ? $conference["name"] : ""}}"
                                                                           placeholder="@lang("courseName")">
                                                                    <label class="Input__Label"
                                                                           for="courseName">@lang("courseName")</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Date">
                                                                <div class="Date__Area">
                                                                    <input id="courseStartDate"
                                                                           class="Date__Field"
                                                                           type="text"
                                                                           name="start_date"
                                                                           value="{{isset($conference) ? $conference["start_date"] : ""}}"
                                                                           placeholder="@lang("courseStartDate")">
                                                                    <label class="Date__Label"
                                                                           for="courseStartDate">@lang("courseStartDate")</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Date">
                                                                <div class="Date__Area">
                                                                    <input id="courseEndDate"
                                                                           class="Date__Field"
                                                                           type="text"
                                                                           name="end_date"
                                                                           value="{{isset($conference) ? $conference["end_date"] : ""}}"
                                                                           placeholder="@lang("courseEndDate")">
                                                                    <label class="Date__Label"
                                                                           for="courseEndDate">@lang("courseEndDate")</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="State"
                                                         data-StateDefault="{{ isset($conference->address->country["id"]) ? $conference->address->country["id"] : "" }}"
                                                         data-CityDefault="{{ isset($conference->address["name"]) ? $conference->address["id"] : "" }}"
                                                         data-CityURL="{{route("get.address")}}"
                                                         class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Select">
                                                                <div class="Select__Area">
                                                                    @php
                                                                        $Countries = [] ;
                                                                        foreach ($countries as $Index => $Item) {
                                                                            array_push($Countries , [
                                                                                "Label" => $Item
                                                                                , "Value" => $Index ]) ;
                                                                        }
                                                                    @endphp
                                                                    @include("System.Components.selector" , [
                                                                                'Name' => "country_name" , "Required" => "true"
                                                                                , "Label" => __('countryName') ,"DefaultValue" => $conference->address->country["id"]
                                                                                , "Options" => $Countries
                                                                            ])
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="City" class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Select">
                                                                <div class="Select__Area">
                                                                    @include("System.Components.selector" , ['Name' => "address_id" , "Required" => "true" ,
                                                                    "Label" => __('cityName'),"DefaultValue" => $conference->address["id"],
                                                                                "OptionsValues" => [__("Damascus"), __("Aleppo"), __('Amman')],])
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Input">
                                                                <div class="Input__Area">
                                                                    <input id="heldPlace"
                                                                           class="Input__Field"
                                                                           type="text"
                                                                           name="address_details"
                                                                           value="{{isset($conference) ? $conference["address_details"] : ""}}"
                                                                           placeholder="@lang("heldPlace")">
                                                                    <label class="Input__Label"
                                                                           for="heldPlace">@lang("heldPlace")</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Input">
                                                                <div class="Input__Area">
                                                                    <input id="courseSalaryImpact"
                                                                           class="Input__Field"
                                                                           type="number"
                                                                           name="rate_effect_salary"
                                                                           value="{{isset($conference) ? $conference["rate_effect_salary"] : ""}}"
                                                                           placeholder="@lang("salaryImpact")">
                                                                    <label class="Input__Label"
                                                                           for="courseSalaryImpact">@lang("salaryImpact")</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Input">
                                                                <div class="Input__Area">
                                                                    <input id="courseProvider"
                                                                           class="Input__Field"
                                                                           type="text"
                                                                           name="name_party"
                                                                           value="{{isset($conference) ? $conference["name_party"] : ""}}"
                                                                           placeholder="@lang("courseProvider")">
                                                                    <label class="Input__Label"
                                                                           for="courseProvider">@lang("courseProvider")</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-12-xs">
                                                        <div class="Form__Group">
                                                            <div class="Form__Button">
                                                                <button class="Button Send"
                                                                        type="submit">@lang("saveCourse")</button>
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
        </div>
    </section>
@endsection
