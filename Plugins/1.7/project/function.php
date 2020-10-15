<?php

$menus = array();
$menus[0]['title'] = 'Project Management';
$menus[0]['sub'][0] = array('name' => 'Project List',
    'classIcon' => 'fa-list',
    'url' => $urlPlugins . 'admin/project-listProject.php');

addMenuAdminMantan($menus);

$category = array(array('title' => 'Project',
        'sub' => array(array(
                'url' => '/project',
                'name' => 'Project'
            )
        )
    )
);
addMenusAppearance($category);
?>