@extends("System.master")

@section("MainContent")
    {{--  Main Content  --}}
    <main class="MainContent">
        <section class="MainContent__Section MainContent__Section--Message">
            <div class="MessagePage MessagePage--ComingSoon">
                <div class="Container--MainContent">
                    <div class="MessagePage__Content">
                        <img src="{{@asset("System/Assets/Images/Logout.jpg")}}"
                             alt="Coming Soon" class="MessagePage__Image" />
                        <div class="MessagePage__Title">
                            <h2>You are Logged Out</h2>
                        </div>
                        <div class="MessagePage__Description">
                            <p>Thank you for using ERP Epic , Have a good day</p>
                            <div class="Row">
                                <div class="Col">
                                    <a class="Button Button--Primary"
                                       href="{{route("login")}}">Login if you forget something</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
