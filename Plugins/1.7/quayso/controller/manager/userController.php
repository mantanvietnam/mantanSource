<?php 
function managerListUser($input) {
    global $urlHomes;
    global $urlNow;
    global $modelUser;
    setVariable('permission', 'managerListUser');
    $modelCampaign = new Campaign();

    if (!empty($_SESSION['infoManager'])) {
        /*
        $allUser = $modelUser->find('all');
        foreach($allUser as $user){
            $user['User']['avatar'] = '/app/Plugin/quayso/view/manager/img/avtar-default.png';

            $modelUser->create();
            $modelUser->save($user);
        }
        */

        $mess= '';

        $limit = 15;
        $conditions = array();
        $conditions['idManager'] = $_SESSION['infoManager']['Manager']['id'];

        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0) $page = 1;

        $listAllCampaignManager= $modelCampaign->find('all', array('conditions'=>$conditions));

        if(!empty($_GET['idCampaign'])){
            $conditions['campaign'] = $_GET['idCampaign'];
        }

        if(!empty($_GET['typeUser'])){
            if($_GET['typeUser']=='checkin'){
                $conditions['checkin']['$exists'] = true;
                $conditions['checkin']['$ne'] = 0;
            }
            elseif($_GET['typeUser']=='nocheckin'){
                $conditions['$or'][0]['checkin']['$exists'] = false;
                $conditions['$or'][1]['checkin'] = 0;
            }
            
        }

        if(!empty($_GET['phone'])){
            $conditions['phone'] = $_GET['phone'];
        }

        if(!empty($_GET['codeQT'])){
            $conditions['codeQT'] = (int) $_GET['codeQT'];
        }

            
        $listData = $modelUser->getPage($page, $limit, $conditions, $order = array('created' => 'desc'));
        if (!empty($listData)) {
            foreach ($listData as $key=>$item) {
                $infoCampaign= $modelCampaign->getData($item['User']['campaign']);
                $listData[$key]['User']['nameCampaign']= @$infoCampaign['Campaign']['name'];
            }
        }

        $totalData = $modelUser->find('count', array('conditions' => $conditions));

        $balance = $totalData % $limit;
        $totalPage = ($totalData - $balance) / $limit;
        if ($balance > 0)
            $totalPage+=1;

        $back = $page - 1;
        $next = $page + 1;
        if ($back <= 0)
            $back = 1;
        if ($next >= $totalPage)
            $next = $totalPage;

        if (isset($_GET['page'])) {
            $urlPage = str_replace('&page=' . $_GET['page'], '', $urlNow);
            $urlPage = str_replace('page=' . $_GET['page'], '', $urlPage);
        } else {
            $urlPage = $urlNow;
        }
        if (strpos($urlPage, '?') !== false) {
            if (count($_GET) >= 1) {
                $urlPage = $urlPage . '&page=';
            } else {
                $urlPage = $urlPage . 'page=';
            }
        } else {
            $urlPage = $urlPage . '?page=';
        }
        
        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);
        
        setVariable('listData', $listData);
        setVariable('mess', $mess);
        setVariable('listAllCampaignManager', $listAllCampaignManager);
    } else {
        $modelUser->redirect('/login');
    }
}

function managerListUserWin($input) {
    global $urlHomes;
    global $urlNow;
    global $modelUser;
    setVariable('permission', 'managerListUserWin');
    $modelCampaign = new Campaign();

    if (!empty($_SESSION['infoManager'])) {
        $mess= '';
        if(!empty($_GET['status'])){
            switch ($_GET['status']) {
                case 1: $mess= '<p style="color: green;">Xóa kết quả chiến thắng thành công</p>';break;
                case 2: $mess= '<p style="color: red;">Quá 24h không thể xóa kết quả người thắng cuộc</p>';break;
            }
        }

        $listUserWin= array();
        $conditions = array();
        $conditions['idManager'] = $_SESSION['infoManager']['Manager']['id'];

        $listAllCampaignManager= $modelCampaign->find('all', array('conditions'=>$conditions));

        if(!empty($_GET['idCampaign'])){
            $listAllCampaign[0]= $modelCampaign->getData($_GET['idCampaign']);
        }else{
            $listAllCampaign= $modelCampaign->find('all', array('conditions'=>$conditions));
        }
        
        if(!empty($listAllCampaign)){
            foreach ($listAllCampaign as $key => $value) {
                if(!empty($value['Campaign']['listUserWin'])){
                    foreach ($value['Campaign']['listUserWin'] as $idUser => $timeWin) {
                        $infoUser= $modelUser->getUser($idUser);
                        if( $infoUser 
                            && (empty($_GET['phone']) || $_GET['phone']==$infoUser['User']['phone']) 
                            && (empty($_GET['codeQT']) || $_GET['codeQT']==$infoUser['User']['codeQT']) 
                        ){
                            $infoUser['User']['nameCampaign']= $value['Campaign']['name'];
                            $infoUser['User']['idCampaign']= $value['Campaign']['id'];
                            $listUserWin[$timeWin]= $infoUser;
                        }
                    }
                }
            }
        }

        if(!empty($listUserWin)){
            krsort($listUserWin);
        }

        setVariable('listUserWin', $listUserWin);
        setVariable('listAllCampaignManager', $listAllCampaignManager);
        setVariable('mess', $mess);
    } else {
        $modelUser->redirect('/login');
    }
}

function managerDeleteUserWin($input){
    global $urlHomes;
    global $urlNow;
    global $modelUser;
    setVariable('permission', 'managerDeleteUserWin');
    $modelCampaign = new Campaign();

    if (!empty($_SESSION['infoManager'])) {
        if(!empty($_GET['idCampaign']) && !empty($_GET['idUser'])){
            $infoCampaign= $modelCampaign->getData($_GET['idCampaign']);

            if(isset($infoCampaign['Campaign']['listUserWin'][$_GET['idUser']])){
                if( (time()-$infoCampaign['Campaign']['listUserWin'][$_GET['idUser']]) <= 24*60*60 ){
                    unset($infoCampaign['Campaign']['listUserWin'][$_GET['idUser']]);
                    $modelCampaign->save($infoCampaign);
                }else{
                    $modelUser->redirect('/userWin?idCampaign='.$_GET['idCampaign'].'&status=2');
                }
            }
        }

        $modelUser->redirect('/userWin?idCampaign='.$_GET['idCampaign'].'&status=1');
    } else {
        $modelUser->redirect('/login');
    }
}

function managerAddUser($input)
{
    global $urlHomes;
    global $urlNow;
    global $modelUser;
    global $isRequestPost;
    setVariable('permission', 'managerAddUser');
    $modelCampaign = new Campaign();

    if (!empty($_SESSION['infoManager'])) {
        $conditions = array();
        $conditions['idManager'] = $_SESSION['infoManager']['Manager']['id'];

        $listAllCampaignManager= $modelCampaign->find('all', array('conditions'=>$conditions));
        $mess = '';

        if($isRequestPost){
            $dataSend= arrayMap($input['request']->data);

            if(!empty($dataSend['campaign']) && !empty($dataSend['fullName']) && !empty($dataSend['phone'])){
                $_SESSION['idCampaignView']= $dataSend['campaign'];

                $checkPhone= $modelUser->find('first', array('conditions'=> array('phone'=>$dataSend['phone'],'campaign'=>$dataSend['campaign'])));

                if(empty($checkPhone)){
                    $save['User']['fullName']= str_replace(array("'",'"','.','-'), "", $dataSend['fullName']);
                    $save['User']['email']= str_replace(array("'",'"','&quot;'), "", $dataSend['email']);
                    $save['User']['phone']= str_replace(array("'",'"','.','-',' ','&quot;'), "", $dataSend['phone']);
                    $save['User']['idMessUser']= '';
                    $save['User']['job']= $dataSend['job'];
                    $save['User']['note']= $dataSend['note'];
                    $save['User']['campaign']= $dataSend['campaign'];
                    $save['User']['avatar']= '/app/Plugin/quayso/view/manager/img/avtar-default.png';
                    $save['User']['time']= time();

                    $infoCampaign= $modelCampaign->getData($dataSend['campaign']);
                    $infoCampaign['Campaign']['code']++;
                    $modelCampaign->save($infoCampaign);

                    $save['User']['codeQT']= $infoCampaign['Campaign']['code'];
                    $save['User']['idManager']= $infoCampaign['Campaign']['idManager'];

                    if($modelUser->save($save)){
                        $save['User']['id'] = $modelUser->getLastInsertId();

                        $mess= '<center style="color: green;">Mã số dự thưởng: <b>'.$save['User']['codeQT'].'</b><br/>Mã QR checkin<br/><img src="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data='.urlencode('https://quayso.xyz/checkin/?idCampaign='.$dataSend['campaign'].'&idUser='.$save['User']['id']).'" width="150" /></center>';
                    }else{
                        $mess= '<p style="color: red;">Lỗi hệ thống, bạn vui lòng thử lại sau</p>';
                    }
                }else{
                    $mess= '<p style="color: red;">Số điện thoại đã được đăng ký với mã tham dự <b>'.$checkPhone['User']['codeQT'].'</b></p>';
                }
            }else{
                $mess= '<p style="color: red;">Bạn không được để trống các trường bắt buộc</p>';
            }
        }

        setVariable('listAllCampaignManager', $listAllCampaignManager);
        setVariable('mess', $mess);
    } else {
        $modelUser->redirect('/login');
    }
}

function managerDeleteUser($input)
{
    global $urlHomes;
    global $urlNow;
    global $modelUser;
    global $isRequestPost;
    setVariable('permission', 'managerDeleteUser');
    $modelCampaign = new Campaign();

    if (!empty($_SESSION['infoManager'])) {
        if(!empty($_GET['idUser']) && $_SESSION['infoManager']['Manager']['typeBuy']=='buyForever'){
            if($modelUser->delete($_GET['idUser'])){
                $modelUser->redirect('/campaign/?status=deleteUserDone');
            }else{
                $modelUser->redirect('/campaign/?status=deleteUserFail');
            }
        }else{
            $modelUser->redirect('/campaign');
        }
        
    }else{
        $modelUser->redirect('/login');
    }
}

function managerDeleteAllUserCampain($input)
{
    global $urlHomes;
    global $urlNow;
    global $modelUser;
    global $isRequestPost;
    setVariable('permission', 'managerDeleteAllUserCampain');
    $modelCampaign = new Campaign();

    if (!empty($_SESSION['infoManager'])) {
        if(!empty($_GET['idCampaign'])){
            $infoCampaign= $modelCampaign->getData($_GET['idCampaign']);

            $conditions['campaign'] = $_GET['idCampaign'];
            $conditions['idManager'] = $_SESSION['infoManager']['Manager']['id'];

            if($modelUser->deleteAll($conditions)){
                $infoCampaign['Campaign']['listUserWin']= array();
                $modelCampaign->save($infoCampaign);

                $modelUser->redirect('/campaign/?status=deleteAllUserCampainDone');
            }else{
                $modelUser->redirect('/campaign/?status=deleteAllUserCampainFail');
            }
        }else{
            $modelUser->redirect('/campaign');
        }
        
    }else{
        $modelUser->redirect('/login');
    }
}

function managerDeleteAllUserWinCampain($input)
{
    global $urlHomes;
    global $urlNow;
    global $modelUser;
    global $isRequestPost;
    setVariable('permission', 'managerDeleteAllUserWinCampain');
    $modelCampaign = new Campaign();

    if (!empty($_SESSION['infoManager'])) {
        if(!empty($_GET['idCampaign'])){
            $infoCampaign= $modelCampaign->getData($_GET['idCampaign']);

            $infoCampaign['Campaign']['listUserWin']= array();

            if($modelCampaign->save($infoCampaign)){
                $modelUser->redirect('/campaign/?status=deleteAllUserWinCampainDone');
            }else{
                $modelUser->redirect('/campaign/?status=deleteAllUserWinCampainFail');
            }
        }else{
            $modelUser->redirect('/campaign');
        }
        
    }else{
        $modelUser->redirect('/login');
    }
}

function managerDeleteAllUserChecinCampain($input)
{
    global $urlHomes;
    global $urlNow;
    global $modelUser;
    global $isRequestPost;
    setVariable('permission', 'managerDeleteAllUserChecinCampain');
    $modelCampaign = new Campaign();

    if (!empty($_SESSION['infoManager'])) {
        if(!empty($_GET['idCampaign'])){
            $conditions['campaign'] = $_GET['idCampaign'];
            $conditions['idManager'] = $_SESSION['infoManager']['Manager']['id'];

            $update['$set']['checkin']= 0;

            if($modelUser->updateAll($update,$conditions)){
                $modelUser->redirect('/campaign/?status=deleteAllUserCheckinCampainDone');
            }else{
                $modelUser->redirect('/campaign/?status=deleteAllUserCheckinCampainFail');
            }
        }else{
            $modelUser->redirect('/campaign');
        }
        
    }else{
        $modelUser->redirect('/login');
    }
}
?>