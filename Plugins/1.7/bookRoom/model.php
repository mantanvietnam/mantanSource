<?php

class Book extends AppModel {

    var $name = 'Book';

    function getPage($page = 1, $limit = 15, $conditions = array()) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => array('created' => 'desc'),
            'conditions' => $conditions
        );
        return $this->find('all', $array);
    }

    function saveBook($fullName, $email, $checkin,  $content, $fone) {
        $Book['Book']['fullName'] = $fullName;
        $Book['Book']['email'] = $email;
        $Book['Book']['checkin'] = $checkin;
        $Book['Book']['content'] = $content;
        $Book['Book']['fone'] = $fone;
        
        $this->save($Book);
    }

    function getBook($idBook) {
        $idBook = new MongoId($idBook);
        $dk = array('_id' => $idBook);
        $idBook = $this->find('first', array('conditions' => $dk));
        return $idBook;
    }

    function deleteBook($idBook) {
        $this->delete($idBook);
    }
}

?>