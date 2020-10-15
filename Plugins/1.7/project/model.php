<?php

class Project extends AppModel {

    var $name = 'Project';

    function getPage($page = 1, $limit = 15, $conditions = array()) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => array('created' => 'desc'),
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }

    function getProject($idProject) {
        $idProject = new MongoId($idProject);
        $dk = array('_id' => $idProject);
        $Project = $this->find('first', array('conditions' => $dk));
        return $Project;
    }

    function deleteProject($idProject) {
        $this->delete($idProject);
    }


}


?>