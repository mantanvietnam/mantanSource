<?php
function managerListWarranty($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    if (checkLoginManager()) {
        $modelWarranty = new Warranty();
        $modelPartner = new Partner();

        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0) $page = 1;
        $limit = 15;
        $conditions = array('idManager'=>$_SESSION['infoManager']['Manager']['id']);
      
        $listData = $modelWarranty->getPage($page, $limit, $conditions);

        if($listData){
            foreach($listData as $key=>$data){
                $partner= $modelPartner->getPartner($data['Warranty']['idPartner']);
                if(!empty($partner['Partner']['fullname'])){
                    $listData[$key]['Warranty']['fullname']= $partner['Partner']['fullname'];
                }else{
                    $listData[$key]['Warranty']['fullname']= 'Thợ tự do';
                }
            }
        }

        $totalData = $modelWarranty->find('count', array('conditions' => $conditions));

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

function managerAddWarranty($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;

    $modelWarranty = new Warranty();
    $modelPartner = new Partner();

    if (checkLoginManager()) {
    	if(!empty($_GET['id'])){
    		$save= $modelWarranty->getPartner($_GET['id']);
    		setVariable('data', $save);
    	}

        if ($isRequestPost) {
            $dataSend = arrayMap($input['request']->data);
            
            $save['Warranty']['idPartner'] = $dataSend['idPartner'];
            $save['Warranty']['phone'] = $dataSend['phone'];
            $save['Warranty']['note'] = $dataSend['note'];
            $save['Warranty']['timeEnd'] = date('d/m/Y H:i'); 
            
            $save['Warranty']['idManager'] = $_SESSION['infoManager']['Manager']['id'];

            if ($modelWarranty->save($save)) {
                $partner= $modelPartner->getPartner($dataSend['idPartner']);
                if($partner){
                    $partner['Partner']['timeEnd']= $save['Warranty']['timeEnd'];
                    $modelPartner->save($partner);
                }

                $modelWarranty->redirect($urlHomes . 'managerListWarranty?status=1');
            } else {
                $modelWarranty->redirect($urlHomes . 'managerListWarranty?status=-1');
            }
            
        }

        $conditions = array('idManager'=>$_SESSION['infoManager']['Manager']['id']);
        $listPartner = $modelPartner->find('all',array('conditions'=>$conditions,'field'=>array('fullname') ) );

        setVariable('listPartner', $listPartner);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function managerDeleteWarranty($input) {
    global $modelOption;
    global $urlHomes;


    if (checkLoginManager()) {
        $modelWarranty = new Warranty();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelWarranty->delete($idDelete);
        }
        $modelWarranty->redirect($urlHomes . 'managerListWarranty?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}
?>