<?php
class Vote extends AppModel {

    var $name = 'Vote';
	function getVote($idUser,$idHotel,$idVote){
        $dk = array('idUser' => $idUser,'idHotel' => $idHotel,'idVote' => (int) $idVote);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }
    function getVoteHotel($idHotel)
    {
    	$dk = array('idHotel' => $idHotel);
        $return = $this->find('all', array('conditions' => $dk));
        return $return;
    }
	function saveVote($idUser,$idHotel,$idVote,$star,$id) {
       	$data['Vote']['idUser']= $idUser;
        $data['Vote']['idHotel']= $idHotel;
		$data['Vote']['idVote']= (int) $idVote;
		$data['Vote']['star']= (int) $star;	
		$data['Vote']['id']= $id;	

		$this->save($data);
		if ($id==null)
			$data['Vote']['id']=$this->getLastInsertID();
		return $data;
    }   
}
?>