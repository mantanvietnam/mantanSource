<?php
class Warehouse extends AppModel {

    var $name = 'Warehouse';

    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'desc'),$fields=null) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions,
            'fields'=>$fields
        );
        return $this->find('all', $array);
    }

    function getWarehouseByAgency($idAgency,$idWarehous,$fields= array() ) {
        $dk = array('idAgency' => $idAgency, 'idWarehous'=>$idWarehous);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

}

?>