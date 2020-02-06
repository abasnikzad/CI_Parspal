# **Parspal gateway library for codeigniter framework .** 

This library allows payment through 

[**Parspal**]: https://parspal.com

 for all **codeigniter** projects . 

This is a single library works on **Parspal API's** . 

this library tested on **Codeigniter 3.1.11** .

---------------------------------------------

### Installation 

Follow the steps below to install :‌

1. Download this repository ***.zip** and unzip it.

2. copy **Parspal.php** file to **application/libraries** folder .****

3. open your controller that you want to make payments there  and call this library using : 

     `$this->load->library('parspal');`

4. now for send payment request call request method from this library . example : 

   

   ```php
   $data = array('
       ApiKey'=>'d0a4f3d4d*************',
       'order_id'=>null,
       'amount'=>100000,
       'return_url'=>'site.com/parspal/back',
       'description'=>'پرداخت صورت حساب آقای ایکس',
       'payer_name'=>'آقای ایکس',
       'payer_mobile'=>'09350000000',
       'payer_email'=>'mrx@gmail.com',
       reserved_id'reserved_id'=>152,
       );
   $this->parspal->request($data);
   ```


   All **required payment information** is sent to this method as **<u>array</u>** . 

5. verifty payment when back from Parspal gateway by this : 
   `$this->parspal->verify($data);`


   **$data** must be the information required for verify payment like this : 

   ```php
     $data = array(
       'amount'=> $amount ,
       'ApiKey'=>'d0a4f3d4db044365b33bfc240ce3a989',
       'status'=>$status,
       'receipt_number'=>$receipt_number,
       'reserve_id'=>$reserve_id,
     );
   ```