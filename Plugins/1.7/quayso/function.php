<?php
require_once("lib/nganluong/config.php");
require_once("lib/nganluong/nganluong.class.php");
require_once("lib/tinify/vendor/autoload.php");

Tinify\setKey("QdVyHBsYGdLcfJWNyNsNw6LHc2R8D0Cv"); // mail mantanvietnam@gmail.com
//Tinify\setKey("Lp2HGknN7vpNkng7F7c1Pzc30VgNP7BL");

$menus= array();
$menus[0]['title']= 'Quay số';
$menus[0]['sub'][0]= array('name'=>'Người quản lý','classIcon'=>'fa-users','url'=>$urlPlugins.'admin/quayso-view-admin-listManager.php','permission'=>'listManagerQS');
addMenuAdminMantan($menus);

function processLoginManager($infoManager)
{
    global $urlHomes;
    $modelManager = new Manager();
    $today= getdate();

    if(!empty($infoManager)){

        $_SESSION['infoManager'] = $infoManager;

        $saveManager['$set']['lastLogin']['time']= time();
        $saveManager['$set']['lastLogin']['text']= date('H:i:s d/m/Y',$saveManager['$set']['lastLogin']['time']);
        $dkManager= array('_id'=> new MongoId($infoManager['Manager']['id']));
        $modelManager->updateAll($saveManager,$dkManager);

        setCookieFromSession();
    }
}

function setCookieFromSession(){
    if(!empty($_SESSION)){
        $time= time()+365*24*60*60;
        setcookie('idManager',$_SESSION['infoManager']['Manager']['id'],$time, "/");
    }
}

function getMenuSidebarLeftManager() {
    global $urlHomes;
    return array(
        array('icon' => 'fa-file-text-o', 'name' => 'Chiến dịch', 'link' => $urlHomes . 'campaign', 'permission' => 'campaign','active'=> array()),    

        array('icon' => 'fa-qrcode', 'name' => 'Checkin', 'link' => $urlHomes . 'scanQR', 'permission' => 'scanQR','active'=> array()),    
        
        array('icon' => 'fa-users', 'name' => 'Người chơi', 'link' => $urlHomes . 'user', 'permission' => 'user','active'=> array()),  

        array('icon' => 'fa-trophy', 'name' => 'Người thắng', 'link' => $urlHomes . 'userWin', 'permission' => 'userWin','active'=> array('managerListUserWin')),  

        array('icon' => 'fa-list-ol', 'name' => 'Hướng dẫn', 'link' => $urlHomes . 'guide', 'permission' => 'guide','active'=> array()),  

        array('icon' => 'fa-credit-card', 'name' => 'Nạp tiền', 'link' => $urlHomes . 'addMoney', 'permission' => 'addMoney','active'=> array()),  

        array('icon' => 'fa-cog', 'name' => 'Tài khoản', 'link' => '',
            'sub' => array(
                array('icon' => '', 'name' => 'Lịch sử giao dịch', 'link' => $urlHomes . 'history', 'permission' => 'history'),
                array('icon' => '', 'name' => 'Thông tin', 'link' => $urlHomes . 'profile', 'permission' => 'profile'),
                array('icon' => '', 'name' => 'Đổi mật khẩu', 'link' => $urlHomes . 'changePass', 'permission' => 'changePass'),
                array('icon' => '', 'name' => 'Đăng xuất', 'link' => $urlHomes . 'logout', 'permission' => 'logout'),
            ),
            'active'=> array(),
        ),

  
    );
}

function randPass( $length ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);

}

?>