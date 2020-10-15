<?php

class Custom extends AppModel {

    var $name = 'Custom';

    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'desc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }
    function getCusByCmnd($cmnd)
    {
        $dk = array('cmnd' => $cmnd);
        //debug ($dk);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }
    function getCustom($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    public function isExist($cmnd) {
        $data = $this->find('count', array(
            'conditions' => array(
                'cmnd' => $cmnd,
        )));

        if ($data > 0) {
            return true;
        }

        return false;
    }

}

?>