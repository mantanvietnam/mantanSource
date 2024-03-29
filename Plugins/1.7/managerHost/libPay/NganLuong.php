﻿<?php
/******************************************************************************

	Ghi chú:hoàn thành ngày 28-08-2012
	Copyright :Hồ Minh Trí
	
*******************************************************************************/

class Admin_Model_NganLuong extends Admin_Model_System{
    
    // URL chheckout của nganluong.vn
    private $nganluong_url= 'http://sandbox.nganluong.vn/checkout.php';

    // Mã merchante site 
    // Biến này được nganluong.vn cung cấp khi bạn đăng ký merchant site
    private $merchant_site_code='668';

    // Mật khẩu bảo mật
    // Biến này được nganluong.vn cung cấp khi bạn đăng ký merchant site
    private $secure_pass='205649601';

    //Mã đối tác tham gia chương trình liên kết của NgânLượng.vn   
    private $affiliate_code='';
    
    
    /*--------------------------------------------------------------------------
        HÀM TẠO ĐƯỜNG LINK THANH TOÁN QUA NGÂNLƯỢNG.VN VỚI THAM SỐ MỞ RỘNG
     
     
        * @param string $return_url:                Đường link dùng để cập nhật tình trạng hoá đơn tại website của bạn khi người mua thanh toán thành công tại NgânLượng.vn
        * @param string $receiver:                  Địa chỉ Email chính của tài khoản NgânLượng.vn của người bán dùng nhận tiền bán hàng
        * @param string $transaction_info:          Tham số bổ sung,bạn có thể dùng để lưu các tham số tuỳ ý để cập nhật thông tin khi NgânLượng.vn trả kết quả về
        * @param string $order_code:                Mã hoá đơn hoặc tên sản phẩm
        * @param int $price:                        Tổng tiền hoá đơn/sản phẩm,chưa kể phí vận chuyển,giảm giá,thuế.
        * @param string $currency:                  Loại tiền tệ,nhận một trong các giá trị 'vnd','usd'.Mặc định đồng tiền thanh toán là 'vnd'
        * @param int $quantity:                     Số lượng sản phẩm
        * @param int $tax:                          Thuế
        * @param int $discount:                     Giảm giá
        * @param int $fee_cal:                      Nhận giá trị 0 hoặc 1.Do trên hệ thống NgânLượng.vn cho phép chủ tài khoản cấu hình cho nhập/thay đổi phí lúc thanh toán hay không.Nếu website của bạn đã có phí vận chuyển và không cho sửa thì đặt tham số này=0
        * @param int $fee_shipping:                 Phí vận chuyển
        * @param string $order_description:         Mô tả về sản phẩm,đơn hàng
        * @param string $buyer_info:                Thông tin người mua 
        * @param string $affiliate_code:            Mã đối tác tham gia chương trình liên kết của NgânLượng.vn
        * @return string:                           đjjd
    --------------------------------------------------------------------------*/
    public function buildCheckoutUrlExpand($return_url,$receiver,$transaction_info,$order_code,$price,$currency='vnd',$quantity=1,$tax=0,$discount=0,$fee_cal=0,$fee_shipping=0,$order_description='',$buyer_info='',$affiliate_code=''){	
            
        if($affiliate_code=="")
            $affiliate_code=$this->affiliate_code;

        // Mảng các tham số chuyển tới nganluong.vn
        $arr_param=array(
            'merchant_site_code'    =>  strval($this->merchant_site_code),
            'return_url'            =>  strval(strtolower($return_url)),
            'receiver'              =>  strval($receiver),
            'transaction_info'      =>  strval($transaction_info),
            'order_code'            =>  strval($order_code),
            'price'                 =>  strval($price),
            'currency'              =>  strval($currency),
            'quantity'              =>  strval($quantity),
            'tax'                   =>  strval($tax),
            'discount'              =>  strval($discount),
            'fee_cal'               =>  strval($fee_cal),
            'fee_shipping'          =>  strval($fee_shipping),
            'order_description'     =>  strval($order_description),
            'buyer_info'            =>  strval($buyer_info),
            'affiliate_code'        =>  strval($affiliate_code)
        );

        $secure_code='';
        $secure_code=implode(' ',$arr_param).' '.$this->secure_pass;
        $arr_param['secure_code']=md5($secure_code);

        /* Bước 2.Kiểm tra  biến $redirect_url xem có '?' không,nếu không có thì bổ sung vào*/
        $redirect_url=$this->nganluong_url;
        if(strpos($redirect_url,'?')===false)
            $redirect_url.='?';
        else if(substr($redirect_url,strlen($redirect_url)-1,1) !='?' && strpos($redirect_url,'&')===false)
            $redirect_url.='&';			


        /* Bước 3.tạo url*/
        $url='';
        foreach($arr_param as $key=>$value){               
            if($key!='return_url')
                $value=urlencode($value);

            if($url=='')
                $url.=$key.'='.$value;
            else
                $url.='&'.$key.'='.$value;
        }
		
        return $redirect_url.$url;
    }
    
    /*--------------------------------------------------------------------------
        HÀM TẠO ĐƯỜNG LINK THANH TOÁN QUA NGÂNLƯỢNG.VN
     
      
        * @param string $return_url:                Sau khi thanh toán hoàn tất
        * @param string $receiver:                  Địa chỉ Email chính của tài khoản nhận tiền.
        * @param string $transaction_info:          Thông tin thêm về giao dịch thanh toán(không bắt buộc).
        * @param int $order_code:                   Mã hóa đơn(hoặc mã hoặc tên sản phẩm) cần thanh toán.
        * @param int $price:                        Tổng giá trị hóa đơn(hoặc sản phẩm) cần thanh toán.
    --------------------------------------------------------------------------*/    
    public function buildCheckoutUrl($return_url,$receiver,$transaction_info,$order_code,$price){

        // Mảng các tham số chuyển tới nganluong.vn
        $arr_param=array(
            'merchant_site_code'    =>  strval($this->merchant_site_code),
            'return_url'            =>  strtolower(urlencode($return_url)),
            'receiver'              =>  strval($receiver),
            'transaction_info'      =>  strval($transaction_info),
            'order_code'            =>  strval($order_code),
            'price'                 =>  strval($price)					
        );
        
        $secure_code='';
        $secure_code=implode(' ',$arr_param).' '.$this->secure_pass;
        $arr_param['secure_code']=md5($secure_code);

        /* Bước 2.Kiểm tra  biến $redirect_url xem có '?' không,nếu không có thì bổ sung vào*/
        $redirect_url=$this->nganluong_url;
        if(strpos($redirect_url,'?')===false)
            $redirect_url.='?';
        
        // Nếu biến $redirect_url có '?' nhưng không kết thúc bằng '?' và có chứa dấu '&' thì bổ sung vào cuối
        else if(substr($redirect_url,strlen($redirect_url)-1,1) !='?' && strpos($redirect_url,'&')===false)
            $redirect_url.='&';

        /* Bước 3.tạo url*/
        $url='';
        foreach($arr_param as $key=>$value){
            if($key!='return_url')
                $value=urlencode($value);
            
            if($url=='')
                $url.=$key.'='.$value;
            else
                $url.='&'.$key.'='.$value;
        }

        return $redirect_url.$url;
    }

    
    /*--------------------------------------------------------------------------
        HÀM KIỂM TRA TÍNH ĐÚNG ĐẮN CỦA ĐƯỜNG LINK KẾT QUẢ TRẢ VỀ TỪ NGÂNLƯỢNG.VN

     
        * @param string $transaction_info:          Thông tin về giao dịch,Giá trị do website gửi sang
        * @param string $order_code:                Mã hoá đơn/tên sản phẩm
        * @param string $price:                     Tổng tiền đã thanh toán
        * @param string $payment_id:                Mã giao dịch tại NgânLượng.vn
        * @param int $payment_type:                 Hình thức thanh toán:1 - Thanh toán ngay(tiền đã chuyển vào tài khoản NgânLượng.vn của người bán); 2 - Thanh toán Tạm giữ(tiền người mua đã thanh toán nhưng NgânLượng.vn đang giữ hộ)
        * @param string $error_text:                Giao dịch thanh toán có bị lỗi hay không.$error_text=="" là không có lỗi.Nếu có lỗi,mô tả lỗi được chứa trong $error_text
        * @param string $secure_code:               Mã checksum(mã kiểm tra)
        * @return unknown
    --------------------------------------------------------------------------*/	
    public function verifyPaymentUrl($transaction_info,$order_code,$price,$payment_id,$payment_type,$error_text,$secure_code){
		
        // Tạo mã xác thực từ chủ web
        $str='';
        $str.=' '.strval($transaction_info);
        $str.=' '.strval($order_code);
        $str.=' '.strval($price);
        $str.=' '.strval($payment_id);
        $str.=' '.strval($payment_type);
        $str.=' '.strval($error_text);
        $str.=' '.strval($this->merchant_site_code);
        $str.=' '.strval($this->secure_pass);

        // Mã hóa các tham số
        $verify_secure_code='';
        $verify_secure_code=md5($str);

        // Xác thực mã của chủ web với mã trả về từ nganluong.vn
        if($verify_secure_code===$secure_code)
            return true;
        else 
            return false;
    }
}
?>