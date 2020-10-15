<?php
function managerDeleteReportRoom($input)
{
	global $urlHomes;
	$modelReport = new Report();
	if (checkLoginManager()) {
		if(!empty($_POST['idDelete'])){
			$idDelete= new MongoId($_POST['idDelete']);
			$modelReport->delete($idDelete);

			//$modelReport->redirect($urlHomes.'managerListReportRoom?status=2');
		}
	}else {
        //$modelReport->redirect($urlHomes);
    }
}

function managerAddReportRoom($input)
{
	$modelRoom = new Room();
	$modelReport = new Report();

    global $urlHomes;
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
      
        	$save['Report']['idHotel']= $_SESSION['idHotel'];
        	$save['Report']['idRoom']= $dataSend['idRoom'];
        	$save['Report']['content']= $dataSend['content'];
        	$save['Report']['time']= $today[0];
        	$save['Report']['status']= 'new';
        
            if($modelReport->save($save)){
            	$modelRoom->redirect($urlHomes.'managerListReportRoom?status=1');
            }else{
            	$modelRoom->redirect($urlHomes.'managerListReportRoom?status=0');
            }

        } 
		
		setVariable('listData', $listData);
	    
    } else {
        $modelRoom->redirect($urlHomes);
    }
}

function managerEditReportRoom($input)
{
	$modelRoom = new Room();
	$modelReport = new Report();

    global $urlHomes;
    global $isRequestPost;

    if (checkLoginManager()) {
        if(!empty($_GET['idReport'])) {
        	$data = $modelReport->getReport($_GET['idReport']);
        	
	    	$listData= $modelRoom->getAllRoomByHotel($_SESSION['idHotel'],array('delete'=>0),array('name'=>'asc') );

	    	if(!$listData){
	    		$modelRoom->redirect($urlHomes.'managerAddRoom');
	    	}

	    	if(!$data){
	    		$modelRoom->redirect($urlHomes.'managerListReportRoom');
	    	}

	        if ($isRequestPost && $data) {
	        	$dataSend = $input['request']->data;
	        	
	        	$data['Report']['content']= $dataSend['content'];
	        	$data['Report']['status']= $dataSend['status'];

	            if($modelReport->save($data)){
	            	$modelRoom->redirect($urlHomes.'managerListReportRoom?status=1');
	            }else{
	            	$modelRoom->redirect($urlHomes.'managerListReportRoom?status=0');
	            }

	        } 
			
			setVariable('data', $data);
			setVariable('listData', $listData);
		}else{
			$modelRoom->redirect($urlHomes);
		}
	    
    } else {
        $modelRoom->redirect($urlHomes);
    }
}

function managerListReportRoom() {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $typeCollectionBill;
    global $urlNow;

    if (checkLoginManager()) {
        $today = getdate();
        $modelReport = new Report();
        $modelRoom = new Room();

        $mess = '';
        if (isset($_GET['status'])) {
            switch ($_GET['status']) {
                case 1: $mess = 'Lưu báo lỗi thành công';
                    break;
                case 0: $mess = 'Lưu báo lỗi thất bại';
                    break;
                case 2: $mess = 'Xoá báo lỗi thành công';
                    break;
            }
        }

        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions['idHotel'] = $_SESSION['idHotel'];

        if (!empty($_GET['dateStart'])){
            $dateStart = strtotime(str_replace("/", "-", $_GET['dateStart']) . ' 0:0:0');
            $conditions['time']['$gte']= $dateStart;
        }
        
        if(!empty($_GET['dateEnd'])){
            $dateEnd = strtotime(str_replace("/", "-", $_GET['dateEnd']) . ' 23:59:59');
            $conditions['time']['$lte']= $dateEnd;
        }

        $listData = $modelReport->getPage($page, $limit, $conditions);

        if($listData){
        	foreach($listData as $key=>$data){
        		$room= $modelRoom->getRoom($data['Report']['idRoom']);

        		$listData[$key]['Report']['nameRoom']= @$room['Room']['name'];
        	}
        }

        $totalData = $modelReport->find('count', array('conditions' => $conditions));

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
        setVariable('mess', $mess);

        if(isset($_GET['action']) && $_GET['action']=='Xuất Excel'){
            $listDataAll= $modelReport->getPage(1, null, $conditions);

            $table = array(
                array('label' => __('STT'), 'width' => 5),
                array('label' => __('Thời gian'),'width' => 15, 'filter' => true, 'wrap' => true),
                array('label' => __('Phòng'),'width' => 20, 'filter' => true, 'wrap' => true),
                array('label' => __('Nội dung'), 'width' => 15, 'filter' => true, 'wrap' => true),
                array('label' => __('Trạng thái'), 'width' => 15,  'wrap' => true),
            );

            $data= array();
            if (!empty($listDataAll)) {
                $stt=0;
                foreach ($listDataAll as $key => $tin) {
                    $stt++;
                    $data[]= array( $stt,
                                    date('H:i d/m/Y', $tin['Report']['time']),
                                    $data['Report']['nameRoom'],
                                    $data['Report']['content'],
                                    $data['Report']['status'],
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

?>