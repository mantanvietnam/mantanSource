<?php

function managerListOrder() {
    global $urlHomes;

    $modelOrder = new Order();
    if (checkLoginManager()) {
        global $urlNow;

        $limit = 15;
        $conditions = array();
        $conditions['idHotel'] = $_SESSION['idHotel'];
        $conditions['idManager'] = $_SESSION['infoManager']['Manager']['id'];
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;

        $listData = $modelOrder->getPage($page, $limit, $conditions, $order = array('created' => 'desc'));
        
        
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
        setVariable('listData', $listData);
    } else {
        $modelOrder->redirect($urlHomes);
    }
}

function managerListOrderPending() {
    global $urlHomes;
    global $urlNow;

    $modelOrder = new Order();

    if (checkLoginManager()) {
        $limit = 15;
        $conditions = array();
        $conditions['idHotel'] = $_SESSION['idHotel'];
        $conditions['idManager'] = $_SESSION['infoManager']['Manager']['id'];
        $conditions['status'] = 0;
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;

        $listData = $modelOrder->getPage($page, $limit, $conditions, $order = array('created' => 'desc'));

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
        setVariable('listData', $listData);
    } else {
        $modelOrder->redirect($urlHomes);
    }
}

function managerListOrderProcess() {
    global $urlHomes;
    global $urlNow;

    $modelOrder = new Order();

    if (checkLoginManager()) {

        $limit = 15;
        $conditions = array();
        $conditions['idHotel'] = $_SESSION['idHotel'];
        $conditions['idManager'] = $_SESSION['infoManager']['Manager']['id'];
        $conditions['status'] = 1;
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;

        $listData = $modelOrder->getPage($page, $limit, $conditions, $order = array('created' => 'desc'));

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
        setVariable('listData', $listData);
    } else {
        $modelOrder->redirect($urlHomes);
    }
}

function managerDeleteOrder($input) {
    global $urlHomes;
    $modelOrder = new Order();

    if (checkLoginManager()) {
        $idDelete = new MongoId($_GET['id']);

        $modelOrder->delete($idDelete);
        $modelOrder->redirect($urlHomes . 'managerListOrder?status=4');
    } else {
        $modelOrder->redirect($urlHomes);
    }
}

function managerProcessOrder($input) {
    global $isRequestPost;
    global $urlHomes;
    $modelOrder = new Order();

    if (checkLoginManager()) {
        $modelFloor = new Floor();
        $modelRoom = new Room();
        $modelTypeRoom = new TypeRoom();
        $modelHotel= new Hotel();

        $listRooms = array();
        $data= array();
        
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $data = $modelOrder->getOrder($id);
        }
        

        
        $page = 1;
        $limit = null;
        $conditions['idHotel'] = $_SESSION['idHotel'];
        $listTypeRoom = $modelTypeRoom->getPage($page, $limit, $conditions);
        $listFloor = $modelFloor->getAllByHotel($_SESSION['idHotel']);

        if (empty($listFloor)) {
            $modelOrder->redirect($urlHomes . 'managerAddFloor?redirect=managerProcessOrder');
        }

        foreach ($listFloor as $floor) {
            $listRooms[$floor['Floor']['id']] = array();
            foreach ($floor['Floor']['listRooms'] as $idRoom) {
                $dataRoom = $modelRoom->getRoomUse($idRoom);

                if ($dataRoom) {
                    array_push($listRooms[$floor['Floor']['id']], $dataRoom);
                }
            }
        }

        setVariable('data', $data);
        setVariable('listTypeRoom', $listTypeRoom);
        setVariable('listFloor', $listFloor);
        setVariable('listRooms', $listRooms);

        if ($isRequestPost) {
            $dataSend = arrayMap($input['request']->data);

            $data['Order']['name'] = $dataSend['name'];
            $data['Order']['email'] = $dataSend['email'];
            $data['Order']['phone'] = $dataSend['phone'];
            $data['Order']['date_start'] = $dataSend['date_start'];
            $data['Order']['date_end'] = $dataSend['date_end'];
            $data['Order']['price'] = $dataSend['price'];
            $data['Order']['prepay'] = $dataSend['prepay'];

            $data['Order']['time_start'] = strtotime(str_replace("/", "-", $dataSend['date_start']) . ' 0:0:0');
            $data['Order']['time_end'] = strtotime(str_replace("/", "-", $dataSend['date_end']) . ' 23:59:59');

            $data['Order']['typeRoom'] = $dataSend['typeRoom'];
            $data['Order']['number_room'] = (int) $dataSend['number_room'];
            $data['Order']['number_people'] = (int) $dataSend['number_people'];
            $data['Order']['status'] = 1;
            $data['Order']['agency'] = $dataSend['agency'];
            $data['Order']['listRooms'] = (isset($dataSend['listRooms'])) ? $dataSend['listRooms'] : array();
            
            $data['Order']['idHotel']= $_SESSION['idHotel'];
            $data['Order']['idManager']= $_SESSION['infoManager']['Manager']['id'];

            $listRoom = '';
            foreach ($data['Order']['listRooms'] as $room) {
                $infoRoom = $modelRoom->getRoom($room);
                $listRoom .= $infoRoom['Room']['name'] . ', ';
            }
            $data['Order']['nameListRooms'] = $listRoom;
            
            $nameTypeRoom = 'Chưa xác định';

            if (!empty($dataSend['typeRoom'])) {
                $typeRoom = $modelTypeRoom->getTypeRoom($dataSend['typeRoom']);
                if (isset($typeRoom['TypeRoom']['roomtype'])) {
                    $nameTypeRoom = $typeRoom['TypeRoom']['roomtype'];
                }
            }
            
            $hotel = $modelHotel->getHotel($_SESSION['idHotel']);
            
            $data['Order']['nameTypeRoom'] = $nameTypeRoom;
            $data['Order']['nameHotel'] = (isset($hotel['Hotel']['name']))?$hotel['Hotel']['name']:'';
            $data['Order']['emailHotel'] = (isset($hotel['Hotel']['email']))?$hotel['Hotel']['email']:'';
            $data['Order']['idUser'] = '';
            

            if ($modelOrder->save($data)) {
                $modelOrder->redirect($urlHomes . 'managerListOrderProcess?status=1');
            }
        }
    } else {
        $modelOrder->redirect($urlHomes);
    }
}

function managerListWaiting() {
    global $isRequestPost;
    global $urlHomes;
    $modelOrder = new Order();
    $modelRoom = new Room();

    if (checkLoginManager()) {
        $room = $modelRoom->getRoom($_GET['idroom']);

        if (!$room) {
            $modelOrder->redirect($urlHomes . 'managerHotelDiagram');
        }

        $today = getdate();
        $timeStart = mktime(0, 0, 0, $today['mon'], $today['mday'], $today['year']);

        $conditions['idHotel'] = $_SESSION['idHotel'];
        $conditions['status'] = 1;
        $conditions['time_start'] = array('$gte' => $timeStart);
        $conditions['listRooms'] = $_GET['idroom'];

        $listData = $modelOrder->find('all', array('conditions' => $conditions, 'order' => array('time_start' => 'asc')));

        setVariable('listData', $listData);
        setVariable('room', $room);
    } else {
        $modelOrder->redirect($urlHomes);
    }
}

function managerProcessOrderCheckin($input)
{
    global $isRequestPost;
    global $urlHomes;
    $modelOrder = new Order();
    $modelRoom = new Room();
    $modelTypeRoom = new TypeRoom();

    if (checkLoginManager()) {
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $data = $modelOrder->getOrder($id);

            if(!empty($data['Order']['listRooms'])){
                $listRooms= array();

                foreach($data['Order']['listRooms'] as $idRoom){
                    $room= $modelRoom->getRoom($idRoom);

                    if(!empty($room['Room']['checkin'])){
                        $modelOrder->redirect($urlHomes.'managerListOrderProcess?status=checkinError&name='.$room['Room']['name']);
                    }

                    $listRooms[]= $room;
                }

                foreach($listRooms as $key=>$room){
                    $save= array();
                    $dk= array('_id'=> new MongoId($room['Room']['id']));
                    $typeRoom = $modelTypeRoom->getTypeRoom($room['Room']['typeRoom']);

                    $dateCheckin = getdate();
                    
                    $save['price'] = (int) $data['Order']['price'];
                    $save['prepay'] = ($key==0)? (int) $data['Order']['prepay']:0;

                    $save['dateCheckin'] = $dateCheckin[0];
                    $save['dateCheckoutForesee'] = null;
                    $save['type_register'] = 'gia_theo_ngay';
                    $save['number_people'] = 1;
                    $save['note'] = 'Khách đặt phòng từ trước';
                    $save['typeDate'] = checkTypeDate();
                    $save['promotion'] = 0;
                    $save['khachDoan']= (count($listRooms)>1)?'co':'khong';

                    $save['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
                    $save['idHotel'] = $_SESSION['idHotel'];
                    $save['idManager'] = $_SESSION['infoManager']['Manager']['id'];

                    $save['agency'] = $data['Order']['agency'];
                    // Thong tin khach 
                    if($save['khachDoan']=='co'){
                        if($key==0){
                            $save['Custom']['truongDoan'] = true;
                            $idRoomDoan= $room['Room']['id'];
                            $save['Custom']['color'] = 'rgb(8,38,198)';
                        }else{
                            $save['Custom']['idRoomDoan'] = $idRoomDoan;
                            $save['Custom']['color'] = 'rgb(8,38,198)';
                        }
                    }

                    $save['Custom']['id'] = '';
                    $save['Custom']['cus_name'] = !empty($data['Order']['name']) ? $data['Order']['name'] : 'Khách lẻ';
                    $save['Custom']['email'] = !empty($data['Order']['email']) ? $data['Order']['email'] : '';
                    $save['Custom']['cmnd'] = '';
                    $save['Custom']['address'] = '';
                    $save['Custom']['phone'] = $data['Order']['phone'];
                    $save['Custom']['nationality'] = 0;
                    $save['bienSoXe'] = '';

                    // Thong tin hang hoa
                    if (!empty($typeRoom['TypeRoom']['hang_hoa'])) {
                        foreach ($typeRoom['TypeRoom']['hang_hoa'] as $key => $value) {
                            $save['hang_hoa'][$key] = 0;
                        }
                    }

                    $return = $modelRoom->checkInRoom($save, $room['Room']['id']);

                }
            }

            $modelOrder->redirect($urlHomes.'managerHotelDiagram');
        }
    } else {
        $modelOrder->redirect($urlHomes);
    }
}

?>