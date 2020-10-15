<?php

/**
 * List Project
 * @author SonTT<js.trantrongson@gmail.com>
 */
function listProject($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    if (checkAdminLogin()) {

        $modelProject = new Project();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();

        if (!empty($_GET['thanh-pho'])) {
            $conditions['city'] = $_GET['thanh-pho'];
        }
        if (!empty($_GET['dia-danh'])) {
            $conditions['$or'][0]['name'] = array('$regex' => strtolower($_GET['dia-danh']));
            $conditions['$or'][1]['name'] = array('$regex' => strtoupper($_GET['dia-danh']));
            $conditions['$or'][2]['slug'] = array('$regex' => createSlugMantan(strtoupper($_GET['dia-danh'])));
        }
        $listData = $modelProject->getPage($page, $limit, $conditions);
        $totalData = $modelProject->find('count', array('conditions' => $conditions));

        $balance = $totalData % $limit;
        $totalPage = ($totalData - $balance) / $limit;
        if ($balance > 0)
            $totalPage+=1;

        $back = $page - 1;
        $next = $page + 1;
        if ($back <= 0)
            $back = 1;
        if ($next >= $totalPage)
            $next = $totalPage;

        if (isset($_GET['page'])) {
            $urlPage = str_replace('&page=' . $_GET['page'], '', $urlNow);
            $urlPage = str_replace('page=' . $_GET['page'], '', $urlPage);
        } else {
            $urlPage = $urlNow;
        }

        if (strpos($urlPage, '?') !== false) {
            if (count($_GET) > 1) {
                $urlPage = $urlPage . '&page=';
            } else {
                $urlPage = $urlPage . 'page=';
            }
        } else {
            $urlPage = $urlPage . '?page=';
        }

        setVariable('listData', $listData);

        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Add Project
 * @author SonTT<js.trantrongson@gmail.com>
 */
function addProject($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {

        if ($isRequestPost) {
            $modelProject = new Project();
            $dataSend = arrayMap($input['request']->data);

            $save['Project'] = $dataSend;

            if ($modelProject->save($save)) {
                $modelProject->redirect($urlPlugins . 'admin/project-listProject.php?status=1');
            } else {
                $modelProject->redirect($urlPlugins . 'admin/project-addProject.php?status=-1');
            }
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Edit Project
 * @author SonTT<js.trantrongson@gmail.com>
 */
function editProject($input) {
    global $modelOption;

    global $isRequestPost;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        $modelProject = new Project();
        $data = $modelProject->getProject($_GET['id']);
        if ($isRequestPost) {

            $dataSend = arrayMap($input['request']->data);

            $save['Project'] = $dataSend;

            $dk['_id'] = new MongoId($_GET['id']);

            if ($modelProject->updateAll($save['Project'], $dk)) {
                $modelProject->redirect($urlPlugins . 'admin/project-listProject.php?status=3');
            } else {
                $modelProject->redirect($urlPlugins . 'admin/project-addProject.php?status=-3');
            }
        }

        setVariable('data', $data);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Delete Project
 * @author SonTT<js.trantrongson@gmail.com>
 */
function deleteProject($input) {
    global $modelOption;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        $modelProject = new Project();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelProject->delete($idDelete);
        }
        $modelProject->redirect($urlPlugins . 'admin/project-listProject.php?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function project() {
    $modelProject = new Project();

    $data['vanhoa_connguoi'] = $modelProject->getPage(1, 999, array('chuyenmuc' => 'vanhoa_connguoi'));
    $data['kientruc_dothi'] = $modelProject->getPage(1, 999, array('chuyenmuc' => 'kientruc_dothi'));
    $data['thiennhien_sinhthai'] = $modelProject->getPage(1, 999, array('chuyenmuc' => 'thiennhien_sinhthai'));
    $data['doisong_xahoi'] = $modelProject->getPage(1, 999, array('chuyenmuc' => 'doisong_xahoi'));
    $data['thuonghieu'] = $modelProject->getPage(1, 999, array('chuyenmuc' => 'thuonghieu'));
    setVariable('data', $data);
}

function minisite() {
    global $urlHomes;
    global $modelOption;
    $modelProject = new Project();
    $data = $modelProject->getProject($_GET['id']);

    if (!empty($data)) {
        setVariable('data', $data);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

?>