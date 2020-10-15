<?php

class Tests extends AppModel {

    var $name = 'Tests';

    function saveNewTest($name,$typeTest,$numberQuestion,$description,$lock,$hot,$images,$time) {
        $data['Tests']['name'] = $name;
        $data['Tests']['typeTest'] = $typeTest;
        $data['Tests']['numberQuestion'] = $numberQuestion;
        $data['Tests']['description'] = $description;
        $data['Tests']['lock'] = $lock;
        $data['Tests']['hot'] = $hot;
        $data['Tests']['images'] = $images;
        $data['Tests']['time'] = $time;
        $this->save($data);
        return $data;
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

    function getTest($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }
    function getTestHot($limit) {
        $dk = array('hot' => '1');
        $return = $this->find('all', array('conditions' => $dk,'limir'=>$limit));
        return $return;
    }

    function editQuestion($idTest, $idEditQuestion, $title, $select1, $select2, $select3, $select4, $result) {
        $data = $this->getTest($idTest);
        if (!empty($data)) {
            $data['Tests']['question'][$idEditQuestion]['id'] = $idEditQuestion;
            $data['Tests']['question'][$idEditQuestion]['title'] = $title;
            $data['Tests']['question'][$idEditQuestion]['select1'] = $select1;
            $data['Tests']['question'][$idEditQuestion]['select2'] = $select2;
            $data['Tests']['question'][$idEditQuestion]['select3'] = $select3;
            $data['Tests']['question'][$idEditQuestion]['select4'] = $select4;
            $data['Tests']['question'][$idEditQuestion]['result'] = $result;
            $this->create();
            $this->save($data);
        }
    }

    function saveQuestion($idTest, $title, $select1, $select2, $select3, $select4, $result) {
        $data = $this->getTest($idTest);
        if ($data) {
            if (empty($data['Tests']['question'])) {
                $dem = 1;
            } else {
                $dem = count($data['Tests']['question']) + 1;
            }
            $data['Tests']['question'][$dem]['id'] = $dem;
            $data['Tests']['question'][$dem]['title'] = $title;
            $data['Tests']['question'][$dem]['select1'] = $select1;
            $data['Tests']['question'][$dem]['select2'] = $select2;
            $data['Tests']['question'][$dem]['select3'] = $select3;
            $data['Tests']['question'][$dem]['select4'] = $select4;
            $data['Tests']['question'][$dem]['result'] = $result;
            $this->save($data, false, array('question'));
            return 1;
        } else {
            return 0;
        }
    }

}

?>