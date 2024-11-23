<header class="HeaderPage OpenMenu">
    <div class="HeaderPage__Wrap">
        <div class="Container--Header">
            <div class="HeaderPage__Content">
                <div class="HeaderPage__MenusOpening">
                    <div class="MenusOpening">
                        <div class="MenuIcon">
                            <i class="material-icons IconClick">menu</i>
                        </div>
                        <div class="Logo">
                            <a href="#" title="ERP Epic">
                                <img src="{{asset("System/Assets/Images/Logo.png")}}"
                                     alt="#" class="Logo__Image">
                                <span class="Logo__SystemName">ERP Epic</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="HeaderPage__AccountAlerts">
                    <div class="AccountAlerts">
                        <ul class="Alerts">
                            <li class="Alert Alert--themeMode">
                                <i class="material-icons IconClick">dark_mode</i>
                            </li>
                            <li class="Alert Alert--Notification">
                                <i class="material-icons IconClick">
                                    notifications
                                </i>
                                <div class="Dropdown NotificationParent">
                                    <div class="Dropdown__Header">
                                        <h3 class="Title">@lang("notification")</h3>
                                        <span class="ReadAll">
                                            @lang("markRead")
                                        </span>
                                    </div>
                                    <ul class="NotificationParent__List Dropdown__Content">
                                        @php
                                          $notifications = auth()->user()->notifications()->whereNot("data->type","audit")->latest()->get();
                                        @endphp
                                        @if(count($notifications) > 0)
                                            @foreach($notifications as $NotificationItem)
                                                <li class="Dropdown__Item Notification"
                                                    data-NotificationID="{{ $NotificationItem["id"] }}">
                                                    <div class="Notification__Content">
                                                        @php
                                                            $NotificationObject = GetNotificationIcon($NotificationItem["data"]["type"]) ;
                                                            $ArrayBodyNotification = explode("@@@@",$NotificationItem["data"]["data"]["body"]) ;
                                                        @endphp
                                                        <a href="{{ $NotificationItem["data"]["data"]["route_name"] }}"
                                                           class="Notification__Icon Notification__Icon--{{ $NotificationObject->Color }}">
                                                            <i class="material-icons">
                                                                {{ $NotificationObject->Icon }}
                                                            </i>
                                                        </a>
                                                        <a href="{{ $NotificationItem["data"]["data"]["route_name"] }}"
                                                           class="Notification__Details">
                                                            <p class="NotificationTitle">
                                                                @lang("ofPage")
                                                                <span class="UserFrom">
                                                                    <strong>
                                                                        {{ $NotificationItem["data"]["data"]["from"] }}
                                                                    </strong>
                                                                </span> ,
                                                                @lang($NotificationItem["data"]["type"])
                                                            </p>
                                                            <p class="NotificationDescription">
                                                                @lang($ArrayBodyNotification[0]) .
                                                            </p>
                                                            <p class="NotificationDate">
                                                                {{ \Carbon\Carbon::parse($NotificationItem["data"]["data"]["date"])->format("Y-m-d H:m") }}
                                                            </p>
                                                        </a>
                                                        <div class="Notification__Remove">
                                                            <i class="material-icons">close</i>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="NoData--V2">
                                                <div class="Icon">
                                                    <i class="material-icons">
                                                        sentiment_dissatisfied
                                                    </i>
                                                </div>
                                                <div class="Text">
                                                    @lang("noNotification")
                                                </div>
                                            </li>
                                        @endif
{{--                                        <li class="Dropdown__Item">--}}
{{--                                            <div class="Notification">--}}
{{--                                                <div class="Notification__Content">--}}
{{--                                                    <a href="#"--}}
{{--                                                       class="Notification__Icon Notification__Icon--Send">--}}
{{--                                                        <i class="material-icons">description</i>--}}
{{--                                                    </a>--}}
{{--                                                    <a href="#"--}}
{{--                                                       class="Notification__Details">--}}
{{--                                                        <p class="NotificationTitle">--}}
{{--                                                            Please check your mail--}}
{{--                                                        </p>--}}
{{--                                                        <p class="NotificationDescription">--}}
{{--                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.--}}
{{--                                                        </p>--}}
{{--                                                        <p class="NotificationDate">2hr ago</p>--}}
{{--                                                    </a>--}}
{{--                                                    <div class="Notification__Remove">--}}
{{--                                                        <i class="material-icons">close</i>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}
                                    </ul>
                                    <div class="Dropdown__Footer">
                                        <a href="{{route("notifications.show")}}" title="View All Notification">
                                            @lang("viewNotification")
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="Alert Alert--Language">
                                <i class="material-icons IconClick">language</i>
                                <div class="Dropdown">
                                    <ul class="Dropdown__Content">
                                        <li class="Dropdown__Item">
                                            <a href="{{route("lang.change","en")}}">@lang("english")</a>
                                        </li>
                                        <li class="Dropdown__Item">
                                            <a href="{{route("lang.change","ar")}}">@lang("arabic")</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <div class="UserImage">
                            @if(auth()->user()->image)
                                <img src="{{PathStorage(auth()->user()->image)}}" alt="UserImage">
                            @else
                                <img src="{{asset("System/Assets/Images/Avatar.jpg")}}" alt="UserImage">
                            @endif
                            <div class="Dropdown">
                                <div class="Dropdown__Header">
                                    <div class="UserImage">
                                        @if(auth()->user()->image)
                                            <img src="{{PathStorage(auth()->user()->image)}}" alt="#">
                                        @else
                                            <img src="{{asset("System/Assets/Images/Avatar.jpg")}}" alt="#">
                                        @endif
                                    </div>
                                    <div class="UserDetails">
                                        <div class="UserName">
                                            {{auth()->user()->name}}
                                        </div>
                                        <div class="UserEmail">
                                            {{auth()->user()->email}}
                                        </div>
                                    </div>
                                </div>
                                <ul class="Dropdown__Content">
                                    <li class="Dropdown__Item">
                                        <a href="{{route("profile.show")}}">
                                            <i class="material-icons">
                                                person
                                            </i>
                                            <span>@lang("viewProfile")</span>
                                        </a>
                                    </li>
                                    <li class="Dropdown__Item">
                                        <a class="AnchorSubmit"
                                           data-form="logOutSystem">
                                            <i class="material-icons">
                                                logout
                                            </i>
                                            <span>@lang("signout")</span>
                                        </a>
                                        <form action="{{route("logout")}}"
                                              class="logoutForm"
                                              name="logOutSystem" method="post">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
