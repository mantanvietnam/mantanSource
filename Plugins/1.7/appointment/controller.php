<?php

function appointment($input) {
    global $isRequestPost;
    global $modelOption;

    $returnSend = '';
    $appointment = $modelOption->getOption('appointmentSettings');

    $dataSend = arrayMap($input['request']->data);
    

    if ($isRequestPost && isset($dataSend['pm_app_form_email']) && $dataSend['pm_app_form_email'] != '') {
        $pm_app_form_name = (isset($dataSend['pm_app_form_name'])) ? $dataSend['pm_app_form_name'] : '';
        $pm_app_form_email = (isset($dataSend['pm_app_form_email'])) ? $dataSend['pm_app_form_email'] : '';
        $pm_app_form_phone = (isset($dataSend['pm_app_form_phone'])) ? $dataSend['pm_app_form_phone'] : '';
        $pm_app_form_date = (isset($dataSend['pm_app_form_date'])) ? $dataSend['pm_app_form_date'] : '';
        $pm_app_form_time = (isset($dataSend['pm_app_form_time'])) ? $dataSend['pm_app_form_time'] : '';
        $recaptcha = (isset($dataSend['recaptcha'])) ? $dataSend['recaptcha'] : '';

        if ($_SESSION['cap_code'] != $recaptcha) {
            $returnSend = '<h5 class="text-align-center" style="color: red;" ><span class="glyphicon glyphicon-remove"></span> Bạn nhập sai mã xác nhận!</h5>';
        } else {
            $modelAppointment = new Appointment();

            $modelAppointment->saveAppointment($pm_app_form_name, $pm_app_form_email, $pm_app_form_phone, $pm_app_form_date, $pm_app_form_time);
            $returnSend = '<h5 class="text-align-center" style="color: green;" ><span class="glyphicon glyphicon-ok"></span> Đặt lịch hẹn thành công!</h5>';

            if (isset($appointment['Option']['value']['sendEmail']) && $appointment['Option']['value']['sendEmail'] == 1) {
                $from = array($appointment['Option']['value']['email'] => $appointment['Option']['value']['displayName']);
                $to = array($appointment['Option']['value']['email']);
                $cc = array();
                $bcc = array();
                $subject = '[' . $appointment['Option']['value']['displayName'] . '] Appointment from website';
                $content = 'Full name: ' . $pm_app_form_name . '<br/> 
                                            Email: ' . $pm_app_form_email . '<br/> 
                                            Điện thoại: ' . $pm_app_form_phone . '<br/> 
                                            Ngày hẹn: ' . $pm_app_form_date . '<br/> 
                                            Thời gian hẹn: ' . $pm_app_form_time . '<br/> 
                                            Nội dung: ' . nl2br($content);

                $modelAppointment->sendMail($from, $to, $cc, $bcc, $subject, $content);
            }
        }
    }

    setVariable('returnSend', $returnSend);
    setVariable('appointment', $appointment);
}

function deleteAppointment($input) {
    global $urlHomes;
    global $urlPlugins;
    $modelAppointment = new Appointment();

    if (checkAdminLogin()) {
        if (isset($input['request']->params['pass'][1])) {
            $idDelete = new MongoId($input['request']->params['pass'][1]);

            $modelAppointment->delete($idDelete);
        }
        $modelAppointment->redirect($urlPlugins . 'admin/appointment-listAppointments.php');
    } else {
        $modelAppointment->redirect($urlHomes);
    }
}

function listAppointments($input) {
    global $urlHomes;
    global $urlNow;

    $modelAppointment = new Appointment();

    if (checkAdminLogin()) {
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;

        $limit = 15;
        $conditions = array();
        $listData = $modelAppointment->getPage($page, $limit);

        $totalData = $modelAppointment->find('count', array('conditions' => $conditions));

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
        $modelAppointment->redirect($urlHomes);
    }
}

function setting($input) {
    global $urlHomes;
    global $modelOption;
    global $isRequestPost;

    if (checkAdminLogin()) {
        $data = $modelOption->getOption('appointmentSettings');
        $mess = '';

        if ($isRequestPost) {

            $dataSend = $input['request']->data;

            $data['Option']['value']['sendEmail'] = (isset($_POST['sendEmail'])) ? (int) $_POST['sendEmail'] : 0;
            $data['Option']['value']['displayName'] = $dataSend['displayName'];
            $data['Option']['value']['email'] = $dataSend['email'];

            $modelOption->saveOption('appointmentSettings', $data['Option']['value']);

            $mess = 'Save Success';
        }

        setVariable('data', $data);
        setVariable('mess', $mess);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

?>