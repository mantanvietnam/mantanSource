<?php
// Duong dan trang chu
global $urlHomeManager;
global $urlHomes;
$urlHomeManager=$urlHomes.'homeManager';
// Danh sach tang
function managerListFloor()
{
	$modelFloor= new Floor();
	global $urlHomes;
	if (checkLoginManager())
	{
		$listData=$modelFloor->getAllByHotel($_SESSION['idHotel']);
		//debug ($listData);
		setVariable('listData', $listData);
	}
	else
	{
		$modelFloor->redirect($urlHomes);
	}
}
// Them tang
function managerAddFloor()
{
	$modelFloor= new Floor();
	$modelTypeRoom= new TypeRoom();
	$modelRoom = new Room();

	global $urlHomes;
	if (checkLoginManager())
	{
		$mess= '';

		if(isset($_GET['redirect'])){
            switch($_GET['redirect']){
                case 'managerProcessOrder': $mess= 'Bạn phải tạo tầng trước khi xử lý yêu cầu đặt phòng';break;
                case 'managerHotelDiagram': $mess= 'Bạn phải tạo tầng trước khi xem sơ đồ khách sạn';break;
            }
        }
        
		$closeDisplay= false;
		$numberRoomActive= $modelRoom->find('count',array('conditions'=>array('manager'=>$_SESSION['infoManager']['Manager']['id'])));
        if(!empty($_SESSION['infoManager']['Manager']['numberRoomMax']) && $numberRoomActive>=$_SESSION['infoManager']['Manager']['numberRoomMax']){
            $mess= 'Bạn đã đạt giới hạn tối đa số phòng. Vui lòng nâng cấp gói cao hơn để tiếp tục sử dụng tính năng này';
            $closeDisplay= true;
        }

		// Lay danh sach loai phong
		$listTypeRoom=$modelTypeRoom->getAllTypeRoomHotel($_SESSION['idHotel']);
        if(empty($listTypeRoom)){
            $modelFloor->redirect($urlHomes.'managerAddTypeRoom?redirect=managerAddFloor');
        }
		//debug ($listTypeRoom);
		setVariable('listTypeRoom', $listTypeRoom);
        setVariable('mess', $mess);
        setVariable('closeDisplay', $closeDisplay);
        
		global $isRequestPost;
		if ($isRequestPost)
		{
			if (isset($_POST['id']) && $_POST['id']!='')
			{
				$floor=$modelFloor->updateFloor($_POST['color'],$_POST['name'],$_POST['note'],$_POST['id']);
			}
			else
			{
				$numberRoomActive= $modelRoom->find('count',array('conditions'=>array('manager'=>$_SESSION['infoManager']['Manager']['id'])));
				$numberRoomActive += $_POST['rooms'];
		        if(!empty($_SESSION['infoManager']['Manager']['numberRoomMax']) && $numberRoomActive>=$_SESSION['infoManager']['Manager']['numberRoomMax']){
		            $modelRoom->redirect($urlHomes . 'managerHotelDiagram?redirect=managerAddRoom');
		        }

				$floor=$modelFloor->saveFloor($_POST['color'],$_POST['name'],$_POST['note'],$_SESSION['idHotel'],$_SESSION['infoManager']['Manager']['id'],$_POST['id']);
				$modelRoom=new Room();
				$listRoom=$modelRoom->creatRoomFloor($floor['Floor']['id'],$floor['Floor']['name'],$floor['Floor']['hotel'],$floor['Floor']['manager'],$_POST['rooms'],$_POST['typeRoom']);
				$modelFloor->addRoom($floor['Floor']['id'],$listRoom);
			}
			$modelFloor->redirect($urlHomes.'managerListFloor');
		}
		elseif(isset($_GET['idFloor']) &&($_GET['idFloor'])!='')
		{	
			$data=$modelFloor->getFloor($_GET['idFloor']);
			setVariable('data', $data);
		}
	}
	else
	{
		$modelFloor->redirect($urlHomes);
	}
}
// Xoa tang
function managerDeleteFloor()
{
	$modelFloor= new Floor();
	global $urlHomes;
	if (checkLoginManager())
	{
		$data=$modelFloor->getFloor($_POST['idDelete']);
			if ($data['Floor']['manager']==$_SESSION['infoManager']['Manager']['id'] && $data['Floor']['hotel']==$_SESSION['idHotel'])
			{
				//debug ($data);
				$modelRoom=new Room();
				foreach ($data['Floor']['listRooms'] as $idRoom)
					$modelRoom->delete($idRoom);
				$modelFloor->delete($_POST['idDelete']);
			}
	}
	else
	{
		$modelFloor->redirect($urlHomes);
	}
}
?>