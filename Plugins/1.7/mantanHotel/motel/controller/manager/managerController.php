<?php

// Duong dan trang chu
global $urlHomeManager;
global $urlHomes;
$urlHomeManager = $urlHomes . 'homeManager';

function managerUserProfile($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        if ($_SESSION['infoManager']['Manager']['isStaff'] != 1) {
            $modelManager = new Manager();
            $data = $modelManager->getManager($_SESSION['infoManager']['Manager']['id']);
            
            if ($isRequestPost) {

                $dataSend = arrayMap($input['request']->data);

                if (!empty($dataSend['password'])) {
                    $save['Manager']['password'] = md5($dataSend['password']);
                }

                $save['Manager']['user'] = $dataSend['user'];
                $save['Manager']['fullname'] = $dataSend['fullname'];
                $save['Manager']['avatar'] = $_SESSION['infoManager']['Manager']['avatar'] = $dataSend['avatar'];
                $save['Manager']['email'] = $dataSend['email'];
                $save['Manager']['phone'] = $dataSend['phone'];
                $save['Manager']['address'] = $dataSend['address'];
                if (!empty($dataSend['desc'])) {
                    $save['Manager']['desc'] = $dataSend['desc'];
                }

                $dk['_id'] = new MongoId($_SESSION['infoManager']['Manager']['id']);

                if ($modelManager->updateAll($save['Manager'], $dk)) {
                    $modelManager->redirect($urlHomes . 'managerUserProfile?status=3');
                } else {
                    $modelManager->redirect($urlHomes . 'managerUserProfile?status=-3');
                }
            }
        } else {

            $modelStaff = new Staff();
            $dataStaff = $modelStaff->getStaff($_SESSION['infoManager']['Manager']['idStaff']);
            $data['Manager'] = $dataStaff['Staff'];
            if ($isRequestPost) {

                $dataSend = arrayMap($input['request']->data);

                if (!empty($dataSend['password'])) {
                    $save['Staff']['password'] = md5($dataSend['password']);
                }
                $save['Staff']['fullname'] = $dataSend['fullname'];
                $save['Staff']['email'] = $dataSend['email'];
                $save['Staff']['phone'] = $dataSend['phone'];
                $save['Staff']['address'] = $dataSend['address'];
                if (!empty($dataSend['desc'])) {
                    $save['Staff']['desc'] = $dataSend['desc'];
                }

                $dk['_id'] = new MongoId($_SESSION['infoManager']['Manager']['idStaff']);

                if ($modelStaff->updateAll($save['Staff'], $dk)) {
                    $modelStaff->redirect($urlHomes . 'managerUserProfile?status=3');
                } else {
                    $modelManager->redirect($urlHomes . 'managerUserProfile?status=-3');
                }
            }
        }


        setVariable('data', $data);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

// Trang chu manager
function homeManager() {
    global $urlHomes;
    $modelManager = new Manager();
    if (checkLoginManager()) {
        $modelHotel = new Hotel();
        $modelRoom = new Room();
        $modelOrder = new Order();
        $modelRevenue = new Revenue();
        $modelRequest = new Request();
        $modelReport = new Report();

        $today = getdate();

        $hotel = $modelHotel->getHotel($_SESSION['idHotel']);

        $conditions['idHotel'] = $_SESSION['idHotel'];
        $conditions['status'] = 0;
        $countOrder = $modelOrder->find('count', array('conditions' => $conditions));

        $revenue = $modelRevenue->getRevenue($_SESSION['idHotel']);

        for ($i = 1; $i <= 12; $i++) {
            if (!isset($revenue['Revenue'][$today['year']][$i])) {
                $revenue['Revenue'][$today['year']][$i] = 0;
            }
        }

        $countRequest = $modelRequest->getCountRequestWithHotel($hotel);
        $countReport= $modelReport->getCountReport('new',$_SESSION['idHotel']);
        $countDeadlineCheckout= count($modelRoom->getRoomDeadlineCheckout($_SESSION['idHotel']));

        setVariable('countDeadlineCheckout', $countDeadlineCheckout);
        setVariable('countReport', $countReport);
        setVariable('view', $hotel['Hotel']['view']);
        setVariable('slug', $hotel['Hotel']['slug']);
        setVariable('countOrder', $countOrder);
        setVariable('today', $today);
        setVariable('countRequest', $countRequest);
        setVariable('revenue', $revenue['Revenue'][$today['year']]);
    } else {
        $modelManager->redirect($urlHomes);
    }
}

function managerListBirthday($input)
{
    global $urlHomes;
    $modelManager = new Manager();
    $modelRoom = new Room();

    if (checkLoginManager()) {
        $listData= $modelRoom->getRoomBirthdayUser($_SESSION['idHotel']);

        setVariable('listData', $listData);
    } else {
        $modelManager->redirect($urlHomes);
    }
}

function managerListDeadlinePay($input)
{
    global $urlHomes;
    $modelManager = new Manager();
    $modelRoom = new Room();

    if (checkLoginManager()) {
        $listData= $modelRoom->getRoomDeadlinePay($_SESSION['idHotel']);

        setVariable('listData', $listData);
    } else {
        $modelManager->redirect($urlHomes);
    }
}

function managerListDeadlineCheckout($input)
{
    global $urlHomes;
    $modelManager = new Manager();
    $modelRoom = new Room();

    if (checkLoginManager()) {
        $listData= $modelRoom->getRoomDeadlineCheckout($_SESSION['idHotel']);

        setVariable('listData', $listData);
    } else {
        $modelManager->redirect($urlHomes);
    }
}

?>