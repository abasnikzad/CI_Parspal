<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter Parspal Library
 *
 * This library enables parspal payment in your codeigniter project
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Abas Nikzad
 * @link	 https://avasam.ir
 */

class Parspal
{
    /**
	 * Send Request to parspal
	 *
	 * this method send your request to parspal
	 *
	 */
    public function request($data)
    {
      /*
      * request requirements
      */
      $apikey      = $data['ApiKey'];
      $reserve_id  = $data['reserved_id'];
      $order_id    = $data['order_id'];
      $amount      = $data['amount'];
      $return_url  = $data['return_url'];
      $description = $data['description'];
      /*
      * payer informations (optional)
      */
      $payer_name =$data['payer_name'];
      $payer_mobile = $data['payer_mobile'];
      $payer_email = $data['payer_email'];

      $postData = array(
          'amount' => $amount,
          'return_url' => $return_url,
          'description' => $description,
          'reserve_id' => $reserve_id,
          'order_id' => $order_id,
          'payer' => array(
              'name' =>$payer_name,
              'mobile' =>$payer_mobile,
              'email' =>$payer_email,
          )
      );
      $curl = curl_init();

      curl_setopt($curl, CURLOPT_POST, TRUE);
      curl_setopt($curl, CURLOPT_URL, "https://api.parspal.com/v1/payment/request");
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          "APIKEY: " . $apikey,
          "Content-Type: application/json"
      ));
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      $result = curl_exec($curl);
      if (!$result) {
          die("Connection Failure");
      }
      curl_close($curl);
      $response = json_decode($result, true);
      $status  = $response["status"];
      if ($status == "ACCEPTED") {
          $payment_link = $response["link"];// مسیر پرداخت
          $payment_id   = $response["payment_id"];// شناسه یا کد پیگیری درخواست پرداخت که می توانید در بازگشت و یا در مواردی برای استعلام از آن استفاده نمایید
          redirect($payment_link);   // به منظور پرداخت می بایست کاربر را به این مسیر ریدایرکت نمایید
      } else {
          $message = $response["message"];// توضیحات فارسی در رابطه با وضعیت درخواست
          echo "خطا در ثبت درخواست پرداخت! وضعیت خطا : " . $status . " - توضیحات : " . $message;
      }
    }

    /**
    * Verify Parspal Payment
    *
    * this method verify user payment
    *
    */
    public function verify($data){
        /*
        * verify requirements
        */
        $amount = $data['amount'];
        $apikey = $data['ApiKey'];
        $status = $data['status'];


        if(isset($status) && $status == 100){

            $receipt_number = $data['receipt_number'];
            $reserve_id     = $data['reserve_id'];
            $order_id       = $data['order_id'];

            $postData = array(
                'amount' => $amount,
                'receipt_number' => $receipt_number
            );
            $curl     = curl_init();
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_URL, 'https://api.parspal.com/v1/payment/verify');
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "APIKEY: " . $apikey,
                "Content-Type: application/json"
            ));
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

            $result = curl_exec($curl);
            if (!$result) {
                die("Connection Failure");
            }
            curl_close($curl);
            $response = json_decode($result, true);
            $status  = $response["status"];
            if ($status == "SUCCESSFUL") {
                // success pay

                $verify_data = array(
                  'is_success'=>true,
                  'receipt_number'=>$receipt_number,
                );
                return $verify_data;
            } else {
                // pay failed

                $message = $response["message"];
                $verify_data = array(
                  'is_success'=>false,
                  'status'=>$status,
                  'message'=>$message,
                );
                return $verify_data;
            }
        }
        else
        {
            $verify_data = array(
              'is_success'=>false,
              'status'=>$status,
              'message'=>'',
            );
            if(!isset($status))
                $verify_data['message'] = 'اطلاعاتی از صفحه پرداخت دریافت نشد !';
            else if($status == 99)
                $verify_data['message'] = 'کاربر عزیز شما از پرداخت منصرف شدید';
            else if($status == 88)
                $verify_data['message'] = 'پرداخت ناموفق بوده است';
            else if($status == 77)
                $verify_data['message'] = 'کاربر عزیز شما پرداخت را لغو کردید';
            return $verify_data;
        }
    }


}
