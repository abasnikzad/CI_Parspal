## کتابخانه ی درگاه پرداخت پارسپال ( جدید ) برای فریمورک کدایگنایتر 
#آموزش نصب و استفاده :‌
برای استفاده از این کتابخانه کافی است فایل کتابخانه Parspal.php  این ریپوزیتوری را دانلود کنید و در مسیر application/libraries کپی کنید . 
این کتابخانه در کل دو عدد تابع داره که یکی به نام request برای ارسال کاربر به صفحه ی پرداخت است و یک تابع دیگر به نام verify برای اعتبارسنجی پرداخت است . به همین سادگی ! 
-------------- برای نصب کردن مراحل زیر را به ترتیب طی کنید -------------
* فایل Parspal.php را از این بخش دانلود کنید . 
* فایل Parspal.php را به مسیر application/libraries کپی کنید . 
* در کنترلری و متدی که میخواهید پرداخت پارسال انجام پذیرد کتابخانه را به این شکل صدا بزنید $this->load->library('parspal',$params); 

