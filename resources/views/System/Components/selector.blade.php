<div class="Selector {{$Size ?? ""}}"
     data-name="{{$Name}}" data-selected="{{$DefaultValue ?? ""}}"
     data-required="{{$Required ?? ""}}">
    <div class="Selector__Main">
        <div class="Selector__WordLabel">{{$Label}}</div>
        <div class="Selector__WordChoose"></div>
        <i class="material-icons Selector__Arrow">
            keyboard_arrow_down
        </i>
    </div>
    @if(isset($OptionsValues))
        <ul class="Selector__Options">
            @foreach($OptionsValues as $value => $lable)
                <li class="Selector__Option"
                    data-option="{{$value}}">
                    {{$lable}}
                </li>
            @endforeach
        </ul>
    @elseif(isset($Options))
        <ul class="Selector__Options">
            @foreach($Options as $Option)
                <li class="Selector__Option"
                    data-option="{{$Option["Value"]}}">
                    {{$Option["Label"]}}
                </li>
            @endforeach
        </ul>
    @endif
</div>
