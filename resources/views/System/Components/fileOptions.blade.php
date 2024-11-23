<div class="Popup Popup--Dark PrintPopup" data-name="PrintTable">
    <div class="Popup__Content">
        <div class="Popup__Card">
            <i class="material-icons Popup__Close">close</i>
            <div class="Popup__CardContent">
                <div class="Popup__InnerGroup">
                    <form class="Form Form--Dark" action="#" method="post">
                        @csrf
                        <h3 class="Popup__Title">
                            <span class="Title">Type Print</span>
                        </h3>
                        <div class="Popup__Body">
                            <div class="PrintPopup__Options">
                                <div class="Row">
                                    <div class="Col-6-md">
                                        <button class="Button PrintPopup__PDF">
                                            <img src="{{asset("System/Assets/Images/pdf.png")}}" alt="PDF Print">
                                        </button>
                                    </div>
                                    <div class="Col-6-md">
                                        <button class="Button PrintPopup__Excel">
                                            <img src="{{asset("System/Assets/Images/sheets.png")}}" alt="Excel Print">
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
