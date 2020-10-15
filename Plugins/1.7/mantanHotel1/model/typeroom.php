<?php
class TypeRoom extends AppModel {
    var $name = 'TypeRoom';
    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'asc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }
	function getAllTypeRoomHotel($hotel) {
        $dk = array('idHotel' => $hotel);		
        $return = $this->find('all', array('conditions' => $dk));
        return $return;
    }
    function getTypeRoom($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }
    public function isExist($roomtype) {
        $data = $this->find('count', array(
            'conditions' => array('idHotel'=>$_SESSION['idHotel'],'roomtype' => $roomtype)
        ));
        if ($data > 0) {
            return true;
        }
        return false;
    }
}
?>