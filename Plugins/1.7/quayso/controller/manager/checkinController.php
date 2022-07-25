<?php 
function managerScanQR($input) {
    global $urlHomes;
    global $urlNow;
    global $modelUser;
    setVariable('permission', 'managerScanQR');

    if (!empty($_SESSION['infoManager'])) {
        $mess= '';
        if(!empty($_GET['status'])){
            switch ($_GET['status']) {
                case 'checkinDone': $mess= '<p style="color: green;">Checkin thành công</p>';break;
                case 'checkinFailSystem': $mess= '<p style="color: red;">Lỗi hệ thống</p>';break;
                case 'checkinFailCheckin': $mess= '<p style="color: red;">Bạn đã checkin</p>';break;
                case 'checkinFailManager': $mess= '<p style="color: red;">Bạn đã checkin sai diễn giả</p>';break;
                case 'checkinFailData': $mess= '<p style="color: red;">Mã QR không chính xác</p>';break;
                case 'checkinFailCampaign': $mess= '<p style="color: red;">Bạn đã checkin sai sự kiện</p>';break;
            }
        }

        setVariable('mess', $mess);
    } else {
        $modelUser->redirect('/login');
    }
}

function managerCheckin($input) {
    global $urlHomes;
    global $urlNow;
    global $modelUser;
    setVariable('permission', 'managerCheckin');
    $modelCampaign = new Campaign();

    if (!empty($_SESSION['infoManager'])) {
        if(!empty($_GET['idCampaign']) && !empty($_GET['idUser'])){
            $infoCampaign= $modelCampaign->getData($_GET['idCampaign']);
            
            if($infoCampaign && $infoCampaign['Campaign']['idManager']==$_SESSION['infoManager']['Manager']['id']){
                $infoUser= $modelUser->getUser($_GET['idUser']);
                
                if($infoUser && $infoUser['User']['campaign']==$_GET['idCampaign']){
                    if(empty($infoUser['User']['checkin'])){
                        $infoUser['User']['checkin'] = time();

                        if($modelUser->save($infoUser)){
                            if(empty($_GET['urlBack'])){
                                $modelUser->redirect('/scanQR/?status=checkinDone');
                            }else{
                                $modelUser->redirect($_GET['urlBack']);
                            }
                            
                        }else{
                            $modelUser->redirect('/scanQR/?status=checkinFailSystem');
                        }
                    }else{
                        $modelUser->redirect('/scanQR/?status=checkinFailCheckin');
                    }
                }else{
                    $modelUser->redirect('/scanQR/?status=checkinFailCampaign');
                }
            }else{
                $modelUser->redirect('/scanQR/?status=checkinFailManager');
            }
        }else{
            $modelUser->redirect('/scanQR/?status=checkinFailData');
        }
    } else {
        $modelUser->redirect('/login');
    }
}

function managerDeleteCheckin($input) {
    global $urlHomes;
    global $urlNow;
    global $modelUser;
    setVariable('permission', 'managerDeleteCheckin');
    $modelCampaign = new Campaign();

    if (!empty($_SESSION['infoManager'])) {
        if(!empty($_GET['idCampaign']) && !empty($_GET['idUser'])){
            $infoCampaign= $modelCampaign->getData($_GET['idCampaign']);
            
            if($infoCampaign && $infoCampaign['Campaign']['idManager']==$_SESSION['infoManager']['Manager']['id']){
                $infoUser= $modelUser->getUser($_GET['idUser']);
                
                if($infoUser && $infoUser['User']['campaign']==$_GET['idCampaign']){
                    $infoUser['User']['checkin']= 0;

                    if($modelUser->save($infoUser)){
                        if(empty($_GET['urlBack'])){
                            $modelUser->redirect('/scanQR/?status=deleteCheckinDone');
                        }else{
                            $modelUser->redirect($_GET['urlBack']);
                        }
                        
                    }else{
                        $modelUser->redirect('/scanQR/?status=deleteCheckinFailSystem');
                    }
                }else{
                    $modelUser->redirect('/scanQR/?status=deleteCheckinFailCampaign');
                }
            }else{
                $modelUser->redirect('/scanQR/?status=deleteCheckinFailManager');
            }
        }else{
            $modelUser->redirect('/scanQR/?status=deleteCheckinFailData');
        }
    } else {
        $modelUser->redirect('/login');
    }
}
?>