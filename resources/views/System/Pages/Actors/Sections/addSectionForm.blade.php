<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionSessionInRead = $MyAccount->can("read_sections") || $MyAccount->can("all_sections") ;
    $IsHavePermissionSessionInEdit = $MyAccount->can("update_sections") || $MyAccount->can("all_sections") ;
    $IsHavePermissionSessionInDelete = $MyAccount->can("delete_sections") || $MyAccount->can("all_sections") ;
    $IsHavePermissionSessionInExport = $MyAccount->can("export_sections") || $MyAccount->can("all_sections") ;
    $IsHavePermissionSessionInCreate = $MyAccount->can("create_sections") || $MyAccount->can("all_sections") ;
?>

@extends("System.Pages.globalPage")

@section("ContentPage")
    @if((isset($sections) && $IsHavePermissionSessionInEdit) ||
        (!isset($sections) && $IsHavePermissionSessionInCreate))
        <section class="MainContent__Section MainContent__Section--NewSectionForm">
            <div class="NewSectionFormPage">
                <div class="NewSectionFormPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => isset($sections) ? __("editSectionInfo") : __("registerSectionInfo") ,
                        'paths' => [[__("home") , '#'] , ['Page']] ,
                        'summery' => __("titleRegisterSectionInfo")
                    ])
                </div>
                <div class="NewSectionFormPage__Content">
                    <div class="Row">
                        <div class="NewSectionFormPage__Form">
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
                                                          action="{{ isset($sections) ? route("system.sections.update" , $sections["id"])
                                                                : route("system.sections.store") }}"
                                                          method="post">
                                                        @csrf
                                                        @if(isset($sections))
                                                            @method("put")
                                                        @endif
                                                        <div class="ListData" >
                                                            <div class="ListData__Head">
                                                                <h4 class="ListData__Title">
                                                                    @lang("basicSectionInfo")
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
                                                                                        <input id="SectionName" class="Input__Field"
                                                                                               type="text" name="name"
                                                                                               value="{{ isset($sections) ? $sections["name"] : "" }}"
                                                                                               placeholder="@lang("sectionName")" required>
                                                                                        <label class="Input__Label" for="SectionName">
                                                                                            @lang("sectionName")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("moderator_id") }}">
                                                                                <div class="Form__Select">
                                                                                    <div class="Select__Area">
                                                                                        @php
                                                                                            $Employees = [] ;
                                                                                            foreach ($employees as $Employee) {
                                                                                                array_push($Employees , [ "Label" => $Employee["first_name"]." ".$Employee["last_name"]
                                                                                                    , "Value" => $Employee["id"] ]) ;
                                                                                            }
                                                                                        @endphp
                                                                                        @include("System.Components.selector" , [
                                                                                            'Name' => "moderator_id" , "Required" => "true" ,
                                                                                            "DefaultValue" => isset($sections) ? $sections["moderator_id"] : ""
                                                                                             , "Label" => __("managerSection") ,
                                                                                            "Options" => $Employees
                                                                                        ])
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div id="State"
                                                                             data-StateDefault="{{ isset($sections) ? $sections->address["country_id"] : "" }}"
                                                                             data-CityDefault="{{ isset($sections) ? $sections->address["id"] : "" }}"
                                                                             data-CityURL="{{route("get.address")}}"
                                                                             class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group">
                                                                                <div class="Form__Select">
                                                                                    <div class="Select__Area">
                                                                                        @php
                                                                                            $Countries = [] ;
                                                                                            foreach ($countries as $Index => $Item) {
                                                                                                array_push($Countries , [
                                                                                                    "Label" => $Item
                                                                                                    , "Value" => $Index ]) ;
                                                                                            }
                                                                                        @endphp
                                                                                        @include("System.Components.selector" , [
                                                                                                    'Name' => "_" , "Required" => "true"
                                                                                                    , "Label" => __('countryName')
                                                                                                    ,"DefaultValue" => isset($sections) ? $sections->address["country_id"] : ""
                                                                                                    , "Options" => $Countries
                                                                                                ])
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div id="City"
                                                                             class="Col-4-md Col-6-sm">
                                                                            <div class="Form__Group">
                                                                                <div class="Form__Select">
                                                                                    <div class="Select__Area">
                                                                                        @include("System.Components.selector" , ['Name' => "address_id" , "Required" => "true" , "Label" => __('locationSection')
                                                                                                ,"DefaultValue" => isset($sections) ? $sections->address["country_id"] : "" ,
                                                                                                "OptionsValues" => []
                                                                                            ])
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Col-12">
                                                                            <div class="Form__Group"
                                                                                 data-ErrorBackend="{{ Errors("details") }}">
                                                                                <div class="Form__Textarea">
                                                                                    <div class="Textarea__Area">
                                                                                    <textarea id="SectionDetails" class="Textarea__Field"
                                                                                              name="details" placeholder="@lang("descriptionSection")"
                                                                                              rows="3"
                                                                                    >{{ isset($sections) ? $sections["details"] : "" }}</textarea>
                                                                                        <label class="Textarea__Label" for="SectionDetails">
                                                                                            @lang("descriptionSection")
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="Row GapC-1-5">
                                                            <div class="Col">
                                                                <div class="Form__Group">
                                                                    <div class="Form__Button">
                                                                        <button class="Button Send"
                                                                                type="submit">
                                                                            @lang("addNewSection")
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
        </section>
    @endif
@endsection
