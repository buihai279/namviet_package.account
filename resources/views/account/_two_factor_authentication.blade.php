<!--begin::Title-->
<h2>Chọn 1 phương thức xác thực người dùng</h2>
<!--end::Title-->
<!--begin::Options-->
<div data-kt-element="options">
    <!--begin::Notice-->
    <p class="text-muted fs-5 fw-bold mb-10">Ngoài tên username và mật khẩu, bạn sẽ phải nhập mã (được gửi qua ứng dụng
        hoặc SMS) truy cập vào các tính năng có yêu cầu bảo mật 2 lớp </p>
    <!--end::Notice-->
    <!--begin::Wrapper-->
    <div class="pb-10">

        <!--begin::Apps-->
        <div class="" data-kt-element="apps">
            <!--begin::Form-->
            <form data-kt-element="apps-form" class="form" method="POST"
                  action="{{route('account.verifyAuthCode',$data->id)}}">
            @csrf
            <!--begin::Heading-->
                <h3 class="text-dark fw-bolder mb-7">Authenticator Apps</h3>
                <!--end::Heading-->
                <!--begin::Description-->
                <div class="text-gray-500 fw-bold fs-6 mb-10">
                    Sử dụng ứng dụng xác thực như Google Authenticator, Microsoft Authenticator, Authy hoặc 1Password,
                    <a href="https://support.google.com/accounts/answer/1066447?hl=en"
                       target="_blank">Google Authenticator</a>,
                    <a href="https://www.microsoft.com/en-us/account/authenticator"
                       target="_blank">Microsoft Authenticator</a>,
                    <a href="https://authy.com/download/" target="_blank">Authy</a>, or
                    <a href="https://support.1password.com/one-time-passwords/"
                       target="_blank">1Password</a> quét mã QR. Nó sẽ tạo ra một mã gồm 6 chữ số để bạn nhập vào bên
                    dưới.
                    <!--begin::QR code image-->
                    <div class="pt-5 text-center">
                        <img src="{!! $qrImg !!}" alt="" class="mw-150px"/>
                    </div>
                    <!--end::QR code image-->
                </div>
                <!--end::Description-->
                <!--begin::Notice-->
                <div
                    class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-10 p-6">
                    <!--begin::Icon-->
                    <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                    <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                             height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                  rx="10" fill="black"/>
                            <rect x="11" y="14" width="7" height="2" rx="1"
                                  transform="rotate(-90 11 14)" fill="black"/>
                            <rect x="11" y="17" width="2" height="2" rx="1"
                                  transform="rotate(-90 11 17)" fill="black"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <!--end::Icon-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-grow-1">
                        <!--begin::Content-->
                        <div class="fw-bold">
                            <div class="fs-6 text-gray-700">Nếu bạn gặp sự cố khi sử dụng
                                mã QR, chọn mục nhập thủ công trên ứng dụng của bạn và nhập
                                tên người dùng của bạn và mã:
                                <div class="fw-bolder text-dark pt-2">
                                    {{chunk_split($secret,4,' ')}}
                                </div>
                            </div>
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Notice-->
                <!--begin::Input group-->
                <div class="mb-10 fv-row">
                    <input type="text"
                           class="form-control form-control-lg form-control-solid" hidden
                           value="{{$secret}}" name="authenticator_secret"/>
                    <input type="text"
                           class="form-control form-control-lg form-control-solid"
                           placeholder="Nhập mã xác thực " name="authenticator_code"/>
                </div>
                <!--end::Input group-->

                <!--begin::Actions-->
                <div class="d-flex flex-center">
                    <button type="submit" data-kt-element="sms-submit"
                            class="btn btn-primary">
                        <span class="indicator-label">{{__('Lưu mã xác thực')}}</span>
                    </button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Apps-->
        <!--begin::Form-->
        <form data-kt-element="apps-form" class="form" action="#">
            <!--begin::SMS-->
            <div class="" data-kt-element="sms">
                <!--begin::Heading-->
                <h3 class="text-dark fw-bolder fs-3 mb-5">SMS: Xác minh số điện thoại di động của bạn</h3>
                <!--end::Heading-->
                <!--begin::Notice-->
                <div class="text-muted fw-bold mb-10">Nhập số điện thoại với mã quốc gia
                </div>
                <!--end::Notice-->
                <!--begin::Form-->
                <!--begin::Input group-->
                <div class="mb-10 fv-row">
                    <input type="text" name="mobile"
                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                           placeholder="{{__('validation.attributes.mobile')}}"
                           value="{{old('mobile',$data->mobile??'')}}"/>
                </div>
                <!--end::Input group-->
            </div>
            <!--end::SMS-->
            <!--begin::Actions-->
            <div class="d-flex flex-center">
                <button type="reset" data-kt-element="sms-cancel"
                        class="btn btn-light me-3">Cancel
                </button>
                <button type="submit" data-kt-element="sms-submit"
                        class="btn btn-primary">
                    <span class="indicator-label">{{__('form.button.submit')}}</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Options-->
    <!--end::Action-->
</div>
<!--end::Options-->
