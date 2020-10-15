<?php
class Localtion extends AppModel {

    var $name = 'Localtion';
	
	function saveLocaltion($name,$description,$city,$district,$show,$key,$id)
	{
		$today= getdate();
		$data['Localtion']['name']= $name;
		$data['Localtion']['description']= $description;
		$data['Localtion']['city']= (int) $city;
		$data['Localtion']['district']= (int) $district;
		$data['Localtion']['show']= (int) $show;
		$data['Localtion']['key']= $key;
		$data['Localtion']['id']= $id;	

		$this->save($data);
		return $data;
	}
    function getLocaltion($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }
	function getAllLocaltion($conditions=array()) {
        $return = $this->find('all',array('conditions'=>$conditions));
        return $return;
    }
	function deleteLocaltion($idLocaltion)
	{
		$this->delete($idLocaltion);
	}
}

?>