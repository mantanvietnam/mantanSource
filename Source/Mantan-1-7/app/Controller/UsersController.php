<?php

class UsersController extends AppController {

    var $name = 'Users';
    var $helpers = array('Session', 'Paginator');
    var $paginate = array();

    function listUser() {
        $this->setup();

        Controller::loadModel('User');
        $urlLocal = $this->getUrlLocal();
        $urlNow = curPageURL(1);

        if (checkAdminLogin()) {
            $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
            if ($page <= 0)
                $page = 1;
            $limit = 15;
            $conditions = array();

            $listData = $this->User->getPage($page, $limit);

            $totalData = $this->User->find('count', array('conditions' => $conditions));

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
                if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
                    $urlPage = $urlPage . '&page=';
                } else {
                    $urlPage = $urlPage . 'page=';
                }
            } else {
                $urlPage = $urlPage . '?page=';
            }

            $this->set('listData', $listData);
            $this->set('page', $page);
            $this->set('totalPage', $totalPage);
            $this->set('back', $back);
            $this->set('next', $next);
            $this->set('urlPage', $urlPage);
        } else {
            $this->redirect($urlLocal['urlAdmins'] . 'login');
        }
    }

    function addUser($idUser = null) {
        $this->setup();

        Controller::loadModel('User');
        $urlLocal = $this->getUrlLocal();

        if (checkAdminLogin()) {
            $data = $this->User->getUser($idUser);

            $this->set('data', $data);
        } else {
            $this->redirect($urlLocal['urlAdmins'] . 'login');
        }
    }

    function saveUserAdmin() {
        $this->setup();

        Controller::loadModel('User');
        $urlLocal = $this->getUrlLocal();

        if (checkAdminLogin() && $this->request->is('post')) {
            $dataSend = arrayMap($_POST);

            $save['User']['fullname'] = $dataSend['fullname'];
            $save['User']['email'] = $dataSend['email'];
            $save['User']['phone'] = $dataSend['phone'];
            $save['User']['address'] = $dataSend['address'];
            if (mb_strlen($dataSend['password']) >= 6) {
                $save['User']['password'] = md5($dataSend['password']);
            }

            if ($dataSend['idUser'] != '') {
                $dk['_id'] = new MongoId($dataSend['idUser']);
                $this->User->updateAll($save['User'], $dk);
            } else {
                $save['User']['user'] = $dataSend['user'];

                $checkUserName = $this->User->getUserCode($save['User']['user']);
                if (!$checkUserName) {
                    $this->User->save($save);
                } else {
                    $this->redirect($urlLocal['urlUsers'] . 'addUser?status=-1');
                }
            }

            $this->redirect($urlLocal['urlUsers'] . 'listUser');
        } else {
            $this->redirect($urlLocal['urlAdmins'] . 'login');
        }
    }

    function deleteUser() {
        $this->setup();

        Controller::loadModel('User');
        $urlLocal = $this->getUrlLocal();

        if (checkAdminLogin()) {
            if (isset($_GET['id'])) {
                $idDelete = new MongoId($_GET['id']);
                $this->User->delete($idDelete);
            }
            $this->redirect($urlLocal['urlUsers'] . 'listUser');
        } else {
            $this->redirect($urlLocal['urlAdmins'] . 'login');
        }
    }

    // Frontend
    function checkLogin() {
        $this->setup();

        $dataSend = arrayMap($_POST);

        Controller::loadModel('User');
        $urlLocal = $this->getUrlLocal();

        if (isset($dataSend['username']) && isset($dataSend['password'])) {
            $username = $dataSend['username'];
            $password = md5($dataSend['password']);

            $user = $this->User->checkLogin($username, $password);
            if ($user) {
                $_SESSION['infoUser'] = $user;

                if(!empty($dataSend['linkRedirect'])){
                    $this->redirect($dataSend['linkRedirect']);
                }else{
                    $this->redirect($urlLocal['urlHomes']);
                }
            } else {
                $this->redirect(getUrlUserLogin() . '?status=-1');
            }
        } else {
            $this->redirect($urlLocal['urlHomes']);
        }
    }

    function saveUser() {
        $this->setup();

        $dataSend = arrayMap($_POST);
        Controller::loadModel('User');
        Controller::loadModel('Option');
        $urlLocal = $this->getUrlLocal();

        $contactSite = $this->Option->getOption('contact');
        $smtpSite = $this->Option->getOption('smtpSetting');
        $language = $this->Option->getOption('language');

        include($urlLocal['urlLocalLanguage'] . '/' . $language['Option']['value']['file']);

        if ($this->request->is('post') && isset($dataSend['fullname']) && isset($dataSend['username']) && isset($dataSend['email']) && isset($dataSend['phone']) && isset($dataSend['address']) && isset($dataSend['password']) && isset($dataSend['passwordAgain'])) {
            $save = array();

            $save['User']['fullname'] = $dataSend['fullname'];
            $save['User']['user'] = $dataSend['username'];
            $save['User']['email'] = $dataSend['email'];
            $save['User']['sex'] = $dataSend['sex'];
            $save['User']['phone'] = $dataSend['phone'];
            $save['User']['address'] = $dataSend['address'];
            if ($dataSend['password'] == $dataSend['passwordAgain'] && $dataSend['password'] != '') {
                $save['User']['password'] = md5($dataSend['password']);

                if ($save['User']['fullname'] != '' && $save['User']['user'] != '' && $save['User']['email'] != '' && $save['User']['phone'] != '' && $save['User']['address'] != '') {
                    $checkUserName = $this->User->getUserCode($save['User']['user']);
                    if (!$checkUserName) {
                        $this->User->save($save);

                        // send email for user and admin
                        $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                        $to = array(trim($dataSend['email']), trim($contactSite['Option']['value']['email']));
                        $cc = array();
                        $bcc = array();
                        $subject = '[' . $smtpSite['Option']['value']['show'] . '] ' . $languageMantan['registerSuccess'];

                        // create content email

                        $content = $languageMantan['hello'] . ' ' . $dataSend['fullname'] . ' !<br/><br/>
										' . $languageMantan['login'] . ': ' . $urlHomes . getUrlUserLogin() . '<br/><br/>
										' . $languageMantan['information'] . ':<br/>
										' . $languageMantan['account'] . ': ' . $dataSend['username'] . '<br/>
										' . $languageMantan['password'] . ': ' . $dataSend['password'] . '<br/>
										' . $languageMantan['email'] . ': ' . $dataSend['email'] . '<br/>
										' . $languageMantan['telephoneNumber'] . ': ' . $dataSend['phone'] . '<br/>
										' . $languageMantan['address'] . ': ' . $dataSend['address'] . '<br/>';


                        $this->User->sendMail($from, $to, $cc, $bcc, $subject, $content);

                        $this->redirect(getUrlUserRegister() . '?status=1');
                    } else
                        $this->redirect(getUrlUserRegister() . '?status=-2');
                } else
                    $this->redirect(getUrlUserRegister() . '?status=-1');
            } else
                $this->redirect(getUrlUserRegister() . '?status=-3');
        }else {
            $this->redirect($urlLocal['urlHomes']);
        }
    }

    function logout() {
        $this->setup();
        $urlLocal = $this->getUrlLocal();
        $this->layout = 'default';
        session_destroy();
        $this->redirect($urlLocal['urlHomes']);
    }

    function login() {
        $this->setup();
        $urlLocal = $this->getUrlLocal();
        $this->layout = 'default';

        if(!empty($_SESSION['infoUser'])){
            $this->redirect($urlLocal['urlHomes']);
        }
    }

    function register() {
        $this->setup();
        $this->layout = 'default';
        
        $cap_code= rand(100000, 999999);
        $_SESSION['capchaCodeRegister'] = $cap_code;
        $this->set('capchaCode', $cap_code);
    }

    function infoUser() {
        $this->setup();
        $this->layout = 'default';
        global $urlHomes;
        $modelUser = new User();
        if (!empty($_SESSION['infoUser'])) {
            $dataUser = $modelUser->getUser($_SESSION['infoUser']['User']['id']);
            if (!empty($_POST)) {
                $dataSend = $dataSend = arrayMap($_POST);

                $data['User']['fullname'] = $_SESSION['infoUser']['User']['fullname'] = $dataSend['fullname'];
                $data['User']['phone'] = $_SESSION['infoUser']['User']['phone'] = $dataSend['phone'];
                $data['User']['sex'] = $_SESSION['infoUser']['User']['sex'] = isset($dataSend['sex']) ? $dataSend['sex'] : '';
                $data['User']['address'] = $_SESSION['infoUser']['User']['address'] = isset($dataSend['address']) ? $dataSend['address'] : '';
                $data['User']['cmnd'] = $_SESSION['infoUser']['User']['cmnd'] = isset($dataSend['cmnd']) ? $dataSend['cmnd'] : '';
                $data['User']['cmnd_address'] = $_SESSION['infoUser']['User']['cmnd_address'] = isset($dataSend['cmnd_address']) ? $dataSend['cmnd_address'] : '';
                $data['User']['cmnd_date'] = $_SESSION['infoUser']['User']['cmnd_date'] = isset($dataSend['cmnd_date']) ? strtotime($dataSend['cmnd_date']) : '';

                $dk['_id'] = new MongoId($_SESSION['infoUser']['User']['id']);

                if ($modelUser->updateAll($data['User'], $dk)) {
                    $modelUser->redirect($urlHomes . 'users/infoUser?stt=1');
                }
            }

            setVariable('dataUser', $dataUser);
        }else{
            $this->redirect($urlHomes);
        }
    }

    function changePassword() {
        $this->setup();
        $this->layout = 'default';

        global $isRequestPost;
        global $urlHomes;
        global $modelOption;
        $modelUser = new User();
        $contactSite = $modelOption->getOption('contact');
        $smtpSite = $modelOption->getOption('smtpSetting');

        if (!empty($_SESSION['infoUser'])) {

            if (!empty($_POST)) {
                $dataSend = arrayMap($_POST);
                

                $dataUser = $modelUser->getUser($_SESSION['infoUser']['User']['id']);

                if (md5($dataSend['oldPassword']) == $dataUser['User']['password']) {
                    if ($dataSend['password'] == $dataSend['passwordAgain']) {

                        $data['User']['password'] = md5($dataSend['password']);
                        $dk['_id'] = new MongoId($_SESSION['infoUser']['User']['id']);

                        if ($modelUser->updateAll($data['User'], $dk)) {

                            // send email for user and admin
                            $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                            $to = array(trim($dataUser['User']['email']), trim($contactSite['Option']['value']['email']));
                            $cc = array();
                            $bcc = array();
                            $subject = '[' . $smtpSite['Option']['value']['show'] . '] ' . 'Thay đổi mật khẩu thành công!';

                            // create content email

                            $content = 'Xin chào '
                                    . $dataUser['User']['fullname'] . ' !<br/><br/>
                                Bạn đã thay đổi mật khẩu thành công! Mật khẩu mới của bạn là: ' . $dataSend['password'] . '<br/><br/>';

                            $modelUser->sendMail($from, $to, $cc, $bcc, $subject, $content);
                            $modelUser->redirect($urlHomes . 'users/infoUser?stt=4');
                        }
                    } else {
                        $modelUser->redirect($urlHomes . 'users/infoUser?stt=3');
                    }
                } else {
                    $modelUser->redirect($urlHomes . 'users/infoUser?stt=2');
                }
            }
        }
    }
    function forgetPassword() {
        $this->setup();
        $this->layout = 'default';
        global $urlHomes;
        global $contactSite;
        global $smtpSite;
        if (!empty($_POST)) {
            $modelUser = new User();
            $dataUser = $modelUser->isExistUser($_POST['user'],$_POST['email']);

            //debug ($infoManager);
            if (empty($dataUser)) {
                $modelUser->redirect($urlHomes . 'users/forgetPassword?status=-4');
                die;
            } else {
                $newPass = rand(11111111, 99999999);
                $dataUser['User']['password'] = md5($newPass);

                $id = new MongoId($dataUser['User']['id']);
                
                if ($modelUser->updateAll($dataUser['User'], array('_id' => $id))) {
                    
                    // send email for user and admin
                    $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                    $to = array(trim($dataUser['User']['email']), trim($contactSite['Option']['value']['email']));
                    $cc = array();
                    $bcc = array();
                    $subject = '[' . $smtpSite['Option']['value']['show'] . '] ' .'Thay đổi mật khẩu thành công';

                    // create content email
                    $content = 'Xin chào ' . $dataUser['User']['fullname'] . '!<br> ' . 'Bạn đã thay đổi mật khẩu thành công' . '<br>';
                    $content.= 'Dưới đây là thông tin đăng nhập của bạn:<br>';
                    $content.= 'Link đăng nhập: <a href="' . $urlHomes . 'users/login">' . $urlHomes . 'users/login</a><br>';
                    $content.= 'Tên đăng nhập: ' . $dataUser['User']['user'] . '<br>';
                    $content.= 'Mật khẩu mới: ' . $newPass . '<br>';

                    if ($modelUser->sendMail($from, $to, $cc, $bcc, $subject, $content)) {
                        $modelUser->redirect($urlHomes . 'users/forgetPassword?status=1');
                    }
                }
            }
        }
    }
    function index() {
        $this->setup();
        $this->layout = 'default';
    }

}

?>