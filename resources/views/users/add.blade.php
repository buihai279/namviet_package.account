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
                    <div class="col-lg-12">
                        <!--begin::Card-->
                        <div class="card card-custom card-stretch p-10">
                            <form class="form" method="POST"
                                  action="{{route('system.user.add')}}" id="kt_login_signin_form">
                                @if ($errors->all())
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
                                    <h2 class="font-weight-bolder text-dark font-size-h2 ">Thêm mới tài khoản</h2>
                                </div>
                                <!--end::Title-->

                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Tên tài
                                            khoản:<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                           type="text" name="username" required autocomplete="off"
                                           value="{{$data->username??''}}"/>
                                    <p class="text-muted text-warning">Tên tài khoản phải viết liền không dấu, chữ
                                        thường, không khoảng trắng. Ví dụ: toan_tq, toan.tq, toantq1</p>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Tên đầy đủ:<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                           type="text" name="fullname" required autocomplete="off"
                                           value="{{$data->fullname??''}}"/>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Mô tả về thông tin
                                            tài khoản, mục đích sử dụng:<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <textarea class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                              type="text" required name="description"
                                              autocomplete="off">{{$data->description??''}}</textarea>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Email:<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                           type="email" name="email" required autocomplete="off"
                                           value="{{$data->email ??''}}"/>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Mobile:<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                           type="tel" name="mobile" required autocomplete="off"
                                           value="{{$data->mobile ??''}}"/>
                                </div>

                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Mật khẩu
                                            mới:<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <input id="password_reg"
                                           class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                           type="password" required name="password" autocomplete="off"/>
                                    <span class="glyphicon form-control-feedback" id="password_reg1"></span>
                                </div>
                                <!--end::Form group-->
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Nhập lại
                                            mật khẩu mới:<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                           type="password" required name="password_confirmation"
                                           id="password_confirmation" autocomplete="off"/>
                                    <span class="glyphicon form-control-feedback" id="password_confirmation1">
                                          </span>
                                </div>
                                <!--end::Form group-->
                                <div class="form-group row">
                                    <label class="font-size-h6 font-weight-bolder text-dark pt-5">Trạng thái: <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <select class="form-control selectpicker" name="status">
                                                <option value="1">Hoạt động</option>
                                                <option value="0">Không hoạt động</option>
                                            </select>
                                            <span class="form-text text-muted"></span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Form group-->
                                <div class="form-group row">
                                    <label class="font-size-h6 font-weight-bolder text-dark pt-5">Nhóm quyền: <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <select class="form-control selectpicker" required name="user_group">
                                                @foreach($userGroups as $userGroup)
                                                    <option value="{{$userGroup->_id}}">{{$userGroup->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="form-text text-muted"></span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Form group-->
                                <div class="form-group row">
                                    <label class="font-size-h6 font-weight-bolder text-dark pt-5">OTP Active: <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <select class="form-control selectpicker" name="otp_active">
                                                <option value="1">{{__('label.active')}}</option>
                                                <option value="0">{{__('label.inactive')}}</option>
                                            </select>
                                            <span class="form-text text-muted"></span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Form group-->
                                <br>
                            @include('layouts.partials.assets.js.custom_uppy')
                            @include('components.forms.uploads.uppy-common', ['fieldName'=>'avatar'])
                            <!--begin::Action-->
                                <div class="text-center pt-2">
                                    <button id="kt_login_signin_submit" type="submit"
                                            class="btn btn-bg-info text-white  font-weight-bolder font-size-h6 px-8 py-4 my-3">
                                        Thêm mới
                                    </button>
                                    <button type="reset"
                                            class="btn btn-bg-secondary font-weight-bolder font-size-h6 px-8 py-4 my-3">
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
