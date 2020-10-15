<?php

// Duong dan trang chu
global $urlHomeManager;
global $urlHomes;
$urlHomeManager = $urlHomes . 'homeManager';

// Dang nhap
function managerLogin($input) {
    global $isRequestPost;
    global $urlHomes;
    if ($isRequestPost && !isset($_SESSION['infoManager'])) {
        $modelManager = new Manager();
        // $dataSend= $input['request']->data;
        $today= getdate();
        $infoManager = $modelManager->checkLogin($_POST['user'], md5($_POST['password']));

        if(!empty($infoManager['Manager']['deadline'])){
            if($infoManager['Manager']['deadline']<$today[0]){
                $modelManager->redirect($urlHomes . 'managerLogin?status=-3');
            }
        }
        
        if (!isset($infoManager) || $infoManager == array()) {
            $modelStaff = new Staff();
            $infoStaff = $modelStaff->checkLogin($_POST['user'], md5($_POST['password']));
            if (empty($infoStaff)) {
                $modelStaff->redirect($urlHomes . 'managerLogin?status=-1');
            } else {
                global $urlHomeManager;
                if (!isset($infoStaff['Staff']['actived']) || $infoStaff['Staff']['actived'] != 1) {
                    $modelStaff->redirect($urlHomes . 'managerLogin?status=-2');
                } else {
                    $infoManager = $modelManager->getManager($infoStaff['Staff']['idManager']);
                    // kiem tra thoi gian hop dong
                    if(!empty($infoManager['Manager']['deadline'])){
                        if($infoManager['Manager']['deadline']<$today[0]){
                            $modelManager->redirect($urlHomes . 'managerLogin?status=-3');
                        }
                    }
                    // kiem tra khoa tai khoan
                    if (!isset($infoManager['Manager']['actived']) || $infoManager['Manager']['actived'] != 1) {
                        $modelManager->redirect($urlHomes . 'managerLogin?status=-2');
                    }

                    if (empty($infoStaff['Staff']['avatar'])) {
                        $infoStaff['Staff']['avatar'] = 'app/webroot/images/avatar_default.png';
                    }
                    $infoManager['Manager']['id'] = $infoStaff['Staff']['idManager'];
                    $infoManager['Manager']['avatar'] = $infoStaff['Staff']['avatar'];
                    $infoManager['Manager']['user'] = $infoStaff['Staff']['user'];
                    $infoManager['Manager']['fullname'] = $infoStaff['Staff']['fullname'];
                    $infoManager['Manager']['email'] = $infoStaff['Staff']['email'];
                    $infoManager['Manager']['phone  '] = $infoStaff['Staff']['phone'];
                    $infoManager['Manager']['address'] = $infoStaff['Staff']['address'];
                    $infoManager['Manager']['actived'] = $infoStaff['Staff']['actived'];
                    $infoManager['Manager']['desc'] = $infoStaff['Staff']['desc'];
                    $infoManager['Manager']['listHotel'] = $infoStaff['Staff']['listHotel'];
                    $infoManager['Manager']['check_list_permission'] = $infoStaff['Staff']['check_list_permission'];
                    $infoManager['Manager']['permissionAdvanced'] = (isset($infoStaff['Staff']['permissionAdvanced']))?$infoStaff['Staff']['permissionAdvanced']:array();

                    $infoManager['Manager']['idStaff'] = $infoStaff['Staff']['id'];
                    $infoManager['Manager']['groupPermission'] = $infoStaff['Staff']['groupPermission'];
                    $infoManager['Manager']['idHotel'] = $infoStaff['Staff']['idHotel'];
                    $infoManager['Manager']['idManager'] = $infoStaff['Staff']['idManager'];
                    $infoManager['Manager']['isStaff'] = true;

                    $_SESSION['infoManager'] = $infoManager;
                    $_SESSION['CheckAuthentication'] = true;
                    $urlBase = Router::url('/');
                    if (strpos(strtolower($urlBase), 'index.php/')) {
                        $urlBase = substr_replace($urlBase, '', -10);
                    }
                    $rootUpload = $urlBase . 'app/webroot/upload/';
                    $_SESSION['urlBaseUpload'] = $rootUpload . $_SESSION['infoManager']['Manager']['id'] . '/';
                    $modelStaff->redirect($urlHomes . 'managerSelectHotel');
                }
            }
        } elseif (!isset($infoManager['Manager']['actived']) || $infoManager['Manager']['actived'] != 1) {
            $modelManager->redirect($urlHomes . 'managerLogin?status=-2');
        } elseif (isset($infoManager['Manager']) && $infoManager['Manager']['actived'] == 1) {
            global $urlHomeManager;
            $infoManager['Manager']['idStaff'] = $infoManager['Manager']['id'];
            $infoManager['Manager']['isStaff'] = false;
            $infoManager['Manager']['check_list_permission'] = array();

            if ($infoManager['Manager']['avatar'] == '')
                $infoManager['Manager']['avatar'] = 'app/webroot/images/avatar_default.png';
            $_SESSION['infoManager'] = $infoManager;
            $_SESSION['CheckAuthentication'] = true;
            // Tao thu muc ipload
            $urlBase = Router::url('/');
            if (strpos(strtolower($urlBase), 'index.php/')) {
                $urlBase = substr_replace($urlBase, '', -10);
            }
            $rootUpload = $urlBase . 'app/webroot/upload/';
            $_SESSION['urlBaseUpload'] = $rootUpload . $_SESSION['infoManager']['Manager']['id'] . '/';
            //debug ($infoManager);
            //debug ($_SESSION['infoManager']);
            $modelManager->redirect($urlHomes . 'managerSelectHotel');
        }
    } elseif (isset($_SESSION['infoManager'])) {
        $modelManager = new Manager();
        global $urlHomeManager;
        $modelManager->redirect($urlHomeManager);
    }
}

function managerForgetPassword($input) {
    global $isRequestPost;
    global $urlHomes;
    global $contactSite;
    global $smtpSite;
    global $gmpThemeSettings;
    if ($isRequestPost && !isset($_SESSION['infoManager'])) {
        $modelManager = new Manager();
        // $dataSend= $input['request']->data;

        $infoManager = $modelManager->isExistUser($_POST['user']);

        //debug ($infoManager);
        if (!isset($infoManager) || $infoManager == array()) {
            $modelManager->redirect($urlHomes . 'managerForgetPassword?status=-4');
        } elseif (!isset($infoManager['Manager']['actived']) || $infoManager['Manager']['actived'] != 1) {
            $modelManager->redirect($urlHomes . 'managerForgetPassword?status=-2');
        } elseif (isset($infoManager['Manager']) && $infoManager['Manager']['actived'] == 1) {
            $newPass = rand(11111111, 99999999);
            $infoManager['Manager']['password'] = md5($newPass);

            $id = new MongoId($infoManager['Manager']['id']);

            if ($modelManager->updateAll($infoManager, array('_id' => $id))) {

                // send email for user and admin
                $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                $to = array(trim($infoManager['Manager']['email']), trim($contactSite['Option']['value']['email']));
                $cc = array();
                $bcc = array();
                $subject = '[' . $smtpSite['Option']['value']['show'] . '] ' . $gmpThemeSettings['Option']['value']['titleEmailForgetPassword'];

                // create content email
                $content = 'Xin chào ' . $infoManager['Manager']['fullname'] . '!<br> ' . $gmpThemeSettings['Option']['value']['textEmailForgetPassword'] . '<br>';
                $content.= 'Dưới đây là thông tin đăng nhập của bạn:<br>';
                $content.= 'Link đăng nhập: <a href="' . $urlHomes . 'quanlykhachsan">' . $urlHomes . 'quanlykhachsan</a><br>';
                $content.= 'Tên đăng nhập: ' . $infoManager['Manager']['user'] . '<br>';
                $content.= 'Mật khẩu mới: ' . $newPass . '<br>';

                if ($modelManager->sendMail($from, $to, $cc, $bcc, $subject, $content)) {
                    $modelManager->redirect($urlHomes . 'managerForgetPassword?status=1');
                }
            }
        }
    } elseif (isset($_SESSION['infoManager'])) {
        $modelManager = new Manager();
        global $urlHomeManager;
        $modelManager->redirect($urlHomeManager);
    }
}

function managerUserProfile($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        if ($_SESSION['infoManager']['Manager']['isStaff'] != 1) {
            $modelManager = new Manager();
            $data = $modelManager->getManager($_SESSION['infoManager']['Manager']['id']);
            
            if ($isRequestPost) {

                $dataSend = arrayMap($input['request']->data);

                if (!empty($dataSend['password'])) {
                    $save['Manager']['password'] = md5($dataSend['password']);
                }

                $save['Manager']['user'] = $dataSend['user'];
                $save['Manager']['fullname'] = $dataSend['fullname'];
                $save['Manager']['avatar'] = $_SESSION['infoManager']['Manager']['avatar'] = $dataSend['avatar'];
                $save['Manager']['email'] = $dataSend['email'];
                $save['Manager']['phone'] = $dataSend['phone'];
                $save['Manager']['address'] = $dataSend['address'];
                if (!empty($dataSend['desc'])) {
                    $save['Manager']['desc'] = $dataSend['desc'];
                }

                $dk['_id'] = new MongoId($_SESSION['infoManager']['Manager']['id']);

                if ($modelManager->updateAll($save['Manager'], $dk)) {
                    $modelManager->redirect($urlHomes . 'managerUserProfile?status=3');
                } else {
                    $modelManager->redirect($urlHomes . 'managerUserProfile?status=-3');
                }
            }
        } else {

            $modelStaff = new Staff();
            $dataStaff = $modelStaff->getStaff($_SESSION['infoManager']['Manager']['idStaff']);
            $data['Manager'] = $dataStaff['Staff'];
            if ($isRequestPost) {

                $dataSend = arrayMap($input['request']->data);

                if (!empty($dataSend['password'])) {
                    $save['Staff']['password'] = md5($dataSend['password']);
                }
                $save['Staff']['fullname'] = $dataSend['fullname'];
                $save['Staff']['email'] = $dataSend['email'];
                $save['Staff']['phone'] = $dataSend['phone'];
                $save['Staff']['address'] = $dataSend['address'];
                if (!empty($dataSend['desc'])) {
                    $save['Staff']['desc'] = $dataSend['desc'];
                }

                $dk['_id'] = new MongoId($_SESSION['infoManager']['Manager']['idStaff']);

                if ($modelStaff->updateAll($save['Staff'], $dk)) {
                    $modelStaff->redirect($urlHomes . 'managerUserProfile?status=3');
                } else {
                    $modelManager->redirect($urlHomes . 'managerUserProfile?status=-3');
                }
            }
        }


        setVariable('data', $data);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

// Lua chon khach san
function managerSelectHotel() {
    global $isRequestPost;
    global $urlHomes;
    global $urlHomeManager;
    $modelHotel = new Hotel();
    if ($isRequestPost && isset($_SESSION['infoManager'])) {
        if (isset($_POST['idHotel'])) {
            $_SESSION['idHotel'] = $_POST['idHotel'];
        }

        //$_SESSION['urlBaseUpload']=$_SESSION['urlBaseUpload'].$_SESSION['idHotel'].'/';
        $modelHotel->redirect($urlHomeManager);
    } elseif (!empty($_SESSION['infoManager']['Manager']['listHotel'])) {

        foreach ($_SESSION['infoManager']['Manager']['listHotel'] as $idHotel) {
            if (!empty($idHotel)) {
                $listData[] = $modelHotel->getHotel($idHotel);
            }
        }
        if (count($listData) == 0) {
            $modelHotel->redirect($urlHomes . 'managerAddHotel');
        }
        setVariable('listData', $listData);
    } elseif (!empty($_SESSION['infoManager']) && !$_SESSION['infoManager']['Manager']['isStaff'] && empty($_SESSION['infoManager']['Manager']['listHotel'])) {
        $modelHotel->redirect($urlHomes . 'managerAddHotel');
    } elseif (!isset($_SESSION['infoManager'])) {
        $modelHotel->redirect($urlHomes);
    }
}

// Dang xuat
function managerLogout() {
    global $urlHomes;
    $modelManager = new Manager();

    session_destroy();
    $modelManager->redirect($urlHomes . 'managerLogin');
}

// Trang chu manager
function homeManager() {
    global $urlHomes;
    $modelManager = new Manager();
    if (checkLoginManager()) {
        $modelHotel = new Hotel();
        $modelOrder = new Order();
        $modelRevenue = new Revenue();
        $modelRequest = new Request();

        $today = getdate();

        $hotel = $modelHotel->getHotel($_SESSION['idHotel']);

        $conditions['idHotel'] = $_SESSION['idHotel'];
        $conditions['status'] = 0;
        $countOrder = $modelOrder->find('count', array('conditions' => $conditions));

        $revenue = $modelRevenue->getRevenue($_SESSION['idHotel']);

        for ($i = 1; $i <= 12; $i++) {
            if (!isset($revenue['Revenue'][$today['year']][$i])) {
                $revenue['Revenue'][$today['year']][$i] = 0;
            }
        }

        $countRequest = $modelRequest->getCountRequestWithHotel($hotel);

        setVariable('view', $hotel['Hotel']['view']);
        setVariable('countOrder', $countOrder);
        setVariable('today', $today);
        setVariable('countRequest', $countRequest);
        setVariable('revenue', $revenue['Revenue'][$today['year']]);
    } else {
        $modelManager->redirect($urlHomes);
    }
}

function loginFB() {
    
}

?>