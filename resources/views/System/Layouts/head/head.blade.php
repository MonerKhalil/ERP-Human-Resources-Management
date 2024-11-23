
{{-- Meta System --}}
@include('.System.Layouts.head.meta')
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
@yield('CSSLibrary_Extra')
{{-- Main CSS System --}}
<link rel="stylesheet" href='{{asset('System/Assets/CSS/Style.css')}}' type="text/css" />
{{-- CSS Extra--}}
@yield('CSS_Extra')
