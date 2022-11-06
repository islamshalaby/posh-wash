<?php
namespace App\Helpers;

class APIHelpers
{

    // format the response for the api
    public static function createApiResponse($is_error, $code, $message_en, $message_ar, $content, $lang)
    {
        if ($lang == 'en') {
            $message = $message_en;
        } else {
            $message = $message_ar;
        }
        $result = [];
        if ($is_error) {
            $result['success'] = false;
            $result['code'] = $code;
            $result['message'] = $message;
        } else {
            $result['success'] = true;
            $result['code'] = $code;
            if ($content == null) {
                $result['message'] = $message;
                $result['data'] = [];
            } else {
                $result['data'] = $content;
            }
        }
        return $result;
    }

    // get month year for the api
    public static function get_month_year($created_at, $lang)
    {
//        $month = $created_at->format('F');
//        if ($lang == 'ar') {
//            if ($month == 'January') {
//                $month = 'يناير';
//            } else if ($month == 'February') {
//                $month = 'فبراير';
//            } else if ($month == 'March') {
//                $month = 'مارس';
//            } else if ($month == 'April') {
//                $month = 'ابريل';
//            } else if ($month == 'May') {
//                $month = 'مايو';
//            } else if ($month == 'June') {
//                $month = 'يونيو';
//            } else if ($month == 'July') {
//                $month = 'يوليو';
//            } else if ($month == 'August') {
//                $month = 'أغسطي';
//            } else if ($month == 'September') {
//                $month = 'سبتمبر';
//            } else if ($month == 'October') {
//                $month = 'أكتوبر';
//            } else if ($month == 'November') {
//                $month = 'نوفمبر';
//            } else if ($month == 'December') {
//                $month = 'ديسمبر';
//            }
//        } else {
//            $month = $created_at->format('F');
//        }
//        return $created_at->format('Y') . ' ' . $month;
        return $created_at;
    }

    // get month day for the api
    public static function get_month_day($created_at, $lang)
    {
//        $month = $created_at->format('F');
//        if ($lang == 'ar') {
//            if ($month == 'January') {
//                $month = 'يناير';
//            } else if ($month == 'February') {
//                $month = 'فبراير';
//            } else if ($month == 'March') {
//                $month = 'مارس';
//            } else if ($month == 'April') {
//                $month = 'ابريل';
//            } else if ($month == 'May') {
//                $month = 'مايو';
//            } else if ($month == 'June') {
//                $month = 'يونيو';
//            } else if ($month == 'July') {
//                $month = 'يوليو';
//            } else if ($month == 'August') {
//                $month = 'أغسطي';
//            } else if ($month == 'September') {
//                $month = 'سبتمبر';
//            } else if ($month == 'October') {
//                $month = 'أكتوبر';
//            } else if ($month == 'November') {
//                $month = 'نوفمبر';
//            } else if ($month == 'December') {
//                $month = 'ديسمبر';
//            }
//        }
//        $day = $created_at->format('l');
//        if ($lang == 'ar') {
//            if ($day == 'Saturday') {
//                $day = 'السبت';
//            } else if ($day == 'Sunday') {
//                $day = 'الاحد';
//            } else if ($day == 'Monday') {
//                $day = 'الاثنين';
//            } else if ($day == 'Tuesday') {
//                $day = 'الثلاثاء';
//            } else if ($day == 'Wednesday') {
//                $day = 'الاربعاء';
//            } else if ($day == 'Thursday') {
//                $day = 'الخميس';
//            } else if ($month == 'Friday') {
//                $day = 'الجمعة';
//            }
//        }
//        $time = $day . ',' . $month . ' ' . $created_at->format('d,Y');
        $time = $created_at;
        return $time;
    }

    // calculate the distance
    public static function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    // send fcm notification
    public static function send_notification($title, $body, $image, $data, $token)
    {

        $message = $body;
        $title = $title;
        $image = $image;
        $path_to_fcm = 'https://fcm.googleapis.com/fcm/send';
        $server_key = "AAAAYfhkvC0:APA91bE1fNeZ8QcCEP4Mu1morxzgkYHvEFRomo6SKB3gPF6Is6DQEwBIrzkbGMt22wpUOO--Mb2MZZJB60xhW8kLgM4uLRqQWetaessj49Nw5nI8aj2JXzZaAbzVt2IlJlAF8znAMzTv";

        $headers = array(
            'Authorization:key=' . $server_key,
            'Content-Type:application/json'
        );

        $fields = array('registration_ids' => $token,
            'notification' => array('title' => $title, 'body' => $message, 'image' => $image));

        $payload = json_encode($fields);
        $curl_session = curl_init();
        curl_setopt($curl_session, CURLOPT_URL, $path_to_fcm);
        curl_setopt($curl_session, CURLOPT_POST, true);
        curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURLOPT_IPRESOLVE);
        curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);
        $result = curl_exec($curl_session);
        curl_close($curl_session);
        return $result;
    }

    public static function send_chat_notification($tokens, $title = "hello", $msg = "helo msg", $type = 1, $chat = null, $jobs = null)
    {
        $key = 'AAAAYfhkvC0:APA91bE1fNeZ8QcCEP4Mu1morxzgkYHvEFRomo6SKB3gPF6Is6DQEwBIrzkbGMt22wpUOO--Mb2MZZJB60xhW8kLgM4uLRqQWetaessj49Nw5nI8aj2JXzZaAbzVt2IlJlAF8znAMzTv';
        $fields = array
        (
            "registration_ids" => (array)$tokens,  //array of user token whom notification sent two
//            "registration_ids" => (array)'diLndYfZRFyxw8nOjU5yt0:APA91bGYE5TyP2VjgUHHEuCP5-dMEoY8K4AgEl_JuWYjcFyJxS1MamBtJhmp4y-q-lhYWF6AXvy9OpgOJJsJyJ5qSNCHFvSR3iWODWVb84NkbnpZYcuNL0mkforreA89wcwrHuntJdaG',
            "priority" => 10,
            'data' => [ // android developer
                'title' => $title,
                'body' => $msg,
                'chat' => $chat,
                'type' => $type,
                'icon' => 'myIcon',
                'sound' => 'mySound',
                'jobs' => $jobs
            ],
            'notification' => [  // ios developer
                'title' => $title,
                'body' => $msg,
                'chat' => $chat,
                'type' => 3,
                'icon' => 'myIcon',
                'sound' => 'mySound',
                'jobs' => $jobs
            ],
            'vibrate' => 1,
            'sound' => 1
        );

        $headers = array
        (
            'accept: application/json',
            'Content-Type: application/json',
            'Authorization: key=' . $key
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    static function decrypt($code,$key) {
        $code =  self::hex2ByteArray(trim($code));
        $code=self::byteArray2String($code);
        $iv = $key;
        $code = base64_encode($code);
        $decrypted = openssl_decrypt($code, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        return self::pkcs5_unpad($decrypted);
    }

    static function hex2ByteArray($hexString) {
        $string = hex2bin($hexString);
        return unpack('C*', $string);
    }


    static function byteArray2String($byteArray) {
        $chars = array_map("chr", $byteArray);
        return join($chars);
    }


    static function pkcs5_unpad($text) {
        $pad = ord($text[strlen($text)-1]);
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }

    //AES Encryption Method Starts
    static function encryptAES($str,$key) {
        $str = self::pkcs5_pad($str);
        $encrypted = openssl_encrypt($str, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $key);
        $encrypted = base64_decode($encrypted);
        $encrypted=unpack('C*', ($encrypted));
        $encrypted=self::byteArray2Hex($encrypted);
        $encrypted = urlencode($encrypted);
        return $encrypted;
    }

    static function pkcs5_pad ($text) {
        $blocksize = 16;
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    static function byteArray2Hex($byteArray) {
        $chars = array_map("chr", $byteArray);
        $bin = join($chars);
        return bin2hex($bin);
    }

    public static function knet($TranAmount, $ResponseUrl, $ErrorUrl, $udf1, $udf2, $udf3="Test3", $udf4="Test4", $udf5="Test5") {
        $TranportalId=env('TRANPORTAL_ID');
        $ReqTranportalPassword="password=" . env('TRANPORTAL_PASSWORD');
        $ReqCurrency="currencycode=414";
        $ReqLangid="langid=AR";
        $ReqAction="action=1";
        $termResourceKey=env("KNET_RESOURCE_KEY");
        $TranTrackid=mt_rand();
        $ReqTranportalId="id=".$TranportalId;
        $ReqAmount="amt=".$TranAmount;
        $ReqTrackId="trackid=".$TranTrackid;
        /* Response URL where Payment gateway will send response once transaction processing is completed
        Merchant MUST esure that below points in Response URL
        1- Response URL must start with http://
        2- the Response URL SHOULD NOT have any additional paramteres or query string  */
        $ReqResponseUrl="responseURL=".$ResponseUrl;

        $ReqErrorUrl="errorURL=".$ErrorUrl;

        $ReqUdf1="udf1=" . $udf1;
        $ReqUdf2="udf2=" . $udf2;
        $ReqUdf3="udf3=" . $udf3;
        $ReqUdf4="udf4=" . $udf4;
        $ReqUdf5="udf5=". $udf5;

        $param=$ReqTranportalId."&".$ReqTranportalPassword."&".$ReqAction."&".$ReqLangid."&".$ReqCurrency."&".$ReqAmount."&".$ReqResponseUrl."&".$ReqErrorUrl."&".$ReqTrackId."&".$ReqUdf1."&".$ReqUdf2."&".$ReqUdf3."&".$ReqUdf4."&".$ReqUdf5;
        $param=self::encryptAES($param,$termResourceKey)."&tranportalId=".$TranportalId."&responseURL=".$ResponseUrl."&errorURL=".$ErrorUrl;
        $url = env('KNET_URL') . "&trandata=".$param;

        return $url;
    }
    
    public static function send_sms($message_body, $phone_number) {
        $phone = str_replace('+', '', $phone_number);
        $phone = str_replace(' ', '', $phone);
        $phone = ltrim($phone, "00");
        $path = "http://api.rmlconnect.net/bulksms/bulksms";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $path, ['query' => [
            'username' => env('RML_USERNAME'), 
            'password' => env('RML_PASSWORD'),
            'type' => "0",
            'dlr' => "1",
            'source'=> env('RML_SOURCE'),
            'message' => $message_body,
            'destination' => $phone
        ],'debug' => false]);
        // http://smsbox.com/smsgateway/services/messaging.asmx/Http_SendSMS?username=InstadealApp&password=instadeal@2021&customerid=2195&sendertext=InstaDeal&messagebody={message body}&recipientnumbers={phone number}&isblink=false&isflash=false&defDate=
        
        $res = json_decode((string) $response->getBody(), true);
        //dd($response);
        return $res;
    }
}

?>
