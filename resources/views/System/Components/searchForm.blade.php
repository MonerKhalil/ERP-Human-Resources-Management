<div class="Popup Popup--Dark" data-name="SearchAbout">
    <div class="Popup__Content">
        <div class="Popup__Card">
            <i class="material-icons Popup__Close">close</i>
            <div class="Popup__CardContent">
                <div class="Popup__InnerGroup">
                    @if(isset($InfoForm))
                        <form class="Form Form--Dark"
                              action="{{$InfoForm['Route']}}"
                              method="{{$InfoForm['Method']}}">
                            @csrf
                            @if(isset($SearchForm))
                                <div class="Popup__Inner">
                                    <h3 class="Popup__Title">
                                        <span class="Title">@lang("search")</span>
                                    </h3>
                                    <div class="Popup__Body">
                                        <div class="Row GapC-1-5">
                                            <div class="Col">
                                                <div class="Form__Group">
                                                    <div class="Form__Input">
                                                        <div class="Input__Area">
                                                            <input id="SearchField" class="Input__Field"
                                                                   type="text" name="{{$SearchForm['Name']}}"
                                                                   placeholder="{{$SearchForm['Placeholder']}}">
                                                            <label class="Input__Label" for="SearchField">{{$SearchForm['Placeholder']}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(isset($FilterForm))
                                <?php
                                $Counter = 0 ;
                                ?>
                                <div class="Popup__Inner">
                                    <h3 class="Popup__Title">
                                        <span class="Title">@lang("filter")</span>
                                    </h3>
                                    <div class="Popup__Body">
                                        <div class="Row GapC-1-5">
                                            @foreach($FilterForm as $Field)
                                                @if($Field["Type"] == "text" || $Field["Type"] == "email"
                                                    || $Field["Type"] == "number")
                                                    <div class="Col-6-md">
                                                        <div class="Form__Group">
                                                            <div class="Form__Input">
                                                                <div class="Input__Area">
                                                                    <input id="{{"Input".$Counter}}"
                                                                           class="Input__Field"
                                                                           type="{{$Field["Type"]}}"
                                                                           name="{{$Field["Info"]["Name"]}}"
                                                                           placeholder="{{$Field["Info"]["Placeholder"]}}"
                                                                           @if(isset($Field["Info"]["Value"]))
                                                                           value="{{$Field["Info"]["Value"]}}"
                                                                           @endif
                                                                           @if(isset($Field["Info"]["Required"]))
                                                                           required
                                                                            @endif>
                                                                    <label class="Input__Label"
                                                                           for="{{"Input".$Counter}}">{{$Field["Info"]["Placeholder"]}}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($Field["Type"] == "select")
                                                    <div class="Col-6-md">
                                                        <div class="Form__Group">
                                                            <div class="Form__Select">
                                                                <div class="Select__Area">
                                                                    <div class="Selector"
                                                                         data-name="{{$Field["Info"]["Name"]}}"
                                                                         data-selected="{{$Field["Info"]["Value"] ?? ""}}"
                                                                         @if(isset($Field["Info"]["Required"]))
                                                                         data-required="true"
                                                                        @endif>
                                                                        <div class="Selector__Main">
                                                                            <div class="Selector__WordLabel">
                                                                                {{$Field["Info"]["Placeholder"] ?? ""}}
                                                                            </div>
                                                                            <div class="Selector__WordChoose">
                                                                                {{$Field["Info"]["Value"] ?? ""}}
                                                                            </div>
                                                                            <i class="material-icons Selector__Arrow">
                                                                                keyboard_arrow_down
                                                                            </i>
                                                                        </div>
                                                                        <ul class="Selector__Options">
                                                                            @foreach($Field["Info"]["Options"] as $Option)
                                                                                <li class="Selector__Option"
                                                                                    data-option="{{$Option["Value"]}}"
                                                                                >{{$Option["Label"]}}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($Field["Type"] == "dateRange")
                                                    <div class="Col-6-md">
                                                        <div class="Form__Group">
                                                            <div class="Form__Date">
                                                                <div class="Date__Area">
                                                                    <input id="{{"Input".$Counter}}" class="RangeData Date__Field"
                                                                           type="text" placeholder="{{$Field["Info"]["Placeholder"]}}"
                                                                           date-StartDateName="{{$Field["Info"]["StartDateName"]}}"
                                                                           date-EndDateName="{{$Field["Info"]["EndDateName"]}}"
                                                                           @if(isset($Field["Info"]["Value"]))
                                                                           value="{{$Field["Info"]["Value"]}}"
                                                                           @endif
                                                                           @if(isset($Field["Info"]["Required"]))
                                                                           required
                                                                        @endif
                                                                    >
                                                                    <label class="Date__Label"
                                                                           for="{{"Input".$Counter}}">{{$Field["Info"]["Placeholder"]}}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($Field["Type"] == "dateSingle")
                                                        <div class="Col-6-md">
                                                            <div class="Form__Group">
                                                                <div class="Form__Date">
                                                                    <div class="Date__Area">
                                                                        <input id="{{"Input".$Counter}}" class="Date__Field"
                                                                               type="text" name="{{$Field["Info"]["Name"]}}"
                                                                               placeholder="{{$Field["Info"]["Placeholder"]}}"
                                                                               @if(isset($Field["Info"]["Value"]))
                                                                               value="{{$Field["Info"]["Value"]}}"
                                                                               @endif
                                                                               @if(isset($Field["Info"]["Required"]))
                                                                               required
                                                                            @endif
                                                                        >
                                                                        <label class="Date__Label"
                                                                               for="{{"Input".$Counter}}">{{$Field["Info"]["Placeholder"]}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($Field["Type"] == "NormalTime")
                                                        <div class="Col-6-md">
                                                            <div class="Form__Group">
                                                                <div class="Form__Date">
                                                                    <div class="Date__Area">
                                                                        <input id="{{"Input".$Counter}}" class="TimeNoDate Date__Field"
                                                                               type="time" name="{{$Field["Info"]["Name"]}}"
                                                                               placeholder="{{$Field["Info"]["Placeholder"]}}"
                                                                               @if(isset($Field["Info"]["Value"]))
                                                                                    value="{{$Field["Info"]["Value"]}}"
                                                                               @endif
                                                                               @if(isset($Field["Info"]["Required"]))
                                                                               required
                                                                            @endif
                                                                        >
                                                                        <label class="Date__Label"
                                                                               for="{{"Input".$Counter}}">{{$Field["Info"]["Placeholder"]}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($Field["Type"] == "NormalMultiSelector")
                                                        <div class="Col-6-md">
                                                            <div class="Form__Group">
                                                                <div class="Form__Date">
                                                                    <div class="Date__Area">
                                                                        @include("System.Components.multiSelector" , [
                                                                            'Name' => "_" , "NameIDs" => $Field["Info"]["NameIDs"] ,
                                                                            "Label" => $Field["Info"]["Label"] ,
                                                                            "Options" => $Field["Info"]["Options"]
                                                                        ])
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                <?php $Counter++?>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="Popup__Inner">
                                <div class="Popup__Body">
                                    <div class="Row">
                                        <div class="Col">
                                            <div class="Form__Group">
                                                <div class="Form__Button">
                                                    <button class="Button Send"
                                                            type="submit">@lang("filter")</button>
                                                    <button class="RestButton Button Clear"
                                                            type="button">@lang("clean")</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
