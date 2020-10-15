<?php

// Duong dan trang chu
global $urlHomeManager;
global $urlHomes;
$urlHomeManager = $urlHomes . 'homeManager';

// Them phong
function managerAddBarTable() {
    $modelBarTable = new BarTable();
    global $urlHomes;
    if (checkLoginManager()) {        
        // Lay danh sach tang
        $modelBarFloor= new BarFloor();
        $listFloor = $modelBarFloor->getAllByHotel($_SESSION['idHotel']);

        if (empty($listFloor)) {
            $modelBarFloor->redirect($urlHomes . 'managerAddBarFloor');
        }
        //debug ($listFloor);
        setVariable('listFloor', $listFloor);
        global $isRequestPost;
        if ($isRequestPost) {
            if (isset($_POST['id']) && $_POST['id'] != '') {
                $modelBarTable->updateTable($_POST['name'], $_POST['id']);
                $modelBarTable->redirect($urlHomes . 'managerBarDiagram');
            } else {
                $return = $modelBarTable->creatTable($_POST['floor'], $_POST['name'], $_SESSION['idHotel'], $_SESSION['infoManager']['Manager']['id']);
                $modelBarFloor->addTable($_POST['floor'], array($return));
                $modelBarTable->redirect($urlHomes . 'managerBarDiagram');
            }
        } elseif (isset($_GET['idTable']) && ($_GET['idTable']) != '') {
            $data = $modelBarTable->getTable($_GET['idTable']);
            setVariable('data', $data);
        }
    } else {
        $modelBarTable->redirect($urlHomes);
    }
}

function managerDeleteBarTable() {
    $modelBarFloor = new BarFloor();
    $modelBarTable = new BarTable();
    global $isRequestPost;

    if (checkLoginManager() && $isRequestPost) {
        $data = $modelBarTable->getTable($_POST['idTable'], $_SESSION['infoManager']['Manager']['id'], $_SESSION['idHotel']);
        if ($data) {
            $modelBarFloor->deleteTable($data['BarTable']['floor'], $data['BarTable']['id']);
            $modelBarTable->deleteTable($_POST['idTable']);
            //$modelBarTable->redirect($urlHomes.'managerHotelDiagram');
        } else {
            //$modelBarTable->redirect($urlHomeManager);
        }
    } else {
        //$modelBarFloor->redirect($urlHomes);
    }
}

function managerClearBarTable() {
    $modelBarTable= new BarTable();
    global $isRequestPost;
    if (checkLoginManager() && $isRequestPost) {

        $data = $modelBarTable->getTable($_POST['idTable'], $_SESSION['infoManager']['Manager']['id'], $_SESSION['idHotel']);
        if ($data) {
            $saveTable['$set']['clear'] = true;
            $idTable = new MongoId($_POST['idTable']);
            $modelBarTable->updateAll($saveTable, array('_id' => $idTable));
        }
    }else{
        $modelBarTable->redirect($urlHomes);
    }
}

?>