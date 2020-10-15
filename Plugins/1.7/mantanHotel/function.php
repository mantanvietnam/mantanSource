<?php

$menus = array();
$menus[0]['title'] = 'Quản lý khách sạn';

$menus[0]['sub'][0] = array('name' => 'Danh sách khách sạn', 'url' => $urlPlugins . 'admin/mantanHotel-admin-hotel-listHotelAdmin.php','permission'=>'listHotelAdmin');
//$menus[0]['sub'][1] = array('name' => 'Danh sách đặt phòng', 'url' => $urlPlugins . 'admin/mantanHotel-admin-book-listBookAdmin.php','permission'=>'listBookAdmin'); 
$menus[0]['sub'][2] = array('name' => 'Danh sách khách hàng', 'url' => $urlPlugins . 'admin/mantanHotel-admin-custom-listCustomAdmin.php','permission'=>'listCustomAdmin');
$menus[0]['sub'][3] = array('name' => 'Danh sách tỉnh thành', 'url' => $urlPlugins . 'admin/mantanHotel-admin-city-listCityAdmin.php','permission'=>'listCityAdmin');
$menus[0]['sub'][4] = array('name' => 'Danh sách tiện nghi', 'url' => $urlPlugins . 'admin/mantanHotel-admin-furniture-listFurnitureAdmin.php','permission'=>'listFurnitureAdmin');

$menus[0]['sub'][6] = array('name' => 'Tài khoản quản trị khách sạn', 'url' => $urlPlugins . 'admin/mantanHotel-admin-manager-listManager.php','permission'=>'listManager');
$menus[0]['sub'][7] = array('name' => 'Tài khoản người dùng', 'url' => $urlPlugins . 'admin/mantanHotel-admin-user-listUserAdmin.php','permission'=>'listUserAdmin');
$menus[0]['sub'][8] = array('name' => 'Danh sách loại khách sạn', 'url' => $urlPlugins . 'admin/mantanHotel-admin-hotel-listHotelTypes.php','permission'=>'listHotelTypes');
$menus[0]['sub'][9] = array('name' => 'Danh sách tiêu chí bình chọn', 'url' => $urlPlugins . 'admin/mantanHotel-admin-hotel-listCriteriaVote.php','permission'=>'listCriteriaVote');
$menus[0]['sub'][10] = array('name' => 'Danh sách yêu cầu báo giá', 'url' => $urlPlugins . 'admin/mantanHotel-admin-request-ListRequest.php','permission'=>'ListRequest');
$menus[0]['sub'][11] = array('name' => 'Danh sách khách hàng đặt phòng', 'url' => $urlPlugins . 'admin/mantanHotel-admin-order-ListOrder.php','permission'=>'ListOrder');
$menus[0]['sub'][12] = array('name' => 'Sitemap Hotel', 'url' => $urlPlugins . 'admin/mantanHotel-admin-hotel-sitemapHotel.php','permission'=>'sitemapHotel');

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
global $paymentCycle;
global $typeHotelManmo;

$typeRegister = array(//'linh_hoat'=>'Linh hoạt',
    'gia_theo_gio' => 'Theo giờ',
    'gia_qua_dem' => 'Qua đêm',
    'gia_theo_ngay' => 'Theo ngày',
    'gia_thang' => 'Theo tháng',
    'gia_nam' => 'Theo năm',
);
$typeHotelManmo = array(
    '1' => array('id'=>1,'name'=>'Nhà nghỉ','code'=>'motel'),
    '2' => array('id'=>2,'name'=>'Khách sạn 1 sao','code'=>'hotel1star'),
    '3' => array('id'=>3,'name'=>'Khách sạn 2 sao','code'=>'hotel2star'),
    '4' => array('id'=>4,'name'=>'Khách sạn 3 sao','code'=>'hotel3star'),
    '5' => array('id'=>5,'name'=>'Khách sạn 4 sao','code'=>'hotel4star'),
    '6' => array('id'=>6,'name'=>'Khách sạn 5 sao','code'=>'hotel5star'),
    '7' => array('id'=>7,'name'=>'Căn hộ dịch vụ cho thuê','code'=>'house'),
);
$paymentCycle = array(//'linh_hoat'=>'Linh hoạt',
    '1' => 'Thanh toán khi trả phòng',
    '2' => 'Thanh toán hàng ngày',
    '3' => '1 tuần 1 lần',
    '4' => '1 tháng 1 lần',
    '5' => '3 tháng 1 lần',
    '6' => '6 tháng 1 lần',
    '7' => '1 năm 1 lần',
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
    'cong_no' => 'Công nợ',
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

function getSignatureEmail()
{

}

function getGUID()
{
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }
}

function checkStatusRoom($idHotel='')
{
    $modelRoom = new Room();
    $conditions = array('hotel'=>$idHotel,'checkin'=>array('$exists'=>false)); 
    $checkRoom= $modelRoom->find('count',array('conditions'=>$conditions));
    if($checkRoom==0){
        // hết phòng
        return 0;
    }else{
        // còn phòng
        return 1;

    }
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

function getListLocation()
{
    return array(   '1'=>array('id'=>1,'name'=>'Kín đáo'), 
                    '2'=>array('id'=>2,'name'=>'Có chỗ để ôtô'), 
                    '3'=>array('id'=>3,'name'=>'Khu trung tâm'), 
                );
}

function getListFurniture()
{
    return array(   '1'=>array('id'=>1,'name'=>'Máy in','class'=>'fa-print','image'=>'/app/Plugin/mantanHotel/images/print.png'), 
                    '2'=>array('id'=>2,'name'=>'Tivi','class'=>'flaticon-television','image'=>'/app/Plugin/mantanHotel/images/tivi.png'), 
                    '3'=>array('id'=>3,'name'=>'Wifi','class'=>'flaticon-wifi','image'=>'/app/Plugin/mantanHotel/images/wifi.png'),
                    '4'=>array('id'=>4,'name'=>'Giặt là','class'=>'flaticon-hanger','image'=>'/app/Plugin/mantanHotel/images/bullseye.png'),
                    '5'=>array('id'=>5,'name'=>'Điều hòa','class'=>'flaticon-air-conditioner','image'=>'/app/Plugin/mantanHotel/images/podcast.png'),
                    '6'=>array('id'=>6,'name'=>'Thang máy','class'=>'flaticon-elevator','image'=>'/app/Plugin/mantanHotel/images/building.png'),
                    '7'=>array('id'=>7,'name'=>'Chỗ để ôtô','class'=>'flaticon-parking-1','image'=>'/app/Plugin/mantanHotel/images/car.png'),
                    '8'=>array('id'=>8,'name'=>'Nhà hàng','class'=>'flaticon-room-service-1','image'=>'/app/Plugin/mantanHotel/images/beer.png'),
                    '9'=>array('id'=>9,'name'=>'Ăn sáng','class'=>'flaticon-restaurant','image'=>'/app/Plugin/mantanHotel/images/coffee.png'),
                    '10'=>array('id'=>10,'name'=>'Điện thoại','class'=>'flaticon-telephone','image'=>'/app/Plugin/mantanHotel/images/phone.png'),
                    '11'=>array('id'=>11,'name'=>'Tủ quần áo','class'=>'flaticon-bathrobe','image'=>'/app/Plugin/mantanHotel/images/street-view.png'),
                    '12'=>array('id'=>12,'name'=>'Bình cứu hỏa','class'=>'flaticon-fire-extinguisher','image'=>'/app/Plugin/mantanHotel/images/fire-extinguisher.png'), 
                    '13'=>array('id'=>13,'name'=>'Truyền hình cáp','class'=>'flaticon-monitor','image'=>'/app/Plugin/mantanHotel/images/cloud-download.png'), 
                    '14'=>array('id'=>14,'name'=>'Bàn làm việc','class'=>'flaticon-reception','image'=>'/app/Plugin/mantanHotel/images/archive.png'), 
                    '15'=>array('id'=>15,'name'=>'Bồn tắm','class'=>'flaticon-bathtub','image'=>'/app/Plugin/mantanHotel/images/bath.png'), 
                    '16'=>array('id'=>16,'name'=>'Bình nóng lạnh','class'=>'flaticon-safebox','image'=>'/app/Plugin/mantanHotel/images/shower.png'), 
                    '17'=>array('id'=>17,'name'=>'Tủ lạnh','class'=>'fa-random','image'=>'/app/Plugin/mantanHotel/images/random.png'), 
                    '18'=>array('id'=>18,'name'=>'Bàn uống nước','class'=>'fa-archive','image'=>'/app/Plugin/mantanHotel/images/archive.png'), 
                );
}

function getListHotelTypes()
{
    return array(   '1'=>array('id'=>1,'name'=>'Nhà nghỉ'), 
                    '2'=>array('id'=>2,'name'=>'Khách sạn 1 sao'), 
                    '3'=>array('id'=>3,'name'=>'Khách sạn 2 sao'), 
                    '4'=>array('id'=>4,'name'=>'Khách sạn 3 sao'), 
                );
}

function tinhKhoangCach($x,$y,$x1,$y1)
{
    return 100*round(sqrt(($x-$x1)*($x-$x1)+($y-$y1)*($y-$y1)),3).'km';
}

function getListCountry()
{
    return array(   '0'=>array('id'=>0,'name'=>'Việt Nam'), 
                    '1'=>array('id'=>1,'name'=>'Afghanistan'), 
                    '2'=>array('id'=>2,'name'=>'Albania'), 
                    '3'=>array('id'=>3,'name'=>'Algeria'), 
                    '4'=>array('id'=>4,'name'=>'Andorra'), 
                    '5'=>array('id'=>5,'name'=>'Angola'), 
                    '6'=>array('id'=>6,'name'=>'Antigua and Barbuda'), 
                    '7'=>array('id'=>7,'name'=>'Argentina'), 
                    '8'=>array('id'=>8,'name'=>'Armenia'), 
                    '9'=>array('id'=>9,'name'=>'Australia'), 
                    '10'=>array('id'=>10,'name'=>'Austria'), 
                    '11'=>array('id'=>11,'name'=>'Azerbaijan'), 
                    '12'=>array('id'=>12,'name'=>'Bahamas'), 
                    '13'=>array('id'=>13,'name'=>'Bahrain'), 
                    '14'=>array('id'=>14,'name'=>'Bangladesh'), 
                    '15'=>array('id'=>15,'name'=>'Barbados'), 
                    '16'=>array('id'=>16,'name'=>'Belarus'), 
                    '17'=>array('id'=>17,'name'=>'Belgium'), 
                    '18'=>array('id'=>18,'name'=>'Belize'), 
                    '19'=>array('id'=>19,'name'=>'Benin'), 
                    '20'=>array('id'=>20,'name'=>'Bhutan'), 
                    '21'=>array('id'=>21,'name'=>'Bolivia'), 
                    '22'=>array('id'=>22,'name'=>'Bosnia and Herzegovina'), 
                    '23'=>array('id'=>23,'name'=>'Botswana'), 
                    '24'=>array('id'=>24,'name'=>'Brazil'), 
                    '25'=>array('id'=>25,'name'=>'Brunei Darussalam'), 
                    '26'=>array('id'=>26,'name'=>'Bulgaria'), 
                    '27'=>array('id'=>27,'name'=>'Burkina Faso'), 
                    '28'=>array('id'=>28,'name'=>'Burma'), 
                    '29'=>array('id'=>29,'name'=>'Burundi'), 
                    '30'=>array('id'=>30,'name'=>'Cambodia'), 
                    '31'=>array('id'=>31,'name'=>'Cameroon'), 
                    '32'=>array('id'=>32,'name'=>'Canada'), 
                    '33'=>array('id'=>33,'name'=>'Cape Verde'), 
                    '34'=>array('id'=>34,'name'=>'Central African Republic'), 
                    '35'=>array('id'=>35,'name'=>'Chad'), 
                    '36'=>array('id'=>36,'name'=>'Chile'), 
                    '37'=>array('id'=>37,'name'=>'China'), 
                    '38'=>array('id'=>38,'name'=>'Colombia'), 
                    '39'=>array('id'=>39,'name'=>'Comoros'), 
                    '40'=>array('id'=>40,'name'=>'Congo'), 
                    '41'=>array('id'=>41,'name'=>'Costa Rica'), 
                    '42'=>array('id'=>42,'name'=>'Croatia'), 
                    '43'=>array('id'=>43,'name'=>'Cuba'), 
                    '44'=>array('id'=>44,'name'=>'Cyprus'), 
                    '45'=>array('id'=>45,'name'=>'Czech Republic'), 
                    '46'=>array('id'=>46,'name'=>'Denmark'), 
                    '47'=>array('id'=>47,'name'=>'Djibouti'), 
                    '48'=>array('id'=>48,'name'=>'Dominica'), 
                    '49'=>array('id'=>49,'name'=>'Dominican Republic'), 
                    '50'=>array('id'=>50,'name'=>'Ecuador'), 
                    '51'=>array('id'=>51,'name'=>'Egypt'), 
                    '52'=>array('id'=>52,'name'=>'El Salvador'), 
                    '53'=>array('id'=>53,'name'=>'Equatorial Guinea'), 
                    '54'=>array('id'=>54,'name'=>'Eritrea'), 
                    '55'=>array('id'=>55,'name'=>'Estonia'), 
                    '56'=>array('id'=>56,'name'=>'Ethiopia'), 
                    '57'=>array('id'=>57,'name'=>'Fiji'), 
                    '58'=>array('id'=>58,'name'=>'Finland'), 
                    '59'=>array('id'=>59,'name'=>'France'), 
                    '60'=>array('id'=>60,'name'=>'Gabon'), 
                    '61'=>array('id'=>61,'name'=>'Gambia'), 
                    '62'=>array('id'=>62,'name'=>'Georgia'), 
                    '63'=>array('id'=>63,'name'=>'Germany'), 
                    '64'=>array('id'=>64,'name'=>'Ghana'), 
                    '65'=>array('id'=>65,'name'=>'Greece'), 
                    '66'=>array('id'=>66,'name'=>'Grenada'), 
                    '67'=>array('id'=>67,'name'=>'Guatemala'), 
                    '68'=>array('id'=>68,'name'=>'Guinea'), 
                    '69'=>array('id'=>69,'name'=>'Guinea-Bissau'), 
                    '70'=>array('id'=>70,'name'=>'Guyana'), 
                    '71'=>array('id'=>71,'name'=>'Haiti'), 
                    '72'=>array('id'=>72,'name'=>'Honduras'), 
                    '73'=>array('id'=>73,'name'=>'Hungary'), 
                    '74'=>array('id'=>74,'name'=>'Iceland'), 
                    '75'=>array('id'=>75,'name'=>'India'), 
                    '76'=>array('id'=>76,'name'=>'Indonesia'), 
                    '77'=>array('id'=>77,'name'=>'Iran'), 
                    '78'=>array('id'=>78,'name'=>'Iraq'), 
                    '79'=>array('id'=>79,'name'=>'Ireland'), 
                    '80'=>array('id'=>80,'name'=>'Israel'), 
                    '81'=>array('id'=>81,'name'=>'Italy'), 
                    '82'=>array('id'=>82,'name'=>'Jamaica'), 
                    '83'=>array('id'=>83,'name'=>'Japan'), 
                    '84'=>array('id'=>84,'name'=>'Jordan'), 
                    '85'=>array('id'=>85,'name'=>'Kazakhstan'), 
                    '86'=>array('id'=>86,'name'=>'Kenya'), 
                    '87'=>array('id'=>87,'name'=>'Kiribati'), 
                    '88'=>array('id'=>88,'name'=>'Korea, North'), 
                    '89'=>array('id'=>89,'name'=>'Korea, South'), 
                    '90'=>array('id'=>90,'name'=>'Kuwait'), 
                    '91'=>array('id'=>91,'name'=>'Kyrgyzstan'), 
                    '92'=>array('id'=>92,'name'=>'Laos'), 
                    '93'=>array('id'=>93,'name'=>'Latvia'), 
                    '94'=>array('id'=>94,'name'=>'Lebanon'), 
                    '95'=>array('id'=>95,'name'=>'Lesotho'), 
                    '96'=>array('id'=>96,'name'=>'Liberia'), 
                    '97'=>array('id'=>97,'name'=>'Libya'), 
                    '98'=>array('id'=>98,'name'=>'Liechtenstein'), 
                    '99'=>array('id'=>99,'name'=>'Lithuania'), 
                    '100'=>array('id'=>100,'name'=>'Luxembourg'), 
                    '101'=>array('id'=>101,'name'=>'Macedonia'), 
                    '102'=>array('id'=>102,'name'=>'Madagascar'), 
                    '103'=>array('id'=>103,'name'=>'Malawi'), 
                    '104'=>array('id'=>104,'name'=>'Malaysia'), 
                    '105'=>array('id'=>105,'name'=>'Maldives'), 
                    '106'=>array('id'=>106,'name'=>'Mali'), 
                    '107'=>array('id'=>107,'name'=>'Malta'), 
                    '108'=>array('id'=>108,'name'=>'Marshall Islands'), 
                    '109'=>array('id'=>109,'name'=>'Mauritania'), 
                    '110'=>array('id'=>110,'name'=>'Mauritius'), 
                    '111'=>array('id'=>111,'name'=>'Mexico'), 
                    '112'=>array('id'=>112,'name'=>'Micronesia'), 
                    '113'=>array('id'=>113,'name'=>'Moldova'), 
                    '114'=>array('id'=>114,'name'=>'Monaco'), 
                    '115'=>array('id'=>115,'name'=>'Mongolia'), 
                    '116'=>array('id'=>116,'name'=>'Montenegro'), 
                    '117'=>array('id'=>117,'name'=>'Morocco'), 
                    '118'=>array('id'=>118,'name'=>'Mozambique'), 
                    '119'=>array('id'=>119,'name'=>'Myanmar'), 
                    '120'=>array('id'=>120,'name'=>'Namibia'), 
                    '121'=>array('id'=>121,'name'=>'Nauru'), 
                    '122'=>array('id'=>122,'name'=>'Nepal'), 
                    '123'=>array('id'=>123,'name'=>'Netherlands'), 
                    '124'=>array('id'=>124,'name'=>'New Zealand'), 
                    '125'=>array('id'=>125,'name'=>'Nicaragua'), 
                    '126'=>array('id'=>126,'name'=>'Niger'), 
                    '127'=>array('id'=>127,'name'=>'Nigeria'), 
                    '128'=>array('id'=>128,'name'=>'Norway'), 
                    '129'=>array('id'=>129,'name'=>'Oman'), 
                    '130'=>array('id'=>130,'name'=>'Pakistan'), 
                    '131'=>array('id'=>131,'name'=>'Palau'), 
                    '132'=>array('id'=>132,'name'=>'Palestinian'), 
                    '133'=>array('id'=>133,'name'=>'Panama'), 
                    '134'=>array('id'=>134,'name'=>'Papua New Guinea'), 
                    '135'=>array('id'=>135,'name'=>'Paraguay'), 
                    '136'=>array('id'=>136,'name'=>'Peru'), 
                    '137'=>array('id'=>137,'name'=>'Philippines'), 
                    '138'=>array('id'=>138,'name'=>'Poland'), 
                    '139'=>array('id'=>139,'name'=>'Portugal'), 
                    '140'=>array('id'=>140,'name'=>'Qatar'), 
                    '141'=>array('id'=>141,'name'=>'Romania'), 
                    '142'=>array('id'=>142,'name'=>'Russia'), 
                    '143'=>array('id'=>143,'name'=>'Rwanda'), 
                    '144'=>array('id'=>144,'name'=>'St. Kitts and Nevis'), 
                    '145'=>array('id'=>145,'name'=>'St. Lucia'), 
                    '146'=>array('id'=>146,'name'=>'St. Vincent and The Grenadines'), 
                    '147'=>array('id'=>147,'name'=>'Samoa'), 
                    '148'=>array('id'=>148,'name'=>'San Marino'), 
                    '149'=>array('id'=>149,'name'=>'São Tomé and Príncipe'), 
                    '150'=>array('id'=>150,'name'=>'Saudi Arabia'), 
                    '151'=>array('id'=>151,'name'=>'Senegal'), 
                    '152'=>array('id'=>152,'name'=>'Serbia'), 
                    '153'=>array('id'=>153,'name'=>'Seychelles'), 
                    '154'=>array('id'=>154,'name'=>'Sierra Leone'), 
                    '155'=>array('id'=>155,'name'=>'Singapore'), 
                    '156'=>array('id'=>156,'name'=>'Slovakia'), 
                    '157'=>array('id'=>157,'name'=>'Slovenia'), 
                    '158'=>array('id'=>158,'name'=>'Solomon Islands'), 
                    '159'=>array('id'=>159,'name'=>'Somalia'), 
                    '160'=>array('id'=>160,'name'=>'South Africa'), 
                    '161'=>array('id'=>161,'name'=>'Spain'), 
                    '162'=>array('id'=>162,'name'=>'Sri Lanka'), 
                    '163'=>array('id'=>163,'name'=>'Sudan'), 
                    '164'=>array('id'=>164,'name'=>'Suriname'), 
                    '165'=>array('id'=>165,'name'=>'Swaziland'), 
                    '166'=>array('id'=>166,'name'=>'Sweden'), 
                    '167'=>array('id'=>167,'name'=>'Switzerland'), 
                    '168'=>array('id'=>168,'name'=>'Syria'), 
                    '169'=>array('id'=>169,'name'=>'Taiwan'), 
                    '170'=>array('id'=>170,'name'=>'Tajikistan'), 
                    '171'=>array('id'=>171,'name'=>'Tanzania'), 
                    '172'=>array('id'=>172,'name'=>'Thailand'), 
                    '173'=>array('id'=>173,'name'=>'Togo'), 
                    '174'=>array('id'=>174,'name'=>'Tonga'), 
                    '175'=>array('id'=>175,'name'=>'Trinidad and Tobago'), 
                    '176'=>array('id'=>176,'name'=>'Tunisia'), 
                    '177'=>array('id'=>177,'name'=>'Turkey'), 
                    '178'=>array('id'=>178,'name'=>'Turkmenistan'), 
                    '179'=>array('id'=>179,'name'=>'Tuvalu'), 
                    '180'=>array('id'=>180,'name'=>'Uganda'), 
                    '181'=>array('id'=>181,'name'=>'Ukraine'), 
                    '182'=>array('id'=>182,'name'=>'United Arab Emirates'), 
                    '183'=>array('id'=>183,'name'=>'United Kingdom'), 
                    '184'=>array('id'=>184,'name'=>'United States'), 
                    '185'=>array('id'=>185,'name'=>'Uruguay'), 
                    '186'=>array('id'=>186,'name'=>'Uzbekistan'), 
                    '187'=>array('id'=>187,'name'=>'Vanuatu'), 
                    '188'=>array('id'=>188,'name'=>'Vatican City'), 
                    '189'=>array('id'=>189,'name'=>'Venezuela'), 
                    '191'=>array('id'=>191,'name'=>'Western Sahara'), 
                    '192'=>array('id'=>192,'name'=>'Yemen'), 
                    '193'=>array('id'=>193,'name'=>'Yugoslavia'), 
                    '194'=>array('id'=>194,'name'=>'Zaire'), 
                    '195'=>array('id'=>195,'name'=>'Zambia'), 
                    '196'=>array('id'=>196,'name'=>'Zimbabwe'), 
        );
}

function getListCity()
{
    return array(   
                    '1'=>array('id'=>1,'name'=>'Hà Nội','gps'=>'21.025905,105.846576','bsx'=>array(29,30,31,32,33)),
                    '2'=>array('id'=>2,'name'=>'TP Hồ Chí Minh','gps'=>'10.820645,106.632518','bsx'=>array(50,51,52,53,54,55,56,57,58,59)),
                    '3'=>array('id'=>3,'name'=>'Đà Nẵng','gps'=>'16.053866,108.203836','bsx'=>array(43)),
                    '4'=>array('id'=>4,'name'=>'Hải Phòng','gps'=>'20.843685,106.694454','bsx'=>array(15,16)),
                    '5'=>array('id'=>5,'name'=>'Cần Thơ','gps'=>'10.044264,105.748773','bsx'=>array(65)),

                    '6'=>array('id'=>6,'name'=>'An Giang','gps'=>'10.503183,105.119829','bsx'=>array(67)),
                    '7'=>array('id'=>7,'name'=>'Bà Rịa - Vũng Tàu','gps'=>'10.563561,107.276515','bsx'=>array(72)),
                    '8'=>array('id'=>8,'name'=>'Bắc Giang','gps'=>'21.362262,106.176664','bsx'=>array(13,98)),
                    '9'=>array('id'=>9,'name'=>'Bắc Kạn','gps'=>'22.240912,105.819391','bsx'=>array(97)),
                    '10'=>array('id'=>10,'name'=>'Bạc Liêu','gps'=>'9.291818,105.467610','bsx'=>array(94)),
                    '11'=>array('id'=>11,'name'=>'Bắc Ninh','gps'=>'21.136271,106.083659','bsx'=>array(99)),
                    '12'=>array('id'=>12,'name'=>'Bến Tre','gps'=>'10.137806,106.565089','bsx'=>array(71)),
                    '13'=>array('id'=>13,'name'=>'Bình Định','gps'=>'14.169255,108.899803','bsx'=>array(77)),
                    '14'=>array('id'=>14,'name'=>'Bình Dương','gps'=>'11.207645,106.578304','bsx'=>array(61)),
                    '15'=>array('id'=>15,'name'=>'Bình Phước','gps'=>'11.680601,106.825329','bsx'=>array(93)),
                    '16'=>array('id'=>16,'name'=>'Bình Thuận','gps'=>'10.947979,107.826546','bsx'=>array(86)),
                    '17'=>array('id'=>17,'name'=>'Cà Mau','gps'=>'8.820449,105.084218','bsx'=>array(69)),
                    '18'=>array('id'=>18,'name'=>'Cao Bằng','gps'=>'22.803639,105.711757','bsx'=>array(11)),
                    '19'=>array('id'=>19,'name'=>'Đắk Lắk','gps'=>'12.865012,108.003386','bsx'=>array(47)),
                    '20'=>array('id'=>20,'name'=>'Đắk Nông','gps'=>'12.107715,107.830821','bsx'=>array(48)),
                    '21'=>array('id'=>21,'name'=>'Điện Biên','gps'=>'21.752904,103.101496','bsx'=>array(27)),
                    '22'=>array('id'=>22,'name'=>'Đồng Nai','gps'=>'10.714318,107.005192','bsx'=>array(60)),
                    '23'=>array('id'=>23,'name'=>'Đồng Tháp','gps'=>'10.581382,105.688341','bsx'=>array(66)),
                    '24'=>array('id'=>24,'name'=>'Gia Lai','gps'=>'13.870961,108.282026','bsx'=>array(81)),
                    '25'=>array('id'=>25,'name'=>'Hà Giang','gps'=>'22.522165,104.765151','bsx'=>array(23)),
                    '26'=>array('id'=>26,'name'=>'Hà Nam','gps'=>'20.447984,105.919875','bsx'=>array(90)),
                    '27'=>array('id'=>27,'name'=>'Hà Tĩnh','gps'=>'18.264984,105.696628','bsx'=>array(38)),
                    '28'=>array('id'=>28,'name'=>'Hải Dương','gps'=>'20.781788,106.289502','bsx'=>array(34)),
                    '29'=>array('id'=>29,'name'=>'Hậu Giang','gps'=>'9.790570,105.576663','bsx'=>array(95)),
                    '30'=>array('id'=>30,'name'=>'Hòa Bình','gps'=>'20.730707,105.474031','bsx'=>array(28)),
                    '31'=>array('id'=>31,'name'=>'Hưng Yên','gps'=>'20.833808,106.010205','bsx'=>array(89)),
                    '32'=>array('id'=>32,'name'=>'Khánh Hòa','gps'=>'12.307491,108.871089','bsx'=>array(79)),
                    '33'=>array('id'=>33,'name'=>'Kiên Giang','gps'=>'10.009664,105.197401','bsx'=>array(68)),
                    '34'=>array('id'=>34,'name'=>'Kon Tum','gps'=>'14.313554,107.920630','bsx'=>array(82)),
                    '35'=>array('id'=>35,'name'=>'Lai Châu','gps'=>'22.324320,102.843735','bsx'=>array(25)),
                    '36'=>array('id'=>36,'name'=>'Lâm Đồng','gps'=>'11.641015,107.497746','bsx'=>array(49)),
                    '37'=>array('id'=>37,'name'=>'Lạng Sơn','gps'=>'21.820741,106.547897','bsx'=>array(12)),
                    '38'=>array('id'=>38,'name'=>'Lào Cai','gps'=>'22.513893,103.856868','bsx'=>array(24)),
                    '39'=>array('id'=>39,'name'=>'Long An','gps'=>'10.695005,105.960820','bsx'=>array(62)),
                    '40'=>array('id'=>40,'name'=>'Nam Định','gps'=>'20.413892,106.162605','bsx'=>array(18)),
                    '41'=>array('id'=>41,'name'=>'Nghệ An','gps'=>'19.395257,104.889498','bsx'=>array(37)),
                    '42'=>array('id'=>42,'name'=>'Ninh Bình','gps'=>'20.247371,105.970816','bsx'=>array(35)),
                    '43'=>array('id'=>43,'name'=>'Ninh Thuận','gps'=>'11.708233,108.886415','bsx'=>array(85)),
                    '44'=>array('id'=>44,'name'=>'Phú Thọ','gps'=>'21.307744,105.125561','bsx'=>array(19)),
                    '45'=>array('id'=>45,'name'=>'Quảng Bình','gps'=>'17.650996,106.225225','bsx'=>array(73)),
                    '46'=>array('id'=>46,'name'=>'Quảng Nam','gps'=>'15.582603,107.985250','bsx'=>array(92)),
                    '47'=>array('id'=>47,'name'=>'Quảng Ngãi','gps'=>'15.033132,108.631560','bsx'=>array(76)),
                    '48'=>array('id'=>48,'name'=>'Quảng Ninh','gps'=>'21.151562,107.203928','bsx'=>array(14)),
                    '49'=>array('id'=>49,'name'=>'Quảng Trị','gps'=>'16.725876,107.103291','bsx'=>array(74)),
                    '50'=>array('id'=>50,'name'=>'Sóc Trăng','gps'=>'9.605473,105.973519','bsx'=>array(83)),
                    '51'=>array('id'=>51,'name'=>'Sơn La','gps'=>'9.600734,105.978154','bsx'=>array(26)),
                    '52'=>array('id'=>52,'name'=>'Tây Ninh','gps'=>'11.357658,106.130780','bsx'=>array(70)),
                    '53'=>array('id'=>53,'name'=>'Thái Bình','gps'=>'20.506917,106.374343','bsx'=>array(17)),
                    '54'=>array('id'=>54,'name'=>'Thái Nguyên','gps'=>'21.587135,105.824038','bsx'=>array(20)),
                    '55'=>array('id'=>55,'name'=>'Thanh Hóa','gps'=>'20.091208,105.301704','bsx'=>array(36)),
                    '56'=>array('id'=>56,'name'=>'Thừa Thiên Huế','gps'=>'16.344361,107.581729','bsx'=>array(75)),
                    '57'=>array('id'=>57,'name'=>'Tiền Giang','gps'=>'10.438860,106.253686','bsx'=>array(63)),
                    '58'=>array('id'=>58,'name'=>'Trà Vinh','gps'=>'9.934929,106.336861','bsx'=>array(84)),
                    '59'=>array('id'=>59,'name'=>'Tuyên Quang','gps'=>'22.058060,105.244858','bsx'=>array(22)),
                    '60'=>array('id'=>60,'name'=>'Vĩnh Long','gps'=>'10.244966,105.958561','bsx'=>array(64)),
                    '61'=>array('id'=>61,'name'=>'Vĩnh Phúc','gps'=>'21.301371,105.591167','bsx'=>array(88)),
                    '62'=>array('id'=>62,'name'=>'Yên Bái','gps'=>'21.718615,104.929472','bsx'=>array(21)),
                    '63'=>array('id'=>63,'name'=>'Phú Yên','gps'=>'13.096341,109.292911','bsx'=>array(78)),
                    
        );
}

function sendSMSNoti($YourPhone="01276560000",$Content="Có khách đặt phòng trên hệ thống ManMo")
{
    $APIKey="A5598C2B5EDFE7A625B7E4AC4B37E6";
    $SecretKey="1A1A910A6E2A031DC553BACE45C878";
    
    $SendContent=urlencode($Content);
    $data="http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone=$YourPhone&ApiKey=$APIKey&SecretKey=$SecretKey&Content=$SendContent&SmsType=4";
    
    $curl = curl_init($data); 
    curl_setopt($curl, CURLOPT_FAILONERROR, true); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    $result = curl_exec($curl); 
    
    /*
    $obj = json_decode($result,true);
    if($obj['CodeResult']==100)
    {
        print "<br>";
        print "CodeResult:".$obj['CodeResult'];
        print "<br>";
        print "CountRegenerate:".$obj['CountRegenerate'];
        print "<br>";     
        print "SMSID:".$obj['SMSID'];
        print "<br>";
    }
    else
    {
        print "ErrorMessage:".$obj['ErrorMessage'];
    }
    */
}

if(!empty($_SESSION['typeHotel']) && !empty($typeHotelManmo[$_SESSION['typeHotel']])){
  include($typeHotelManmo[$_SESSION['typeHotel']]['code'].'/function.php');
}

if(!function_exists('getMenuSidebarLeftManager')){
function getMenuSidebarLeftManager() {
    global $urlHomes;
    return array(
        
        array('icon' => 'fa-sitemap', 'name' => 'Danh sách cơ sở lưu trú', 'link' => $urlHomes . 'managerListHotel', 'permission' => 'managerListHotel'),
        
    );
}
}

// đăng ký bằng mail mantanvietnam@gmail.com
function sendMessageNotifi($data,$target){
    /*  
    Parameter Example
        $data = array('post_id'=>'12345','post_title'=>'A Blog post');
        $target = 'single tocken id or topic name';
        or
        $target = array('token1','token2','...'); // up to 1000 in one request
    */
    //FCM api URL
    $url = 'https://fcm.googleapis.com/fcm/send';
    //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
    $server_key = 'AAAAuOFWYmA:APA91bEfX-SC8t9RgYhg47yN0t5AmbI8GpTL5572HZApyirHHmgq_OzthYxePtzjamQxhnz0Nwn1CrSnuelldl3NSowLq-h15BFNBKvMPIetjRnciU-g2-_S-GBQ8yRT8SHBgQDKLNrv';
                
    $fields = array();
    $fields['data'] = $data;
    if(is_array($target)){
        $fields['registration_ids'] = $target;
    }else{
        $fields['to'] = $target;
    }
    //header with content_type api key
    $headers = array(
        'Content-Type:application/json',
      'Authorization:key='.$server_key
    );
                
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        //die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    //return $result;
}
?>