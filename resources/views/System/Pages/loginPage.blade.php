@extends("System.master")


@section("MainContent")
    <main class="MainContent">
        <section class="MainContent__Section MainContent__Section--Login">
            <div class="AuthenticationPage">
                <div class="AuthenticationPage__Wrap">
                    <div class="AuthenticationPage__Content">
                        <div class="AuthenticationPage__ImagePage">
                            <img src="{{asset("System/Assets/Images/Login.jpg")}}" alt="" />
                        </div>
                        <div class="AuthenticationPage__LoginForm">
                            <div class="Content">
                                <div class="AuthenticationPage__Logo">
                                    <div class="Logo">
                                        <a>
                                            <img src="{{asset("System/Assets/Images/Logo.png")}}"
                                                 alt="#" class="Logo__Image">
                                        </a>
                                    </div>
                                </div>
                                <div class="AuthenticationPage__Text">
                                    <h2 class="AuthenticationPage__Title">@lang("welcomeSystem")</h2>
                                    <p class="AuthenticationPage__Summery">
                                        @lang("titleSystem")
                                    </p>
                                </div>
                                <div class="AuthenticationPage__Form">
                                    <h2 class="AuthenticationPage__Title">@lang("signin")</h2>
                                    <form class="Form Form--Dark" id="AuthenticationForm"
                                          action="{{route('login')}}" method="post">
                                        @csrf
                                        <div class="Row">
                                            <div class="Col">
                                                <div class="Form__Group"
                                                     data-ErrorBackend="{{ Errors("email") }}">
                                                    <div class="Form__Input">
                                                        <div class="Input__Area">
                                                            <input id="email" class="Input__Field" type="email"
                                                                   name="email" required
                                                                   placeholder="@lang("email")">
                                                            <label class="Input__Label" for="email">@lang("email")</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="Col">
                                                <div class="Form__Group"
                                                     data-ErrorBackend="{{ Errors("password") }}">
                                                    <div class="Form__Input Form__Input--Password">
                                                        <div class="Input__Area">
                                                            <input id="Password" class="Input__Field"
                                                                   type="password" name="password"
                                                                   placeholder="@lang("password")" required>
                                                            <label class="Input__Label" for="Password">@lang("password")</label>
                                                            <i class="material-icons Input__Icon">visibility</i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="Col-6-xs">
                                                <div class="Form__Group"
                                                     data-ErrorBackend="{{ Errors("remember") }}">
                                                    <div class="Form__CheckBox">
                                                        <div class="CheckBox__Area">
                                                            <input type="checkbox" id="RememberMe"
                                                                   name="remember"
                                                                   class="CheckBox__Input">
                                                            <label class="CheckBox__Label" for="RememberMe">
                                                            <span class="IconChecked">
                                                                <i class="material-icons ">
                                                                    check_small
                                                                </i>
                                                            </span>
                                                                <span class="TextCheckBox">@lang("rememberMe")</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="Col">
                                                <div class="Form__Group">
                                                    <div class="Form__Button">
                                                        <button class="Button Send"
                                                                type="submit">@lang("loginSystem")</button>
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
        </section>
    </main>
@endsection
