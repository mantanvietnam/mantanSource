<?php
function listCustomer($input){
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    $modelCustomer= new Customer();

    if(checkAdminLogin()){
        $page= (isset($_GET['page']))? (int) $_GET['page']:1;
        if($page<=0) $page=1;
        $limit= 15;
        $conditions= array();

        if(!empty($_GET['view'])){
            if($_GET['view']=='regDriver'){
                $conditions['updateDriver']= 'pending';
            }
        }
        
        $listData= $modelCustomer->getPage($page,$limit,$conditions);

        $totalData= $modelCustomer->find('count',array('conditions' => $conditions));
    
        $balance= $totalData%$limit;
        $totalPage= ($totalData-$balance)/$limit;
        if($balance>0)$totalPage+=1;
        
        $back=$page-1;$next=$page+1;
        if($back<=0) $back=1;
        if($next>=$totalPage) $next=$totalPage;
        
        if(isset($_GET['page'])){
            $urlPage= str_replace('&page='.$_GET['page'], '', $urlNow);
            $urlPage= str_replace('page='.$_GET['page'], '', $urlPage);
        }else{
            $urlPage= $urlNow;
        }

        if(strpos($urlPage,'?')!== false){
            if(count($_GET)>=1){
                $urlPage= $urlPage.'&page=';
            }else{
                $urlPage= $urlPage.'page=';
            }
        }else{
            $urlPage= $urlPage.'?page=';
        }

        setVariable('listData',$listData);
        
        setVariable('page',$page);
        setVariable('totalPage',$totalPage);
        setVariable('back',$back);
        setVariable('next',$next);
        setVariable('urlPage',$urlPage);

    }else{
        $modelCustomer->redirect($urlHomes);
    }
}

function addCustomer($input)
{
    global $modelOption;
    global $urlHomes;
    global $urlNow;
    global $isRequestPost;
    global $contactSite;

    $modelCustomer= new Customer();
    $modelDriver= new Driver();
    $modelHistory= new History();

    $mess= '';

    if(checkAdminLogin()){
        if(!empty($_GET['id'])){
            $data= $modelCustomer->getCustomer($_GET['id']);

            if($data){
                setVariable('data',$data);
            }else{
                $modelCustomer->redirect($urlHomes);
            }
        }else{
            $modelCustomer->redirect($urlHomes);
        }

        if ($isRequestPost) {
            $dataSend = $input['request']->data;

            $data['Customer']['status']= $dataSend['status'];
            $data['Customer']['chuxe']= (boolean) $dataSend['chuxe'];
            $data['Customer']['fullName']= $dataSend['fullName'];
            //$data['Customer']['fone']= $dataSend['fone'];
            $data['Customer']['email']= $dataSend['email'];
            $data['Customer']['company']['address']= $dataSend['addressCompany'];
            $data['Customer']['company']['name']= $dataSend['nameCompany'];
            $data['Customer']['company']['tax']= $dataSend['taxCompany'];
            $data['Customer']['company']['gps']= $dataSend['gpsCompany'];

            if(!empty($dataSend['pass'])){
                $data['Customer']['pass']= md5($dataSend['pass']);
            }

            if($data['Customer']['chuxe'] && isset($data['Customer']['updateDriver']) && $data['Customer']['updateDriver']=='pending'){
                $data['Customer']['updateDriver']= 'done';
                $data['Customer']['coin']= 500000;

                $today= getdate();
                $saveNewDriver['Driver']['time']= $today[0];
                $saveNewDriver['Driver']['lock']= false;
                $saveNewDriver['Driver']['status']= true;
                $saveNewDriver['Driver']['fullName']= $dataSend['fullName'];
                $saveNewDriver['Driver']['fone']= $data['Customer']['fone'];
                $saveNewDriver['Driver']['address']= $dataSend['addressCompany'];
                $saveNewDriver['Driver']['idUser']= $data['Customer']['id'];
                $saveNewDriver['Driver']['pass']= $data['Customer']['pass'];

                $modelDriver->create();
                $modelDriver->save($saveNewDriver);

                // Gửi email thông báo
                $from=array($contactSite['Option']['value']['email']);
                $to=array($data['Customer']['email']);
                $cc=array();
                $bcc=array();
                $subject='[Netloading] Kích hoạt tài khoản chủ xe thành công';
                $content= ' <p>Xin chào '.$dataSend['fullName'].' !</p>

                            <p>Tài khoản CHỦ XE của bạn đã được kích hoạt thành công trên hệ thống Netloading. Bạn vui lòng tải App Mobile cho chủ xe tại đây để sử dụng: </p>
                            <p><a href=""></a></p>
                            ' . getSignatureEmail();

                $modelCustomer->sendMail($from,$to,$cc,$bcc,$subject,$content);
            }
            
            // cap nhap toa do nha xe cho lai xe
            $dk= array('idUser'=>$data['Customer']['id']);
            $saveDriver['$set']['gpsCityEnd']= $dataSend['gpsCompany'];

            // cap nhap toa do nha xe cho xe trong hang
            $dk2= array('idDriverBoss'=>$data['Customer']['id']);
            $saveHistory['$set']['gpsCityEnd']= $dataSend['gpsCompany'];

            $modelCustomer->save($data);

            $modelDriver->create();
            $modelDriver->updateAll($saveDriver,$dk); 

            $modelHistory->create();
            $modelHistory->updateAll($saveHistory,$dk2);

            $mess= 'Lưu dữ liệu thành công';


        }

        setVariable('mess',$mess);
    }else{
        $modelCustomer->redirect($urlHomes);
    }
}
?>