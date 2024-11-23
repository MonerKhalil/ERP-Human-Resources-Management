
<?php
    $IsVisitor = (auth()->user()->id != $user->id) ;
    $MyAccount = auth()->user() ;
    $IsHavePermissionEditUser = isset($user) && ($MyAccount->can("update_users") || $MyAccount->can("all_users")) ;
    $IsHavePermissionEditEmployee = isset($user->employee) && ($MyAccount->can("update_employees")
            || $MyAccount->can("all_employees")) ;
    $IsHavePermissionReadUser = isset($user) && ($MyAccount->can("read_users") || $MyAccount->can("all_users")) ;
    $IsHavePermissionReadEmployee = isset($user->employee) && ($MyAccount->can("read_employees") || $MyAccount->can("all_employees")) ;
    $IsHavePermissionDelete = isset($user) && ($MyAccount->can("delete_users") || $MyAccount->can("all_users")) ;
?>


@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--Profile">
        <div class="ProfilePage ProfilePage--{{$IsVisitor ? "Visitor" : "My"}}">
            <div class="ProfilePage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __('profile') ,
                    'paths' => [[__("home") , '#'] , [__('profile')]] ,
                    'summery' => __('titleProfilePage')
                ])
            </div>
            <div class="ProfilePage__Content">
                <div class="Container--MainContent">
                    <div class="MessageProcessContainer">
                        @include("System.Components.messageProcess")
                    </div>
                    <div class="Row GapC-1">
                        @if($IsHavePermissionReadUser)
                            <div class="Col-3-md">
                                <div class="Card">
                                    <div class="Card__Content">
                                        <div class="Card__Inner">
                                            <div class="ProfilePage__Image">
                                                @if(!$IsVisitor && $IsHavePermissionEditUser)
                                                    <form class="ChangeImage" enctype="multipart/form-data"
                                                          action="{{$IsVisitor ? route("users.update",$user->id) : route("profile.update")}}"
                                                          method="post">
                                                        @csrf
                                                        <input type="file" id="ImageChange"
                                                               name="image" accept="image/png, image/gif, image/jpeg, image/jpg, image/svg" hidden>
                                                        <label for="ImageChange" style="display: block">
                                                            <div class="UserImage">
                                                                @if($user->image)
                                                                        <img src=" {{ PathStorage($user->image) }}" alt="UserImage">
                                                                    @else
                                                                        <img src=" {{ asset("System/Assets/Images/Avatar.jpg") }}"
                                                                             alt="UserImage">
                                                                @endif
                                                                <div class="UserImage__Edit">
                                                                    <i class="material-icons EditIcon">edit</i>
                                                                </div>
                                                                <i class="material-icons LockOpenIcon">lock_open</i>
                                                            </div>
                                                        </label>
                                                    </form>
                                                @else
                                                    <div class="UserImage">
                                                        @if($user->image)
                                                            <img src=" {{ PathStorage($user->image) }}" alt="UserImage">
                                                        @else
                                                            <img src=" {{ asset("System/Assets/Images/Avatar.jpg") }}"
                                                                 alt="UserImage">
                                                        @endif
                                                    </div>
                                                @endif
                                                <div class="Text">
                                                    <div class="UserName">
                                                        <span>{{$user->name}}</span>
                                                    </div>
                                                    <div class="Specialization">
                                                        <span>Front End Developer</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="Col-9-md">
                            <div class="ProfilePage__Information">
                                <div class="Card Card--Taps Taps">
                                    <ul class="Taps__List">
                                        @if($IsHavePermissionReadUser)
                                            <li class="Taps__Item Taps__Item--Icon"
                                            data-content="UserInfo">
                                            <i class="material-icons">face</i>
                                            @lang("userInfo")
                                        </li>
                                        @endif
                                        @if($IsHavePermissionEditUser || $IsHavePermissionDelete)
                                            <li class="Taps__Item Taps__Item--Icon"
                                                    data-content="SecurityInfo">
                                                    <i class="material-icons">security</i>
                                                    @lang("secureInfo")
                                                </li>
                                        @endif
                                    </ul>
                                    <div class="Taps__Content">
                                        @if($IsHavePermissionReadUser)
                                            <div class="Card Taps__Panel" data-panel="UserInfo">
                                                <div class="Card__Content">
                                                    <div class="Card__Inner">
                                                        <div class="Card__Body">
                                                            @include("System.Components.dataList" , [
                                                                "Title" => __("basics") , "ListData" => [
                                                                    [
                                                                        "Label" => __("userName") , "Value" => $user->name ,
                                                                        "IsLock" => !$IsHavePermissionEditUser , "PopupName" => "UpdateUser"
                                                                    ] , [
                                                                        "Label" => __("email") , "Value" => $user->email ,
                                                                        "IsLock" => !$IsHavePermissionEditUser , "PopupName" => "UpdateUser"
                                                                    ] , [
                                                                        "Label" => __("role") , "Value" => $user->roles[0]["name"] ?? "" ,
                                                                        "IsLock" => !(isset($roles) && $IsHavePermissionEditUser) , "PopupName" => "UpdateUser"
                                                                    ]
                                                                ]
                                                            ])
                                                            @include("System.Components.dataList" , [
                                                                "Title" => __("additionalInformation") , "ListData" => [
                                                                    [
                                                                        "Label" => "Create Date" , "Value" => "$user->created_at" ,
                                                                        "IsLock" => true
                                                                    ]
                                                                ]
                                                            ])
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($IsHavePermissionEditUser || $IsHavePermissionDelete)
                                            <div class="Card Taps__Panel ProfilePage__PasswordChange"
                                                 data-panel="SecurityInfo">
                                                <div class="Card__Content">
                                                    <div class="Card__Inner">
                                                        <div class="Card Card--Border">
                                                            <div class="Card__Body">
                                                                <div class="Card__InnerGroup">
                                                                    @if($IsHavePermissionEditUser)
                                                                        <div class="Card__Inner">
                                                                            <div class="PasswordChange">
                                                                                <div class="PasswordChange__Label">
                                                                                    <h4 class="PasswordChange__Title">
                                                                                        @lang("changePassword")
                                                                                    </h4>
                                                                                    <p class="PasswordChange__Text">
                                                                                        @lang("determinePassword")
                                                                                    </p>
                                                                                    <em class="PasswordChange__LastChange">
                                                                                        @lang("lastChange")
                                                                                        <span class="Date">Oct 2, 2019</span>
                                                                                    </em>
                                                                                </div>
                                                                                <div class="PasswordChange__Button">
                                                                                    <button class="OpenPopup Button Button--Primary"
                                                                                            data-popUp="UpdatePassword">
                                                                                        @lang("changePassword")
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @if($IsHavePermissionDelete)
                                                                        <div class="Card__Inner">
                                                                            <div class="DeleteAccount">
                                                                                <div class="DeleteAccount__Label">
                                                                                    <h4 class="DeleteAccount__Title">
                                                                                        @lang("deleteAccount")
                                                                                    </h4>
                                                                                    <p class="DeleteAccount__Text">
                                                                                        @lang("SureDeleteAccount")
                                                                                    </p>
                                                                                </div>
                                                                                <div class="DeleteAccount__Button">
                                                                                    <button class="OpenPopup Button Button--Danger"
                                                                                            data-popUp="DeleteAccount">
                                                                                        @lang("delete")
                                                                                    </button>
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
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section("PopupPage")
    @if($IsHavePermissionReadUser && $IsHavePermissionEditUser)
        <div class="Popup Popup--Dark" data-name="UpdateUser">
            <div class="Popup__Content">
                <div class="Popup__Card">
                    <i class="material-icons Popup__Close">close</i>
                    <div class="Popup__CardContent">
                        <div class="Popup__Inner">
                            <h3 class="Popup__Title">
                                <span class="Title">@lang("updateProfile")</span>
                            </h3>
                            <div class="Popup__Body">
                                <form class="Form Form--Dark"
                                      action="{{$IsVisitor ? route("users.update",$user->id) : route("profile.update")}}"
                                      method="post">
                                    @csrf
                                    <div class="Row GapC-1-5">
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Input">
                                                    <div class="Input__Area">
                                                        <input id="UserName" class="Input__Field"
                                                               type="text" name="name"
                                                               value="{{$user->name}}"
                                                               placeholder="@lang("userName")" required>
                                                        <label class="Input__Label" for="UserName">
                                                            @lang("userName")
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Input">
                                                    <div class="Input__Area">
                                                        <input id="Email" class="Input__Field"
                                                               type="email" name="email"
                                                               value="{{$user->email}}"
                                                               placeholder="@lang("email")" required>
                                                        <label class="Input__Label" for="Email">@lang("email")</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(isset($roles))
                                            <div class="Col-6-md">
                                                <div class="Form__Group">
                                                    <div class="Form__Select">
                                                        <div class="Select__Area">
                                                            @php
                                                                $RolesType = [] ;
                                                                foreach ($roles as $Index=>$RoleItem) {
                                                                    array_push($RolesType , [ "Label" => $RoleItem
                                                                        , "Value" => $Index ]) ;
                                                                }
                                                            @endphp
                                                            @include("System.Components.selector" , [
                                                                'Name' => "role" , "Required" => "true" ,
                                                                "DefaultValue" => $user->roles[0]["id"] ?? "" ,
                                                                "Label" => __("roles") ,
                                                                "Options" => $RolesType
                                                            ])
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="Col">
                                            <div class="Form__Group">
                                                <div class="Form__Button">
                                                    <button class="Button Send"
                                                            type="submit">@lang("updateData")</button>
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
        <div class="Popup Popup--Dark" data-name="UpdatePassword">
            <div class="Popup__Content">
                <div class="Popup__Card">
                    <i class="material-icons Popup__Close">close</i>
                    <div class="Popup__CardContent">
                        <div class="Popup__Inner">
                            <h3 class="Popup__Title">
                                <span class="Title">@lang("changePassword")</span>
                            </h3>
                            <div class="Popup__Body">
                                <form class="Form Form--Dark"
                                      action="{{$IsVisitor ? route("users.update",$user->id) : route("profile.update")}}"
                                      method="post">
                                    @csrf
                                    <div class="Row GapC-1-5">
                                        @if($IsVisitor)
                                            <div class="Col-6-md">
                                                <div class="Form__Group">
                                                    <div class="Form__Input Form__Input--Password">
                                                        <div class="Input__Area">
                                                            <input id="Password" class="Input__Field"
                                                                   type="password" name="password" placeholder="@lang("password")">
                                                            <label class="Input__Label" for="Password">@lang("password")</label>
                                                            <i class="material-icons Input__Icon">visibility</i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="Col-6-md">
                                                <div class="Form__Group">
                                                    <div class="Form__Input Form__Input--Password">
                                                        <div class="Input__Area">
                                                            <input id="OldPassword" class="Input__Field"
                                                                   type="password" name="old_password" placeholder="@lang("oldPassword")">
                                                            <label class="Input__Label" for="OldPassword">@lang("oldPassword")</label>
                                                            <i class="material-icons Input__Icon">visibility</i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="Col-6-md">
                                                <div class="Form__Group">
                                                    <div class="Form__Input Form__Input--Password">
                                                        <div class="Input__Area">
                                                            <input id="Password" class="Input__Field"
                                                                   type="password" name="new_password" placeholder="@lang("newPassword")">
                                                            <label class="Input__Label" for="Password">@lang("newPassword")</label>
                                                            <i class="material-icons Input__Icon">visibility</i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Input Form__Input--Password">
                                                    <div class="Input__Area">
                                                        <input id="Re_Password" class="Input__Field"
                                                               type="password" name="re_password"
                                                               placeholder="@lang("rePassword")" required>
                                                        <label class="Input__Label" for="Re_Password">@lang("rePassword")</label>
                                                        <i class="material-icons Input__Icon">visibility</i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col">
                                            <div class="Form__Group">
                                                <div class="Form__Button">
                                                    <button class="Button Send"
                                                            type="submit">@lang("updateData")</button>
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
    @endif
    @if($user->employee->exists && $IsHavePermissionReadEmployee && $IsHavePermissionEditEmployee)
        <div class="Popup Popup--Dark" data-name="UpdateEmployee">
            <div class="Popup__Content">
                <div class="Popup__Card">
                    <i class="material-icons Popup__Close">close</i>
                    <div class="Popup__CardContent">
                        <div class="Popup__Inner">
                            <h3 class="Popup__Title">
                                <span class="Title">@lang("updateProfile")</span>
                            </h3>
                            <div class="Popup__Body">
                                <form class="Form Form--Dark"
                                      action="{{$IsVisitor ? route("users.update",$user->id) : route("profile.update")}}"
                                      method="post">
                                    @csrf
                                    <div class="Row GapC-1-5">
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Input">
                                                    <div class="Input__Area">
                                                        <input id="FullName" class="Input__Field" type="text"
                                                               name="name" placeholder="Full Name">
                                                        <label class="Input__Label" for="FullName">Full Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Input">
                                                    <div class="Input__Area">
                                                        <input id="DossierNumber" class="Input__Field" type="number"
                                                               name="DossierNumber" placeholder="Dossier Number">
                                                        <label class="Input__Label" for="DossierNumber">Dossier Number</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Select">
                                                    <div class="Select__Area">
                                                        @include("System.Components.selector" , [
                                                            'Name' => "Gender" , "Required" => "true" ,
                                                            "DefaultValue" => "" , "Label" => __('gender') ,
                                                            "Options" => [ ["Label" => __('male') , "Value" => "male"] ,
                                                                           ["Label" => __('female') , "Value" => "female"]]
                                                        ])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Input">
                                                    <div class="Input__Area">
                                                        <input id="PhoneNumber" class="Input__Field" type="number"
                                                               name="PhoneNumber" placeholder="Phone Number">
                                                        <label class="Input__Label" for="PhoneNumber">Phone Number</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Date">
                                                    <div class="Date__Area">
                                                        <input id="DateBirthday" class="Date__Field"
                                                               type="text" name="DateBirthday"
                                                               placeholder="Date Birthday">
                                                        <label class="Date__Label" for="DateBirthday">Date Birthday</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Date">
                                                    <div class="Date__Area">
                                                        <input id="JoinDate" class="Date__Field"
                                                               type="text" name="Join Date"
                                                               placeholder="Join Date">
                                                        <label class="Date__Label" for="JoinDate">Join Date</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Select">
                                                    <div class="Select__Area">
                                                        @include("System.Components.selector" , [
                                                            'Name' => "FamilySituation" , "Required" => "true" ,
                                                            "DefaultValue" => "" , "Label" => "Family Situation" ,
                                                            "Options" => [ ["Label" => "Celibate" , "Value" => "1"] ,
                                                                           ["Label" => "married" , "Value" => "2"]]
                                                        ])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Input">
                                                    <div class="Input__Area">
                                                        <input id="Country" class="Input__Field" type="text"
                                                               name="Country" placeholder="Country">
                                                        <label class="Input__Label" for="Country">Country</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Input">
                                                    <div class="Input__Area">
                                                        <input id="Nationality" class="Input__Field" type="text"
                                                               name="Nationality" placeholder="Nationality">
                                                        <label class="Input__Label" for="Nationality">Nationality</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col">
                                            <div class="Form__Group">
                                                <div class="Form__Button">
                                                    <button class="Button Send"
                                                            type="submit">@lang("updateData")</button>
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
        <div class="Popup Popup--Dark" data-name="UpdateWork">
            <div class="Popup__Content">
                <div class="Popup__Card">
                    <i class="material-icons Popup__Close">close</i>
                    <div class="Popup__CardContent">
                        <div class="Popup__Inner">
                            <h3 class="Popup__Title">
                                <span class="Title">@lang("updateProfile")</span>
                            </h3>
                            <div class="Popup__Body">
                                <form class="Form Form--Dark"
                                      action="{{$IsVisitor ? route("users.update",$user->id) : route("profile.update")}}"
                                      method="post"
                                >
                                    @csrf
                                    <div class="Row GapC-1-5">
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Select">
                                                    <div class="Select__Area">
                                                        @include("System.Components.selector" , [
                                                            'Name' => "Department" , "Required" => "true" ,
                                                            "DefaultValue" => "" , "Label" => "Department" ,
                                                            "Options" => [ ["Label" => "Computer Science" , "Value" => "1"]]
                                                        ])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Select">
                                                    <div class="Select__Area">
                                                        @include("System.Components.selector" , [
                                                            'Name' => "JobPosition" , "Required" => "true" ,
                                                            "DefaultValue" => "" , "Label" => "Job Position" ,
                                                            "Options" => [ ["Label" => "IT" , "Value" => "1"]]
                                                        ])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Date">
                                                    <div class="Date__Area">
                                                        <input id="BeginningContract" class="Date__Field"
                                                               type="text" name="BeginningContract"
                                                               placeholder="Beginning Contract">
                                                        <label class="Date__Label" for="BeginningContract">Beginning Contract</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Select">
                                                    <div class="Select__Area">
                                                        @include("System.Components.selector" , [
                                                            'Name' => "ContractDuration" , "Required" => "true" ,
                                                            "DefaultValue" => "" , "Label" => "Contract Duration" ,
                                                            "Options" => [ ["Label" => "3 Month" , "Value" => "1"] ,
                                                                           ["Label" => "6 Month" , "Value" => "1"] ,
                                                                           ["Label" => "1 Year" , "Value" => "1"] ,
                                                                           ["Label" => "2 Year" , "Value" => "1"] ,
                                                                           ["Label" => "3 Year" , "Value" => "1"] ,
                                                                           ["Label" => "4 Year" , "Value" => "1"] ,
                                                                           ["Label" => "5 Year" , "Value" => "1"] ]
                                                        ])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col">
                                            <div class="Form__Group">
                                                <div class="Form__Button">
                                                    <button class="Button Send"
                                                            type="submit">@lang("updateData")</button>
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
    @endif
    @if($IsHavePermissionDelete)
        <div class="Popup Popup--Dark" data-name="DeleteAccount">
            <div class="Popup__Content">
                <div class="Popup__Card">
                    <i class="material-icons Popup__Close">close</i>
                    <div class="Popup__CardContent">
                        <div class="Popup__Inner">
                            <h3 class="Popup__Title">
                                <span class="Title">@lang("deleteAccount")</span>
                            </h3>
                            <div class="Popup__Body">
                                <form class="Form Form--Dark"
                                      action="{{route("users.destroy",$user->id)}}"
                                      method="post">
                                    @method('delete')
                                    @csrf
                                    <div class="Row">
                                        <div class="Col">
                                            <p class="Center">@lang("SureDeleteAccountMessage")</p>
                                        </div>
                                        <div class="Col">
                                            <div class="Form__Group">
                                                <div class="Form__Button Center">
                                                    <button class="Button Cancel"
                                                            type="submit">@lang("deleteAccount")</button>
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
    @endif
    @if($IsHavePermissionReadUser && $IsHavePermissionEditUser)
        <div class="Popup Popup--Dark" data-name="UpdateSocialMedia">
            <div class="Popup__Content">
                <div class="Popup__Card">
                    <i class="material-icons Popup__Close">close</i>
                    <div class="Popup__CardContent">
                        <div class="Popup__Inner">
                            <h3 class="Popup__Title">
                                <span class="Title">@lang("updateProfile")</span>
                            </h3>
                            <div class="Popup__Body">
                                <form class="Form Form--Dark"
                                      action="{{$IsVisitor ? route("users.update",$user->id) : route("profile.update")}}"
                                      method="post">
                                    @csrf
                                    <div class="Row GapC-1-5">
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Select">
                                                    <div class="Select__Area">
                                                        @include("System.Components.selector" , [
                                                            'Name' => "SocialMedia_1" , "Required" => "true" ,
                                                            "DefaultValue" => "FaceBook" , "Label" => "Social Media" ,
                                                            "Options" => [ ["Label" => "Facebook" , "Value" => "1"] ,
                                                                           ["Label" => "Whatsapp" , "Value" => "1"] ,
                                                                           ["Label" => "Linkedin" , "Value" => "1"] ,
                                                                           ["Label" => "Google +" , "Value" => "1"] ]
                                                        ])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Input">
                                                    <div class="Input__Area">
                                                        <input id="SocialName_1" class="Input__Field"
                                                               type="text" name="SocialName_1"
                                                               placeholder="Social Name">
                                                        <label class="Input__Label" for="SocialName_1">Social Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col-6-md">
                                            <div class="Form__Group">
                                                <div class="Form__Select">
                                                    <div class="Select__Area">
                                                        @include("System.Components.selector" , [
                                                            'Name' => "SocialMedia_2" , "Required" => "true" ,
                                                            "DefaultValue" => "" , "Label" => "Social Media" ,
                                                            "Options" => [ ["Label" => "Facebook" , "Value" => "1"] ,
                                                                           ["Label" => "Whatsapp" , "Value" => "1"] ,
                                                                           ["Label" => "Linkedin" , "Value" => "1"] ,
                                                                           ["Label" => "Google +" , "Value" => "1"] ,
                                                                           ["Label" => "Facebook" , "Value" => "1"]]
                                                        ])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Col">
                                            <div class="Form__Group">
                                                <div class="Form__Button">
                                                    <button class="Button Send"
                                                            type="submit">@lang("updateData")</button>
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
    @endif
@endsection
