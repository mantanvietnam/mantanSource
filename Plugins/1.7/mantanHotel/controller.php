<?php
    // for admin
    include 'controller/admin/adminController.php';
    
    // for home
    include 'controller/home/hotelController.php';
    include 'controller/home/voteController.php';
    include 'controller/home/requestController.php';
    
    // for api
    include 'controller/api/apiController.php';
    include 'controller/api/marketerController.php';
    include 'controller/api/userAPIController.php';

    // for manager
    include 'controller/manager/managerController.php';
    include 'controller/manager/hotelController.php';
    
    global $typeHotelManmo;
    if(!empty($_SESSION['typeHotel']) && !empty($typeHotelManmo[$_SESSION['typeHotel']])){
      include $typeHotelManmo[$_SESSION['typeHotel']]['code'].'/controller.php';
    }
?>