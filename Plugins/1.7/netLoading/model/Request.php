<?php
class Request extends AppModel {

    var $name = 'Request';

    function getPage($page = 1, $limit = null, $conditions = array(), $order = array('created' => 'desc'),$fields=null) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions,
            'fields' => $fields
        );
        return $this->find('all', $array);
    }

    function getRequest($id=null) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    function getRequestByUser($id=null,$idUser='',$dk= array()){
        $id = new MongoId($id);
       
        $dk['_id']= $id;
        $dk['idUser']= $idUser;

        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

}

?>