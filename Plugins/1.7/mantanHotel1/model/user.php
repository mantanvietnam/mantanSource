<?php
class Userhotel extends User {

    var $name = 'User';

	function getUserByCmnd($cmnd) {
        $dk = array('cmnd' => $cmnd);
		//debug ($dk);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }
}

?>