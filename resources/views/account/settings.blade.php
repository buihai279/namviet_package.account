@extends('layouts::type_layout.basic')
@push('head')
@endpush
@section('container')
    <!--begin::Navbar-->

    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <!--begin: Pic-->
                <div class="me-7 mb-4">
                    <div
                        class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img src="{{$data->avatar_url}}" alt=""/>
                    </div>
                </div>
                <!--end::Pic-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div
                        class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a href="#"
                                   class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">
                                    {{$data->fullname}}
                                </a>

                            </div>
                            <!--end::Name-->
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                <a href="#"
                                   class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                    <i class="la la-mailchimp"></i>
                                    {{$data->email}}</a>
                            </div>
                            <!--end::Info-->
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                <a href="#"
                                   class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                    <i class="la la-mailchimp"></i>
                                    {{$data->mobile}}</a>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                        <!--begin::Actions-->
                        <!--end::Actions-->
                    </div>
                    <!--end::Title-->
                    <!--begin::Stats-->
                    <!--end::Stats-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->
            <!--begin::Navs-->
            <div class="d-flex overflow-auto h-55px">
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">

                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6 active"
                           href="{{route('account.settings')}}">Settings</a>
                    </li>
                    <!--end::Nav item-->
                </ul>
            </div>
            <!--begin::Navs-->
        </div>
    </div>
    <!--end::Navbar-->
    <!--begin::Sign-in Method-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_account_signin_method">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Sign-in Method</h3>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Content-->
    @include('views::account._security_account')
    <!--end::Content-->
    </div>
    <div class="card mb-5 mb-xl-10">
        <div class="card-body border-top p-9">
            <!--begin::Modals-->
            <!--begin::Modal - Two-factor authentication-->
        @include('views::account._two_factor_authentication')
        <!--end::Modal - Two-factor authentication-->
            <!--end::Modals-->
        </div>
    </div>
    <!--end::Sign-in Method-->
    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_account_profile_details" aria-expanded="true"
             aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Profile Details</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
    @include('views::account._profile_detail')
    <!--end::Content-->
    </div>
    <!--end::Basic info-->
@endsection
@push('script_bottom')
    <script src="{{asset('assets/v8/js/custom/account/settings/signin-methods.js')}}"></script>
    {{--    <script src="{{asset('assets/v8/js/custom/modals/two-factor-authentication.js')}}"></script>--}}
@endpush
