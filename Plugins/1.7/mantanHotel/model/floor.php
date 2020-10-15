<?php
class Floor extends AppModel {

    var $name = 'Floor';
	
	function saveFloor($color,$name,$note,$idHotel,$manager,$id)
	{
		$data['Floor']['name']= $name;
		$data['Floor']['hotel']= $idHotel;
		$data['Floor']['manager']= $manager;
		$data['Floor']['note']= $note;
                $data['Floor']['color']= $color;
		$data['Floor']['rooms']= 0;
		$data['Floor']['id']= $id;	

		$this->save($data);
		$data['Floor']['id']=$this->getLastInsertID();
		return $data;
	}
	function updateFloor($color,$name,$note,$id)
	{
		$data=$data=$this->getFloor($id);
		$data['Floor']['name']= $name;
		$data['Floor']['note']= $note;
        $data['Floor']['color']= $color;

		$this->save($data);
		$data['Floor']['id']=$this->getLastInsertID();
		return $data;
	}
	function addRoom($id,$listRoom)
	{
		$data=$this->getFloor($id);
		if (!isset($data['Floor']['listRooms']))
			$data['Floor']['listRooms']=array();
		$data['Floor']['listRooms']=array_merge($data['Floor']['listRooms'],$listRoom);
		$data['Floor']['rooms']=$data['Floor']['rooms']+count($listRoom);
		$this->save($data);
	}
	function deleteRoom($id,$idRoom)
	{
		$data=$this->getFloor($id);
		if (!isset($data['Floor']['listRooms']))
			$data['Floor']['listRooms']=array();
		$array=array();
		$dem=-1;
		foreach ($data['Floor']['listRooms'] as $infoRoom)
		{
			$dem++;			
			if ($infoRoom!=$idRoom)
				$array[$dem]=$infoRoom;
		}
		$data['Floor']['listRooms']=$array;
		$data['Floor']['rooms']--;
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