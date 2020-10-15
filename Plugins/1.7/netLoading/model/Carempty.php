<?php
class Carempty extends AppModel {

    var $name = 'Carempty';

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

    function getCarempty($id=null) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    function getDriverAround($latGPS,$longGPS,$radius,$cityStart,$cityEnd,$fields=null)
    {
        $latMin= $latGPS-$radius;
        $latMax= $latGPS+$radius;

        $longMin= $longGPS-$radius;
        $longMax= $longGPS+$radius;

        $conditions['latGPS']= array('$gte' => $latMin,'$lte' => $latMax);
        $conditions['longGPS']= array('$gte' => $longMin,'$lte' => $longMax);

        $return = $this->find('all', array('conditions' => $conditions, 'fields'=>$fields));

        return $return;
    }
}

?>