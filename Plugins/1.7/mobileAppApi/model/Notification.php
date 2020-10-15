<?php
class Notification extends AppModel {

    var $name = 'Notification';

    function getPage($page = 1, $limit = null, $conditions = array(), $order = array('created' => 'desc')) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }

    function saveNotification($saveData= array()) {
        $save['Notification']['notification']= $saveData['notification'];
        $save['Notification']['link']= $saveData['link'];
        $id= $saveData['id'];
        $today= getdate();
        
        if ($id!='') {
            $id = new MongoId($id);
            $dk = array('_id' => $id);
            $this->updateAll($save['Notification'], $dk);
        } else {
            $save['Notification']['view'] = 0;
            $save['Notification']['timePost'] = $today[0];
            $this->save($save);
        }
    }

    function getNotification($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    function updateView($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $save['$inc']['view'] = 1;
        $this->updateAll($save, $dk);
    }

}

?>