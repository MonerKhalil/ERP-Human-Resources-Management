<!doctype html>
@if(app()->getLocale()==="en")
    <html lang="en" dir="ltr">
    @else
    <html lang="ar" dir="rtl">
@endif

    <head>
        @include('System.Layouts.head.head')
    </head>

    <body class="Light">
        <div id="Wrapper">
            @yield("MainContent")
            @include("System.Components.loader")
        </div>
            {{-- Scripts --}}
            @include("System.Layouts.Footer.footerScript")
    </body>

</html>
