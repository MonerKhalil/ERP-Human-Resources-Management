<!doctype html>
@if(app()->getLocale()==="en")
    <html lang="en" dir="ltr">
    @else
    <html lang="ar" dir="rtl">
    @endif
        <head>
            {{-- Meta System --}}
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no,initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="x-ua-compatible" content="ie=edge">
            <meta name="description" content="Welcome Welcome Welcome !!!">
            <meta name="keywords" content="Demo">
            <meta name="author" content="Amir">
            <meta name="csrf-token" content="{{@csrf_token()}}">
            <meta name="url" content="{{ url("") }}">
            {{-- Title Page System --}}
            <title>HR System</title>
            {{-- Logo System --}}
            <link rel="icon" href="{{asset('System/Assets/Images/Logo.png')}}">
            {{-- Icons System --}}
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
                  rel="stylesheet">
            {{-- Normalize System --}}
            <link rel="stylesheet" href='{{asset('System/Assets/CSS/Normalize.css')}}' type="text/css" />
            {{-- Libraries System --}}
            <link rel="stylesheet" href='{{asset('System/Assets/Lib/Libraries.css')}}' type="text/css" />
            {{-- Libraries Extra --}}
            {{-- Main CSS System --}}
            <link rel="stylesheet" href='{{asset('System/Assets/CSS/Style.css')}}' type="text/css" />
            {{-- CSS Extra--}}
        </head>
        <body class="Light">
        <main class="MainContent">
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
                                                  action=""
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
            <div class="Cookies Cookies--Dark">
                <div class="Cookies__Header">
                    <i class="material-icons Cookies__Icon">cookie</i>
                    <h3>Cookies Consent</h3>
                </div>
                <div class="Cookies__Content">
                    <p>
                        This website use cookies to help you have a superior and more relevant
                        browsing experience on the website. <a href="#" class="Cookies__ReadMore"> Read more...</a>
                    </p>
                </div>
                <div class="Cookies__Buttons">
                    <button class="Button Button--Primary Cookies__Accept">Accept</button>
                    <button class="Button Button--Primary Cookies__Decline">Decline</button>
                </div>
            </div>
        </main>
        <footer class="FooterPage">
            <div class="FooterPage__Wrap">
                <div class="Container--MainContent">
                    <div class="FooterPage__Content">
                        <div class="Row m0">
                            <div class="Col-6-xs">
                                <div class="FooterPage__CopyRight">
                                    @lang("copyright") © 2022
                                </div>
                            </div>
                            <div class="Col-6-xs">
                                <div class="FooterPage__Links">
                                    @lang("footerTitle")
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <script src="{{asset("System/Assets/Lib/Libraries.js")}}"></script>
        <script src="{{asset("System/Assets/Lib/@popperjs/core/dist/umd/popper.js")}}"></script>
        <script src="{{asset("System/Assets/JS/Main.js")}}"></script>
        <script>
            window.onload = function () {
                javascript:window.print();
            };
        </script>
        </body>

</html>
