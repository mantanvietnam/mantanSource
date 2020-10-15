<?php
function findnear($input){
	global $modelOption;
	global $metaTitleMantan;

    $modelHotel = new Hotel();
    $modelRoom = new Room();
    $metaTitleMantan= "Nhà nghỉ xung quanh bạn";
    $dataSend = arrayMap($input['request']->query);
    //debug($_COOKIE);die;
    $page = 1; 
    $limit = null; 
    $conditions = array(); 
    $today= getdate();
    //$order = array('created' => 'desc');
    $fields= array('priceHour','price','priceNight','imageDefault','name','point','coordinates_x','coordinates_y','address','phone','coordinates','slug','created','best');
    $order= array('best'=>'desc');

    // tim theo tu khoa
    if (!empty($dataSend['nameHotel'])) {
        $key = createSlugMantan($dataSend['nameHotel']);
        $conditions['slug'] = array('$regex' => $key);
    }

    // tim theo gia
    if (!empty($dataSend['price'])) {
        $price = explode('-', $dataSend['price']);

        $priceFrom = (int) $price[0];
        $priceTo = (int) $price[1];

        $conditions['priceHour'] = array('$gte' => $priceFrom, '$lte' => $priceTo);
    }

    // tim theo tien ich
    if (!empty($dataSend['tienIch'])) {
        foreach ($dataSend['tienIch'] as $key => $value) {
            $dataSend['tienIch'][$key] = (int) $value;
        }
        $conditions['furniture'] = array('$all' => $dataSend['tienIch']);
    }

    // tim theo điểm vote
    if (isset($dataSend['rating']) && $dataSend['rating'] > 0) {
        // lớn hơn hoặc bằng
        $conditions['point'] = array('$gte' => (double)$dataSend['rating']);
    }

    if (!empty($dataSend['tienIch'])) {
        foreach ($dataSend['tienIch'] as $key => $value) {
            $dataSend['tienIch'][$key] = (int) $value;
        }
        $conditions['furniture'] = array('$all' => $dataSend['tienIch']);
    }

    if(!empty($_SESSION['userGPS']) && empty($conditions)){
        $radius= (!empty($_GET['radius']))?(double)$_GET['radius']:0.09;

        $listHotel = $modelHotel->getAround($_SESSION['userGPS']['lat'],$_SESSION['userGPS']['long'],$radius,$fields,$conditions, $order, $limit );
    }else{
        $listHotel = $modelHotel->getPage($page, $limit, $conditions, $order );
    }
    
    if($listHotel){
    	$timeCookie= time() + (86400 * 3650);
    	foreach($listHotel as $key=>$hotel){
            if($today[0]-$hotel['Hotel']['created']->sec<=2592000){
                // còn phòng
                $listHotel[$key]['Hotel']['statusRoom']= 1;
            }else{
                $listHotel[$key]['Hotel']['statusRoom']= checkStatusRoom($hotel['Hotel']['id']);
            }

    		// giá hiển thị
    		if ($hotel['Hotel']['priceHour'] > 0) {
                $priceShow = number_format($hotel['Hotel']['priceHour']) . 'đ/giờ';
            } elseif ($hotel['Hotel']['priceNight'] > 0) {
                $priceShow = number_format($hotel['Hotel']['priceNight']) . 'đ/đêm';
            }elseif ($hotel['Hotel']['price'] > 0) {
                $priceShow = number_format($hotel['Hotel']['price']) . 'đ/ngày';
            }else{
                $priceShow = 'Giá liên hệ';
            }
            $listHotel[$key]['Hotel']['priceShow']= $priceShow;

            // tính khoảng cách
            
            $khoangCach= '';
            if(!empty($_SESSION['userGPS']) && !empty($hotel['Hotel']['coordinates_x']) && !empty($hotel['Hotel']['coordinates_y'])){
            	$khoangCach= tinhKhoangCach($_SESSION['userGPS']['lat'],$_SESSION['userGPS']['long'],$hotel['Hotel']['coordinates_x'],$hotel['Hotel']['coordinates_y']);
            }
            $listHotel[$key]['Hotel']['khoangCach']= $khoangCach;
            
    	}
    }
    //debug($listHotel);die;
    setVariable('listHotel', $listHotel);
}

function searchHotel($input) {
    global $modelOption;
    global $urlNow;
    $dataSend = arrayMap($input['request']->query);
    $modelHotel = new Hotel();

    $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
    if ($page <= 0) $page = 1;
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

        $conditions['priceHour'] = array('$gte' => $priceFrom, '$lte' => $priceTo);
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
    if (!empty($dataSend['loction'])) {
        $conditions['local'] = array('$all' => $dataSend['loction']);
    }

    // tim theo điểm vote
    if (isset($dataSend['rating']) && $dataSend['rating'] > 0) {
        // lớn hơn hoặc bằng
        $conditions['point'] = array('$gte' => (double)$dataSend['rating']);
    }

    // tim theo loai khach san
    if (isset($dataSend['hotelType']) && $dataSend['hotelType'] > 0) {
        $conditions['typeHotel'] = (int) $dataSend['hotelType'];
    }

    // tim theo tien ich
    if (!empty($dataSend['tienIch'])) {
        foreach ($dataSend['tienIch'] as $key => $value) {
            $dataSend['tienIch'][$key] = (int) $value;
        }
        $conditions['furniture'] = array('$all' => $dataSend['tienIch']);
    }

    if(!empty($_GET['orderBy'])){
        switch($_GET['orderBy']){
            case 'cheap': $order= array('priceHour'=>'asc','price'=>'asc');break;
            case 'vote': $order['point'] = 'desc';break;
        }
    }

    $order= array('best'=>'desc');
    $fields= array('priceHour','price','priceNight','imageDefault','name','point','coordinates_x','coordinates_y','address','phone','furniture','manager','email','coordinates','slug','created');

    $listHotel = $modelHotel->getPage($page, $limit, $conditions, $order, $fields);
    $today= getdate();

    if($listHotel){
        foreach($listHotel as $key=>$hotel){
            if($today[0]-$hotel['Hotel']['created']->sec<=2592000){
                $listHotel[$key]['Hotel']['statusRoom']= 1;
            }else{
                $listHotel[$key]['Hotel']['statusRoom']= checkStatusRoom($hotel['Hotel']['id']);
            }

            // giá hiển thị
            if ($hotel['Hotel']['priceHour'] > 0) {
                $priceShow = number_format($hotel['Hotel']['priceHour']) . 'đ/giờ';
            } elseif ($hotel['Hotel']['priceNight'] > 0) {
                $priceShow = number_format($hotel['Hotel']['priceNight']) . 'đ/đêm';
            }elseif ($hotel['Hotel']['price'] > 0) {
                $priceShow = number_format($hotel['Hotel']['price']) . 'đ/ngày';
            }else{
                $priceShow = 'Giá liên hệ';
            }
            $listHotel[$key]['Hotel']['priceShow']= $priceShow;

            // tính khoảng cách
            $khoangCach= '';
            if(!empty($_SESSION['userGPS']) && !empty($hotel['Hotel']['coordinates_x']) && !empty($hotel['Hotel']['coordinates_y'])){
                $khoangCach= tinhKhoangCach($_SESSION['userGPS']['lat'],$_SESSION['userGPS']['long'],$hotel['Hotel']['coordinates_x'],$hotel['Hotel']['coordinates_y']);
            }
            $listHotel[$key]['Hotel']['khoangCach']= $khoangCach;
        }
    }

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
        $checkUrl= explode('?', $urlPage);
        if (count($checkUrl) > 1) {
            $urlPage = $urlPage . '&page=';
        } else {
            $urlPage = $urlPage . 'page=';
        }
    } else {
        $urlPage = $urlPage . '?page=';
    }

    if (isset($_GET['orderBy'])) {
        $urlSearch = str_replace('&orderBy=' . $_GET['orderBy'], '', $urlNow);
        $urlSearch = str_replace('orderBy=' . $_GET['orderBy'], '', $urlSearch);
    } else {
        $urlSearch = $urlNow;
    }
    if (strpos($urlSearch, '?') !== false) {
        $checkUrl= explode('?', $urlPage);
        if (count($checkUrl) > 1) {
            $urlSearch = $urlSearch . '&orderBy=';
        } else {
            $urlSearch = $urlSearch . 'orderBy=';
        }
    } else {
        $urlSearch = $urlSearch . '?orderBy=';
    }

    setVariable('page', $page);
    setVariable('totalPage', $totalPage);
    setVariable('back', $back);
    setVariable('next', $next);
    setVariable('urlPage', $urlPage);
    setVariable('urlSearch', $urlSearch);
    setVariable('listHotel', $listHotel);
    setVariable('totalData', $totalData);
    setVariable('listFurniture', getListFurniture());
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
        if(empty($metaDescriptionMantan)) $metaDescriptionMantan= 'Thông tin chi tiết về '.$data['Hotel']['name'].' trên website manmo.vn, liên hệ '.$data['Hotel']['phone'].' để đặt phòng trước';
        
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

        $listFurniture = getListFurniture();

        $radius= 0.09; // 10km
        $conditions = array('_id'=>array('$ne'=>new MongoId($data['Hotel']['id']) ));
        $fields= array('priceHour','price','priceNight','imageDefault','name','point','slug');
        $order= array('best'=>'desc');
        $limit= 9;
        $otherData = $modelHotel->getAround($data['Hotel']['coordinates_x'],$data['Hotel']['coordinates_y'],$radius,$fields,$conditions, $order, $limit );
    
        
        //$otherData = $modelHotel->getOtherData(3, $conditions);

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

        $khoangCach= '';
        if(!empty($_SESSION['userGPS']) && !empty($data['Hotel']['coordinates'])){
            $khoangCach= tinhKhoangCach($_SESSION['userGPS']['lat'],$_SESSION['userGPS']['long'],$data['Hotel']['coordinates_x'],$data['Hotel']['coordinates_y']);
        }

        setVariable('typeHotel', $typeHotel['name']);
        setVariable('listCriteriaVote', $listCriteriaVote);
        setVariable('listPromotion', $listPromotion);
        setVariable('listTypeRoom', $listTypeRoom);
        setVariable('otherData', $otherData);
        setVariable('listFurniture', $listFurniture);
        setVariable('data', $data);
        setVariable('urlHotel', $urlHotel[0]);
        setVariable('khoangCach', $khoangCach);
    }
}

function bestHotel() {
    global $urlNow;
    global $modelOption;
    $modelHotel = new Hotel();

    $conditions = array();
    $conditions['best'] = 1;

    if(!empty($_GET['orderBy'])){
        switch($_GET['orderBy']){
            case 'cheap': $order['priceHour'] = 'asc';$order['price'] = 'asc';break;
            case 'vote': $order['point'] = 'desc';break;
        }
    }

    $order['created'] = 'desc';
    $fields= array('priceHour','price','priceNight','imageDefault','name','point','coordinates_x','coordinates_y','address','phone','furniture','manager','email','coordinates','slug','created');

    /*
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
    */

    $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
    if ($page <= 0) $page = 1;
    $limit = 15;


    $listHotel = $modelHotel->getPage($page, $limit, $conditions, $order, $fields);
    if($listHotel){
        $today= getdate();
        foreach($listHotel as $key=>$hotel){
            if($today[0]-$hotel['Hotel']['created']->sec<=2592000){
                $listHotel[$key]['Hotel']['statusRoom']= 1;
            }else{
                $listHotel[$key]['Hotel']['statusRoom']= checkStatusRoom($hotel['Hotel']['id']);
            }

            // giá hiển thị
            if ($hotel['Hotel']['priceHour'] > 0) {
                $priceShow = number_format($hotel['Hotel']['priceHour']) . 'đ/giờ';
            } elseif ($hotel['Hotel']['priceNight'] > 0) {
                $priceShow = number_format($hotel['Hotel']['priceNight']) . 'đ/đêm';
            }elseif ($hotel['Hotel']['price'] > 0) {
                $priceShow = number_format($hotel['Hotel']['price']) . 'đ/ngày';
            }else{
                $priceShow = 'Giá liên hệ';
            }
            $listHotel[$key]['Hotel']['priceShow']= $priceShow;

            // tính khoảng cách
            $khoangCach= '';
            if(!empty($_SESSION['userGPS']) && !empty($hotel['Hotel']['coordinates_x']) && !empty($hotel['Hotel']['coordinates_y'])){
                $khoangCach= tinhKhoangCach($_SESSION['userGPS']['lat'],$_SESSION['userGPS']['long'],$hotel['Hotel']['coordinates_x'],$hotel['Hotel']['coordinates_y']);
            }
            $listHotel[$key]['Hotel']['khoangCach']= $khoangCach;
        }
    }

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
        $checkUrl= explode('?', $urlPage);
        if (count($checkUrl) > 1) {
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
    setVariable('listFurniture', getListFurniture());
    setVariable('totalData', $totalData);
}

function newHotel() {
    global $urlNow;
    global $modelOption;

    $modelHotel = new Hotel();
    $limit = 15;
    $conditions = array();

    if(!empty($_GET['orderBy'])){
        switch($_GET['orderBy']){
            case 'cheap': $order['priceHour'] = 'asc';$order['price'] = 'asc';break;
            case 'vote': $order['point'] = 'desc';break;
        }
    }

    $order['created'] = 'desc';
    $fields= array('priceHour','price','priceNight','imageDefault','name','point','coordinates_x','coordinates_y','address','phone','furniture','manager','email','coordinates','slug','created');

    /*
    if (!empty($_GET['giaPhong']) && $_GET['giaPhong'] != 'empty') {
        if ($_GET['giaPhong'] == 'thap-cao') {
            
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

    if (!empty($_GET['khuyenMai']) && $_GET['khuyenMai'] != 'empty') {
        if ($_GET['khuyenMai'] == 'co') {
            $order['view'] = 'asc';
        } elseif ($_GET['khuyenMai'] == 'khong') {
            $order['view'] = 'desc';
        }
    }
    
    if (!empty($_GET['city']) && $_GET['city'] != 'all') {
        $conditions['city'] = (int) $_GET['city'];
    }
    */

    $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
    if ($page <= 0) $page = 1;
    $listHotel = $modelHotel->getPage($page, $limit, $conditions, $order, $fields);
    if($listHotel){
        $today= getdate();
        foreach($listHotel as $key=>$hotel){
            if($today[0]-$hotel['Hotel']['created']->sec<=2592000){
                $listHotel[$key]['Hotel']['statusRoom']= 1;
            }else{
                $listHotel[$key]['Hotel']['statusRoom']= checkStatusRoom($hotel['Hotel']['id']);
            }

            // giá hiển thị
            if ($hotel['Hotel']['priceHour'] > 0) {
                $priceShow = number_format($hotel['Hotel']['priceHour']) . 'đ/giờ';
            } elseif ($hotel['Hotel']['priceNight'] > 0) {
                $priceShow = number_format($hotel['Hotel']['priceNight']) . 'đ/đêm';
            }elseif ($hotel['Hotel']['price'] > 0) {
                $priceShow = number_format($hotel['Hotel']['price']) . 'đ/ngày';
            }else{
                $priceShow = 'Giá liên hệ';
            }
            $listHotel[$key]['Hotel']['priceShow']= $priceShow;

            // tính khoảng cách
            $khoangCach= '';
            if(!empty($_SESSION['userGPS']) && !empty($hotel['Hotel']['coordinates_x']) && !empty($hotel['Hotel']['coordinates_y'])){
                $khoangCach= tinhKhoangCach($_SESSION['userGPS']['lat'],$_SESSION['userGPS']['long'],$hotel['Hotel']['coordinates_x'],$hotel['Hotel']['coordinates_y']);
            }
            $listHotel[$key]['Hotel']['khoangCach']= $khoangCach;
        }
    }

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
        $checkUrl= explode('?', $urlPage);
        if (count($checkUrl) > 1) {
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
    setVariable('totalData', $totalData);
    setVariable('listFurniture', getListFurniture());
}

function infoUser($input) {
    global $isRequestPost;
    global $urlHomes;
    $modelUser = new User();

    if (!empty($_SESSION['infoUser'])) {
        $dataUser = $modelUser->getUser($_SESSION['infoUser']['User']['id']);
        if ($isRequestPost) {
            $dataSend = arrayMap($input['request']->data);

            $data['User']['fullname'] = $_SESSION['infoUser']['User']['fullname'] = $dataSend['fullname'];
            $data['User']['phone'] = $_SESSION['infoUser']['User']['phone'] = $dataSend['phone'];
            $data['User']['sex'] = $_SESSION['infoUser']['User']['sex'] = $dataSend['sex'];
            $data['User']['address'] = $_SESSION['infoUser']['User']['address'] = $dataSend['address'];
            $data['User']['cmnd'] = $_SESSION['infoUser']['User']['cmnd'] = $dataSend['cmnd'];
            $data['User']['cmnd_address'] = $_SESSION['infoUser']['User']['cmnd_address'] = $dataSend['cmnd_address'];
            $data['User']['cmnd_date'] = $_SESSION['infoUser']['User']['cmnd_date'] = strtotime($dataSend['cmnd_date']);

            if(!empty($dataSend['password'])){
                $data['User']['password']= md5($dataSend['password']);
            }

            $dk['_id'] = new MongoId($_SESSION['infoUser']['User']['id']);

            if ($modelUser->updateAll($data['User'], $dk)) {
                $dataUser = $modelUser->getUser($_SESSION['infoUser']['User']['id']);
                $_SESSION['infoUser']= $dataUser;
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
    $return= array('code'=>-1);
    if ($isRequestPost) {
        $modelOrder = new Order();
        $modelHotel= new Hotel();

        $dataSend = arrayMap($input['request']->data);
        $urlHotel = (!empty($dataSend['urlHotel']))?$dataSend['urlHotel']:'';

        $time_start = strtotime(str_replace("/", "-", $dataSend['date_start']) . ' 0:0:0');
        $time_end = strtotime(str_replace("/", "-", $dataSend['date_end']) . ' 23:59:59');

        $dateStart = $dataSend['date_start'];
        $today = date("d-m-Y");

        if (strtotime($today) <= strtotime($dateStart)) {
            if ($time_end < $time_start) {
                if(!empty($urlHotel)){
                    $modelOrder->redirect($urlHotel . '?stt=2');
                }else{
                    // thời gian kết thúc nhỏ hơn thời gian bắt đầu
                    $return= array('code'=>2);
                }
                
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
                    $to = array(trim($contactSite['Option']['value']['email']));
                    if(!empty($dataSend['emailHotel'])){
                        $to[]= trim($dataSend['emailHotel']);
                    }

                    if(!empty($dataSend['email'])){
                        $to[]= trim($dataSend['email']);
                    }
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

                    // gửi thông báo SMS
                    $infoHotel= $modelHotel->getHotel($dataSend['idHotel'],array('phone') );
                    if(!empty($infoHotel['Hotel']['phone'])){
                        $phone= str_replace('.', '', $infoHotel['Hotel']['phone']);
                        $content= "Co khach dat phong tren he thong ManMo, so dien thoai cua khach la ".$dataSend['phone'].". Su dung phan mem quan ly phong ManMo de xem thong tin chi tiet";
                        sendSMSNoti($phone,$content);
                    }

                    if(!empty($urlHotel)){
                        $modelOrder->redirect($urlHotel . '?stt=1&idOrder='.$idOrder);
                    }else{
                        // lưu dữ liệu thành công
                        $return= array('code'=>0);
                    }
                    
                } else {
                    $modelOrder->redirect($urlHotel . '?stt=-1');
                }
            }
        } else {
            if(!empty($urlHotel)){
                $modelOrder->redirect($urlHotel . '?stt=-2');
            }else{
                // ngày bắt đầu đã qua
                $return= array('code'=>-2);
            }
        }
    }

    echo json_encode($return);
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
        $checkUrl= explode('?', $urlPage);
        if (count($checkUrl) > 1) {
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

function dangKyPhanMemQuanLyKhachSanMienPhi($input)
{
    
}

?>