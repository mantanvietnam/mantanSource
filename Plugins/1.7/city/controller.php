<?php
/**
 * List City
 * @author SonTT<js.trantrongson@gmail.com>
 */
function listCity($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;
    if (checkAdminLogin()) {
        $modelCity = new City();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();
        if (!empty($_GET['khu-vuc'])) {
            $conditions['khuvuc'] = $_GET['khu-vuc'];
        }
        if (!empty($_GET['tinh-thanh'])) {
            $conditions['$or'][0]['name'] = array('$regex' => strtolower($_GET['tinh-thanh']));
            $conditions['$or'][1]['name'] = array('$regex' => strtoupper($_GET['tinh-thanh']));
            $conditions['$or'][2]['slug'] = array('$regex' => createSlugMantan(strtoupper($_GET['tinh-thanh'])));
        }

        $listData = $modelCity->getPage($page, $limit);

        $totalData = $modelCity->find('count', array('conditions' => $conditions));

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
 * Add City
 * @author SonTT<js.trantrongson@gmail.com>
 */
function addCity($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {

        if ($isRequestPost) {
            $modelCity = new City();
            $dataSend = arrayMap($input['request']->data);

            $save['City'] = $dataSend;

            if ($modelCity->save($save)) {
                $modelCity->redirect($urlPlugins . 'admin/city-listCity.php?status=1');
            } else {
                $modelCity->redirect($urlPlugins . 'admin/city-addCity.php?status=-1');
            }
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}
/**
 * Edit City
 * @author SonTT<js.trantrongson@gmail.com>
 */
function editCity($input) {
    global $modelOption;

    global $isRequestPost;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        $modelCity = new City();
        $data = $modelCity->getCity($_GET['id']);
        if ($isRequestPost) {

            $dataSend = $input['request']->data;

            $save['City'] = $dataSend;

            $dk['_id'] = new MongoId($_GET['id']);

            if ($modelCity->updateAll($save['City'], $dk)) {
                $modelCity->redirect($urlPlugins . 'admin/city-listCity.php?status=3');
            } else {
                $modelCity->redirect($urlPlugins . 'admin/city-addCity.php?status=-3');
            }
        }

        setVariable('data', $data);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Delete City
 * @author SonTT<js.trantrongson@gmail.com>
 */
function deleteCity($input) {
    global $modelOption;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        $modelCity = new City();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelCity->delete($idDelete);
        }
        $modelCity->redirect($urlPlugins . 'admin/city-listCity.php?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function city() {
    $modelCity = new City();
    $data = $modelCity->getCity($_GET['id']);
    setVariable('data', $data);
}

?>