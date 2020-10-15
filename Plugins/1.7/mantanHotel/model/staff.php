<?php

class Staff extends AppModel {

    var $name = 'Staff';

    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'asc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }

    function getStaff($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }
    
    function checkLogin($user, $password) {
        $dk = array('user' => $user, 'password' => $password);
        $lay = array('password' => 0);

        $return = $this->find('first', array('conditions' => $dk, 'fields' => $lay));

        return $return;
    }


    /**
     * check Staff exist
     * @param int StaffId
     * @return boolean
     * @author SonTT<js.trantrongson@gmail.com>
     */
    public function isExist($username, $email) {
        //$conditions['$or'][0]['slug']= array('$regex' => $key);
        
        $conditions['$or'][0]['user']= $username;
        $conditions['$or'][1]['email']= $email;
        
        $data = $this->find('count', array('conditions' => $conditions));

        if ($data > 0) {
            return true;
        }

        return false;
    }

}

?>