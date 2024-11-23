@foreach($employees as $employee)
    <div class="Item DataItem">
        <div class="Item__Col Item__Col--Check">
            <input id="ItemRow_{{$employee["id"]}}"
                   class="CheckBoxItem" type="checkbox"
                   name="employees[]"
                   value="{{$employee["id"]}}" hidden>
            <label for="ItemRow_{{$employee["id"]}}"
                   class="CheckBoxRow">
                <i class="material-icons ">
                    check_small
                </i>
            </label>
        </div>
        <div
            class="Item__Col">{{$employee["first_name"]}}</div>
        <div
            class="Item__Col">{{$employee["user_id"]}}</div>
        <div class="Item__Col">{{$employee["gender"]}}</div>
        <div
            class="Item__Col">{{$employee["NP_registration"]}}</div>
        <div
            class="Item__Col">{{$employee["current_job"]}}</div>
        <div class="Item__Col MoreDropdown">
            <i class="material-icons Popper--MoreMenuTable MenuPopper IconClick More__Button"
               data-MenuName="RoleMore_{{$employee["id"]}}">
                more_horiz
            </i>
            <div
                class="Popper--MoreMenuTable MenuTarget Dropdown"
                data-MenuName="RoleMore_{{$employee["id"]}}">
                <ul class="Dropdown__Content">
                    <li>
                        <a href="{{route("system.employees.show" , $employee["id"])}}"
                           class="Dropdown__Item">
                            @lang("viewDetails")
                        </a>
                    </li>
                </ul>
                <ul class="Dropdown__Content">
                    <li>
                        <a href="{{route("system.employees.edit" , $employee["id"])}}"
                           class="Dropdown__Item">
                            @lang("editDetails")
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endforeach
