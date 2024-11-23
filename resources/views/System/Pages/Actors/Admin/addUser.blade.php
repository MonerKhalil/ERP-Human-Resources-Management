<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionCreate = $MyAccount->can("create_users") || $MyAccount->can("all_users") ;
?>


@extends("System.Pages.globalPage")

@section("ContentPage")
    @if($IsHavePermissionCreate)
        <section class="MainContent__Section MainContent__Section--AddUserPage">
            <div class="AddUserPage">
                <div class="AddUserPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __('addUser') ,
                        'paths' => [[__("home") , '#'] , [__('addUser')]] ,
                        'summery' => __('titleAddUserPage')
                    ])
                </div>
                <div class="AddUserPage__Content">
                    <div class="Row">
                        <div class="AddUserPage__Form">
                            <div class="Container--MainContent">
                                <div class="MessageProcessContainer">
                                    @include("System.Components.messageProcess")
                                </div>
                                <div class="Row">
                                    <div class="Card">
                                        <div class="Card__Content">
                                            <div class="Card__Inner">
                                                <div class="Card__Body">
                                                    <form class="Form Form--Dark" action="{{route("users.store")}}" method="post">
                                                        @csrf
                                                        <div class="ListData" >
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("userInfoBasic")
                                                                </h4>
                                                            </div>
                                                            <div class="ListData__Content">
                                                                <div class="Row GapC-1-5">
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group"
                                                                             data-ErrorBackend="{{ Errors("name") }}">
                                                                            <div class="Form__Input">
                                                                                <div class="Input__Area">
                                                                                    <input id="name" class="Input__Field" type="text"
                                                                                           name="name" placeholder="@lang("userName")" required>
                                                                                    <label class="Input__Label" for="name">@lang("userName")</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group"
                                                                             data-ErrorBackend="{{ Errors("email") }}">
                                                                            <div class="Form__Input">
                                                                                <div class="Input__Area">
                                                                                    <input id="email" class="Input__Field"
                                                                                           type="email" name="email" placeholder="@lang("email")" required>
                                                                                    <label class="Input__Label" for="email">@lang("email")</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group"
                                                                             data-ErrorBackend="{{ Errors("password") }}">
                                                                            <div class="Form__Input Form__Input--Password">
                                                                                <div class="Input__Area">
                                                                                    <input id="Password" class="Input__Field"
                                                                                           type="password" name="password" placeholder="@lang("password")" required>
                                                                                    <label class="Input__Label" for="Password">@lang("password")</label>
                                                                                    <i class="material-icons Input__Icon">visibility</i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group"
                                                                             data-ErrorBackend="{{ Errors("re_password") }}">
                                                                            <div class="Form__Input Form__Input--Password">
                                                                                <div class="Input__Area">
                                                                                    <input id="Re_password" class="Input__Field"
                                                                                           type="password" name="re_password" placeholder="@lang("rePassword")" required>
                                                                                    <label class="Input__Label" for="Re_password">@lang("rePassword")</label>
                                                                                    <i class="material-icons Input__Icon">visibility</i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="Form__Group"
                                                                             data-ErrorBackend="{{ Errors("role") }}">
                                                                            <div class="Form__Select">
                                                                                <div class="Select__Area">
                                                                                    @include("System.Components.selector" , [
                                                                                        'Name' => "role" , "Required" => "true" ,
                                                                                        "DefaultValue" => "" , "Label" => __('role') ,
                                                                                        "OptionsValues" => $roles,
                                                                                    ])
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="Col-12-xs">
                                                                        <div class="Form__Group">
                                                                            <div class="Form__Button">
                                                                                <button class="Button Send"
                                                                                        type="submit">@lang("addUser")</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
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
    @endif
@endsection
