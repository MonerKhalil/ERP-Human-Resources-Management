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

            .ViewUsers__TableUsers {
                overflow: hidden ;
            }

            .Table__Table .Item__Col {
                text-align : center  ;
                border : 1px solid #23364e ;
            }

            .PrintPage .Table__Table .Item__Col {
                width: auto ;
            }

            .Table__Table .Item.HeaderList .Item__Col {
                font-size: 1.4rem ;
                background-color: #3F51B5;
                color: #fff;
            }

            .FooterPage .RowFooter{
                display: flex;
                justify-content: space-between;
                align-content: center;
            }

            /*# sourceMappingURL=Style.css.map */

        </style>

    </head>

    <body>
        <div id="Wrapper">
            {{--  Main Content  --}}
            <main class="MainContent">
                <section class="MainContent__Section MainContent__Section--Print">
                    <div class="PrintPage">
                        <div class="ViewUsers__Content">
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
                                        <div class="Card ViewUsers__TableUsers">
                                            <div class="Table">
                                                <div class="Card__Inner p0">
                                                    <div class="Table__ContentTable">
                                                        <table class="Table__Table">
                                                            <thead>
                                                            <tr class="Item HeaderList">
                                                                @foreach($data["head"] as $value)
                                                                    @if(is_array($value) && isset($value['head']))
                                                                        <th class="Item__Col">
                                                                            <span>{{$value['head']}}</span>
                                                                        </th>
                                                                    @else
                                                                        <th class="Item__Col">
                                                                            <span>{{$value}}</span>
                                                                        </th>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($data["body"] as $item)
                                                                <tr class="Item DataItem">
                                                                    @foreach($data['head'] as $value)
                                                                        @if(is_array($value) && isset($value['head']))
                                                                            <td class="Item__Col">{{ $item->{$value['relationFunc']}->{$value['key']} ?? "" }}</td>
                                                                        @else
                                                                            <td class="Item__Col">{{ $item->{$value} ?? "" }}</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
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
