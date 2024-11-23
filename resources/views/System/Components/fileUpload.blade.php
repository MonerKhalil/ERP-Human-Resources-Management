<div class="FileUpload {{ isset($DefaultData) ? "Selected" : "" }}">
    <label class="FileUpload__Label" for="{{ $FieldID }}">
        {{ $LabelField }}
    </label>
    <div class="FileUpload__MainContent">
        <label for="{{ $FieldID }}" class="FileUpload__FileName">
            {{ (isset($DefaultData) && $DefaultData !== "") ? $DefaultData : "No File Choose" }}
        </label>
    </div>
    <input type="file" name="{{ $FieldName }}" multiple
           accept="{{ $AcceptFiles }}"
           class="FileUpload__InputFile"
           id="{{ $FieldID }}" hidden>
</div>


{{--

    $FieldID
    $FieldName
    $DefaultData
    $AcceptFiles
    $LabelField

--}}
