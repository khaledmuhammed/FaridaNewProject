<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\User\OrderHistoryController;
use App\Notifications\{OrderNew, OrderNewAdmin};
use App\Services\Aramex;
use Auth, Log, GuzzleHttp;
use Validator;

class PaymentController extends Controller
{

    public function show(Request $request)
    {
        logger()->info("e-Payment", ['request' => $request->all()]);
        $orderId = explode("-", $request['TrackId'], 2)[0];
        $order = Order::find($orderId);
      if ($request['Result'] == 'Successful') {
        
        Payment::create([
          'order_id' => $order->id,
          'user_id' => Auth::user()?Auth::user()->id:null,
          'details' => json_encode($request->all())
        ]);

        // Add status preparing
        OrderHistoryController::addOrderHistory('',$order->id,Status::$PREPARING);

        try {
            $order->notify(new OrderNew($order));
        } catch (\Exception $e) {

        }

        try {
            User::find(1)->notify(new OrderNewAdmin($order));
        } catch (\Exception $e) {

        }
          
        session()->flash('success', 'تمت عملية الشراء بنجاح');
        return redirect()->to('/orders/'.$order->id);
      }
      // Add status payment failed
      OrderHistoryController::addOrderHistory('',$order->id,Status::$PAYMENT_FAILED);
      \Log::error('Payment error[3]: ',['route'=>'payment.show','request' => $request->all()]);
      session()->flash('error', 'خطأ في عملية الدفع، الرجاء التأكد من المعلومات أو المحاولة في وقت لاحق');
      return redirect()->to('/orders/'.$order->id);
    }

    /**
     * @param Request $request
     * @return array|bool|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function getCheckoutUrl($order)
    {

      $trackid = $order->id."-".rand(000,999);

      $txn_details = "".$trackid.
      "|".config('services.urway.terminalId').
      "|".config('services.urway.password').
      "|".config('services.urway.key').
      "|".$order->total_price.
      "|".config('services.urway.currency');

      $hash = hash('sha256', $txn_details);
      $host = gethostname();
      $ip = gethostbyname($host);  

      $fields = array(
        'trackid' => $trackid,
        'transid' => $trackid,
        'terminalId' => config('services.urway.terminalId'),
        'customerEmail' => $order->email,
        'address' => '',
        'city' => $order->city->name,
        'state' => $order->city->name,
        'zipCode' => 00000,
        'customerName' => $order->username,
        'cardHolderName'=> $order->username,
        'action' => 1, // 1 = Purchase
        'instrumentType' => "DEFAULT",
        'merchantIp' => $ip,
        'password'=> config('services.urway.password'),
        'currency' => config('services.urway.currency'),
        'country' => 'SA',
        'amount' => $order->total_price,
        'udf2' => route('payment.show'),
        'udf3'=>"",
        'udf1'=>"",
        'udf5'=>"",
        'udf4'=>"",
        'requestHash' => $hash
      );

      $data = json_encode($fields);

      $url = config('services.urway.url');
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data))
      );
      curl_setopt($ch, CURLOPT_TIMEOUT, config('services.urway.timeout'));
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, config('services.urway.timeout'));

      //execute post
      $result = curl_exec($ch);
                            
      //close connection
      curl_close($ch);

      if($result != NULL){
  
        $urldecode=(json_decode($result,true));  
        logger()->info('urldecode', [$urldecode]);
                      
        if(isset($urldecode['payid'] )) {
                          
          if (strpos($urldecode['targetUrl'], '?') !== false) {
            $url = $urldecode['targetUrl']."paymentid=".$urldecode['payid'];
          } else {
            $url = $urldecode['targetUrl']."?paymentid=".$urldecode['payid'];
          }

          return [
            "checkoutUrl" => $url,
            "order_id"   => $order->id,
          ];

        } else {

          logger()->error('error', [$urldecode]);
          return [
            "error" => 'Payment Error'
          ];
                          
        }
                          
      } else {
        logger()->error('error', ["Server is down."]);
        return [
          "errot" => 'Server is down'
        ];
      }
    }

}
