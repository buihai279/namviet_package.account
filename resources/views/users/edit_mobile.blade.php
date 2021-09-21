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
                    <div class="col-lg-6 m-auto">
                        @include('components.notice')
                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-lg-6 m-auto">
                        <!--begin::Card-->
                        <div class="card card-custom card-stretch p-20">
                            <form class="form" novalidate="novalidate" method="POST"
                                  action="{{route('system.user.update_mobile')}}" id="kt_login_signin_form">
                                @if ($errors->has('mobile'))
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
                                    <h2 class="font-weight-bolder text-dark font-size-h2">{{__('label.update_mobile.title')}}</h2>
                                </div>
                                <!--end::Title-->
                                <input hidden type="tel" disabled name="mobile" value="{{$data->mobile??''}}"/>
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label
                                            class="font-size-h6 font-weight-bolder text-dark pt-5">{{__('label.otp.mobile')}}</label>
                                    </div>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                           type="number" name="mobile" autocomplete="off"
                                           value="{{$data->mobile??''}}"
                                           placeholder="{{__('label.placeholder.mobile')}}"/>
                                </div>
                                <!--end::Form group-->
                                <!--begin::Action-->
                                <div class="text-center pt-2">
                                    <button id="kt_login_signin_submit" type="submit"
                                            class="btn btn-bg-info text-white  font-weight-bolder font-size-h6 px-8 py-4 my-3">
                                        {{__('label.update_mobile.title')}}
                                    </button>
                                    <button type="reset"
                                            class="btn btn-bg-secondary  font-weight-bolder font-size-h6 px-8 py-4 my-3">
                                        {{__('label.reset')}}
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
