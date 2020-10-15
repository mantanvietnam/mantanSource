<?php
// Duong dan trang chu
global $urlHomeManager;
global $urlHomes;
$urlHomeManager=$urlHomes.'homeManager';
// Danh sach tang
function managerListBarFloor()
{
	$modelBarFloor= new BarFloor();
	global $urlHomes;
	if (checkLoginManager())
	{
		$listData=$modelBarFloor->getAllByHotel($_SESSION['idHotel']);
		//debug ($listData);
		setVariable('listData', $listData);
	}
	else
	{
		$modelFloor->redirect($urlHomes);
	}
}
// Them tang
function managerAddBarFloor()
{
	$modelBarFloor= new BarFloor();
	global $urlHomes;
	if (checkLoginManager())
	{
	    $mess= '';
        if(isset($_GET['redirect'])){
            switch($_GET['redirect']){
                case 'managerProcessOrder': $mess= 'Bạn phải tạo tầng trước khi xử lý yêu cầu đặt bàn';break;
                case 'managerHotelDiagram': $mess= 'Bạn phải tạo tầng trước khi xem sơ đồ quán Bar';break;
            }
        }      
        setVariable('mess', $mess);
        
		global $isRequestPost;
		if ($isRequestPost)
		{
			if (isset($_POST['id']) && $_POST['id']!='')
			{
				$floor=$modelBarFloor->updateFloor($_POST['color'],$_POST['name'],$_POST['note'],$_POST['id']);
			}
			else
			{
				$floor=$modelBarFloor->saveFloor($_POST['color'],$_POST['name'],$_POST['note'],$_SESSION['idHotel'],$_SESSION['infoManager']['Manager']['id'],$_POST['id']);
				$modelBarTable=new barTable();
				$listRoom=$modelBarTable->creatTableFloor($floor['BarFloor']['id'],$floor['BarFloor']['name'],$floor['BarFloor']['hotel'],$floor['BarFloor']['manager'],$_POST['table']);
				$modelBarFloor->addTable($floor['BarFloor']['id'],$listRoom);
			}
			$modelBarFloor->redirect($urlHomes.'managerListBarFloor');
		}
		elseif(isset($_GET['idFloor']) &&($_GET['idFloor'])!='')
		{	
			$data=$modelBarFloor->getFloor($_GET['idFloor']);
			setVariable('data', $data);
		}
	}
	else
	{
		$modelFloor->redirect($urlHomes);
	}
}
// Xoa tang
function managerDeleteBarFloor()
{
	$modelBarFloor= new BarFloor();
	global $urlHomes;
	if (checkLoginManager())
	{
		$data=$modelBarFloor->getFloor($_POST['idDelete']);
			if ($data['BarFloor']['manager']==$_SESSION['infoManager']['Manager']['id'] && $data['BarFloor']['hotel']==$_SESSION['idHotel'])
			{
				//debug ($data);
				$modelBarTable=new barTable();
				foreach ($data['BarFloor']['listTable'] as $idRoom)
					$modelBarTable->delete($idRoom);
				$modelBarFloor->delete($_POST['idDelete']);
			}
	}
	else
	{
		$modelFloor->redirect($urlHomes);
	}
}
?>