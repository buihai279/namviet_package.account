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
                                <span class="d-block  pt-2">Phân quyền hệ thống CMS theo chức năng</span>
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-2">
                                <label class="font-weight-bold"><h4>Phòng ban - vai trò:</h4></label>
                                <p class="text-danger font-size-h5-md font-weight-boldest">Chọn nhóm quyền trước, sau đó
                                    phân quyền </p>
                                <div
                                    class="accordion accordion-light accordion-light-borderless accordion-svg-toggle"
                                    id="accordionExample7">
                                    @foreach($userGroupTypes as $userGroupType)
                                        @if(!empty($types[(string)$userGroupType->_id]))
                                            <div class="card">
                                                <div class="card-header" id="heading{{$userGroupType->_id}}">
                                                    <div class="card-title" data-toggle="collapse"
                                                         data-target="#collapse{{$userGroupType->_id}}">
                                                        <i class="la la-angle-double-right"></i>
                                                        <div class="card-label pl-4">{{$userGroupType->name}}</div>
                                                    </div>
                                                </div>
                                                <div id="collapse{{$userGroupType->_id}}" class="collapse show"
                                                     data-parent="#accordionExample7">
                                                    <div class="card-body pl-12">
                                                        <table class="table table-bordered  table-hover">
                                                            @foreach($types[(string)$userGroupType->_id] as $item)
                                                                <tr>
                                                                    <td class="{{request()->get('user_group')===(string)$item->_id?'font-size-h3-md table-success':''}}">
                                                                        <a href="{{route('system.user_group_permission.index',['user_group'=>$item->_id])}}">
                                                                            {{$item->name}}
                                                                        </a></td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @if(!empty($types[""]))
                                        <div class="card">
                                            <div class="card-header" id="heading0">
                                                <div class="card-title" data-toggle="collapse show"
                                                     data-target="#collapse0">
                                                    <i class="la la-angle-double-right"></i>
                                                    <div class="card-label pl-4">Không thuộc phòng ban</div>
                                                </div>
                                            </div>
                                            <div id="collapse0" class="collapse show"
                                                 data-parent="#accordionExample7">
                                                <div class="card-body pl-12">
                                                    <table class="table table-bordered table-hover">
                                                        @foreach($types[""] as $item)
                                                            <tr>
                                                                <td>
                                                                    <a href="{{route('system.user_group_permission.index',['user_group'=>$item->_id])}}">
                                                                        {{$item->name}}
                                                                    </a></td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="font-weight-bold"><h4>Chọn quyền theo chức năng:</h4></label>
                                <p class="text-muted">Dưới đây là các quyền mà nhóm người dùng chưa được phân bổ</p>
                                <select id="multiselect" class="form-control border-4" size="25"
                                        multiple="multiple">
                                    @foreach($codeGrs as $module)
                                        <optgroup label="{{$module['module_vi']??$module['module_name']}}">
                                            @foreach($module['list'] as $key => $item)
                                                <option value="{{$key}}">{{$item}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 pt-25">
                                <button type="button" id="multiselect_undo" class="d-block btn btn-default mb-4">Hoàn
                                    tác <i class="fas fa-undo"></i>
                                </button>
                                <button type="button" id="multiselect_rightAll" class="d-block btn btn-default  mb-4">
                                    Thêm hết <i class='fas fa-angle-double-right'></i>
                                </button>
                                <button type="button" id="multiselect_rightSelected"
                                        class="d-block btn btn-default  mb-4">
                                    Thêm <i class='fas fa-angle-right'></i>
                                </button>
                                <button type="button" id="multiselect_leftSelected"
                                        class="d-block btn btn-default  mb-4">
                                    Bỏ <i class='fas fa-angle-left'></i>
                                </button>
                                <button type="button" id="multiselect_leftAll" class="d-block btn btn-default  mb-4">
                                    Bỏ hết <i class='fas fa-angle-double-left'></i>
                                </button>
                                <button type="button" id="multiselect_redo" class="d-block btn btn-default  mb-4">Làm
                                    lại <i class="fas fa-redo"></i>
                                </button>
                            </div>
                            <div class="col-lg-4">
                                <form class="form" method="POST"
                                      action="{{route('system.user_group_permission.edit',$userGroup['_id'] ??'0')}}">
                                    @csrf
                                    <label class="font-weight-bold"><h4>Quyền hạn được phân bổ:</h4></label>
                                    <p class="text-muted">Các quyền của nhóm người dùng được phân bổ sẽ khả dụng khi
                                        đăng nhập lại</p>
                                    <label>
                                        <span class="font-weight-bold">
                                            Nhóm quyền/ Nhóm người dùng:
                                            <span class="bg-info-o-95 p-1">{{$userGroup['name']??''}}</span>
                                        </span>
                                    </label>
                                    @if(request()->get('user_group'))
                                        <select name="permissions[]" id="multiselect_to"
                                                class="form-control mb-10 border-4"
                                                size="25"
                                                multiple="multiple">
                                            @foreach(config('permission.codes') as $module)
                                                @if(!empty($userGroup['permissions']) && !empty(array_intersect($userGroup['permissions'], array_keys($module['list']))))
                                                    <optgroup label="{{$module['module_vi']??$module['module_name']}}">
                                                        @foreach($module['list'] as $key => $item)
                                                            @if( in_array($key,$userGroup['permissions'] ))
                                                                <option value="{{$key}}">{{$item}}</option>
                                                            @endif
                                                        @endforeach
                                                    </optgroup>
                                                @endif
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary mr-2">Cập nhật quyền hạn</button>
                                        <a href="{{url()->full()}}" class="btn btn-secondary">Tải lại trang</a>
                                    @else
                                        <p class="text-danger font-weight-bold">Chưa chọn nhóm quyền nào</p>
                                    @endif
                                </form>
                            </div>
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
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{asset("assets/custom/multiselect.min.js")}}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('#multiselect').multiselect({
                search: {
                    left: '<input type="text" name="q" class="form-control" placeholder="Tìm kiếm tên quyền chưa có..." />',
                    right: '<input type="text" name="q" class="form-control" placeholder="Tìm kiếm tên quyền đã có..." />',
                },
                fireSearch: function (value) {
                    return value.length >= 1;
                }
            });
        });
    </script>

@endpush

