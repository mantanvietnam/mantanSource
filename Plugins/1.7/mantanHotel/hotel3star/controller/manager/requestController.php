<?php

function managerListRequest($input) {
    global $isRequestPost;
    global $urlHomes;
    global $isRequestPost;
    global $urlNow;

    $modelRequest = new Request();

    if (checkLoginManager()) {
        $mess = '';
        if (isset($_GET['status'])) {
            switch ($_GET['status']) {
                case 1: $mess = 'Gửi báo giá thành công';
                break;
            }
        }

        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $order['created'] = 'desc';
        if (!empty($_GET['type_oder']) && $_GET['type_oder'] != 'empty') {
            if ($_GET['type_oder'] == 'chuaXuLy') {
                $order['hotelProcess'] = 'asc';
            } elseif ($_GET['type_oder'] == 'daXuLy') {
                $order['hotelProcess'] = 'desc';
                
            }elseif ($_GET['type_oder'] == 'moiNhat') {
                $order['created'] = 'desc';
            }elseif ($_GET['type_oder'] == 'cuNhat') {
                $order['created'] = 'asc';
            }
        }else{
            $order['hotelProcess'] = 'desc';
        }
        $conditions = array();
        $listData = $modelRequest->getPage($page, $limit, $conditions,$order);

        $totalData = $modelRequest->find('count', array('conditions' => $conditions));
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


        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);

        setVariable('listData', $listData);
        setVariable('mess', $mess);
    } else {
        $modelRequest->redirect($urlHomes);
    }
}


function managerProcessRequest($input) {
    global $isRequestPost;
    global $modelOption;
    global $urlHomes;
    global $gmpThemeSettings;

    $modelRequest = new Request();
    $contactSite = $modelOption->getOption('contact');
    $smtpSite = $modelOption->getOption('smtpSetting');

    if (checkLoginManager()) {
        $data = $modelRequest->getRequest($_GET['id']);

        
        if ($data) {
            $time_start = getdate($data['Request']['time']);

            setVariable('data', $data);
            setVariable('time_start', $time_start);

            if ($isRequestPost) {
                $modelHotel = new Hotel();
                $price = (int) $_POST['price'];
                $contentRequest = $_POST['contentRequest'];
                $save['$set']['hotelProcess.' . $_SESSION['idHotel'].'.price'] = $price;
                $save['$set']['hotelProcess.' . $_SESSION['idHotel'].'.contentRequest'] = $contentRequest;
                $idRequest = new MongoId($data['Request']['id']);
                $hotel = $modelHotel->getHotel($_SESSION['idHotel']);
                
                if ($modelRequest->updateAll($save, array('_id' => $idRequest))) {

                    // send email for user and admin
                    $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                    $to = array(trim($contactSite['Option']['value']['email']));
                    if(!empty($data['Request']['email'])) $to[]= $data['Request']['email'];
                    $cc = array();
                    $bcc = array();
                    $subject = '[' . $smtpSite['Option']['value']['show'] . '] ' . $gmpThemeSettings['Option']['value']['titleEmailManagerRequest'];

                    
                    if (function_exists('getLinkHotelDetail')) {
                        $urlHotel = getLinkHotelDetail($hotel);
                    }else{
                        $urlHotel = $urlHomes;
                    }

                    // create content email
                    $content = '<a href="'.$urlHotel.'">Khách sạn '.$hotel['Hotel']['name'].'</a>,<br>';
                    $content.= 'Xin chào '. $data['Request']['fullName'] . '! '.$gmpThemeSettings['Option']['value']['textEmailManagerRequest'].' <br>'.$data['Request']['content'].' <br><br>';
                    $content.= 'Khách sạn '.$hotel['Hotel']['name'].': ';
                    $content.= '<a href="'.$urlHotel.'">'.  $urlHotel.'</a><br/>';
                    $content.= 'Báo giá: '.  number_format($_POST['price']). ' VNĐ <br>';
                   
                    $content.= 'Nội dung báo giá: '. $contentRequest;
                    $modelRequest->sendMail($from, $to, $cc, $bcc, $subject, $content);
                }

                
                $modelRequest->redirect($urlHomes . 'managerListRequest?status=1');
            }
        } else {
            $modelRequest->redirect($urlHomes);
        }
    } else {
        $modelRequest->redirect($urlHomes);
    }
}
function managerViewProcessRequest() {
    global $urlHomes;

    $modelRequest = new Request();
    
    if (checkLoginManager()) {
        $data = $modelRequest->getRequest($_GET['id']);

        if ($data) {

            setVariable('data', $data);

        } else {
            $modelRequest->redirect($urlHomes);
        }
    } else {
        $modelRequest->redirect($urlHomes);
    }
}
function managerDeleteRequest($input) {
    global $urlHomes;
    $modelRequest = new Request();

    if (checkLoginManager()) {
        $idDelete = new MongoId($_GET['id']);

        $modelRequest->delete($idDelete);
        $modelRequest->redirect($urlHomes . 'managerListRequest?status=4');
    } else {
        $modelRequest->redirect($urlHomes);
    }
}

?>