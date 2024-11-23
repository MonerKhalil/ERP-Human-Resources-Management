<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionCreate = $MyAccount->can("create_roles") || $MyAccount->can("all_roles") ;
?>


@extends("System.Pages.globalPage")

@php
    $IsEditPage = isset($role) ;
    $PermissionNotReserve = [] ;
    if($IsEditPage) {
        foreach($permissions as $Permission) {
            $IsExist = false ;
            foreach($rolePermissions as $RolePermission) {
                if($Permission["id"] == $RolePermission["id"]) {
                    $IsExist = true ;
                    break ;
                }
            }
            if(!$IsExist)
                array_push($PermissionNotReserve , $Permission) ;
        }
    } else {
        $PermissionNotReserve = $permissions ;
    }
@endphp

@section("ContentPage")
    @if($IsHavePermissionCreate)
        <section class="MainContent__Section MainContent__Section--RollSetting">
            <div class="RollSettingPage">
                <div class="AddUserPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __("roleSetting") ,
                        'paths' => [[__("home") , '#'] , [__("roleSetting")]] ,
                        'summery' => __("titleRoleAdd")
                    ])
                    <div class="RollSettingPage__Content">
                        <div class="Container--MainContent">
                            <div class="MessageProcessContainer">
                                @include("System.Components.messageProcess")
                            </div>
                            <div class="Row GapC-2">
                                <div class="Col-6-md">
                                    <div class="Card">
                                        <div class="Card__Content">
                                            <div class="Card__Inner pb0">
                                                <div class="Card__Header">
                                                    <div class="Card__Title">
                                                        <h3>@lang("permissions")</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="Card__Inner">
                                                <div class="Card Card--Border">
                                                    <div class="Card__Body">
                                                        <div class="ListData">
                                                            <div class="DragDrop DragDrop__Zone
                                                                        ListData__Content" data-namesItem="Permissions">
                                                                @foreach($PermissionNotReserve as $Permission)
                                                                    <div class="DragDrop DragDrop__Item ListData__Item
                                                                            ListData__Item--Action" data-nameItem="Permissions">
                                                                        <input type="text" name="permissions[]"
                                                                               value="{{$Permission["id"]}}" hidden>
                                                                        <div class="Data_Col">
                                                                            <span class="Data_Label">
                                                                            {{$Permission["name"]}}
                                                                        </span>
                                                                        </div>
                                                                        <div class="Data_Col Data_Col--End">
                                                                            <i class="material-icons">
                                                                                sync_alt
                                                                            </i>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="Col-6-md">
                                    <div class="Card Card--NewRoll">
                                        <div class="Card__Content">
                                            <div class="Card__Inner pb0">
                                                <div class="Card__Header">
                                                    <div class="Card__Title">
                                                        <h3>@lang("newRole")</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="Card__Inner pt0">
                                                <form class="Form Form--Dark"
                                                      action="{{$IsEditPage ? route("roles.update" , $role["id"])
                                                                : route("roles.store")}}"
                                                      method="post">
                                                    @csrf
                                                    @if($IsEditPage)
                                                        @method("put")
                                                    @endif
                                                    <div class="Row">
                                                        <div class="Col">
                                                            <div class="Form__Group"
                                                                 data-ErrorBackend="{{ Errors("name") }}">
                                                                <div class="Form__Input">
                                                                    <div class="Input__Area">
                                                                        <input id="RoleName" class="Input__Field" type="text"
                                                                               name="name" value="{{$IsEditPage ? $role['name'] : ''}}"
                                                                               placeholder="@lang("roleName")" required>
                                                                        <label class="Input__Label" for="RoleName">@lang("roleName")</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="Col Col--DragDropTarget">
                                                            <div class="Card Card--Border">
                                                                <div class="Card__Body">
                                                                    <div class="ListData">
                                                                        <div class="DragDrop DragDrop__Zone
                                                                        ListData__Content" data-namesItem="Permissions">
                                                                            @if($IsEditPage)
                                                                                @foreach($rolePermissions as $Permission)
                                                                                    <div class="DragDrop DragDrop__Item ListData__Item
                                                                                         ListData__Item--Action"
                                                                                         data-nameItem="Permissions">
                                                                                        <input type="text" name="permissions[]"
                                                                                               value="{{$Permission["id"]}}" hidden>
                                                                                        <div class="Data_Col">
                                                                                            <span class="Data_Label">
                                                                            {{$Permission["name"]}}
                                                                        </span>
                                                                                        </div>
                                                                                        <div class="Data_Col Data_Col--End">
                                                                                            <i class="material-icons">
                                                                                                sync_alt
                                                                                            </i>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="Col">
                                                            <div class="Form__Group">
                                                                <div class="Form__Button">
                                                                    <button class="Button Send"
                                                                            type="submit">@lang("createOne")</button>
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
        </section>
    @endif
@endsection

