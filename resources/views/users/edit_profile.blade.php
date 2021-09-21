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
                        @include('components.notice')
                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-lg-6">
                        <!--begin::Card-->
                        <div class="card card-custom card-stretch p-20">
                            <form class="form" novalidate="novalidate" method="POST"
                                  action="{{route('system.user.change_password')}}" id="kt_login_signin_form">
                                @if ($errors->has('password_old')||$errors->has('password')||$errors->has('password_confirmation'))
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                            @endif
                            @csrf
                            <!--begin::Title-->
                                <div class="text-center pb-8">
                                    <h2 class="font-weight-bolder text-dark font-size-h2 ">Đổi
                                        mật khẩu tài khoản</h2>
                                </div>
                                <!--end::Title-->

                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Mật khẩu
                                            cũ</label>
                                    </div>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                           type="password" name="password_old" autocomplete="off"/>
                                </div>
                                <!--end::Form group-->

                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Mật khẩu
                                            mới</label>
                                    </div>
                                    <input id="password_reg"
                                           class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                           type="password" name="password" autocomplete="off"/>
                                    <span class="glyphicon form-control-feedback" id="password_reg1"></span>
                                </div>
                                <!--end::Form group-->
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Nhập lại
                                            mật khẩu mới</label>
                                    </div>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                           type="password" name="password_confirmation" id="password_confirmation"
                                           required autocomplete="off"/>
                                    <span class="glyphicon form-control-feedback" id="password_confirmation1">
                                          </span>
                                </div>
                                <!--end::Form group-->
                                <!--begin::Action-->
                                <div class="text-center pt-2">
                                    <button id="kt_login_signin_submit" type="submit"
                                            class="btn btn-bg-success text-white font-weight-bolder font-size-h6 px-8 py-4 my-3">
                                        Thay đổi mật khẩu
                                    </button>
                                </div>
                                <p class=""><span class="text-danger">*</span> Sau khi thay đổi mật khẩu hệ thống sẽ tự
                                    động đăng xuất</p>
                                <!--end::Action-->
                            </form>
                        </div>
                        <!--end::Card-->
                    </div>

                    <div class="col-lg-6">
                        <!--begin::Card-->
                        <div class="card card-custom card-stretch p-20">
                            <form class="form" novalidate="novalidate" method="POST"
                                  action="{{route('system.user.updateProfile')}}" id="kt_login_signin_form">
                                @if ($errors->has('fullname'))
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                            @endif
                            @csrf
                            <!--begin::Title-->
                                <div class="text-center pb-8">
                                    <h2 class="font-weight-bolder text-dark font-size-h2">Thay đổi thông tin cá
                                        nhân</h2>
                                </div>
                                <!--end::Title-->
                                <input hidden type="text" disabled name="username" value="{{$data->username??''}}"/>
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Tên đầy đủ</label>
                                    </div>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                           type="text" name="fullname" autocomplete="off"
                                           value="{{$data->fullname??''}}"/>
                                </div>
                                <!--end::Form group-->
                            @include('layouts.partials.assets.js.custom_uppy')
                            @include('components.forms.uploads.uppy-common', ['fieldName'=>'avatar'])
                            <!--begin::Action-->
                                <div class="text-center pt-2">
                                    <button id="kt_login_signin_submit" type="submit"
                                            class="btn btn-bg-info text-white  font-weight-bolder font-size-h6 px-8 py-4 my-3">
                                        Thay đổi thông tin
                                    </button>
                                    <button type="reset"
                                            class="btn btn-bg-secondary  font-weight-bolder font-size-h6 px-8 py-4 my-3">
                                        Nhập lại
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
    @include('layouts.partials.assets.js.validate_login')
@endsection
