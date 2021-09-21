@extends('layouts::master')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid pt-0" id="kt_content" xmlns="http://www.w3.org/1999/html"
         xmlns="http://www.w3.org/1999/html">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-lg-12">
                        @if (!empty($errors->all()))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-lg-6 {{$user->status===0?'position-relative overflow-hidden':''}} ">
                        <div
                            class="{{$user->status===0?'bg-dark h-100 opacity-30 position-absolute w-100  zindex-1':''}}"></div>
                        <!--begin::Card-->
                        <div class="card card-custom card-stretch p-10">
                            <form class="form" novalidate="novalidate" method="POST"
                                  action="{{route('system.user.block', $user->_id)}}" id="form-delete">
                                <input name="status" hidden value="0">
                            @csrf
                            <!--begin::Title-->
                                <div class="text-center pb-8">
                                    <h2 class="font-weight-bolder text-dark font-size-h2 ">Khóa tài khoản</h2>
                                </div>
                                <!--end::Title-->

                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Tài
                                            khoản: </label>
                                        <span class="font-size-h6 pt-5">{{'@'.$user->username}}</span>
                                    </div>
                                </div>
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Tên đầy
                                            đủ: </label>
                                        <span class="font-size-h6 pt-5 text">{{$user->fullname}}</span>
                                    </div>
                                </div>
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Trạng
                                            thái: </label>
                                        <span
                                            class="font-size-h6 text-danger pt-5">{{config('const.status_user')[$user->status]}}</span>
                                    </div>
                                </div>
                                <div class="form-group mb-1">
                                    <label for="exampleTextarea">Nhập lý do khóa tài khoản
                                        <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="exampleTextarea" name="reason_block" rows="3"
                                              required></textarea>
                                </div>
                                <!--end::Form group-->
                                <!--begin::Action-->
                                <div class="text-center pt-2">
                                    <button type="submit" onclick="confirmDelete(event)"
                                            class="btn btn-warning text-white font-weight-bolder font-size-h6 px-8 py-4 my-3">
                                        Khóa
                                    </button>
                                </div>
                                <p class=""><span class="text-danger">*</span> Sau khi khóa tài khoản sẽ bị đăng xuất
                                </p>
                                <!--end::Action-->
                            </form>
                        </div>
                        <!--end::Card-->
                    </div>
                    <div class="col-lg-6 {{$user->status===1?'position-relative overflow-hidden':''}} ">
                        <div
                            class="{{$user->status===1?'bg-dark h-100 opacity-30 position-absolute w-100  zindex-1':''}}"></div>
                        <!--begin::Card-->
                        <div class="card card-custom card-stretch p-10">
                            <form class="form" novalidate="novalidate" method="POST"
                                  action="{{route('system.user.block', $user->_id)}}" id="kt_login_signin_form">
                                <input name="status" hidden value="1">
                                <input name="reason_block" hidden value="{{ $user->reason_block}}">
                            @csrf
                            <!--begin::Title-->
                                <div class="text-center pb-8">
                                    <h2 class="font-weight-bolder text-dark font-size-h2 ">Mở khóa tài khoản</h2>
                                </div>
                                <!--end::Title-->

                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Tên đầy
                                            đủ: </label>
                                        <span class="font-size-h6 pt-5 text">{{$user->fullname}}</span>
                                    </div>
                                </div>
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Tài
                                            khoản: </label>
                                        <span class="font-size-h6 pt-5">{{'@'.$user->username}}</span>
                                    </div>
                                </div>
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Trạng
                                            thái: </label>
                                        <span
                                            class="font-size-h6 text-danger pt-5">{{config('const.status_user')[$user->status]}}</span>
                                    </div>
                                </div>
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Lý do đã
                                            khóa: </label>
                                        <span
                                            class="font-size-h6 pt-5">{{$user->reason_block}}</span>
                                    </div>
                                </div>
                                <!--end::Form group-->
                                <!--begin::Action-->
                                <div class="text-center pt-2">
                                    <button type="submit"
                                            class="btn btn-warning text-white font-weight-bolder font-size-h6 px-8 py-4 my-3">
                                        Mở khóa
                                    </button>
                                </div>
                                <!--end::Action-->
                            </form>
                        </div>
                        <!--end::Card-->
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
@section('script_bottom')
    <script src="{{asset('assets/js/pages/features/miscellaneous/sweetalert2.js?v=7.1.8')}}"></script>
    <script>
        function confirmDelete(e) {
            e.preventDefault();
            Swal.fire({
                title: "Bạn có chắc chắc muốn KHÓA tài khoản?",
                text: "Sau khi khóa, tài khoản này không thể đăng nhập vào hệ thống!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Khóa tài khoản!",
                cancelButtonText: "Hủy bỏ thao tác"
            }).then(function (result) {
                if (result.value) {
                    $("#form-delete").submit();
                }
            });
        }
    </script>
@endsection
