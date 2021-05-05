<?php
class Import extends AppModel {

    var $name = 'Import';

    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'desc'),$fields=null) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions,
            'fields'=>$fields
        );
        return $this->find('all', $array);
    }

    function getImport($id,$fields=array() ) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk,'fields'=>$fields));
        return $return;
    }

    function getListImportByProduct($idProduct='',$idWarehouse='',$fields=array()){
        $dk = array('idWarehouse' => $idWarehouse,'idProduct'=>$idProduct,'quantity'=>array('$gt'=>0));
        $order = array('dateExpiration.time' => 'asc');
        $return = $this->find('all', array('conditions' => $dk,'fields'=>$fields,'order' => $order));
        return $return;
    }

}

?>