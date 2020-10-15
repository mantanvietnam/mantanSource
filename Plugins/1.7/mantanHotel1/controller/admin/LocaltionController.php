<?php
// Quan ly vi tri
function listLocationAdmin($input) {
    $modelLocaltion=new Localtion();
    global $urlHomes;
    global $isRequestPost;
    if (checkAdminLogin()) {
        if ($isRequestPost) {
            if (isset($_POST['type']) && $_POST['type'] == 'save')
			{
				$modelLocaltion->saveLocaltion($_POST['name'],$_POST['description'],$_POST['city'],$_POST['district'],$_POST['show'],$_POST['key'],$_POST['id']);
				//debug ($_POST['district']);
			}
            elseif (isset($_POST['type']) && $_POST['type'] == 'delete') {
                // Xoa tien vi tri
                $idDelete = $_POST['idDelete'];
                $modelLocaltion->deleteLocaltion($idDelete);
            }
        }
		$listData = $modelLocaltion->getAllLocaltion();
        setVariable('listData', $listData);
		$modelOption= new Option();
		// Lay danh sach tinh thanh quan huyen
		$listCity = $modelOption->getOption('cityMantanHotel');
		$listCity= (isset($listCity['Option']['value']['allData']))?$listCity['Option']['value']['allData']:array();
		setVariable('listCity', $listCity);
    } else {
        $modelOption->redirect($urlHomes);
    }
}
function ajaxLocalForHotel()
{
	$modelLocaltion=new Localtion();
    global $urlHomes;
    global $isRequestPost;
    global $modelOption;
	//debug (isset($_SESSION['infoManager']));
    if (isset($_SESSION['infoManager'])) {
        if ($isRequestPost) {
			$conditions=array('city'=>(int) $_POST['city'],'district'=> (int) $_POST['district'],'show'=>1);
			//debug ($conditions);
			$listData = $modelLocaltion->getAllLocaltion($conditions);
			//debug ($listData);
			setVariable('listData', $listData);
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

// Ket thuc quan ly vi tri

?>