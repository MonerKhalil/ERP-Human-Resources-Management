@extends("System.master")

@section("MainContent")
    {{--  Main Header  --}}
    <header class="HeaderPage HeaderPage--Print">
        <div class="HeaderPage__Wrap">
            <div class="Container--Header">
                <div class="HeaderPage__Content">
                    <div class="HeaderPage__MenusOpening">
                        <div class="MenusOpening">
                            <div class="Logo">
                                <a href="#" title="ERP Epic">
                                    <img src="{{asset("System/Assets/Images/Logo.png")}}"
                                         alt="#" class="Logo__Image">
                                    <span class="Logo__SystemName">ERP Epic</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    {{--  Main Content  --}}
    <main class="MainContent">
        <section class="MainContent__Section MainContent__Section--Print">
            <div class="PrintPage">
                <div class="ViewUsers__Breadcrumb">
                    @include('System.Components.breadcrumb' , [
                        'mainTitle' => __("printInformation") ,
                        'summery' => __("titlePrintInformation")
                    ])
                </div>
                <div class="PrintPage__Content">
                    <div class="Container--MainContent">
                        <div class="Row">
                            <div class="Col">
                                <div class="Card ViewUsers__TableUsers">
                                    <div class="Table">
                                        <div class="Card__Inner p0">
                                            <div class="Table__ContentList">
                                                <div class="Table__List">
                                                    <div class="Item HeaderList">
                                                        <div class="Item__Col"><span>User</span></div>
                                                        <div class="Item__Col">ID</div>
                                                        <div class="Item__Col"><span>Email</span></div>
                                                        <div class="Item__Col"><span>Create Date</span></div>
                                                    </div>
                                                    <div class="Item DataItem">
                                                        <div class="Item__Col">Amir Ho</div>
                                                        <div class="Item__Col">123</div>
                                                        <div class="Item__Col">example@example.com</div>
                                                        <div class="Item__Col">10-2-2023</div>
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
    </main>
    {{--  Footer  --}}
    <footer class="FooterPage FooterPage--Print">
        <div class="FooterPage__Wrap">
            <div class="Container--MainContent">
                <div class="FooterPage__Content">
                    <div class="Row m0">
                        <div class="Col-6-xs">
                            <div class="FooterPage__CopyRight">
                                Copyright © 2022
                            </div>
                        </div>
                        <div class="Col-6-xs">
                            <div class="FooterPage__Links">
                                Designed by <span class="SystemName"> ERP Epic </span> All rights reserved
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

@endsection
