@extends("System.master")

@section("MainContent")
    {{--  Main Content  --}}
    <main class="MainContent">
        <section class="MainContent__Section MainContent__Section--Message">
            <div class="MessagePage MessagePage--ComingSoon">
                <div class="Container--MainContent">
                    <div class="MessagePage__Content">
                        <img src="{{@asset("System/Assets/Images/ComingSoon.jpg")}}"
                             alt="Coming Soon" class="MessagePage__Image" />
                        <div class="MessagePage__Title">
                            <h2>@lang("comingSoon")</h2>
                        </div>
                        <div class="MessagePage__Description">
                            @lang("comingSoonMessage")
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
