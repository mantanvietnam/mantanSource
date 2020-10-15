<?php

function managerListMaterialsGroup($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    if (checkLoginManager()) {
        $modelMaterialsGroup = new MaterialsGroup();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();
        if (!empty($_SESSION['idHotel'])) {
            $conditions['idHotel'] = $_SESSION['idHotel'];
        }
        $listData = $modelMaterialsGroup->getPage($page, $limit, $conditions);

        $totalData = $modelMaterialsGroup->find('count', array('conditions' => $conditions));

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

//        pr($listData);die;
        setVariable('listData', $listData);

        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);
    } else {
        $modelOption->redirect($urlHomes);
    }
}


function managerAddMaterialsGroup($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        $mess= '';
        if(isset($_GET['redirect'])){
            switch($_GET['redirect']){
                case 'managerAddMaterials': $mess= 'Bạn phải tạo nhóm nguyên liệu trước khi thêm nguyên liệu mới';break;
            }
        }
        
        if ($isRequestPost) {
            $modelMaterialsGroup = new MaterialsGroup();
            $dataSend = arrayMap($input['request']->data);
           
            $save['MaterialsGroup']['name'] = $dataSend['name'];
            $save['MaterialsGroup']['note'] = $dataSend['note'];
            $save['MaterialsGroup']['idHotel'] = $_SESSION['idHotel'];
            $save['MaterialsGroup']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
            if ($modelMaterialsGroup->save($save)) {
                $modelMaterialsGroup->redirect($urlHomes . 'managerListMaterialsGroup?status=1');
            } else {
                $modelMaterialsGroup->redirect($urlHomes . 'managerListMaterialsGroup?status=-1');
            }
        }
        
        setVariable('mess', $mess);
    } else {
        $modelOption->redirect($urlHomes);
    }
}


function managerEditMaterialsGroup($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        $modelMaterialsGroup = new MaterialsGroup();
        $data = $modelMaterialsGroup->getMaterialsGroup($_GET['id']);
        if ($isRequestPost) {

            $dataSend = arrayMap($input['request']->data);
            if ($data['MaterialsGroup']['name'] == $dataSend['name']) {
                $save['MaterialsGroup']['name'] = $data['MaterialsGroup']['name'];
                $save['MaterialsGroup']['note'] = $dataSend['note'];
                $save['MaterialsGroup']['idHotel'] = $data['MaterialsGroup']['idHotel'];
                $save['MaterialsGroup']['idManager'] = $data['MaterialsGroup']['idManager'];

                $dk['_id'] = new MongoId($_GET['id']);

                if ($modelMaterialsGroup->updateAll($save['MaterialsGroup'], $dk)) {
                    $modelMaterialsGroup->redirect($urlHomes . 'managerListMaterialsGroup?status=3');
                } else {
                    $modelMaterialsGroup->redirect($urlHomes . '/managerEditMaterialsGroup?status=-3');
                }
            } else {
                if ($modelMaterialsGroup->isExist($dataSend['name']) == true) {
                    $mess = 'Nhóm hàng hóa "' . $dataSend['name'] . '" đã tồn tại!';
                    setVariable('mess', $mess);
                } else {
                    $save['MaterialsGroup']['name'] = $dataSend['name'];
                    $save['MaterialsGroup']['note'] = $dataSend['note'];

                    $dk['_id'] = new MongoId($_GET['id']);

                    if ($modelMaterialsGroup->updateAll($save['MaterialsGroup'], $dk)) {
                        $modelMaterialsGroup->redirect($urlHomes . 'managerListMaterialsGroup?status=3');
                    } else {
                        $modelMaterialsGroup->redirect($urlHomes . '/managerEditMaterialsGroup?status=-3');
                    }
                }
            }
        }

        setVariable('data', $data);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function managerDeleteMaterialsGroup($input) {
    global $modelOption;
    global $urlHomes;


    if (checkLoginManager()) {
        $modelMaterialsGroup = new MaterialsGroup();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelMaterialsGroup->delete($idDelete);
        }
        $modelMaterialsGroup->redirect($urlHomes . 'managerListMaterialsGroup?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

?>