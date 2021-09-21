@extends('layouts::master')
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
                                <span class="d-block  pt-2">Danh sách phòng/ ban</span>
                            </h3>
                            <a href="{{route('system.user_group_type.add')}}"
                               class="btn btn-success">Thêm mới</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table
                            class="table table-separate table-head-custom table-checkable table-striped table-bordered table-hover"
                            id="kt_datatable">
                            <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Mô tả</th>
                                <th>Trạng thái</th>
                                <th>Được tạo bởi</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($userGroupTypes as $userGroupType)
                                <tr>
                                    <td>{{$userGroupType->name}}</td>
                                    <td>{{$userGroupType->description}}</td>
                                    <td>{{$userGroupType->status===1?'Kích hoạt':'Ngưng kích hoạt'}}</td>
                                    <td>{!! $userGroupType->user?$userNameList[(string)$userGroupType->user]:'' !!}</td>
                                    <td>{{Helper::transformDate($userGroupType->created)}}</td>
                                    <td>
                                        <a href="{{route('system.user_group_type.edit', $userGroupType->_id)}}"
                                           class="btn btn-info">Sửa</a>
                                        <form action="{{route('system.user_group_type.toggle', $userGroupType->_id)}}"
                                              method="POST">
                                            @csrf
                                            @if($userGroupType->status===1)
                                                <button class="btn btn-warning form-delete">Ngưng kích hoạt</button>
                                            @else
                                                <button class="btn btn-secondary">Kích hoạt</button>
                                            @endif
                                        </form>
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
    <script src="{{asset('assets/js/pages/features/miscellaneous/sweetalert2.js?v=7.1.8')}}"></script>
    <script>
        $(".form-delete").click(function (e) {
            $this = $(this);
            e.preventDefault();
            Swal.fire({
                title: "Bạn có chắc chắc muốn NGƯNG KÍCH HOẠT phòng/ban này?",
                text: "Sau khi NGƯNG KÍCH HOẠT, phòng/ban không thể đăng nhập vào hệ thống!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "NGƯNG KÍCH HOẠT!",
                cancelButtonText: "Hủy bỏ thao tác"
            }).then(function (result) {
                if (result.value) {
                    $this.closest("form").submit();
                }
            });
        });
    </script>
@endsection

