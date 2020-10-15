<?php

$menus = array();
$menus[0]['title'] = 'City Management';
$menus[0]['sub'][0] = array('name' => 'City List',
    'classIcon' => 'fa-list',
    'url' => $urlPlugins . 'admin/city-listCity.php');

addMenuAdminMantan($menus);

$category = array(array('title' => 'City',
        'sub' => array(array(
                'url' => '/city',
                'name' => 'City'
            )
        )
    )
);
addMenusAppearance($category);
?>