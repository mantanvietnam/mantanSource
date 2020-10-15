<?php

class Book extends AppModel {

    var $name = 'Book';
    
    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'desc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }

    function getBook($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    public function isExist($codeBook) {
        $data = $this->find('count', array(
            'conditions' => array(
                'codeBook' => $codeBook,
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