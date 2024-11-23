<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionSessionRead = $MyAccount->can("read_session_decisions") || $MyAccount->can("all_session_decisions") ;
    $IsHavePermissionSessionEdit = $MyAccount->can("update_session_decisions") || $MyAccount->can("all_session_decisions") ;
    $IsHavePermissionDecisionRead = $MyAccount->can("read_decisions") || $MyAccount->can("all_decisions") ;
?>


@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--SessionDetailsPage">
        <div class="SessionDetailsPage">
            <div class="SessionDetailsPage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __("sessionDetails") ,
                    'paths' => [[__("home") , '#'] , [__("sessionDetails")]] ,
                    'summery' => __("titleSessionDetails")
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
                                    @if($IsHavePermissionSessionRead)
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
                                                        @lang("sessionName")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$sessionDecision["name"]}}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("sessionDate")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$sessionDecision["date_session"]}}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("sessionDirection")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$sessionDecision["description"]}}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("sessionModerator")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$sessionDecision->moderator["first_name"].$sessionDecision->
                                                            moderator["last_name"] }}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("sessionMember")
                                                    </span>
                                                        <span class="Data_Value">
                                                        @foreach($sessionDecision->members as $Members)
                                                                {{$Members["first_name"].$Members["last_name"]}} ,
                                                            @endforeach
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("createSessionDate")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$sessionDecision["created_at"]}}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("updateSessionDate")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{$sessionDecision["updated_at"]}}
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($IsHavePermissionDecisionRead || $IsHavePermissionSessionEdit)
                                        <div class="ListData">
                                            <div class="ListData__Head">
                                                <h4 class="ListData__Title">
                                                    @lang("operationsOnSession")
                                                </h4>
                                            </div>
                                            <div class="ListData__Content">
                                                <div class="Card__Inner px0">
                                                    @if($IsHavePermissionDecisionRead)
                                                        <a href="{{route("system.decisions.session_decisions.show" , $sessionDecision["id"])}}"
                                                           class="Button Button--Primary">
                                                            @lang("viewDecision")
                                                        </a>
                                                    @endif
                                                    @if($IsHavePermissionSessionEdit)
                                                        <a href="{{route("system.session_decisions.edit" , $sessionDecision["id"])}}"
                                                           class="Button Button--Primary">
                                                            @lang("editSessionInfo")
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
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
@endsection
