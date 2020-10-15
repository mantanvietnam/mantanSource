<?php

class Student extends AppModel {

    var $name = 'Student';

    function saveNewStudent($fullname,$username,$password,$email,$sex,$phone,$address,$id=null)
    {
        $data['Student']['fullname'] = $fullname;
        $data['Student']['username'] = $username;
        $data['Student']['password'] = $password;
        $data['Student']['email'] = $email;
        $data['Student']['sex'] = $sex;
        $data['Student']['phone'] = $phone;
        $data['Student']['address'] = $address;
        $data['Student']['id'] = $id;

        $this->save($data);
        return $data;
    }

    function getStudentByUsername($username) 
    {
        //debug('vao');die;
        $dk = array('username' => $username);
        $return = $this->find('first', array('conditions' => $dk));
        //debug($return);die;
        return $return;
    }

    function checkLogin($username,$password)
    {
        $dk = array('username' => $username,'password'=>$password);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    function getStudent($id)
    {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return; 
    }


    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'desc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
            );
        return $this->find('all', $array);
    }
}

?>