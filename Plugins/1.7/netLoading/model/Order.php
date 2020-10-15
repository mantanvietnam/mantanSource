<?php
class Order extends AppModel {

    var $name = 'Order';

    function getPage($page = 1, $limit = null, $conditions = array(), $order = array('created' => 'desc'),$fields=null) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions,
            'fields' => $fields
        );
        return $this->find('all', $array);
    }

    function getOrder($id=null) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    function getOrderByUser($id=null,$idUser=''){
        $id = new MongoId($id);
        $dk = array('_id' => $id,'idUser'=>$idUser);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

}

?>