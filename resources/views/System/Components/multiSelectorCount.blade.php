<div class="MultiSelector">
    <div class="MultiSelector__Main">
        <div class="MultiSelector__WordLabel">{{$Label}}</div>
        <div class="MultiSelector__WordChoose"></div>
        <i class="material-icons MultiSelector__Arrow">
            keyboard_arrow_down
        </i>
    </div>
    @if(isset($Options))
        @php
            $Counter = 0 ;
        @endphp
        <ul class="MultiSelector__Options">
            @foreach($Options as $Option)
                <li class="MultiSelector__Option">
                    <input id="{{$NameIDs}}_{{$Counter}}" name="{{$Option['Name']}}[{{$Counter}}]"
                           class="MultiSelector__InputCheckBox"
{{--                           @if(isset($Required)) required @endif--}}
                           type="checkbox" value="{{$Option['Value']}}"
                           {{isset($Option['IsChecked']) && $Option['IsChecked'] ? "checked" : ""}}
                           hidden>
                    <label for="{{$NameIDs}}_{{$Counter}}" class="MultiSelector__Label">
                        <span class="MultiSelector__CheckBox">
                            <i class="material-icons ">
                                check_small
                            </i>
                        </span>
                        <span class="MultiSelector__Title">{{$Option['Label']}}</span>
                    </label>
                </li>
                @php
                    $Counter++ ;
                @endphp
            @endforeach
        </ul>
    @endif
</div>
