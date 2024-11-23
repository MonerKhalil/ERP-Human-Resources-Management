<div class="ListData">
    <div class="ListData__Head">
        <h4 class="ListData__Title">{{$Title}}</h4>
    </div>
    <div class="ListData__Content">
        @foreach($ListData as $Item)
            @if($Item["IsLock"])
                    <div class="ListData__Item ListData__Item--NoAction">
            @else
                @if(isset($Item["PopupName"]))
                    <div class="OpenPopup ListData__Item ListData__Item--Action"
                         data-popUp="UpdateUser">
                @else
                    <div class="ListData__Item ListData__Item--NoAction">
                @endif
            @endif
                <div class="Data_Col">
                    <span class="Data_Label">
                        {{$Item["Label"]}}
                    </span>

                    @if(isset($Item["IsDataSkills"]) && $Item["IsDataSkills"])
                        <div class="Data_Value Skills">
                            <ul class="Skills__List">
                                @foreach($Item["Skills"] as $Skill)
                                    <li class="Skill">{{$Skill}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <span class="Data_Value">
                            {{$Item["Value"]}}
                        </span>
                    @endif



                </div>
                <div class="Data_Col Data_Col--End">
                    @if($Item["IsLock"])
                        <i class="material-icons">
                            lock
                        </i>
                    @else
                        <i class="material-icons">
                            lock_open
                        </i>
                    @endif
                </div>
                    </div>
        @endforeach
    </div>
</div>

{{--
    Title
    ListData : [Label , Value , IsLock , PopupName]
--}}
