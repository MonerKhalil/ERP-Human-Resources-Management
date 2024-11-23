<table>
    <thead>
    <tr>
        @foreach($data['head'] as $value)
            @if(is_array($value) && isset($value['head']))
                <th class="text-center">{{__($value['head'])}}</th>
            @else
                <th class="text-center">{{__($value)}}</th>
            @endif
        @endforeach
        @if(isset($dataSelected['from_salary'])||isset($dataSelected['salary']))
            <th class="text-center">{{__("salary")}}</th>
        @endif
        @if(isset($dataSelected['languages']))
            <th class="text-center">{{__("languages")}}</th>
        @endif
        @if(isset($dataSelected['education_level_id']))
            <th class="text-center">{{__("education_data")}}</th>
        @endif
        @if(isset($dataSelected['position_id']))
            <th class="text-center">{{__("position")}}</th>
        @endif
        @if(isset($dataSelected['type_decision_id']))
            <th class="text-center">{{__("type_decision")}}</th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($data['body'] as $item)
        <tr>
            @foreach($data['head'] as $value)
                @if(is_array($value) && isset($value['head']))
                    <td class="text-center">{{ $item->{$value['relationFunc']}->{$value['key']} }}</td>
                @else
                    <td class="text-center">{{ $item->{$value} }}</td>
                @endif
            @endforeach
            @if(isset($dataSelected['from_salary'])||isset($dataSelected['salary']))
                <td class="text-center">{{ $item->contract()->latest()->first()->salary ?? "-"}}</td>
            @endif
            @if(isset($dataSelected['languages']))
                <td class="text-center">
                  <table>
            <thead>
                <tr>
                    <th class="text-center">{{__("language")}}</th>
                    <th class="text-center">{{__("read_skill")}}</th>
                    <th class="text-center">{{__("write_skill")}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($item->language_skill as $language)
                    <tr>
                        <td class="text-center">{{$language->language->name,}}</td>
                        <td class="text-center">{{$language->read}}</td>
                        <td class="text-center">{{$language->write}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
                 </td>
            @endif
            @if(isset($dataSelected['education_level_id']))
                <td class="text-center">
                        <table>
                            <thead>
                            <tr>
                                <th class="text-center">{{__("education_level")}}</th>
                                <th class="text-center">{{__("grant_date")}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($item->education_data as $val)
                                <tr>
                                    <td class="text-center">{{$val->education_level->name,}}</td>
                                    <td class="text-center">{{$val->grant_date}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                </td>
            @endif
            @if(isset($dataSelected['position_id']))
                <td class="text-center">
                        <table>
                            <thead>
                            <tr>
                                <th class="text-center">{{__("position_name")}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($item->positions as $val)
                                <tr>
                                    <td class="text-center">{{$val->name,}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                </td>
            @endif
            @if(isset($dataSelected['type_decision_id']))
                <td class="text-center">
                        <table>
                            <thead>
                            <tr>
                                <th class="text-center">{{__("type_decision")}}</th>
                                <th class="text-center">{{__("date")}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($item->decision_employees as $val)
                                <tr>
                                    <td class="text-center">{{$val->type_decision->name,}}</td>
                                    <td class="text-center">{{$val->date,}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                </td>
            @endif
    </tr>
    @endforeach
    </tbody>
</table>
