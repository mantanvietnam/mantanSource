<?php

function setting($input) {
    global $modelOption;
    global $urlHomes;
    global $modelNotice;
    global $languageMantan;
    global $isRequestPost;

    if (checkAdminLogin()) {
        $mess = '';
        $listPage = $modelNotice->getAllPage();

        $data = $modelOption->getOption('mobileAppApiSettings');

        if ($isRequestPost) {

            $data['Option']['value']['idAboutPage'] = $input['request']->data['idAboutPage'];
            $modelOption->saveOption('mobileAppApiSettings', $data['Option']['value']);
            $mess = $languageMantan['saveSuccess'];
        }

        setVariable('listPage', $listPage);
        setVariable('mess', $mess);
        setVariable('data', $data);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function listNotification($input) {
    global $isRequestPost;
    global $urlHomes;
    global $urlNow;


    $modelNotification = new Notification();
    
    if (checkAdminLogin()) {
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0) $page = 1;
        $limit = 15;
        $conditions = array();
        $mess = '';
        
        if ($isRequestPost) {
            $dataSend = $input['request']->data;
            $modelNotification->saveNotification($dataSend);
            $mess = 'Lưu dữ liệu thành công';
        }

        $listData = $modelNotification->getPage($page, $limit, $conditions);
        
        $totalData= $modelNotification->find('count',array('conditions' => $conditions));
        $balance= $totalData%$limit;
        $totalPage= ($totalData-$balance)/$limit;
        if($balance>0)$totalPage+=1;

        $back=$page-1;$next=$page+1;
        if($back<=0) $back=1;
        if($next>=$totalPage) $next=$totalPage;

        if(isset($_GET['page'])){
            $urlPage= str_replace('&page='.$_GET['page'], '', $urlNow);
            $urlPage= str_replace('page='.$_GET['page'], '', $urlPage);
        }else{
            $urlPage= $urlNow;
        }

        if(strpos($urlPage,'?')!== false){
            if(count($_GET)>1){
                    $urlPage= $urlPage.'&page=';
            }else{
                    $urlPage= $urlPage.'page=';
            }
        }else{
            $urlPage= $urlPage.'?page=';
        }

        setVariable('page',$page);
        setVariable('totalPage',$totalPage);
        setVariable('back',$back);
        setVariable('next',$next);
        setVariable('urlPage',$urlPage);

        setVariable('listData', $listData);
        setVariable('mess', $mess);
    } else {
        $modelNotification->redirect($urlHomes);
    }
}

function deleteNotification($input)
{
    global $isRequestPost;
    global $urlHomes;
    $modelNotification = new Notification();
    
    if (checkAdminLogin()) {
        if ($isRequestPost) {
            $idDelete= new MongoId($input['request']->data['id']);
            $modelNotification->delete($idDelete);
        }
    } 
}

?>