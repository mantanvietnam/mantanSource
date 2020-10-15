<?php

/**
 * List Merchandise
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerListMerchandise($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    if (checkLoginManager()) {
        $mess= '';
        if(isset($_GET['redirect'])){
            switch($_GET['redirect']){
                case 'managerAddNumberMerchandise': $mess= '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Thêm số lượng Hàng hóa thành công!</p>';break;
                case 'managerSellMerchandise': $mess= '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Bán lẻ Hàng hóa thành công!</p>';break;
            }
        }
        
        if (isset($_GET['status'])) {
            switch ($_GET['status']) {
                case 1: $mess= '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Thêm Hàng hóa - Dịch vụ thành công!</p>';
                    break;
                case -1: $mess= '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Thêm Hàng hóa - Dịch vụ không thành công!</p>';
                    break;
                case 3: $mess= '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Sửa Hàng hóa - Dịch vụ thành công!</p>';
                    break;
                case -3: $mess= '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Sửa Hàng hóa - Dịch vụ không thành công!</p>';
                    break;
                case 4: $mess= '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Xóa Hàng hóa - Dịch vụ thành công!</p>';
                    break;
            }
        }
        
        $modelMerchandise = new Merchandise();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();
        if(!empty($_SESSION['idHotel'])){
            $conditions['idHotel']= $_SESSION['idHotel'];
        }
        
        if(!empty($_GET['idNhomHangHoa'])){
            $conditions['type_merchandise']= $_GET['idNhomHangHoa'];
        }
        
        if(!empty($_GET['code'])){
            $conditions['code']= $_GET['code'];
        }
        
        $listData = $modelMerchandise->getPage($page, $limit,$conditions);
        
        $conditionsGroup= array();
        $conditionsGroup['idHotel']= $_SESSION['idHotel'];
        $modelMerchandiseGroup = new MerchandiseGroup();
        $listMerchandiseGroup = $modelMerchandiseGroup->getPage(1, null,$conditionsGroup);

        $totalData = $modelMerchandise->find('count', array('conditions' => $conditions));

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
        setVariable('mess', $mess);
        setVariable('listMerchandiseGroup', $listMerchandiseGroup);

        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);
        
        if(isset($_GET['action']) && $_GET['action']=='Xuất Excel'){
            $table = array(
                array('label' => __('STT'), 'width' => 5),
                array('label' => __('Tên HH - DV'),'width' => 30, 'filter' => true, 'wrap' => true),
                array('label' => __('Mã HH - DV'), 'width' => 30, 'filter' => true, 'wrap' => true),
                array('label' => __('Nhóm HH - DV'),'width' => 20, 'filter' => true, 'wrap' => true),
                array('label' => __('Số lượng'), 'width' => 10, 'filter' => true),
                array('label' => __('Giá nhập'), 'width' => 10, 'filter' => true),
                array('label' => __('Giá bán'), 'width' => 10, 'filter' => true),
                array('label' => __('Ghi chú'), 'width' => 30,  'wrap' => true)
            );
            
            $data= array();
            $listDataAll= $modelMerchandise->getPage(1, null,$conditions);
            if (!empty($listDataAll)) {
                $listNameGroup= array();
                foreach ($listMerchandiseGroup as $data) {
                    $listNameGroup[$data['MerchandiseGroup']['id']]= $data['MerchandiseGroup']['name'];
                }
                
                $data= array();    
                foreach ($listDataAll as $key => $tin) {
                    $stt= $key+1;
                    $data[]= array( $stt,
                                    $tin['Merchandise']['name'],
                                    $tin['Merchandise']['code'],
                                    $listNameGroup[$tin['Merchandise']['type_merchandise']],
                                    $tin['Merchandise']['quantity'],
                                    number_format($tin['Merchandise']['priceInput']),
                                    number_format($tin['Merchandise']['price']),
                                    $tin['Merchandise']['note']
                                    );
                }
                
            }
            //debug($data);
            $exportsController = new ExportsController;
            $exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function getAjaxMerchandise($input)
{
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    $dataMerchandise= array();

    if (checkLoginManager() && $isRequestPost) {
        $modelMerchandise = new Merchandise();
        $dataSend = arrayMap($input['request']->data);
        
        if (!empty($dataSend['idNhomHangHoa'])) {
            $conditions['idHotel'] = $_SESSION['idHotel'];
            $conditions['type_merchandise'] = $dataSend['idNhomHangHoa'];
            
            $dataMerchandise = $modelMerchandise->getPage(1, null, $conditions);
        }
    }
    
    setVariable('dataMerchandise', $dataMerchandise);
}

function managerAddNumberMerchandise($input)
{
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        $modelMerchandiseGroup = new MerchandiseGroup();
        $numberProduct=1;
        $dataMerchandiseGroup = $modelMerchandiseGroup->find('all',array('conditions'=>array('idHotel'=>$_SESSION['idHotel'])));
        
        if(empty($dataMerchandiseGroup)){
            $modelOption->redirect($urlHomes.'managerAddMerchandiseGroup?redirect=managerAddMerchandise');
        }
        
        if ($isRequestPost) {
            $modelMerchandise = new Merchandise();
            $dataSend = arrayMap($input['request']->data);
            
            if(isset($dataSend['numberProduct'])){
                $numberProduct= (int) $dataSend['numberProduct'];
            }else{
                if (!empty($dataSend['idHangHoa']) && !empty($dataSend['soluong'])) {
                    foreach($dataSend['idHangHoa'] as $key=>$idHangHoa){
                        if($dataSend['soluong'][$key]>0){
                            $save= array();
                            $modelMerchandise->create();
                            
                            $save['$inc']['quantity'] = (int) $dataSend['soluong'][$key];
                            $modelMerchandise->updateAll($save, array('_id' => new MongoId($idHangHoa)));
                        }
                    }
                    
                    $modelMerchandise->redirect($urlHomes . 'managerListMerchandise?redirect=managerAddNumberMerchandise');
                }
            }
        }
        
        $today= getdate();
        
        setVariable('dataMerchandiseGroup', $dataMerchandiseGroup);
        setVariable('today', $today);
        setVariable('numberProduct', $numberProduct);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Add Merchandise
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerAddMerchandise($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        $numberProduct=10;
        $modelMerchandiseGroup = new MerchandiseGroup();
        $modelMaterialsGroup = new MaterialsGroup();
        
        $dataMaterialsGroup = $modelMaterialsGroup->find('all',array('conditions'=>array('idHotel'=>$_SESSION['idHotel'])));
        
        $listData = $modelMerchandiseGroup->find('all',array('conditions'=>array('idHotel'=>$_SESSION['idHotel'])));
        
        if(empty($listData)){
            $modelOption->redirect($urlHomes.'managerAddMerchandiseGroup?redirect=managerAddMerchandise');
        }
        
        if ($isRequestPost) {
            $modelMerchandise = new Merchandise();
            $dataSend = arrayMap($input['request']->data);

            if ($modelMerchandise->isExist($dataSend['code']) == true) {
                $mess = 'Mã hàng hóa đã tồn tại!';
                setVariable('mess', $mess);
            } else {
                $save['Merchandise']['name'] = $dataSend['name'];
                $save['Merchandise']['code'] = $dataSend['code'];
                $save['Merchandise']['type_merchandise'] = $dataSend['type_merchandise'];
                $save['Merchandise']['quantity'] = (int) $dataSend['quantity'];
                $save['Merchandise']['price'] = (int) $dataSend['price'];
                $save['Merchandise']['priceInput'] = (int) $dataSend['priceInput'];
                $save['Merchandise']['date'] = strtotime(str_replace("/", "-", $dataSend['date']) . ' 0:0:0');
                
                if (!empty($dataSend['note'])) {
                    $save['Merchandise']['note'] = $dataSend['note'];
                } else {
                    $save['Merchandise']['note'] = '';
                }
                $save['Merchandise']['idHotel'] = $_SESSION['idHotel'];
                $save['Merchandise']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
                
                $save['Merchandise']['materials']= array();
                
                if (!empty($dataSend['idHangHoa']) && !empty($dataSend['soluong'])) {
                    foreach($dataSend['idHangHoa'] as $key=>$idHangHoa){
                        if($dataSend['soluong'][$key]>0){
                            $save['Merchandise']['materials'][$idHangHoa]= (double) $dataSend['soluong'][$key];
                        }
                    }
                }

                if ($modelMerchandise->save($save)) {
                    $modelMerchandise->redirect($urlHomes . 'managerListMerchandise?status=1');
                } else {
                    $modelMerchandise->redirect($urlHomes . 'managerListMerchandise?status=-1');
                }
            }
        }
        
        $today= getdate();
        
        setVariable('listData', $listData);
        setVariable('today', $today);
        setVariable('dataMaterialsGroup', $dataMaterialsGroup);
        setVariable('numberProduct', $numberProduct);
        
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Edit Merchandise
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerEditMerchandise($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        $modelMerchandise = new Merchandise();
        $modelMaterials = new Materials();
        $modelMaterialsGroup = new MaterialsGroup();
        $dataMaterialsGroup = $modelMaterialsGroup->find('all',array('conditions'=>array('idHotel'=>$_SESSION['idHotel'])));
        
        $data = $modelMerchandise->getMerchandise($_GET['id']);
        $listMaterials= array();
        $listMaterialsGroup= array();
        $numberProduct=10;
        $today= getdate($data['Merchandise']['date']);

        $modelMerchandiseGroup = new MerchandiseGroup();
        $listMerchandiseGroup = $modelMerchandiseGroup->find('all',array('conditions' => array('idHotel'=>$_SESSION['idHotel'])));
        
        if(empty($listMerchandiseGroup)){
            $modelOption->redirect($urlHomes.'managerAddMerchandiseGroup?redirect=managerAddMerchandise');
        }
        
        if(!empty($data['Merchandise']['materials'])){
            $conditions['idHotel'] = $_SESSION['idHotel'];
            foreach($data['Merchandise']['materials'] as $idMaterials=>$value){
                $materials= $modelMaterials->getMaterials($idMaterials);
                if($materials){
                    $listMaterials[]= $materials;
                    
                    $conditions['type_materials'] = $materials['Materials']['type_materials'];
                    
                    $dataMaterials = $modelMaterials->getPage(1, null, $conditions);
                    if($dataMaterials){
                        $listMaterialsGroup[$materials['Materials']['type_materials']]= $dataMaterials;
                    }
                }
            }
        }
        
        setVariable('listMerchandiseGroup', $listMerchandiseGroup);
        setVariable('listMaterials', $listMaterials);
        setVariable('listMaterialsGroup', $listMaterialsGroup);
        setVariable('data', $data);
        setVariable('today', $today);
        setVariable('dataMaterialsGroup', $dataMaterialsGroup);
        setVariable('numberProduct', $numberProduct);

        if ($isRequestPost) {

            $dataSend = arrayMap($input['request']->data);

            if ($data['Merchandise']['code'] == $dataSend['code']) {
                $save['Merchandise']['code'] = $data['Merchandise']['code'];
                $save['Merchandise']['name'] = $dataSend['name'];
                $save['Merchandise']['type_merchandise'] = $dataSend['type_merchandise'];
                $save['Merchandise']['quantity'] = (int) $dataSend['quantity'];
                $save['Merchandise']['price'] = (int) $dataSend['price'];
                $save['Merchandise']['priceInput'] = (int) $dataSend['priceInput'];
                $save['Merchandise']['date'] = strtotime(str_replace("/", "-", $dataSend['date']) . ' 0:0:0');
                
                if (!empty($dataSend['note'])) {
                    $save['Merchandise']['note'] = $dataSend['note'];
                } else {
                    $save['Merchandise']['note'] = '';
                }
                $save['Merchandise']['idHotel'] = $data['Merchandise']['idHotel'];
                $save['Merchandise']['idManager'] = $data['Merchandise']['idManager'];
                
                $save['Merchandise']['materials']= array();
                if (!empty($dataSend['idHangHoa']) && !empty($dataSend['soluong'])) {
                    foreach($dataSend['idHangHoa'] as $key=>$idHangHoa){
                        if($dataSend['soluong'][$key]>0){
                            $save['Merchandise']['materials'][$idHangHoa]= (double) $dataSend['soluong'][$key];
                        }
                    }
                }
               
                $dk['_id'] = new MongoId($_GET['id']);

                if ($modelMerchandise->updateAll($save['Merchandise'], $dk)) {
                    $modelMerchandise->redirect($urlHomes . 'managerListMerchandise?status=3');
                } else {
                    $modelMerchandise->redirect($urlHomes . '/managerListMerchandise?status=-3');
                }
            } else {
                if ($modelMerchandise->isExist($dataSend['code']) == true) {
                    $mess = 'Mã hàng hóa '.$dataSend['code'].' đã tồn tại!';
                    setVariable('mess', $mess);
                } else {
                    $save['Merchandise']['code'] = $dataSend['code'];
                    $save['Merchandise']['name'] = $dataSend['name'];
                    $save['Merchandise']['type_mercandise'] = $dataSend['type_mercandise'];
                    $save['Merchandise']['quantity'] = (int) $dataSend['quantity'];
                    if (!empty($dataSend['note'])) {
                        $save['Merchandise']['note'] = $dataSend['note'];
                    } else {
                        $save['Merchandise']['note'] = '';
                    }
                    $save['Merchandise']['idHotel'] = $data['Merchandise']['idHotel'];
                    
                    $save['Merchandise']['materials']= array();
                    if (!empty($dataSend['idHangHoa']) && !empty($dataSend['soluong'])) {
                        foreach($dataSend['idHangHoa'] as $key=>$idHangHoa){
                            if($dataSend['soluong'][$key]>0){
                                $save['Merchandise']['materials'][$idHangHoa]= (double) $dataSend['soluong'][$key];
                            }
                        }
                    }
                    
                    $dk['_id'] = new MongoId($_GET['id']);

                    if ($modelMerchandise->updateAll($save['Merchandise'], $dk)) {
                        $modelMerchandise->redirect($urlHomes . 'managerListMerchandise?status=3');
                    } else {
                        $modelMerchandise->redirect($urlHomes . '/managerListMerchandise?status=-3');
                    }
                }
            }
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Delete Merchandise
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerDeleteMerchandise($input) {
    global $modelOption;
    global $urlHomes;


    if (checkLoginManager()) {
        $modelMerchandise = new Merchandise();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelMerchandise->delete($idDelete);
        }
        $modelMerchandise->redirect($urlHomes . 'managerListMerchandise?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function managerSellMerchandise($input)
{
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        $modelMerchandiseGroup = new MerchandiseGroup();
        $modelMerchandiseStatic = new MerchandiseStatic();
        
        $dataMerchandise = array();
        $idNhomHangHoa= '';
        $numberProduct= 1;
        $dataMerchandiseGroup = $modelMerchandiseGroup->find('all',array('conditions'=>array('idHotel'=>$_SESSION['idHotel'])));
        
        if(empty($dataMerchandiseGroup)){
            $modelOption->redirect($urlHomes.'managerAddMerchandiseGroup?redirect=managerAddMerchandise');
        }
        
        if ($isRequestPost) {
            $modelMerchandise = new Merchandise();
            $dataSend = arrayMap($input['request']->data);
            
            if(isset($dataSend['numberProduct'])){
                $numberProduct= (int) $dataSend['numberProduct'];
            }else{
                if (!empty($dataSend['idHangHoa']) && !empty($dataSend['soluong'])) {
                    $textHoaDon= array();
                    $today= getdate();
                    $priteTotal= 0;
                    
                    foreach($dataSend['idHangHoa'] as $key=>$idHangHoa){
                        if($dataSend['soluong'][$key]>0){
                            $save= array();
                            $modelMerchandise->create();
                            $modelMerchandiseStatic->create();
                            
                            $save['$inc']['quantity'] = 0 - $dataSend['soluong'][$key];
                            $modelMerchandise->updateAll($save, array('_id' => new MongoId($idHangHoa)));
                            
                            $merchandise= $modelMerchandise->getMerchandise($idHangHoa);
                            $textHoaDon[]= $merchandise['Merchandise']['name'].' số lượng '.$dataSend['soluong'][$key];
                            
                            // Luu thong ke hang hoa su dung
                            $priceMerchandise= round($dataSend['price'][$key]/$dataSend['soluong'][$key],2);
                            $saveMerchandise['MerchandiseStatic']= array('name'=>$merchandise['Merchandise']['name'],
                                                                        'price'=>$priceMerchandise,
                                                                        'number'=> (int) $dataSend['soluong'][$key],
                                                                        'code'=>$merchandise['Merchandise']['code']
                                                                        );
                            $saveMerchandise['MerchandiseStatic']['time']= $today;
                            $saveMerchandise['MerchandiseStatic']['idHotel']= $_SESSION['idHotel'];
                            $saveMerchandise['MerchandiseStatic']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
                            $saveMerchandise['MerchandiseStatic']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
                            $saveMerchandise['MerchandiseStatic']['idMerchandiseGroup'] = $dataSend['idNhomHangHoa'][$key];
                            
                            $modelMerchandiseStatic->save($saveMerchandise);
                            
                            $priteTotal+= $dataSend['price'][$key];
                        }
                    }
                    
                    // Tao phieu thu hang hoa dich vu
                    if(isset($dataSend['price']) && $dataSend['price']>0){
                        $modelCollectionBill = new CollectionBill();
                        $save = array();
                        $save['CollectionBill']['time'] = $today[0];
                        $save['CollectionBill']['coin'] = (int) $priteTotal;
                        $save['CollectionBill']['nguoi_nop'] = 'Khách lẻ';
                        $save['CollectionBill']['typeCollectionBill'] = 'tien_mat';
                        $save['CollectionBill']['nguoi_nhan'] = $_SESSION['infoManager']['Manager']['fullname'];
                        $save['CollectionBill']['note'] = 'Bán lẻ '.implode(', ',$textHoaDon);
                        $save['CollectionBill']['idHotel'] = $_SESSION['idHotel'];
                        $save['CollectionBill']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
                        $save['CollectionBill']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
                        
                        $modelCollectionBill->create();
                        $modelCollectionBill->save($save);
                    }
    
                    $modelMerchandise->redirect($urlHomes . 'managerListMerchandise?redirect=managerSellMerchandise');
                }
            }
        }
        
        $today= getdate();
        
        setVariable('numberProduct', $numberProduct);
        setVariable('dataMerchandiseGroup', $dataMerchandiseGroup);
        setVariable('today', $today);
    } else {
        $modelOption->redirect($urlHomes);
    }
}
?>