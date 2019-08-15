<?php

namespace App\Http\Controllers;

use Yansongda\Pay\Pay;
use Illuminate\Http\Request;

class PayController extends Controller
{
    protected $config = [
        'alipay' => [
            'app_id' => '2016101000654228',
            'notify_url' => 'http://localhost/03kj/blog/public/api/pay/notify',
            'return_url' => 'http://localhost/03kj/blog/public/api/pay/return',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqQIVnZLMTgOAtz0U3WjJfZGZ3bUpAg/yTQvYT/hwSTcZpvZ69BbprRvTU7S6HfaldvwP/IP/dEZmoH+tqpXsPqkFbwtvhy5CyuLiCcGKL0j8BUjVNs2166HV3uYHC39c3zLTtbsMN3lx3hsSNOKt88K/X8SHBz53rxfES+2fbwIx1MRgOVO7tO1SogIZLcD+1OmZRYkcmnwlAz7qenrXkbq3Hm4CUi73PsEZDaIctfN8REPFCr2B0tbIfrroWkqJsR5b2IyfowISkv5FqudV3d+WifJOmXYrmM7MK9ank8QLsJNrlnJoafmrRl4xziEQor2Lh6nqr0vqbWbz9s2XIQIDAQAB',
            'private_key' => 'MIIEowIBAAKCAQEAtDYYPJB4uAzoH7Gpp+oDQUFrjlOlO9GzSm7Qs1Rwb/Yhzlsl1UxEyFon7W5aFwgVCXuoBTYSY6e1IA0hNyb7lLZLxVU3v9osaX0XDXQy52xNi7+OT9/6kiGiNn9rmWON+Od5RsQYHUhjzdCmnu8i/IjZ+nOFfPb95JKNRjxrvE21l0OLuZUhEAW5PciNIV39xeFLd/Gv5tck3tPwfUZUzMAjYVWPDA6SO6C8E/Z6vNSuVOELx4Kwgd2vX8wsUJJrqjJAJ0z21RiJ9xoKWuO5CWgedqFSblHM9ZMeYnVEx1+pLD3so3ZZQZyGx8YLsHC5L5zIKjE67r75hrmnTYXCqQIDAQABAoIBACEx9bTyR8pfVkLATygHCyJyEoXdEoq6TfRgBUGDRFLbW87PK2Dm86SUNtadhSrI6lcc2A5dr3V75vlIcd3e6Gi0S7DFycclQRkNWbm4tce7Q22Ck4xTDaztVRwEzKUsmXJH8Sb/6BE8zGWVEZwlIKSz8LMZpHUoagw4kp1lc9Lzjlaa2BrPcADOJKLoqfbRMfshniVnLOim3at+3etRYdn9eqIT3EqG6V7DEE/nPwiKs+17N6F3+F/Y/Z7ab3NU9w2HKBQT/cLBjCWrBmYtnh+Lzl5qDNVxFnsexl2wcIfATxhbLPfWF7VfptjrDnKyPNFBEi/LV0krjKEushA3lIECgYEA32zql0fjNhlPFSVNXzaSje0HPUEZsBomo9nbn6H4Qlhb76gORhraJxoqruOdR267d8JsJgHhD3MIoOKHNlZ6bTiktOK3U4NNcmn0UViKaBJt4+/673+hCjKdXuAnGHCUcPFUyiyW64TZFYqpQCjbxvXWE+9lsk8DBc6AQsb6B+UCgYEAznxDRGX/uhmH30fe1FqGtlRHnx10Bu2w4P2UMWzg4Nh/lkyQxwaDOPbJB4cMXz+kOvqjnLlBZjGU0DtGWqBBgd5V8zGqzhj5xMeGKqX5iwt2y4dR1R3lm6cyHI0wLuE1nSgzf141c0Mjiy7SVSmU9N2zoWFblcLKlqbZeOgPG3UCgYEAkRHOTIX/0KukPq2mzFDJ3d9umOZBQKfqOO+G++KWKLXok/bBteFPjp4d4sql37DVhpA12oPT100w6A3OD4kdGvfxcgXXVSFnUwfa/EqKK8LzmVHD1GhBbzaoGedfWy4WJDN+g3tqTuhGcAdFmAQvl8MdynnhxWIqK0YG39UEmcUCgYA8A5Hph1vUUydSlikFv2n4BHbsoDrg6KTIP+uakfKqZ0JuBMLvlcz9+XxkW7QU2wJ4wfBb1NxVP4PpIdFI9dsUS/LfREhIrqmpr/Qm4Sauax6T+TinoJDjtKyz77VZasuSaeTN2Cvg3FqwUWOArR1GLknPVeSwmnUXZFdA9PGvIQKBgFqjuoBU2H0LfdjrMS3SSo6k5eC7LyB5he3qMrZmTaohhWhCFw4oRWmL1CvcHQl2Sb50Vq+eiHSWXXfNgRZYVkuILxRJ/8RtoTRPGaFwpeV/xP61UvJkh3yoswkZBipNq2yIFxLBHwFwFmCwGbMNYfmq3e9YnjF7ys9/Cwfo459F',
        ],
    ];

    public function index(Request $request)
    {
        $config_biz = [
            'out_trade_no' => $request->input('a'),
            'total_amount' => $request->input('oid'),
            'subject'      => 'test subject',
        ];

        $pay = new Pay($this->config);

        return $pay->driver('alipay')->gateway()->pay($config_biz);
    }

    public function return(Request $request)
    {
        $pay = new Pay($this->config);

        return $pay->driver('alipay')->gateway()->verify($request->all());
    }

    public function notify(Request $request)
    {
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->all())) {
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。 
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号； 
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）； 
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）； 
            // 4、验证app_id是否为该商户本身。 
            // 5、其它业务逻辑情况
            file_put_contents(storage_path('notify.txt'), "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单号：' . $request->out_trade_no . "\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单金额：' . $request->total_amount . "\r\n\r\n", FILE_APPEND);
        } else {
            file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }
}
