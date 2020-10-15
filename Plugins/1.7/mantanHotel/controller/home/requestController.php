<?php

function requestHotel($input) {
    global $isRequestPost;
    global $modelOption;
    global $optionPrice;
    global $contactSite;
    global $urlHomes;
    global $smtpSite;
    global $gmpThemeSettings;

    $mess = '';
    $listCity = $modelOption->getOption('cityMantanHotel');
    $listFurniture= getListFurniture();
    $listLocation= getListLocation();
    $dataSend = arrayMap($input['request']->data);
    $modelRequest = new Request();
    $modelHotel = new Hotel();

    $city = 'Không giới hạn tỉnh thành';
    $district = 'Không giới hạn quận huyện';
    $loction = 'Không giới hạn vị trí';
    $furniture = 'Không giới hạn tiện ích';
    $priceSelect = 'Không giới hạn giá phòng';

    if ($isRequestPost && isset($dataSend['fone']) && $dataSend['fone'] != '') {
        if (isset($_SESSION['capchaCode']) && $_SESSION['capchaCode'] == $dataSend['captcha']) {
            $today = getdate();

            $save['Request']['time'] = $today[0];
            $save['Request']['email'] = (isset($dataSend['email'])) ? $dataSend['email'] : '';
            $save['Request']['fullName'] = (isset($dataSend['fullName'])) ? $dataSend['fullName'] : '';
            $save['Request']['fone'] = (isset($dataSend['fone'])) ? $dataSend['fone'] : '';
            $save['Request']['content'] = (isset($dataSend['content'])) ? $dataSend['content'] : '';
            $save['Request']['idUser'] = (isset($dataSend['idUser'])) ? $dataSend['idUser'] : '';

            $save['Request']['furniture'] = (isset($dataSend['furniture'])) ? $dataSend['furniture'] : array();
            $save['Request']['city'] = (isset($dataSend['city'])) ? (int) $dataSend['city'] : 0;
            $save['Request']['district'] = (isset($dataSend['district'])) ? (int) $dataSend['district'] : 0;
            $save['Request']['loction'] = (isset($dataSend['loction'])) ? $dataSend['loction'] : array();
            $save['Request']['price'] = (isset($dataSend['price'])) ? $dataSend['price'] : '';
            $save['Request']['dateStart'] = (isset($dataSend['dateStart'])) ? $dataSend['dateStart'] : '';
            $save['Request']['dateEnd'] = (isset($dataSend['dateEnd'])) ? $dataSend['dateEnd'] : '';

            $conditions = array();
            if ($save['Request']['city'] > 0) {
                $conditions['city'] = $save['Request']['city'];
                $city = $listCity['Option']['value']['allData'][$save['Request']['city']]['name'];
            }
            if ($save['Request']['district'] > 0) {
                $conditions['district'] = $save['Request']['district'];
                $district = $listCity['Option']['value']['allData'][$save['Request']['city']]['district'][$save['Request']['district']]['name'];
            }
            if (!empty($save['Request']['loction'])) {
                $conditions['local'] = array('$in' => $save['Request']['loction']);
                $listLoction = array();
                foreach ($save['Request']['loction'] as $idLoction) {
                    $listLoction[] = $listLocation[$idLoction]['name'];
                }
                $loction = implode(', ', $listLoction);
            }
            if (!empty($save['Request']['furniture'])) {
                foreach ($save['Request']['furniture'] as $key => $value) {
                    $save['Request']['furniture'][$key] = (int) $value;
                }
                $conditions['furniture'] = array('$in' => $save['Request']['furniture']);

                $listFurnitureSelect = array();
                foreach ($save['Request']['furniture'] as $idFurniture) {
                    $listFurnitureSelect[] = $listFurniture[$idFurniture]['name'];
                }
                $furniture = implode(', ', $listFurnitureSelect);
            }
            if ($save['Request']['price'] != '') {
                $price = explode('-', $save['Request']['price']);
                $save['Request']['priceFrom'] = (int) $price[0];
                $save['Request']['priceTo'] = (int) $price[1];
                $priceSelect = $optionPrice[$save['Request']['price']];

                $conditions['price'] = array('$gte' => $save['Request']['priceFrom'], '$lte' => $save['Request']['priceTo']);
            }

            $save['Request']['content'] = 'Tình thành: ' . $city . '<br/>Quận huyện: ' . $district . '<br/>Vị trí: ' . $loction . '<br/>Tiện ích: ' . $furniture . '<br/>Khoảng giá: ' . $priceSelect . '<br/>Ngày đến: ' . $save['Request']['dateStart'] . '<br/>Ngày đi: ' . $save['Request']['dateEnd'] . '<br/>Nội dung: ' . nl2br($save['Request']['content']);
            $modelRequest->save($save);
            $mess = '<span class="glyphicon glyphicon-ok"></span> Gửi yêu cầu thành công';
            $idRequest = $modelRequest->getLastInsertId();

            $listHotel = $modelHotel->getPage(1, null, $conditions, null, array('email'));
            
            if ($listHotel) {
                // send email for user and admin
                $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);

                $to = array();

                foreach ($listHotel as $hotel) {
                    if(!empty($hotel['Hotel']['email'])){
                        $to[] = $hotel['Hotel']['email'];
                    }
                }


                if (filter_var($contactSite['Option']['value']['email'], FILTER_VALIDATE_EMAIL)) {
                    $to[] = $contactSite['Option']['value']['email'];
                }

                if(!empty($dataSend['email'])){
                    $to[]=$dataSend['email'];
                }
                
                $to = array_unique($to);

                $cc = array();
                $bcc = array();
                $subject = '[' . $smtpSite['Option']['value']['show'] . ']'.$gmpThemeSettings['Option']['value']['titleEmailCustomRequest'];

                $link = $urlHomes . 'managerProcessRequest?id=' . $idRequest;

                $content = '<b>Thông tin khách hàng yêu cầu</b><br/>' . $save['Request']['content'] . '<br/><br/>'.$gmpThemeSettings['Option']['value']['textEmailCustomRequest'].' <a href="' . $link . '">' . $link . '</a>';

                $modelRequest->sendMail($from, $to, $cc, $bcc, $subject, $content);
            }
        } else {
            $mess = '<span class="glyphicon glyphicon-remove"></span> Nhập sai mã xác thực';
        }
    }

    $cap_code = rand(100000, 999999);
    $_SESSION['capchaCode'] = $cap_code;

    setVariable('mess', $mess);
    setVariable('capchaCode', $cap_code);
    setVariable('listCity', $listCity);
    setVariable('listFurniture', $listFurniture);
    setVariable('listLocation', $listLocation);

}

function requestHistory() {
    global $isRequestPost;
    global $urlHomes;
    global $urlNow;
    $modelRequest = new Request();

    if (!empty($_SESSION['infoUser'])) {
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions['idUser'] = $_SESSION['infoUser']['User']['id'];

        $listData = $modelRequest->getPage($page, $limit, $conditions);

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
    } else {
        $modelRequest->redirect($urlHomes);
    }
}

function requestDetail() {
    global $urlHomes;
    $modelRequest = new Request();
    

    if (!empty($_SESSION['infoUser'])) {
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

?>