@extends("System.master")

@section("MainContent")
    {{--  Main Content  --}}
    <main class="MainContent">
        <section class="MainContent__Section MainContent__Section--Message">
            <div class="MessagePage MessagePage--404">
                <div class="Container--MainContent">
                    <div class="MessagePage__Content">
                        <img src="{{@asset("System/Assets/Images/404.jpg")}}"
                             alt="Coming Soon" class="MessagePage__Image" />
                        <div class="MessagePage__Description">
                            <p>
                                @lang("404Message")
                            </p>
                            <a class="Button Button--Primary" href="{{route("home")}}">
                                @lang("backToHome")
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
