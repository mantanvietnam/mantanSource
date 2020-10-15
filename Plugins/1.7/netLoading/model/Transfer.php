<?php
class Transfer extends AppModel {

    var $name = 'Transfer';

    function getPage($page = 1, $limit = null, $conditions = array(), $order = array('created' => 'desc'), $fields=null) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions,
            'fields' => $fields
        );
        return $this->find('all', $array);
    }


    function getTransfer($id=null,$fields=null) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

}

?>