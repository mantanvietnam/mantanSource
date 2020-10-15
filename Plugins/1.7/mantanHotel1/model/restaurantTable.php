<?php
class Table extends AppModel {

    var $name = 'Table';
	
	function creatTableFloor($floor,$floorName,$hotel,$manager,$tables)
	{
		for ($i=1;$i<=$tables;$i++)
		{
			$data['Table']['name']= $floorName.' - '.$i;
			$data['Table']['floor']= $floor;
			$data['Table']['hotel']= $hotel;
			$data['Table']['manager']= $manager;
			$data['Table']['delete']= 0;
			$this->create();
			$this->save($data);
			$listTable[]=$this->getLastInsertID();
		}
		return $listTable;
	}
	function creatTable($floor,$name,$hotel,$manager)
	{
		$data['Table']['name']= $name;
		$data['Table']['floor']= $floor;
		$data['Table']['hotel']= $hotel;
		$data['Table']['manager']= $manager;
		$data['Table']['delete']= 0;
		$this->save($data);
		return $this->getLastInsertID();
	}
	function updateTable($name,$id)
	{
		$data=$this->getTable($id);
		$data['Table']['name']= $name;
		$data['Table']['id']= $id;
		$this->save($data);
		return $data;
	}
	function checkInTable($checkin,$id)
	{
		$data=$this->getTable($id);
		$data['Table']['checkin']= $checkin;
                $this->save($data);
		return $data;
	}
	function changCheckIn($idFrom,$idTo)
	{
		$dataFrom=$this->getTable($idFrom);
		$dataTo=$this->getTable($idTo);
		$dataTo['Table']['checkin']= $dataFrom['Table']['checkin'];
		$dataFrom['Table']['checkin']= '';
		$this->save($dataTo);
		$this->create();
		$this->save($dataFrom);
		return $data;
	}
	function cancelCheckInTable($id)
	{
		$data=$this->getTable($id);
		$data['Table']['checkin']= array();
		$this->save($data);
		return $data;
	}
	function deleteTable($id)
	{
		$data=$this->getTable($id);
		$data['Table']['delete']= 1;
		$this->save($data);
	}
	function getTable($id=null,$idManager=null,$idHotel=null) {
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
	function getTableUse($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id,'delete'=>0);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }
}

?>