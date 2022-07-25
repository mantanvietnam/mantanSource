<?php 
function managerHistory($input) {
    global $urlHomes;
    global $urlNow;
    global $modelUser;
    setVariable('permission', 'managerHistory');

    $modelHistory = new History();

    if (!empty($_SESSION['infoManager'])) {
        $mess= '';

        $limit = 15;
        $conditions = array();
        $conditions['idManager'] = $_SESSION['infoManager']['Manager']['id'];

        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0) $page = 1;

        $listData = $modelHistory->getPage($page, $limit, $conditions, $order = array('created' => 'desc'));

        $totalData = $modelHistory->find('count', array('conditions' => $conditions));

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
            if (count($_GET) >= 1) {
                $urlPage = $urlPage . '&page=';
            } else {
                $urlPage = $urlPage . 'page=';
            }
        } else {
            $urlPage = $urlPage . '?page=';
        }
        
        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);
        
        setVariable('listData', $listData);
        setVariable('mess', $mess);
    } else {
        $modelHistory->redirect('/login');
    }
}
?>