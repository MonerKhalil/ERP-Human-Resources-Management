<?php
    $MyAccount = auth()->user() ;
    $IsHavePermissionSessionCreate = $MyAccount->can("create_session_decisions") || $MyAccount->can("all_session_decisions") ;
    $IsHavePermissionSessionEdit = $MyAccount->can("update_session_decisions") || $MyAccount->can("all_session_decisions") ;
?>

@extends("System.Pages.globalPage")

<?php
    $employeesSelector = [] ;
    foreach ($employees as $Employee) {
        array_push($employeesSelector , [ "Label" => $Employee["first_name"].$Employee["last_name"]
            , "Value" => $Employee["id"] ]) ;
    }
?>

@section("ContentPage")
    @if((isset($data) && $IsHavePermissionSessionEdit) ||
        (!isset($data) && $IsHavePermissionSessionCreate))
        <section class="MainContent__Section MainContent__Section--AddDecisionPage">
            <div class="AddDecisionPage">
                <div class="AddUserPage__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __("sessionForm") ,
                        'paths' => [[__("home") , '#'] , [__("sessionForm")]] ,
                        'summery' => __("titleSessionForm")
                    ])
                </div>
                <div class="AddUserPage__Content">
                    <div class="Row">
                        <div class="AddUserPage__Form">
                            <div class="Container--MainContent">
                                <div class="MessageProcessContainer">
                                    @include("System.Components.messageProcess")
                                </div>
                                <div class="Card">
                                    <div class="Card__Content">
                                        <div class="Card__Inner">
                                            <div class="Card__Body">
                                                <form class="Form Form--Dark" method="post"
                                                      @if(isset($data))
                                                      action="{{route("system.session_decisions.update" , $data["id"])}}"
                                                      @else
                                                      action="{{route("system.session_decisions.store")}}"
                                                    @endif>
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
                                                            <div class="Row GapC-1-5">
                                                                <div class="Col-4-md Col-6-sm">
                                                                    <div class="Form__Group"
                                                                         data-ErrorBackend="{{ Errors("name") }}">
                                                                        <div class="Form__Input">
                                                                            <div class="Input__Area">
                                                                                <input id="SessionName" class="Input__Field"
                                                                                       type="text"
                                                                                       @if(isset($data))
                                                                                       value="{{$data["name"]}}"
                                                                                       @endif
                                                                                       name="name" placeholder="@lang("sessionName")" required>
                                                                                <label class="Input__Label" for="SessionName">@lang("sessionName")</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="Col-4-md Col-6-sm">
                                                                    <div class="Form__Group"
                                                                         data-ErrorBackend="{{ Errors("date_session") }}">
                                                                        <div class="Form__Date">
                                                                            <div class="Date__Area">
                                                                                <input id="SessionDate" class="Date__Field MinimumNow"
                                                                                       @if(isset($data))
                                                                                       value="{{$data["date_session"]}}"
                                                                                       @endif
                                                                                       type="date" name="date_session"
                                                                                       placeholder="@lang("sessionDate")" required>
                                                                                <label class="Date__Label" for="SessionDate">@lang("sessionDate")</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="Col">
                                                                    <div class="Form__Group"
                                                                         data-ErrorBackend="{{ Errors("description") }}">
                                                                        <div class="Form__Textarea">
                                                                            <div class="Textarea__Area">
                                                                                <textarea id="SessionDirection"
                                                                                          class="Textarea__Field"
                                                                                          name="description"
                                                                                          rows="6"
                                                                                          placeholder="@lang("sessionDirection")"
                                                                                          required>@if(isset($data)){{$data["description"]}}@endif</textarea>
                                                                                <label class="Textarea__Label"
                                                                                       for="SessionDirection">
                                                                                    @lang("sessionDirection")
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ListData">
                                                        <div class="ListData__Head">
                                                            <h4 class="ListData__Title">
                                                                @lang("sessionMember")
                                                            </h4>
                                                        </div>
                                                        <div class="ListData__Content">
                                                            <div class="Row GapC-1-5">
                                                                <div class="Col-4-md Col-6-sm">
                                                                    <div class="Form__Group"
                                                                         data-ErrorBackend="{{ Errors("moderator_id") }}">
                                                                        <div class="Form__Select">
                                                                            <div class="Select__Area">
                                                                                @include("System.Components.selector" , [
                                                                                    'Name' => "moderator_id" , "Required" => "true" ,
                                                                                    "DefaultValue" => isset($data) ? $data["moderator_id"] : ""
                                                                                     , "Label" => __("sessionModerator") ,
                                                                                    "Options" => $employeesSelector
                                                                                ])
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="Selector2Readonly Col-4-md Col-6-sm"
                                                                     data-ClassContainer="Col-4-md Col-6-sm"
                                                                     data-ReadonlyNames="members[]"
                                                                     data-TitleField="@lang("memberInSession")"
                                                                     data-RequiredNum="1"
                                                                     @if(isset($data) && count($data->members) > 0)
                                                                     data-ValueSelectedNum="{{ count($data->members) }}"
                                                                     @endif
                                                                     @if(isset($data))
                                                                     <?php
                                                                     $MembersIDs = null ;
                                                                     foreach ($data->members as $Member)
                                                                         if($MembersIDs != null)
                                                                             $MembersIDs = $MembersIDs.",".$Member["id"] ;
                                                                         else
                                                                             $MembersIDs = $Member["id"]."" ;
                                                                     ?>
                                                                     data-DefaultValues="{{$MembersIDs}}"
                                                                     @endif
                                                                     data-Location="Before">
                                                                    <div class="Form__Group">
                                                                        <div class="Form__Select">
                                                                            <div class="Select__Area">
                                                                                @include("System.Components.selector" , [
                                                                                    'Name' => "" , "Required" => "true" ,
                                                                                    "DefaultValue" => "" , "Label" => __("sessionMember") ,
                                                                                    "Options" => $employeesSelector
                                                                                ])
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
                                                                            type="submit">@lang("createSession")
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
        </section>
    @endif
@endsection
