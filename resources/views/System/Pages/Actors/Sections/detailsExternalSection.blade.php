<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionSessionExRead = $MyAccount->can("read_section_externals") || $MyAccount->can("all_section_externals") ;
    $IsHavePermissionSessionExEdit = $MyAccount->can("update_section_externals") || $MyAccount->can("all_section_externals") ;
    $IsHavePermissionSessionExDelete = $MyAccount->can("delete_section_externals") || $MyAccount->can("all_section_externals") ;
    $IsHavePermissionSessionExExport = $MyAccount->can("export_section_externals") || $MyAccount->can("all_section_externals") ;
    $IsHavePermissionSessionExCreate = $MyAccount->can("create_section_externals") || $MyAccount->can("all_section_externals") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--DetailsSectionPage">
        <div class="DetailsSectionPage">
            <div class="DetailsSectionPage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __("ViewSectionExternalDetails") ,
                    'paths' => [[__("home") , '#'] , [__("viewSectionDetails")]] ,
                    'summery' => __("TitleViewSectionExternalDetails")
                ])
            </div>
            <div class="DetailsSectionPage__Content">
                <div class="Container--MainContent">
                    <div class="MessageProcessContainer">
                        @include("System.Components.messageProcess")
                    </div>
                    <div class="Row">
                        <div class="Col">
                            <div class="Card">
                                <div class="Card__Inner">
                                    <div class="ListData NotResponsive">
                                        <div class="ListData__Head">
                                            <h4 class="ListData__Title">
                                                @lang("basicSectionInfo")
                                            </h4>
                                        </div>
                                        @if($IsHavePermissionSessionExRead)
                                            <div class="ListData__Content">
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("sectionName")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{ $sectionExternal["name"] }}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("locationSection")
                                                    </span>
                                                    <span class="Data_Value">
                                                        @php
                                                            $CountryName = null ;
                                                            foreach($countries as $Index=>$Country)
                                                                if($Index == $sectionExternal["address_id"])
                                                                    $CountryName = $Country ;
                                                        @endphp
                                                        {{ $CountryName ?? "" }}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("email")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{ $sectionExternal["email"] }}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("AddressDetails")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{ $sectionExternal["address_details"] }}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("fax")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{ $sectionExternal["fax"] }}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        @lang("phone")
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{ $sectionExternal["phone"] }}
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @if($IsHavePermissionSessionExEdit || $IsHavePermissionSessionExDelete)
                                        <div class="ListData">
                                            <div class="ListData__Head">
                                                <h4 class="ListData__Title">
                                                    @lang("operationSection")
                                                </h4>
                                            </div>
                                            <div class="ListData__Content">
                                                <div class="Card__Inner px0">
                                                    @if($IsHavePermissionSessionExEdit)
                                                        <a href="{{route("system.section_externals.edit" , $sectionExternal["id"])}}"
                                                           class="Button Button--Primary">
                                                            @lang("editSection")
                                                        </a>
                                                    @endif
                                                    @if($IsHavePermissionSessionExDelete)
                                                        <form class="Form"
                                                              style="display: inline-block" method="post"
                                                              action="{{route("system.section_externals.destroy" , $sectionExternal["id"])}}">
                                                            @csrf
                                                            @method("delete")
                                                            <button type="submit" class="Button Button--Danger">
                                                                @lang("removeOneSection")
                                                            </button>
                                                        </form>
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
