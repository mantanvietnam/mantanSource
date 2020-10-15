<?php

class LogBar extends AppModel {

    var $name = 'LogBar';
    
    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'desc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }

    function getLogBar($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    public function isExist($codeLogBar) {
        $data = $this->find('count', array(
            'conditions' => array(
                'codeLogBar' => $codeLogBar,
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