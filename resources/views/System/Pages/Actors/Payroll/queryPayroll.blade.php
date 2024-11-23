@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--AddCoursePage">
        <div class="queryPayrollPage">
            <div class="queryPayrollPage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __('QueryPayroll') ,
                    'paths' => [['queries' , '#'] , ['New query']] ,
                    'summery' => __('QueryPayrollPage')
                ])
            </div>
        </div>
        <div class="AddCoursePagePrim__Content">
            <div class="Row">
                <div class="AddCoursePage__Form">
                    <div class="Container--MainContent">
                        <div class="Row">
                            <div class="CoursePage__Information">
                                <div class="Card">
                                    <div class="Card__Content">
                                        <div class="Card__Inner">
                                            <div class="Card__Header">
                                                <div class="Card__Title">
                                                    <h3>@lang("EmployeeInfo")</h3>
                                                </div>
                                            </div>
                                            <form class="Form Form--Dark">
                                                @csrf
                                                <div class="Row GapC-1-5">
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Date">
                                                                <div class="Date__Area">
                                                                    <input id="startDate"
                                                                           class="Date__Field"
                                                                           type="text"
                                                                           name="startDate"
                                                                           placeholder="@lang("courseEndDate")">
                                                                    <label class="Date__Label"
                                                                           for="startDate">@lang("courseEndDate")</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-4-md Col-6-sm">
                                                        <div class="Form__Group">
                                                            <div class="Form__Date">
                                                                <div class="Date__Area">
                                                                    <input id="endDate"
                                                                           class="Date__Field"
                                                                           type="text"
                                                                           name="endDate"
                                                                           placeholder="@lang("courseEndDate")">
                                                                    <label class="Date__Label"
                                                                           for="endDate">@lang("courseEndDate")</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="Col-12-xs">
                                                        <div class="Form__Group">
                                                            <div class="Form__Button">
                                                                <button class="Button Send"
                                                                        type="submit">@lang("queryPayroll")</button>
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
