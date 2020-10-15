<?php
function managerListPartner($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    if (checkLoginManager()) {
        $modelPartner = new Partner();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0) $page = 1;
        $limit = 15;
        $conditions = array('idManager'=>$_SESSION['infoManager']['Manager']['id']);
      
        $listData = $modelPartner->getPage($page, $limit, $conditions);

        $totalData = $modelPartner->find('count', array('conditions' => $conditions));

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

function managerAddPartner($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    $modelPartner = new Partner();

    if (checkLoginManager()) {
    	if(!empty($_GET['id'])){
    		$save= $modelPartner->getPartner($_GET['id']);
    		setVariable('data', $save);
    	}

        if ($isRequestPost) {
            $dataSend = arrayMap($input['request']->data);
            
            $save['Partner']['fullname'] = $dataSend['fullname'];
            $save['Partner']['email'] = $dataSend['email'];
            $save['Partner']['phone'] = $dataSend['phone'];
            $save['Partner']['address'] = $dataSend['address'];
            $save['Partner']['career'] = $dataSend['career'];
            $save['Partner']['note'] = $dataSend['note'];
            
            $save['Partner']['idManager'] = $_SESSION['infoManager']['Manager']['id'];

            if(empty($_GET['id'])){
            	$save['Partner']['timeEnd'] = '';
            }

            if ($modelPartner->save($save)) {
                $modelPartner->redirect($urlHomes . 'managerListPartner?status=1');
            } else {
                $modelPartner->redirect($urlHomes . 'managerListPartner?status=-1');
            }
            
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function managerDeletePartner($input) {
    global $modelOption;
    global $urlHomes;


    if (checkLoginManager()) {
        $modelPartner = new Partner();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelPartner->delete($idDelete);
        }
        $modelPartner->redirect($urlHomes . 'managerListPartner?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}
?>