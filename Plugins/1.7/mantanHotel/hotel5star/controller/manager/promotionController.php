<?php

/**
 * List Promotion
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerListPromotion($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    if (checkLoginManager()) {
        $modelPromotion = new Promotion();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();
        if (!empty($_SESSION['idHotel'])) {
            $conditions['idHotel'] = $_SESSION['idHotel'];
        }
        $listData = $modelPromotion->getPage($page, $limit, $conditions);
        
        $modelTypeRoom = new TypeRoom();
        $listTypeRoom = $modelTypeRoom->getPage($page, $limit, $conditions);
        $arrayTypeRoom=array();
        foreach ($listTypeRoom as $value) {
            $arrayTypeRoom[$value['TypeRoom']['id']]=$value['TypeRoom']['roomtype'];
        }

        $totalData = $modelPromotion->find('count', array('conditions' => $conditions));

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
        setVariable('listTypeRoom', $arrayTypeRoom);

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
 * Add Promotion
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerAddPromotion($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        $mess= '';
        if ($isRequestPost) {
            $modelPromotion = new Promotion();
            $dataSend = arrayMap($input['request']->data);
            
            $time_start= strtotime(str_replace("/", "-", $dataSend['date_start']) . ' ' . $dataSend['time_start']);
            $time_end= strtotime(str_replace("/", "-", $dataSend['date_end']) . ' ' . $dataSend['time_end']);
            
            if ($time_end < $time_start) {
                $mess = 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu. Xin mời nhập lại!';
            } else {
                $save['Promotion']['time_start'] = (int) $time_start;
                $save['Promotion']['time_end'] = (int) $time_end;
               
                $save['Promotion']['type_room'] = $dataSend['type_room'];
                $save['Promotion']['promotion_value'] = $dataSend['promotion_value'];
                $save['Promotion']['content'] = $dataSend['content'];
                $save['Promotion']['idHotel'] = $_SESSION['idHotel'];
                $save['Promotion']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
                if ($modelPromotion->save($save)) {
                    $modelPromotion->redirect($urlHomes . 'managerListPromotion?status=1');
                } else {
                    $modelPromotion->redirect($urlHomes . 'managerListPromotion?status=-1');
                }
            }
        }
        
        $modelTypeRoom = new TypeRoom();
        $listTypeRoom = $modelTypeRoom->getAllTypeRoomHotel($_SESSION['idHotel']);
        
        setVariable('listTypeRoom', $listTypeRoom);
        setVariable('mess', $mess);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Edit Promotion
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerEditPromotion($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        $modelPromotion = new Promotion();
        $save = $modelPromotion->getPromotion($_GET['id']);
        
        if($save){
            if ($isRequestPost) {
                $modelPromotion = new Promotion();
                $dataSend = arrayMap($input['request']->data);
                $mess= '';
                
                $time_start= strtotime(str_replace("/", "-", $dataSend['date_start']) . ' ' . $dataSend['time_start']);
                $time_end= strtotime(str_replace("/", "-", $dataSend['date_end']) . ' ' . $dataSend['time_end']);
                
                if ($time_end < $time_start) {
                    $mess = 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu. Xin mời nhập lại!';
                } else {
                    $save['Promotion']['time_start'] = (int)  $time_start;
                    $save['Promotion']['time_end'] = (int)$time_end;
                   
                    $save['Promotion']['type_room'] = $dataSend['type_room'];
                    $save['Promotion']['promotion_value'] = $dataSend['promotion_value'];
                    $save['Promotion']['content'] = $dataSend['content'];
                    if ($modelPromotion->save($save)) {
                        $modelPromotion->redirect($urlHomes . 'managerListPromotion?status=1');
                    } else {
                        $modelPromotion->redirect($urlHomes . 'managerListPromotion?status=-1');
                    }
                }
            }
            
            $modelTypeRoom = new TypeRoom();
            $listTypeRoom = $modelTypeRoom->getAllTypeRoomHotel($_SESSION['idHotel']);
            
            $time_start= getdate($save['Promotion']['time_start']);
            $time_end= getdate($save['Promotion']['time_end']);
                            
            setVariable('listTypeRoom', $listTypeRoom);
            setVariable('data', $save);
            setVariable('time_start', $time_start);
            setVariable('time_end', $time_end);
        }else{
            $modelOption->redirect($urlHomes.'managerListPromotion');
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Delete Promotion
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerDeletePromotion($input) {
    global $modelOption;
    global $urlHomes;


    if (checkLoginManager()) {
        $modelPromotion = new Promotion();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelPromotion->delete($idDelete);
        }
        $modelPromotion->redirect($urlHomes . 'managerListPromotion?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

?>