<?php
class BarTable extends AppModel {

    var $name = 'BarTable';
	
	function creatTableFloor($floor,$floorName,$hotel,$manager,$table)
	{
		for ($i=1;$i<=$table;$i++)
		{
			$data['BarTable']['name']= $floorName.' - '.$i;
			$data['BarTable']['floor']= $floor;
			$data['BarTable']['hotel']= $hotel;
			$data['BarTable']['manager']= $manager;
			$data['BarTable']['delete']= 0;
			$this->create();
			$this->save($data);
			$listTable[]=$this->getLastInsertID();
		}
		return $listTable;
	}
	function creatTable($floor,$name,$hotel,$manager)
	{
		$data['BarTable']['name']= $name;
		$data['BarTable']['floor']= $floor;
		$data['BarTable']['hotel']= $hotel;
		$data['BarTable']['manager']= $manager;
		$data['BarTable']['delete']= 0;
		$this->save($data);
		return $this->getLastInsertID();
	}
	function updateTable($name,$id)
	{
		$data=$this->getTable($id);
		$data['BarTable']['name']= $name;
		$data['BarTable']['id']= $id;
		$this->save($data);
		return $data;
	}
	function checkInTable($checkin,$id)
	{
		$data=$this->getTable($id);
		$data['BarTable']['checkin']= $checkin;
                $this->save($data);
		return $data;
	}
	function changCheckIn($idFrom,$idTo)
	{
		$dataFrom=$this->getTable($idFrom);
		$dataTo=$this->getTable($idTo);
		$dataTo['BarTable']['checkin']= $dataFrom['BarTable']['checkin'];
		$dataFrom['BarTable']['checkin']= '';
		$this->save($dataTo);
		$this->create();
		$this->save($dataFrom);
		return $data;
	}
	function cancelCheckInTable($id)
	{
		$data=$this->getTable($id);
		$data['BarTable']['checkin']= array();
		$this->save($data);
		return $data;
	}
	function deleteTable($id)
	{
		$data=$this->getTable($id);
		$data['BarTable']['delete']= 1;
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