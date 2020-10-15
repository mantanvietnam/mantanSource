<?php

class PermissionGroup extends AppModel {

    var $name = 'PermissionGroup';

    public function isExist($name) {
        global $modelOption;
        $count = 0;
        $dk = array('key' => 'listPermission');
        $data = $modelOption->find('first', array('conditions' => $dk));

        foreach ($data['Option']['value']['allPermission'] as $permission){
            if($permission['groupPermission']== $name){
                $count++;
            } 
        }
        
        if ($count > 0) {
            return true;
        }

        return false;
    }

}

?>