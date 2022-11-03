@extends($activeTemplate.'layouts.advertiser.frontend')
@php
    $user = auth()->guard('advertiser')->user();
@endphp
@section('panel')

    <div class="card">
        <div class="card-header bg--primary text-center">
            <h3 class="text-white">@lang('Type of Advertisements')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse ($types as $key => $type)
                    <div class="col-md-3 mb-4">
                        <div class="card shadow">
                            <div class="card-header bg--primary text-center">
                                {{ $type->adName }}
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">@lang('Type'): <strong>{{ $type->type }}</strong></li>
                                    <li class="list-group-item">@lang('Width'): <strong>{{ $type->type == 'Direct Link' || $type->type == 'Native' || $type->type == 'Pop ads' ? 'fixed' : $type->width.'px' }}</strong>
                                    </li>
                                    <li class="list-group-item">@lang('Height'): <strong>{{ $type->type == 'Direct Link' || $type->type == 'Native' || $type->type == 'Pop ads' ? 'fixed' : $type->height.'px' }}</strong>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer create">

                                @if ($user->impression_credit <=0 && $user->click_credit <= 0)
                                    <button 
                                        class="btn btn--secondary w-100 create_campaign" 
                                        type="button"
                                        data-name="{{ $type->adName }}"
                                        data-type="{{$type->type}}"
                                        data-slug="{{ $type->slug }}"
                                        data-id="{{ $type->id }}"
                                    >@lang('Create Ad')</button>
                                @endif
                                    <button 
                                        class="btn btn--secondary w-100 create_campaign" 
                                        type="button"
                                        data-name="{{ $type->adName }}"
                                        data-type="{{$type->type}}"
                                        data-slug="{{ $type->slug }}"
                                        data-id="{{ $type->id }}"
                                    >@lang('Create Campaign')</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-12"><h5 class="text-center py-3">@lang('No Ad types')</h5></div>
                @endforelse

            </div>
            <!-- /.row -->
        </div>
    </div>



    <!-- /modal -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header bg--primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('advertiser.ad.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="" name="adName">
                        <input type="hidden" value="" name="adtype">
                        <input type="hidden" value="" name="typeId" id="typeId">
                        <input type="hidden" value="{{ Auth::guard('advertiser')->user()->id }}" name="advertiser">
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Ad Title')<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" placeholder="Ad title" required>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold" for="my-select">@lang('Type')<span
                                    class="text-danger">*</span></label>
                            <select id="my-select" class="form-control" name="type" required>
                                <option value="click">@lang('Click')</option>
                                <option value="impression">@lang('Impression')</option>
                            </select>
                        </div>

                        <div class="form-group url_box">
                            <label class="font-weight-bold" for="exampleInputPassword1">@lang('Landing URL')<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="url" id="exampleInputPassword1"
                                   placeholder="e.g (https://site.com)">
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Keywords')<span class="text-danger">*</span>
                                <small>(@lang('Please use only suggested keywords'))</small> </label>
                            <select name="keywords[]" class="form-control select2-multi-select" id="keyword"
                                    multiple="multiple" required>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold" for="exampleInputPassword1">@lang('Target Country')<span
                                    class="text-danger">*</span></label>
                            <select name="country[]" class="form-control select2-multi-select" id="country"
                                    multiple="multiple" required>

                            </select>
                        </div>

                        <div class="custom-control custom-checkbox form-check-primary my-2">
                            <input type="checkbox" name="global" class="custom-control-input" id="customCheck21">
                            <label class="custom-control-label font-weight-bold"
                                   for="customCheck21">@lang('Target for global')</label>
                        </div>

                        <div class="form-group image_box">
                            <label class="font-weight-bold" for="exampleInputPassword1">@lang('Ad Image')<span
                                    class="text-danger">*</span> <small class="text-danger" id="slug"></small></label>
                            <img alt="" id="img" class="mb-2">
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                <input type="file" class="form-control-file prev" name="file" value="defualt.png"></li>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold" for="exampleInputPassword1">@lang('Budget')<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="budget" placeholder="Total budget..." required>
                        </div>

                        <div class="form-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang(' Status:')
                                <label class="switch">
                                    <input type="checkbox" name="status" id="checkbox">
                                    <div class="slider round"></div>
                                </label>
                            </li>
                        </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="close">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary">@lang('Save changes')</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

<!-- Button trigger modal -->

@push('script')
    <script>
        'use strict';
        (function ($) {
            $(".image_box").hide();
            var modal = $('#exampleModal');
            $('.create_campaign').on('click', function () {
                var adtype = $(this).data('type');
                switch(adtype){
                    case 'Direct Link':
                        $(".image_box").hide();
                        break;
                    case 'Pop ads':
                        $(".image_box").hide();
                        break;
                    case 'Native' :
                        $(".image_box").hide();
                        break;
                    default:
                        $(".image_box").show();
                        break;
                }
                $("#my-select").html('');
                $('#country').children().remove()
                var url = "{{route('countries')}}";
                $("#my-select").append('<option value = "' + $(this).data('type') + '">' + $(this).data('type') + '</option>');
                $.get(url, function (result, state) {
                    var country = result.forEach(function (cn) {
                        $('#country').append('<option value="' + cn + '">' + cn + '</option>')
                    });
                })
                $('#keyword').children().remove()
                var keywordUrl = "{{route('keywords')}}";
                $.get(keywordUrl, function (result, state) {
                    var keywords = result.forEach(function (cn) {
                        $('#keyword').append('<option value="' + cn + '">' + cn + '</option>')
                    });
                })

                $('.modal-title').text($(this).data('name'));
                $('#slug').text('(' + $(this).data('slug') + ')');
                $('#img').attr('src', $(this).data('defaultimage'));

                modal.find('input[name=adtype]').val($(this).data('type'));
                modal.find('input[name=typeId]').val($(this).data('id'));
                modal.find('input[name=adName]').val($(this).data('name'));
                modal.modal('show');
            });

            $('#close').on('click', function () {
                modal.find('input[type=file]').val('')
            })

            $(".prev").change(function () {
                readURL(this);
            });


            $('#customCheck21').change(function () {
                if ($(this).is(":checked")) {
                    $('#country').attr('disabled', true)
                } else {
                    $('#country').attr('disabled', false)
                }
            })


            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            } 
        })(jQuery); 
      
    </script>
   
      
  
@endpush
@push('style')
    <style>
        .prev {
            overflow: hidden;
        }
    </style>
@endpush
