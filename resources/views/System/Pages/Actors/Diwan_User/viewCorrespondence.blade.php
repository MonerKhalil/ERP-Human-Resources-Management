@extends("System.Pages.globalPage")

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--AddCorrespondencePage">
        <div class="AddCorrespondencePage">
            <div class="AddCorrespondencePage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __('viewCorrespondence') ,
                    'paths' => [['Correspondences' , '#'] , ['Correspondence']] ,
                    'summery' => __('viewCorrespondencesPage')
                ])
            </div>
        </div>
        <div class="AddCorrespondencePagePrim__Content">
            <div class="Row">
                <div class="AddCorrespondencePage__Form">
                    <div class="Container--MainContent">
                        <div class="MessageProcessContainer">
                            @include("System.Components.messageProcess")
                        </div>
                        <div class="Row">
                            <div class="CorrespondencePage__Information">
                                <div class="Card">
                                    <div class="Card__Content">
                                        <div class="Card__Inner">
                                            <form class="Form Form--Dark" action="{{route("correspondences.store")}}"
                                                  method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="ListData">
                                                    <div class="ListData__Head">
                                                        <h4 class="ListData__Title">
                                                            @lang("MainInformation")
                                                        </h4>
                                                    </div>
                                                    <div class="ListData__Content">
                                                        <div class="ListData__CustomItem">
                                                            <div class="Row GapC-1-5">
                                                                <div class="Col-4-md Col-6-sm">
                                                                    <div class="ListData__Content">
                                                                        <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("type")</span>
                                                                            <span
                                                                                class="Data_Value">{{$correspondence->type}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="Col-4-md Col-6-sm">
                                                                    <div class="ListData__Content">
                                                                        <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("createDate")</span>
                                                                            <span
                                                                                class="Data_Value">{{$correspondence->date}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @if($correspondence->number_internal != '')
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="ListData__Content">
                                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("numberInternal")</span>
                                                                                <span
                                                                                    class="Data_Value">{{$correspondence->number_internal}}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @if($correspondence->number_external != '')
                                                                    <div class="Col-4-md Col-6-sm">
                                                                        <div class="ListData__Content">
                                                                            <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("number_external")</span>
                                                                                <span
                                                                                    class="Data_Value">{{$correspondence->number_external}}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <div class="Col-4-md Col-6-sm">
                                                                    <div class="ListData__Content">
                                                                        <div class="Data_Col">
                                                                            <span
                                                                                class="Data_Label">@lang("path_file")</span>
                                                                            <a href="{{PathStorage($correspondence->path_file)}}"
                                                                               target="_blank">
                                                                                عرض الملف</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ListData">
                                                    <div class="ListData__Head">
                                                        <h4 class="ListData__Title">
                                                            <label for="CorrespondenceSubjectEditor">
                                                                @lang("CorrespondenceSubject")
                                                            </label>
                                                        </h4>
                                                    </div>
                                                    <div class="ListData__Content">
                                                        <div class="ListData__CustomItem">
                                                            <div class="Row">
                                                                <div class="Col">
                                                                    <div class="Form__Group">
                                                                        <div class="Form__Textarea">
                                                                            <span
                                                                                class="Data_Value">{!! $correspondence->subject !!}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="ListData">
                                                    <div class="ListData__Head">
                                                        <h4 class="ListData__Title">
                                                            <label for="CorrespondenceSubjectEditor">
                                                                @lang("summary")
                                                            </label>
                                                        </h4>
                                                    </div>
                                                    <div class="ListData__Content">
                                                        <div class="ListData__CustomItem">
                                                            <div class="Row">
                                                                <div class="Col">
                                                                    <div class="Form__Group">
                                                                        <div class="Form__Textarea">
                                                                            <span
                                                                                class="Data_Value">{{$correspondence->summary}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ListData">
                                                    <div class="ListData__Head">
                                                        <h4 class="ListData__Title">
                                                            معلومات الحركات
                                                        </h4>
                                                    </div>
                                                    <div class="ListData__Content">
                                                        <div class="ListData__CustomItem">
                                                            <div class="SignatureStructure">
                                                                <div class="SignatureStructure__List">
                                                                    @foreach($correspondence->CorrespondenceDest as $transaction)
                                                                        <div class="SignatureStructure__Item">
                                                                            <i class="material-icons ArrowRight">chevron_right</i>
                                                                            <div
                                                                                class="OpenPopup SignatureBox SignatureBox--Success"
                                                                                data-popup="{{$transaction["id"]}}">
                                                                                <div
                                                                                    class="SignatureName">{{$transaction->source_dest_type}}</div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                    {{--                                                                    <div class="SignatureStructure__Item">--}}
                                                                    {{--                                                                        <i class="material-icons ArrowRight">chevron_right</i>--}}
                                                                    {{--                                                                        <div class="OpenPopup SignatureBox SignatureBox--Pending"--}}
                                                                    {{--                                                                             data-popup="Signature_2">--}}
                                                                    {{--                                                                            <div class="SignatureName">Amir</div>--}}
                                                                    {{--                                                                        </div>--}}
                                                                    {{--                                                                    </div>--}}
                                                                    {{--                                                                    <div class="SignatureStructure__Item">--}}
                                                                    {{--                                                                        <i class="material-icons ArrowRight">chevron_right</i>--}}
                                                                    {{--                                                                        <div class="OpenPopup SignatureBox SignatureBox--Pending"--}}
                                                                    {{--                                                                             data-popup="Signature_3">--}}
                                                                    {{--                                                                            <div class="SignatureName">Amir</div>--}}
                                                                    {{--                                                                        </div>--}}
                                                                    {{--                                                                    </div>--}}
                                                                    {{--                                                                    <div class="SignatureStructure__Item">--}}
                                                                    {{--                                                                        <i class="material-icons ArrowRight">chevron_right</i>--}}
                                                                    {{--                                                                        <div class="OpenPopup SignatureBox SignatureBox--Pending"--}}
                                                                    {{--                                                                             data-popup="Signature_4">--}}
                                                                    {{--                                                                            <div class="SignatureName">Amir</div>--}}
                                                                    {{--                                                                        </div>--}}
                                                                    {{--                                                                    </div>--}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                            <form action="{{route("transaction.legalopinion.send", $correspondence["id"])}}"
                                                  method="post">
                                                @csrf
                                                <div class="Row">
                                                    <div class="Col">
                                                        <div class="Form__Group">
                                                            <div class="Form__Button">
                                                                <button class="Button Send"
                                                                        type="submit">طلب رأي قانوني</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section("PopupPage")
    @foreach($correspondence->CorrespondenceDest as $transaction)
        <div class="Popup Popup--Dark" data-name="{{$transaction["id"]}}">
            <div class="Popup__Content">
                <div class="Popup__Card">
                    <i class="material-icons Popup__Close">close</i>
                    <div class="Popup__CardContent">
                        <div class="Popup__InnerGroup">
                            <div class="ListData NotResponsive">
                                <div class="ListData__Head">
                                    <h4 class="ListData__Title">
                                        معلومات الحركات
                                    </h4>
                                </div>
                                {{--                            @php--}}
                                {{--                                dd($transaction);--}}
                                {{--                            @endphp--}}
                                <div class="ListData__Content">
                                    <div class="ListData__Item ListData__Item--NoAction">
                                        <div class="Data_Col">
                                        <span class="Data_Label">
                                           @lang("transactionType")
                                        </span>
                                            <span class="Data_Value">
                                            {{$transaction["type"]}}
                                        </span>
                                        </div>
                                    </div>
                                    <div class="ListData__Item ListData__Item--NoAction">
                                        <div class="Data_Col">
                                        <span class="Data_Label">
                                            @lang("notices")
                                        </span>
                                            <span class="Data_Value">
                                            {{$transaction["notice"]}}
                                        </span>
                                        </div>
                                    </div>
                                    @if($transaction["type"] == 'internal')
                                        <div class="ListData__Item ListData__Item--NoAction">
                                            <div class="Data_Col">
                                        <span class="Data_Label">
                                            @lang("department")
                                        </span>
                                                <span class="Data_Value">
                                            {{$transaction->internal_department["name"]}}
                                        </span>
                                            </div>
                                        </div>
                                    @endif
                                    @if($transaction["source_dest_type"] == 'outgoing_to_incoming')
                                        <div class="ListData__Item ListData__Item--NoAction">
                                            <div class="Data_Col">
                                        <span class="Data_Label">
                                            @lang('transactionSource')
                                        </span>
                                                <span class="Data_Value">
                                            {{$transaction["source_correspondence_id"]}}
                                        </span>
                                            </div>
                                        </div>
                                    @endif
                                    @if($transaction["source_dest_type"] == 'incoming_to_outgoing')
                                        <div class="ListData__Item ListData__Item--NoAction">
                                            <div class="Data_Col">
                                        <span class="Data_Label">
                                            @lang("transactionSource")
                                        </span>
                                                <span class="Data_Value">
                                            {{$transaction["source_correspondence_id"]}}
                                        </span>
                                            </div>
                                        </div>
                                    @endif
                                    @if($transaction["type"] == 'external')
                                        <div class="ListData__Item ListData__Item--NoAction">
                                            <div class="Data_Col">
                                        <span class="Data_Label">
                                            @lang("external_party")
                                        </span>
                                                <span class="Data_Value">
                                            {{$transaction->external_party["name"]}}
                                        </span>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="ListData__Item ListData__Item--NoAction">
                                        <div class="Data_Col">
                                        <span class="Data_Label">
                                            @lang("document")
                                        </span>
                                            <span class="Data_Value">
                                            <a href="{{PathStorage($transaction->path_file)}}"
                                               target="_blank">
                                                عرض الملف</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{--    <div class="Popup Popup--Dark" data-name="Signature_2">--}}
    {{--        <div class="Popup__Content">--}}
    {{--            <div class="Popup__Card">--}}
    {{--                <i class="material-icons Popup__Close">close</i>--}}
    {{--                <div class="Popup__CardContent">--}}
    {{--                    <div class="Popup__InnerGroup">--}}
    {{--                        <div class="ListData NotResponsive">--}}
    {{--                            <div class="ListData__Head">--}}
    {{--                                <h4 class="ListData__Title">--}}
    {{--                                    معلومات الموقعين--}}
    {{--                                </h4>--}}
    {{--                            </div>--}}
    {{--                            <div class="ListData__Content">--}}
    {{--                                <div class="ListData__Item ListData__Item--NoAction">--}}
    {{--                                    <div class="Data_Col">--}}
    {{--                                        <span class="Data_Label">--}}
    {{--                                            المعلومة الاولى--}}
    {{--                                        </span>--}}
    {{--                                        <span class="Data_Value">--}}
    {{--                                            ---}}
    {{--                                        </span>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="ListData__Item ListData__Item--NoAction">--}}
    {{--                                    <div class="Data_Col">--}}
    {{--                                        <span class="Data_Label">--}}
    {{--                                            المعلومة الثانية--}}
    {{--                                        </span>--}}
    {{--                                        <span class="Data_Value">--}}
    {{--                                            ---}}
    {{--                                        </span>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="ListData__Item ListData__Item--NoAction">--}}
    {{--                                    <div class="Data_Col">--}}
    {{--                                        <span class="Data_Label">--}}
    {{--                                            المعلومة الثالثة--}}
    {{--                                        </span>--}}
    {{--                                        <span class="Data_Value">--}}
    {{--                                            ---}}
    {{--                                        </span>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="ListData__Item ListData__Item--NoAction">--}}
    {{--                                    <div class="Data_Col">--}}
    {{--                                        <span class="Data_Label">--}}
    {{--                                            المعلومة الرابعة--}}
    {{--                                        </span>--}}
    {{--                                        <span class="Data_Value">--}}
    {{--                                            ---}}
    {{--                                        </span>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--    <div class="Popup Popup--Dark" data-name="Signature_3">--}}
    {{--        <div class="Popup__Content">--}}
    {{--            <div class="Popup__Card">--}}
    {{--                <i class="material-icons Popup__Close">close</i>--}}
    {{--                <div class="Popup__CardContent">--}}
    {{--                    <div class="Popup__InnerGroup">--}}
    {{--                        <div class="ListData NotResponsive">--}}
    {{--                            <div class="ListData__Head">--}}
    {{--                                <h4 class="ListData__Title">--}}
    {{--                                    معلومات الموقعين--}}
    {{--                                </h4>--}}
    {{--                            </div>--}}
    {{--                            <div class="ListData__Content">--}}
    {{--                                <div class="ListData__Item ListData__Item--NoAction">--}}
    {{--                                    <div class="Data_Col">--}}
    {{--                                        <span class="Data_Label">--}}
    {{--                                            المعلومة الاولى--}}
    {{--                                        </span>--}}
    {{--                                        <span class="Data_Value">--}}
    {{--                                            ---}}
    {{--                                        </span>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="ListData__Item ListData__Item--NoAction">--}}
    {{--                                    <div class="Data_Col">--}}
    {{--                                        <span class="Data_Label">--}}
    {{--                                            المعلومة الثانية--}}
    {{--                                        </span>--}}
    {{--                                        <span class="Data_Value">--}}
    {{--                                            ---}}
    {{--                                        </span>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="ListData__Item ListData__Item--NoAction">--}}
    {{--                                    <div class="Data_Col">--}}
    {{--                                        <span class="Data_Label">--}}
    {{--                                            المعلومة الثالثة--}}
    {{--                                        </span>--}}
    {{--                                        <span class="Data_Value">--}}
    {{--                                            ---}}
    {{--                                        </span>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="ListData__Item ListData__Item--NoAction">--}}
    {{--                                    <div class="Data_Col">--}}
    {{--                                        <span class="Data_Label">--}}
    {{--                                            المعلومة الرابعة--}}
    {{--                                        </span>--}}
    {{--                                        <span class="Data_Value">--}}
    {{--                                            ---}}
    {{--                                        </span>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--    <div class="Popup Popup--Dark" data-name="Signature_4">--}}
    {{--        <div class="Popup__Content">--}}
    {{--            <div class="Popup__Card">--}}
    {{--                <i class="material-icons Popup__Close">close</i>--}}
    {{--                <div class="Popup__CardContent">--}}
    {{--                    <div class="Popup__InnerGroup">--}}
    {{--                        <div class="ListData NotResponsive">--}}
    {{--                            <div class="ListData__Head">--}}
    {{--                                <h4 class="ListData__Title">--}}
    {{--                                    معلومات الموقعين--}}
    {{--                                </h4>--}}
    {{--                            </div>--}}
    {{--                            <div class="ListData__Content">--}}
    {{--                                <div class="ListData__Item ListData__Item--NoAction">--}}
    {{--                                    <div class="Data_Col">--}}
    {{--                                        <span class="Data_Label">--}}
    {{--                                            المعلومة الاولى--}}
    {{--                                        </span>--}}
    {{--                                        <span class="Data_Value">--}}
    {{--                                            ---}}
    {{--                                        </span>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="ListData__Item ListData__Item--NoAction">--}}
    {{--                                    <div class="Data_Col">--}}
    {{--                                        <span class="Data_Label">--}}
    {{--                                            المعلومة الثانية--}}
    {{--                                        </span>--}}
    {{--                                        <span class="Data_Value">--}}
    {{--                                            ---}}
    {{--                                        </span>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="ListData__Item ListData__Item--NoAction">--}}
    {{--                                    <div class="Data_Col">--}}
    {{--                                        <span class="Data_Label">--}}
    {{--                                            المعلومة الثالثة--}}
    {{--                                        </span>--}}
    {{--                                        <span class="Data_Value">--}}
    {{--                                            ---}}
    {{--                                        </span>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="ListData__Item ListData__Item--NoAction">--}}
    {{--                                    <div class="Data_Col">--}}
    {{--                                        <span class="Data_Label">--}}
    {{--                                            المعلومة الرابعة--}}
    {{--                                        </span>--}}
    {{--                                        <span class="Data_Value">--}}
    {{--                                            ---}}
    {{--                                        </span>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
@endsection

@section("extraScripts")
    {{-- JS Trumbowyg --}}
    <script src="{{asset("System/Assets/Lib/trumbowyg/dist/trumbowyg.min.js")}}"></script>
    @if(app()->getLocale()==="ar")
        <script src="{{asset("System/Assets/Lib/trumbowyg/dist/langs/ar.min.js")}}"></script>
    @endif
@endsection
