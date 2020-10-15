<?php

class Promotion extends AppModel {

    var $name = 'Promotion';

    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'asc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }

    function getPromotion($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    function checkPromotion($hotel,$type_room)
    {
        $today= getdate();
        $conditions['time_start']= array('$lte' => $today[0]);
        $conditions['time_end']= array('$gte' => $today[0]);
        $conditions['idHotel']= $hotel;
        $conditions['type_room']= $type_room;
        
        $data= $this->find('first', array('conditions' => $conditions));
        
        if(isset($data['Promotion']['promotion_value'])){
            return $data['Promotion']['promotion_value'];
        }
        
        return 0;
    }
    function checkPromotionByHotel($hotel)
    {
        $today= getdate();
        $conditions['time_start']= array('$lte' => $today[0]);
        $conditions['time_end']= array('$gte' => $today[0]);
        $conditions['idHotel']= $hotel;
        
        $data= $this->find('first', array('conditions' => $conditions));
        
        if(isset($data['Promotion']['promotion_value'])){
            return true;
        }else{
             return false;
        }
        
       
    }
}

?>