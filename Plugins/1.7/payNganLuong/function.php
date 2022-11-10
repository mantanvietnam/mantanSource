<?php
require_once("lib/nganluong/config.php");
require_once("lib/nganluong/nganluong.class.php");

$menus= array();
$menus[0]['title']= 'Cài đặt Ngân Lượng';
$menus[0]['sub'][0]= array('name'=>'Cài đặt','classIcon'=>'fa-users','url'=>$urlPlugins.'admin/payNganLuong-setting.php','permission'=>'payNganLuongSetting');

addMenuAdminMantan($menus);

function createPayNL($money=0, $fullName='', $phone='', $email='', $orderID='')
{
    global $urlHomes;

    /*THANH TOÁN TIỀN NGÂN LƯỢNG*/
    if ($money > 0) {
        $text = 'Fullname: '.$fullName.'. Phone: '.$phone.'. orderID: '.$orderID;

        //Khai báo url trả về 
        $return_url= $urlHomes . '?stt=3-'.$orderID;

        // Link nut hủy đơn hàng
        $cancel_url= $urlHomes . '?stt=4-'.$orderID;

        $txh_name = $fullName;
        $txt_email = $email;
        $txt_phone = $phone;


        $order_code = "Order ID ".$orderID;

        //Thông tin giao dịch
        $transaction_info="Purchase payment";
        $currency= "usd";
        $quantity=1;
        $tax=0;
        $discount=0;
        $fee_cal=0;
        $fee_shipping=0;
        $order_description=$text;
        $buyer_info=$txh_name."*|*".$txt_email."*|*".$txt_phone;
        $affiliate_code="";

        //Khai báo đối tượng của lớp NL_Checkout
        $nl= new NL_Checkout();
        $nl->nganluong_url = 'https://www.nganluong.vn/checkout.php';
        $nl->merchant_site_code = '36680';
        $nl->secure_pass = 'matkhauketnoi';

        $receiver = "tranmanhbk179@gmail.com";

        //Tạo link thanh toán đến nganluong.vn

        $url= $nl->buildCheckoutUrlExpand($return_url, $receiver, $transaction_info, $order_code, $money, $currency, $quantity, $tax, $discount , $fee_cal, $fee_shipping, $order_description, $buyer_info, $affiliate_code);

        if ($order_code != "") {

            $url .='&cancel_url='. $cancel_url;
            
            echo '<meta http-equiv="refresh" content="0; url='.$url.'" >';
        }
    }
}

?>