<?php

class Report extends AppModel {

    var $name = 'Report';

    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'desc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }

    function getReport($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    function getCountReport($status='',$idHotel='')
    {
        $dk = array('status' => $status,'idHotel'=>$idHotel);
        $return = $this->find('count', array('conditions' => $dk));
        return $return;
    }
}

?>