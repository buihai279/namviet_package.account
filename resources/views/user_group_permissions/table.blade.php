@extends('layouts::master')
@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class=" container-fluid ">
            @include('layouts::components_v8.alerts')

            <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">
                                <span class="d-block  pt-2">Bảng phân quyền hệ thống CMS</span>
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="table table-separate table-head-custom table-checkable table-striped table-bordered table-hover"
                                id="">
                                <thead>
                                <tr>
                                    <th rowspan="3">Nhóm chức năng</th>
                                    <th rowspan="3">Chức năng</th>
                                    <th colspan="{{count(Arr::flatten($types,1))+1}}">Các Phòng ban</th>
                                </tr>
                                <tr>
                                    @foreach($userGroupTypes as $userGroupType)
                                        <th colspan="{{count($types[$userGroupType->name]??[1])}}">{{$userGroupType->name}}</th>
                                    @endforeach
                                    <th colspan="{{count($types[""])}}">Không thuộc phòng ban nào</th>
                                </tr>
                                <tr>
                                    @foreach($userGroupTypes as $key => $userGroupType)
                                        @if(empty($types[$userGroupType->name]))
                                            <th>-</th>
                                            @continue
                                        @endif
                                        @foreach($types[$userGroupType->name] as  $userGroup)
                                            <th>{{$userGroup->name}}</th>
                                        @endforeach
                                    @endforeach
                                    @foreach($types[""] as  $userGroup)
                                        <th>{{$userGroup->name}}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($codeGrs as  $codeGr)
                                    <tr>
                                        <td rowspan="{{count($codeGr['list'])+1}}">{{$codeGr['module_name']}}</td>
                                    </tr>
                                    @foreach($codeGr['list'] as  $code)
                                        <tr>
                                            <td>{{$code}}</td>
                                            @foreach($userGroupTypes as $key => $userGroupType)
                                                @if(empty($types[$userGroupType->name]))
                                                    <td>-</td>
                                                    @continue
                                                @endif
                                                @foreach($types[$userGroupType->name] as  $userGroup)
                                                    <td>
                                                        <input type="checkbox"
                                                               name="permissions[{{$userGroup->id}}][{{$code}}]">
                                                    </td>
                                                @endforeach
                                            @endforeach
                                            @foreach($types[""] as  $userGroup)
                                                <td>
                                                    <input type="checkbox"
                                                           name="permissions[{{$userGroup->id}}][{{$code}}]" {{in_array($code,$userGroup->permissions??[])?"checked" :""}}>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endforeach

                                </tbody>
                            </table>
                        </div>
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
@push('script_bottom')
    <!--begin::Page Vendors(used by this page)-->
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script type="text/javascript">
        "use strict";
        var KTDatatable = function () {

            var initTable1 = function () {
                // begin first table
                var table = $('#kt_datatable').DataTable({
                    responsive: false,
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
            KTDatatable.init();
        });

    </script>
@endpush

