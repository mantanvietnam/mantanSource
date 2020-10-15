<?php
class Userhotel extends User {

    var $name = 'User';

	function getUserByCmnd($cmnd) {
        $dk = array('cmnd' => $cmnd);
		//debug ($dk);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    function checkLoginByToken($token='',$fields=null, $dk= array()) {
        $dk['accessToken']= $token;
        $return = $this->find('first', array('conditions' => $dk, 'fields'=>$fields));
        return $return;
    }

    function checkLoginByUser($user='',$pass='',$fields=null, $dk= array()) {
        $dk['user']= $user;
        $dk['password']= $pass;
      
        $return = $this->find('first', array('conditions' => $dk, 'fields'=>$fields));
        return $return;
    }

    function getByUser($user='',$fields=null) {
        $dk = array('user' => $user);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }
}

?>