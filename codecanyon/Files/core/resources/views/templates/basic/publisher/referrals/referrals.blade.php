@extends($activeTemplate.'layouts.publisher.frontend')

@section('panel')
<form action="{{ route('publisher.referrals.insert') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row justify-content-center mb-none-30">
        
     <div class="col-lg-8 col-md-9 mb-30">
            <div class="card profile-update-card">
                <div class="card-body px-5 py-2">
                    <div class="form-group">
                        <div class="image-upload">
                            <div class="thumb">
                                <div class="avatar-preview">
                                    <div class="profilePicPreview" style="background-image: url({{ get_image('assets/publisher/images/profile/'. auth()->guard('publisher')->user()->image) }})">
                                        <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label class="form-control-label font-weight-bold">@lang('Advertise List')</label>
                                <select name="country[]" class="form-control select2-multi-select" id="advertises" required></select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label class="form-control-label font-weight-bold">@lang('Advertise description')</label>
                                <textarea id="description" class="form-control" ></textarea> 
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group previewAdvertisement"></div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('script')
<script>
    "use strict";
    (function($){
        var url = "{{route('getName')}}";
        $.get(url, function (result, state) {
            result.forEach(function (cn) {
                $('#advertises').append('<option value="' + cn + '">' + cn + '</option>')
            });
        })
    })(jQuery);
</script>

@endpush