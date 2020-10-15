<?php
class Request extends AppModel {

    var $name = 'Request';

    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'desc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }

    function getRequest($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }
    
    function getRequestByUser($idUser)
    {
        $array = array(
            'order' => array('created' => 'asc'),
            'conditions' => array('idUser'=>$idUser)
        );
        return $this->find('all', $array);
    }
    
    function getCountRequestWithHotel($hotel)
    {
        $conditions= array();
        if($hotel['Hotel']['city']>0){
            $conditions['city']= array('$in'=>array(0,$hotel['Hotel']['city']));
        }
        
        if($hotel['Hotel']['district']>0){
            $conditions['district']= array('$in'=>array(0,$hotel['Hotel']['district']));
        }
        
        if(!empty($hotel['Hotel']['local'])){
            $conditions['loction']= array('$in'=>$hotel['Hotel']['local']);
        }
        
        if(!empty($hotel['Hotel']['furniture'])){
            $conditions['furniture']= array('$in'=>$hotel['Hotel']['furniture']);
        }
        
        if($hotel['Hotel']['price']>0){
            $price= '';
            if($hotel['Hotel']['price']<100000) $price= '0-100000';
            elseif($hotel['Hotel']['price']>=100000 && $hotel['Hotel']['price']<200000) $price= '100000-200000';
            elseif($hotel['Hotel']['price']>=200000 && $hotel['Hotel']['price']<300000) $price= '200000-300000';
            elseif($hotel['Hotel']['price']>=300000 && $hotel['Hotel']['price']<400000) $price= '300000-400000';
            elseif($hotel['Hotel']['price']>=400000 && $hotel['Hotel']['price']<500000) $price= '400000-500000';
            elseif($hotel['Hotel']['price']>=500000 && $hotel['Hotel']['price']<600000) $price= '500000-600000';
            elseif($hotel['Hotel']['price']>=600000 && $hotel['Hotel']['price']<700000) $price= '600000-700000';
            elseif($hotel['Hotel']['price']>=700000 && $hotel['Hotel']['price']<800000) $price= '700000-800000';
            elseif($hotel['Hotel']['price']>=800000 && $hotel['Hotel']['price']<900000) $price= '800000-900000';
            elseif($hotel['Hotel']['price']>=900000 && $hotel['Hotel']['price']<1000000) $price= '900000-1000000';
            elseif($hotel['Hotel']['price']>=1000000) $price= '1000000-1000000000';
            
            $conditions['price']= array('$in'=>array('',$price));
        }
        
        return $this->find('count', array('conditions' => $conditions));
    }
}

?>