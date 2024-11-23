<!DOCTYPE HTML>
<html lang="{{app()->getLocale()}}">
<head>
    <title>{{ $title ?? "Table Xlsx"}}</title>
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
                    </tr>
                    @foreach($data['body'] as $item)
                        <tr>
                            @foreach($data['head'] as $value)
                                @if(is_array($value) && isset($value['head']))
                                    <td class="text-center">{{ $item->{$value['relationFunc']}->{$value['key']} ?? "-" }}</td>
                                @else
                                    <td class="text-center">{{ $item->{$value} ?? "-" }}</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <hr/>
    </div>
</div>
</body>
</html>
