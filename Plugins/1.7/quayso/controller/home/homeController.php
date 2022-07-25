<?php
function addUserAPI($input)
{
    global $isRequestPost;
    global $modelUser;
    global $modelOption;

    $modelCampaign = new Campaign();
    $return = array();

    if($isRequestPost){
        $dataSend= arrayMap($input['request']->data);

        if(!empty($dataSend['fullName']) && !empty($dataSend['phone']) && !empty($dataSend['campaign']) && MongoId::isValid($dataSend['campaign'])){
            $checkPhone= $modelUser->find('first', array('conditions'=> array('phone'=>$dataSend['phone'],'campaign'=>$dataSend['campaign'])));

            if(empty($checkPhone)){
                if(empty($dataSend['avatar'])) {
                    $dataSend['avatar'] = '/app/Plugin/quayso/view/manager/img/avtar-default.png';
                }

                $save['User']['fullName']= str_replace(array("'",'"','.','-'), "", $dataSend['fullName']);
                $save['User']['email']= str_replace(array("'",'"','&quot;'), "", @$dataSend['email']);
                $save['User']['phone']= str_replace(array("'",'"','.','-',' ','&quot;'), "", $dataSend['phone']);
                $save['User']['idMessUser']= @$dataSend['idMessUser'];
                $save['User']['job']= @$dataSend['job'];
                $save['User']['note']= @$dataSend['note'];
                $save['User']['campaign']= $dataSend['campaign'];
                $save['User']['avatar']= $dataSend['avatar'];
                $save['User']['time']= time();

                if(!empty($dataSend['autoCheckin'])){
                    $save['User']['checkin'] = time();
                }

                $infoCampaign= $modelCampaign->getData($dataSend['campaign']);
                $infoCampaign['Campaign']['code']++;
                $modelCampaign->save($infoCampaign);

                $save['User']['codeQT']= $infoCampaign['Campaign']['code'];
                $save['User']['idManager']= $infoCampaign['Campaign']['idManager'];

                if($modelUser->save($save)){
                    $save['User']['id'] = $modelUser->getLastInsertId();

                    if(empty($dataSend['hiddenMessages']) || $dataSend['hiddenMessages']!=1){
                        $return['messages']= array(array('text'=>'Mã số dự thưởng của bạn là '.$save['User']['codeQT']));
                    }else{
                        unset($return['messages']);
                    }
                    
                    $return['set_attributes']['codeQT']= $save['User']['codeQT'];
                    $return['set_attributes']['linkQRCheckin']= 'https://api.qrserver.com/v1/create-qr-code/?size=500x500&data='.urlencode('https://quayso.xyz/checkin/?idCampaign='.$dataSend['campaign'].'&idUser='.$save['User']['id']);
                    $return['set_attributes']['code'] = 1;
                }else{
                    $return['messages']= array(array('text'=>'Lỗi hệ thống, bạn vui lòng thử lại sau'));
                    
                    $return['set_attributes']['codeQT']= '';
                    $return['set_attributes']['linkQRCheckin']= '';
                    $return['set_attributes']['code'] = 0;
                }

                
            }else{
                if(empty($dataSend['hiddenMessages']) || $dataSend['hiddenMessages']!=1){
                    $return['messages']= array(array('text'=>'Mã số dự thưởng của bạn là '.$checkPhone['User']['codeQT']));
                }

                $return['set_attributes']['codeQT']= $checkPhone['User']['codeQT'];
                $return['set_attributes']['linkQRCheckin']= 'https://api.qrserver.com/v1/create-qr-code/?size=500x500&data='.urlencode('https://quayso.xyz/checkin/?idCampaign='.$dataSend['campaign'].'&idUser='.$checkPhone['User']['id']);
                $return['set_attributes']['code'] = 1;
            }
        }else{
            $return['messages']= array(array('text'=>'Gửi thiếu dữ liệu (fullName, phone, campaign, email, idMessUser)'));
        }
    }

    echo json_encode($return);die;
}

function saveKQQT($input)
{
    global $isRequestPost;
    global $modelUser;
    global $modelOption;
    $modelCampaign = new Campaign();

    if (!empty($_SESSION['infoManager']) || !empty($_SESSION['codeSecurity'])) {
        if($isRequestPost){
            $dataSend= arrayMap($input['request']->data);

            if(!empty($dataSend['idCampaign']) && !empty($dataSend['idUserKQ'])){
            	$infoCampaign= $modelCampaign->getData($dataSend['idCampaign']);
            	if($infoCampaign){
            		if(empty($infoCampaign['Campaign']['listUserWin'][$dataSend['idUserKQ']])){
            			$infoCampaign['Campaign']['listUserWin'][$dataSend['idUserKQ']]= time();

            			$modelCampaign->save($infoCampaign);
            		}
            	}
            }
        }
    }
}

function checkinCampaign($input)
{
    global $modelUser;
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;

    $modelCampaign = new Campaign();

    if(!empty($_GET['idCampaign'])) {
        $infoCampaign= $modelCampaign->getData($_GET['idCampaign']);

        if($infoCampaign) {
            $mess = '';

            if(empty($_SESSION['infoUserCheckin'])){
                if($isRequestPost) {
                    $dataSend= arrayMap($input['request']->data);

                    if(!empty($dataSend['codeUser'])){
                        $infoUser = $modelUser->find('first', array('conditions' => array('campaign'=>$_GET['idCampaign'], 'codeQT'=>(int)$dataSend['codeUser'])));

                        if($infoUser) {
                            if(empty($infoUser['User']['checkin'])){
                                $infoUser['User']['checkin'] = time();

                                if($modelUser->save($infoUser)){
                                    setVariable('infoUser', $infoUser);
                                    $_SESSION['infoUserCheckin'] = $infoUser;
                                }else{
                                    $mess= '<p style="color: red;">Lỗi hệ thống</p>';
                                }
                            }else{
                                setVariable('infoUser', $infoUser);
                            }
                        }else{
                            $mess= '<p style="color: red;">Không tìm thấy mã người dùng</p>';
                        }
                    }else{
                        $mess= '<p style="color: red;">Bạn chưa nhập mã người dùng</p>';
                    }
                }
            } else {
                $infoUser = $_SESSION['infoUserCheckin'];
                setVariable('infoUser', $infoUser);
            }

            setVariable('infoCampaign', $infoCampaign);
            setVariable('mess', $mess);
        }else{
            $modelUser->redirect('/error');
        }
    }else{
        $modelUser->redirect('/error');
    }
}
?>