<?php

/**
 * Danh sách loại phòng
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerListTypeRoom($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    if (checkLoginManager()) {
        $modelTypeRoom = new TypeRoom();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();
        if (!empty($_SESSION['idHotel'])) {
            $conditions['idHotel'] = $_SESSION['idHotel'];
        }
        $listData = $modelTypeRoom->getPage($page, $limit, $conditions);

        $totalData = $modelTypeRoom->find('count', array('conditions' => $conditions));

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

/**
 * Thêm loại phòng
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerAddTypeRoom($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        // Lay danh sach hang hoa
        $modelMerchandise = new Merchandise();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();
        if (!empty($_SESSION['idHotel'])) {
            $conditions['idHotel'] = $_SESSION['idHotel'];
        }
        $listDataMerchandise = $modelMerchandise->getPage($page, null, $conditions);
        // Lay danh sach loai hang hoa
        $page = 1;
        $limit = null;
        $conditions = array();
        
        $mess= '';
        if(isset($_GET['redirect'])){
            switch($_GET['redirect']){
                case 'managerAddFloor': $mess= 'Bạn phải tạo loại phòng trước khi tạo tầng phòng';break;
                case 'managerHotelDiagram': $mess= 'Bạn phải tạo loại phòng trước khi xem sơ đồ khách sạn';break;
            }
        }
        
        if (!empty($_SESSION['idHotel'])) {
            $conditions['idHotel'] = $_SESSION['idHotel'];
        }
        $modelMerchandiseGroup = new MerchandiseGroup();
        $listMerchandiseGroup = $modelMerchandiseGroup->getPage($page, $limit, $conditions);
        $array = array();
        foreach ($listMerchandiseGroup as $value) {
            $array[$value['MerchandiseGroup']['id']] = $value['MerchandiseGroup']['name'];
        }
        setVariable('listDataMerchandise', $listDataMerchandise);
        setVariable('listMerchandiseGroup', $array);
        //debug ($listDataMerchandise);
        if ($isRequestPost) {
            $modelTypeRoom = new TypeRoom();
            $dataSend = arrayMap($input['request']->data);
            if (!empty($dataSend['desc'])) {
                $save['TypeRoom']['desc'] = $dataSend['desc'];
            }
            $save['TypeRoom']['roomtype'] = $dataSend['roomtype'];
            $save['TypeRoom']['so_giuong'] = (int) $dataSend['so_giuong'];
            $save['TypeRoom']['so_nguoi'] = (int) $dataSend['so_nguoi'];
            $save['TypeRoom']['image'] = $dataSend['image'];
            $save['TypeRoom']['idHotel'] = $_SESSION['idHotel'];
            $save['TypeRoom']['ngayle_nhu_ngaythuong'] = (isset($dataSend['ngayle_nhu_ngaythuong']))? (int) $dataSend['ngayle_nhu_ngaythuong']:0;
            $save['TypeRoom']['ngaycuoituan_nhu_ngaythuong'] = (isset($dataSend['ngaycuoituan_nhu_ngaythuong']))? (int) $dataSend['ngaycuoituan_nhu_ngaythuong']:0;

            //ngay thuong

            $save['TypeRoom']['ngay_thuong']['gia_ngay'] = (int) $dataSend['gia_ngay_thuong'];
            $save['TypeRoom']['ngay_thuong']['gia_qua_dem'] = (int) $dataSend['gia_qua_dem_ngay_thuong'];
            $save['TypeRoom']['ngay_thuong']['gio_qua_dem_start'] = (int) $dataSend['gio_qua_dem_ngay_thuong_start'];
            $save['TypeRoom']['ngay_thuong']['gio_qua_dem_end'] = (int) $dataSend['gio_qua_dem_ngay_thuong_end'];

            $time_gia_theo_gio = $dataSend['time_gia_theo_gio'];
            $gia_theo_gio = $dataSend['gia_theo_gio'];
            $key = 0;
            foreach ($time_gia_theo_gio as $time) {
                $giaTheoGio[$time] = (int) $gia_theo_gio[$key];
                $key++;
            }
            $save['TypeRoom']['ngay_thuong']['gia_theo_gio'] = $giaTheoGio;

            $time_phu_troi_checkout_ngay = $dataSend['time_phu_troi_checkout_ngay'];
            $phu_troi_checkout_ngay = $dataSend['phu_troi_checkout_ngay'];
            $key = 0;
            foreach ($time_phu_troi_checkout_ngay as $time) {
                $phuTroiCheckoutNgay[$time] = (int) $phu_troi_checkout_ngay[$key];
                $key++;
            }
            $save['TypeRoom']['ngay_thuong']['phu_troi_checkout_ngay'] = $phuTroiCheckoutNgay;

            $time_phu_troi_checkout_dem = $dataSend['time_phu_troi_checkout_dem'];
            $phu_troi_checkout_dem = $dataSend['phu_troi_checkout_dem'];
            $key = 0;
            foreach ($time_phu_troi_checkout_dem as $time) {
                $phuTroiCheckoutDem[$time] = (int) $phu_troi_checkout_dem[$key];
                $key++;
            }
            $save['TypeRoom']['ngay_thuong']['phu_troi_checkout_dem'] = $phuTroiCheckoutDem;

            $time_phu_troi_checkin_ngay = $dataSend['time_phu_troi_checkin_ngay'];
            $phu_troi_checkin_ngay = $dataSend['phu_troi_checkin_ngay'];
            $key = 0;
            foreach ($time_phu_troi_checkin_ngay as $time) {
                $phuTroiCheckinNgay[$time] = (int) $phu_troi_checkin_ngay[$key];
                $key++;
            }
            $save['TypeRoom']['ngay_thuong']['phu_troi_checkin_ngay'] = $phuTroiCheckinNgay;

            $time_phu_troi_checkin_dem = $dataSend['time_phu_troi_checkin_dem'];
            $phu_troi_checkin_dem = $dataSend['phu_troi_checkin_dem'];
            $key = 0;
            foreach ($time_phu_troi_checkin_dem as $time) {
                $phuTroiCheckinDem[$time] = (int) $phu_troi_checkin_dem[$key];
                $key++;
            }
            $save['TypeRoom']['ngay_thuong']['phu_troi_checkin_dem'] = $phuTroiCheckinDem;

            $save['TypeRoom']['ngay_thuong']['phu_troi_them_khach'] = (int) $dataSend['phu_troi_them_khach'];

            if (!empty($dataSend['note'])) {
                $save['TypeRoom']['ngay_thuong']['note'] = $dataSend['note'];
            }
    
            //ngay cuoi tuan
            if(isset($dataSend['ngaycuoituan_nhu_ngaythuong']) && $dataSend['ngaycuoituan_nhu_ngaythuong']==1){
                $save['TypeRoom']['ngay_cuoi_tuan']= $save['TypeRoom']['ngay_thuong'];
            }else{
                $save['TypeRoom']['ngay_cuoi_tuan']['gia_ngay'] = (int) $dataSend['gia_ngay_cuoi_tuan'];
                $save['TypeRoom']['ngay_cuoi_tuan']['gia_qua_dem'] = (int) $dataSend['gia_qua_dem_ngay_cuoi_tuan'];
                $save['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_start'] = (int) $dataSend['gio_qua_dem_ngay_cuoi_tuan_start'];
                $save['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end'] = (int) $dataSend['gio_qua_dem_ngay_cuoi_tuan_end'];

                $time_cuoituan_gia_theo_gio = $dataSend['time_cuoituan_gia_theo_gio'];
                $cuoituan_gia_theo_gio = $dataSend['cuoituan_gia_theo_gio'];
                $key = 0;
                foreach ($time_cuoituan_gia_theo_gio as $time) {
                    $cuoituan_giaTheoGio[$time] = (int) $cuoituan_gia_theo_gio[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_cuoi_tuan']['gia_theo_gio'] = $cuoituan_giaTheoGio;

                $time_cuoituan_phu_troi_checkout_ngay = $dataSend['time_cuoituan_phu_troi_checkout_ngay'];
                $cuoituan_phu_troi_checkout_ngay = $dataSend['cuoituan_phu_troi_checkout_ngay'];
                $key = 0;
                foreach ($time_cuoituan_phu_troi_checkout_ngay as $time) {
                    $cuoituan_phuTroiCheckoutNgay[$time] = (int) $cuoituan_phu_troi_checkout_ngay[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_cuoi_tuan']['phu_troi_checkout_ngay'] = $cuoituan_phuTroiCheckoutNgay;

                $time_cuoituan_phu_troi_checkout_dem = $dataSend['time_cuoituan_phu_troi_checkout_dem'];
                $cuoituan_phu_troi_checkout_dem = $dataSend['cuoituan_phu_troi_checkout_dem'];
                $key = 0;
                foreach ($time_cuoituan_phu_troi_checkout_dem as $time) {
                    $cuoituan_phuTroiCheckoutDem[$time] = (int) $cuoituan_phu_troi_checkout_dem[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_cuoi_tuan']['phu_troi_checkout_dem'] = $cuoituan_phuTroiCheckoutDem;

                $time_cuoituan_phu_troi_checkin_ngay = $dataSend['time_cuoituan_phu_troi_checkin_ngay'];
                $cuoituan_phu_troi_checkin_ngay = $dataSend['cuoituan_phu_troi_checkin_ngay'];
                $key = 0;
                foreach ($time_cuoituan_phu_troi_checkin_ngay as $time) {
                    $cuoituan_phuTroiCheckinNgay[$time] = (int) $cuoituan_phu_troi_checkin_ngay[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_cuoi_tuan']['phu_troi_checkin_ngay'] = $cuoituan_phuTroiCheckinNgay;

                $time_cuoituan_phu_troi_checkin_dem = $dataSend['time_cuoituan_phu_troi_checkin_dem'];
                $cuoituan_phu_troi_checkin_dem = $dataSend['cuoituan_phu_troi_checkin_dem'];
                $key = 0;
                foreach ($time_cuoituan_phu_troi_checkin_dem as $time) {
                    $cuoituan_phuTroiCheckinDem[$time] = (int) $cuoituan_phu_troi_checkin_dem[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_cuoi_tuan']['phu_troi_checkin_dem'] = $cuoituan_phuTroiCheckinDem;

                $save['TypeRoom']['ngay_cuoi_tuan']['phu_troi_them_khach'] = (int) $dataSend['cuoituan_phu_troi_them_khach'];

                if (!empty($dataSend['note'])) {
                    $save['TypeRoom']['ngay_cuoi_tuan']['note'] = $dataSend['cuoituan_note'];
                }
            }

            //ngay le
            if(isset($dataSend['ngayle_nhu_ngaythuong']) && $dataSend['ngayle_nhu_ngaythuong']==1){
                $save['TypeRoom']['ngay_le']= $save['TypeRoom']['ngay_thuong'];
            }else{
                $save['TypeRoom']['ngay_le']['gia_ngay'] = (int) $dataSend['gia_ngay_le'];
                $save['TypeRoom']['ngay_le']['gia_qua_dem'] = (int) $dataSend['gia_qua_dem_ngay_le'];
                $save['TypeRoom']['ngay_le']['gio_qua_dem_start'] = (int) $dataSend['gio_qua_dem_ngay_le_start'];
                $save['TypeRoom']['ngay_le']['gio_qua_dem_end'] = (int) $dataSend['gio_qua_dem_ngay_le_end'];

                $time_ngayle_gia_theo_gio = $dataSend['time_ngayle_gia_theo_gio'];
                $ngayle_gia_theo_gio = $dataSend['ngayle_gia_theo_gio'];
                $key = 0;
                foreach ($time_ngayle_gia_theo_gio as $time) {
                    $ngayle_giaTheoGio[$time] = (int) $ngayle_gia_theo_gio[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_le']['gia_theo_gio'] = $ngayle_giaTheoGio;

                $time_ngayle_phu_troi_checkout_ngay = $dataSend['time_ngayle_phu_troi_checkout_ngay'];
                $ngayle_phu_troi_checkout_ngay = $dataSend['ngayle_phu_troi_checkout_ngay'];
                $key = 0;
                foreach ($time_ngayle_phu_troi_checkout_ngay as $time) {
                    $ngayle_phuTroiCheckoutNgay[$time] = (int) $ngayle_phu_troi_checkout_ngay[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_le']['phu_troi_checkout_ngay'] = $ngayle_phuTroiCheckoutNgay;

                $time_ngayle_phu_troi_checkout_dem = $dataSend['time_ngayle_phu_troi_checkout_dem'];
                $ngayle_phu_troi_checkout_dem = $dataSend['ngayle_phu_troi_checkout_dem'];
                $key = 0;
                foreach ($time_ngayle_phu_troi_checkout_dem as $time) {
                    $ngayle_phuTroiCheckoutDem[$time] = (int) $ngayle_phu_troi_checkout_dem[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_le']['phu_troi_checkout_dem'] = $ngayle_phuTroiCheckoutDem;

                $time_ngayle_phu_troi_checkin_ngay = $dataSend['time_ngayle_phu_troi_checkin_ngay'];
                $ngayle_phu_troi_checkin_ngay = $dataSend['ngayle_phu_troi_checkin_ngay'];
                $key = 0;
                foreach ($time_ngayle_phu_troi_checkin_ngay as $time) {
                    $ngayle_phuTroiCheckinNgay[$time] = (int) $ngayle_phu_troi_checkin_ngay[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_le']['phu_troi_checkin_ngay'] = $ngayle_phuTroiCheckinNgay;

                $time_ngayle_phu_troi_checkin_dem = $dataSend['time_ngayle_phu_troi_checkin_dem'];
                $ngayle_phu_troi_checkin_dem = $dataSend['ngayle_phu_troi_checkin_dem'];
                $key = 0;
                foreach ($time_ngayle_phu_troi_checkin_dem as $time) {
                    $ngayle_phuTroiCheckinDem[$time] = (int) $ngayle_phu_troi_checkin_dem[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_le']['phu_troi_checkin_dem'] = $ngayle_phuTroiCheckinDem;

                $save['TypeRoom']['ngay_le']['phu_troi_them_khach'] = (int) $dataSend['ngayle_phu_troi_them_khach'];

                if (!empty($dataSend['note'])) {
                    $save['TypeRoom']['ngay_le']['note'] = $dataSend['ngayle_note'];
                }
            }
            
            //hang hoa
            $save['TypeRoom']['hang_hoa'] = array();
            
            if(!empty($dataSend['mechan'])){
                $dem = -1;
                foreach ($dataSend['mechan'] as $mechanId) {
                    $dem++;
                    if ($dataSend['countMechan'][$dem] > 0)
                        $save['TypeRoom']['hang_hoa'][$mechanId] = (int) $dataSend['countMechan'][$dem];
                }
            }

            if ($modelTypeRoom->save($save)) {
                $modelTypeRoom->redirect($urlHomes . 'managerListTypeRoom?status=1');
            } else {
                $modelTypeRoom->redirect($urlHomes . 'managerListTypeRoom?status=-1');
            }
            
        }

        setVariable('mess', $mess);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Sửa loại phòng
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerEditTypeRoom($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    if (checkLoginManager()) {
        $modelTypeRoom = new TypeRoom();
        $data = $modelTypeRoom->getTypeRoom($_GET['id']);
        // Lay danh sach hang hoa
        $modelMerchandise = new Merchandise();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();
        if (!empty($_SESSION['idHotel'])) {
            $conditions['idHotel'] = $_SESSION['idHotel'];
        }
        $listDataMerchandise = $modelMerchandise->getPage($page, null, $conditions);
        // Lay danh sach loai hang hoa
        $page = 1;
        $limit = null;
        $conditions = array();
        if (!empty($_SESSION['idHotel'])) {
            $conditions['idHotel'] = $_SESSION['idHotel'];
        }
        $modelMerchandiseGroup = new MerchandiseGroup();
        $listMerchandiseGroup = $modelMerchandiseGroup->getPage($page, $limit, $conditions);
        $array = array();
        foreach ($listMerchandiseGroup as $value) {
            $array[$value['MerchandiseGroup']['id']] = $value['MerchandiseGroup']['name'];
        }
        setVariable('listDataMerchandise', $listDataMerchandise);
        setVariable('listMerchandiseGroup', $array);
        //ebug ($listDataMerchandise);
        if ($isRequestPost) {

            $dataSend = arrayMap($input['request']->data);
            if (!empty($dataSend['desc'])) {
                $save['TypeRoom']['desc'] = $dataSend['desc'];
            }
            $save['TypeRoom']['roomtype'] = $dataSend['roomtype'];
            $save['TypeRoom']['so_giuong'] = (int) $dataSend['so_giuong'];
            $save['TypeRoom']['so_nguoi'] = (int) $dataSend['so_nguoi'];
            $save['TypeRoom']['image'] = $dataSend['image'];
            $save['TypeRoom']['idHotel'] = $_SESSION['idHotel'];
            $save['TypeRoom']['ngayle_nhu_ngaythuong'] = (isset($dataSend['ngayle_nhu_ngaythuong']))? (int) $dataSend['ngayle_nhu_ngaythuong']:0;
            $save['TypeRoom']['ngaycuoituan_nhu_ngaythuong'] = (isset($dataSend['ngaycuoituan_nhu_ngaythuong']))? (int) $dataSend['ngaycuoituan_nhu_ngaythuong']:0;
            
            //ngay thuong

            $save['TypeRoom']['ngay_thuong']['gia_ngay'] = (int) $dataSend['gia_ngay_thuong'];
            $save['TypeRoom']['ngay_thuong']['gia_qua_dem'] = (int) $dataSend['gia_qua_dem_ngay_thuong'];
            $save['TypeRoom']['ngay_thuong']['gio_qua_dem_start'] = (int) $dataSend['gio_qua_dem_ngay_thuong_start'];
            $save['TypeRoom']['ngay_thuong']['gio_qua_dem_end'] = (int) $dataSend['gio_qua_dem_ngay_thuong_end'];

            $time_gia_theo_gio = $dataSend['time_gia_theo_gio'];
            $gia_theo_gio = $dataSend['gia_theo_gio'];
            $key = 0;
            foreach ($time_gia_theo_gio as $time) {
                $giaTheoGio[$time] = (int) $gia_theo_gio[$key];
                $key++;
            }
            $save['TypeRoom']['ngay_thuong']['gia_theo_gio'] = $giaTheoGio;

            $time_phu_troi_checkout_ngay = $dataSend['time_phu_troi_checkout_ngay'];
            $phu_troi_checkout_ngay = $dataSend['phu_troi_checkout_ngay'];
            $key = 0;
            foreach ($time_phu_troi_checkout_ngay as $time) {
                $phuTroiCheckoutNgay[$time] = (int) $phu_troi_checkout_ngay[$key];
                $key++;
            }
            $save['TypeRoom']['ngay_thuong']['phu_troi_checkout_ngay'] = $phuTroiCheckoutNgay;

            $time_phu_troi_checkout_dem = $dataSend['time_phu_troi_checkout_dem'];
            $phu_troi_checkout_dem = $dataSend['phu_troi_checkout_dem'];
            $key = 0;
            foreach ($time_phu_troi_checkout_dem as $time) {
                $phuTroiCheckoutDem[$time] = (int) $phu_troi_checkout_dem[$key];
                $key++;
            }
            $save['TypeRoom']['ngay_thuong']['phu_troi_checkout_dem'] = $phuTroiCheckoutDem;

            $time_phu_troi_checkin_ngay = $dataSend['time_phu_troi_checkin_ngay'];
            $phu_troi_checkin_ngay = $dataSend['phu_troi_checkin_ngay'];
            $key = 0;
            foreach ($time_phu_troi_checkin_ngay as $time) {
                $phuTroiCheckinNgay[$time] = (int) $phu_troi_checkin_ngay[$key];
                $key++;
            }
            $save['TypeRoom']['ngay_thuong']['phu_troi_checkin_ngay'] = $phuTroiCheckinNgay;

            $time_phu_troi_checkin_dem = $dataSend['time_phu_troi_checkin_dem'];
            $phu_troi_checkin_dem = $dataSend['phu_troi_checkin_dem'];
            $key = 0;
            foreach ($time_phu_troi_checkin_dem as $time) {
                $phuTroiCheckinDem[$time] = (int) $phu_troi_checkin_dem[$key];
                $key++;
            }
            $save['TypeRoom']['ngay_thuong']['phu_troi_checkin_dem'] = $phuTroiCheckinDem;

            $save['TypeRoom']['ngay_thuong']['phu_troi_them_khach'] = (int) $dataSend['phu_troi_them_khach'];

            if (!empty($dataSend['note'])) {
                $save['TypeRoom']['ngay_thuong']['note'] = $dataSend['note'];
            }
            
            //ngay cuoi tuan
            if(isset($dataSend['ngaycuoituan_nhu_ngaythuong']) && $dataSend['ngaycuoituan_nhu_ngaythuong']==1){
                $save['TypeRoom']['ngay_cuoi_tuan']= $save['TypeRoom']['ngay_thuong'];
            }else{
                $save['TypeRoom']['ngay_cuoi_tuan']['gia_ngay'] = (int) $dataSend['gia_ngay_cuoi_tuan'];
                $save['TypeRoom']['ngay_cuoi_tuan']['gia_qua_dem'] = (int) $dataSend['gia_qua_dem_ngay_cuoi_tuan'];
                $save['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_start'] = (int) $dataSend['gio_qua_dem_ngay_cuoi_tuan_start'];
                $save['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end'] = (int) $dataSend['gio_qua_dem_ngay_cuoi_tuan_end'];

                $time_cuoituan_gia_theo_gio = $dataSend['time_cuoituan_gia_theo_gio'];
                $cuoituan_gia_theo_gio = $dataSend['cuoituan_gia_theo_gio'];
                $key = 0;
                foreach ($time_cuoituan_gia_theo_gio as $time) {
                    $cuoituan_giaTheoGio[$time] = (int) $cuoituan_gia_theo_gio[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_cuoi_tuan']['gia_theo_gio'] = $cuoituan_giaTheoGio;

                $time_cuoituan_phu_troi_checkout_ngay = $dataSend['time_cuoituan_phu_troi_checkout_ngay'];
                $cuoituan_phu_troi_checkout_ngay = $dataSend['cuoituan_phu_troi_checkout_ngay'];
                $key = 0;
                foreach ($time_cuoituan_phu_troi_checkout_ngay as $time) {
                    $cuoituan_phuTroiCheckoutNgay[$time] = (int) $cuoituan_phu_troi_checkout_ngay[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_cuoi_tuan']['phu_troi_checkout_ngay'] = $cuoituan_phuTroiCheckoutNgay;

                $time_cuoituan_phu_troi_checkout_dem = $dataSend['time_cuoituan_phu_troi_checkout_dem'];
                $cuoituan_phu_troi_checkout_dem = $dataSend['cuoituan_phu_troi_checkout_dem'];
                $key = 0;
                foreach ($time_cuoituan_phu_troi_checkout_dem as $time) {
                    $cuoituan_phuTroiCheckoutDem[$time] = (int) $cuoituan_phu_troi_checkout_dem[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_cuoi_tuan']['phu_troi_checkout_dem'] = $cuoituan_phuTroiCheckoutDem;

                $time_cuoituan_phu_troi_checkin_ngay = $dataSend['time_cuoituan_phu_troi_checkin_ngay'];
                $cuoituan_phu_troi_checkin_ngay = $dataSend['cuoituan_phu_troi_checkin_ngay'];
                $key = 0;
                foreach ($time_cuoituan_phu_troi_checkin_ngay as $time) {
                    $cuoituan_phuTroiCheckinNgay[$time] = (int) $cuoituan_phu_troi_checkin_ngay[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_cuoi_tuan']['phu_troi_checkin_ngay'] = $cuoituan_phuTroiCheckinNgay;

                $time_cuoituan_phu_troi_checkin_dem = $dataSend['time_cuoituan_phu_troi_checkin_dem'];
                $cuoituan_phu_troi_checkin_dem = $dataSend['cuoituan_phu_troi_checkin_dem'];
                $key = 0;
                foreach ($time_cuoituan_phu_troi_checkin_dem as $time) {
                    $cuoituan_phuTroiCheckinDem[$time] = (int) $cuoituan_phu_troi_checkin_dem[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_cuoi_tuan']['phu_troi_checkin_dem'] = $cuoituan_phuTroiCheckinDem;

                $save['TypeRoom']['ngay_cuoi_tuan']['phu_troi_them_khach'] = (int) $dataSend['cuoituan_phu_troi_them_khach'];

                if (!empty($dataSend['note'])) {
                    $save['TypeRoom']['ngay_cuoi_tuan']['note'] = $dataSend['cuoituan_note'];
                }
            }

            //ngay le
            if(isset($dataSend['ngayle_nhu_ngaythuong']) && $dataSend['ngayle_nhu_ngaythuong']==1){
                $save['TypeRoom']['ngay_le']= $save['TypeRoom']['ngay_thuong'];
            }else{
                $save['TypeRoom']['ngay_le']['gia_ngay'] = (int) $dataSend['gia_ngay_le'];
                $save['TypeRoom']['ngay_le']['gia_qua_dem'] = (int) $dataSend['gia_qua_dem_ngay_le'];
                $save['TypeRoom']['ngay_le']['gio_qua_dem_start'] = (int) $dataSend['gio_qua_dem_ngay_le_start'];
                $save['TypeRoom']['ngay_le']['gio_qua_dem_end'] = (int) $dataSend['gio_qua_dem_ngay_le_end'];

                $time_ngayle_gia_theo_gio = $dataSend['time_ngayle_gia_theo_gio'];
                $ngayle_gia_theo_gio = $dataSend['ngayle_gia_theo_gio'];
                $key = 0;
                foreach ($time_ngayle_gia_theo_gio as $time) {
                    $ngayle_giaTheoGio[$time] = (int) $ngayle_gia_theo_gio[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_le']['gia_theo_gio'] = $ngayle_giaTheoGio;

                $time_ngayle_phu_troi_checkout_ngay = $dataSend['time_ngayle_phu_troi_checkout_ngay'];
                $ngayle_phu_troi_checkout_ngay = $dataSend['ngayle_phu_troi_checkout_ngay'];
                $key = 0;
                foreach ($time_ngayle_phu_troi_checkout_ngay as $time) {
                    $ngayle_phuTroiCheckoutNgay[$time] = (int) $ngayle_phu_troi_checkout_ngay[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_le']['phu_troi_checkout_ngay'] = $ngayle_phuTroiCheckoutNgay;

                $time_ngayle_phu_troi_checkout_dem = $dataSend['time_ngayle_phu_troi_checkout_dem'];
                $ngayle_phu_troi_checkout_dem = $dataSend['ngayle_phu_troi_checkout_dem'];
                $key = 0;
                foreach ($time_ngayle_phu_troi_checkout_dem as $time) {
                    $ngayle_phuTroiCheckoutDem[$time] = (int) $ngayle_phu_troi_checkout_dem[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_le']['phu_troi_checkout_dem'] = $ngayle_phuTroiCheckoutDem;

                $time_ngayle_phu_troi_checkin_ngay = $dataSend['time_ngayle_phu_troi_checkin_ngay'];
                $ngayle_phu_troi_checkin_ngay = $dataSend['ngayle_phu_troi_checkin_ngay'];
                $key = 0;
                foreach ($time_ngayle_phu_troi_checkin_ngay as $time) {
                    $ngayle_phuTroiCheckinNgay[$time] = (int) $ngayle_phu_troi_checkin_ngay[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_le']['phu_troi_checkin_ngay'] = $ngayle_phuTroiCheckinNgay;

                $time_ngayle_phu_troi_checkin_dem = $dataSend['time_ngayle_phu_troi_checkin_dem'];
                $ngayle_phu_troi_checkin_dem = $dataSend['ngayle_phu_troi_checkin_dem'];
                $key = 0;
                foreach ($time_ngayle_phu_troi_checkin_dem as $time) {
                    $ngayle_phuTroiCheckinDem[$time] = (int) $ngayle_phu_troi_checkin_dem[$key];
                    $key++;
                }
                $save['TypeRoom']['ngay_le']['phu_troi_checkin_dem'] = $ngayle_phuTroiCheckinDem;

                $save['TypeRoom']['ngay_le']['phu_troi_them_khach'] = (int) $dataSend['ngayle_phu_troi_them_khach'];

                if (!empty($dataSend['note'])) {
                    $save['TypeRoom']['ngay_le']['note'] = $dataSend['ngayle_note'];
                }
            }
            
            //hang hoa
            $save['TypeRoom']['hang_hoa'] = array();
            $dem = -1;
            if (!empty($dataSend['mechan'])) {
                foreach ($dataSend['mechan'] as $mechanId) {
                    $dem++;
                    if ($dataSend['countMechan'][$dem] > 0)
                        $save['TypeRoom']['hang_hoa'][$mechanId] = (int) $dataSend['countMechan'][$dem];
                }
            }
            $dk['_id'] = new MongoId($_GET['id']);

            if ($modelTypeRoom->updateAll($save['TypeRoom'], $dk)) {
                $modelTypeRoom->redirect($urlHomes . 'managerListTypeRoom?status=3');
            } else {
                $modelTypeRoom->redirect($urlHomes . 'managerListTypeRoom?status=-3');
            }
        }

        setVariable('data', $data);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Xóa loại phòng
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerDeleteTypeRoom($input) {
    global $modelOption;
    global $urlHomes;

    if (checkLoginManager()) {
        $modelTypeRoom = new TypeRoom();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelTypeRoom->delete($idDelete);
        }
        $modelTypeRoom->redirect($urlHomes . 'managerListTypeRoom?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

?>