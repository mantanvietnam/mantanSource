<?php
// Dang nhap
function managerLogin($input) {
    global $isRequestPost;
    global $urlHomes;
    global $urlHomeManager;
    setVariable('permission', 'managerLogin');
    
    $modelManager = new Manager();
    
    if ($isRequestPost && !isset($_SESSION['infoManager'])) {
        $dataSend= arrayMap($input['request']->data);
        
        $infoManager = $modelManager->checkLogin($dataSend['phone'], md5((string)$dataSend['password']));
        
        if($infoManager){
            if(empty($infoManager['Manager']['typeBuy'])){
                $infoManager['Manager']['typeBuy']= 'buyTurn';
            }
            
            processLoginManager($infoManager);
            $modelManager->redirect($urlHomes . 'campaign');
        }else{
            // sai user hoặc pass
            $modelManager->redirect($urlHomes . 'login?status=-1');
        }
    } elseif (isset($_SESSION['infoManager'])) {
        $modelManager->redirect($urlHomes . 'campaign');
    } elseif(!empty($_COOKIE['idManager'])){
        $infoManager = $modelManager->getData($_COOKIE['idManager']);
        if($infoManager){
            processLoginManager($infoManager);

            $modelManager->redirect($urlHomes . 'campaign');
        }
    }
}

// đăng ký
function managerRegister($input) {
    global $isRequestPost;
    global $urlHomes;
    global $urlHomeManager;
    setVariable('permission', 'managerRegister');
    
    $modelManager = new Manager();
    
    if(empty($_SESSION['infoManager'])){
        if ($isRequestPost) {
            $dataSend= arrayMap($input['request']->data);

            $checkUser= $modelManager->find('first', array('conditions'=> array('phone'=>$dataSend['phone'])));
            if($checkUser){
                // số điện thoại đã tồn tại
                $modelManager->redirect($urlHomes . 'register/?status=-1');
            }else{
                if($dataSend['password']==$dataSend['passwordAgain']){
                    $save['Manager']['fullname']= $dataSend['fullname'];
                    $save['Manager']['phone']= $dataSend['phone'];
                    $save['Manager']['email']= $dataSend['email'];
                    $save['Manager']['password']= md5($dataSend['password']);
                    $save['Manager']['coin']= 0;
                    $save['Manager']['typeBuy']= 'buyTurn';

                    if($modelManager->save($save)){
                        $save['Manager']['id']= $modelManager->getLastInsertId();
                        processLoginManager($save);

                        $modelManager->redirect($urlHomes . 'campaign');
                    }else{
                        // lỗi hệ thống
                        $modelManager->redirect($urlHomes . 'register/?status=-3');
                    }
                }else{
                    // mật khẩu nhập lại chưa đúng
                    $modelManager->redirect($urlHomes . 'register/?status=-2');
                }
            }
        }
    }else{
        $modelManager->redirect($urlHomes . 'campaign');
    }
    
}

function managerForgetPassword($input) {
    global $isRequestPost;
    global $urlHomes;
    global $contactSite;
    global $smtpSite;
    global $gmpThemeSettings;
    global $urlManagerLogin;
    setVariable('permission', 'managerForgetPassword');

    $mess= '';
    if(!empty($_GET['status'])){
        switch ($_GET['status']) {
            case 1: $mess= '<p style="color: green;">Mật khẩu mới đã được gửi về email của bạn, kiểm tra thư mục Spam nếu không thấy email</p>';break;
            case -4: $mess= '<p style="color: red;">Không tồn tại tài khoản</p>';break;
        }
    }

    if ($isRequestPost && !isset($_SESSION['infoManager'])) {
        $modelManager = new Manager();
        $dataSend= arrayMap($input['request']->data);

        $infoManager = $modelManager->find('first', array('conditions'=>array('phone'=>$dataSend['phone'])));

        if (empty($infoManager)) {
            // không tồn tại tài khoản
            $modelManager->redirect($urlHomes . 'forgetPassword?status=-4');
        } elseif (!empty($infoManager['Manager']['email'])) {
            $newPass = randPass(8);
            $infoManager['Manager']['password'] = md5($newPass);
            
            if ($modelManager->save($infoManager)) {

                // send email for user and admin
                $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                $to = array(trim($infoManager['Manager']['email']));
                $cc = array();
                $bcc = array();
                $subject = 'Thay đổi mật khẩu trên hệ thống QUAY SỐ';

                $content= '<!DOCTYPE html>
                <html lang="en">
                <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>Document</title>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css">
                <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
                <style>
                .bao{background: #fafafa;margin: 40px;padding: 20px 20px 40px;}
                .logo{

                }
                .logo img{height: 115px;margin:  0 auto;display:  block;margin-bottom: 15px;}
                .nd{background: white;max-width: 500px;margin: 0 auto;border-radius: 12px;border: 2px solid #e6e2e2;line-height: 2;position: relative; margin-top: 50px;}
                .head{background: #3fb901; color:white;text-align: center;padding: 15px 10px;font-size: 17px;text-transform: uppercase;}
                .main{padding: 10px 20px;}
                .thong_tin{padding: 0 20px 20px;}
                .line{position: relative;height: 2px;}
                .line1{position: absolute;top: 0;left: 0;width: 100%;height: 100%;background-image: linear-gradient(to right, transparent 50%, #737373 50%);background-size: 26px 100%;}
                .cty{text-align:  center;margin: 20px 0 30px;}
                .main .fa{color:green;}
                table{margin:auto;}
                .icon{
                    width: 80px;
                    height: 80px;
                    display: inline-block;
                    padding: 20px;
                    background: #00BCD4;
                    text-align: center;
                    color: white;
                    font-size: 40px;
                    line-height: 34px;
                    position: absolute;
                    top: -40px;
                    left: 202px;
                    border-radius: 50%;
                    border: 2px solid #e0e0e0;
                }
                @media screen and (max-width: 768px){
                    .bao{margin:0;}
                }
                @media screen and (max-width: 767px){
                    .bao{padding:6px; }
                    .nd{text-align: inherit;}
                }
                </style>
                </head>
                <body>
                
                <div class="bao">
                
                <div class="nd">
                
                <div class="main"> 
                <em style="    margin: 10px 0 10px;display: inline-block;">Kính gửi ' . $infoManager['Manager']['fullname'] . ' !</em> <br>
                
                Mật khẩu tài khoản của bạn trên hệ thống QUAY SỐ đã được thay đổi thành công vào lúc '.date('H:i d/m/Y').'. Thông tin đăng nhập như sau: <br><br>
                <i class="fa fa-globe"></i> Trang đăng nhập: <a href="https://quayso.xyz/login">https://quayso.xyz/login</a> <br>
                <i class="fa fa-user"></i> Số điện thoại: <strong>' . $infoManager['Manager']['phone'] . '</strong><br>
                <i class="fa fa-lock"></i> Mật khẩu mới: <strong>' . $newPass . '</strong><br><br>
                Cảm ơn Quý khách đã tin dùng Phần mềm QUAY SỐ. Nếu cần hỗ trợ xin vui lòng liên hệ hotline số: 081.656.0000
                
                <br><br>
                Trân trọng ./

                </p>
                </div>
                

                </div>
                </div>
                </body>
                </html>';

                if ($modelManager->sendMail($from, $to, $cc, $bcc, $subject, $content)) {
                    $modelManager->redirect($urlHomes . 'forgetPassword?status=1');
                }
            }
        }
    } elseif (isset($_SESSION['infoManager'])) {
        $modelManager = new Manager();
        $modelManager->redirect('/campaign');
    }

    setVariable('mess', $mess);
}


// Dang xuat
function managerLogout() {
    global $urlHomes;
    $modelManager = new Manager();
    setVariable('permission', 'managerLogout');

    session_destroy();
    $time= time()-365*24*60*60;

    setcookie('idManager','',$time, "/");

    $modelManager->redirect($urlHomes . 'login');
}

function managerChangePass($input)
{
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    setVariable('permission', 'managerChangePass');

    if (!empty($_SESSION['infoManager'])) {
        $modelManager = new Manager();

        $data = $modelManager->getData($_SESSION['infoManager']['Manager']['id']);
        $mess= '';
        if ($isRequestPost) {
            $dataSend = arrayMap($input['request']->data);

            if($dataSend['passNew']!=$dataSend['passAgain']){
                $mess= '<p style="color: red;">Mật khẩu nhập lại chưa đúng</p>';
            }else{
                if($data['Manager']['password'] != md5($dataSend['passOld'])){
                    $mess= '<p style="color: red;">Mật khẩu cũ chưa đúng</p>';
                }else{
                    $update['$set']['password']= md5($dataSend['passNew']);
                    $conditions= array('_id'=> new MongoId($_SESSION['infoManager']['Manager']['id']) );

                    if($modelManager->updateAll($update,$conditions)){
                        $mess= '<p style="color: green;">Đổi mật khẩu thành công</p>';
                    }else{
                        $mess= '<p style="color: red;">Lỗi hệ thống</p>';
                    }
                }
            }
        }

        setVariable('mess', $mess);
    } else {
        $modelOption->redirect('/login');
    }
}

function managerProfile($input)
{
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    setVariable('permission', 'managerProfile');

    if (!empty($_SESSION['infoManager'])) {
        $modelManager = new Manager();

        $data = $modelManager->getData($_SESSION['infoManager']['Manager']['id']);
        $mess= '';
        if ($isRequestPost) {
            $dataSend = arrayMap($input['request']->data);

            $data['Manager']['fullname']= $dataSend['fullname'];
            $data['Manager']['email']= $dataSend['email'];

            if($modelManager->save($data)){
                $mess= '<p style="color: green;">Đổi thông tin thành công</p>';

                $_SESSION['infoManager']= $data;
            }else{
                $mess= '<p style="color: red;">Lỗi hệ thống</p>';
            }
        }

        setVariable('data', $data);
        setVariable('mess', $mess);
    } else {
        $modelOption->redirect('/login');
    }
}

function managerAddMoney($input)
{
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    setVariable('permission', 'managerAddMoney');

    if (!empty($_SESSION['infoManager'])) {
        $modelManager = new Manager();

        $data = $modelManager->getData($_SESSION['infoManager']['Manager']['id']);
        $mess= '';
        if(!empty($_GET['status'])){
            switch ($_GET['status']) {
                case 'addMoneyCancel': $mess= '<p style="color: red;">Bạn đã hủy thanh toán nạp tiền</p>';break;
                case 'addMoneyDone': 
                    if(!empty($_GET['type'])){
                        if($_GET['type']=='buyTurn'){
                            $mess= '<p style="color: green;">Nạp tiền thành công</p>';
                        }elseif($_GET['type']=='buyMonth'){
                            $mess= '<p style="color: green;">Mua thành công 30 ngày tạo chiến dịch không giới hạn</p>';
                        }elseif($_GET['type']=='buyForever'){
                            $mess= '<p style="color: green;">Mua thành công gói tạo chiến dịch không giới hạn vĩnh viễn</p>';
                        }
                    }
                    break;
            }
        }
       
        if(!empty($_REQUEST['numberCoin']) && !empty($_REQUEST['type'])){
            $dataSend = arrayMap($_REQUEST);
            $dataSend['numberCoin']= (int) str_replace(array("'",'"','.','_','-',' ',','), '', $dataSend['numberCoin']);
           
            if($dataSend['numberCoin']>=50000){
                $_SESSION['tokenAddMoney'] = randPass(15);
                $_SESSION['numberAddMoney'] = $dataSend['numberCoin'];
                $_SESSION['typeBuy'] = $dataSend['type'];

                if(empty($dataSend['typePay'])) $dataSend['typePay']= 'bank';

                if($dataSend['typePay']=='nganluong'){
                    /*THANH TOÁN TIỀN NGÂN LƯỢNG*/
                    $receiver=RECEIVER;
                    //Mã đơn hàng 
                    $order_code= 'B'.time();
                    //Khai báo url trả về 
                    $return_url= $urlHomes . 'processAddMoneyDone?token='.$_SESSION['tokenAddMoney'];
                    // Link nut hủy đơn hàng
                    $cancel_url= $urlHomes . 'processAddMoneyCancel?token='.$_SESSION['tokenAddMoney'];
                    $notify_url = $urlHomes . 'processAddMoneyDone?token='.$_SESSION['tokenAddMoney'];
                    //Giá của cả giỏ hàng 
                    $txh_name = $_SESSION['infoManager']['Manager']['fullname'];
                    $txt_email = $_SESSION['infoManager']['Manager']['email'];
                    $txt_phone = $_SESSION['infoManager']['Manager']['phone'];
                    
                    $price = $dataSend['numberCoin'];
                    //Thông tin giao dịch
                    $transaction_info= $_SESSION['infoManager']['Manager']['phone'];
                    $currency= "vnd";
                    $quantity=1;
                    $tax=0;
                    $discount=0;
                    $fee_cal=0;
                    $fee_shipping=0;
                    $order_description= 'Họ tên: '.$_SESSION['infoManager']['Manager']['fullname'].'. Điện thoại: '.$_SESSION['infoManager']['Manager']['phone'].'. Email: '.$_SESSION['infoManager']['Manager']['email'].'. Mã đơn: '.$order_code;
                    $buyer_info=$txh_name."*|*".$txt_email."*|*".$txt_phone;
                    $affiliate_code="";
                    //Khai báo đối tượng của lớp NL_Checkout
                    $nl= new NL_Checkout();
                    $nl->nganluong_url = NGANLUONG_URL;
                    $nl->merchant_site_code = MERCHANT_ID;
                    $nl->secure_pass = MERCHANT_PASS;
                    //Tạo link thanh toán đến nganluong.vn
                    $url= $nl->buildCheckoutUrlExpand($return_url, $receiver, $transaction_info, $order_code, $price, $currency, $quantity, $tax, $discount , $fee_cal,    $fee_shipping, $order_description, $buyer_info , $affiliate_code);
                    //$url= $nl->buildCheckoutUrl($return_url, $receiver, $transaction_info, $order_code, $price);


                    //echo $url; die;
                    if ($order_code != "") {
                        //một số tham số lưu ý
                        //&cancel_url=http://yourdomain.com --> Link bấm nút hủy giao dịch
                        //&option_payment=bank_online --> Mặc định forcus vào phương thức Ngân Hàng
                        $url .='&cancel_url='. $cancel_url . '&notify_url='.$notify_url;
                        //$url .='&option_payment=bank_online';
                        $modelOption->redirect($url);
                        //echo '<meta http-equiv="refresh" content="0; url='.$url.'" >';
                        //&lang=en --> Ngôn ngữ hiển thị google translate
                    }
                }elseif($dataSend['typePay']=='momo'){
                    $modelOption->redirect('/payWithMoMo');
                }elseif($dataSend['typePay']=='bank'){
                    $modelOption->redirect('/payWithBank');
                }
            }else{
                $mess= '<p style="color: red;">Nhập số tiền tối thiểu 50.000đ</p>';
            }
        }

        setVariable('data', $data);
        setVariable('mess', $mess);
    } else {
        $modelOption->redirect('/login');
    }
}

function managerProcessAddMoneyCancel($input){
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    setVariable('permission', 'managerProcessAddMoneyCancel');

    if (!empty($_SESSION['infoManager'])) {
        unset($_SESSION['tokenAddMoney']);
        unset($_SESSION['numberAddMoney']);
    }

    $modelOption->redirect('/addMoney?status=addMoneyCancel');
}

function managerProcessAddMoneyDone($input){
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    setVariable('permission', 'managerProcessAddMoneyDone');

    if (!empty($_SESSION['infoManager'])) {
        if(!empty($_SESSION['tokenAddMoney']) && !empty($_GET['token']) && $_SESSION['tokenAddMoney']==$_GET['token']){
            $modelManager = new Manager();
            $modelHistory = new History();

            $data = $modelManager->getData($_SESSION['infoManager']['Manager']['id']);
            if($data){
                // kiểm tra người dùng mua gói tháng đã hết hạn chưa
                if(!empty($data['Manager']['typeBuy'])){
                    if($data['Manager']['typeBuy']=='buyMonth'){
                        if($data['Manager']['deadlineBuy']<=time()){
                            $data['Manager']['typeBuy'] = 'buyTurn';
                            $data['Manager']['deadlineBuy'] = 0;
                        }
                    }
                }

                // kiểm tra hình thức nạp tiền lần này
                if($_SESSION['typeBuy']=='buyTurn'){
                    $data['Manager']['coin'] += $_SESSION['numberAddMoney'];
                    if(empty($data['Manager']['typeBuy'])){
                        $data['Manager']['typeBuy'] = 'buyTurn';
                    }
                }elseif($_SESSION['typeBuy']=='buyForever'){
                    $data['Manager']['typeBuy'] = 'buyForever';
                    $data['Manager']['deadlineBuy'] = 0;
                }elseif($_SESSION['typeBuy']=='buyMonth'){
                    if(empty($data['Manager']['typeBuy']) || $data['Manager']['typeBuy']=='buyTurn'){
                        $data['Manager']['typeBuy'] = 'buyMonth';
                        $data['Manager']['deadlineBuy'] = strtotime('+30 day');
                    }elseif($data['Manager']['typeBuy']=='buyMonth'){
                        $data['Manager']['deadlineBuy'] = strtotime('+30 day', $data['Manager']['deadlineBuy']);
                    }
                }

                if($modelManager->save($data)){
                    $_SESSION['infoManager']['Manager']['typeBuy'] = $data['Manager']['typeBuy'];
                    $_SESSION['infoManager']['Manager']['coin'] = $data['Manager']['coin'];

                    $saveHistory['History']['time']= time();
                    $saveHistory['History']['idManager']= $_SESSION['infoManager']['Manager']['id'];
                    $saveHistory['History']['numberCoin']= $_SESSION['numberAddMoney'];
                    $saveHistory['History']['numberCoinManager']= $data['Manager']['coin'];
                    $saveHistory['History']['type']= 'plus';

                    switch ($_SESSION['typeBuy']) {
                        case 'buyTurn': $saveHistory['History']['note']= 'Nạp tiền vào tài khoản';break;
                        case 'buyMonth': $saveHistory['History']['note']= 'Mua 30 ngày không giới hạn';break;
                        case 'buyForever': $saveHistory['History']['note']= 'Mua gói vĩnh viễn không giới hạn';break;
                    }
                    

                    $modelHistory->save($saveHistory);
                    $type = $_SESSION['typeBuy'];

                    unset($_SESSION['tokenAddMoney']);
                    unset($_SESSION['numberAddMoney']);
                    unset($_SESSION['typeBuy']);

                    $modelOption->redirect('/addMoney?status=addMoneyDone&type='.$type);
                }else{
                    $modelOption->redirect('/addMoney?status=addMoneyDoneError');
                }
            }else{
                $modelOption->redirect('/addMoney?status=addMoneyDoneError');
            }
        }else{
            $modelOption->redirect('/addMoney?status=addMoneyDoneError');
        }
    } else {
        $modelOption->redirect('/login');
    }
}
?>