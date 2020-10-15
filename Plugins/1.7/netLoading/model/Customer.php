<?php
class Customer extends AppModel {

    var $name = 'Customer';

    function getPage($page = 1, $limit = null, $conditions = array(), $order = array('created' => 'desc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }


    function getCustomer($id=null,$fields=null) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

    function getCustomerByEmail($email='') {
        $dk = array('email' => $email);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    function getCustomerByUser($user='') {
        $dk = array('user' => $user);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    function getCustomerByFone($fone='') {
        $dk = array('fone' => $fone);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }
	
    function checkLoginByAccount($account='',$pass='',$fields=null, $dk= array()) {
        $dk['account']= $account;
        $dk['pass']= md5($pass);
        $return = $this->find('first', array('conditions' => $dk, 'fields'=>$fields));
        return $return;
    }

    function checkLoginByFone($fone='',$pass='',$fields=null, $dk= array()) {
        $dk['fone']= $fone;
        $dk['pass']= md5($pass);
        $return = $this->find('first', array('conditions' => $dk, 'fields'=>$fields));
        return $return;
    }

    function checkLoginByToken($token='',$fields=null, $dk= array()) {
        $dk['accessToken']= $token;
        $return = $this->find('first', array('conditions' => $dk, 'fields'=>$fields));
        return $return;
    }

    function checkLoginById($id='',$pass='',$fields=null, $dk= array()) {
        $id= new MongoId($id);
        $dk['_id']= $id;
        $dk['pass']= $pass;
        $return = $this->find('first', array('conditions' => $dk, 'fields'=>$fields));
        return $return;
    }

}

?>