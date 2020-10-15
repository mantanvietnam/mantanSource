<?php

/**
 * List Materials
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerListMaterials($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    if (checkLoginManager()) {
        $mess= '';
        if(isset($_GET['redirect'])){
            switch($_GET['redirect']){
                case 'managerAddNumberMaterials': $mess= '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Thêm số lượng Nguyên liệu thành công!</p>';break;
                case 'managerSellMaterials': $mess= '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Bán lẻ Nguyên liệu thành công!</p>';break;
            }
        }
        
        if (isset($_GET['status'])) {
            switch ($_GET['status']) {
                case 1: $mess= '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Thêm Nguyên liệu thành công!</p>';
                    break;
                case -1: $mess= '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Thêm Nguyên liệu không thành công!</p>';
                    break;
                case 3: $mess= '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Sửa Nguyên liệu thành công!</p>';
                    break;
                case -3: $mess= '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Sửa Nguyên liệu không thành công!</p>';
                    break;
                case 4: $mess= '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Xóa Nguyên liệu thành công!</p>';
                    break;
            }
        }
        
        $modelMaterials = new Materials();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();
        if(!empty($_SESSION['idHotel'])){
            $conditions['idHotel']= $_SESSION['idHotel'];
        }
        
        if(!empty($_GET['idNhomHangHoa'])){
            $conditions['type_materials']= $_GET['idNhomHangHoa'];
        }
        
        if(!empty($_GET['code'])){
            $conditions['code']= $_GET['code'];
        }
        
        $listData = $modelMaterials->getPage($page, $limit,$conditions);
        
        $conditionsGroup= array();
        $conditionsGroup['idHotel']= $_SESSION['idHotel'];
        $modelMaterialsGroup = new MaterialsGroup();
        $listMaterialsGroup = $modelMaterialsGroup->getPage(1, null,$conditionsGroup);

        $totalData = $modelMaterials->find('count', array('conditions' => $conditions));

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
        setVariable('listMaterialsGroup', $listMaterialsGroup);

        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);
        
        if(isset($_GET['action']) && $_GET['action']=='Xuất Excel'){
            $table = array(
                array('label' => __('STT'), 'width' => 5),
                array('label' => __('Tên nguyên liệu'),'width' => 30, 'filter' => true, 'wrap' => true),
                array('label' => __('Mã nguyên liệu'), 'width' => 30, 'filter' => true, 'wrap' => true),
                array('label' => __('Nhóm nguyên liệu'),'width' => 20, 'filter' => true, 'wrap' => true),
                array('label' => __('Số lượng'), 'width' => 10, 'filter' => true),
                array('label' => __('Giá nhập'), 'width' => 10, 'filter' => true),
                array('label' => __('Ghi chú'), 'width' => 30,  'wrap' => true)
            );
            
            $data= array();
            $listDataAll= $modelMaterials->getPage(1, null,$conditions);
            if (!empty($listDataAll)) {
                $listNameGroup= array();
                foreach ($listMaterialsGroup as $data) {
                    $listNameGroup[$data['MaterialsGroup']['id']]= $data['MaterialsGroup']['name'];
                }
                
                $data= array();    
                foreach ($listDataAll as $key => $tin) {
                    $stt= $key+1;
                    $data[]= array( $stt,
                                    $tin['Materials']['name'],
                                    $tin['Materials']['code'],
                                    $listNameGroup[$tin['Materials']['type_materials']],
                                    $tin['Materials']['quantity'],
                                    number_format($tin['Materials']['priceInput']),
                                    $tin['Materials']['note']
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

function getAjaxMaterials($input)
{
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    $dataMaterials= array();

    if (checkLoginManager() && $isRequestPost) {
        $modelMaterials = new Materials();
        $dataSend = arrayMap($input['request']->data);
        
        if (!empty($dataSend['idNhomHangHoa'])) {
            $conditions['idHotel'] = $_SESSION['idHotel'];
            $conditions['type_materials'] = $dataSend['idNhomHangHoa'];
            
            $dataMaterials = $modelMaterials->getPage(1, null, $conditions);
        }
    }
    
    setVariable('dataMaterials', $dataMaterials);
}

function managerAddNumberMaterials($input)
{
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        $modelMaterialsGroup = new MaterialsGroup();
        $numberProduct=1;
        $dataMaterialsGroup = $modelMaterialsGroup->find('all',array('conditions'=>array('idHotel'=>$_SESSION['idHotel'])));
        
        if(empty($dataMaterialsGroup)){
            $modelOption->redirect($urlHomes.'managerAddMaterialsGroup?redirect=managerAddMaterials');
        }
        
        if ($isRequestPost) {
            $modelMaterials = new Materials();
            $dataSend = arrayMap($input['request']->data);
            
            if(isset($dataSend['numberProduct'])){
                $numberProduct= (int) $dataSend['numberProduct'];
            }else{
                if (!empty($dataSend['idHangHoa']) && !empty($dataSend['soluong'])) {
                    foreach($dataSend['idHangHoa'] as $key=>$idHangHoa){
                        if($dataSend['soluong'][$key]>0){
                            $save= array();
                            $modelMaterials->create();
                            
                            $save['$inc']['quantity'] = (int) $dataSend['soluong'][$key];
                            $modelMaterials->updateAll($save, array('_id' => new MongoId($idHangHoa)));
                        }
                    }
                    
                    $modelMaterials->redirect($urlHomes . 'managerListMaterials?redirect=managerAddNumberMaterials');
                }
            }
        }
        
        $today= getdate();
        
        setVariable('dataMaterialsGroup', $dataMaterialsGroup);
        setVariable('today', $today);
        setVariable('numberProduct', $numberProduct);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Add Materials
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerAddMaterials($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        $modelMaterialsGroup = new MaterialsGroup();

        $listData = $modelMaterialsGroup->find('all',array('conditions'=>array('idHotel'=>$_SESSION['idHotel'])));
        
        if(empty($listData)){
            $modelOption->redirect($urlHomes.'managerAddMaterialsGroup?redirect=managerAddMaterials');
        }
        
        if ($isRequestPost) {
            $modelMaterials = new Materials();
            $dataSend = arrayMap($input['request']->data);

            if ($modelMaterials->isExist($dataSend['code']) == true) {
                $mess = 'Mã Nguyên liệu đã tồn tại!';
                setVariable('mess', $mess);
            } else {
                $save['Materials']['name'] = $dataSend['name'];
                $save['Materials']['code'] = $dataSend['code'];
                $save['Materials']['type_materials'] = $dataSend['type_materials'];
                $save['Materials']['quantity'] = (int) $dataSend['quantity'];
                $save['Materials']['priceInput'] = (int) $dataSend['priceInput'];
                $save['Materials']['date'] = strtotime(str_replace("/", "-", $dataSend['date']) . ' 0:0:0');
                
                if (!empty($dataSend['note'])) {
                    $save['Materials']['note'] = $dataSend['note'];
                } else {
                    $save['Materials']['note'] = '';
                }
                $save['Materials']['idHotel'] = $_SESSION['idHotel'];
                $save['Materials']['idManager'] = $_SESSION['infoManager']['Manager']['id'];

                if ($modelMaterials->save($save)) {
                    $modelMaterials->redirect($urlHomes . 'managerListMaterials?status=1');
                } else {
                    $modelMaterials->redirect($urlHomes . 'managerListMaterials?status=-1');
                }
            }
        }
        
        $today= getdate();
        
        setVariable('listData', $listData);
        setVariable('today', $today);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Edit Materials
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerEditMaterials($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        $modelMaterials = new Materials();
        $data = $modelMaterials->getMaterials($_GET['id']);
        
        $today= getdate($data['Materials']['date']);

        $modelMaterialsGroup = new MaterialsGroup();
        $listMaterialsGroup = $modelMaterialsGroup->find('all',array('conditions' => array('idHotel'=>$_SESSION['idHotel'])));
        
        if(empty($listMaterialsGroup)){
            $modelOption->redirect($urlHomes.'managerAddMaterialsGroup?redirect=managerAddMaterials');
        }
        
        setVariable('listMaterialsGroup', $listMaterialsGroup);
        setVariable('data', $data);
        setVariable('today', $today);

        if ($isRequestPost) {

            $dataSend = arrayMap($input['request']->data);

            if ($data['Materials']['code'] == $dataSend['code']) {
                $save['Materials']['code'] = $data['Materials']['code'];
                $save['Materials']['name'] = $dataSend['name'];
                $save['Materials']['type_materials'] = $dataSend['type_materials'];
                $save['Materials']['quantity'] = (int) $dataSend['quantity'];
                $save['Materials']['priceInput'] = (int) $dataSend['priceInput'];
                $save['Materials']['date'] = strtotime(str_replace("/", "-", $dataSend['date']) . ' 0:0:0');
                
                if (!empty($dataSend['note'])) {
                    $save['Materials']['note'] = $dataSend['note'];
                } else {
                    $save['Materials']['note'] = '';
                }
                $save['Materials']['idHotel'] = $data['Materials']['idHotel'];
                $save['Materials']['idManager'] = $data['Materials']['idManager'];
               
               
                $dk['_id'] = new MongoId($_GET['id']);

                if ($modelMaterials->updateAll($save['Materials'], $dk)) {
                    $modelMaterials->redirect($urlHomes . 'managerListMaterials?status=3');
                } else {
                    $modelMaterials->redirect($urlHomes . '/managerListMaterials?status=-3');
                }
            } else {
                if ($modelMaterials->isExist($dataSend['code']) == true) {
                    $mess = 'Mã Nguyên liệu '.$dataSend['code'].' đã tồn tại!';
                    setVariable('mess', $mess);
                } else {
                    $save['Materials']['code'] = $dataSend['code'];
                    $save['Materials']['name'] = $dataSend['name'];
                    $save['Materials']['type_materials'] = $dataSend['type_materials'];
                    $save['Materials']['quantity'] = (int) $dataSend['quantity'];
                    if (!empty($dataSend['note'])) {
                        $save['Materials']['note'] = $dataSend['note'];
                    } else {
                        $save['Materials']['note'] = '';
                    }
                    $save['Materials']['idHotel'] = $data['Materials']['idHotel'];
                    $dk['_id'] = new MongoId($_GET['id']);

                    if ($modelMaterials->updateAll($save['Materials'], $dk)) {
                        $modelMaterials->redirect($urlHomes . 'managerListMaterials?status=3');
                    } else {
                        $modelMaterials->redirect($urlHomes . '/managerListMaterials?status=-3');
                    }
                }
            }
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Delete Materials
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerDeleteMaterials($input) {
    global $modelOption;
    global $urlHomes;


    if (checkLoginManager()) {
        $modelMaterials = new Materials();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelMaterials->delete($idDelete);
        }
        $modelMaterials->redirect($urlHomes . 'managerListMaterials?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

?>