<?php

namespace App\Http\Controllers\Gateway\faucetpay;

use App\Deposit;
use App\GeneralSetting;
use App\Http\Controllers\Gateway\PaymentController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class ProcessController extends Controller
{

    /*
     * Faucetpay Gateway
     */
    public static function process($deposit)
    {

        $alias = $deposit->gateway->alias;

        $send['track'] = $deposit->trx;
        $send['amount'] = $deposit->amount;
        $send['currency'] = $deposit->method_currency;
        $send['view'] = 'user.payment.'.$alias;
        $send['method'] = 'post';
        $send['url'] = route('ipn.'.$alias);
        return json_encode($send);
    }

    public function ipn(Request $request)
    {
      $track = Session::get('Track');
      $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
      if ($data->status == 1) {
          $notify[] = ['error', 'Invalid Request.'];
          return redirect()->route(returnUrl())->withNotify($notify);
      }
      $this->validate($request, [
          'email' => 'required'
      ]);

      PaymentController::userDataUpdate($data->trx);
      $notify[] = ['success', returnMsg()];

      return redirect()->route(returnUrl())->withNotify($notify);
    }
}
