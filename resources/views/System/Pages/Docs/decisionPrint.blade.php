<!doctype html>
@if(app()->getLocale()==="en")
<html lang="en" dir="ltr">
@else
<html lang="ar" dir="rtl">
@endif

    <head>
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
        {{-- Main CSS System --}}
        <link rel="stylesheet" href='{{asset('System/Assets/CSS/Style.css')}}' type="text/css" />
    </head>

    <body>
        <div id="Wrapper">
            {{--  Main Content  --}}
            <main class="MainContent">
                <section class="MainContent__Section MainContent__Section--Print">
                    <div class="PrintPage">
                        <div class="PrintPage__Content">
                            <div class="Container--MainContent">
                                <div class="Row">
                                    <div class="Col">
                                        <div class="Card">
                                            <div class="PrintPage__CompanyInfo">
                                                <div class="ImageCompany">
                                                    <img src="{{asset("System/Assets/Images/Logo.png")}}"
                                                         alt="Company Image" />
                                                </div>
                                                <div class="DescriptionCompany">
                                                    <div class="Text">
                                                        <div class="CompanyName">@lang("company") : ERP Epic</div>
                                                        <div class="Address">@lang("address") : @lang("damascus")</div>
                                                        <div class="Telephone">@lang("tel") : 123123123</div>
                                                        <div class="Email">@lang("email") : Amir@Amir.com</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Col">
                                        <div class="Card">
                                            <div class="Card__Inner">
                                                <div class="ListData NotResponsive ListData--CustomPrint">
                                                    <div class="ListData__Head">
                                                        <h4 class="ListData__Title">
                                                            @lang("basics")
                                                        </h4>
                                                    </div>
                                                    <div class="PrintPage__Data">
                                                        <div class="ListData__Item ListData__Item--NoAction">
                                                            <div class="Data_Col">
                                                            <span class="Data_Label">
                                                                @lang("decisionNumber")
                                                            </span>
                                                                <span class="Data_Value">
                                                                    {{$data->number}}
                                                            </span>
                                                            </div>
                                                            <div class="Data_Col Data_Col--End">
                                                                <i class="material-icons">
                                                                    verified
                                                                </i>
                                                            </div>
                                                        </div>
                                                        <div class="ListData__Item ListData__Item--NoAction">
                                                            <div class="Data_Col">
                                                                <span class="Data_Label">
                                                                    @lang("decisionType")
                                                                </span>
                                                                <span class="Data_Value">
                                                                        {{$data->type_decision->name ?? ""}}
                                                                </span>
                                                            </div>
                                                            <div class="Data_Col Data_Col--End">
                                                                <i class="material-icons">
                                                                    verified
                                                                </i>
                                                            </div>
                                                        </div>
                                                        <div class="ListData__Item ListData__Item--NoAction">
                                                            <div class="Data_Col">
                                                            <span class="Data_Label">
                                                                @lang("dateDecision")
                                                            </span>
                                                                <span class="Data_Value">
                                                                    {{$data->date}}
                                                            </span>
                                                            </div>
                                                            <div class="Data_Col Data_Col--End">
                                                                <i class="material-icons">
                                                                    verified
                                                                </i>
                                                            </div>
                                                        </div>
                                                        <div class="ListData__Item ListData__Item--NoAction">
                                                            <div class="Data_Col">
                                                            <span class="Data_Label">
                                                                @lang("sessionName")
                                                            </span>
                                                                <span class="Data_Value">
                                                                    {{$data->session_decision->name  ?? ""}}
                                                            </span>
                                                            </div>
                                                            <div class="Data_Col Data_Col--End">
                                                                <i class="material-icons">
                                                                    verified
                                                                </i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Col">
                                        <div class="Card">
                                            <div class="Card__Inner">
                                                <div class="ListData NotResponsive ListData--CustomPrint">
                                                    <div class="ListData__Head">
                                                        <h4 class="ListData__Title">
                                                            @lang("decisionContent")
                                                        </h4>
                                                    </div>
                                                    <div class="PrintPage__Data">
                                                        <div class="PrintPage__TextEditorContent">
                                                            <div class="TextEditorContent">
                                                                <div class="TextEditorContent__Content">
                                                                    <div class="Card Content">
                                                                        <div class="Card__Inner">
                                                                            {!! $data->content !!}
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
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
            {{--  Footer  --}}
            <footer class="FooterPage FooterPage--Print">
                <div class="FooterPage__Wrap">
                    <div class="Container--MainContent">
                        <div class="FooterPage__Content">
                            <div class="RowFooter">
                                <div class="FooterPage__CopyRight">
                                    Copyright © 2022
                                </div>
                                <div class="FooterPage__Links">
                                    Designed by <span class="SystemName"> ERP Epic </span> All rights reserved
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        {{-- JS Library --}}
        <script src="{{asset("System/Assets/Lib/Libraries.js")}}"></script>
        {{-- Main JS --}}
        <script src="{{asset("System/Assets/JS/Main.js")}}"></script>
        <script>
            window.onload = function () {
                javascript:window.print();
            };
        </script>
    </body>

</html>
