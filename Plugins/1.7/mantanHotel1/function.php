<?php

$menus = array();
$menus[0]['title'] = 'Quản lý khách sạn';

$menus[0]['sub'][0] = array('name' => 'Danh sách khách sạn', 'url' => $urlPlugins . 'admin/mantanHotel-admin-hotel-listHotelAdmin.php','permission'=>'listHotelAdmin');
$menus[0]['sub'][1] = array('name' => 'Danh sách đặt phòng', 'url' => $urlPlugins . 'admin/mantanHotel-admin-book-listBookAdmin.php','permission'=>'listBookAdmin'); 
$menus[0]['sub'][2] = array('name' => 'Danh sách khách hàng', 'url' => $urlPlugins . 'admin/mantanHotel-admin-custom-listCustomAdmin.php','permission'=>'listCustomAdmin');
$menus[0]['sub'][3] = array('name' => 'Danh sách tỉnh thành', 'url' => $urlPlugins . 'admin/mantanHotel-admin-city-listCityAdmin.php','permission'=>'listCityAdmin');
$menus[0]['sub'][4] = array('name' => 'Danh sách tiện nghi', 'url' => $urlPlugins . 'admin/mantanHotel-admin-furniture-listFurnitureAdmin.php','permission'=>'listFurnitureAdmin');
$menus[0]['sub'][5] = array('name' => 'Danh sách vị trí', 'url' => $urlPlugins . 'admin/mantanHotel-admin-location-listLocationAdmin.php','permission'=>'listLocationAdmin');
$menus[0]['sub'][6] = array('name' => 'Tài khoản quản trị khách sạn', 'url' => $urlPlugins . 'admin/mantanHotel-admin-manager-listManager.php','permission'=>'listManager');
$menus[0]['sub'][7] = array('name' => 'Tài khoản người dùng', 'url' => $urlPlugins . 'admin/mantanHotel-admin-user-listUserAdmin.php','permission'=>'listUserAdmin');
$menus[0]['sub'][8] = array('name' => 'Danh sách loại khách sạn', 'url' => $urlPlugins . 'admin/mantanHotel-admin-hotel-listHotelTypes.php','permission'=>'listHotelTypes');
$menus[0]['sub'][9] = array('name' => 'Danh sách tiêu chí bình chọn', 'url' => $urlPlugins . 'admin/mantanHotel-admin-hotel-listCriteriaVote.php','permission'=>'listCriteriaVote');
$menus[0]['sub'][10] = array('name' => 'Danh sách yêu cầu báo giá', 'url' => $urlPlugins . 'admin/mantanHotel-admin-request-ListRequest.php','permission'=>'ListRequest');
$menus[0]['sub'][11] = array('name' => 'Danh sách khách sạn đặt phòng', 'url' => $urlPlugins . 'admin/mantanHotel-admin-order-ListOrder.php','permission'=>'ListOrder');

addMenuAdminMantan($menus);

$category = array(array('title' => 'Mantan Hotel',
        'sub' => array(array(
                'url' => '/bestHotel',
                'name' => 'Khách sạn tốt nhất'
            ),
            array(
                'url' => '/newHotel',
                'name' => 'Khách sạn mới nhất'
            ),
            array(
                'url' => '/requestHotel',
                'name' => 'Yêu cầu báo giá'
            ),
        )
    )
);
addMenusAppearance($category);

global $typeRegister;
global $statusPay;
global $typeDate;
global $typeCollectionBill;
global $typeBill;
global $optionPrice;

$typeRegister = array(//'linh_hoat'=>'Linh hoạt',
    'gia_theo_gio' => 'Theo giờ',
    'gia_qua_dem' => 'Qua đêm',
    'gia_theo_ngay' => 'Theo ngày'
);
$statusPay = array('da_thanh_toan' => 'Đã thanh toán',
    'cong_no' => 'Đưa vào công nợ',
    //'chuyen_phong'=>'Chuyển hóa đơn vào phòng khác'
);
$typeDate = array('ngay_thuong' => 'Ngày thường',
    'ngay_cuoi_tuan' => 'Ngày cuối tuần',
    'ngay_le' => 'Ngày lễ'
);
$typeCollectionBill = array('tien_mat' => 'Tiền mặt',
    'chuyen_khoan' => 'Chuyển khoản',
    'the_tin_dung' => 'Thẻ tín dụng',
    'hinh_thuc_khac' => 'Hình thức khác'
);
$typeBill = array('tien_mat' => 'Tiền mặt',
    'chuyen_khoan' => 'Chuyển khoản',
    'the_tin_dung' => 'Thẻ tín dụng',
    'cong_no' => 'Công nợ',
    'hinh_thuc_khac' => 'Hình thức khác'
);
$optionPrice = array('0-100000' => 'Dưới 100.000đ',
    '100000-200000' => '100.000đ đến 200.000đ',
    '200000-300000' => '200.000đ đến 300.000đ',
    '300000-400000' => '300.000đ đến 400.000đ',
    '400000-500000' => '400.000đ đến 500.000đ',
    '500000-600000' => '500.000đ đến 600.000đ',
    '600000-700000' => '600.000đ đến 700.000đ',
    '700000-800000' => '700.000đ đến 800.000đ',
    '800000-900000' => '800.000đ đến 900.000đ',
    '900000-1000000' => '900.000đ đến 1.000.000đ',
    '1000000-1000000000' => 'Trên 1.000.000đ',
);

function getLinkHotelDetail($hotel) {
    global $urlHomes;
    if (isset($hotel['Hotel']['slug'])) {
        return $urlHomes . 'hotel/' . $hotel['Hotel']['slug'] . '.html';
    } else {
        return '';
    }
}

function getListPermissionAdvanced()
{
    return array(   'editCheckoutBar'=>'Sửa thông tin hóa đơn khi trả bàn quán Bar',
                    'editCheckoutRestaurant'=>'Sửa thông tin hóa đơn khi trả bàn nhà hàng',
                    'editCollectionBill'=>'Sửa thông tin phiếu thu',
                    'deleteCollectionBill'=>'Xóa phiếu thu',
                    'editBill'=>'Sửa thông tin phiếu chi',
                    'deleteBill'=>'Xóa phiếu chi',
                );
}
function getMenuSidebarLeftManager() {
    global $urlHomes;
    return array(
        array('icon' => 'fa-bed', 'name' => 'Quản lý khách sạn', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Sơ đồ khách sạn', 'link' => $urlHomes . 'managerHotelDiagram', 'permission' => 'managerHotelDiagram'),
                array('icon' => '', 'name' => 'Danh sách tầng', 'link' => $urlHomes . 'managerListFloor', 'permission' => 'managerListFloor'),
                array('icon' => '', 'name' => 'Danh sách loại phòng', 'link' => $urlHomes . 'managerListTypeRoom', 'permission' => 'managerListTypeRoom'),
                array('icon' => '', 'name' => 'Thêm phòng', 'link' => $urlHomes . 'managerAddRoom', 'permission' => 'managerAddRoom'),
                array('icon' => '', 'name' => 'Danh sách Ngày lễ', 'link' => $urlHomes . 'managerListHoliday', 'permission' => 'managerListHoliday'),
            )
        ),
        array('icon' => 'fa-beer', 'name' => 'Quản lý Bar', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Sơ đồ quán bar', 'link' => $urlHomes . 'managerBarDiagram', 'permission' => 'managerBarDiagram'),
                array('icon' => '', 'name' => 'Danh sách tầng Bar', 'link' => $urlHomes . 'managerListBarFloor', 'permission' => 'managerListBarFloor'),
                array('icon' => '', 'name' => 'Thêm bàn Bar', 'link' => $urlHomes . 'managerAddBarTable', 'permission' => 'managerAddBarTable')
            )
        ),
        array('icon' => 'fa-coffee', 'name' => 'Quản lý nhà hàng', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Sơ đồ nhà hàng', 'link' => $urlHomes . 'managerRestaurantDiagram', 'permission' => 'managerRestaurantDiagram'),
                array('icon' => '', 'name' => 'Danh sách tầng nhà hàng', 'link' => $urlHomes . 'managerListRestaurantFloor', 'permission' => 'managerListRestaurantFloor'),
                array('icon' => '', 'name' => 'Thêm bàn nhà hàng', 'link' => $urlHomes . 'managerAddTableRestaurant', 'permission' => 'managerAddTableRestaurant')
            )
        ),
        array('icon' => 'fa-video-camera', 'name' => 'Xem camera', 'link' => $urlHomes . 'managerHotelCamera', 'permission' => 'managerHotelCamera'),
        array('icon' => 'fa-sitemap', 'name' => 'Danh sách khách sạn', 'link' => $urlHomes . 'managerListHotel', 'permission' => 'managerListHotel'),
        array('icon' => 'fa-calendar', 'name' => 'Người dùng đặt phòng', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Tất cả đơn hàng', 'link' => $urlHomes . 'managerListOrder', 'permission' => 'managerListOrder'),
                array('icon' => '', 'name' => 'Chưa xử lý', 'link' => $urlHomes . 'managerListOrderPending', 'permission' => 'managerListOrderPending'),
                array('icon' => '', 'name' => 'Đã xếp phòng', 'link' => $urlHomes . 'managerListOrderProcess', 'permission' => 'managerListOrderProcess')
            )
        ),
        array('icon' => 'fa-question-circle', 'name' => 'Khách yêu cầu báo giá', 'link' => $urlHomes . 'managerListRequest', 'permission' => 'managerListRequest'),
        array('icon' => 'fa-book', 'name' => 'Khuyến mại', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Danh sách khuyến mại', 'link' => $urlHomes . 'managerListPromotion', 'permission' => 'managerListPromotion'),
                array('icon' => '', 'name' => 'Thêm khuyến mại', 'link' => $urlHomes . 'managerAddPromotion', 'permission' => 'managerAddPromotion')
            )
        ),
        array('icon' => 'fa-suitcase', 'name' => 'Hàng hóa - Dịch vụ', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Danh sách hàng hóa - dịch vụ', 'link' => $urlHomes . 'managerListMerchandise', 'permission' => 'managerListMerchandise'),
                array('icon' => '', 'name' => 'Thêm hàng hóa - dịch vụ', 'link' => $urlHomes . 'managerAddMerchandise', 'permission' => 'managerAddMerchandise'),
                array('icon' => '', 'name' => 'Thêm số lượng hàng hóa', 'link' => $urlHomes . 'managerAddNumberMerchandise', 'permission' => 'managerAddNumberMerchandise'),
                array('icon' => '', 'name' => 'Bán lẻ hàng hóa', 'link' => $urlHomes . 'managerSellMerchandise', 'permission' => 'managerSellMerchandise'),
                array('icon' => '', 'name' => 'Nhóm hàng hóa - dịch vụ', 'link' => $urlHomes . 'managerListMerchandiseGroup', 'permission' => 'managerListMerchandiseGroup'),
                array('icon' => '', 'name' => 'Thêm nhóm hàng hóa - dịch vụ', 'link' => $urlHomes . 'managerAddMerchandiseGroup', 'permission' => 'managerAddMerchandiseGroup')
            )
        ),
        array('icon' => 'fa-cutlery', 'name' => 'Kho chế biến', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Danh sách nguyên liệu', 'link' => $urlHomes . 'managerListMaterials', 'permission' => 'managerListMaterials'),
                array('icon' => '', 'name' => 'Thêm số lượng nguyên liệu', 'link' => $urlHomes . 'managerAddNumberMaterials', 'permission' => 'managerAddNumberMaterials'),
                array('icon' => '', 'name' => 'Nhóm nguyên liệu', 'link' => $urlHomes . 'managerListMaterialsGroup', 'permission' => 'managerListMaterialsGroup'),
            )
        ),
        array('icon' => 'fa-users', 'name' => 'Nhân viên', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Danh sách nhân viên', 'link' => $urlHomes . 'managerListStaff', 'permission' => 'managerListStaff'),
                array('icon' => '', 'name' => 'Thêm nhân viên', 'link' => $urlHomes . 'managerAddStaff', 'permission' => 'managerAddStaff'),
                array('icon' => '', 'name' => 'Nhóm phân quyền', 'link' => $urlHomes . 'managerListPermission', 'permission' => 'managerListPermission'),
                array('icon' => '', 'name' => 'Thêm nhóm phân quyền', 'link' => $urlHomes . 'managerAddPermission', 'permission' => 'managerAddPermission')
            )
        ),
        array('icon' => 'fa-money', 'name' => 'Quản lý thu/chi', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Danh sách phiếu thu', 'link' => $urlHomes . 'managerListCollectionBill', 'permission' => 'managerListCollectionBill'),
                array('icon' => '', 'name' => 'Thêm phiếu thu', 'link' => $urlHomes . 'managerAddCollectionBill', 'permission' => 'managerAddCollectionBill'),
                array('icon' => '', 'name' => 'Danh sách phiếu chi', 'link' => $urlHomes . 'managerListBill', 'permission' => 'managerListBill'),
                array('icon' => '', 'name' => 'Thêm phiếu chi', 'link' => $urlHomes . 'managerAddBill', 'permission' => 'managerAddBill')
            )
        ),
        array('icon' => 'fa-fax', 'name' => 'Quản lý công nợ', 'link' => '',
            'sub' => array(
            	array('icon' => '', 'name' => 'Công nợ phòng', 'link' => $urlHomes . 'managerLiabilitie', 'permission' => 'managerLiabilitie'),
            	array('icon' => '', 'name' => 'Công nợ bar', 'link' => $urlHomes . 'managerLiabilitieBar', 'permission' => 'managerLiabilitieBar'),
                array('icon' => '', 'name' => 'Công nợ chi', 'link' => $urlHomes . 'managerLiabilitieBill', 'permission' => 'managerLiabilitieBill')
            )
        ),
        array('icon' => 'fa-credit-card', 'name' => 'Quản lý doanh thu', 'link' => '',
            'sub' => array(array('icon' => '', 'name' => 'Doanh thu phòng', 'link' => $urlHomes . 'managerRevenue', 'permission' => 'managerRevenue'),
                array('icon' => '', 'name' => 'Doanh thu hàng hóa', 'link' => $urlHomes . 'managerRevenueMerchandise', 'permission' => 'managerRevenueMerchandise'),
                array('icon' => '', 'name' => 'Doanh thu bar', 'link' => $urlHomes . 'managerRevenueBar', 'permission' => 'managerRevenueBar'),
                array('icon' => '', 'name' => 'Doanh thu nhà hàng', 'link' => $urlHomes . 'managerRevenueRestaurant', 'permission' => 'managerRevenueRestaurant'),
                array('icon' => '', 'name' => 'Doanh thu đại lý', 'link' => $urlHomes . 'managerRevenueAgency', 'permission' => 'managerRevenueAgency'),
            )
        ),
    );
}

// Kiem tra tinh trang dang nhap
function checkLoginManager() {
    global $urlHomes;
    global $isAddHotel;
    $modelHotel = new Hotel();
    if (isset($_SESSION['infoManager'])) {
        if (empty($_SESSION['infoManager']['Manager']['listHotel'])) {
            if (!$isAddHotel && $_SESSION['infoManager']['Manager']['id'] == $_SESSION['infoManager']['Manager']['idStaff']) {
                $modelHotel->redirect($urlHomes . 'managerAddHotel');
            }/* else{
              debug ($isAddHotel);
              debug ($_SESSION['infoManager']['Manager']['id']==$_SESSION['infoManager']['Manager']['idStaff']);
              $modelHotel->redirect($urlHomes.'managerLogout');
              } */
        } else {
            foreach ($_SESSION['infoManager']['Manager']['listHotel'] as $idHotel) {
                $hotel = $modelHotel->getHotel($idHotel);
                if ($hotel) {
                    $listHotel[] = $hotel;
                }
            }
            setVariable('listHotel', $listHotel);

            if (!isset($_SESSION['idHotel'])) {
                $modelHotel->redirect($urlHomes . 'managerSelectHotel');
            }
        }
    }
    return isset($_SESSION['infoManager']);
}

function filterData(&$str) {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"'))
        $str = '"' . str_replace('"', '""', $str) . '"';
}

function convert_number_to_words($number) 
{
 
    $hyphen      = ' ';
    $conjunction = '  ';
    $separator   = ' ';
    $negative    = 'âm ';
    $decimal     = ' phẩy ';
    $dictionary  = array(
    0                   => 'Không',
    1                   => 'Một',
    2                   => 'Hai',
    3                   => 'Ba',
    4                   => 'Bốn',
    5                   => 'Năm',
    6                   => 'Sáu',
    7                   => 'Bảy',
    8                   => 'Tám',
    9                   => 'Chín',
    10                  => 'Mười',
    11                  => 'Mười một',
    12                  => 'Mười hai',
    13                  => 'Mười ba',
    14                  => 'Mười bốn',
    15                  => 'Mười năm',
    16                  => 'Mười sáu',
    17                  => 'Mười bảy',
    18                  => 'Mười tám',
    19                  => 'Mười chín',
    20                  => 'Hai mươi',
    30                  => 'Ba mươi',
    40                  => 'Bốn mươi',
    50                  => 'Năm mươi',
    60                  => 'Sáu mươi',
    70                  => 'Bảy mươi',
    80                  => 'Tám mươi',
    90                  => 'Chín mươi',
    100                 => 'trăm',
    1000                => 'ngàn',
    1000000             => 'triệu',
    1000000000          => 'tỷ',
    1000000000000       => 'nghìn tỷ',
    1000000000000000    => 'ngàn triệu triệu',
    1000000000000000000 => 'tỷ tỷ'
    );
     
    if (!is_numeric($number)) {
    return false;
    }
     
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
    // overflow
    trigger_error(
    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
    E_USER_WARNING
    );
    return false;
    }
     
    if ($number < 0) {
    return $negative . convert_number_to_words(abs($number));
    }
     
    $string = $fraction = null;
     
    if (strpos($number, '.') !== false) {
    list($number, $fraction) = explode('.', $number);
    }
     
    switch (true) {
    case $number < 21:
    $string = $dictionary[$number];
    break;
    case $number < 100:
    $tens   = ((int) ($number / 10)) * 10;
    $units  = $number % 10;
    $string = $dictionary[$tens];
    if ($units) {
    $string .= $hyphen . $dictionary[$units];
    }
    break;
    case $number < 1000:
    $hundreds  = $number / 100;
    $remainder = $number % 100;
    $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
    if ($remainder) {
    $string .= $conjunction . convert_number_to_words($remainder);
    }
    break;
    default:
    $baseUnit = pow(1000, floor(log($number, 1000)));
    $numBaseUnits = (int) ($number / $baseUnit);
    $remainder = $number % $baseUnit;
    $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
    if ($remainder) {
    $string .= $remainder < 100 ? $conjunction : $separator;
    $string .= convert_number_to_words($remainder);
    }
    break;
    }
     
    if (null !== $fraction && is_numeric($fraction)) {
    $string .= $decimal;
    $words = array();
    foreach (str_split((string) $fraction) as $number) {
    $words[] = $dictionary[$number];
    }
    $string .= implode(' ', $words);
    }
     
    return $string;
}

function checkTypeDate($today= null)
{
    if($today==null){
        $today= getdate();
    }

    $modelHoliday = new Holiday();

    $typeDate = 'ngay_thuong';
    $weekday = $today['weekday'];

    if ($modelHoliday->checkToday($today[0], $_SESSION['idHotel'])) {
        $typeDate = 'ngay_le';
    } elseif ($weekday == 'Saturday' || $weekday == 'Sunday') {
        $typeDate = 'ngay_cuoi_tuan';
    } else {
        $typeDate = 'ngay_thuong';
    }

    return $typeDate;
}

?>