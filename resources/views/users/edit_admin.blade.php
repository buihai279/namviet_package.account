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
                        @include('layouts::components_v8.alerts')
                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-lg-6">
                        <!--begin::Card-->
                        <div class="card card-custom card-stretch p-10">
                            <form class="form" novalidate="novalidate" method="POST"
                                  action="{{route('system.user.admin_reset_password', $data->id)}}"
                                  id="kt_login_signin_form">
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
                                    <h2 class="font-weight-bolder text-dark font-size-h2 ">Đặt lại mật khẩu</h2>
                                </div>
                                <!--end::Title-->

                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Đặt lại mật khẩu
                                            cho tài khoản</label>
                                    </div>
                                    <p><span
                                            class="font-weight-bold">Tên đầy đủ:</span><span>{{$data->fullname??''}}</span>
                                    </p>
                                    <p><span
                                            class="font-weight-bold">Username:</span><span>{{$data->username??''}}</span>
                                    </p>
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
                                        Đặt lại mật khẩu
                                    </button>
                                </div>
                                <p class="text-danger">*Chỉ sử dụng tính năng này khi có yêu cầu hỗ trợ từ phía
                                    người chủ tài khoản</p>
                                <!--end::Action-->
                            </form>
                        </div>
                        <!--end::Card-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Card-->
                        <div class="card card-custom card-stretch p-10">
                            <form class="form" novalidate="novalidate" method="POST"
                                  action="{{route('system.user.updateAdmin',$data->_id)}}">
                                @if (!empty($errors->all()))
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
                                    <h2 class="font-weight-bolder text-dark font-size-h2">Sửa thông tin của tài
                                        khoản</h2>
                                </div>
                                <!--end::Title-->
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Username:</label>
                                        <input hidden type="text" disabled name="username"
                                               value="{{$data->username??''}}"/>
                                    </div>
                                    <span class="font-weight-bold">{{$data->username??''}}</span>
                                </div>
                                @if(request()->get('code'))
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between mt-n5">
                                            <label
                                                class="font-size-h6 font-weight-bolder text-dark pt-5">CODE_USER:</label>
                                        </div>
                                        <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                               type="text" name="code" autocomplete="off"
                                               value="{{$data->code??''}}"/>
                                        <p class="text-muted">SYS_ADMIN, USER_CMS</p>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Tên đầy đủ</label>
                                    </div>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                           type="text" name="fullname" autocomplete="off"
                                           value="{{$data->fullname??''}}"/>
                                </div>
                                <!--end::Form group-->
                                <div class="form-group row">
                                    <label class="font-size-h6 font-weight-bolder text-dark pt-5">Nhóm quyền/Nhóm
                                        người dùng: <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <select class="form-control selectpicker" required name="user_group">
                                                @foreach($userGroups as $userGroup)
                                                    <option
                                                        value="{{$userGroup->_id}}"
                                                        {{(string)$data->user_group===(string)$userGroup->_id?'selected':''}}
                                                        @if($userGroup->status!==1)
                                                        class='bg-danger text-light-warning'
                                                        disabled
                                                        data-subtext='Đã_bị_khóa'
                                                        @endif

                                                    >
                                                        {{$userGroup->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="form-text text-muted"></span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Form group-->
                            @include('layouts.partials.assets.js.custom_uppy')
                            @include('components.forms.uploads.uppy-common', ['fieldName'=>'avatar'])
                            <!--begin::Action-->
                                <div class="form-group">
                                    <label class="font-size-h6 font-weight-bolder text-dark">Sử dụng xác thực mã
                                        OTP</label>
                                    <label class="d-inline-block px-4">
                                        <input @if($data->otp_active === 0) {{'checked'}} @endif class="mx-2"
                                               name="otp_active" value="0" type="radio">Không
                                    </label>
                                    <label class="d-inline-block px-4">
                                        <input @if($data->otp_active ===1) {{'checked'}} @endif class="mx-2"
                                               name="otp_active" value="1" type="radio">Có
                                    </label>
                                </div>
                                <div class="text-center pt-2">
                                    <button id="kt_login_signin_submit" type="submit"
                                            class="btn btn-bg-info text-white  font-weight-bolder font-size-h6 px-8 py-4 my-3">
                                        Thay đổi thông tin
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
