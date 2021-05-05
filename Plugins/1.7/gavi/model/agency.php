<?php
class Agency extends AppModel {

    var $name = 'Agency';

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

    function getAgency($id,$fields=array() ) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

    function getAgencyByCode($code,$fields=array() ) {
        $dk = array('code' => strtoupper(trim($code)));
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

    function getAgencyByPhone($phone,$fields=array() ) {
        $dk = array('phone' => trim($phone));
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

    function checkLogin($phone, $password) {
        $dk = array('phone' => $phone, 'pass' => md5($password),'status'=>'active');
        $lay = array('pass' => 0);

        $return = $this->find('first', array('conditions' => $dk, 'fields' => $lay));

        return $return;
    }

}

?>