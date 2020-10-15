<?php
class BarFloor extends AppModel {

    var $name = 'BarFloor';
	
	function saveFloor($color,$name,$note,$idHotel,$manager,$id)
	{
		$data['BarFloor']['name']= $name;
		$data['BarFloor']['hotel']= $idHotel;
		$data['BarFloor']['manager']= $manager;
		$data['BarFloor']['note']= $note;
        $data['BarFloor']['color']= $color;
		$data['BarFloor']['table']= 0;
		$data['BarFloor']['id']= $id;	

		$this->save($data);
		$data['BarFloor']['id']=$this->getLastInsertID();
		return $data;
	}
	function updateFloor($color,$name,$note,$id)
	{
		$data=$data=$this->getFloor($id);
		$data['BarFloor']['name']= $name;
		$data['BarFloor']['note']= $note;
        $data['BarFloor']['color']= $color;

		$this->save($data);
		$data['BarFloor']['id']=$this->getLastInsertID();
		return $data;
	}
	function addTable($id,$listTable)
	{
		$data=$this->getFloor($id);
		if (!isset($data['BarFloor']['listTable']))
			$data['BarFloor']['listTable']=array();
		$data['BarFloor']['listTable']=array_merge($data['BarFloor']['listTable'],$listTable);
		$data['BarFloor']['table']=$data['BarFloor']['table']+count($listTable);
		$this->save($data);
	}
	function deleteTable($id,$idTable)
	{
		$data=$this->getFloor($id);
		if (!isset($data['BarFloor']['listTable']))
			$data['BarFloor']['listTable']=array();
		$array=array();
		$dem=-1;
		foreach ($data['BarFloor']['listTable'] as $infoTable)
		{
			$dem++;			
			if ($infoTable!=$idTable)
				$array[$dem]=$infoTable;
		}
		$data['BarFloor']['listTable']=$array;
		$data['BarFloor']['Table']--;
		$this->save($data);
	}
    function getAllByHotel($hotel) {
        $array = array(
            'order' => array('created' => 'desc'),
            'conditions' => array ('hotel'=>$hotel)
        );
		//debug ($array);
        return $this->find('all', $array);
    }

    function getFloor($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }
}

?>