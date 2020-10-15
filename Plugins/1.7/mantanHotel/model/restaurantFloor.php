<?php

class RestaurantFloor extends AppModel {

    var $name = 'RestaurantFloor';

    function saveRestaurantFloor($color, $name, $note, $idHotel, $manager, $id) {
        $data['RestaurantFloor']['name'] = $name;
        $data['RestaurantFloor']['hotel'] = $idHotel;
        $data['RestaurantFloor']['manager'] = $manager;
        $data['RestaurantFloor']['note'] = $note;
        $data['RestaurantFloor']['color'] = $color;
        $data['RestaurantFloor']['tables'] = 0;
        $data['RestaurantFloor']['id'] = $id;

        $this->save($data);
        $data['RestaurantFloor']['id'] = $this->getLastInsertID();
        return $data;
    }

    function updateRestaurantFloor($color, $name, $note, $id) {
        $data = $data = $this->getRestaurantFloor($id);
        $data['RestaurantFloor']['name'] = $name;
        $data['RestaurantFloor']['note'] = $note;
        $data['RestaurantFloor']['color'] = $color;

        $this->save($data);
        $data['RestaurantFloor']['id'] = $this->getLastInsertID();
        return $data;
    }

    function addTable($id, $listTable) {
        $data = $this->getRestaurantFloor($id);
        if (!isset($data['RestaurantFloor']['listTables']))
            $data['RestaurantFloor']['listTables'] = array();
        $data['RestaurantFloor']['listTables'] = array_merge($data['RestaurantFloor']['listTables'], $listTable);
        $data['RestaurantFloor']['tables'] = $data['RestaurantFloor']['tables'] + count($listTable);
        $this->save($data);
    }

    function deleteTable($id, $idTable) {
        $data = $this->getRestaurantFloor($id);
        if (!isset($data['RestaurantFloor']['listTables']))
            $data['RestaurantFloor']['listTables'] = array();
        $array = array();
        $dem = -1;
        foreach ($data['RestaurantFloor']['listTables'] as $infoTable) {
            $dem++;
            if ($infoTable != $idTable)
                $array[$dem] = $infoTable;
        }
        $data['RestaurantFloor']['listTables'] = $array;
        $data['RestaurantFloor']['tables'] --;
        $this->save($data);
    }

    function getAllByHotel($hotel) {
        $array = array(
            'order' => array('created' => 'desc'),
            'conditions' => array('hotel' => $hotel)
        );
        //debug ($array);
        return $this->find('all', $array);
    }

    function getRestaurantFloor($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

}

?>