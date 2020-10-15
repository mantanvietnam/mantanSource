<?php
class Room extends AppModel {

    var $name = 'Room';
	
	function creatRoomFloor($floor,$floorName,$hotel,$manager,$rooms,$typeRoom)
	{
		for ($i=1;$i<=$rooms;$i++)
		{
			$data['Room']['name']= $floorName.' - '.$i;
			$data['Room']['floor']= $floor;
			$data['Room']['hotel']= $hotel;
			$data['Room']['manager']= $manager;
			$data['Room']['delete']= 0;
			$data['Room']['typeRoom']= $typeRoom;
			$this->create();
			$this->save($data);
			$listRoom[]=$this->getLastInsertID();
		}
		return $listRoom;
	}
	function creatRoom($floor,$name,$hotel,$manager,$typeRoom)
	{
		$data['Room']['name']= $name;
		$data['Room']['floor']= $floor;
		$data['Room']['hotel']= $hotel;
		$data['Room']['manager']= $manager;
		$data['Room']['typeRoom']= $typeRoom;
		$data['Room']['delete']= 0;
		$this->save($data);
		return $this->getLastInsertID();
	}
	function updateRoom($name,$typeRoom,$id)
	{
		$data=$this->getRoom($id);
		$data['Room']['name']= $name;
		$data['Room']['typeRoom']= $typeRoom;
		$data['Room']['id']= $id;
		$this->save($data);
		return $data;
	}

	function checkInRoom($checkin,$id)
	{
		$data=$this->getRoom($id);
		$data['Room']['checkin']= $checkin;
        $this->create();
        $this->save($data);
		return $data;
	}
	function changCheckIn($idFrom,$idTo)
	{
		$dataFrom=$this->getRoom($idFrom);
		$dataTo=$this->getRoom($idTo);
		$dataTo['Room']['checkin']= $dataFrom['Room']['checkin'];
		$dataFrom['Room']['checkin']= '';
		$this->save($dataTo);
		$this->create();
		$this->save($dataFrom);
		return $data;
	}
	function cancelCheckInRoom($id)
	{
		$data=$this->getRoom($id);
		$data['Room']['checkin']= array();
		$this->save($data);
		return $data;
	}
	function deleteRoom($id)
	{
		$data=$this->getRoom($id);
		$data['Room']['delete']= 1;
		$this->save($data);
	}
	function getRoom($id=null,$idManager=null,$idHotel=null) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        if($idManager){
            $dk['manager']= $idManager;
        }
        if($idHotel){
            $dk['hotel']= $idHotel;
        }
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }
	function getRoomUse($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id,'delete'=>0);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }
    function getAllRoomByHotel($idHotel,$dk=array(),$order = array('created' => 'desc') )
    {
    	$dk['hotel']= $idHotel;
    	return $this->find('all', array('conditions' => $dk,'order'=>$order));
    }
    function getRoomByUser($user='',$field=array() )
	{
		$dk['checkin.Custom.user']= $user;
		$dk['delete']= 0;

    	return $this->find('first', array('conditions' => $dk,'fields' => $field,'order'=>array('dateCheckin'=>'desc')));
	}
	function getRoomBirthdayUser($idHotel)
	{
		$today= getdate();
		$dk['checkin.Custom.birthdayTime']['$lte']= $today[0]+172800;
		$dk['checkin.Custom.birthdayTime']['$gte']= mktime(0,0,0,$today['mon'],$today['mday'],$today['year']);
		$dk['hotel']= $idHotel;

		return $this->find('all', array('conditions' => $dk));
	}

	function getRoomDeadlinePay($idHotel)
	{
		$today= getdate();
		$dk['checkin.paymentCycle.time']['$lte']= $today[0]+172800;
		$dk['checkin.paymentCycle.time']['$gte']= mktime(0,0,0,$today['mon'],$today['mday'],$today['year']);
		$dk['hotel']= $idHotel;

		return $this->find('all', array('conditions' => $dk));
	}

	function getRoomDeadlineCheckout($idHotel)
	{
		$today= getdate();
		$dk['checkin.dateCheckoutForesee']['$lte']= $today[0]+172800;
		$dk['checkin.dateCheckoutForesee']['$gte']= mktime(0,0,0,$today['mon'],$today['mday'],$today['year']);
		$dk['hotel']= $idHotel;

		return $this->find('all', array('conditions' => $dk));
	}
}

?>