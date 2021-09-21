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
                    <div class="col-lg-12">
                        <!--begin::Card-->
                        <div class="card card-custom card-stretch p-10">
                            <form class="form" novalidate="novalidate" method="POST"
                                  action="{{route('system.user_group_type.store')}}" id="kt_login_signin_form">
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
                                    <h2 class="font-weight-bolder text-dark font-size-h2 ">Thêm mới phòng/ban</h2>
                                </div>
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Tên: <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                           type="text" name="name" autocomplete="off"
                                           value="{{$data->name??''}}"/>
                                    <p class="text-muted">Ví dụ: Phòng Nội Dung - Nam Việt</p>
                                </div>
                                <!--end::Form group-->
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Mã phòng ban:
                                            <span class="text-danger">*</span></label>
                                    </div>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                           type="text" name="code" autocomplete="off"
                                           value="{{$data->code??''}}"/>
                                    <p class="text-muted">Trường này là thông tin nhạy cảm nên hạn chế đổi</p>
                                </div>
                                <!--end::Form group-->
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Mô tả ngắn: <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <textarea class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                              name="description" autocomplete="off"
                                    >{{$data->description??''}}</textarea>
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

                                <!--begin::Action-->
                                <div class="text-center pt-2">
                                    <button id="kt_login_signin_submit" type="submit"
                                            class="btn btn-bg-success text-white font-weight-bolder font-size-h6 px-8 py-4 my-3">
                                        Thêm mới
                                    </button>
                                    <button type="reset"
                                            class="btn btn-bg-secondary font-weight-bolder font-size-h6 px-8 py-4 my-3">
                                        Nhập lại
                                    </button>
                                </div>
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
