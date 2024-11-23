<!doctype html>
@if(app()->getLocale()==="en")
    <html lang="en" dir="ltr">
@else
    <html lang="en" dir="rtl">
@endif
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <h1>@lang("dashboard")</h1>
    @if(app()->getLocale()==="en")
        <form action="{{route("lang.change","ar")}}" method="get">
            <input type="time" name="time">
            <button type="submit">change</button>
        </form>
    @else
        <form action="{{route("lang.change","en")}}" method="get">
            <input type="time" name="time">
            <button type="submit">change</button>
        </form>
    @endif
    @if(Session::has(Messages::$suc))
        <h2>{{Session::get(Messages::$suc)}}</h2>
    @endif
   <h2> {{request('section_id')}}</h2>

</body>
</html>
