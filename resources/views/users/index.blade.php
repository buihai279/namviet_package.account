@extends('layouts.master')
@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class=" container ">
            @include('components.notice')

            <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">
                                <span class="d-block  pt-2">Danh sách tài khoản</span>
                            </h3>
                            <a href="{{route('system.user.add')}}"
                               class="btn btn-success">Thêm mới</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table
                            class="table table-separate table-head-custom table-checkable table-striped table-bordered table-hover"
                            id="kt_datatable">
                            <thead>
                            <tr>
                                <th>Tên đầy đủ</th>
                                <th>Username</th>
                                <th>Ảnh</th>
                                <th>Trạng thái tài khoản</th>
                                <th>Nhóm quyền</th>
                                <th>Được tạo bởi</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->fullname}}</td>
                                    <td>
                                        {{'@'.$user->username}}
                                        @if($user->code==='SYS_ADMIN')
                                            <span class="label label-inline label-light-success font-weight-bold">
                                                SYS_ADMIN
                                            </span>
                                        @endif
                                    </td>
                                    <td><img src="{{Helper::getDataFiles($user,'avatar', false)}}" width="100px"
                                             height="auto" alt=""></td>
                                    <td>{{config('const.status_active')[$user->status]??''}}</td>
                                    <td>{{$userGroups[(string)$user->user_group]??''}}</td>
                                    <td>{!! $user->user?$userNameList[(string)$user->user]:'' !!}</td>
                                    <td>{{Helper::transformDate($user->created)}}</td>
                                    <td>
                                        {{-- TÀI KHOẢN SYS ADMIN KHÔNG ĐƯỢC TÁC ĐỘNG--}}
                                        <a href="{{route('system.user.admin_edit', $user->_id)}}"
                                           class="btn btn-info">Sửa
                                            tài khoản</a>

                                        <a href="{{route('system.user.block', $user->_id)}}"
                                           class="btn  {{$user->status===0?'btn-default':'btn-warning'}}">{{$user->status===0?'Mở khóa':'Khóa'}}
                                            tài khoản</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->
@endsection
@section('script_bottom')
    <!--begin::Page Vendors(used by this page)-->
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script type="text/javascript">
        "use strict";
        var KTDatatablesSearchOptionsAdvancedSearch = function () {

            var initTable1 = function () {
                // begin first table
                var table = $('#kt_datatable').DataTable({
                    responsive: true,
                    // "dom": '<"top"ilp<"clear">>rt<"bottom"ilp<"clear">>',
                    lengthMenu: [20, 50],
                    pageLength: 30,
                    language: i18n.datatable,
                });
            };
            return {
                //main function to initiate the module
                init: function () {
                    initTable1();
                },
            };
        }();
        jQuery(document).ready(function () {
            KTDatatablesSearchOptionsAdvancedSearch.init();
        });

    </script>
@endsection

