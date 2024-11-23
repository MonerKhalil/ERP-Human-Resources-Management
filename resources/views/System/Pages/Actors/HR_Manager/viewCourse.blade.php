@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--AddCoursePage">
        <div class="AddCoursePage">
            <div class="AddCoursePage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __('ViewEmployeeCourse') ,
                    'paths' => [['Courses' , '#'] , ['Course']] ,
                    'summery' => __('ViewCoursesPage')
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
                                            <form class="Form Form--Dark">
                                                @csrf
                                                <div class="Row GapC-1-5">
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                <span
                                                                    class="Data_Label">@lang("employeeName")</span>
                                                                <span class="Data_Value">
                                                                    @foreach($conference->employees as $employee)
                                                                        {{$employee["first_name"]}} ,
                                                                    @endforeach
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("type")</span>
                                                                <span
                                                                    class="Data_Value">{{$conference->type}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("courseName")</span>
                                                                <span
                                                                    class="Data_Value">{{$conference->name}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("courseStartDate")</span>
                                                                <span
                                                                    class="Data_Value">{{$conference->start_date}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("courseEndDate")</span>
                                                                <span
                                                                    class="Data_Value">{{$conference->end_date}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
{{--                                                    @php--}}
{{--                                                    dd($conference);--}}
{{--                                                    @endphp--}}
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("countryName")</span>
                                                                <span
                                                                    class="Data_Value">{{isset($conference->address->country["country_name"]) ? $conference->address->country["country_name"] : ""}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("cityName")</span>
                                                                <span
                                                                    class="Data_Value">{{isset($conference->address) ? $conference->address->name : ""}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("heldPlace")</span>
                                                                <span
                                                                    class="Data_Value">{{$conference->address_details}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("salaryImpact")</span>
                                                                <span
                                                                    class="Data_Value">{{$conference->rate_effect_salary}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="ListData__Content">
                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("courseProvider")</span>
                                                                <span
                                                                    class="Data_Value">{{$conference->name_party}}</span>
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
