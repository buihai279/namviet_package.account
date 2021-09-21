@extends('layouts.master')
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
                        @include('components.notice')
                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-lg-12">
                        <!--begin::Card-->
                        <div class="card card-custom card-stretch p-20">

                            <div class="card-header">
                                <div class="card-title">
														<span class="card-icon">
															<i class="flaticon2-bell-2 icon-2x text-primary"></i>
														</span>
                                    <h3 class="card-label">Thông báo chung
                                        <small>Danh sách thông báo</small></h3>
                                </div>
                                <div class="card-toolbar">
                                    <form action="{{route('system.user.notification.markAsReadAll')}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-skype  ">
                                            <i class="flaticon2-check-mark text-white text-hover-white"></i>
                                            Đánh dấu đã đọc hết
                                        </button>
                                    </form>
                                    <form action="{{route('system.user.notification.destroyAll')}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn text-danger btn-bg-white "
                                                onclick="confirm('Dữ liệu sẽ không thể khôi phục. Bạn có chắc chắn muốn xóa toàn bộ thông báo không ?')">
                                            <i class="fas fa-bell-slash text-white"></i>
                                            Xóa hết thông báo
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    @if($notifications->isNotEmpty())
                                        @foreach($notifications as $notification)
                                            <tr>
                                                <td class="p-6 @if($notification->unread()) bg-dark-o-20 @endif ">
                                                    <a href="{{route('system.user.notification.view', $notification->_id)}}"
                                                       class="text-dark">
                                                        <!--begin::Item-->
                                                        <div class="d-flex align-items-center">
                                                            <!--begin::Symbol-->
                                                            <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                        <span class="symbol-label">
                                                                {!! $notification['data']['icon_html']??'' !!}
                                                        </span>
                                                            </div>
                                                            <!--end::Symbol-->
                                                            <!--begin::Text-->
                                                            <div class="d-flex flex-column font-size-base">
                                                    <span href="#"
                                                          class="text-dark mb-1 font-size-lg">
                                                        {!! $notification['data']['title']??'' !!}
                                                    </span>
                                                                <span
                                                                    class="">{!! $notification['data']['content']??'' !!}</span>
                                                                <div
                                                                    class="text-muted font-size-sm">{{ $notification['created_at']->format('H:i:s d-m-Y')??'' }}</div>
                                                            </div>
                                                            <!--end::Text-->
                                                        </div>
                                                        <!--end::Item--></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        Hết thông báo :(
                                    @endif
                                </table>
                                {{ $notifications->links() }}
                            </div>
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
