<?php

/**
 * List MerchandiseGroup
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerListMerchandiseGroup($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    if (checkLoginManager()) {
        $modelMerchandiseGroup = new MerchandiseGroup();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();
        if (!empty($_SESSION['idHotel'])) {
            $conditions['idHotel'] = $_SESSION['idHotel'];
        }
        $listData = $modelMerchandiseGroup->getPage($page, $limit, $conditions);

        $totalData = $modelMerchandiseGroup->find('count', array('conditions' => $conditions));

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


/**
 * Add MerchandiseGroup
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerAddMerchandiseGroup($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        $mess= '';
        if(isset($_GET['redirect'])){
            switch($_GET['redirect']){
                case 'managerAddMerchandise': $mess= 'Bạn phải tạo nhóm hàng hóa trước khi thêm hàng hóa mới';break;
            }
        }
        
        if ($isRequestPost) {
            $modelMerchandiseGroup = new MerchandiseGroup();
            $dataSend = arrayMap($input['request']->data);
           
            $save['MerchandiseGroup']['name'] = $dataSend['name'];
            $save['MerchandiseGroup']['note'] = $dataSend['note'];
            $save['MerchandiseGroup']['idHotel'] = $_SESSION['idHotel'];
            $save['MerchandiseGroup']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
            if ($modelMerchandiseGroup->save($save)) {
                $modelMerchandiseGroup->redirect($urlHomes . 'managerListMerchandiseGroup?status=1');
            } else {
                $modelMerchandiseGroup->redirect($urlHomes . 'managerListMerchandiseGroup?status=-1');
            }
        }
        
        setVariable('mess', $mess);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Edit MerchandiseGroup
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerEditMerchandiseGroup($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        $modelMerchandiseGroup = new MerchandiseGroup();
        $data = $modelMerchandiseGroup->getMerchandiseGroup($_GET['id']);
        if ($isRequestPost) {

            $dataSend = arrayMap($input['request']->data);
            if ($data['MerchandiseGroup']['name'] == $dataSend['name']) {
                $save['MerchandiseGroup']['name'] = $data['MerchandiseGroup']['name'];
                $save['MerchandiseGroup']['note'] = $dataSend['note'];
                $save['MerchandiseGroup']['idHotel'] = $data['MerchandiseGroup']['idHotel'];
                $save['MerchandiseGroup']['idManager'] = $data['MerchandiseGroup']['idManager'];

                $dk['_id'] = new MongoId($_GET['id']);

                if ($modelMerchandiseGroup->updateAll($save['MerchandiseGroup'], $dk)) {
                    $modelMerchandiseGroup->redirect($urlHomes . 'managerListMerchandiseGroup?status=3');
                } else {
                    $modelMerchandiseGroup->redirect($urlHomes . '/managerEditMerchandiseGroup?status=-3');
                }
            } else {
                if ($modelMerchandiseGroup->isExist($dataSend['name']) == true) {
                    $mess = 'Nhóm hàng hóa "' . $dataSend['name'] . '" đã tồn tại!';
                    setVariable('mess', $mess);
                } else {
                    $save['MerchandiseGroup']['name'] = $dataSend['name'];
                    $save['MerchandiseGroup']['note'] = $dataSend['note'];

                    $dk['_id'] = new MongoId($_GET['id']);

                    if ($modelMerchandiseGroup->updateAll($save['MerchandiseGroup'], $dk)) {
                        $modelMerchandiseGroup->redirect($urlHomes . 'managerListMerchandiseGroup?status=3');
                    } else {
                        $modelMerchandiseGroup->redirect($urlHomes . '/managerEditMerchandiseGroup?status=-3');
                    }
                }
            }
        }

        setVariable('data', $data);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Delete MerchandiseGroup
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerDeleteMerchandiseGroup($input) {
    global $modelOption;
    global $urlHomes;


    if (checkLoginManager()) {
        $modelMerchandiseGroup = new MerchandiseGroup();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelMerchandiseGroup->delete($idDelete);
        }
        $modelMerchandiseGroup->redirect($urlHomes . 'managerListMerchandiseGroup?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

?>