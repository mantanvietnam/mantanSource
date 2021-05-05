<?php
class Level extends AppModel {

    var $name = 'Level';

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

    function getLevelByAgency($idAgency,$fields=array() ) {
        $dk = array('idAgency' => $idAgency);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

    function getLevel($id,$fields=array() ) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

}

?>