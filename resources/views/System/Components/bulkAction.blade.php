<div class="BulkTools">
    <div class="Form Form--Dark">
        <div class="Form__Group">
            <div class="Form__Select">
                <div class="Select__Area">
                    <div class="Selector Selected Size-2"
                         data-name="BulkAction" data-required="false">
                        <div class="Selector__Main">
                            <div class="Selector__WordChoose">@lang("bulkAction")</div>
                            <i class="material-icons Selector__Arrow">
                                keyboard_arrow_down
                            </i>
                        </div>
                        <ul class="Selector__Options">
                            @foreach($Options as $Option)
                                <li class="Selector__Option"
                                    data-action="{{$Option['Action']}}"
                                    data-method="{{$Option['Method']}}">
                                    {{$Option['Label']}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="Form__Group">
            <div class="Form__Button">
                <button class="Button Send Size-2"
                        type="submit">@lang("apply")</button>
            </div>
        </div>
    </div>
</div>

{{--
    $Options => [action , method , label][]
--}}
