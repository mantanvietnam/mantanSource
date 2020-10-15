<?php
function managerListHoliday($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    if (checkLoginManager()) {
        $modelHoliday = new Holiday();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();
        if(!empty($_SESSION['idHotel'])){
            $conditions['idHotel']= $_SESSION['idHotel'];
        }
        $listData = $modelHoliday->getPage($page, $limit,$conditions);

        $totalData = $modelHoliday->find('count', array('conditions' => $conditions));

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
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function managerAddHoliday($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    if (checkLoginManager()) 
    {
        if ($isRequestPost) 
        {
            $modelHoliday = new Holiday();
            $dataSend = arrayMap($input['request']->data);
            $dateTimeStart=strtotime(str_replace("/", "-",$dataSend['date_start']).' '.$dataSend['time_start']);
            $dateTimeEnd=strtotime(str_replace("/", "-",$dataSend['date_end']).' '.$dataSend['time_end']);
            if ($dateTimeEnd < $dateTimeStart) 
            {
                $mess = 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc! Mời nhập lại!';
                setVariable('mess', $mess);
            }
            else
            {
                $save['Holiday']['name'] = $dataSend['name'];
                $save['Holiday']['dateTimeStart'] = $dateTimeStart;
                $save['Holiday']['dateTimeEnd'] = $dateTimeEnd;
                $save['Holiday']['describe'] = $dataSend['describe'];
                $save['Holiday']['idHotel'] = $_SESSION['idHotel'];

                if ($modelHoliday->save($save)) {
                    $modelHoliday->redirect($urlHomes . 'managerListHoliday?status=1');
                } else {
                    $modelHoliday->redirect($urlHomes . 'managerListHoliday?status=-1');
                }
            }
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function managerEditHoliday($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        $modelHoliday = new Holiday();
        $data = $modelHoliday->getHoliday($_GET['id']);
        if ($isRequestPost) {
            $dataSend = arrayMap($input['request']->data);
            $dateTimeStart=strtotime(str_replace("/", "-",$dataSend['date_start']).' '.$dataSend['time_start']);
            $dateTimeEnd=strtotime(str_replace("/", "-",$dataSend['date_end']).' '.$dataSend['time_end']);
            if ($dateTimeEnd < $dateTimeStart) {
                $mess = 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc! Moi nhap lai!';
                setVariable('mess', $mess);
            }
            else
            {
                $save['Holiday']['name'] = $dataSend['name'];
                $save['Holiday']['dateTimeStart'] = $dateTimeStart;
                $save['Holiday']['dateTimeEnd'] = $dateTimeEnd;
                $save['Holiday']['describe'] = $dataSend['describe'];
                $save['Holiday']['idHotel'] = $data['Holiday']['idHotel'];

                $dk['_id'] = new MongoId($_GET['id']);

                if ($modelHoliday->updateAll($save['Holiday'], $dk)) {
                    $modelHoliday->redirect($urlHomes . 'managerListHoliday?status=3');
                } else {
                    $modelHoliday->redirect($urlHomes . '/managerAddHoliday?status=-3');
                }
            }
        }

        setVariable('data', $data);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function managerDeleteHoliday($input) {
    global $modelOption;
    global $urlHomes;
    if (checkLoginManager()) {
        $modelHoliday = new Holiday();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelHoliday->delete($idDelete);
        }
        $modelHoliday->redirect($urlHomes . 'managerListHoliday?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

?>