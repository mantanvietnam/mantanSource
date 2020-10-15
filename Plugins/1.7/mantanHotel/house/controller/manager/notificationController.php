<?php
function managerListNotification() {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $typeCollectionBill;
    global $urlNow;

    if (checkLoginManager()) {
        $today = getdate();
        $modelNotification = new Notification();
        $modelRoom = new Room();

        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions['idHotel'] = $_SESSION['idHotel'];
        $conditions['to'] = 'manager';

        if (!empty($_GET['dateStart'])){
            $dateStart = strtotime(str_replace("/", "-", $_GET['dateStart']) . ' 0:0:0');
            $conditions['time']['$gte']= $dateStart;
        }
        
        if(!empty($_GET['dateEnd'])){
            $dateEnd = strtotime(str_replace("/", "-", $_GET['dateEnd']) . ' 23:59:59');
            $conditions['time']['$lte']= $dateEnd;
        }

        $listData = $modelNotification->getPage($page, $limit, $conditions);

        if($listData){
            foreach($listData as $key=>$data){
                $room= $modelRoom->getRoom($data['Notification']['idRoom']);

                $listData[$key]['Notification']['nameRoom']= @$room['Room']['name'];
                $listData[$key]['Notification']['phone']= (!empty($data['Notification']['phone']))?$data['Notification']['phone']:@$room['Room']['checkin']['Custom']['phone'];
            }
        }

        $totalData = $modelNotification->find('count', array('conditions' => $conditions));

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
            if (count($_GET) > 1) {
                $urlPage = $urlPage . '&page=';
            } else {
                $urlPage = $urlPage . 'page=';
            }
        } else {
            $urlPage = $urlPage . '?page=';
        }

        setVariable('listData', $listData);
        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);

        if(isset($_GET['action']) && $_GET['action']=='Xuất Excel'){
            $listDataAll= $modelNotification->getPage(1, null, $conditions);

            $table = array(
                array('label' => __('STT'), 'width' => 5),
                array('label' => __('Thời gian'),'width' => 15, 'filter' => true, 'wrap' => true),
                array('label' => __('Phòng'),'width' => 20, 'filter' => true, 'wrap' => true),
                array('label' => __('Nội dung'), 'width' => 15, 'filter' => true, 'wrap' => true),
                array('label' => __('Điện thoại'), 'width' => 15,  'wrap' => true),
            );

            $data= array();
            if (!empty($listDataAll)) {
                $stt=0;
                foreach ($listDataAll as $key => $tin) {
                    $stt++;
                    $data[]= array( $stt,
                                    date('H:i d/m/Y', $tin['Notification']['time']),
                                    $data['Notification']['nameRoom'],
                                    $data['Notification']['content'],
                                    $data['Notification']['phone'],
                                    );
                }
                
            }
            
            $exportsController = new ExportsController;
            $exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
        }
        
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function managerListNotificationCustomer() {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $typeCollectionBill;
    global $urlNow;

    if (checkLoginManager()) {
        $today = getdate();
        $modelNotification = new Notification();
        $modelRoom = new Room();

        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions['idHotel'] = $_SESSION['idHotel'];
        $conditions['to'] = 'customer';

        if (!empty($_GET['dateStart'])){
            $dateStart = strtotime(str_replace("/", "-", $_GET['dateStart']) . ' 0:0:0');
            $conditions['time']['$gte']= $dateStart;
        }
        
        if(!empty($_GET['dateEnd'])){
            $dateEnd = strtotime(str_replace("/", "-", $_GET['dateEnd']) . ' 23:59:59');
            $conditions['time']['$lte']= $dateEnd;
        }

        $listData = $modelNotification->getPage($page, $limit, $conditions);

        if($listData){
            foreach($listData as $key=>$data){
                if(!empty($data['Notification']['idRoom'])){
                    $room= $modelRoom->getRoom($data['Notification']['idRoom']);

                    $listData[$key]['Notification']['nameRoom']= @$room['Room']['name'];
                    $listData[$key]['Notification']['phone']= @$room['Room']['checkin']['Custom']['phone'];
                }else{
                    $listData[$key]['Notification']['nameRoom']= 'Thông báo chung';
                    $listData[$key]['Notification']['phone']= '';
                }
            }
        }

        $totalData = $modelNotification->find('count', array('conditions' => $conditions));

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
            if (count($_GET) > 1) {
                $urlPage = $urlPage . '&page=';
            } else {
                $urlPage = $urlPage . 'page=';
            }
        } else {
            $urlPage = $urlPage . '?page=';
        }

        setVariable('listData', $listData);
        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);

        if(isset($_GET['action']) && $_GET['action']=='Xuất Excel'){
            $listDataAll= $modelNotification->getPage(1, null, $conditions);

            $table = array(
                array('label' => __('STT'), 'width' => 5),
                array('label' => __('Thời gian'),'width' => 15, 'filter' => true, 'wrap' => true),
                array('label' => __('Phòng'),'width' => 20, 'filter' => true, 'wrap' => true),
                array('label' => __('Nội dung'), 'width' => 15, 'filter' => true, 'wrap' => true),
                array('label' => __('Điện thoại'), 'width' => 15,  'wrap' => true),
            );

            $data= array();
            if (!empty($listDataAll)) {
                $stt=0;
                foreach ($listDataAll as $key => $tin) {
                    $stt++;
                    $data[]= array( $stt,
                                    date('H:i d/m/Y', $tin['Notification']['time']),
                                    $data['Notification']['nameRoom'],
                                    $data['Notification']['content'],
                                    $data['Notification']['phone'],
                                    );
                }
                
            }
            
            $exportsController = new ExportsController;
            $exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
        }
        
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function managerDeleteNotificationCustomer($input)
{
    global $urlHomes;
    $modelNotification = new Notification();
    if (checkLoginManager()) {
        if(!empty($_POST['idDelete'])){
            $idDelete= new MongoId($_POST['idDelete']);
            $modelNotification->delete($idDelete);

            //$modelNotification->redirect($urlHomes.'managerListNotificationRoom?status=2');
        }
    }else {
        //$modelNotification->redirect($urlHomes);
    }
}

function managerAddNotificationCustomer($input)
{
    $modelRoom = new Room();
    $modelUser= new Userhotel();
    $modelNotification = new Notification();
    $modelHotel= new Hotel();

    global $urlHomes;
    global $contactSite;
    global $isRequestPost;

    if (checkLoginManager()) {
        if(!empty($_GET['idroom'])) {
            $data = $modelRoom->getRoom($_GET['idroom']);
            setVariable('data', $data);
        }

        $listData= $modelRoom->getAllRoomByHotel($_SESSION['idHotel'],array('delete'=>0),array('name'=>'asc') );

        if(empty($listData)){
            $modelRoom->redirect($urlHomes.'managerAddRoom');
        }

        if ($isRequestPost) {
            $dataSend = $input['request']->data;
            $today= getdate();
      
            $save['Notification']['idHotel']= $_SESSION['idHotel'];
            $save['Notification']['idRoom']= $dataSend['idRoom'];
            $save['Notification']['title']= $dataSend['title'];
            $save['Notification']['content']= $dataSend['content'];
            $save['Notification']['time']= $today[0];
            $save['Notification']['file']= (!empty($dataSend['file']))?$urlHomes.$dataSend['file']:"";
            $save['Notification']['to']= 'customer';
        
            if($modelNotification->save($save)){
            	$hotel= $modelHotel->getHotel($_SESSION['idHotel'],array('name'));
            	$target= array();
            	$to= array();

            	if(!empty($save['Notification']['idRoom'])){
            		$room= $modelRoom->getRoom($save['Notification']['idRoom']);

            		if(!empty($room['Room']['checkin']['Custom']['user'])){
            			$user= $modelUser->getByUser($room['Room']['checkin']['Custom']['user'],array('tokenDevice','email','fullname') );
            			
            			if(!empty($user['User']['tokenDevice'])){
				            $target= array($user['User']['tokenDevice']);
            			}
            			
            			if(!empty($user['User']['email'])){
					        $to=array($user['User']['email']);
            			}
            		}
            	}else{
            		foreach($listData as $room){
            			if(!empty($room['Room']['checkin']['Custom']['user'])){
	            			$user= $modelUser->getByUser($room['Room']['checkin']['Custom']['user'],array('tokenDevice','email','fullname') );
	            			
	            			if(!empty($user['User']['tokenDevice'])){
					            $target[]= $user['User']['tokenDevice'];
	            			}
	            			
	            			if(!empty($user['User']['email'])){
						        $to[]= $user['User']['email'];
	            			}
	            		}
            		}
            	}

            	// gửi thông báo cho người dùng qua app
            	if(!empty($target)){
            		$dataNoti= array('functionCall'=>'managerAddNotificationCustomer','title'=>'Thông báo mới từ '.$hotel['Hotel']['name']);
            		sendMessageNotifi($dataNoti,$target);
            	}
            	// Gửi email thông báo
            	if(!empty($to)){
            		$from=array($contactSite['Option']['value']['email']);
            		$cc=array();
			        $bcc=array();
			        $subject='[ManMo] Thông báo mới từ '.$hotel['Hotel']['name'];
			        $content= ' <p>Xin chào '.$user['User']['fullname'].' !</p>

			                    <p>Bạn nhận được thông báo như sau:</p>'.nl2br($dataSend['content']);
			        if(!empty($save['Notification']['file']) ){
			        	$content .= '<p>File đính kèm: <a href="'.$save['Notification']['file'].'">'.$save['Notification']['file'].'</a></p>';
			        }
					$content .= getSignatureEmail();

			        $modelUser->sendMail($from,$to,$cc,$bcc,$subject,$content);
            	}

                $modelRoom->redirect($urlHomes.'managerListNotificationCustomer?status=1');
            }else{
                $modelRoom->redirect($urlHomes.'managerListNotificationCustomer?status=0');
            }

        } 
        
        setVariable('listData', $listData);
        
    } else {
        $modelRoom->redirect($urlHomes);
    }
}

?>