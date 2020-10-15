<?php
function changePassAPI($input){
    $modelCustomer= new Customer();
    $dataSend = $input['request']->data;
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);
 
    if(!empty($dataUser['Customer']['accessToken']) ){
        if($dataUser['Customer']['pass'] == md5($dataSend['oldPass'])&& $dataSend['pass'] = $dataSend['RePass']){
            $dataUser['Customer']['pass'] = md5($dataSend['pass']);
            if($modelCustomer->save($dataUser)){
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

function getInfoCustomerAPI(){
    $modelCustomer= new Customer();
    $dataSend = $input['request']->data;
    $dataUser = $modelCustomer->checkLoginByToken($dataSend['accessToken']);
    $return = array('code'=>0);

    if(!empty($dataUser['Customer']['accessToken'])){
        $data= $modelCustomer->getCustomer($dataSend['idUser'],array('fullName','email','fax','company','fone','coin'));

        $return = array('code'=>1,'data'=>$data);
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function updateInfoUserAPI($input)
{
    $modelCustomer= new Customer();
    $dataSend = $input['request']->data;
    $dataUser = $modelCustomer->checkLoginByToken($dataSend['accessToken']);
    if(!empty($dataUser['Customer']['accessToken'])){
        $dataUser['Customer']['fullName'] = $dataSend['fullName'];
        $dataUser['Customer']['email'] = $dataSend['email'];
        $dataUser['Customer']['fax'] = $dataSend['fax'];
        $dataUser['Customer']['company']['name'] = $dataSend['nameCompany'];
        $dataUser['Customer']['company']['address'] = $dataSend['addressCompany'];
        $dataUser['Customer']['company']['tax'] = $dataSend['taxCompany'];
        if($modelCustomer->save($dataUser)){
            $return = array('code'=>0);
        }else{
            $return = array('code'=>1);
        }
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);

}

function checkRegisterAPI($input)
{
    global $contactSite;
    $modelCustomer= new Customer();
    $listData = array();
    $dataSend= $input['request']->data;

    if(!empty($dataSend['fullName']) &&
        !empty($dataSend['email']) &&
        !empty($dataSend['fone']) &&
        !empty($dataSend['pass']) &&
        !empty($dataSend['passAgain'])
    ){
        $today= getdate();

        if($dataSend['pass'] != $dataSend['passAgain']){
            $return= array('code'=>2);
        }else{
            $checkAccEmail= $modelCustomer->getCustomerByEmail($dataSend['email']);
            $checkAccFone= $modelCustomer->getCustomerByFone($dataSend['fone']);

            if($checkAccEmail || $checkAccFone){
                $return= array('code'=>1);
            }else{
                $save['Customer']['fullName']= $dataSend['fullName'];
                $save['Customer']['email']= $dataSend['email'];
                $save['Customer']['fone']= $dataSend['fone'];
                $save['Customer']['pass']= md5($dataSend['pass']);
                $save['Customer']['chuxe']= false;
                $save['Customer']['coin']= 0;

                $modelCustomer->save($save);

                $return= array('code'=>0);

                // Gửi email thông báo
                $from=array($contactSite['Option']['value']['email']);
                $to=array($dataSend['email']);
                $cc=array();
                $bcc=array();
                $subject='[Netloading] Đăng ký tài khoản thành công';
                $content= ' <p>Xin chào '.$dataSend['fullName'].' !</p>

                            <p>Chúc mừng bạn đã đăng ký thành công tài khoản Chủ hàng trên hệ thống Netloading, thông tin tài khoản như sau:</p>

                            <ul>
                                <li>App chủ hàng: <a href=""></a></li>
                                <li>Tài khoản: '.$dataSend['fone'].'</li>
                                <li>Mật khẩu: '.$dataSend['pass'].'</li>
                            </ul>' . getSignatureEmail();

                $modelCustomer->sendMail($from,$to,$cc,$bcc,$subject,$content);
            }
        }
    }else{
        $return= array('code'=>3);
    }

    echo json_encode($return);
}

function checkLoginAPI($input)
{
    $modelCustomer= new Customer();
    $listData = array();
    $dataSend= $input['request']->data;

    if(!empty($dataSend['account']) && !empty($dataSend['pass'])){
        $userByAccount  = $modelCustomer->checkLoginByAccount($dataSend['account'],$dataSend['pass']);
        $userByFone     = $modelCustomer->checkLoginByFone($dataSend['account'],$dataSend['pass']);
        $accessToken = getGUID();
        if($userByAccount){
            $userByAccount['Customer']['accessToken']= $accessToken;
            $return= array('code'=>0,'user'=>$userByAccount['Customer']);
            $modelCustomer->save($userByAccount);
        }
        elseif($userByFone){
            $userByFone['Customer']['accessToken']= $accessToken;
            $return= array('code'=>0,'user'=>$userByFone['Customer']);
            $modelCustomer->save($userByFone);
        }else{
            $return= array('code'=>1,'user'=>array());
        }
    }else{
        $return= array('code'=>1,'user'=>array());
    }

    echo json_encode($return);
}

// gửi yêu cầu cấp mã lấy lại mật khẩu
function sendCodePassNewAPI($input)
{
    $modelCustomer= new Customer();
    global $contactSite;

    $dataSend= $input['request']->data;
    $data= $modelCustomer->getCustomerByFone($dataSend['fone']);
    $return= array('code'=>1);

    if($data['Customer']['email']){
        $data['Customer']['codeForgetPass']= rand(100000,999999);
        $modelCustomer->save($data);
        
        // Gửi email thông báo
        $from=array($contactSite['Option']['value']['email']);
        $to=array($data['Customer']['email']);
        $cc=array();
        $bcc=array();
        $subject='[Netloading] Mã cấp lại mật khẩu';
        $content= ' <p>Xin chào '.$data['Customer']['fullName'].' !</p>

                    <p>Bạn vui lòng nhập mã sau để lấy lại mật khẩu: <b>'.$data['Customer']['codeForgetPass'].'</b></p>
                    ' . getSignatureEmail();

        $modelCustomer->sendMail($from,$to,$cc,$bcc,$subject,$content);
        $return= array('code'=>0);
    }

    echo json_encode($return);
}

// gửi yêu cầu lấy lại mật khẩu
function sendPassNewAPI($input)
{
    $modelCustomer= new Customer();
    global $contactSite;

    $dataSend= $input['request']->data;
    $data= $modelCustomer->getCustomerByFone($dataSend['fone']);
    $return= array('code'=>1);

    if($data['Customer']['email'] && isset($data['Customer']['codeForgetPass']) && $data['Customer']['codeForgetPass']==$dataSend['codeForgetPass']){
        $newPass= rand(100000,999999);
		$save['$set']['pass']= md5($newPass);
		$save['$unset']['codeForgetPass']= true;
        $dk= array('_id'=>new MongoId($data['Customer']['id']));
        if($modelCustomer->updateAll($save,$dk)){
			// Gửi email thông báo
			$from=array($contactSite['Option']['value']['email']);
			$to=array($data['Customer']['email']);
			$cc=array();
			$bcc=array();
			$subject='[Netloading] Mã cấp lại mật khẩu';
			$content= ' <p>Xin chào '.$data['Customer']['fullName'].' !</p>

						<p>Mật khẩu mới của bạn là: <b>'.$newPass.'</b></p>
						' . getSignatureEmail();

			$modelCustomer->sendMail($from,$to,$cc,$bcc,$subject,$content);
			$return= array('code'=>0);
		}else{
			$return= array('code'=>1);
		}
    }

    echo json_encode($return);
}

function saveTokenDeviceAPI($input)
{
    $modelCustomer= new Customer();
    $dataSend = $input['request']->data;
    $dataUser = $modelCustomer->checkLoginByToken($dataSend['accessToken']);
    if(!empty($dataUser['Customer']['accessToken'])){
        $save['$set']['tokenDevice']= $dataSend['tokenDevice'];
        $id= new MongoId($dataUser['Customer']['id']);
        $dk= array('_id'=>$id);

        if($modelCustomer->updateAll($save,$dk)){
            $return = array('code'=>0);
        }else{
            $return = array('code'=>1);
        }
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function CheckLogoutAPI($input)
{
    $modelCustomer= new Customer();
    $dataSend= $input['request']->data;
    $return= array('code'=>0);

    $dataUser['$unset']['accessToken']= true;
    $dataUser['$unset']['tokenDevice']= true;
    
    $dk= array('accessToken'=>$dataSend['accessToken']);
    if($modelCustomer->updateAll($dataUser,$dk)){
        $return= array('code'=>0);
    }else{
        $return= array('code'=>1);
    } 

    echo json_encode($return);
}

// Mạnh Code
function getListCityAPI($input)
{
    $return= array_values(getListCity());

    echo json_encode($return);
}

// Mạnh Code
function getListDistrictAPI($input)
{
    $dataSend= $input['request']->data;
    if(empty($dataSend['idCity'])) $dataSend['idCity']= '';
    $return= getListDistrict($dataSend['idCity']);

    echo json_encode($return);
}

function getListTypeCarAPI()
{
    $return= array_values(getListTypeCar());

    echo json_encode($return);
}

function getTypeWeightAPI()
{
    $return= array_values(getTypeWeight());

    echo json_encode($return);
}

function getTypeVolumeAPI()
{
    $return= array_values(getTypeVolume());

    echo json_encode($return);
}

function getTypeMoneyAPI()
{
    $return= array_values(getTypeMoney());

    echo json_encode($return);
}

// Mạnh Code

// Tạo yêu cầu từ chuyến xe có sẵn khi chủ hàng chọn
function saveRequestToCaremptyAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelRequest= new Request();
    $today= getdate();
    $modelCustomer= new Customer();
    $modelCarempty= new Carempty();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $infoCarEmpty= $modelCarempty->getCarempty($dataSend['idCarEmpty']);
        $infoDriverBoss= $modelCustomer->getCustomer($infoCarEmpty['Carempty']['idUser']); 

        if($infoCarEmpty && $infoDriverBoss && $dataSend['timeEnd']>=$dataSend['timeStart']){
            $push['$push']['waiting']= $dataUser['Customer']['id'];
            $dkPush= array('_id'=> new MongoId($dataSend['idCarEmpty']) );
            $modelCarempty->updateAll($push,$dkPush);

            $timeStart= explode('-', $dataSend['timeStart']);
            $timeStart= mktime(0,0,0,$timeStart[1],$timeStart[0],$timeStart[2]);

            $timeEnd= explode('-', $dataSend['timeEnd']);
            $timeEnd= mktime(23,59,59,$timeEnd[1],$timeEnd[0],$timeEnd[2]);

            $save['Request']['_id']= new MongoId();
            $save['Request']['time']= $today[0];
            $save['Request']['lock']= false;
            $save['Request']['status']= 'pendingDriver';
            $save['Request']['idCarEmpty']= $dataSend['idCarEmpty'];
			$save['Request']['idDriverBossWin']= $infoCarEmpty['Carempty']['idUser'];

            $save['Request']['cityStart']= (int)$dataSend['cityStart'];
            $save['Request']['districtStart']= (int)$dataSend['districtStart'];
            $save['Request']['addressStart']= $dataSend['addressStart'];
            $save['Request']['cityEnd']= (int)$dataSend['cityEnd'];
            $save['Request']['districtEnd']= (int)$dataSend['districtEnd'];
            $save['Request']['addressEnd']= $dataSend['addressEnd'];
            $save['Request']['productName']= $dataSend['productName'];
            $save['Request']['timeStart']= $timeStart;
            $save['Request']['timeEnd']= $timeEnd;
            $save['Request']['weigh']= (int) $dataSend['weigh'];
            $save['Request']['volume']= (int) $dataSend['volume'];
            $save['Request']['typeWeigh']= (int) $dataSend['typeWeigh'];
            $save['Request']['typeVolume']= (int) $dataSend['typeVolume'];
            $save['Request']['typeCar']= (int) $dataSend['typeCar'];
            $save['Request']['priceGood']= (int) $dataSend['priceGood'];
            $save['Request']['priceDone']= (int) $dataSend['priceGood'];

            $save['Request']['typeMoney']= (int) $dataSend['typeMoney'];
            
            $save['Request']['description']= $dataSend['description'];
            $save['Request']['idUser']= $dataUser['Customer']['id'];

            $save['Request']['auction'][$infoCarEmpty['Carempty']['idUser']]= array('idUser'=>$infoCarEmpty['Carempty']['idUser'],
                                                                                    'nameDriver'=>$infoDriverBoss['Customer']['company']['name'],
                                                                                    'price'=>(int) $infoCarEmpty['Carempty']['price'],
                                                                                    'time'=> $today[0],
                                                                                    'note'=> $infoCarEmpty['Carempty']['note'],
                                                                                    'idCar'=> $infoCarEmpty['Carempty']['idCar'],
                                                                                    'typeMoney'=>(int) $infoCarEmpty['Carempty']['typeMoney'],
                                                                                    'number'=>1
                                                                        );

            if($modelRequest->save($save)){
                $return= array('code'=>0);

                // gui thong bao cho chu xe
                $data= array('functionCall'=>'saveRequestToCaremptyAPI','title'=>'Có khách muốn đặt xe ','idRequest'=>(string) $save['Request']['_id']);
                $target= array($infoDriverBoss['Customer']['tokenDevice']);
                sendMessageNotifi($data,$target);
            }else{
                $return= array('code'=>1);
            }
        }else{
            $return= array('code'=>1);
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function saveRequestAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelRequest= new Request();
    $today= getdate();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
		if($dataSend['timeEnd']>=$dataSend['timeStart']){
			if(!empty($dataSend['idRequest'])){
				$save= $modelRequest->getRequest($dataSend['idRequest']);
			}else{
				$save['Request']['time']= $today[0];
				$save['Request']['lock']= false;
				$save['Request']['status']= 'pending';
			}

            $timeStart= explode('-', $dataSend['timeStart']);
            $timeStart= mktime(0,0,0,$timeStart[1],$timeStart[0],$timeStart[2]);

            $timeEnd= explode('-', $dataSend['timeEnd']);
            $timeEnd= mktime(23,59,59,$timeEnd[1],$timeEnd[0],$timeEnd[2]);

			$save['Request']['cityStart']= (int)$dataSend['cityStart'];
			$save['Request']['districtStart']= (int)$dataSend['districtStart'];
			$save['Request']['addressStart']= $dataSend['addressStart'];
			$save['Request']['cityEnd']= (int)$dataSend['cityEnd'];
			$save['Request']['districtEnd']= (int)$dataSend['districtEnd'];
			$save['Request']['addressEnd']= $dataSend['addressEnd'];
			$save['Request']['productName']= $dataSend['productName'];
			$save['Request']['timeStart']= $timeStart;
			$save['Request']['timeEnd']= $timeEnd;
			$save['Request']['weigh']= (int) $dataSend['weigh'];
			$save['Request']['volume']= (int) $dataSend['volume'];
			$save['Request']['typeWeigh']= (int) $dataSend['typeWeigh'];
			$save['Request']['typeVolume']= (int) $dataSend['typeVolume'];
			$save['Request']['typeCar']= (int) $dataSend['typeCar'];
			$save['Request']['priceGood']= (int) $dataSend['priceGood'];
			$save['Request']['typeMoney']= (int) $dataSend['typeMoney'];
			
			$save['Request']['description']= $dataSend['description'];
			$save['Request']['idUser']= $dataUser['Customer']['id'];

			if($modelRequest->save($save)){
				$return= array('code'=>0);
			}else{
				$return= array('code'=>1);
			}
		}else{
			$return= array('code'=>1);
		}
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function getListRequestAPI($input)
{
    $return= array();
    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $modelRequest= new Request();
        $idUser= $dataUser['Customer']['id'];
        $page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        $conditions = array('idUser'=>$idUser, 'lock'=>array('$ne'=>true));
        $order = array('created' => 'desc');
        $fields= array('cityStart','cityEnd','productName','time','districtStart','districtEnd','lock','timeStart');

        $return= $modelRequest->getPage($page, $limit , $conditions, $order, $fields );
    }else{
        $return= array('code'=>-1);
    }
    echo json_encode($return);
}

function cancelRequestAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelRequest= new Request();
    $today= getdate();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $save['$set']['lock']= true;
        $save['$set']['status']= 'delete';

        $id= new MongoId($dataSend['idRequest']);
        // Cẩn thận với điều kiện này
        $dk= array('_id'=>$id,/*'idUser'=>$dataUser['Customer']['id']*/);
        if($modelRequest->updateAll($save,$dk) ){
            $return= array('code'=>0);
        }else{
            $return= array('code'=>1);
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function getInfoRequestAPI($input)
{
    $dataSend= $input['request']->data;
    $modelRequest= new Request();
    $today= getdate();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);
    $return= array();

    if(!empty($dataUser['Customer']['accessToken'])){
        //$return= $modelRequest->getRequestByUser($dataSend['idRequest'],$dataUser['Customer']['id']);
        $return= $modelRequest->getRequest($dataSend['idRequest']);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function getAuctionRequestAPI($input)
{
    $dataSend= $input['request']->data;
    $modelRequest= new Request();
    $today= getdate();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);
    $return= array();

    if(!empty($dataUser['Customer']['accessToken'])){
        $return= $modelRequest->getRequestByUser($dataSend['idRequest'],$dataUser['Customer']['id']);
        //$return= $modelRequest->getRequest($dataSend['idRequest']);

        $return= (!empty($return['Request']['auction']))? array_values($return['Request']['auction']):array();
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function getInfoDriverAPI($input)
{
    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);
    $return= array();

    if(!empty($dataUser['Customer']['accessToken'])){
        $return= $modelCustomer->getCustomer($dataSend['idDriver'],array('fullName','email','fone','company'));
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function getInfoCarAPI($input)
{
    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);
    $return= array();

    if(!empty($dataUser['Customer']['accessToken'])){
        $modelCar= new Car();
        $return= $modelCar->getCar($dataSend['idCar']);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

// lưu lựa chọn của chủ hàng khi chọn xe có sẵn ở so khớp
function saveChooseCaremptyRequestAPI($input)
{
    global $contactSite;

    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $modelRequest= new Request();
    $modelCarempty= new Carempty();

    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);
    $return= array('code'=>1);

    if(!empty($dataUser['Customer']['accessToken'])){
        $emptyCar= $modelCarempty->getCarempty($dataSend['idCarEmpty']);
        $infoDriverBoss= $modelCustomer->getCustomer($emptyCar['Carempty']['idUser'],array('fullName','email','tokenDevice','company'));

        $save['$set']['status']= 'pendingDriver';
        $save['$set']['idDriverBossWin']= $emptyCar['Carempty']['idUser'];
        $save['$set']['priceDone']= (int) $emptyCar['Carempty']['price'];

        $save['$set']['auction.'.$dataUser['Customer']['id']]= array('idUser'=>$emptyCar['Carempty']['idUser'],
                                                                        'nameDriver'=>$infoDriverBoss['Customer']['company']['name'],
                                                                        'price'=>(int) $emptyCar['Carempty']['price'],
                                                                        'time'=> $today[0],
                                                                        'note'=> $emptyCar['Carempty']['note'],
                                                                        'idCar'=> $emptyCar['Carempty']['idCar'],
                                                                        'typeMoney'=>(int) $emptyCar['Carempty']['typeMoney']
                                                                    );
        
        $id= new MongoId($dataSend['idRequest']);
        $dk= array('_id'=>$id);
        
        if($modelRequest->updateAll($save,$dk) ){
            $return= array('code'=>0);

            // gui thong bao cho chu xe thang cuoc
           
            $data= array('functionCall'=>'saveChooseCaremptyRequestAPI','idRequest'=>$dataSend['idRequest'],'title'=>'Có khách chọn xe của bạn');
            $target= array($infoDriverBoss['Customer']['tokenDevice']);
            sendMessageNotifi($data,$target);
        }else{
            $return= array('code'=>1);
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

// chủ hàng chọn nhà xe đấu giá thắng
function saveChooseAuctionRequestAPI($input)
{
	global $contactSite;

    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
	$modelRequest= new Request();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);
    $return= array('code'=>1);

    if(!empty($dataUser['Customer']['accessToken'])){
        $request= $modelRequest->getRequestByUser($dataSend['idRequest'],$dataUser['Customer']['id'],array('lock'=>array('$ne'=>true)));
        
		$save['$set']['status']= 'pendingDriver';
		$save['$set']['idDriverBossWin']= $dataSend['idDriverBoss'];
		$save['$set']['priceDone']= (int) $request['Request']['auction'][$dataSend['idDriverBoss']]['price'];

		$id= new MongoId($dataSend['idRequest']);
		$dk= array('_id'=>$id);
		
		if($modelRequest->updateAll($save,$dk) ){
            $return= array('code'=>0);

            // gui thong bao cho chu xe thang cuoc
            $infoDriverBoss= $modelCustomer->getCustomer($dataSend['idDriverBoss'],array('fullName','email','tokenDevice'));
            $data= array('functionCall'=>'saveChooseAuctionRequestAPI','idRequest'=>$dataSend['idRequest'],'title'=>'Đấu giá '.$request['Request']['productName'].' thành công');
            $target= array($infoDriverBoss['Customer']['tokenDevice']);
            sendMessageNotifi($data,$target);
        }else{
            $return= array('code'=>1);
        }
	}else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}
/*
function saveChooseAuctionRequestAPI($input)
{
    global $contactSite;

    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);
    $return= array('code'=>1);

    if(!empty($dataUser['Customer']['accessToken'])){
        $modelRequest= new Request();
        $modelOrder= new Order();
        $modelCarempty= new Carempty();
        $modelCar= new Car();

        $request= $modelRequest->getRequestByUser($dataSend['idRequest'],$dataUser['Customer']['id'],array('lock'=>array('$ne'=>true)));
        if($request){
            $today= getdate();
            $save['Order']['_id']= new MongoId();
            $save['Order']['time']= $today[0];
            $save['Order']['idUser']= $dataUser['Customer']['id'];
            $save['Order']['idDriverBoss']= $dataSend['idDriverBoss'];

            $save['Order']['idRequest']= $request['Request']['id'];
            $save['Order']['cityStart']= $request['Request']['cityStart'];
            $save['Order']['districtStart']= $request['Request']['districtStart'];
            $save['Order']['addressStart']= $request['Request']['addressStart'];
            $save['Order']['cityEnd']= $request['Request']['cityEnd'];
            $save['Order']['districtEnd']= $request['Request']['districtEnd'];
            $save['Order']['addressEnd']= $request['Request']['addressEnd'];
            $save['Order']['productName']= $request['Request']['productName'];
            $save['Order']['timeStart']= $request['Request']['timeStart'];
            $save['Order']['timeEnd']= $request['Request']['timeEnd'];
            $save['Order']['weigh']= $request['Request']['weigh'];
            $save['Order']['volume']= $request['Request']['volume'];
            $save['Order']['typeWeigh']= $request['Request']['typeWeigh'];
            $save['Order']['typeVolume']= $request['Request']['typeVolume'];
            $save['Order']['typeMoney']= $request['Request']['auction'][$dataSend['idDriverBoss']]['typeMoney'];
            $save['Order']['description']= $request['Request']['description'];
            $save['Order']['price']= $request['Request']['auction'][$dataSend['idDriverBoss']]['price'];
            $save['Order']['idCar']= $request['Request']['auction'][$dataSend['idDriverBoss']]['idCar'];

            $idOrderNew= (string) $save['Order']['_id'];

            $modelOrder->save($save);

            $saveRequest['$set']['lock']= true;
            $saveRequest['$set']['status']= 'complete';
            $saveRequest['$set']['idDriverBossWin']= $dataSend['idDriverBoss'];
            $saveRequest['$set']['priceWin']= $request['Request']['auction'][$dataSend['idDriverBoss']]['price'];

            $id= new MongoId($dataSend['idRequest']);
            $dk= array('_id'=>$id,'idUser'=>$dataUser['Customer']['id']);
            $modelRequest->updateAll($saveRequest,$dk);

            $return= array('code'=>0);
            // Gui email thong bao cho chu xe
            $infoDriverBoss= $modelCustomer->getCustomer($dataSend['idDriverBoss'],array('fullName','email','tokenDevice'));

            $from=array($contactSite['Option']['value']['email']);
            $to=array($infoDriverBoss['Customer']['email']);
            $cc=array();
            $bcc=array();
            $subject='[Netloading] Kết quả đấu giá mặt hàng '.$request['Request']['productName'];
            $content= ' <p>Xin chào '.$infoDriverBoss['Customer']['fullName'].' !</p>

                        <p>Chúc mừng bạn đã trở thành người thắng cuộc trong phiên đấu giá chở '.$request['Request']['productName'].' của chủ hàng '.$dataUser['Customer']['fullName'].' , thông tin đơn hàng như sau:</p>

                        <ul>
                            <li>Nơi gửi: '.$request['Request']['addressStart'].'</li>
                            <li>Nơi nhận: '.$request['Request']['addressEnd'].'</li>
                            <li>Người gửi: '.$dataUser['Customer']['fullName'].'</li>
                            <li>Điện thoại: '.$dataUser['Customer']['fone'].'</li>
                            <li>Tên hàng hóa: '.$request['Request']['productName'].'</li>
                            <li>Ngày đóng hàng: '.date('d/m/Y',$request['Request']['timeStart']).'</li>
                            <li>Ngày nhận hàng: '.date('d/m/Y',$request['Request']['timeEnd']).'</li>
                            <li>Khối lượng: '.number_format($request['Request']['weigh']).'</li>
                            <li>Thể tích: '.number_format($request['Request']['volume']).'</li>
                            <li>Mô tả thêm: '.$request['Request']['description'].'</li>
                            <li>Giá vận chuyển: '.number_format($request['Request']['auction'][$dataSend['idDriverBoss']]['price']).'đ</li>
                        </ul>' . getSignatureEmail();

            $modelRequest->sendMail($from,$to,$cc,$bcc,$subject,$content);

            // gui thong bao cho chu xe thang cuoc
            $data= array('functionCall'=>'saveChooseAuctionRequestAPI','idOrder'=>$idOrderNew,'title'=>'Đấu giá '.$request['Request']['productName'].' thành công');
            $target= array($infoDriverBoss['Customer']['tokenDevice']);
            sendMessageNotifi($data,$target);

            // gui thong bao cho chu xe that bai
            $data= array('functionCall'=>'saveChooseAuctionRequestAPI','idRequest'=>$dataSend['idRequest'],'title'=>'Đấu giá '.$request['Request']['productName'].' thất bại');
            //unset($request['Request']['auction'][$dataSend['idDriverBoss']]);
            $target= array();
            $listTypeCar= getListTypeCar();
            foreach($request['Request']['auction'] as $auction){
                $infoDriverFail= $modelCustomer->getCustomer($auction['idUser'],array('tokenDevice'));
                if($infoDriverFail['Customer']['id']!=$dataSend['idDriverBoss']){
                    $target[]= $infoDriverFail['Customer']['tokenDevice'];
                }
                $infoCar= $modelCar->getCar($request['Request']['auction'][$infoDriverFail['Customer']['id']]['idCar']);

                // tạo chuyến xe có sẵn từ đấu giá thất bại
                $modelCarempty->create();
                $saveCarempty= array();
                $saveCarempty['Carempty']['time']= $today[0];
                $saveCarempty['Carempty']['lock']= false;
                $saveCarempty['Carempty']['idUser']= $infoDriverFail['Customer']['id'];
                $saveCarempty['Carempty']['cityStart']= (int)$request['Request']['cityStart'];
                $saveCarempty['Carempty']['districtStart']= (int)$request['Request']['districtStart'];
                $saveCarempty['Carempty']['cityEnd']= (int)$request['Request']['cityEnd'];
                $saveCarempty['Carempty']['districtEnd']= (int)$request['Request']['districtEnd'];
                $saveCarempty['Carempty']['idCar']= $request['Request']['auction'][$infoDriverFail['Customer']['id']]['idCar'];
                $saveCarempty['Carempty']['note']= $request['Request']['auction'][$infoDriverFail['Customer']['id']]['note'];
                $saveCarempty['Carempty']['typeMoney']= (int) $request['Request']['auction'][$infoDriverFail['Customer']['id']]['typeMoney'];
                $saveCarempty['Carempty']['groupCar']= $listTypeCar[$infoCar['Car']['typeCar'] ]['group'];
                $saveCarempty['Carempty']['timeStart']= (int) $request['Request']['timeStart'];
                $saveCarempty['Carempty']['timeEnd']= (int) $request['Request']['timeEnd'];

                // tính giá tối ưu
                if($request['Request']['weigh']>0){
                    $giakhoiluong= round($request['Request']['auction'][$infoDriverFail['Customer']['id']]['price']*$infoCar['Car']['weight']/$request['Request']['weigh']);
                }else{
                    $giakhoiluong= -1;
                }

                if($request['Request']['weigh']>0){
                    $giasokhoi= round($request['Request']['auction'][$infoDriverFail['Customer']['id']]['price']*$infoCar['Car']['volume']/$request['Request']['volume']);
                }else{
                    $giasokhoi= -1;
                }

                if($giakhoiluong>0 && $giasokhoi>0){
                    $saveCarempty['Carempty']['price']= min($giakhoiluong,$giasokhoi);
                }else{
                    if($giakhoiluong>0){
                        $saveCarempty['Carempty']['price']= $giakhoiluong;
                    }elseif ($giasokhoi>0) {
                        $saveCarempty['Carempty']['price']= $giasokhoi;
                    }else{
                        $saveCarempty['Carempty']['price']= 0;
                    }
                }

                $modelCarempty->save($saveCarempty);

            }

            sendMessageNotifi($data,$target);
        }else{
            $return= array('code'=>3);
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}
*/

function getListOrderAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelOrder= new Order();
    $today= getdate();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        $conditions = array('lock'=>array('$ne'=>true),'idUser'=>$dataUser['Customer']['id']);
        $order = array('created' => 'desc');
        $fields= null;

        $data= $modelOrder->getPage($page, $limit, $conditions, $order,$fields);

        $return= array('code'=>0,'listData'=>$data);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function getInfoOrderAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelOrder= new Order();
    $today= getdate();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $data= $modelOrder->getOrder($dataSend['idOrder']);
        
        if($data){
            $modelCar= new Car();
            $infoCar= $modelCar->getCar($data['Order']['idCar']);
            if($infoCar){
                $data['Order']['typeCar']= $infoCar['Car']['typeCar'];
            }

            $infoDriverBoss= $modelCustomer->getCustomer($data['Order']['idDriverBoss'],array('fullName','email','fone','company'));
            if($infoDriverBoss){
                $data['Order']['infoDriverBoss']= $infoDriverBoss['Customer'];
            }

            if(!empty($data['Order']['idDriver'])){
                $modelDriver= new Driver();
                $infoDriver= $modelDriver->getDriver($data['Order']['idDriver']);
                if($infoDriver){
                    $data['Order']['infoDriver']= $infoDriver['Driver'];
                }
            }
        }

        $return= array('code'=>0,'data'=>$data);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function getListAllCarEmptyAPI($input)
{
    $return= array();
    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $modelCar= new Car();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $modelCarempty= new Carempty();
        $page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        $conditions = array('lock'=>array('$ne'=>true) );

        if(!empty($dataSend['cityStart'])){
            $conditions['cityStart']= (int)$dataSend['cityStart'];
        }

        if(!empty($dataSend['cityEnd'])){
            $conditions['cityEnd']= (int)$dataSend['cityEnd'];
        }

        $order = array('created' => 'desc');
        $fields= null;

        $listData= $modelCarempty->getPage($page, $limit , $conditions, $order, $fields );

        if($listData){
            foreach($listData as $key=>$data){
                $listData[$key]['Carempty']['infoCar']= $modelCar->getCar($data['Carempty']['idCar']);
            }
        }

        $return= array('code'=>1,'listData'=>$listData);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function getCompareCarEmptyAPI($input)
{
    $return= array();
    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $modelCar= new Car();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $modelCarempty= new Carempty();
        $page=1;
        $limit= 5;
        $conditions = array('lock'=>array('$ne'=>true) );

        $conditions['cityStart']= (int)$dataSend['cityStart'];
        $conditions['cityEnd']= (int)$dataSend['cityEnd'];
        $conditions['timeStart']= (int)$dataSend['timeStart'];
        $conditions['timeEnd']= array('$lte' => (int)$dataSend['timeEnd']);

        if($dataSend['groupCar']!=1){
            $conditions['groupCar']= (int) $dataSend['groupCar'];
        }else{
            //$conditions['groupCar']= array('$or'=>array(1,2));
            $conditions['$or']= array(array('groupCar'=>1),array('groupCar'=>2));
        }

        $order = array('price' => 'asc','weight'=>'asc','volume'=>'asc');
        $fields= null;

        $listData= $modelCarempty->getPage($page, $limit , $conditions, $order, $fields );

        if($listData){
            foreach($listData as $key=>$data){
                $listData[$key]['Carempty']['infoCar']= $modelCar->getCar($data['Carempty']['idCar']);
            }
        }

        $return= array('code'=>1,'listData'=>$listData);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function getInfoCarEmptyAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelCarempty= new Carempty();
    $modelDriver= new Driver();
    $modelCustomer= new Customer();
    $modelCar= new Car();

    $today= getdate();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $data= $modelCarempty->getCarempty($dataSend['idCarEmpty']);

        if($data){
            foreach($data as $key=>$info){
                $data[$key]['Carempty']['infoDriver']= $modelDriver->getDriver($info['Carempty']['idDriver']);
                $data[$key]['Carempty']['infoCar']= $modelCar->getCar($info['Carempty']['idCar']);
            }
        }

        $return= array('code'=>0,'data'=>$data);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}


function getDriverAroundAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    //$modelDriver= new Driver();
    $modelHistory= new History();
    $today= getdate();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    //var_dump($dataSend);die;

    if(!empty($dataUser['Customer']['accessToken'])){
        $listCity= getListCity();
        // 100km tương đương 0.9 độ
        $fields= array('fullName','fone','latGPS','longGPS');
        //$data= $modelDriver->getDriverAround($dataSend['lat'],$dataSend['long'],$dataSend['radius'],$dataSend['cityStart'],$dataSend['cityEnd']);
        //$data= $modelCarempty->getDriverAround($dataSend['lat'],$dataSend['long'],$dataSend['radius'],$dataSend['cityStart'],$dataSend['cityEnd']);
        $listData= $modelHistory->getDriverAroundDistance($dataSend['distance']*0.7);
        $listDataCheck= array();

        if($listData){
            foreach($listData as $key=>$data){
                $ca= file_get_contents('http://maps.googleapis.com/maps/api/directions/json?origin='.$data['History']['latGPS'].','.$data['History']['longGPS'].'&destination='.$dataSend['cityStart'].'&sensor=false');
                $ca= json_decode($ca,true);
                $ca= $ca['routes'][0]['legs'][0]['distance']['value'];

                $bd= file_get_contents('http://maps.googleapis.com/maps/api/directions/json?origin='.$dataSend['cityEnd'].'&destination='.$data['History']['gpsCityEnd'].'&sensor=false');
                $bd= json_decode($bd,true);
                $bd= $bd['routes'][0]['legs'][0]['distance']['value'];

                if(($ca+$dataSend['distance']+$bd)<=($data['History']['distance']*1.3)){
                    $listDataCheck[]= $data;
                }
            }
        }

        $return= array('code'=>0,'data'=>$listDataCheck);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function sendNotifiChat($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $infoCustomer= $modelCustomer->getCustomer($dataSend['idUser'],array('tokenDevice'));

        // gui thong bao cho ban
        $data= array('functionCall'=>'sendNotifiChat','title'=>'Bạn có tin nhắn mới','idUser'=>$dataUser['Customer']['id'],'fullName'=>$dataUser['Customer']['fullName']);
        $target= array($infoCustomer['Customer']['tokenDevice']);
        sendMessageNotifi($data,$target);

        $return= array('code'=>0);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function getInfoDriverStaffAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelDriver= new Driver();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $data= $modelDriver->getDriver($dataSend['idDriverStaff']);

        $return= array('code'=>0,'data'=>$data);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function getInfoCarStaffAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelCar= new Car();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $data= $modelCar->getCar($dataSend['idCar']);

        $return= array('code'=>0,'data'=>$data);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}
?>