<!DOCTYPE HTML>
<html lang="{{app()->getLocale()}}">
<head>
    <title>{{ "Employee Report" }}</title>
</head>
<body>
<div class="d-flex justify-content-center profile-container">
    <div class='col-md-10 text-center sort-profile' id='sort-profile'>
        <div class='row'>
            <div class='col-md-12 text-center' >
                <table class='table table-light table-striped table-bordered' id='excel-table' style="background-color: transparent; border:2px solid black; margin-top:15px;">
                    <tr>
                        @foreach($data['head'] as $value)
                            @if(is_array($value) && isset($value['head']))
                                <th class="text-center">{{$value['head']}}</th>
                            @else
                                <th class="text-center">{{$value}}</th>
                            @endif
                        @endforeach
                        @if(isset($dataSelected['from_salary'])||isset($dataSelected['salary']))
                            <th class="text-center">{{__("salary")}}</th>
                        @endif
                        @if(isset($dataSelected['education_level_id']))
                            <th class="text-center">{{__("education_data")}}</th>
                        @endif
                        @if(isset($dataSelected['membership_type_id']))
                            <th class="text-center">{{__("membership")}}</th>
                        @endif
                        @if(isset($dataSelected['position_id']))
                            <th class="text-center">{{__("position")}}</th>
                        @endif
                    </tr>
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
                                <td class="text-center">{{ $item->contract()->first()->salary ?? "-"}}</td>
                            @endif
                            @if(isset($dataSelected['education_level_id']))
                                <td class="text-center">{{ "education_level : " .$item->education_data()->first()->education_level->name ?? "-"." ,grant_date: " . $item->education_data()->first()->education_level->grant_date ?? "-"}}</td>
                            @endif
                            @if(isset($dataSelected['membership_type_id']))
                                <td class="text-center">{{ "membership : " .$item->membership()->first()->membership_type->name ?? "-"." ,date_start: " . $item->membership()->first()->membership_type->date_start ?? "-"}}</td>
                            @endif
                            @if(isset($dataSelected['position_id']))
                                <td class="text-center">{{ "position : " .$item->positions()->first()->name ?? "-"." ,date_start: " . $item->membership()->first()->membership_type->date_start ?? "-"}}</td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
