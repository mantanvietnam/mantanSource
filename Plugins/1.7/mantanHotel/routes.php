<?php
global $routesPlugin;

$routesPlugin['managerLogin'] = 'mantanHotel/view/manager/managerLogin.php';
$routesPlugin['managerForgetPassword'] = 'mantanHotel/view/manager/managerForgetPassword.php';
$routesPlugin['quanlykhachsan'] = 'mantanHotel/view/manager/managerLogin.php';
$routesPlugin['managerSelectHotel'] = 'mantanHotel/view/manager/managerSelectHotel.php';
$routesPlugin['managerLogout'] = 'mantanHotel/view/manager/managerLogout.php';
$routesPlugin['managerAddHotel'] = 'mantanHotel/view/manager/hotel/managerAddHotel.php';
$routesPlugin['managerDeleteHotel'] = 'mantanHotel/manager/hotel/managerDeleteHotel.php';
$routesPlugin['managerListHotel'] = 'mantanHotel/view/manager/hotel/managerListHotel.php';

// Routes for home - ManhTN
$routesPlugin['ajaxLocalForHotelHome'] = 'mantanHotel/view/home/ajaxLocalForHotelHome.php';
$routesPlugin['search-hotel'] = 'mantanHotel/view/home/searchHotel.php';
$routesPlugin['hotel'] = 'mantanHotel/view/home/hotel.php';
$routesPlugin['bestHotel'] = 'mantanHotel/view/home/bestHotel.php';
$routesPlugin['newHotel'] = 'mantanHotel/view/home/newHotel.php';
$routesPlugin['infoUser'] = 'mantanHotel/view/home/infoUser.php';
$routesPlugin['changePassword'] = 'mantanHotel/view/home/changePassword.php';
$routesPlugin['orderHotel'] = 'mantanHotel/view/home/orderHotel.php';
$routesPlugin['orderHistory'] = 'mantanHotel/view/home/orderHistory.php';
$routesPlugin['requestHotel'] = 'mantanHotel/view/home/requestHotel.php';
$routesPlugin['requestHistory'] = 'mantanHotel/view/home/requestHistory.php';
$routesPlugin['requestDetail'] = 'mantanHotel/view/home/requestDetail.php';
$routesPlugin['findnear'] = 'mantanHotel/view/home/findnear.php';
$routesPlugin['ajaxStar'] = 'mantanHotel/view/home/ajaxStar.php';
$routesPlugin['phan-mem-quan-ly-khach-san-mien-phi'] = 'mantanHotel/view/home/event/phanMemQuanLyKhachSanMienPhi.php';
$routesPlugin['dang-ky-su-dung-phan-mem-quan-ly-mien-phi'] = 'mantanHotel/view/home/event/dangKyPhanMemQuanLyKhachSanMienPhi.php';

// API
$routesPlugin['getHotelAroundAPI'] = 'mantanHotel/getHotelAroundAPI.php';
$routesPlugin['getInfoHotelAPI'] = 'mantanHotel/getInfoHotelAPI.php';
$routesPlugin['getFurnitureAPI'] = 'mantanHotel/getFurnitureAPI.php';
$routesPlugin['getTypeHotelAPI'] = 'mantanHotel/getTypeHotelAPI.php';
$routesPlugin['searchHotelAPI'] = 'mantanHotel/searchHotelAPI.php';
$routesPlugin['saveGPSUserAPI'] = 'mantanHotel/saveGPSUserAPI.php';
$routesPlugin['updateVoteHotelAPI'] = 'mantanHotel/updateVoteHotelAPI.php';
$routesPlugin['getInfoManagerAPI'] = 'mantanHotel/getInfoManagerAPI.php';

// API nhan vien thi truong
$routesPlugin['saveGPSMarketerAPI'] = 'mantanHotel/saveGPSMarketerAPI.php';
$routesPlugin['getAllMarketerAPI'] = 'mantanHotel/getAllMarketerAPI.php';
$routesPlugin['saveHotelMarketerAPI'] = 'mantanHotel/saveHotelMarketerAPI.php';
$routesPlugin['saveTokenDeviceMarketerAPI'] = 'mantanHotel/saveTokenDeviceMarketerAPI.php';

// API User
$routesPlugin['checkRegisterUserAPI'] = 'mantanHotel/checkRegisterUserAPI.php';
$routesPlugin['changePassUserAPI'] = 'mantanHotel/changePassUserAPI.php';
$routesPlugin['getInfoUserAPI'] = 'mantanHotel/getInfoUserAPI.php';
$routesPlugin['updateInfoUserAPI'] = 'mantanHotel/updateInfoUserAPI.php';
$routesPlugin['checkLoginUserAPI'] = 'mantanHotel/checkLoginUserAPI.php';
$routesPlugin['sendCodePassNewUserAPI'] = 'mantanHotel/sendCodePassNewUserAPI.php';
$routesPlugin['sendPassNewUserAPI'] = 'mantanHotel/sendPassNewUserAPI.php';
$routesPlugin['saveTokenDeviceUserAPI'] = 'mantanHotel/saveTokenDeviceUserAPI.php';
$routesPlugin['checkLogoutUserAPI'] = 'mantanHotel/checkLogoutUserAPI.php';
$routesPlugin['saveReportUserAPI'] = 'mantanHotel/saveReportUserAPI.php';
$routesPlugin['deleteReportUserAPI'] = 'mantanHotel/deleteReportUserAPI.php';
$routesPlugin['getListReportUserAPI'] = 'mantanHotel/getListReportUserAPI.php';
$routesPlugin['saveClearRoomUserAPI'] = 'mantanHotel/saveClearRoomUserAPI.php';
$routesPlugin['getCategoryServiceAPI'] = 'mantanHotel/getCategoryServiceAPI.php';
$routesPlugin['getListServiceByCategoryAPI'] = 'mantanHotel/getListServiceByCategoryAPI.php';
$routesPlugin['saveNotificationUserAPI'] = 'mantanHotel/saveNotificationUserAPI.php';
$routesPlugin['getInfoRoomUserAPI'] = 'mantanHotel/getInfoRoomUserAPI.php';
$routesPlugin['getListRequestUserAPI'] = 'mantanHotel/getListRequestUserAPI.php';
$routesPlugin['getListNotificationUserAPI'] = 'mantanHotel/getListNotificationUserAPI.php';


$typeHotelManmo = array(
    '1' => array('id'=>1,'name'=>'Nhà nghỉ','code'=>'motel'),
    '2' => array('id'=>2,'name'=>'Khách sạn 1 sao','code'=>'hotel1star'),
    '3' => array('id'=>3,'name'=>'Khách sạn 2 sao','code'=>'hotel2star'),
    '4' => array('id'=>4,'name'=>'Khách sạn 3 sao','code'=>'hotel3star'),
    '5' => array('id'=>5,'name'=>'Khách sạn 4 sao','code'=>'hotel4star'),
    '6' => array('id'=>6,'name'=>'Khách sạn 5 sao','code'=>'hotel5star'),
    '7' => array('id'=>7,'name'=>'Căn hộ dịch vụ cho thuê','code'=>'house'),
);
if(!empty($_SESSION['typeHotel']) && !empty($typeHotelManmo[$_SESSION['typeHotel']])){
  include $typeHotelManmo[$_SESSION['typeHotel']]['code'].'/routes.php';
}
//debug($routesPlugin);die;
?>