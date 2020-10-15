<?php

/**
 * List Staff
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerListStaff($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    if (checkLoginManager()) {
        $modelStaff = new Staff();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();
        if (!empty($_SESSION['idHotel'])) {
            $conditions['idHotel'] = $_SESSION['idHotel'];
        }
        $listData = $modelStaff->getPage($page, $limit, $conditions);

        $modelHotel = new Hotel();
        $listHotel = $modelHotel->getAllByManager($_SESSION['infoManager']['Manager']['id']);

        $modelPermission = new Permission();

        $listPermission = $modelPermission->getPage($page, $limit, $conditions);

        $totalData = $modelStaff->find('count', array('conditions' => $conditions));

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
        setVariable('listHotel', $listHotel);
        setVariable('listPermission', $listPermission);

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
 * Add Staff
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerAddStaff($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    $modelHotel = new Hotel();
    $modelPermission = new Permission();

    $listHotel = $modelHotel->getAllByManager($_SESSION['infoManager']['Manager']['id']);
    $listPermission = $modelPermission->find('all', array('conditions' => array('idHotel' => $_SESSION['idHotel'])));
    $listPermissionMenu = getMenuSidebarLeftManager();
    $listPermissionAdvanced = getListPermissionAdvanced();

//    if(empty($listPermission)){
//        $modelOption->redirect($urlHomes.'managerAddPermission');
//    }

    if (checkLoginManager()) {
        if ($isRequestPost) {
            $modelStaff = new Staff();
            $dataSend = arrayMap($input['request']->data);

            if ($modelStaff->isExist($dataSend['user'], $dataSend['email']) == true) {
                $mess = 'Tài khoản đã tồn tại!';
                setVariable('mess', $mess);
            } else {
                $save['Staff']['user'] = $dataSend['user'];

                $save['Staff']['fullname'] = $dataSend['fullname'];

                $save['Staff']['cmnd'] = $dataSend['cmnd'];
                $save['Staff']['date_cmnd'] = $dataSend['date_cmnd'];
                $save['Staff']['date_start'] = $dataSend['date_start'];
                $save['Staff']['birthday'] = $dataSend['birthday'];
                $save['Staff']['email'] = $dataSend['email'];
                $save['Staff']['phone'] = $dataSend['phone'];
                $save['Staff']['address'] = $dataSend['address'];
                $save['Staff']['password'] = md5($dataSend['password']);
                $save['Staff']['actived'] = (int) $dataSend['actived'];
                $save['Staff']['desc'] = $dataSend['desc'];
                $save['Staff']['permissionAdvanced'] = (isset($dataSend['permissionAdvanced']))?$dataSend['permissionAdvanced']:array();
                
                if (!empty($dataSend['listHotel'])) {
                    $save['Staff']['listHotel'] = $dataSend['listHotel'];
                } else {
                    $save['Staff']['listHotel'] = array();
                }
                if (!empty($dataSend['groupPermission'])) {
                    $save['Staff']['groupPermission'] = $dataSend['groupPermission'];
                } else {
                    $save['Staff']['groupPermission'] = array();
                }
                if (!empty($dataSend['check_list_permission'])) {
                    $save['Staff']['check_list_permission'] = $dataSend['check_list_permission'];
                } else {
                    $save['Staff']['check_list_permission'] = array();
                }
                $save['Staff']['idHotel'] = $_SESSION['idHotel'];
                $save['Staff']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
                if ($modelStaff->save($save)) {
                    $modelStaff->redirect($urlHomes . 'managerListStaff?status=1');
                } else {
                    $modelStaff->redirect($urlHomes . 'managerListStaff?status=-1');
                }
            }
        }
        setVariable('listPermission', $listPermission);
        setVariable('listPermissionMenu', $listPermissionMenu);
        setVariable('listHotel', $listHotel);
        setVariable('listPermissionAdvanced', $listPermissionAdvanced);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Edit Staff
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerEditStaff($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    $modelHotel = new Hotel();
    $listHotel = $modelHotel->getAllByManager($_SESSION['infoManager']['Manager']['id']);
    $listPermissionMenu = getMenuSidebarLeftManager();
    $listPermissionAdvanced = getListPermissionAdvanced();
    
    if (checkLoginManager()) {
        $modelStaff = new Staff();
        $data = $modelStaff->getStaff($_GET['id']);

        $modelPermission = new Permission();
        $listPermission = $modelPermission->getPage(1, null);
        if ($isRequestPost) {

            $dataSend = arrayMap($input['request']->data);

            if (!empty($dataSend['password'])) {
                $save['Staff']['password'] = md5($dataSend['password']);
            } 
            $save['Staff']['idHotel'] = $data['Staff']['idHotel'];
            $save['Staff']['idManager'] = $data['Staff']['idManager'];
            $save['Staff']['fullname'] = $dataSend['fullname'];
            $save['Staff']['cmnd'] = $dataSend['cmnd'];
            $save['Staff']['date_cmnd'] = $dataSend['date_cmnd'];
            $save['Staff']['date_start'] = $dataSend['date_start'];
            $save['Staff']['birthday'] = $dataSend['birthday'];
            $save['Staff']['email'] = $dataSend['email'];
            $save['Staff']['phone'] = $dataSend['phone'];
            $save['Staff']['address'] = $dataSend['address'];
            $save['Staff']['desc'] = $dataSend['desc'];
            $save['Staff']['actived'] = (int) $dataSend['actived'];
            $save['Staff']['permissionAdvanced'] = (isset($dataSend['permissionAdvanced']))?$dataSend['permissionAdvanced']:array();
                

            if (!empty($dataSend['listHotel'])) {
                $save['Staff']['listHotel'] = $dataSend['listHotel'];
            } else {
                $save['Staff']['listHotel'] = array();
            }
            if (!empty($dataSend['groupPermission'])) {
                $save['Staff']['groupPermission'] = $dataSend['groupPermission'];
            } else {
                $save['Staff']['groupPermission'] = array();
            }
            if (!empty($dataSend['check_list_permission'])) {
                $save['Staff']['check_list_permission'] = $dataSend['check_list_permission'];
            } else {
                $save['Staff']['check_list_permission'] = array();
            }
           
            $dk['_id'] = new MongoId($_GET['id']);

            if ($modelStaff->updateAll($save['Staff'], $dk)) {
                $modelStaff->redirect($urlHomes . 'managerListStaff?status=3');
            } else {
                $modelStaff->redirect($urlHomes . '/managerAddStaff?status=-3');
            }
        }

        setVariable('data', $data);
        setVariable('listPermission', $listPermission);
        setVariable('listPermissionMenu', $listPermissionMenu);
        setVariable('listHotel', $listHotel);
        setVariable('listPermissionAdvanced', $listPermissionAdvanced);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Delete Staff
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerDeleteStaff($input) {
    global $modelOption;
    global $urlHomes;


    if (checkLoginManager()) {
        $modelStaff = new Staff();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelStaff->delete($idDelete);
        }
        $modelStaff->redirect($urlHomes . 'managerListStaff?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

?>