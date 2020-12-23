<?php

function bookRoom($input) {
    global $isRequestPost;
    global $modelOption;

    $contact = $modelOption->getOption('contactSettings');

    $dataSend = arrayMap($input['request']->data);
    $returnSend = array('code' => -1, 'mess' => '');

    if ($isRequestPost && isset($dataSend['email']) && $dataSend['email'] != '') {
        
        $fullName = (isset($dataSend['fullName'])) ? $dataSend['fullName'] : '';
        $email = (isset($dataSend['email'])) ? $dataSend['email'] : '';
        $checkin = (isset($dataSend['checkin'])) ? $dataSend['checkin'] : '';
        $content = (isset($dataSend['content'])) ? $dataSend['content'] : '';
        $fone = (isset($dataSend['fone'])) ? $dataSend['fone'] : '';
        $contentFull = nl2br($content);
        $modelBook = new Book();
        $modelBook->saveBook($fullName, $email, $checkin, $contentFull, $fone);

        if (isset($contact['Option']['value']['sendEmail']) && $contact['Option']['value']['sendEmail'] == 1) {
            $from = array($contact['Option']['value']['email'] => $contact['Option']['value']['displayName']);
            $to = array($contact['Option']['value']['email']);
            $cc = array();
            $bcc = array();
            $subject = '[' . $contact['Option']['value']['displayName'] . '] Đặt lịch hẹn';
            $content = 'Họ tên: ' . $fullName . '<br/> 
								Email: ' . $email . '<br/> 
								Thời gian hẹn: ' . $checkin . '<br/>
								Nội dung: ' . nl2br($content);
            $modelBook->sendMail($from, $to, $cc, $bcc, $subject, $content);
        }

        $returnSend = array('code' => 1, 'mess' => 'Gửi yêu cầu thành công');
    }
    setVariable('returnSend', $returnSend);
}

    function deleteBook($input) {
        global $urlHomes;
        global $urlPlugins;
          $modelBook = new Book();
        if (checkAdminLogin()) {
            if (isset($input['request']->params['pass'][1])) {
                $idDelete = new MongoId($input['request']->params['pass'][1]);

                $modelBook->delete($idDelete);
            }
            $modelBook->redirect($urlPlugins . 'admin/bookRoom-listBook.php');
        } else {
            $modelBook->redirect($urlHomes);
        }
    }

    function listBook($input) {
        global $modelOption;
        global $urlHomes;
        global $urlNow;

       $modelBook = new Book();

        if (checkAdminLogin()) {
            $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
            if ($page <= 0)
                $page = 1;

            $limit = 15;
            $conditions = array();
            $listData = $modelBook->getPage($page, $limit);
           
            $totalData = $modelBook->find('count', array('conditions' => $conditions));

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
                $urlNow = str_replace('&page=' . $_GET['page'], '', $urlNow);
                $urlNow = str_replace('page=' . $_GET['page'], '', $urlNow);
            }

            if (strpos($urlNow, '?') !== false) {
                if (count($_GET) > 1) {
                    $urlNow = $urlNow . '&page=';
                } else {
                    $urlNow = $urlNow . 'page=';
                }
            } else {
                $urlNow = $urlNow . '?page=';
            }

            setVariable('listData', $listData);
            setVariable('page', $page);
            setVariable('totalPage', $totalPage);
            setVariable('back', $back);
            setVariable('next', $next);
            setVariable('urlNow', $urlNow);
        } else {
            $modelBook->redirect($urlHomes);
        }
    }

   
?>