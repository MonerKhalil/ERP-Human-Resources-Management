@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--Notification">
        <div class="NotificationPage">
            <div class="NotificationPage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __("notification") ,
                    'paths' => [[__("home") , '#'] , [__("notification")]] ,
                    'summery' => __("titleNotificationPage")
                ])
            </div>
            <div class="NotificationPage__Content">
                <div class="Row">
                    <div class="Container--MainContent">
                        <div class="Row Justify-Content-Center">
                            <div class="Col">
                                <div class="Card Overflow-Hidden">
                                    <div class="Card__Content">
                                        <div class="Card__InnerGroup NotificationParent">
                                            <div class="Card__Inner">
                                                <div class="NotificationPage__Buttons">
                                                    <form action="{{route("notifications.clear")}}"
                                                          method="post">
                                                        @csrf
                                                        @method("delete")
                                                        <button type="submit"
                                                                class="Button Button--Primary">
                                                            @lang("clean")
                                                        </button>
                                                    </form>
                                                    <button class="ReadAll Button Button--Primary">
                                                        @lang("readAll")
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="Card__Inner p0">
                                                <ul class="NotificationParent__List NotificationPage__NotificationList">
                                                    @if(count($data) > 0)
                                                        @foreach($data as $NotificationItem)
                                                            <li class="NotificationPage__Notification Notification"
                                                                data-NotificationID="{{ $NotificationItem["id"] }}">
                                                                <div class="Card__Inner">
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
                                                                                @lang($NotificationItem["data"]["type"]).
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

{{--                                                    <li class="NotificationPage__Notification Notification">--}}
{{--                                                        <div class="Card__Inner">--}}
{{--                                                            <div class="Notification__Content">--}}
{{--                                                                <a href="#"--}}
{{--                                                                   class="Notification__Icon Notification__Icon--Send">--}}
{{--                                                                    <i class="material-icons">description</i>--}}
{{--                                                                </a>--}}
{{--                                                                <a href="#"--}}
{{--                                                                   class="Notification__Details">--}}
{{--                                                                    <p class="NotificationTitle">--}}
{{--                                                                        Please check your mail--}}
{{--                                                                    </p>--}}
{{--                                                                    <p class="NotificationDescription">--}}
{{--                                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.--}}
{{--                                                                    </p>--}}
{{--                                                                    <p class="NotificationDate">2hr ago</p>--}}
{{--                                                                </a>--}}
{{--                                                                <div class="Notification__Remove">--}}
{{--                                                                    <i class="material-icons">close</i>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </li>--}}
                                                </ul>
                                            </div>
                                            <div class="Card__Inner">
                                                <div class="Card__Pagination">
                                                    @include("System.Components.paginationNum" , [
                                                    "PaginationData" => $data ,
                                                    "PartsViewNum" => 5
                                                    ])
                                                    @include("System.Components.paginationSelect" , [
                                                        "PaginationData" => $data
                                                    ])
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
@endsection
