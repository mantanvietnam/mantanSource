<?php

class MerchandiseStatic extends AppModel {

    var $name = 'MerchandiseStatic';

    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'asc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }

    function getMerchandiseStatic($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

}

?>