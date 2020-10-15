<?php

class Holiday extends AppModel {

    var $name = 'Holiday';

    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'desc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }
    function getHoliday($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }
    function checkToday($today,$hotel)
    {
        $conditions['dateTimeStart']= array('$lte' => $today);
        $conditions['dateTimeEnd']= array('$gte' => $today);
        $conditions['idHotel']= $hotel;
        //debug ($conditions);
        $list=array();
        $list=$this->find('all', array('conditions' => $conditions));
        //debug ($list);
        return count($list)!=0;
    }
}

?>