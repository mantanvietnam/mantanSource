<?php

class LogRestaurant extends AppModel {

    var $name = 'LogRestaurant';
    
    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'desc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }

    function getLogRestaurant($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    public function isExist($codeLogRestaurant) {
        $data = $this->find('count', array(
            'conditions' => array(
                'codeLogRestaurant' => $codeLogRestaurant,
                'idHotel' => $_SESSION['idHotel']
                )
        ));

        if ($data > 0) {
            return true;
        }

        return false;
    }

}

?>