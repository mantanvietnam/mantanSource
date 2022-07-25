<?php

class Manager extends AppModel {

    var $name = 'Manager';

    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'desc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }

    

    function getData($id='',$fields=array() ) {
        if(MongoId::isValid($id)){
            $id = new MongoId($id);
            $dk = array('_id' => $id);
            $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
            return $return;
        }
    }

    function getByPhone($phone='',$fields=null) {
        $dk = array('phone' => $phone);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }
    
    function checkLogin($phone, $password) {
        $dk = array('phone' => $phone, 'password' => $password);
        $lay = array('password' => 0);
        
        $return = $this->find('first', array('conditions' => $dk, 'fields' => $lay));

        return $return;
    }

}

?>