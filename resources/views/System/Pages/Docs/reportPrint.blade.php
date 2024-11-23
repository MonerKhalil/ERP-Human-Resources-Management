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
            {{-- CSS Extra--}}
            <style>

                /* Custom CSS */

                .FooterPage .RowFooter{
                    display: flex;
                    justify-content: space-between;
                    align-content: center;
                }

            </style>

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
                                                <div class="Card PrintPage__ReportTable Report">
                                                    <div class="Report__Content">
                                                        <div class="Table">
                                                            <div class="Card__InnerGroup">
                                                                <div class="Card__Inner p0">
                                                                    <div class="Table__ContentTable">
                                                                        <table class="Center Table__Table" >
                                                                            <thead>
                                                                                <tr class="Item HeaderList">
                                                                                    <th class="Item__Col">
                                                                                        #
                                                                                    </th>
                                                                                    <th class="Item__Col">
                                                                                        اسم الموظف
                                                                                    </th>
                                                                                    <th class="Item__Col">
                                                                                        الجنس
                                                                                    </th>
                                                                                    <th class="Item__Col">
                                                                                        رقم الاضبارة
                                                                                    </th>
                                                                                    <th class="Item__Col">
                                                                                        الوظيفة الحالية
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            @foreach($finalData as $RowData)
                                                                                <tbody class="GroupRows">
                                                                                    <tr class="GroupRows__MainRow">
                                                                                        <td class="Item__Col">
                                                                                            {{ $RowData["id"] }}
                                                                                        </td>
                                                                                        <td class="Item__Col">
                                                                                            {{ $RowData["first_name"]." ".$RowData["last_name"] }}
                                                                                        </td>
                                                                                        <td class="Item__Col">
                                                                                            {{ $RowData["gender"] }}
                                                                                        </td>
                                                                                        <td class="Item__Col">
                                                                                            1
                                                                                        </td>
                                                                                        <td class="Item__Col">
                                                                                            {{ $RowData["current_job"] }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    @if(count($dataSelected) != 0)
                                                                                        <tr class="GroupRows__SubRows">
                                                                                            <td class="Item__Col" colspan="6">
                                                                                                <div class="Report">
                                                                                                    <div class="Report__Content">
                                                                                                        <div class="ListData NotResponsive">
                                                                                                            <div class="ListData__Content">
                                                                                                                @foreach($dataSelected as $Index => $ReportSelected)
                                                                                                                    @if($Index != "gender")
                                                                                                                        <div class="ListData__Item ListData__Item--NoAction">
                                                                                                                            <div class="Data_Col">
                                                                                                                            <span class="Data_Label">
                                                                                                                                {{ $Index }}
                                                                                                                            </span>
                                                                                                                                <span class="Data_Value">
                                                                                                                                {{ $ReportSelected }}
                                                                                                                            </span>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    @endif
                                                                                                                @endforeach
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endif
                                                                                </tbody>
                                                                            @endforeach
                                                                        </table>
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
