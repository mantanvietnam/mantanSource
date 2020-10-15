<?php

//danh sách các tỉnh
//author:Josduong
function listCityAdmin($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlPlugins;
    if (checkAdminLogin()) {
        $listData = $modelOption->getOption('cityMantanHotel');
        if ($isRequestPost) {
            $dataSend = $input['request']->data;
            if (mb_strlen($dataSend['name']) > 0) {
                if ($dataSend['id'] == '') {
                    if (!isset($listData['Option']['value']['tData'])) {
                        $listData['Option']['value']['tData'] = 1;
                    } else {
                        $listData['Option']['value']['tData'] += 1;
                    }

                    $listData['Option']['value']['allData'][$listData['Option']['value']['tData']] = array('id' => $listData['Option']['value']['tData'], 'name' => $dataSend['name']);
                } else {
                    $idEdit = (int) $dataSend['id'];
                    $listData['Option']['value']['allData'][$idEdit]['name'] = $dataSend['name'];
                }
                $modelOption->saveOption('cityMantanHotel', $listData['Option']['value']);
            } else {
                $modelOption->redirect($urlPlugins . 'admin/mantanHotel-admin-city-listCityAdmin.php');
            }
        }
        setVariable('listData', $listData);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function deleteCityAdmin($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    if (checkAdminLogin()) {
        if ($isRequestPost) {

            $dataSend = $input['request']->data;
            $listData = $modelOption->getOption('cityMantanHotel');
            $idDelete = (int) $dataSend['id'];
            unset($listData['Option']['value']['allData'][$idDelete]);
            $modelOption->saveOption('cityMantanHotel', $listData['Option']['value']);
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

//danh sách các loại khách sạn
function listHotelTypes($input) {
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $urlPlugins;
    if (checkAdminLogin()) {
        $listData = $modelOption->getOption('HotelTypes');
        if ($isRequestPost) {
            $dataSend = $input['request']->data;
            if (!empty($dataSend['name']) && !empty($dataSend['code'])) {
                if ($dataSend['id'] == '') {
                    if (!isset($listData['Option']['value']['tData'])) {
                        $listData['Option']['value']['tData'] = 1;
                    } else {
                        $listData['Option']['value']['tData'] += 1;
                    }

                    $listData['Option']['value']['allData'][$listData['Option']['value']['tData']] = array(
                        'id' => $listData['Option']['value']['tData'],
                        'code' => $dataSend['code'],
                        'name' => $dataSend['name'],
                        'describe' => $dataSend['describe']
                    );
                } else {
                    $idEdit = (int) $dataSend['id'];
                    $listData['Option']['value']['allData'][$idEdit]['code'] = $dataSend['code'];
                    $listData['Option']['value']['allData'][$idEdit]['name'] = $dataSend['name'];
                    $listData['Option']['value']['allData'][$idEdit]['describe'] = $dataSend['describe'];
                }
                $modelOption->saveOption('HotelTypes', $listData['Option']['value']);
            } else {
                $modelOption->redirect($urlPlugins . 'admin/mantanHotel-admin-hotel-listHotelTypes.php');
            }
        }
        setVariable('listData', $listData);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

//danh sách khách sạn
function listHotelAdmin($input) {
    global $modelOption;
    global $urlHomes;
    global $urlPlugins;
    global $urlNow;
    $modelHotel = new Hotel();
    if (checkAdminLogin()) {
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0) {
            $page = 1;
        }
        $listData = $modelHotel->getPageAdmin($page, $limit = 30, $conditions = array(), $order = array('created' => 'desc', 'name' => 'asc'), $field = array());

        if (!empty($_GET['idHotel'])) {
            $idHotel = $_GET['idHotel'];
            $data = $modelHotel->getHotel($idHotel);

            if ($data['Hotel']['best'] == 0) {
                $data['Hotel']['best'] = 1;
            } else {
                $data['Hotel']['best'] = 0;
            }

            $dk['_id'] = new MongoId($idHotel);

            if ($modelHotel->updateAll($data['Hotel'], $dk)) {
                $modelHotel->redirect($urlPlugins . 'admin/mantanHotel-admin-hotel-listHotelAdmin.php');
            }
        }
        $totalData = $modelHotel->find('count', array('conditions' => array()));

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
 * Delete hotel
 * @author SonTT<js.trantrongson@gmail.com>
 */
function deleteHotelAdmin($input) {
    global $modelOption;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        $modelHotel = new Hotel();
        if (isset($_GET['idHotel'])) {
            $idDelete = new MongoId($_GET['idHotel']);

            if ($modelHotel->delete($idDelete)) {
                $modelHotel->redirect($urlPlugins . 'admin/mantanHotel-admin-hotel-listHotelAdmin.php?status=4');
            }
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function deleteHotelTypes($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    if (checkAdminLogin()) {
        if ($isRequestPost) {
            $dataSend = $input['request']->data;
            $listData = $modelOption->getOption('HotelTypes');
            $idDelete = (int) $dataSend['id'];
            unset($listData['Option']['value']['allData'][$idDelete]);
            $modelOption->saveOption('HotelTypes', $listData['Option']['value']);
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

//danh sách các quận huyện
//author:Josduong
function listDistrictAdmin($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlPlugins;
    if (checkAdminLogin()) {
        $listData = $modelOption->getOption('cityMantanHotel');

        if (!isset($_GET['idCity']) || !isset($listData['Option']['value']['allData'][$_GET['idCity']])) {
            $modelOption->redirect($urlPlugins . 'admin/mantanHotel-admin-city-listDistrictAdmin.php');
        }

        if ($isRequestPost) {
            $dataSend = $input['request']->data;
            if (!empty($input['request']->query['idCity'])) {
                $idCity = $input['request']->query['idCity'];
            } else {
                $idCity = '';
            }
            if (mb_strlen($dataSend['name']) > 0) {
                if ($dataSend['id'] == '') {
                    if (!isset($listData['Option']['value']['allData'][$idCity]['tDistrict'])) {
                        $listData['Option']['value']['allData'][$idCity]['tDistrict'] = 1;
                    } else {
                        $listData['Option']['value']['allData'][$idCity]['tDistrict'] += 1;
                    }
                    $tDistrict = $listData['Option']['value']['allData'][$idCity]['tDistrict'];
                    $listData['Option']['value']['allData'][$idCity]['district'][$tDistrict] = array(
                        'id' => $tDistrict,
                        'name' => $dataSend['name']
                    );
                } else {
                    if (!empty($input['request']->query['idCity'])) {
                        $idCity = $input['request']->query['idCity'];
                    } else {
                        $idCity = '';
                    }
                    $idEdit = (int) $dataSend['id'];
                    $listData['Option']['value']['allData'][$idCity]['district'][$idEdit]['name'] = $dataSend['name'];
                }
                $modelOption->saveOption('cityMantanHotel', $listData['Option']['value']);
            } else {
                $modelOption->redirect($urlPlugins . 'admin/mantanHotel-admin-city-listDistrictAdmin.php');
            }
        }
        setVariable('listData', $listData);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function deleteDistrictAdmin($input) {
    if (checkAdminLogin()) {
        global $modelOption;
        global $isRequestPost;

        if ($isRequestPost) {
            $dataSend = $input['request']->data;
            $listData = $modelOption->getOption('cityMantanHotel');

            $idCity = $dataSend['idCity'];
            $idDelete = $dataSend['id'];
            unset($listData['Option']['value']['allData'][$idCity]['district'][$idDelete]);
            $modelOption->saveOption('cityMantanHotel', $listData['Option']['value']);
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * List Manager
 * @author SonTT<js.trantrongson@gmail.com>
 */
function listManager($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    if (checkAdminLogin()) {
        $modelManager = new Manager();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0) {
            $page = 1;
        }
        $limit = 30;
        $conditions = array();
        $order = array('deadline' => 'asc');

        $listData = $modelManager->getPage($page, $limit, $conditions, $order);

        $totalData = $modelManager->find('count', array('conditions' => $conditions));

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
 * Add Manager
 * @author SonTT<js.trantrongson@gmail.com>
 */
function addManager($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $urlPlugins;
    global $gmpThemeSettings;
    $contactSite = $modelOption->getOption('contact');
    $smtpSite = $modelOption->getOption('smtpSetting');

    if (checkAdminLogin()) {
        if ($isRequestPost) {
            $modelManager = new Manager();
            $dataSend = arrayMap($input['request']->data);

            if ($modelManager->isExistUser($dataSend['user'])) {
                $mess = 'Tài khoản đã tồn tại!';
                setVariable('mess', $mess);
            } else {
                $save['Manager']['user'] = $dataSend['user'];
                $save['Manager']['fullname'] = $dataSend['fullname'];
                $save['Manager']['avatar'] = $dataSend['avatar'];
                $save['Manager']['email'] = $dataSend['email'];
                $save['Manager']['phone'] = $dataSend['phone'];
                $save['Manager']['address'] = $dataSend['address'];
                $save['Manager']['password'] = md5($dataSend['password']);
                $save['Manager']['actived'] = (int) $dataSend['actived'];
                $save['Manager']['numberRoomMax'] = (int) $dataSend['numberRoomMax'];
                $save['Manager']['agency'] = $dataSend['agency'];
                
                if(!empty($dataSend['deadline'])){
                    $deadline= explode('-', $dataSend['deadline']);

                    $save['Manager']['deadline']= mktime(23,59,59,$deadline[1],$deadline[0],$deadline[2]);
                }

                if (!empty($dataSend['desc'])) {
                    $save['Manager']['desc'] = $dataSend['desc'];
                }

                if ($modelManager->save($save)) {
                    // send email for user and admin
                    
                    $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                    $to = array(trim($contactSite['Option']['value']['email']));
                    if(!empty($dataSend['email'])) $to[]= $dataSend['email'];
                    $cc = array();
                    $bcc = array();
                    $subject = '[' . $smtpSite['Option']['value']['show'] . '] ' . $gmpThemeSettings['Option']['value']['titleEmailAddManager'];


                    $content = 'Dear '.$save['Manager']['fullname'].'<br/>';
                    $content.= $gmpThemeSettings['Option']['value']['textEmailAddManager'];
                    $content.= '<br/><span style="font-style: italic;font-weight: bold;font-size: 1.1em;">Thông tin đăng nhập của bạn là:</span><br/>
                        <span style="color: green;font-style: italic;font-size: 1.1em;">Tên đăng nhập: '.$save['Manager']['user'].'</span><br/>
                        <span style="color: green;font-style: italic;font-size: 1.1em;">Mật khẩu: '.$dataSend['password'].'</span><br/>
                        <span style="font-style: italic;font-size: 1.1em;">Link đăng nhập tại: <a href="'.$urlHomes.'quanlykhachsan">'.$urlHomes.'quanlykhachsan </a></span><br/>';
                    
                    $modelManager->sendMail($from, $to, $cc, $bcc, $subject, $content);
                    
                    $modelManager->redirect($urlPlugins . 'admin/mantanHotel-admin-manager-listManager.php?status=1');
                } else {
                    $modelManager->redirect($urlPlugins . 'admin/mantanHotel-admin-manager-addManager.php?status=-1');
                }
            }
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Edit Manager
 * @author SonTT<js.trantrongson@gmail.com>
 */
function editManager($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        $modelManager = new Manager();
        $data = $modelManager->getManager($_GET['id']);
        if ($isRequestPost) {

            $dataSend = arrayMap($input['request']->data);

            if ($dataSend['password'] != '') {
                $save['Manager']['password'] = md5($dataSend['password']);
            }

            $save['Manager']['user'] = $data['Manager']['user'];
            $save['Manager']['fullname'] = $dataSend['fullname'];
            $save['Manager']['avatar'] = $dataSend['avatar'];
            $save['Manager']['email'] = $dataSend['email'];
            $save['Manager']['phone'] = $dataSend['phone'];
            $save['Manager']['address'] = $dataSend['address'];
            $save['Manager']['actived'] = (int) $dataSend['actived'];
            if (!empty($dataSend['desc'])) {
                $save['Manager']['desc'] = $dataSend['desc'];
            }

            $save['Manager']['numberRoomMax'] = (int) $dataSend['numberRoomMax'];
            $save['Manager']['agency'] = $dataSend['agency'];
                
            if(!empty($dataSend['deadline'])){
                $deadline= explode('-', $dataSend['deadline']);

                $save['Manager']['deadline']= mktime(23,59,59,$deadline[1],$deadline[0],$deadline[2]);
            }

            $dk['_id'] = new MongoId($_GET['id']);

            if ($modelManager->updateAll($save['Manager'], $dk)) {
                $modelManager->redirect($urlPlugins . 'admin/mantanHotel-admin-manager-listManager.php?status=3');
            } else {
                $modelManager->redirect($urlPlugins . 'admin/mantanHotel-admin-manager-addManager.php?status=-3');
            }
        }

        $deadline= '';
        if(!empty($data['Manager']['deadline'])){
            $deadline= getdate($data['Manager']['deadline']);
            $deadline= $deadline['mday'].'-'.$deadline['mon'].'-'.$deadline['year'];
        }

        setVariable('data', $data);
        setVariable('deadline', $deadline);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Delete Manager
 * @author SonTT<js.trantrongson@gmail.com>
 */
function deleteManager($input) {
    global $modelOption;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        $modelManager = new Manager();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelManager->delete($idDelete);
        }
        $modelManager->redirect($urlPlugins . 'admin/mantanHotel-admin-manager-listManager.php?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Danh sách đặt phòng
 * @author SonTT<js.trantrongson@gmail.com>
 */
function listBookAdmin($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    if (checkAdminLogin()) {
        $modelBook = new Book();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();
//        $conditions['idHotel']= $_SESSION['idHotel'];

        $listData = $modelBook->getPage($page, $limit, $conditions);

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
 * Thêm đặt phòng
 * @author SonTT<js.trantrongson@gmail.com>
 */
function addBookAdmin($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        if ($isRequestPost) {
            $modelBook = new Book();
            $dataSend = arrayMap($input['request']->data);

            if ($modelBook->isExist($dataSend['codeBook']) == true) {
                $mess = 'Mã đặt phòng đã tồn tại!';
                setVariable('mess', $mess);
            } else {
                $save['Book']['codeBook'] = $dataSend['codeBook'];
                $save['Book']['price'] = $dataSend['price'];
                $save['Book']['date_checkin'] = strtotime($dataSend['date_checkin']);
                $save['Book']['time_checkin'] = strtotime($dataSend['time_checkin']);
                $save['Book']['date_checkout_foresee'] = strtotime($dataSend['date_checkout_foresee']);
                $save['Book']['time_checkout_foresee'] = strtotime($dataSend['time_checkout_foresee']);
                $save['Book']['prepay'] = $dataSend['prepay'];
                $save['Book']['deduction'] = $dataSend['deduction'];
                $save['Book']['type_register'] = $dataSend['type_register'];
                $save['Book']['number_people'] = $dataSend['number_people'];
                $save['Book']['note'] = $dataSend['note'];
                $save['Book']['cus_name'] = $dataSend['cus_name'];
                $save['Book']['cmnd'] = $dataSend['cmnd'];
                $save['Book']['date_cmnd'] = strtotime($dataSend['date_cmnd']);
                $save['Book']['cus_address'] = $dataSend['cus_address'];
                $save['Book']['phone'] = $dataSend['phone'];
                $save['Book']['sex'] = $dataSend['sex'];
                $save['Book']['nationlaty'] = $dataSend['nationlaty'];

                if (!empty($dataSend['cus_note'])) {
                    $save['Book']['cus_note'] = $dataSend['cus_note'];
                }
                if ($modelBook->save($save)) {
                    $modelBook->redirect($urlPlugins . 'admin/mantanHotel-admin-book-listBookAdmin.php?status=1');
                } else {
                    $modelBook->redirect($urlPlugins . 'admin/mantanHotel-admin-book-addBookAdmin.php?status=-1');
                }
            }
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Sửa đặt phòng
 * @author SonTT<js.trantrongson@gmail.com>
 */
function editBookAdmin($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        $modelBook = new Book();
        $data = $modelBook->getBook($_GET['id']);

        if ($isRequestPost) {

            $dataSend = arrayMap($input['request']->data);
            $save['Book']['codeBook'] = $data['Book']['codeBook'];
            $save['Book']['price'] = $dataSend['price'];
            $save['Book']['date_checkin'] = strtotime($dataSend['date_checkin']);
            $save['Book']['time_checkin'] = strtotime($dataSend['time_checkin']);
            $save['Book']['date_checkout_foresee'] = strtotime($dataSend['date_checkout_foresee']);
            $save['Book']['time_checkout_foresee'] = strtotime($dataSend['time_checkout_foresee']);
            $save['Book']['prepay'] = $dataSend['prepay'];
            $save['Book']['deduction'] = $dataSend['deduction'];
            $save['Book']['type_register'] = $dataSend['type_register'];
            $save['Book']['number_people'] = $dataSend['number_people'];
            $save['Book']['note'] = $dataSend['note'];
            $save['Book']['cus_name'] = $dataSend['cus_name'];
            $save['Book']['cmnd'] = $dataSend['cmnd'];
            $save['Book']['date_cmnd'] = strtotime($dataSend['date_cmnd']);
            $save['Book']['cus_address'] = $dataSend['cus_address'];
            $save['Book']['phone'] = $dataSend['phone'];
            $save['Book']['sex'] = $dataSend['sex'];
            $save['Book']['nationlaty'] = $dataSend['nationlaty'];

            if (!empty($dataSend['cus_note'])) {
                $save['Book']['cus_note'] = $dataSend['cus_note'];
            }

            $dk['_id'] = new MongoId($_GET['id']);

            if ($modelBook->updateAll($save['Book'], $dk)) {
                $modelBook->redirect($urlPlugins . 'admin/mantanHotel-admin-book-listBookAdmin.php?status=3');
            } else {
                $modelBook->redirect($urlPlugins . 'admin/mantanHotel-admin-book-listBookAdmin.php?status=-3');
            }
        }

        setVariable('data', $data);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Xóa đặt phòng
 * @author SonTT<js.trantrongson@gmail.com>
 */
function deleteBookAdmin($input) {
    global $modelOption;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        $modelBook = new Book();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelBook->delete($idDelete);
        }
        $modelBook->redirect($urlPlugins . 'admin/mantanHotel-admin-book-listBookAdmin.php?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

// Quan ly tien ich
function listFurnitureAdmin($input) {
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    if (checkAdminLogin()) {
        $listData = $modelOption->getOption('furnitureMantanHotel');
        if ($isRequestPost) {
            if (isset($_POST['type']) && $_POST['type'] == 'save') {
                $dataSend = $input['request']->data;
                // Them tien ich
                if ($dataSend['id'] == '') {
                    if (!isset($listData['Option']['value']['tData']))
                        $listData['Option']['value']['tData'] = 0;
                    $listData['Option']['value']['tData'] += 1;
                    $listData['Option']['value']['allData'][$listData['Option']['value']['tData']] = array('id' => $listData['Option']['value']['tData'], 'name' => $dataSend['name'], 'description' => $dataSend['description'], 'show' => (int) $dataSend['show'], 'key' => $dataSend['key'], 'image' => $dataSend['image']);
                }
                else {
                    // Sua tien ich
                    $idEdit = (int) $dataSend['id'];
                    $listData['Option']['value']['allData'][$idEdit]['name'] = $dataSend['name'];
                    $listData['Option']['value']['allData'][$idEdit]['description'] = $dataSend['description'];
                    $listData['Option']['value']['allData'][$idEdit]['show'] = $dataSend['show'];
                    $listData['Option']['value']['allData'][$idEdit]['key'] = $dataSend['key'];
                    $listData['Option']['value']['allData'][$idEdit]['image'] = $dataSend['image'];
                }
                $modelOption->saveOption('furnitureMantanHotel', $listData['Option']['value']);
            } elseif (isset($_POST['type']) && $_POST['type'] == 'delete') {
                // Xoa tien ich
                $dataSend = $input['request']->data;
                $idDelete = (int) $dataSend['idDelete'];
                unset($listData['Option']['value']['allData'][$idDelete]);
                $modelOption->saveOption('furnitureMantanHotel', $listData['Option']['value']);
            }
        }
        setVariable('listData', $listData);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

// Ket thuc quan ly tien ich

/**
 * Danh sách khách hàng
 * @author SonTT<js.trantrongson@gmail.com>
 */
function listCustomAdmin($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    if (checkAdminLogin()) {
        $modelCustom = new Custom();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();

        $listData = $modelCustom->getPage($page, $limit);

        $totalData = $modelCustom->find('count', array('conditions' => $conditions));

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
 * Thêm khách hàng
 * @author SonTT<js.trantrongson@gmail.com>
 */
function addCustomAdmin($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        if ($isRequestPost) {
            $modelCustom = new Custom();
            $dataSend = arrayMap($input['request']->data);

            if ($modelCustom->isExist($dataSend['cmnd']) == true) {
                $mess = 'Số chứng minh đã dược đăng ký!';
                setVariable('mess', $mess);
            } else {
                $save['Custom']['cus_name'] = $dataSend['cus_name'];
                $save['Custom']['cmnd'] = $dataSend['cmnd'];
                $save['Custom']['address'] = $dataSend['address'];
                $save['Custom']['phone'] = $dataSend['phone'];
                $save['Custom']['nationality'] = $dataSend['nationality'];
                $save['Custom']['birthday'] = $dataSend['birthday'];

                if (!empty($dataSend['info_deal'])) {
                    $save['Custom']['info_deal'] = $dataSend['info_deal'];
                }
                if (!empty($dataSend['note'])) {
                    $save['Custom']['note'] = $dataSend['note'];
                }

                if ($modelCustom->save($save)) {
                    $modelCustom->redirect($urlPlugins . 'admin/mantanHotel-admin-custom-listCustomAdmin.php?status=1');
                } else {
                    $modelCustom->redirect($urlPlugins . 'admin/mantanHotel-admin-custom-addCustomAdmin.php?status=-1');
                }
            }
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Sửa khách hàng
 * @author SonTT<js.trantrongson@gmail.com>
 */
function editCustomAdmin($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        $modelCustom = new Custom();
        $data = $modelCustom->getCustom($_GET['id']);

        if ($isRequestPost) {

            $dataSend = arrayMap($input['request']->data);

            $save['Custom']['cus_name'] = $dataSend['cus_name'];
            $save['Custom']['cmnd'] = $data['Custom']['cmnd'];
            $save['Custom']['address'] = $dataSend['address'];
            $save['Custom']['phone'] = $dataSend['phone'];
            $save['Custom']['nationality'] = $dataSend['nationality'];
            $save['Custom']['birthday'] = $dataSend['birthday'];
            if (!empty($dataSend['info_deal'])) {
                $save['Custom']['info_deal'] = $dataSend['info_deal'];
            }
            if (!empty($dataSend['note'])) {
                $save['Custom']['note'] = $dataSend['note'];
            }

            $dk['_id'] = new MongoId($_GET['id']);

            if ($modelCustom->updateAll($save['Custom'], $dk)) {
                $modelCustom->redirect($urlPlugins . 'admin/mantanHotel-admin-custom-listCustomAdmin.php?status=3');
            } else {
                $modelCustom->redirect($urlPlugins . 'admin/mantanHotel-admin-custom-listCustomAdmin.php?status=-3');
            }
        }

        setVariable('data', $data);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Xóa khách hàng
 * @author SonTT<js.trantrongson@gmail.com>
 */
function deleteCustomAdmin($input) {
    global $modelOption;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        $modelCustom = new Custom();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelCustom->delete($idDelete);
        }
        $modelCustom->redirect($urlPlugins . 'admin/mantanHotel-admin-custom-listCustomAdmin.php?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * List User
 * @author SonTT<js.trantrongson@gmail.com>
 */
function listUserAdmin($input) {
    global $modelOption;
    global $modelUser;
    global $urlHomes;
    global $urlNow;

    if (checkAdminLogin()) {

        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();

        $listData = $modelUser->getPage($page, $limit);

        $totalData = $modelUser->find('count', array('conditions' => $conditions));

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
 * Add User
 * @author SonTT<js.trantrongson@gmail.com>
 */
function addUserAdmin($input) {
    global $modelOption;
    global $modelUser;
    global $isRequestPost;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        if ($isRequestPost) {

            $dataSend = arrayMap($input['request']->data);
            if ($modelUser->isExist($dataSend['user'], $dataSend['email'], $dataSend['cmnd']) == true) {
                $mess = 'Người dùng đã tồn tại!';
                setVariable('mess', $mess);
            } else {
                $save['User']['user'] = $dataSend['user'];
                $save['User']['cmnd'] = $dataSend['cmnd'];
                $save['User']['fullname'] = $dataSend['fullname'];
                $save['User']['avatar'] = $dataSend['avatar'];
                $save['User']['email'] = $dataSend['email'];
                $save['User']['phone'] = $dataSend['phone'];
                $save['User']['address'] = $dataSend['address'];
                $save['User']['password'] = md5($dataSend['password']);
                $save['User']['actived'] = (int) $dataSend['actived'];
                if (!empty($dataSend['desc'])) {
                    $save['User']['desc'] = $dataSend['desc'];
                }
                if ($modelUser->save($save)) {
                    $modelUser->redirect($urlPlugins . 'admin/mantanHotel-admin-user-listUserAdmin.php?status=1');
                } else {
                    $modelUser->redirect($urlPlugins . 'admin/mantanHotel-admin-user-addUserAdmin.php?status=-1');
                }
            }
        }
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Edit User
 * @author SonTT<js.trantrongson@gmail.com>
 */
function editUserAdmin($input) {
    global $modelOption;
    global $modelUser;
    global $isRequestPost;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        $modelUser = new User();
        $data = $modelUser->getUser($_GET['id']);
        if ($isRequestPost) {

            $dataSend = arrayMap($input['request']->data);

            if ($dataSend['password'] == $data['User']['password']) {
                $pass = $data['User']['password'];
            } else {
                $pass = md5($dataSend['password']);
            }

            $save['User']['user'] = $data['User']['user'];
            $save['User']['fullname'] = $dataSend['fullname'];
            $save['User']['avatar'] = $dataSend['avatar'];
            $save['User']['email'] = $dataSend['email'];
            $save['User']['phone'] = $dataSend['phone'];
            $save['User']['address'] = $dataSend['address'];
            $save['User']['password'] = $pass;
            $save['User']['actived'] = (int) $dataSend['actived'];
            if (!empty($dataSend['desc'])) {
                $save['User']['desc'] = $dataSend['desc'];
            }

            $dk['_id'] = new MongoId($_GET['id']);

            if ($modelUser->updateAll($save['User'], $dk)) {
                $modelUser->redirect($urlPlugins . 'admin/mantanHotel-admin-user-listUserAdmin.php?status=3');
            } else {
                $modelUser->redirect($urlPlugins . 'admin/mantanHotel-admin-user-addUserAdmin.php?status=-3');
            }
        }

        setVariable('data', $data);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

/**
 * Delete User
 * @author SonTT<js.trantrongson@gmail.com>
 */
function deleteUserAdmin($input) {
    global $modelOption;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        $modelUser = new User();
        if (isset($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelUser->delete($idDelete);
        }
        $modelUser->redirect($urlPlugins . 'admin/mantanHotel-admin-user-listUserAdmin.php?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

// Tieu chi binh chọn
function listCriteriaVote() {
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    if (checkAdminLogin()) {
        $listData = $modelOption->getOption('criteriaVote');
        if ($isRequestPost) {
            if (isset($_POST['type']) && $_POST['type'] == 'save') {
                // Them tien ich
                if ($_POST['id'] == '') {
                    if (!isset($listData['Option']['value']['tData']))
                        $listData['Option']['value']['tData'] = 0;
                    $listData['Option']['value']['tData'] += 1;
                    $listData['Option']['value']['allData'][$listData['Option']['value']['tData']] = array('id' => $listData['Option']['value']['tData'], 'name' => $_POST['name'], 'show' => (int) $_POST['show']);
                }
                else {
                    // Sua tien ich
                    $idEdit = (int) $_POST['id'];
                    $listData['Option']['value']['allData'][$idEdit]['name'] = $_POST['name'];
                    $listData['Option']['value']['allData'][$idEdit]['show'] = $_POST['show'];
                }
                $modelOption->saveOption('criteriaVote', $listData['Option']['value']);
            } elseif (isset($_POST['type']) && $_POST['type'] == 'delete') {
                // Xoa tien ich
                $idDelete = (int) $_POST['idDelete'];
                unset($listData['Option']['value']['allData'][$idDelete]);
                //debu ($idDelete);
                //debu ($listData);
                $modelOption->saveOption('criteriaVote', $listData['Option']['value']);
            }
        }
        setVariable('listData', $listData);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function ListRequest($input) {
    global $isRequestPost;
    global $urlHomes;
    global $isRequestPost;
    global $urlNow;

    $modelRequest = new Request();

    if (checkAdminLogin()) {
        $mess = '';
        if (isset($_GET['status'])) {
            switch ($_GET['status']) {
                case 1: $mess = 'Gửi báo giá thành công';
                    break;
            }
        }

        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $order['created'] = 'desc';
        if (!empty($_GET['type_oder']) && $_GET['type_oder'] != 'empty') {
            if ($_GET['type_oder'] == 'chuaXuLy') {
                $order['hotelProcess'] = 'asc';
            } elseif ($_GET['type_oder'] == 'daXuLy') {
                $order['hotelProcess'] = 'desc';
            } elseif ($_GET['type_oder'] == 'moiNhat') {
                $order['created'] = 'desc';
            } elseif ($_GET['type_oder'] == 'cuNhat') {
                $order['created'] = 'asc';
            }
        } else {
            $order['hotelProcess'] = 'desc';
        }
        $conditions = array();
        $listData = $modelRequest->getPage($page, $limit, $conditions, $order);

        $totalData = $modelRequest->find('count', array('conditions' => $conditions));
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


        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);

        setVariable('listData', $listData);
        setVariable('mess', $mess);
    } else {
        $modelRequest->redirect($urlHomes);
    }
}

function ListOrder($input) {
    global $isRequestPost;
    global $urlHomes;
    global $isRequestPost;
    global $urlNow;

    $modelOrder = new Order();

    if (checkAdminLogin()) {
        $mess = '';
        if (isset($_GET['status'])) {
            switch ($_GET['status']) {
                case 1: $mess = 'Gửi báo giá thành công';
                    break;
            }
        }

        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 30;
        $order['created'] = 'desc';
        if (!empty($_GET['type_oder']) && $_GET['type_oder'] != 'empty') {
            if ($_GET['type_oder'] == 'chuaXuLy') {
                $order['hotelProcess'] = 'asc';
            } elseif ($_GET['type_oder'] == 'daXuLy') {
                $order['hotelProcess'] = 'desc';
            } elseif ($_GET['type_oder'] == 'moiNhat') {
                $order['created'] = 'desc';
            } elseif ($_GET['type_oder'] == 'cuNhat') {
                $order['created'] = 'asc';
            }
        } else {
            $order['hotelProcess'] = 'desc';
        }
        $conditions = array();
        $listData = $modelOrder->getPage($page, $limit, $conditions, $order);

        $totalData = $modelOrder->find('count', array('conditions' => $conditions));
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


        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);

        setVariable('listData', $listData);
        setVariable('mess', $mess);
    } else {
        $modelOrder->redirect($urlHomes);
    }
}

function ProcessRequest($input) {
    global $isRequestPost;
    global $modelOption;
    global $urlPlugins;
    global $urlHomes;
     global $gmpThemeSettings;

    $modelRequest = new Request();
    $contactSite = $modelOption->getOption('contact');
    $smtpSite = $modelOption->getOption('smtpSetting');

    if (checkAdminLogin()) {
        $data = $modelRequest->getRequest($_GET['id']);


        if ($data) {
            $time_start = getdate($data['Request']['time']);

            setVariable('data', $data);
            setVariable('time_start', $time_start);

            if ($isRequestPost) {
                $price = (int) $_POST['price'];
                $contentRequest = $_POST['contentRequest'];
                $save['$set']['hotelProcess.miniHotel.price'] = $price;
                $save['$set']['hotelProcess.miniHotel.contentRequest'] = $contentRequest;
                $idRequest = new MongoId($data['Request']['id']);
                    $content = '<a href="' . $urlHomes . '">Hotel365.vn</a>,<br>';
                    $content.= 'Xin chào ' . $data['Request']['fullName'] . '!<br/>'.$gmpThemeSettings['Option']['value']['textEmailRequest'].' <br>' . $data['Request']['content'] . ' <br><br>';
                    $content.= 'Hotel365: ';
                    $content.= '<a href="' . $urlHomes . '">' . $urlHomes . '</a><br/>';
                    $content.= 'Báo giá: ' . number_format($_POST['price']) . ' VNĐ <br>';

                    $content.= 'Nội dung báo giá: ' . $contentRequest;
                if ($modelRequest->updateAll($save, array('_id' => $idRequest))) {

                    // send email for user and admin
                    $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                    $to = array(trim($contactSite['Option']['value']['email']));
                    if(!empty($data['Request']['email'])) $to[]= $data['Request']['email'];
                    $cc = array();
                    $bcc = array();
                    $subject = '[' . $smtpSite['Option']['value']['show'] . '] ' . $gmpThemeSettings['Option']['value']['titleEmailRequest'];

                    // create content email
                    $content = '<a href="' . $urlHomes . '">Hotel365.vn</a>,<br>';
                    $content.= 'Xin chào ' . $data['Request']['fullName'] . '!<br/>'.$gmpThemeSettings['Option']['value']['textEmailRequest'].' <br>' . $data['Request']['content'] . ' <br><br>';
                    $content.= 'Hotel365: ';
                    $content.= '<a href="' . $urlHomes . '">' . $urlHomes . '</a><br/>';
                    $content.= 'Báo giá: ' . number_format($_POST['price']) . ' VNĐ <br>';

                    $content.= 'Nội dung báo giá: ' . $contentRequest;
                    $modelRequest->sendMail($from, $to, $cc, $bcc, $subject, $content);
                }


                $modelRequest->redirect($urlPlugins . 'admin/mantanHotel-admin-request-ListRequest.php?status=1');
            }
        } else {
            $modelRequest->redirect($urlHomes);
        }
    } else {
        $modelRequest->redirect($urlHomes);
    }
}

function ViewProcessRequest() {
    global $urlHomes;

    $modelRequest = new Request();

    if (checkAdminLogin()) {
        $data = $modelRequest->getRequest($_GET['id']);

        if ($data) {

            setVariable('data', $data);
        } else {
            $modelRequest->redirect($urlHomes);
        }
    } else {
        $modelRequest->redirect($urlHomes);
    }
}

function sitemapHotel($input)
{
    global $urlHomes;

    $modelHotel = new Hotel();

    if (checkAdminLogin()) {
        if(function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules()))
        {
            $urlLocalRoot= '../../app/Plugin/mantanHotel/';
        }
        else
        {
            $urlLocalRoot= '/app/Plugin/mantanHotel/';
        }
        
        
        // Create hotel sitemap
        $listHotel= $modelHotel->find('all',array('fields' => array('slug','modified')));
      
        $doc = new DOMDocument('1.0', 'utf-8');
        $doc->formatOutput = true;
      
        $r = $doc->createElement( "urlset" );
        $doc->appendChild( $r );
        
        $xmlns = $doc->createAttribute('xmlns');
        $r->appendChild($xmlns);
        
        $value = $doc->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9');
        $xmlns->appendChild($value);
        
        foreach($listHotel as $data)
        {
            $b = $doc->createElement( "url" );
            $loc = $doc->createElement( "loc" );
            $loc->appendChild( $doc->createTextNode( $urlHomes.'hotel/'.$data['Hotel']['slug'].'.html' ));
            $b->appendChild( $loc );
            $r->appendChild( $b );
        }

        $doc->save($urlLocalRoot.'sitemapHotel.xml');
        
    } else {
        $modelHotel->redirect($urlHomes);
    }
}

?>