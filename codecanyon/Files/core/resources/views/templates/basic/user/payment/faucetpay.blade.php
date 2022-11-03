@extends($activeTemplate.'layouts.advertiser.frontend')


@section('panel')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card card-deposit">
                    <div class="card-header bg--primary ">
                        <h5 class="card-title text--white">@lang('FaucetPay Payment')</h5>
                    </div>
                    <div class="card-body card-body-deposit">

                        <div class="card-wrapper"></div>
                        <br><br>

                        <form role="form" id="payment-form" method="{{$data->method}}" action="{{$data->url}}">
                            {{csrf_field()}}
                            <input type="hidden" value="{{$data->track}}" name="track">
                            <input type="hidden" value="{{$data->amount}}" name="amount">
                            <input type="hidden" value="{{$data->currency }}" name="currency ">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                        </div>
                                        <input type="email" class="form-control form-control-lg custom-input" name="email"
                                               placeholder="@lang('apollyon@outlook.com')" autocomplete="off" autofocus/>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn--primary btn-lg btn-block text-center faucetpay_connect"> @lang('PAY NOW')</button>
                                </div>
                            </div>
                            <br>

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('script')
    <script type="text/javascript" src="https://rawgit.com/jessepollak/card/master/dist/card.js"></script>

    <script>
      
        (function ($) {
            'use strict'
            $(document).ready(function () {
                var amount = $("input[name=amount]").val();
                var currency = $("input[name=currency]").val();
                var to = $("input[name=email]").val();

                $(".faucetpay_connect").on('click', function(){
                    $.ajax({  
                        url: 'https://faucetpay.io/api/listv1/faucetlist',  
                        type: 'POST',
                        headers: 'Access-Control-Allow-Origin: *',
                        dataType: 'jsonp',
                        data:{
                            api_key: 'b73543be40ea14501cb1a7831be3f4eecf886a47',
                        },
                        success: function(data, textStatus, xhr) {  
                            console.log(data);  
                        }
                    });  
                });
            });
        })(jQuery);
    </script>
@endpush
