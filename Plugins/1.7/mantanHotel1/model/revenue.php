<?php
class Revenue extends AppModel {

    var $name = 'Revenue';

    function updateCoin($idManager='',$idHotel='',$coin=0)
    {
        $today= getdate();
        
        $save= $this->find('first',array('conditions'=>array('hotel'=>$idHotel)));
        
        $save['Revenue']['manager']= $idManager;
        $save['Revenue']['hotel']= $idHotel;
        $save['Revenue'][$today['year']][$today['mon']]= (isset($save['Revenue'][$today['year']][$today['mon']]))?$save['Revenue'][$today['year']][$today['mon']]+$coin:$coin;
    
        $this->save($save);
    }
    
    function getRevenue($idHotel)
    {
        return $this->find('first',array('conditions'=>array('hotel'=>$idHotel)));
    }
}

?>