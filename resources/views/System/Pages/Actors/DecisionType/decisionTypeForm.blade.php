<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionDecisionTypeRead = $MyAccount->can("read_type_decisions") || $MyAccount->can("all_type_decisions") ;
    $IsHavePermissionDecisionTypeEdit = $MyAccount->can("update_type_decisions") || $MyAccount->can("all_type_decisions") ;
    $IsHavePermissionDecisionTypeDelete = $MyAccount->can("delete_type_decisions") || $MyAccount->can("all_type_decisions") ;
    $IsHavePermissionDecisionTypeExport = $MyAccount->can("export_type_decisions") || $MyAccount->can("all_type_decisions") ;
    $IsHavePermissionDecisionTypeCreate = $MyAccount->can("create_type_decisions") || $MyAccount->can("all_type_decisions") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    @if((isset($data) && $IsHavePermissionDecisionTypeEdit) ||
        (!isset($data) && $IsHavePermissionDecisionTypeCreate))
        <section class="MainContent__Section MainContent__Section--AddDecisionPage">
            <div class="AddDecisionPage">
                <div class="AddUserPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => "تسجيل نوع قرار جديد" ,
                        'paths' => [[__("home") , '#'] , [__("decisionForm")]] ,
                        'summery' => __("titleDecisionForm")
                    ])
                </div>
                <div class="AddUserPage__Content">
                    <div class="ViewUsers__Content">
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
                                                        <form class="Form Form--Dark"
                                                              action="{{ (isset($data)) ? route("system.type_decisions.update" , $data["id"])
                                                                        : route("system.type_decisions.store") }}"
                                                              method="post">
                                                            @csrf
                                                            @if(isset($data))
                                                                @method("put")
                                                            @endif
                                                            <div class="ListData">
                                                                <div class="ListData__Head">
                                                                    <h4 class="ListData__Title">
                                                                        @lang("basics")
                                                                    </h4>
                                                                </div>
                                                                <div class="ListData__Content">
                                                                    <div class="ListData__CustomItem">
                                                                        <div class="Row GapC-1-5">
                                                                            <div class="Col-4-md Col-6-sm">
                                                                                <div class="Form__Group"
                                                                                     data-ErrorBackend="{{ Errors("name") }}">
                                                                                    <div class="Form__Input">
                                                                                        <div class="Input__Area">
                                                                                            <input id="DecisionTypeName" class="Input__Field" type="text"
                                                                                                   value="{{ isset($data) ? $data["name"] : "" }}"
                                                                                                   name="name" placeholder="اسم النوع" required>
                                                                                            <label class="Input__Label" for="DecisionTypeName">
                                                                                                اسم النوع
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="Row">
                                                                <div class="Col">
                                                                    <div class="Form__Group">
                                                                        <div class="Form__Button">
                                                                            <button class="Button Send"
                                                                                    type="submit">
                                                                                اضافة نوع جديد
                                                                            </button>
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
            </div>
        </section>
    @endif
@endsection
