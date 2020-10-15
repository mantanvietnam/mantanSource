<?php

// Them khach san
function managerAddHotel($input) {
    $modelHotel = new Hotel();
    global $urlHomes;
    global $isAddHotel;
    global $modelOption;
    global $typeHotelManmo;

    $isAddHotel = true;
    //$listHotelTypes = $modelOption->getOption('HotelTypes');
    setVariable('listHotelTypes', $typeHotelManmo);
    if (checkLoginManager()) {
        global $isRequestPost;
        if ($isRequestPost) {
            $modelManager = new Manager();
            $name = $_POST['name'];
            $manager = $_SESSION['infoManager']['Manager']['id'];
            $idStaff = $_SESSION['infoManager']['Manager']['idStaff'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $price = (int) $_POST['price'];
            $email = isset($_POST['email'])?$_POST['email']:'';
            $city = (int) $_POST['city'];
            $district = (int) $_POST['district'];
            $typeHotel = (int) $_POST['typeHotel'];
            $imageDefault = $_POST['imageDefault'];
            $priceHour = (int) $_POST['priceHour'];
            $priceNight = (int) $_POST['priceNight'];
            $link360 = $_POST['link360'];

            if (isset($_POST['linkCamera']))
                $linkCamera = $_POST['linkCamera'];
            else {
                $linkCamera = '';
            }
            if (isset($_POST['furniture']))
                $furniture = $_POST['furniture'];
            else
                $furniture = array();
            //debug ($furniture);
            foreach ($furniture as $key => $value) {
                $furniture[$key] = (int) $value;
            }
            
            if (isset($_POST['local'])) {
                $local = $_POST['local'];
            } else {
                $local = array();
            }
            
            //debug ($local);
            if (isset($_POST['website']))
                $website = $_POST['website'];
            else
                $website = '';

            if (isset($_POST['id']))
                $id = $_POST['id'];
            else
                $id = '';
            if (isset($_POST['info']))
                $info =  $_POST['info'];
            else
                $info = '';
            if (isset($_POST['coordinates'])){
                $coordinates = $_POST['coordinates'];
                $array = explode(',', $_POST['coordinates']);
                $coordinates_x = (double) $array[0];
                $coordinates_y = (double) $array[1];
            }else{
                $coordinates = '';
                $coordinates_x = '';
                $coordinates_y = '';
            }
            if (isset($_POST['yahoo']))
                $yahoo = $_POST['yahoo'];
            else
                $yahoo = '';
            if (isset($_POST['skype']))
                $skype = $_POST['skype'];
            else
                $skype = '';

            $number = -1;
            $images = array();
            for ($i = 0; $i <= 9; $i++) {
                if ($_POST['image' . $i] != '') {
                    $number++;
                    $images[$number] = $_POST['image' . $i];
                }
            }
            if (empty($images)) {
                $images[0] = '/app/Plugin/mantanHotel/images/no-thumb.png';
            }

            $return = $modelHotel->saveHotel($name, $manager, $idStaff, $city, $district, $address, $phone, $email, $website, $typeHotel, $furniture, $local, $images, $id, $price, $info, $coordinates,$coordinates_x,$coordinates_y, $yahoo, $skype,$linkCamera,$imageDefault,$priceHour,$priceNight,$link360);
            if(empty($_GET['idHotel'])){
                $return['Hotel']['id'] = $modelHotel->getLastInsertId();
                $modelManager->addHotelForManager($_SESSION['infoManager']['Manager']['id'], $return['Hotel']['id']);
            }
            
            $listData = $modelHotel->getAllByManager($_SESSION['infoManager']['Manager']['idStaff']);
            $array = array();
            foreach ($listData as $data) {
                $array[] = $data['Hotel']['id'];
            }
            $_SESSION['infoManager']['Manager']['listHotel'] = $array;
           	if (count($listData) == 1){
                $modelHotel->redirect($urlHomes . 'managerSelectHotel');
            }
            elseif (isset($return['Hotel'])){
                if(!empty($_GET['idHotel']) && $_GET['idHotel']==$_SESSION['idHotel']){
                    $_SESSION['typeHotel']= $typeHotel;
                }
                $modelHotel->redirect($urlHomes . 'managerListHotel');
            }
        }else {
            $modelOption = new Option();
            $modelLocaltion = new Localtion();
            // Lay danh sach tinh thanh quan huyen
            $listData = $modelOption->getOption('cityMantanHotel');
            $listCity = $listData['Option']['value']['allData'];
            setVariable('listCity', $listCity);
            // Lay danh sach tien nghi
            $listData = $modelOption->getOption('furnitureMantanHotel');
            $listFurniture = (isset($listData['Option']['value']['allData'])) ? $listData['Option']['value']['allData'] : array();
            setVariable('listFurniture', $listFurniture);
            if (isset($_GET['idHotel']) && $_GET['idHotel'] != '') {
                $data = $modelHotel->getHotel($_GET['idHotel']);
                if ($data['Hotel']['manager'] == $_SESSION['infoManager']['Manager']['id'])
                    setVariable('data', $data);
            }
        }

        setVariable('listLocal', getListLocation());
    } else {
        $modelHotel->redirect($urlHomes);
    }
}

function managerListHotel() {
    $modelHotel = new Hotel();
    global $urlHomes;
    if (checkLoginManager()) {
        if (empty($_GET['key'])) {
            $listData = $modelHotel->getAllByManager($_SESSION['infoManager']['Manager']['idStaff']);
            //debug ($_SESSION['infoManager']['Manager']['id']);
        } else {
            $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
            if ($page <= 0)
                $page = 1;
            $limit = 15;

            $key = createSlugMantan($_GET['key']);

            $conditions['slug'] = array('$regex' => $key);
            $conditions['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
            $listData = $modelHotel->getPage($page, $limit, $conditions);
        }

        setVariable('listData', $listData);
    } else {
        $modelHotel->redirect($urlHomes);
    }
}

// Xoa khach san
function managerDeleteHotel($input) {
    $modelHotel = new Hotel();
    global $urlHomes;
    if (checkLoginManager()) {
        global $isRequestPost;
        if ($isRequestPost && isset($_POST['idDelete'])) {
            $data = $modelHotel->getHotel($_POST['idDelete']);
            if ($data['Hotel']['manager'] == $_SESSION['infoManager']['Manager']['id'])
                $modelHotel->delete($_POST['idDelete']);
        }
    }
    else {
        $modelHotel->redirect($urlHomes);
    }
}


?>