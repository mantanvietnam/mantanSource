<?php

class Permission extends AppModel {

    var $name = 'Permission';

    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'asc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }

    function getPermission($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    public function isExist($name) {
        $data = $this->find('count', array(
            'conditions' => array(
                'name' => $name,
                'idHotel' => $_SESSION['idHotel']
        )));

        if ($data > 0) {
            return true;
        }

        return false;
    }
}

?>