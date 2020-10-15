<?php

function exportExam() {
    global $urlHomes;
    
    if (checkAdminLogin()) {
        $modelQuestions = new Questions;
        $modelTests = new Tests;
        if (isset($_GET['idTest'])) {

            $dataTest = $modelTests->getTest($_GET['idTest']);
            $allQuestion = $modelQuestions->allQuestions($_GET['idTest']);
            $countAllQuestion = count($allQuestion);
            if($countAllQuestion<=$dataTest['Tests']['numberQuestion']){
                $numberQuest = $countAllQuestion;
            }else{
                $numberQuest = $dataTest['Tests']['numberQuestion'];
            }
            $listQuestion = $modelQuestions->listQuestions($dataTest['Tests']['id'], $numberQuest);

            if (!empty($listQuestion)) {
                shuffle($listQuestion);
                foreach ($listQuestion as $key => $question) {
                    shuffle($listQuestion[$key]['Questions']['select']);
                }
                $_SESSION['listQuestionTest'] = $listQuestion;
            }
        }
        setVariable('listQuestion', $listQuestion);
        setVariable('dataTest', $dataTest);
    }
}

// danh sách loại đề thi - author:josvuduong
function typeOfExam() {
    global $modelOption;
    global $urlHomes;
    if (checkHomeLogin()) {
        $listTypeTest = $modelOption->getOption('typeTest');
        setVariable('listTypeTest', $listTypeTest);
    } else {
        $modelOption->redirect($urlHomes . 'login');
    }
}
function examInside(){
     global $modelOption;
    global $urlHomes;
    if (checkHomeLogin()) {
        $listTypeTest = $modelOption->getOption('typeTest');
      
        if(!empty($listTypeTest['Option']['value']['category'][$_GET['typeTest']]['sub']) && count($listTypeTest['Option']['value']['category'][$_GET['typeTest']]['sub'])>0){
            $listSub = $listTypeTest['Option']['value']['category'][$_GET['typeTest']]['sub'];
            setVariable('listSub', $listSub);
            }else{
                $modelOption->redirect($urlHomes . 'category?typeTest='.$_GET['typeTest']);
            }
        setVariable('listTypeTest', $listTypeTest);
    } else {
        $modelOption->redirect($urlHomes . 'login');
    }
    
}
//list đề thi -author:josvuduong
function category() {
    global $urlHomes;
    global $urlHomes;
    global $isRequestPost;
    global $urlNow;

    $modelTests = new Tests;
    if (checkHomeLogin()) {
        $modelTests = new Tests;
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 14;
        $conditions = array('typeTest' => $_GET['typeTest']);
        $listTest = $modelTests->getPage($page, $limit, $conditions);
        $totalData = $modelTests->find('count', array('conditions' => $conditions));
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
        setVariable('listTest', $listTest);
        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);
    } else {
        $modelTests->redirect($urlHomes . 'login');
    }
}

//list cau hoi-author:josvuduong
function startQuestion() {
    global $urlHomes;
    global $urlHomes;
    global $isRequestPost;
    global $urlNow;

    $modelQuestions = new Questions;
    $modelStudent = new Student;
    $modelTests = new Tests;
    if (checkHomeLogin()) {
        if (isset($_GET['idTest'])) {

            $dataTest = $modelTests->getTest($_GET['idTest']);
            $listQuestion = $modelQuestions->listQuestions($dataTest['Tests']['id'], $dataTest['Tests']['numberQuestion']);

            if (!empty($listQuestion)) {
                //shuffle($listQuestion);
                foreach ($listQuestion as $key => $question) {
                    shuffle($listQuestion[$key]['Questions']['select']);
                }
                $_SESSION['listQuestionTest'] = $listQuestion;
            }
        }

        setVariable('listQuestion', $listQuestion);
        setVariable('dataTest', $dataTest);
    } else {
        $modelTests->redirect($urlHomes . 'login');
    }
}

//kết quả bài thi -author:josvuduong
function result($input) {
    global $urlHomes;
    global $urlHomes;
    global $isRequestPost;
    global $urlNow;

    $modelTests = new Tests;
    $modelStudent = new Student;
    $modelQuestions = new Questions;
    if (checkHomeLogin()) {
        if (isset($_GET['idTest'])) {
            $listQuestion = $_SESSION['listQuestionTest'];
            $questionTrue = 0;
            foreach ($listQuestion as $question) {
                if (!empty($_POST['Question' . $question['Questions']['id']])) {
                    if ($_POST['Question' . $question['Questions']['id']] == $question['Questions']['result']) {
                        $questionTrue++;
                    }
                }
            }
            $n = count($listQuestion);
            $diem1cau = 10 / $n;
            $point = $questionTrue * $diem1cau;
            $dataSend = $input['request']->data;
            if (isset($_SESSION)) {
                $_SESSION['dataAccount']['Student']['listQuestionTest'][$_GET['idTest']] = $listQuestion;
                $_SESSION['dataAccount']['Student']['ketqua'][$_GET['idTest']]['luachon'] = $dataSend;
                $_SESSION['dataAccount']['Student']['ketqua'][$_GET['idTest']]['socauhoi'] = $n;
                $_SESSION['dataAccount']['Student']['ketqua'][$_GET['idTest']]['socaudung'] = $questionTrue;
                $_SESSION['dataAccount']['Student']['ketqua'][$_GET['idTest']]['point'] = $point;
                $modelStudent->save($_SESSION['dataAccount']['Student']);
            }
        }
        $modelTests->redirect($urlHomes . 'infoTest?typeTest=' . $dataSend['typeTest'] . '&idTest=' . $_GET['idTest']);
    } else {
        $modelTests->redirect($urlHomes . 'login');
    }
}

//thông tin bài thi - author:josvuduong
function infoTest() {
    global $urlHomes;
    global $urlHomes;
    global $isRequestPost;
    global $urlNow;
    $modelTests = new Tests;

    if (checkHomeLogin()) {
        if (isset($_GET['idTest'])) {
            $data = $modelTests->getTest($_GET['idTest']);
            setVariable('data', $data);
        }
    } else {
        $modelTests->redirect($urlHomes . 'login');
    }
}

function register() {
    global $urlHomes;
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwordAgain'])) {

        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $passwordAgain = $_POST['passwordAgain'];
        $email = $_POST['email'];
        $sex = $_POST['sex'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $modelStudent = new Student();
        $dataUserName = $modelStudent->getStudentByUsername($username);
        setVariable('dataUserName', $dataUserName);

        if ($password == $passwordAgain && strlen($password) >= 6) {
            $password = md5($_POST['password']);

            if (!empty($dataUserName)) {
                $modelStudent->redirect($urlHomes . 'register?status=2');
            } else {
                $modelStudent->saveNewStudent($fullname, $username, $password, $email, $sex, $phone, $address);
                $modelStudent->redirect($urlHomes . 'register?status=1');
            }
        } else {
            $modelStudent->redirect($urlHomes . 'register?status=3');
        }
    }
}

function login() {
    global $urlHomes;

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $modelStudent = new Student;
        $dataAccount = $modelStudent->checkLogin($username, $password);
        if ($dataAccount) {
            $_SESSION['dataAccount'] = $dataAccount;
            $modelStudent->redirect($urlHomes);
        } else {
            $modelStudent->redirect($urlHomes . '?status=-1');
        }
    }
}

function logOut() {
    global $urlHomes;
    $modelStudent = new Student;
    session_destroy();
    $modelStudent->redirect($urlHomes);
}

function edit() {

    global $urlHomes;
    $modelStudent = new Student;
    $dataAccount = $_SESSION['dataAccount'];
    if (isset($_POST['id'])) {
        // Doi thong tin binh thuong
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $password = $dataAccount['Student']['password'];
        $email = $_POST['email'];
        $sex = $_POST['sex'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $id = $_POST['id'];
        // Xu ly neu co doi mat khau	
        $passwordOld = $_POST['passwordOld'];
        $passwordNew = $_POST['passwordNew'];
        $passwordAgain = $_POST['passwordAgain'];

        if (!empty($passwordNew)) {
            if (md5($passwordOld) == $password && $passwordNew == $passwordAgain) {
                $password = md5($passwordNew);
            } else {
                $modelStudent->redirect($urlHomes . 'edit?status=2');
            }
        }
        $modelStudent->saveNewStudent($fullname, $username, $password, $email, $sex, $phone, $address, $id);
        $dataAccount = $modelStudent->checkLogin($username, $password);
        $_SESSION['dataAccount'] = $dataAccount;
    }
}

?>