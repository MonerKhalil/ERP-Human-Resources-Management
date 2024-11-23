@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--SessionDetailsPage">
        <div class="SessionDetailsPage">
            <div class="SessionDetailsPage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __("Payroll") ,
                    'paths' => [[__("home") , '#'] , [__("Payroll")]] ,
                    'summery' => __("TitlePayroll")
                ])
            </div>
            <div class="SessionDetailsPage__Content">
                <div class="Container--MainContent">
                    <div class="MessageProcessContainer">
                        @include("System.Components.messageProcess")
                    </div>
                    <div class="Row">
                        <div class="Col">
                            <div class="Card">
                                <div class="Card__Inner">
                                    <form class="Form"
                                          action="{{ route("system.payroll.salary.employee" , $employee->id) }}"
                                          method="get">
                                        <div class="Row GapC-1">
                                            <div class="Col-6-md">
                                                <div class="Form__Group">
                                                    <div class="Form__Input">
                                                        <div class="Input__Area">
                                                            <input id="FilterByYear" class="Input__Field"
                                                                   type="number" name="year" value="{{$year}}"
                                                                   min="1960" max="2023"
                                                                   placeholder="حسب السنة">
                                                            <label class="Input__Label" for="FilterByYear">
                                                                حسب السنة
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="Col-6-md">
                                                <div class="Form__Group">
                                                    <div class="Form__Input">
                                                        <div class="Input__Area">
                                                            <input id="FilterByMonth" class="Input__Field"
                                                                   type="number" name="month" value="{{$month}}"
                                                                   min="1" max="12"
                                                                   placeholder="حسب الشهر">
                                                            <label class="Input__Label" for="FilterByMonth">
                                                                حسب الشهر
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="Col-12">
                                                <div class="Form__Group">
                                                    <div class="Form__Button">
                                                        <button class="Next Button Send" type="submit">
                                                            فلترة
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @if(!is_null($data))
                            <div class="Col">
                                <div class="Card">
                                    <div class="Card__Inner">
                                        <div class="ListData NotResponsive">
                                            <div class="ListData__Head">
                                                <h4 class="ListData__Title">
                                                    @lang("basics")
                                                </h4>
                                            </div>
                                            <div class="ListData__Content">
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("employeeName")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{$data->employee->name??""}}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("total_salary")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->total_salary }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("default_salary")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->default_salary }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("overtime_minute")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->overtime_minute }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("overtime_value")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->overtime_value }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("bonuses_decision")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->bonuses_decision }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("penalties_decision")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->bonuses_decision }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("absence_days")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->absence_days }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("absence_days_value")")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->absence_days_value }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("count_leaves_unpaid")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->count_leaves_unpaid }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("leaves_unpaid_value")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->leaves_unpaid_value }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("count_leaves_effect_salary")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->leaves_effect_salary }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("leaves_effect_salary_value")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->leaves_effect_salary_value}}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("position_employee_value")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->position_employee_value }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("conferences_employee_value")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->conferences_employee_value }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("education_value")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->education_value }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("minutes_late_entry")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->minutes_late_entry }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("minutes_late_entry_value")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->minutes_late_entry_value }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("minutes_early_exit")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->minutes_early_exit }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("minutes_early_exit_value")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->minutes_early_exit_value }}
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                <span class="Data_Label">
                                                    @lang("created_at")
                                                </span>
                                                        <span class="Data_Value">
                                                    {{ $data->created_at }}
                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ListData NotResponsive">
                                            <div class="ListData__Head">
                                                <h4 class="ListData__Title">
                                                    العمليات على الرواتب
                                                </h4>
                                            </div>
                                            <div class="ListData__Content">
                                                <div class="Card__Inner px0">
                                                    <form
                                                          style="display: inline-block"
                                                          method="post"
                                                          action="{{ route("system.payroll.export.pdf") }}">
                                                        @csrf
                                                        @foreach(FilterDataRequest() as $Index=>$FilterItem)
                                                            @if(!is_null($FilterItem))
                                                                <input type="hidden" name="{{ $Index }}" value="{{ $FilterItem }}">
                                                            @endif
                                                        @endforeach
                                                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                                        <button type="submit" class="Button Button--Primary">
                                                            طباعة كـ PDF
                                                        </button>
                                                    </form>
                                                    <form
                                                          style="display: inline-block"
                                                          method="post"
                                                          action="{{ route("system.payroll.export.xls") }}">
                                                        @csrf
                                                        @foreach(FilterDataRequest() as $Index=>$FilterItem)
                                                            @if(!is_null($FilterItem))
                                                                <input type="hidden" name="{{ $Index }}" value="{{ $FilterItem }}">
                                                            @endif
                                                        @endforeach
                                                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                                        <button type="submit" class="Button Button--Primary">
                                                            طباعة كاكسل
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="Col">
                                <div class="Card">
                                    <div class="Card__Inner">
                                        @include("System.Components.noData")
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
