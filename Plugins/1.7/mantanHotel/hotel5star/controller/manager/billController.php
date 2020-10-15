<?php

function managerListCollectionBill($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $typeCollectionBill;
    global $urlNow;

    if (checkLoginManager()) {
        $today = getdate();
        $modelCollectionBill = new CollectionBill();

        $mess = '';
        if (isset($_GET['status'])) {
            switch ($_GET['status']) {
                case 1: $mess = 'Lưu phiếu thu thành công';
                    break;
                case 2: $mess = 'Xóa phiếu thu thành công';
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
        
        if (!empty($_GET['idStaff'])) {
            $conditions['idStaff'] = $_GET['idStaff'];
        }

        $listData = $modelCollectionBill->getPage($page, $limit, $conditions);

        $totalData = $modelCollectionBill->find('count', array('conditions' => $conditions));

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

        $modelStaff = new Staff();
        $conditionsStaff['idHotel'] = $_SESSION['idHotel'];

        $listStaff = $modelStaff->getPage(1, null, $conditionsStaff);

        setVariable('listData', $listData);
        setVariable('listStaff', $listStaff);
        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);
        setVariable('mess', $mess);
        setVariable('typeCollectionBill', $typeCollectionBill);
        
        if(isset($_GET['action']) && $_GET['action']=='Xuất Excel'){
            $table = array(
                array('label' => __('STT'), 'width' => 5),
                array('label' => __('Ngày tạo'),'width' => 17, 'filter' => true, 'wrap' => true),
                array('label' => __('Số tiền'), 'width' => 15, 'filter' => true, 'wrap' => true),
                array('label' => __('Người nộp'),'width' => 20, 'filter' => true, 'wrap' => true),
                array('label' => __('Hình thức thu'), 'width' => 15, 'filter' => true),
                array('label' => __('Người nhận'), 'width' => 20, 'filter' => true),
                array('label' => __('Ghi chú'), 'width' => 45,  'wrap' => true)
            );
            
            $data= array();
            $listDataAll= $modelCollectionBill->getPage(1, null, $conditions);
            if (!empty($listDataAll)) {
                foreach ($listDataAll as $key => $tin) {
                    $stt= $key+1;
                    $dateCreate = getdate($tin['CollectionBill']['time']);
                    
                    $data[]= array( $stt,
                                    $dateCreate['hours'] . ':' . $dateCreate['minutes'] . ' ' . $dateCreate['mday'] . '/' . $dateCreate['mon'] . '/' . $dateCreate['year'],
                                    number_format($tin['CollectionBill']['coin']),
                                    $tin['CollectionBill']['nguoi_nop'],
                                    $typeCollectionBill[$tin['CollectionBill']['typeCollectionBill']],
                                    $tin['CollectionBill']['nguoi_nhan'],
                                    $tin['CollectionBill']['note']
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

function managerAddCollectionBill($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $typeCollectionBill;

    if (checkLoginManager()) {
        $today = getdate();
        $modelCollectionBill = new CollectionBill();

        if (isset($_GET['id'])) {
            $data = $modelCollectionBill->getCollectionBill($_GET['id']);
            
            if($data && (!$_SESSION['infoManager']['Manager']['isStaff'] || in_array('editCollectionBill',$_SESSION['infoManager']['Manager']['permissionAdvanced']))){
                $today = getdate($data['CollectionBill']['time']);
                setVariable('data', $data);
            }else{
                $modelOption->redirect($urlHomes);
            }
        }

        if ($isRequestPost) {
            $dataSend = arrayMap($input['request']->data);

            $save['CollectionBill']['time'] = strtotime(str_replace("/", "-", $dataSend['date']) . ' ' . $dataSend['time']);
            $save['CollectionBill']['coin'] = (int) $dataSend['coin'];
            $save['CollectionBill']['nguoi_nop'] = $dataSend['nguoi_nop'];
            $save['CollectionBill']['typeCollectionBill'] = $dataSend['typeCollectionBill'];
            $save['CollectionBill']['nguoi_nhan'] = $dataSend['nguoi_nhan'];
            $save['CollectionBill']['note'] = $dataSend['note'];
            $save['CollectionBill']['idHotel'] = $_SESSION['idHotel'];
            $save['CollectionBill']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
            $save['CollectionBill']['idManager'] = $_SESSION['infoManager']['Manager']['id'];

            if (isset($dataSend['id']) && $dataSend['id'] != '') {
                $save['CollectionBill']['id'] = $dataSend['id'];
            }

            $modelCollectionBill->save($save);
            $modelCollectionBill->redirect($urlHomes . 'managerListCollectionBill?status=1');
        }

        setVariable('today', $today);
        setVariable('typeCollectionBill', $typeCollectionBill);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function managerPrintCollectionBill($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $typeCollectionBill;

    if (checkLoginManager()) {
        $today = getdate();
        $modelCollectionBill = new CollectionBill();
        $modelHotel= new Hotel();

        if (isset($_GET['id'])) {
            $data = $modelCollectionBill->getCollectionBill($_GET['id']);
            
            if($data){
                $today = getdate($data['CollectionBill']['time']);
                $dataHotel = $modelHotel->getHotel($_SESSION['idHotel']);

                setVariable('data', $data);
                setVariable('today', $today);
                setVariable('typeCollectionBill', $typeCollectionBill);
                setVariable('dataHotel', $dataHotel);
            }else{
                $modelOption->redirect($urlHomes);
            }
        }else{
            $modelOption->redirect($urlHomes);
        }
        
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function managerDeleteCollectionBill($input) {
    global $modelOption;
    global $urlHomes;

    if (checkLoginManager()) {
        $modelCollectionBill = new CollectionBill();
        
        if(isset($_GET['id']) && (!$_SESSION['infoManager']['Manager']['isStaff'] || in_array('deleteCollectionBill',$_SESSION['infoManager']['Manager']['permissionAdvanced']))){
            $idDelete = new MongoId($_GET['id']);
            $modelCollectionBill->delete($idDelete);
        }else{
            $modelOption->redirect($urlHomes);
        }

        $modelOption->redirect($urlHomes . 'managerListCollectionBill?status=2');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function managerListBill($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $typeBill;
    global $urlNow;

    if (checkLoginManager()) {
        $today = getdate();
        $modelBill = new Bill();

        $mess = '';
        if (isset($_GET['status'])) {
            switch ($_GET['status']) {
                case 1: $mess = 'Lưu phiếu chi thành công';
                    break;
                case 2: $mess = 'Xóa phiếu chi thành công';
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
        
        if (!empty($_GET['idStaff'])) {
            $conditions['idStaff'] = $_GET['idStaff'];
        }
        $listData = $modelBill->getPage($page, $limit, $conditions);

        $totalData = $modelBill->find('count', array('conditions' => $conditions));

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
        $modelStaff = new Staff();
        $conditionsStaff['idHotel'] = $_SESSION['idHotel'];

        $listStaff = $modelStaff->getPage($page, $limit = 100, $conditionsStaff);

        setVariable('listData', $listData);
        setVariable('listStaff', $listStaff);

        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);
        setVariable('mess', $mess);
        setVariable('typeCollectionBill', $typeBill);
        
        if(isset($_GET['action']) && $_GET['action']=='Xuất Excel'){
            $table = array(
                array('label' => __('STT'), 'width' => 5),
                array('label' => __('Ngày tạo'),'width' => 17, 'filter' => true, 'wrap' => true),
                array('label' => __('Số tiền'), 'width' => 15, 'filter' => true, 'wrap' => true),
                array('label' => __('Người nhận'),'width' => 20, 'filter' => true, 'wrap' => true),
                array('label' => __('Hình thức chi'), 'width' => 15, 'filter' => true),
                array('label' => __('Người chi'), 'width' => 20, 'filter' => true),
                array('label' => __('Ghi chú'), 'width' => 45,  'wrap' => true)
            );
            
            $data= array();
            $listDataAll= $modelBill->getPage(1, null, $conditions);
            if (!empty($listDataAll)) {
                foreach ($listDataAll as $key => $tin) {
                    $stt= $key+1;
                    $dateCreate = getdate($tin['Bill']['time']);
                    
                    $data[]= array( $stt,
                                    $dateCreate['hours'] . ':' . $dateCreate['minutes'] . ' ' . $dateCreate['mday'] . '/' . $dateCreate['mon'] . '/' . $dateCreate['year'],
                                    number_format($tin['Bill']['coin']),
                                    $tin['Bill']['nguoi_nhan'],
                                    $typeBill[$tin['Bill']['typeBill']],
                                    $tin['Bill']['nguoi_chi'],
                                    $tin['Bill']['note']
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

function managerPrintBill($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $typeBill;

    if (checkLoginManager()) {
        $today = getdate();
        $modelBill = new Bill();
        $modelHotel = new Hotel();

        if (isset($_GET['id'])) {
            $data = $modelBill->getBill($_GET['id']);
            $dataHotel = $modelHotel->getHotel($_SESSION['idHotel']);

            if($data){
                $today = getdate($data['Bill']['time']);

                setVariable('data', $data);
                setVariable('today', $today);
                setVariable('typeCollectionBill', $typeBill);
                setVariable('dataHotel', $dataHotel);
            }else{
                $modelOption->redirect($urlHomes);
            }
        }else{
            $modelOption->redirect($urlHomes);
        }
        
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function managerAddBill($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $typeBill;

    if (checkLoginManager()) {
        $today = getdate();
        $modelBill = new Bill();

        if (isset($_GET['id'])) {
            $data = $modelBill->getBill($_GET['id']);

            if($data && (!$_SESSION['infoManager']['Manager']['isStaff'] || in_array('editBill',$_SESSION['infoManager']['Manager']['permissionAdvanced']))){
                $today = getdate($data['Bill']['time']);
                setVariable('data', $data);
            }else{
                $modelOption->redirect($urlHomes);
            }
        }

        if ($isRequestPost) {
            $dataSend = arrayMap($input['request']->data);

            $save['Bill']['time'] = strtotime(str_replace("/", "-", $dataSend['date']) . ' ' . $dataSend['time']);
            $save['Bill']['coin'] = (int) $dataSend['coin'];
            $save['Bill']['nguoi_chi'] = $dataSend['nguoi_chi'];
            $save['Bill']['typeBill'] = $dataSend['typeBill'];
            $save['Bill']['nguoi_nhan'] = $dataSend['nguoi_nhan'];
            $save['Bill']['note'] = $dataSend['note'];
            $save['Bill']['idHotel'] = $_SESSION['idHotel'];
            $save['Bill']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
            $save['Bill']['idManager'] = $_SESSION['infoManager']['Manager']['id'];

            if (isset($dataSend['id']) && $dataSend['id'] != '') {
                $save['Bill']['id'] = $dataSend['id'];
            }

            $modelBill->save($save);
            $modelBill->redirect($urlHomes . 'managerListBill?status=1');
        }

        setVariable('today', $today);
        setVariable('typeCollectionBill', $typeBill);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function managerDeleteBill($input) {
    global $modelOption;
    global $urlHomes;

    if (checkLoginManager()) {
        $modelBill = new Bill();
        
        if(isset($_GET['id']) && (!$_SESSION['infoManager']['Manager']['isStaff'] || in_array('deleteBill',$_SESSION['infoManager']['Manager']['permissionAdvanced']))){
            $idDelete = new MongoId($_GET['id']);
            $modelBill->delete($idDelete);
        }else{
            $modelOption->redirect($urlHomes);
        }

        $modelOption->redirect($urlHomes . 'managerListBill?status=2');
    } else {
        $modelOption->redirect($urlHomes);
    }
}


?>