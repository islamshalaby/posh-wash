<?php

namespace App\Http\Controllers;

use App\DayTime;
use App\Order;
use App\OrderDetail;
use App\OrderTime;
use App\Plan_details;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Helpers\APIHelpers;
use App\Plan;
use App\User;


class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['select_all_plans', 'getpricing', 'excute_pay', 'excute_order', 'pay_sucess', 'pay_error', 'excute_pay2', 'day_times']]);
    }

    public function day_times(Request $request)
    {
        $now = Carbon::now()->format('Y-m-d');
        $validator = Validator::make($request->all(), [
            'selected_date' => 'required|date_format:Y-m-d|after_or_equal:' . $now,
            'plan_id' => 'required|exists:plans,id',
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true, 406, $validator->errors()->first(), $validator->errors()->first(), null, $request->lang);
            return response()->json($response, 406);
        }

        $day = date('w', strtotime($request->selected_date));
        
        $data['plan_info'] = Plan::findOrFail($request->plan_id);
        // $setting = Setting::find(1);

        $available_times = DayTime::where('plan_id', $request->plan_id)->where('day', $day)->select('id', 'time_from', 'time_to', 'work_time', 'usage_number')
            ->get()
            ->makeHidden(['OrderTimes']);

        $data['available_times'] = [];

        for ($i = 0; $i < count($available_times); $i++) {
            
            if (($available_times[$i]->OrderTimes2($request->selected_date) < $available_times[$i]->usage_number)) {
                $data['available_times'][] = $available_times[$i];
            }
        }


        for ($n = 0; $n < count($data['available_times']); $n++) {
            // var_dump($data['available_times'][$n]->time_to);
            // var_dump($data['available_times'][$n + 1]->time_from);
            if ($n + 1 < count($data['available_times']) && trim($data['available_times'][$n]->time_to) != trim($data['available_times'][$n + 1]->time_from)) {
                array_splice($data['available_times'], $n +1, $data['plan_info']->work_hours - 1);
            }
        }

        $response = APIHelpers::createApiResponse(false, 200, '', '', $data, $request->lang);
        return response()->json($response, 200);
    }

    public function add_cart(Request $request)
    {
        $now = Carbon::now()->format('Y-m-d');
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'order_date' => 'required|date_format:Y-m-d|after_or_equal:' . $now,
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'plan_id' => 'required|exists:plans,id',
            'address_id' => 'required|exists:user_addresses,id',
            'selected_times' => 'required|array',
        ]);
        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true, 406, $validator->errors()->first(), $validator->errors()->first(), null, $request->lang);
            return response()->json($response, 406);
        }
        $user = auth()->user();
        if ($user) {
            if ($user->active == 0) {
                $response = APIHelpers::createApiResponse(true, 406, 'تم حظر حسابك', 'تم حظر حسابك', null, $request->lang);
                return response()->json($response, 406);
            }
            $day = date('w', strtotime($request->order_date));
            $plan = Plan::where('id', $request->plan_id)->select('work_hours')->first();
            $plan_day_times = DayTime::where('plan_id', $request->plan_id)->where('day', $day)->where('id', '>=', $request->selected_times[0])->take($plan->work_hours)->get();
            if (count($plan_day_times) != $plan->work_hours) {
                $response = APIHelpers::createApiResponse(true, 406, 'This time is not available for this plan', 'هذا الموعد غير متاح لهذه الباقة', null, $request->lang);
                return response()->json($response, 406);
            }
            // loop on plan day times and check if number order times is less than usage number
            foreach ($plan_day_times as $plan_day_time) {
                if ($plan_day_time->OrderTimes2($request->order_date) >= $plan_day_time->usage_number) {
                    $response = APIHelpers::createApiResponse(true, 406, 'This time is not available for this plan', 'هذا الموعد غير متاح لهذه الباقة', null, $request->lang);
                    return response()->json($response, 406);
                }
            }
            // dd($plan_day_times);
            $input['user_id'] = $user->id;
            unset($data['selected_times']);
            $input['order_date'] = $request->order_date;
            $input['category_id'] = $request->category_id;
            $input['sub_category_id'] = $request->sub_category_id;
            $input['plan_id'] = $request->plan_id;
            $input['address_id'] = $request->address_id;
            $order_details = OrderDetail::create($input);
            
            //loop on plan day times
            $i = 0;
            foreach ($plan_day_times as $plan_day_time) {
                $order_time['order_details_id'] = $order_details->id;
                $order_time['time_id'] = $plan_day_time->id;
                $order_time['start'] = 0;
                $order_time['order_date'] = \Carbon\Carbon::parse($request->order_date)->timestamp;
                if ($i == 0) {
                    $order_time['start'] = 1;
                }
                OrderTime::create($order_time);
                $i ++;
            }
            $response = APIHelpers::createApiResponse(false, 200, '', '', $data, $request->lang);
            return response()->json($response, 200);
        } else {
            $response = APIHelpers::createApiResponse(true, 406, 'you should login first', 'يجب تسجيل الدخول اولا', null, $request->lang);
            return response()->json($response, 406);
        }
    }
    
    public function remove_from_cart(Request $request, $cart_id) {
        $user = auth()->user();
        $orderDetails = OrderDetail::where('id', $cart_id)->first();
        $orderDetails->Times()->delete();
        $orderDetails->delete();
        $data = OrderDetail::where('user_id', $user->id)->where('order_id', null)->with(['Plan', 'Category'])->get();

        $response = APIHelpers::createApiResponse(false, 200, '', '', $data, $request->lang);
            return response()->json($response, 200);
    }

    //cart
    public function get_cart(Request $request)
    {
        $user = auth()->user();
        Session::put('lang', $request->lang);
        $data['cart'] = OrderDetail::where('user_id', $user->id)->where('order_id', null)->with(['Plan', 'Category'])->get();
        $total = 0;
        foreach ($data['cart'] as $row) {
            $total = $total + $row->Plan->price;
        }
        $data['total'] = $total;
        $response = APIHelpers::createApiResponse(false, 200, '', '', $data, $request->lang);
        return response()->json($response, 200);
    }

    //orders
    public function my_orders(Request $request)
    {
        $user = auth()->user();
        Session::put('lang', $request->lang);
        $data = Order::where('user_id', $user->id)->orderBy('created_at','desc')->get();
        $response = APIHelpers::createApiResponse(false, 200, '', '', $data, $request->lang);
        return response()->json($response, 200);
    }

    public function order_details(Request $request, $id)
    {
        $user = auth()->user();
        Session::put('lang', $request->lang);
        $data['order'] = Order::whereId($id)->first();
        $first_detail = OrderDetail::with('Address')->where('order_id', $id)->first();
        $data['order_address'] = $first_detail->Address;
        $data['order_details'] = OrderDetail::with(['Plan', 'Category','Address'])->where('order_id', $id)->get();
        $response = APIHelpers::createApiResponse(false, 200, '', '', $data, $request->lang);
        return response()->json($response, 200);
    }

    public function item_details(Request $request, $id)
    {
        $user = auth()->user();
        Session::put('lang', $request->lang);
        $data['details'] = OrderDetail::with(['Times','Plan', 'Category','Address'])->where('id', $id)->first();
        $data['plan_details'] = Plan_details::select('id', 'title_' . $request->lang . ' as title')->where('plan_id', $data['details']->plan_id)->get();
        $response = APIHelpers::createApiResponse(false, 200, '', '', $data, $request->lang);
        return response()->json($response, 200);
    }

    public function place_order(Request $request) {
        Session::put('lang', $request->lang);
        $user = auth()->user();
        if ($user) {
            if ($user->active == 0) {
                $response = APIHelpers::createApiResponse(true, 406, 'تم حظر حسابك', 'تم حظر حسابك', null, $request->lang);
                return response()->json($response, 406);
            }
            $input['user_id'] = $user->id;
            $order_details = OrderDetail::where('user_id', $user->id)->where('order_id', null)->get();
            
            if (count($order_details) > 0) {
                $total = 0;
                foreach ($order_details as $row) {
                    $total = $total + $row->Plan->price;
                }
                $root_url = $request->root();
                $ResponseUrl=$root_url . "/api/order/decode_order";
                $ErrorUrl=$root_url . "/api/order/error";
                $url = APIHelpers::knet($total, $ResponseUrl, $ErrorUrl, $user->id, $total);
                $response = APIHelpers::createApiResponse(false, 200, '', '', ["url" => $url], $request->lang);
                return response()->json($response, 200);
            } else {
                $response = APIHelpers::createApiResponse(true, 406, 'you should fill cart first', 'يجب ملاء السلة اولا', null, $request->lang);
                return response()->json($response, 406);
            }
        }
    }

    public function excute_order(Request $request)
    {
        $data = $request->all();
        
        if ($request->result == 'CAPTURED') {
            $input['user_id'] = $request->udf1;
            $order_details = OrderDetail::where('user_id', $input['user_id'])->where('order_id', null)->get();

            if (count($order_details) > 0) {
                $input['total'] = $request->udf2;
                // loop on order details
                for($i = 0; $i < count($order_details); $i ++) {
                    $order_details[$i]->Times()->update(['order_times.status' => 'done']);
                }
                
                $order = Order::create($input);
                if ($order) {
                    OrderDetail::where('user_id', $input['user_id'])->where('order_id', null)->update(['order_id' => $order->id]);
                }
                return redirect()->route('order_success');
            } else {
                return redirect()->route('order_error');
            }
        }
        
        
    }

    public function excute_pay2(Request $request) {
        //$ResErrorText= $_REQUEST['ErrorText']; 	  	//Error Text/message
        $ResPaymentId = $_REQUEST['paymentid'];		//Payment Id
        $ResTrackID = $_REQUEST['trackid'];       	//Merchant Track ID
        //$ResErrorNo = $_REQUEST['Error'];           //Error Number
        $ResResult =  $_REQUEST['result'];          //Transaction Result
        $ResPosdate = $_REQUEST['postdate'];        //Postdate
        $ResTranId = $_REQUEST['tranid'];           //Transaction ID
        $ResAuth = $_REQUEST['auth'];               //Auth Code
        $ResAVR = $_REQUEST['avr'];                 //TRANSACTION avr
        $ResRef = $_REQUEST['ref'];                 //Reference Number also called Seq Number
        $ResAmount = $_REQUEST['amt'];              //Transaction Amount
        $Resudf1 = $_REQUEST['udf1'];               //UDF1
        $Resudf2 = $_REQUEST['udf2'];               //UDF2

        //Below Terminal resource Key is used to decrypt the response sent from Payment Gateway.
        $termResourceKey=env("KNET_RESOURCE_KEY");

        //if($ResErrorText==null && $ResErrorNo==null)
        // {

        /*IMPORTANT NOTE - MERCHANT SHOULD UPDATE
                        TRANACTION PAYMENT STATUS IN MERCHANT DATABASE AT THIS POSITION
                        AND THEN REDIRECT CUSTOMER ON RESULT PAGE*/
        $ResTranData= $_REQUEST['trandata'];

        if($ResTranData !=null)
        {
            //Decryption logice starts
            $decrytedData=APIHelpers::decrypt($ResTranData,$termResourceKey);

            return redirect()->route('excute_order', $decrytedData);
        }

    }

    public function getpricing(Request $request)
    {
        $plans = Plan::select('id', 'ads_count', 'price')->get();
        $response = APIHelpers::createApiResponse(false, 200, '', '', $plans, $request->lang);
        return response()->json($response, 200);
    }

    public function buyplan(Request $request)
    {
        $user = auth()->user();
        if ($user->active == 0) {
            $response = APIHelpers::createApiResponse(true, 406, 'تم حظر حسابك', 'تم حظر حسابك', null, $request->lang);
            return response()->json($response, 406);
        }

        $validator = Validator::make($request->all(), [
            'plan_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true, 406, 'بعض الحقول مفقودة', 'بعض الحقول مفقودة', null, $request->lang);
            return response()->json($response, 406);
        }

        $plan = Plan::find($request->plan_id);
        $root_url = $request->root();

        $path = 'https://api.myfatoorah.com/v2/SendPayment';
        $token = "bearer AeIvp3c6BK2hHMYhFeFSMEavoQdS65m_b8B_HyInpkJBInEEa_LeYH6kllPD_doZVm9Vpye370HhGrLtz6hGeoThWJrsJiHqrn_ezFRGjcvsZ1EyeHQ7S1DUP6AkYVdhbVb2jpS03wrlSnv82_Gj8U9FyA0HU-Epi3OZkwk4GZ7F7F0vwZdVD-ZkPpYtNephrWip4v-cI0nsUbAtP1ntkk7W17FGc3dSYSnCofLRWgqO04Dl1orOZSsiWlZV6upE3SwiQFJfZQXRVxDEnrpjkD7GCejDVjKJJG3hByuI0LHLyY9GAfAikDFKffZPeqjDQLqcFUFdEPHlrzh27JQvM_gGwPGJnNKspzgI1rzevSUBYSqKWj4R0fwXuCtu2rrKk8ZmcaLnTRbtwsl1oO_ZUBoZMZkAx0-H3b-vQHYC5Ti2W406-rCZ0Oayea6S0uyHGvafL7CEhrr_zBizI4SjD-s7pinUUyohw2OiPN5J7dmksJtXKVDrxPLO1Uy8nQ0vvlcDcuRaBbAW1ekis49zGTceIPKs01fA6juHpiYGSmd2NfFCYMuYTGS9NaTPbhAka3a7ipoQnwKogexvUqCAr9ttpi7X8Vb3JnlpYmUq6e1y2KQTc0YPsrkPloDYbQMAZUIleuAS0pxvIFbrk9N45gDsIiPhF_Rq4jE6BCBp2V0nMKqKBZf2zrMSD1EZdw0gPwG2GXZYs-f-xQXPCs9JFAHipOK_OS8_hzCHji8leokMW8Mt";

        $headers = array(
            'Authorization:' . $token,
            'Content-Type:application/json'
        );
        $price = $plan->price;
        $call_back_url = $root_url . "/api/excute_pay?user_id=" . $user->id . "&plan_id=" . $request->plan_id;
        $error_url = $root_url . "/api/pay/error";
        $fields = array(
            "CustomerName" => $user->name,
            "NotificationOption" => "LNK",
            "InvoiceValue" => $price,
            "CallBackUrl" => $call_back_url,
            "ErrorUrl" => $error_url,
            "Language" => "AR",
            "CustomerEmail" => $user->email
        );

        $payload = json_encode($fields);
        $curl_session = curl_init();
        curl_setopt($curl_session, CURLOPT_URL, $path);
        curl_setopt($curl_session, CURLOPT_POST, true);
        curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURLOPT_IPRESOLVE);
        curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);
        $result = curl_exec($curl_session);
        curl_close($curl_session);
        $result = json_decode($result);
        $response = APIHelpers::createApiResponse(false, 200, '', '', $result->Data->InvoiceURL, $request->lang);
        return response()->json($response, 200);

    }

    public function excute_pay(Request $request)
    {
        $plan = Plan::find($request->plan_id);
        $new_ads_count = $plan->ads_count;
        $user = User::find($request->user_id);
        $paid_ads = $user->paid_ads_count;
        $user->paid_ads_count = $paid_ads + $new_ads_count;
        $user->save();
        return redirect('api/pay/success');
    }

    public function pay_sucess()
    {
        return "Please wait ...";
    }

    public function pay_error()
    {
        return "Please wait ...";
    }

    public function select_all_plans(Request $request, $cat_id)
    {
        $lang = $request->lang;
        Session::put('api_lang', $lang);
        $data = Plan::with('Details')
            ->where('cat_id', $cat_id)
            ->orwhere('cat_id', 'all')
            ->where('status', 'show')
            ->where('deleted', '0')
            ->select('id', 'title_' . $lang . ' as title', 'price')
            ->get();
        $response = APIHelpers::createApiResponse(false, 200, '', '', $data, $request->lang);
        return response()->json($response, 200);
    }

    public function plan_details(Request $request, $plan_id)
    {
        $lang = $request->lang;
        Session::put('api_lang', $lang);
        $data = Plan_details::
        where('plan_id', $plan_id)->where('status', 'show')
            ->select('id', 'title_' . $lang . ' as title')
            ->get();
        $response = APIHelpers::createApiResponse(false, 200, '', '', $data, $request->lang);
        return response()->json($response, 200);
    }
}
