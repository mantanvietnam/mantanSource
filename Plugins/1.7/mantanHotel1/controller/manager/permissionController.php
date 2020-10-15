<?php

/**
 * List Permission
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerListPermission($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    if (checkLoginManager()) {
        $modelPermission = new Permission();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();
        if (!empty($_SESSION['idHotel'])) {
            $conditions['idHotel'] = $_SESSION['idHotel'];
        }
        $listData = $modelPermission->getPage($page, $limit, $conditions);

        $totalData = $modelPermission->find('count', array('conditions' => $conditions));

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
 * Add Permission
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerAddPermission($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        if ($isRequestPost) {
            $modelPermission = new Permission();
            $dataSend = arrayMap($input['request']->data);
            
            $save['Permission']['name'] = $dataSend['name'];
            $save['Permission']['note'] = $dataSend['note'];
            $save['Permission']['idHotel'] = $_SESSION['idHotel'];
            $save['Permission']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
            if ($modelPermission->save($save)) {
                $modelPermission->redirect($urlHomes . 'managerListPermission?status=1');
            } else {
                $modelPermission->redirect($urlHomes . 'managerListPermission?status=-1');
            }
            
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Edit Permission
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerEditPermission($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        $modelPermission = new Permission();
        $permission = $modelPermission->getPermission($_GET['id']);
        if ($isRequestPost) {

            $dataSend = arrayMap($input['request']->data);
            
            $dk['_id'] = new MongoId($_GET['id']);
            $save['note'] = $dataSend['note'];
            $save['name'] = $dataSend['name'];
            if ($modelPermission->updateAll($save, $dk)) {
                $modelPermission->redirect($urlHomes . 'managerListPermission?status=3');
            } else {
                $modelPermission->redirect($urlHomes . '/managerEditPermission?status=-3');
            }
            
        }

        setVariable('permission', $permission);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Delete Permission
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerDeletePermission($input) {
    global $modelOption;
    global $urlHomes;


    if (checkLoginManager()) {
        $modelPermission = new Permission();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelPermission->delete($idDelete);
        }
        $modelPermission->redirect($urlHomes . 'managerListPermission?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

?>