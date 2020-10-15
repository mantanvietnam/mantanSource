<?php

// Duong dan trang chu
global $urlHomeManager;
global $urlHomes;
$urlHomeManager = $urlHomes . 'homeManager';

// Them phong
function managerAddRoom() {
    $modelRoom = new Room();
    $modelTypeRoom = new TypeRoom();
    global $urlHomes;
    if (checkLoginManager()) {
        $numberRoomActive= $modelRoom->find('count',array('conditions'=>array('manager'=>$_SESSION['infoManager']['Manager']['id'])));
        if(!empty($_SESSION['infoManager']['Manager']['numberRoomMax']) && $numberRoomActive>=$_SESSION['infoManager']['Manager']['numberRoomMax']){
            $modelRoom->redirect($urlHomes . 'managerHotelDiagram?redirect=managerAddRoom');
        }

        $listTypeRoom = $modelTypeRoom->getAllTypeRoomHotel($_SESSION['idHotel']);

        if (empty($listTypeRoom)) {
            $modelRoom->redirect($urlHomes . 'managerAddTypeRoom');
        }
        //debug ($listTypeRoom);
        setVariable('listTypeRoom', $listTypeRoom);
        // Lay danh sach tang
        $modelFloor = new Floor();
        $listFloor = $modelFloor->getAllByHotel($_SESSION['idHotel']);

        if (empty($listFloor)) {
            $modelRoom->redirect($urlHomes . 'managerAddFloor');
        }
        //debug ($listFloor);
        setVariable('listFloor', $listFloor);
        global $isRequestPost;
        if ($isRequestPost) {
            if (isset($_POST['id']) && $_POST['id'] != '') {
                $modelRoom->updateRoom($_POST['name'], $_POST['typeRoom'], $_POST['id']);
                $modelRoom->redirect($urlHomes . 'managerHotelDiagram');
            } else {
                $return = $modelRoom->creatRoom($_POST['floor'], $_POST['name'], $_SESSION['idHotel'], $_SESSION['infoManager']['Manager']['id'], $_POST['typeRoom']);
                $modelFloor->addRoom($_POST['floor'], array($return));
                $modelRoom->redirect($urlHomes . 'managerHotelDiagram');
            }
        } elseif (isset($_GET['idroom']) && ($_GET['idroom']) != '') {
            $data = $modelRoom->getRoom($_GET['idroom']);
            setVariable('data', $data);
        }
    } else {
        $modelRoom->redirect($urlHomes);
    }
}

function managerDeleteRoom() {
    $modelFloor = new Floor();
    $modelRoom = new Room();
    global $isRequestPost;

    if (checkLoginManager() && $isRequestPost) {
        $data = $modelRoom->getRoom($_POST['idroom'], $_SESSION['infoManager']['Manager']['id'], $_SESSION['idHotel']);
        if ($data) {
            $modelFloor->deleteRoom($data['Room']['floor'], $data['Room']['id']);
            $modelRoom->deleteRoom($_POST['idroom']);
            //$modelRoom->redirect($urlHomes.'managerHotelDiagram');
        } else {
            //$modelRoom->redirect($urlHomeManager);
        }
    } else {
        //$modelFloor->redirect($urlHomes);
    }
}

function managerClearRoom() {
    $modelRoom = new Room();
    global $isRequestPost;
    if (checkLoginManager() && $isRequestPost) {

        $data = $modelRoom->getRoom($_POST['idroom'], $_SESSION['infoManager']['Manager']['id'], $_SESSION['idHotel']);
        if ($data) {

            $saveRoom['$set']['clear'] = true;
            $idRoom = new MongoId($_POST['idroom']);
            $modelRoom->updateAll($saveRoom, array('_id' => $idRoom));
        } else {
//            $modelRoom->redirect($urlHomeManager);
        }
    } else {
        //$modelFloor->redirect($urlHomes);
    }
}

?>