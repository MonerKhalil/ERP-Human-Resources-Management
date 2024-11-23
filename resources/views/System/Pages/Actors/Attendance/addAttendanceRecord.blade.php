<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionAttendanceCreate = !is_null(auth()->user()->employee["id"]) ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    @if($IsHavePermissionAttendanceCreate)
        <section class="MainContent__Section MainContent__Section--AddAttendancePage">
            <div class="AddAttendancePage">
                <div class="AddAttendancePage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __('RegisterAttendanceRecord') ,
                        'paths' => [['Attendances' , '#'] , ['New Attendance']] ,
                        'summery' => __('RegisterAttendancePage')
                    ])
                </div>
            </div>
            <div class="AddAttendancePagePrim__Content">
                <div class="Row">
                    <div class="AddAttendancePage__Form">
                        <div class="Container--MainContent">
                            <div class="Row">
                                <div class="AttendancePage__Information">
                                    <div class="AttendanceClock Taps">
                                        <div class="AttendanceClock__TypeTime">
                                            <div class="TypeTime">
                                                <div class="Taps__Item TimeIn Active"
                                                     data-content="TimeIn">
                                                    @lang("TimeCheckIn")
                                                </div>
                                                @if(isset($attendance["check_in"]))
                                                    <div class="Taps__Item TimeOut"
                                                         data-content="TimeOut">
                                                        @lang("TimeCheckOut")
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="Taps__Panel" data-panel="TimeIn">
                                            <form action="{{ route("system.attendances.store.type" , "check_in") }}" method="post">
                                                @csrf
                                                <div class="AttendanceClock__DateTime">
                                                    <div class="CircleTime ClockTime">
                                                        <div class="Day"></div>
                                                        <div class="Time"></div>
                                                        <div class="Date"></div>
                                                    </div>
                                                </div>
                                                <div class="AttendanceClock__Register">
                                                    @if(isset($attendance["check_in"]))
                                                        <div class="BoxRegister">
                                                            @lang("Welcome")! {{ $employee["first_name"]." ".$employee["last_name"] }} <br>
                                                            @lang("DoneCheckIn") {{ \Carbon\Carbon::parse($attendance["check_in"])->format('H:i:s A') }} @lang("Success")!
                                                        </div>
                                                    @else
                                                        <button class="Button Size-2 Button--Primary">
                                                            @lang("CheckInRecord")
                                                        </button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                        @if(isset($attendance["check_in"]))
                                            <div class="Taps__Panel" data-panel="TimeOut">
                                                <form action="{{ route("system.attendances.store.type" , "check_out") }}" method="post">
                                                    @csrf
                                                    <div class="AttendanceClock__DateTime">
                                                        <div class="CircleTime ClockTime">
                                                            <div class="Day"></div>
                                                            <div class="Time"></div>
                                                            <div class="Date"></div>
                                                        </div>
                                                    </div>
                                                    <div class="AttendanceClock__Register">
                                                        @if(isset($attendance["check_out"]))
                                                            <div class="BoxRegister">
                                                                @lang("Welcome")! {{ $employee["first_name"]." ".$employee["last_name"] }} <br>
                                                                @lang("DoneCheckOut") {{ \Carbon\Carbon::parse($attendance["check_out"])->format('H:i:s A') }} @lang("Success")!
                                                            </div>
                                                        @else
                                                            <button class="Button Size-2 Button--Primary">
                                                                @lang("CheckOutRecord")
                                                            </button>
                                                        @endif
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
