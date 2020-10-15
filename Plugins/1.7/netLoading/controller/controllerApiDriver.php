<?php
function changePassDriverStaffAPI($input){
    $modelDriver= new Driver();
    $dataSend = $input['request']->data;
    $dataUser= $modelDriver->checkLoginByToken($dataSend['accessToken']);
 
    if(!empty($dataUser['Driver']['accessToken'])){
        if($dataUser['Driver']['pass'] == md5($dataSend['oldPass'])&& $dataSend['pass'] = $dataSend['RePass']){
            $dataUser['Driver']['pass'] = md5($dataSend['pass']);
            if($modelDriver->save($dataUser)){
                $return = array('code'=>0);
            }else{
                $return = array('code'=>1);
            }
        }else{
            $return = array('code'=>1);
        }
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function checkLoginDriverStaffAPI($input)
{
    $modelDriver= new Driver();
    $listData = array();
    $dataSend= $input['request']->data;

    if(!empty($dataSend['fone']) && !empty($dataSend['pass'])){
        $userByFone  = $modelDriver->checkLoginByFone($dataSend['fone'],$dataSend['pass']);
        $accessToken = getGUID();
        
        if($userByFone){
            $userByFone['Driver']['accessToken']= $accessToken;
            $return= array('code'=>0,'user'=>$userByFone['Driver']);
            $modelDriver->save($userByFone);
        }else{
            $return= array('code'=>1,'user'=>array());
        }
    }else{
        $return= array('code'=>1,'user'=>array());
    }

    echo json_encode($return);
}

function saveTokenDeviceStaffAPI($input)
{
    $modelDriver= new Driver();
    $dataSend = $input['request']->data;
    $dataUser = $modelDriver->checkLoginByToken($dataSend['accessToken']);
    if(!empty($dataUser['Driver']['accessToken'])){
        $save['$set']['tokenDevice']= $dataSend['tokenDevice'];
        $id= new MongoId($dataUser['Driver']['id']);
        $dk= array('_id'=>$id);

        if($modelDriver->updateAll($save,$dk)){
            $return = array('code'=>0);
        }else{
            $return = array('code'=>1);
        }
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function saveGPSDriverStaffAPI($input)
{
    $modelDriver= new Driver();
    $modelHistory= new History();
    $modelOrder= new Order();

    $dataSend = $input['request']->data;
    $dataUser = $modelDriver->checkLoginByToken($dataSend['accessToken']);
    if(!empty($dataUser['Driver']['accessToken'])){
        // distance là khoảng cách tình từ tọa độ lái xe đến nơi cần chuyển hàng (chạy theo đơn hàng) hoặc về nhà xe (xe tự do)
        // tọa độ điểm đến lưu vào biến gpsCityEnd

    	$today= getdate();
        $save['$set']['latGPS']= (double) $dataSend['lat'];
        $save['$set']['longGPS']= (double) $dataSend['long'];
        $save['$set']['distance']= (double) $dataSend['distance'];
        $save['$set']['timeUpdate']= $today[0];
        
        $id= new MongoId($dataUser['Driver']['id']);
        $dk= array('_id'=>$id);

        $dk2= array('idDriverStaff'=>$dataUser['Driver']['id']);
        $dk1= array('idDriver'=>$dataUser['Driver']['id']);

        if($modelDriver->updateAll($save,$dk)){
            $modelHistory->updateAll($save,$dk2);
            $modelOrder->updateAll($save,$dk1);
            
            $return = array('code'=>0);
        }else{
            $return = array('code'=>1);
        }
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function CheckLogoutStaffAPI($input)
{
    $modelDriver= new Driver();
    $dataSend= $input['request']->data;
    $return= array('code'=>0);

    $dataUser['$unset']['accessToken']= true;
    $dataUser['$unset']['latGPS']= true;
    $dataUser['$unset']['longGPS']= true;
    $dataUser['$unset']['timeUpdate']= true;
    $dataUser['$unset']['tokenDevice']= true;
    
    $dk= array('accessToken'=>$dataSend['accessToken']);
    if($modelDriver->updateAll($dataUser,$dk)){
        $return= array('code'=>0);
    }else{
        $return= array('code'=>1);
    } 

    echo json_encode($return);
}

?>