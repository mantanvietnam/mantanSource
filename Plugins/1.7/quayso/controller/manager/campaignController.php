<?php 
function managerListCampaign($input) {
    global $urlHomes;
    global $urlNow;
    global $modelUser;
    setVariable('permission', 'managerListCampaign');

    $modelCampaign = new Campaign();

    if (!empty($_SESSION['infoManager'])) {
        $mess= '';
        $numberCampaign = $modelCampaign->find('count', array('conditions'=>array('idManager'=>$_SESSION['infoManager']['Manager']['id'])));

        if(!empty($_GET['status'])){
            switch ($_GET['status']) {
                case 1: $mess= '<p style="color: green;">Lưu thông tin chiến dịch thành công</p>';break;
                case 'deleteAllUserCampainDone': $mess= '<p style="color: green;">Xóa toàn bộ người tham gia chiến dịch thành công</p>';break;
                case 'deleteAllUserWinCampainDone': $mess= '<p style="color: green;">Xóa toàn bộ người tham gia chiến thắng thành công</p>';break;
                case 'deleteAllUserCheckinCampainDone': $mess= '<p style="color: green;">Xóa toàn bộ người tham gia checkin thành công</p>';break;

                case -1: $mess= '<p style="color: red;">Lỗi hệ thống</p>';break;
                case 'deleteAllUserCampainFail': $mess= '<p style="color: red;">Lỗi hệ thống</p>';break;
                case 'deleteAllUserWinCampainFail': $mess= '<p style="color: red;">Lỗi hệ thống</p>';break;
                case 'deleteAllUserCheckinCampainFail': $mess= '<p style="color: red;">Lỗi hệ thống</p>';break;
            }
        }

        $limit = 15;
        $conditions = array();
        $conditions['idManager'] = $_SESSION['infoManager']['Manager']['id'];

        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0) $page = 1;

        $listData = $modelCampaign->getPage($page, $limit, $conditions, $order = array('created' => 'desc'));
        
        if (!empty($listData)) {
            foreach ($listData as $key=>$item) {
                $listData[$key]['Campaign']['numberUser']= $modelUser->find('count', array('conditions'=> array('campaign'=>$item['Campaign']['id'])));

                $listData[$key]['Campaign']['numberUserCheckin']= $modelUser->find('count', array('conditions'=> array('campaign'=>$item['Campaign']['id'], 'checkin'=> array('$exists'=>true,'$ne'=>0))));
            }
        }

        $totalData = $modelCampaign->find('count', array('conditions' => $conditions));

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
        setVariable('numberCampaign', $numberCampaign);
    } else {
        $modelCampaign->redirect('/login');
    }
}

function managerAddCampaign($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    setVariable('permission', 'managerAddCampaign');

    $modelCampaign = new Campaign();
    $modelManager = new Manager();
    $modelHistory = new History();

    if (!empty($_SESSION['infoManager'])) {
        $mess= '';

        $save= array();
        if(!empty($_GET['id']) && MongoId::isValid($_GET['id'])){
            $save = $modelCampaign->getData($_GET['id']);
        }
        
        
        $infoManager = $modelManager->getData($_SESSION['infoManager']['Manager']['id']);
        
        if(empty($infoManager['Manager']['typeBuy'])) {
            $infoManager['Manager']['typeBuy'] = '';
        }

        $numberCampaign = $modelCampaign->find('count', array('conditions'=>array('idManager'=>$_SESSION['infoManager']['Manager']['id'])));


        if( !empty($save) 
            || $numberCampaign<=5
            || $infoManager['Manager']['coin']>=50000 
            || $infoManager['Manager']['typeBuy']=='buyForever' 
            || ($infoManager['Manager']['typeBuy']=='buyMonth' && $infoManager['Manager']['deadlineBuy']<=time())
        ){
            if ($isRequestPost) {
                $dataSend = arrayMap($input['request']->data);

                if(empty($save)){
                    // trừ tiền tài khoản mua theo lần
                    if($numberCampaign>5 && (empty($infoManager['Manager']['typeBuy']) || $infoManager['Manager']['typeBuy']=='buyTurn')){
                        $infoManager['Manager']['coin'] -= 50000;
                        if($modelManager->save($infoManager)){
                            $saveHistory['History']['time']= time();
                            $saveHistory['History']['idManager']= $_SESSION['infoManager']['Manager']['id'];
                            $saveHistory['History']['numberCoin']= 50000;
                            $saveHistory['History']['numberCoinManager']= $infoManager['Manager']['coin'];
                            $saveHistory['History']['type']= 'minus';
                            $saveHistory['History']['note']= 'Trừ tiền tạo chiến dịch '.$dataSend['name'];

                            $modelHistory->save($saveHistory);
                        }
                    }
                }

                // tạo slug
                $listSlug = array();
                $number = 0;
                $slug = createSlugMantan(trim($dataSend['name']));
                $slugStart = $slug;
                $id= (!empty($_GET['id']))?$_GET['id']:'';
                do {
                    $number++;
                    $listSlug = $modelCampaign->find('all', array('conditions' => array('urlSlug' => $slug)));
                    if (count($listSlug) > 0 && $listSlug[0]['Campaign']['id'] != $id) {
                        $slug = $slugStart . '-' . $number;
                    }
                } while (count($listSlug) > 0 && $listSlug[0]['Campaign']['id'] != $id);
                
                $urlSlug= $slug;
                $save['Campaign']['urlSlug'] = $urlSlug;
                $save['Campaign']['name'] = $dataSend['name'];
                $save['Campaign']['codeSecurity'] = $dataSend['codeSecurity'];
                $save['Campaign']['typeUserWin'] = $dataSend['typeUserWin'];
                $save['Campaign']['note'] = $dataSend['note'];
                $save['Campaign']['colorText'] = $dataSend['colorText'];
                $save['Campaign']['idManager'] = $_SESSION['infoManager']['Manager']['id'];

                // xử lý file ảnh
                if (!file_exists(__DIR__.'/../../../../webroot/upload/' . $_SESSION['infoManager']['Manager']['phone'].'/files')) {
                    mkdir(__DIR__.'/../../../../webroot/upload/' . $_SESSION['infoManager']['Manager']['phone'].'/files', 0755, true);
                }

                $checkImage= true;
                $image= '';
                $logo= '';

                if(isset($_FILES['image']) && empty($_FILES['image']["error"])){
                    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                    $filename = $_FILES['image']["name"];
                    $filetype = strtolower($_FILES['image']["type"]);
                    $filesize = $_FILES['image']["size"];
                    
                    // Verify file extension
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if(!array_key_exists(strtolower($ext), $allowed)){
                        $mess= '<p style="color: red;">File ảnh nền không đúng định dạng ảnh</p>';
                        $checkImage= false;
                    }
                    // Verify file size - 5MB maximum
                    $maxsize = 1024 * 1024 * 1;
                    if($filesize > $maxsize){
                        $mess= '<p style="color: red;">File ảnh nền vượt quá giới hạn cho phép 1Mb</p>';
                        $checkImage= false;
                    }
                    // Verify MYME type of the file
                    if(in_array($filetype, $allowed)){
                        // Check whether file exists before uploading it
                        $locationImage= __DIR__.'/../../../../webroot/upload/' . $_SESSION['infoManager']['Manager']['phone'].'/files/bacground-'.$urlSlug.'.'.$ext;

                        move_uploaded_file($_FILES['image']["tmp_name"], $locationImage);

                        // nén ảnh
                        Tinify\fromFile($locationImage)->toFile($locationImage);

                        $image= $urlHomes.'/app/webroot/upload/'.$_SESSION['infoManager']['Manager']['phone'].'/files/bacground-'.$urlSlug.'.'.$ext;
                        
                    } else{
                        $mess= '<p style="color: red;">File ảnh nền không đúng định dạng ảnh</p>';
                        $checkImage= false;
                    }
                }

                if($checkImage && isset($_FILES['image']) && empty($_FILES['image']["error"])){
                    $save['Campaign']['image'] = $image;
                }

                if($checkImage){
                    $checkImage= true;
                    if(isset($_FILES['logo']) && empty($_FILES['logo']["error"])){
                        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                        $filename = $_FILES['logo']["name"];
                        $filetype = strtolower($_FILES['logo']["type"]);
                        $filesize = $_FILES['logo']["size"];
                        
                        // Verify file extension
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        if(!array_key_exists(strtolower($ext), $allowed)){
                            $mess= '<p style="color: red;">File ảnh logo không đúng định dạng ảnh</p>';
                            $checkImage= false;
                        }
                        // Verify file size - 5MB maximum
                        $maxsize = 1024 * 1024 * 1;
                        if($filesize > $maxsize){
                            $mess= '<p style="color: red;">File ảnh logo vượt quá giới hạn cho phép 1Mb</p>';
                            $checkImage= false;
                        }
                        // Verify MYME type of the file
                        if(in_array($filetype, $allowed)){
                            // Check whether file exists before uploading it
                            $locationImage= __DIR__.'/../../../../webroot/upload/' . $_SESSION['infoManager']['Manager']['phone'].'/files/logo-'.$urlSlug.'.'.$ext;

                            move_uploaded_file($_FILES['logo']["tmp_name"], $locationImage);

                            // nén ảnh
                            Tinify\fromFile($locationImage)->toFile($locationImage);

                            $logo= $urlHomes.'/app/webroot/upload/'.$_SESSION['infoManager']['Manager']['phone'].'/files/logo-'.$urlSlug.'.'.$ext;
                            
                        } else{
                            $mess= '<p style="color: red;">File ảnh logo không đúng định dạng ảnh</p>';
                            $checkImage= false;
                        }
                    }

                    if($checkImage && isset($_FILES['logo']) && empty($_FILES['logo']["error"])){
                        $save['Campaign']['logo'] = $logo;
                    }
                    
                    if(empty($save['Campaign']['code'])){
                        $save['Campaign']['code']= 999;
                    }

                    if(empty($save['Campaign']['listUserWin'])){
                        $save['Campaign']['listUserWin']= array();
                    }

                    if(empty($save['Campaign']['image'])){
                        $save['Campaign']['image']= '/app/Plugin/quayso/view/home/image/background.png';
                    }

                    if(empty($save['Campaign']['logo'])){
                        $save['Campaign']['logo']= '/app/Plugin/quayso/view/home/image/logo.png';
                    }

                    if(empty($save['Campaign']['colorText'])){
                        $save['Campaign']['colorText']= '000000';
                    }

                    if ($checkImage && $modelCampaign->save($save)) {
                        $modelCampaign->redirect($urlHomes . 'campaign?status=1');
                    } else {
                        $modelCampaign->redirect($urlHomes . 'campaign?status=-1');
                    }
                }
            }
        }elseif ($isRequestPost){
            $mess= '<p style="color: red;">Số dư tài khoản không đủ để tạo chiến dịch. Bạn chỉ được miễn phí 05 chiến dịch đầu tiên, mỗi chiến dịch tạo mới tiếp bạn sẽ bị trừ 50.000đ, bạn có thể mua gói không giới hạn tạo chiến dịch trong 30 ngày hoặc không giới hạn vĩnh viễn</p>';
        }
        
        setVariable('mess', $mess);
        setVariable('data', $save);
        setVariable('numberCampaign', $numberCampaign);
    } else {
        $modelCampaign->redirect('/login');
    }
}
?>