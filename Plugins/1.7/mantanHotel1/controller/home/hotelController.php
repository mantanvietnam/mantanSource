<?php

function searchHotel($input) {
    global $modelOption;
    global $urlNow;
    $dataSend = arrayMap($input['request']->query);
    $modelHotel = new Hotel();

    $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
    if ($page <= 0)
        $page = 1;
    $limit = 15;

    $conditions = array();
    // tim theo tu khoa
    if (isset($dataSend['nameHotel']) && $dataSend['nameHotel'] != '') {
        $key = createSlugMantan($dataSend['nameHotel']);
        $conditions['slug'] = array('$regex' => $key);
    }

    // tim theo gia
    if (isset($dataSend['price']) && $dataSend['price'] != '') {
        $price = explode('-', $dataSend['price']);

        $priceFrom = (int) $price[0];
        $priceTo = (int) $price[1];

        $conditions['price'] = array('$gte' => $priceFrom, '$lte' => $priceTo);
    }

    // tim theo thanh pho
    if (isset($dataSend['city']) && $dataSend['city'] > 0) {
        $conditions['city'] = (int) $dataSend['city'];
    }

    // tim theo quan huyen
    if (isset($dataSend['district']) && $dataSend['district'] > 0) {
        $conditions['district'] = (int) $dataSend['district'];
    }

    // tim theo vi tri
    if (isset($dataSend['loction']) && $dataSend['loction'] != '') {
        $conditions['local'] = $dataSend['loction'];
    }

    // tim theo loai khach san
    if (isset($dataSend['hotelType']) && $dataSend['hotelType'] > 0) {
        $conditions['typeHotel'] = (int) $dataSend['hotelType'];
    }

    // tim theo tien ich
    $listFurniture = $modelOption->getOption('furnitureMantanHotel');
//    $listFurniture['Option']['value']['allData'];
    if (!empty($dataSend['tienIch'])) {
        $condition_tienIch = $dataSend['tienIch'];
    } else {
        $condition_tienIch = array();
    }

    if (!empty($dataSend['tienIch'])) {
        foreach ($dataSend['tienIch'] as $key => $value) {
            $dataSend['tienIch'][$key] = (int) $value;
        }
        $conditions['furniture'] = array('$in' => $dataSend['tienIch']);
    }

    $listHotel = $modelHotel->getPage($page, $limit, $conditions);

    $totalData = $modelHotel->find('count', array('conditions' => $conditions));
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
    setVariable('condition_tienIch', $condition_tienIch);
    setVariable('listHotel', $listHotel);
}

function hotel($input) {
    global $urlHomes;
    global $modelOption;
    global $urlNow;
    global $metaTitleMantan;
    global $metaDescriptionMantan;
    global $metaImageMantan;

    $modelHotel = new Hotel();
    $modelPromotion = new Promotion();


    if (isset($input['request']->params['pass'][1])) {
        $input['request']->params['pass'][1] = str_replace('.html', '', $input['request']->params['pass'][1]);
        $data = $modelHotel->getHotelSlug($input['request']->params['pass'][1]);
        $folderHotel = $urlHomes . '/app/Plugin/mantanHotel/';
    }

    if (empty($data)) {
        $modelHotel->redirect($urlHomes);
    } else {
        $metaTitleMantan = $data['Hotel']['name'];
        $metaDescriptionMantan = substr(strip_tags($data['Hotel']['info']), 0,160) ;
        $metaImageMantan = $urlHomes.$data['Hotel']['image'][0];
        
        $modelHotel->updateView($data['Hotel']['id']);

        $data['Hotel']['urlHotelDetail'] = $urlHomes . 'hotel/' . $data['Hotel']['slug'] . '.html';

        if (!isset($data['Hotel']['logo'])) {
            $data['Hotel']['logo'] = $folderHotel . 'images/no_image-100x100.jpg';
        }
        $listTypeHotel = $modelOption->getOption('HotelTypes');
        if (!empty($data['Hotel']['typeHotel'])) {
            $typeHotel = $listTypeHotel['Option']['value']['allData'][$data['Hotel']['typeHotel']];
        } else {
            $typeHotel['name'] = 'Đang cập nhật';
        }


        $listData = $modelOption->getOption('furnitureMantanHotel');
        $listFurniture = (isset($listData['Option']['value']['allData'])) ? $listData['Option']['value']['allData'] : array();
        $conditions = array();
        $otherData = $modelHotel->getOtherData(3, $conditions);

        $modelTypeRoom = new TypeRoom();
        $page = 1;
        $limit = null;
        $conditions['idHotel'] = $data['Hotel']['id'];

        $listTypeRoom = $modelTypeRoom->getPage($page, $limit, $conditions);

        $today = getdate();
//        $conditions['time_start']= array('$lte' => $today[0]);
        $conditions['time_end'] = array('$gte' => $today[0]);
        $listPromotion = $modelPromotion->getPage(1, null, $conditions);

        // Lay du lieu binh chon
        $listCriteriaVote = $modelOption->getOption('criteriaVote');
        if (isset($listCriteriaVote['Option'])) {
            $modelVote = new Vote();
            $listCriteriaVote = $listCriteriaVote['Option']['value']['allData'];

            if (isset($_SESSION['infoUser']['User']['id'])) {
                foreach ($listCriteriaVote as $key => $value) {
                    $vote = $modelVote->getVote($_SESSION['infoUser']['User']['id'], $data['Hotel']['id'], $value['id']);
                    if (isset($vote['Vote']['id'])) {
                        $listCriteriaVote[$key]['show'] = 0;
                    }
                }
            }
        }

        $urlHotel = explode('?', $urlNow);

        setVariable('typeHotel', $typeHotel['name']);
        setVariable('listCriteriaVote', $listCriteriaVote);
        setVariable('listPromotion', $listPromotion);
        setVariable('listTypeRoom', $listTypeRoom);
        setVariable('otherData', $otherData);
        setVariable('listFurniture', $listFurniture);
        setVariable('data', $data);
        setVariable('urlHotel', $urlHotel[0]);
    }
}

function bestHotel() {
    global $urlNow;
    global $modelOption;
    $modelHotel = new Hotel();

    $conditions = array();
    $conditions['best'] = 1;



    if (!empty($_GET['giaPhong']) && $_GET['giaPhong'] != 'empty') {
        if ($_GET['giaPhong'] == 'thap-cao') {
            $order['price'] = 'asc';
        } elseif ($_GET['giaPhong'] == 'cao-thap') {
            $order['price'] = 'desc';
        }
    }
    if (!empty($_GET['nameHotel']) && $_GET['nameHotel'] != 'empty') {
        if ($_GET['nameHotel'] == 'thap-cao') {
            $order['name'] = 'asc';
        } elseif ($_GET['nameHotel'] == 'cao-thap') {
            $order['name'] = 'desc';
        }
    }
    if (!empty($_GET['danhGia']) && $_GET['danhGia'] != 'empty') {
        if ($_GET['danhGia'] == 'thap-cao') {
            $order['vote.point'] = 'asc';
        } elseif ($_GET['danhGia'] == 'cao-thap') {
            $order['vote.point'] = 'desc';
        }
    }
    if (!empty($_GET['quanTam']) && $_GET['quanTam'] != 'empty') {
        if ($_GET['quanTam'] == 'thap-cao') {
            $order['view'] = 'asc';
        } elseif ($_GET['quanTam'] == 'cao-thap') {
            $order['view'] = 'desc';
        }
    }
    $order['created'] = 'desc';

    if (!empty($_GET['city']) && $_GET['city'] != 'all') {
        $conditions['city'] = (int) $_GET['city'];
    }
    $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
    if ($page <= 0)
        $page = 1;
    $limit = 15;


    $listHotel = $modelHotel->getPage($page, $limit, $conditions, $order);


    $totalData = $modelHotel->find('count', array('conditions' => $conditions));

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

    $listCity = $modelOption->getOption('cityMantanHotel');

    setVariable('listCity', $listCity);
    setVariable('page', $page);
    setVariable('totalPage', $totalPage);
    setVariable('back', $back);
    setVariable('next', $next);
    setVariable('urlPage', $urlPage);
    setVariable('listHotel', $listHotel);
}

function newHotel() {
    global $urlNow;
    global $modelOption;

    $modelHotel = new Hotel();
    $limit = 15;
    $conditions = array();

    if (!empty($_GET['giaPhong']) && $_GET['giaPhong'] != 'empty') {
        if ($_GET['giaPhong'] == 'thap-cao') {
            $order['price'] = 'asc';
        } elseif ($_GET['giaPhong'] == 'cao-thap') {
            $order['price'] = 'desc';
        }
    }
    if (!empty($_GET['nameHotel']) && $_GET['nameHotel'] != 'empty') {
        if ($_GET['nameHotel'] == 'thap-cao') {
            $order['name'] = 'asc';
        } elseif ($_GET['nameHotel'] == 'cao-thap') {
            $order['name'] = 'desc';
        }
    }
    if (!empty($_GET['danhGia']) && $_GET['danhGia'] != 'empty') {
        if ($_GET['danhGia'] == 'thap-cao') {
            $order['vote.point'] = 'asc';
        } elseif ($_GET['danhGia'] == 'cao-thap') {
            $order['vote.point'] = 'desc';
        }
    }
    if (!empty($_GET['quanTam']) && $_GET['quanTam'] != 'empty') {
        if ($_GET['quanTam'] == 'thap-cao') {
            $order['view'] = 'asc';
        } elseif ($_GET['quanTam'] == 'cao-thap') {
            $order['view'] = 'desc';
        }
    }
//    if (!empty($_GET['khuyenMai']) && $_GET['khuyenMai'] != 'empty') {
//        if ($_GET['khuyenMai'] == 'co') {
//            $order['view'] = 'asc';
//        } elseif ($_GET['khuyenMai'] == 'khong') {
//            $order['view'] = 'desc';
//        }
//    }
    $order['created'] = 'desc';
    if (!empty($_GET['city']) && $_GET['city'] != 'all') {
        $conditions['city'] = (int) $_GET['city'];
    }
    $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
    if ($page <= 0)
        $page = 1;
    $listHotel = $modelHotel->getPage($page, $limit, $conditions, $order);



    $totalData = $modelHotel->find('count', array('conditions' => $conditions));

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

    $listCity = $modelOption->getOption('cityMantanHotel');

    setVariable('listCity', $listCity);

    setVariable('page', $page);
    setVariable('totalPage', $totalPage);
    setVariable('back', $back);
    setVariable('next', $next);
    setVariable('urlPage', $urlPage);
    setVariable('listHotel', $listHotel);
}

function infoUser($input) {
    global $isRequestPost;
    global $urlHomes;
    $modelUser = new User();

    if (!empty($_SESSION['infoUser'])) {
        $dataUser = $modelUser->getUser($_SESSION['infoUser']['User']['id']);
        if ($isRequestPost) {
            $dataSend = $input['request']->data;

            $data['User']['fullname'] = $_SESSION['infoUser']['User']['fullname'] = $dataSend['fullname'];
            $data['User']['phone'] = $_SESSION['infoUser']['User']['phone'] = $dataSend['phone'];
            $data['User']['sex'] = $_SESSION['infoUser']['User']['sex'] = $dataSend['sex'];
            $data['User']['address'] = $_SESSION['infoUser']['User']['address'] = $dataSend['address'];
            $data['User']['cmnd'] = $_SESSION['infoUser']['User']['cmnd'] = $dataSend['cmnd'];
            $data['User']['cmnd_address'] = $_SESSION['infoUser']['User']['cmnd_address'] = $dataSend['cmnd_address'];
            $data['User']['cmnd_date'] = $_SESSION['infoUser']['User']['cmnd_date'] = strtotime($dataSend['cmnd_date']);

            $dk['_id'] = new MongoId($_SESSION['infoUser']['User']['id']);

            if ($modelUser->updateAll($data['User'], $dk)) {
                $modelUser->redirect($urlHomes . 'infoUser?stt=1');
            }
        }

        setVariable('dataUser', $dataUser);
    } else {
        $modelUser->redirect($urlHomes);
    }
}

function changePassword($input) {
    global $isRequestPost;
    global $urlHomes;
    global $modelOption;
    global $gmpThemeSettings;
    $modelUser = new User();
    $contactSite = $modelOption->getOption('contact');
    $smtpSite = $modelOption->getOption('smtpSetting');

    if (!empty($_SESSION['infoUser'])) {

        if ($isRequestPost) {
            $dataSend = $input['request']->data;
            $dataUser = $modelUser->getUser($_SESSION['infoUser']['User']['id']);

            if (md5($dataSend['oldPassword']) == $dataUser['User']['password']) {
                if ($dataSend['password'] == $dataSend['passwordAgain']) {

                    $data['User']['password'] = md5($dataSend['password']);
                    $dk['_id'] = new MongoId($_SESSION['infoUser']['User']['id']);
                        
                    if ($modelUser->updateAll($data['User'], $dk)) {

                        // send email for user and admin
                        $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                        $to = array(trim($dataUser['User']['email']), trim($contactSite['Option']['value']['email']));
                        $cc = array();
                        $bcc = array();
                        $subject = '[' . $smtpSite['Option']['value']['show'] . '] ' .$gmpThemeSettings['Option']['value']['titleEmailChangePassword'];

                        // create content email

                        $content = 'Xin chào '. $dataUser['User']['fullname'] . ' !<br/>';
                        $content.= $gmpThemeSettings['Option']['value']['textEmailChangePassword'].'<br/>';
                        $content.='Mật khẩu mới của bạn là: ' . $dataSend['password'] . '';
                        
                        $modelUser->sendMail($from, $to, $cc, $bcc, $subject, $content);
                        $modelUser->redirect($urlHomes . 'infoUser?stt=4');
                    }
                } else {
                    $modelUser->redirect($urlHomes . 'infoUser?stt=3');
                }
            } else {
                $modelUser->redirect($urlHomes . 'infoUser?stt=2');
            }
        }
    } else {
        $modelUser->redirect($urlHomes);
    }
}

function orderHotel($input) {
    global $isRequestPost;
    global $modelOption;
    $contactSite = $modelOption->getOption('contact');
    $smtpSite = $modelOption->getOption('smtpSetting');
    if ($isRequestPost) {
        $modelOrder = new Order();

        $dataSend = arrayMap($input['request']->data);
        $urlHotel = $dataSend['urlHotel'];

        $time_start = strtotime(str_replace("/", "-", $dataSend['date_start']) . ' 0:0:0');
        $time_end = strtotime(str_replace("/", "-", $dataSend['date_end']) . ' 23:59:59');

        $dateStart = $dataSend['date_start'];
        $today = date("d-m-Y");

        if (strtotime($today) <= strtotime($dateStart)) {
            if ($time_end < $time_start) {
                $modelOrder->redirect($urlHotel . '?stt=2');
            } else {
                $nameTypeRoom = 'Chưa xác định';

                if (!empty($dataSend['typeRoom'])) {
                    $modelTypeRoom = new TypeRoom();
                    $typeRoom = $modelTypeRoom->getTypeRoom($dataSend['typeRoom']);
                    if (isset($typeRoom['TypeRoom']['roomtype'])) {
                        $nameTypeRoom = $typeRoom['TypeRoom']['roomtype'];
                    }
                }

                $save['Order']['name'] = $dataSend['name'];
                $save['Order']['phone'] = $dataSend['phone'];
                $save['Order']['email'] = $dataSend['email'];
                $save['Order']['date_start'] = $dataSend['date_start'];
                $save['Order']['date_end'] = $dataSend['date_end'];
                $save['Order']['typeRoom'] = $dataSend['typeRoom'];
                $save['Order']['nameTypeRoom'] = $nameTypeRoom;
                $save['Order']['number_room'] = (int) $dataSend['number_room'];
                $save['Order']['number_people'] = (int) $dataSend['number_people'];
                $save['Order']['idHotel'] = $dataSend['idHotel'];
                $save['Order']['nameHotel'] = $dataSend['nameHotel'];
                $save['Order']['emailHotel'] = $dataSend['emailHotel'];
                $save['Order']['idManager'] = $dataSend['idManager'];
                $save['Order']['idUser'] = (isset($_SESSION['infoUser']['User']['id'])) ? $_SESSION['infoUser']['User']['id'] : "";
                $save['Order']['status'] = 0;


                if ($modelOrder->save($save)) {
                    // send email for user and admin
                    $idOrder= $modelOrder->id;
                    
                    $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                    $to = array(
                        trim($contactSite['Option']['value']['email']),
                        trim($dataSend['email']),
                        trim($dataSend['emailHotel'])
                    );
                    if (!empty($_SESSION['infoUser']['User']['email'])) {
                        $to[] = trim($_SESSION['infoUser']['User']['email']);
                    }
                    
                    if (!empty($_SESSION['infoManager']['Manager']['email'])) {
                        $to[] = trim($_SESSION['infoManager']['Manager']['email']);
                    }
                    
                    $cc = array();
                    $bcc = array();
                    $subject = '[' . $smtpSite['Option']['value']['show'] . '] ' . 'Yêu cầu đặt phòng thành công!';

                    
                    // create content email

                    $content = 'Xin chào ' . $dataSend['name'] . '! Bạn đã yêu cầu đặt phòng thành công! Chúng tôi sẽ sớm liên lạc lại với bạn! <br/><br/>';
                    $content.='Thông tin đặt phòng: <br>';
                    $content .= 'Khách sạn: <a href="' . $urlHotel . '">' . $dataSend['nameHotel'] . '</a>,<br>';
                    $content.='Họ và tên: ' . $dataSend['name'] . '<br>';
                    $content.='SĐT: ' . $dataSend['phone'] . '<br>';
                    $content.='Email: ' . $dataSend['email'] . '<br>';
                    $content.='Ngày đến: ' . $dataSend['date_start'] . '<br>';
                    $content.='Ngày đi: ' . $dataSend['date_end'] . '<br>';
                    $content.='Loại phòng: ' . $nameTypeRoom . '<br>';
                    $content.='Số phòng: ' . $dataSend['number_room'] . '<br>';
                    $content.='Số người lớn: ' . $dataSend['number_people'] . '<br>';
                    $content.='ID đặt phòng: ' . $idOrder . '<br>';

                    $modelOrder->sendMail($from, $to, $cc, $bcc, $subject, $content);
                    $modelOrder->redirect($urlHotel . '?stt=1&idOrder='.$idOrder);
                } else {
                    $modelOrder->redirect($urlHotel . '?stt=-1');
                }
            }
        } else {
            $modelOrder->redirect($urlHotel . '?stt=-2');
        }
    }
}

function orderHistory() {
    global $urlNow;
    $modelOrder = new Order();
    $idUser = $_SESSION['infoUser']['User']['id'];

    $limit = 15;
    $conditions = array();
    $conditions['idUser'] = $idUser;
    $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
    if ($page <= 0)
        $page = 1;

    $data = $modelOrder->getPage($page, $limit, $conditions, $order = array('created' => 'desc'));

    $totalData = $modelOrder->find('count', array('conditions' => $conditions));

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
    setVariable('data', $data);
}

?>