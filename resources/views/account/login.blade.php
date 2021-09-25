@extends('layouts::blank')
@section('body')
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative"
                 style="background-color: #f9fafc">

                <!--begin::Content-->
                <div class="d-flex flex-center flex-column flex-column-fluid">
                    <!--begin::Wrapper-->
                    <a href="#" class="text-center pt-2">
                        <img src="https://cms-testing.vtvtravel.vn/approve//assets/custom/image/logo.png"
                             class="max-h-75px max-w-200px mt-20" alt="">
                    </a>
                    <div class="w-lg-500px p-10 p-lg-15 mx-auto">
                    @include('layouts::components_v8.alerts')
                    <!--begin::Form-->
                        <form class="form w-100" id="kt_sign_in_form" novalidate="novalidate" method="POST"
                              action="{{route('system.user.login')}}">
                        @csrf
                        <!--begin::Heading-->
                            <div class="text-center mb-10">
                                <!--begin::Title-->
                                <h1 class="text-dark mb-3">Đăng nhập vào hệ
                                    thống</h1>
                                <!--end::Title-->
                                <!--begin::Link-->
                                <!--end::Link-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="form-label fs-6 fw-bolder text-dark">Tài khoản</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-lg form-control-solid border-primary"
                                       type="text"
                                       name="username" value="{{old('username')}}"
                                       autocomplete="off"/>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack mb-2">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                                    <!--end::Label-->
                                    <!--begin::Link-->
                                    <!--end::Link-->
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Input-->
                                <input class="form-control form-control-lg form-control-solid  border-primary"
                                       type="password" value="{{old('password')}}"
                                       name="password" autocomplete="off"/>
                                <!--end::Input-->
                                @if(!empty(request()->session()->get('check')) && request()->session()->get('check') >=3)
                                    <div class="form-group">
                                        {{--                                    <label class="font-size-h6 font-weight-bolder text-dark">Mã Captcha</label>--}}
                                        <div class="captcha my-3">
                                            <span class="img-captcha">{!! captcha_img('math') !!}</span>
                                            <span class="ml-3 btn-refresh-captcha"><i
                                                    class="la la-refresh text-dark"></i></span>
                                        </div>
                                        <input
                                            class="form-control form-control-solid h-auto py-7 px-6 rounded-lg  border-primary"
                                            type="text"
                                            name="captcha" id="captcha" placeholder="Enter captcha" required
                                            autocomplete="off"/>

                                        @error('captcha')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="text-center">
                                <!--begin::Submit button-->
                                <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                                    <span class="indicator-label">Đăng nhập</span>
                                    <span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <!--end::Submit button-->
                                <!--begin::Separator-->
                                <!--end::Separator-->
                                <!--begin::Google link-->
                                <!--end::Google link-->
                                <!--begin::Google link-->
                                <!--end::Google link-->
                                <!--begin::Google link-->
                                <!--end::Google link-->
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Aside-->
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid py-10"
                 style="    background-image: url({{asset('vendor/theme/images/bg_login.jpg')}});
                     background-repeat: no-repeat;
                     background-size: cover;
                     }">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
                    <!--begin::Content-->
                    <div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
                        <!--begin::Logo-->

                    </div>
                    <!--end::Content-->
                    <!--begin::Illustration-->
                    <!--end::Illustration-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Main-->

@endsection
@push('script_bottom')

    <!--begin::Page Scripts(used by this page)-->
    {{--<script src="assets/js/pages/custom/login/login-general.js"></script>--}}
    <!--end::Page Scripts-->
    <script>
        $('.btn-refresh-captcha').on('click', function () {
            $.ajax({
                type: "GET",
                url: '{{ route('refresh.captcha') }}',
                success: function (data) {
                    $('.captcha .img-captcha').html(data);
                }
            });
        })
    </script>
@endpush
