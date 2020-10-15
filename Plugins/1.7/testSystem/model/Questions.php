<?php

class Questions extends AppModel {

    var $name = 'Questions';
    
    function getPage($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'desc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }

    function listQuestions($idTest,$numberQuestion) {
     
        $dk = array('idTest' => $idTest);
        $return = $this->find('all', array('conditions' => $dk));
        shuffle($return);
        $list= array();
        for($i=0;$i<$numberQuestion;$i++){
            $list[]= $return[$i];
        }
        
        return $list;
    }
    function allQuestions($idTest) {
     
        $dk = array('idTest' => $idTest);
        $return = $this->find('all', array('conditions' => $dk));
        return $return;
    }
    function getQuestions($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }



}

?>