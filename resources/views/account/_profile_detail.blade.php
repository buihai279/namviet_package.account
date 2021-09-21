<div id="kt_account_profile_details" class="collapse show">
    <!--begin::Form-->
    <form id="kt_account_profile_details_form" action="{{route('account.update')}}" method="POST" class="form">
    @csrf
    <!--begin::Card body-->
        <div class="card-body border-top p-9">
            <!--begin::Input group-->
            <div class="row mb-6">
                <!--begin::Label-->
                <label
                    class="col-lg-4 col-form-label required fw-bold fs-6">{{__('validation.attributes.fullname')}}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8">
                    <!--begin::Row-->
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-lg-6 fv-row">
                            <input type="text" name="fullname"
                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                   placeholder="{{__('validation.attributes.fullname')}}"
                                   value="{{old('fullname',$data->fullname??'')}}"/>
                        </div>
                        <!--end::Col-->
                    </div>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-6">
                <!--begin::Col-->
                <div class="col-lg-8">
                    <!--begin::Row-->
                    <div class="row">
                        <!--end::Form group-->
                    @include('layouts.partials.assets.js.custom_uppy')
                    @include('components.forms.uploads.uppy-common', ['fieldName'=>'avatar'])
                    <!--begin::Action-->
                    </div>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->
            <!--end::Row-->
            <!--begin::Input group-->
            <div class="row mb-6">
                <!--begin::Label-->
                <label
                    class="col-lg-4 col-form-label required fw-bold fs-6">{{__('validation.attributes.mobile')}}</label>
                <!--end::Label-->
                <div class="col-lg-8">
                    <!--begin::Row-->
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-lg-6 fv-row">
                            <input type="text" name="mobile"
                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                   placeholder="{{__('validation.attributes.mobile')}}"
                                   value="{{old('mobile',$data->mobile??'')}}"/>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-light btn-active-light-primary me-2">
                    {{__('Từ chối')}}
                </button>
                <button type="submit" class="btn btn-primary"
                        id="kt_account_profile_details_submit">{{__('Lưu')}}
                </button>
            </div>
            <!--end::Actions-->
        </div>
    </form>
    <!--end::Form-->
</div>
