<?php
function ajaxLocalForHotelHome()
{
	$modelLocaltion=new Localtion();
    global $urlHomes;
    global $isRequestPost;
    global $modelOption;
	
    $listData= array();
    if ($isRequestPost) {
		$conditions=array('city'=>(int) $_POST['city'],'district'=> (int) $_POST['district'],'show'=>1);
        //debug ($conditions);
		$listData = $modelLocaltion->getAllLocaltion($conditions);
    }
    setVariable('listData', $listData);
}

// Ket thuc quan ly vi tri

?>