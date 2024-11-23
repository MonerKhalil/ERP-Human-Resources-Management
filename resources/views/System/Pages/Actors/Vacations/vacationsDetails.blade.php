<?php
    $MyAccount = auth()->user() ;
    $IsMyVocation = (!is_null(auth()->user()->employee["id"]) && ($leave->employee["user_id"] == auth()->user()["id"]));
    $IsHavePermissionVacationRead = $MyAccount->can("read_leaves") || $MyAccount->can("all_leaves") ;
    $IsHavePermissionVacationEdit = $MyAccount->can("update_leaves") || $MyAccount->can("all_leaves") ;
    $IsHavePermissionVacationDelete = $MyAccount->can("delete_leaves") || $MyAccount->can("all_leaves") ;
    $IsHavePermissionVacationExport = $MyAccount->can("export_leaves") || $MyAccount->can("all_leaves") ;
    $IsHavePermissionVacationDecisionState = $MyAccount->can("all_leaves") ;
?>

@extends("System.Pages.globalPage")

@php
    $MyAccount = auth()->user() ;
    $IsHavePermissionEditUser = ($MyAccount->can("update_leaves") || $MyAccount->can("all_leaves")) ;
@endphp

@section("ContentPage")
    <section class="MainContent__Section MainContent__Section--VacationsDetailsPage">
        <div class="VacationsDetailsPage">
            <div class="VacationsDetailsPage__Breadcrumb">
                @include('System.Components.breadcrumb' , [
                    'mainTitle' => __("vocationDetails") ,
                    'paths' => [[__("home") , '#'] , [__("vocationDetails")]] ,
                    'summery' => __("titleVocationDetails")
                ])
            </div>
            <div class="VacationsDetailsPage__Content">
                <div class="Container--MainContent">
                    <div class="MessageProcessContainer">
                        @include("System.Components.messageProcess")
                    </div>
                    <div class="Row">
                        <div class="Col">
                            <div class="Card">
                                <div class="Card__Inner">
                                    @if($IsHavePermissionVacationRead || $IsMyVocation)
                                        <div class="ListData NotResponsive">
                                            <div class="ListData__Head">
                                                <h4 class="ListData__Title">
                                                    معلومات الاجازة
                                                </h4>
                                            </div>
                                            <div class="ListData__Content">
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        رقم الطلب
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{ $leave["id"] }}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        مقدم الطلب
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{ $leave->employee["first_name"]." ".$leave->employee["last_name"] }}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        نوع الاجازة
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{ $leave->leave_type["name"] ?? "(محذوف)" }}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        حالة الطلب
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{ $leave["status"] }}
                                                    </span>
                                                    </div>
                                                </div>
                                                @if($leave["status"] == "reject" && $leave["reject_details"])
                                                    <div class="ListData__Item ListData__Item--NoAction">
                                                        <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        سبب رفض الطلب
                                                    </span>
                                                            <span class="Data_Value">
                                                        {{ $leave["reject_details"] }}
                                                    </span>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        تاريخ تقديم الطلب
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{ $leave["created_at"] }}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="ListData__Item ListData__Item--NoAction">
                                                    <div class="Data_Col">
                                                    <span class="Data_Label">
                                                        تاريخ الرد على الطلب
                                                    </span>
                                                        <span class="Data_Value">
                                                        {{ $leave["date_update_status"] ?? "_" }}
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($IsHavePermissionVacationDecisionState)
                                        @if($IsHavePermissionEditUser && $leave["status"] == "pending")
                                            <!-- For Admin -->
                                            <div class="ListData">
                                                <div class="ListData__Head">
                                                    <h4 class="ListData__Title">
                                                        العمليات على الاجازة
                                                    </h4>
                                                </div>
                                                <div class="ListData__Content">
                                                    <div class="Card__Inner px0">
                                                        <form class="Form Form--Dark"
                                                              action="{{ route("system.leaves_admin.leave.status.change" , "approve") }}"
                                                              method="post">
                                                            @csrf
                                                            <input type="hidden" name="ids[0]" value="{{ $leave["id"] }}">
                                                            <button class="Button Button--Primary" type="submit">
                                                                قبول اجازة
                                                            </button>
                                                            <button class="OpenPopup Button Button--Danger"
                                                                    type="button"
                                                                    data-popUp="RejectReason">
                                                                رفض اجازة
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="Popup Popup--Dark"
                                                 data-name="RejectReason">
                                                <div class="Popup__Content">
                                                    <div class="Popup__Card">
                                                        <i class="material-icons Popup__Close">close</i>
                                                        <div class="Popup__CardContent">
                                                            <div class="Popup__InnerGroup">
                                                                <form class="Form Form--Dark"
                                                                      action="{{ route("system.leaves_admin.leave.status.change" , "reject") }}"
                                                                      method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="ids[0]" value="{{ $leave["id"] }}">
                                                                    <div class="Popup__Body">
                                                                        <div class="Popup__Inner">
                                                                            <h3 class="Popup__Title">
                                                                                <span class="Title">تأكيد الرفض</span>
                                                                            </h3>
                                                                            <div class="Popup__Body">
                                                                                <div class="Row GapC-1-5">
                                                                                    <div class="Col-12">
                                                                                        <div class="Form__Group">
                                                                                            <div class="Form__Textarea">
                                                                                                <div class="Textarea__Area">
                                                                                                    <textarea id="ReasonReject" class="Textarea__Field"
                                                                                                              name="reject_details" placeholder="سبب الرفض"
                                                                                                              rows="3"></textarea>
                                                                                                    <label class="Textarea__Label"
                                                                                                           for="ReasonReject">سبب الرفض</label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="Popup__Inner">
                                                                            <button class="Button Button--Danger" type="submit">
                                                                                تأكيد الرفض
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
