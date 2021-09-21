@extends('vendor.layouts.base')
@push('head')
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{asset('vendor/theme/js/plugins/global/plugins.bundle.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('vendor/theme/css/style.bundle.css')}}" rel="stylesheet"
          type="text/css"/>
    <!--end::Global Stylesheets Bundle-->
@endpush
@section('body')
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Two-steps -->
        <div
            class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed"
            style="background-image: url(https://preview.keenthemes.com/metronic8/demo1/assets/media/illustrations/sketchy-1/14.png">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <!--begin::Logo-->
                <a href="https://preview.keenthemes.com/metronic8/demo1/demo1/dist/index.html" class="mb-12">
                    <img alt="Logo" src="{{asset('assets/custom/image/logo.png')}}"
                         class="h-40px"/>
                </a>
                <!--end::Logo-->
                <!--begin::Wrapper-->
                <div class="w-lg-600px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->
                    <form class="form w-100 mb-10" action="{{route('system.users.two_steps.verify')}}"
                          novalidate="novalidate" id="kt_sing_in_two_steps_form">
                        <!--begin::Icon-->
                        <div class="text-center mb-10">
                            <img alt="Logo" class="mh-125px"
                                 src="https://preview.keenthemes.com/metronic8/demo1/assets/media/svg/misc/smartphone.svg"/>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Heading-->
                        <div class="text-center mb-10">
                            <!--begin::Title-->
                            <h1 class="text-dark mb-3">
                                {{__('notice.two_step_verification')}}
                            </h1>
                            <!--end::Title-->
                            <!--begin::Sub-title-->
                            <div class="text-muted fw-bold fs-5 mb-5">
                                {{__('notice.enter_the_verification_code')}}
                            </div>
                            <!--end::Sub-title-->
                            <!--begin::Mobile no-->
                            <div class="fw-bolder text-dark fs-3">{{Auth::user()->mobile}}</div>
                            <!--end::Mobile no-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Section-->
                        <div class="mb-10 px-md-10">
                            <!--begin::Label-->
                            <div class="fw-bolder text-start text-dark fs-6 mb-1 ms-1">
                                {{__('notice.type_security_code')}}
                            </div>
                            <!--end::Label-->
                            <!--begin::Input group-->
                            <div class="d-flex flex-wrap flex-stack">
                                <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1"
                                       class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary  mx-1 my-2"
                                       value=""
                                       name="v_input_1"/>
                                <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1"
                                       class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary  mx-1 my-2"
                                       value=""
                                       name="v_input_2"/>
                                <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1"
                                       class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary  mx-1 my-2"
                                       value=""
                                       name="v_input_3"/>
                                <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1"
                                       class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary  mx-1 my-2"
                                       value=""
                                       name="v_input_4"/>
                                <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1"
                                       class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary  mx-1 my-2"
                                       value=""
                                       name="v_input_5"/>
                                <input type="text" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1"
                                       class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary  mx-1 my-2"
                                       value=""
                                       name="v_input_6"/>
                            </div>
                            <!--begin::Input group-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Submit-->
                        <div class="d-flex flex-center">
                            <button type="button" id="kt_sing_in_two_steps_submit"
                                    class="btn btn-lg btn-primary fw-bolder">
                                <span class="indicator-label">{{__('form.button.submit')}}</span>
                                <span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Submit-->
                    </form>
                    <!--end::Form-->
                    <!--begin::Notice-->
                    <div class="text-center fw-bold fs-5">
                        <span class="text-muted me-1">{{ __('label.didnt_get_the_code') }}</span>
                        <a href="javascript:window.location.href=window.location.href"
                           class="link-primary fw-bolder fs-5 me-1">{{ __('label.resend') }}</a>
                        {{--                        <span class="text-muted me-1">or</span>--}}
                        {{--                        <a href="#" class="link-primary fw-bolder fs-5">Call Us</a>--}}
                    </div>
                    <!--end::Notice-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Two-stes-->
    </div>
    <!--end::Main-->
    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{asset('vendor/theme/js/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{asset('vendor/theme/js/scripts.bundle.js')}}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{asset('assets/v8/js/custom/authentication/sign-in/two-steps.js')}}"></script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
@endsection
