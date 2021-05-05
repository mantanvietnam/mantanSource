<?php
function listStaff($input) {
	global $modelOption;
	global $urlHomes;
	global $urlNow;

	if (checkAdminLogin()) {
		$modelStaff = new Staff();
		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		if ($page <= 0) {
			$page = 1;
		}
		$limit = 15;
		$conditions = array();
		$order = array();
		if(!empty($_GET['name'])){
			$conditions['slug.fullName']=array('$regex' => createSlugMantan(trim($_GET['name'])));
		}
		if(!empty($_GET['birthday'])){
			$conditions['birthday']=array('$regex' => $_GET['birthday']);
		}
		if(!empty($_GET['email'])){
			$conditions['slug.email']=array('$regex' => createSlugMantan(trim($_GET['email'])));
		}
		if(!empty($_GET['phone'])){
			$conditions['phone']=array('$regex' => trim($_GET['phone']));
		}
		if(!empty($_GET['idCity'])){
			$conditions['idCity']=array('$regex' => $_GET['idCity']);
		}
		
		if(!empty($_GET['address'])){
			$conditions['address']=array('$regex' => createSlugMantan(trim($_GET['address'])));
		}
		if(!empty($_GET['code'])){
			$conditions['slug.code']=array('$regex' => createSlugMantan(trim($_GET['code'])));
		}
		if(!empty($_GET['position'])){
			$conditions['slug.position']=array('$regex' => createSlugMantan(trim($_GET['position'])));
		}if(!empty($_GET['indirectManager'])){
			$conditions['slug.indirectManager']=array('$regex' => createSlugMantan(trim($_GET['indirectManager'])));
		}if(!empty($_GET['directManager'])){
			$conditions['slug.directManager']=array('$regex' => createSlugMantan(trim($_GET['directManager'])));
		}
		if(!empty($_GET['dateTrial'])){
			$conditions['dateTrial']=array('$regex' => $_GET['dateTrial']);
		}
		
		if(!empty($_GET['dateStart'])){
			$conditions['dateStart']=array('$regex' => $_GET['dateStart']);
		}
		$listData = $modelStaff->getPage($page, $limit, $conditions, $order);

		$totalData = $modelStaff->find('count', array('conditions' => $conditions));

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
			$urlNow = str_replace("?mess=-2", "", $urlNow);
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

		setVariable('listData', $listData);
		setVariable('limit', $limit);
		setVariable('listCityKiosk', getListCity());

		setVariable('page', $page);
		setVariable('totalPage', $totalPage);
		setVariable('back', $back);
		setVariable('next', $next);
		setVariable('urlPage', $urlPage);
	} else {
		$modelOption->redirect($urlHomes);
	}
}

function addStaff($input) {
	global $modelOption;
	global $isRequestPost;
	global $urlHomes;
	global $urlPlugins;
	global $contactSite;
	global $smtpSite;

	if (checkAdminLogin()) {
		$modelStaff = new Staff();
		$save= array();
		if(!empty($_GET['id'])){
			$save = $modelStaff->getStaff($_GET['id']);
		}

		if ($isRequestPost) {

			$dataSend = arrayMap($input['request']->data);

			if (empty($_GET['id']) && $modelStaff->isExistUser($dataSend['code'])) {
				$mess = 'Tài khoản đã tồn tại!';
				setVariable('mess', $mess);
			} else {
				if(!empty($dataSend['code'])){
					$save['Staff']['code']= $dataSend['code'];
					$save['Staff']['slug']['code']= createSlugMantan(trim($dataSend['code']));
				}
				$save['Staff']['status']= $dataSend['status'];
				$save['Staff']['fullName']= $dataSend['fullName'];
				$save['Staff']['sex']= $dataSend['sex'];
				$save['Staff']['birthday']= $dataSend['birthday'];
				$save['Staff']['email']= $dataSend['email'];
				
				$save['Staff']['phone']= $dataSend['phone'];
				$save['Staff']['idCity']= $dataSend['idCity'];
				
				$save['Staff']['slug']['email']= createSlugMantan($dataSend['email']);
				$save['Staff']['slug']['position']= createSlugMantan($dataSend['position']);
				$save['Staff']['slug']['directManager']= createSlugMantan($dataSend['directManager']);
				$save['Staff']['slug']['indirectManager']= createSlugMantan($dataSend['indirectManager']);
				$save['Staff']['slug']['address']= createSlugMantan($dataSend['address']);
				$save['Staff']['slug']['fullName']= createSlugMantan($dataSend['fullName']);
				
				$save['Staff']['address']= $dataSend['address'];
				$save['Staff']['dateTrial']= $dataSend['dateTrial'];
				$save['Staff']['dateStart']= $dataSend['dateStart'];
				$save['Staff']['position']= $dataSend['position'];
				$save['Staff']['directManager']= $dataSend['directManager'];
				$save['Staff']['indirectManager']= $dataSend['indirectManager'];
				$save['Staff']['desc']= $dataSend['desc'];
				$save['Staff']['pass'] = md5($dataSend['password']);
				$save['Staff']['type'] = 'admin';

				if ($modelStaff->save($save)) {
                    // send email for user and admin
					if(empty($_GET['id'])){
						$from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
						$to = array(trim($dataSend['email']));
						$cc = array();
						$bcc = array();
						$subject = '[' . $smtpSite['Option']['value']['show'] . '] Tài khoản của bạn đã được khởi tạo thành công';


						$content = 'Xin chào '.$save['Staff']['fullName'].'<br/>';
						$content.= '<br/>Thông tin đăng nhập của bạn là:<br/>
						Tên đăng nhập: '.$save['Staff']['code'].'<br/>
						Mật khẩu: '.$dataSend['password'].'<br/>
						Link đăng nhập tại: <a href="'.$urlHomes.'adminLogin">'.$urlHomes.'adminLogin </a><br/>';

						$modelStaff->sendMail($from, $to, $cc, $bcc, $subject, $content);
					}

					$modelStaff->redirect($urlPlugins . 'admin/gavi-admin-staff-listStaff.php');
				} else {
					$modelStaff->redirect($urlPlugins . 'admin/gavi-admin-staff-addStaff.php');
				}
			}
		}
		
		setVariable('listCityKiosk', getListCity());

		setVariable('data', $save);
	} else {
		$modelOption->redirect($urlHomes);
	}
}

function updateStatusStaff($input) {
	global $modelOption;
	global $urlHomes;
	global $urlPlugins;

	if (checkAdminLogin()) {
		$modelStaff = new Staff();
		if (isset($_GET['id']) && isset($_GET['status'])) {
			$save['$set']['status'] = $_GET['status'];
			$dk= array('_id'=>new MongoId($_GET['id']));

			$modelStaff->updateALL($save,$dk);
		}
		$modelStaff->redirect($urlPlugins . 'admin/kiosk-admin-staff-listStaff.php?stt=4');
	} else {
		$modelOption->redirect($urlHomes);
	}
}

function listLog($input) {
	global $modelOption;
	global $urlHomes;
	global $urlNow;

	if (checkAdminLogin()) {
		$modelLog = new Log();
		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		if ($page <= 0) {
			$page = 1;
		}
		$limit = 15;
		$conditions = array();
		$order = array('created'=>'DESC');

		$listData = $modelLog->getPage($page, $limit, $conditions, $order);

		$totalData = $modelLog->find('count', array('conditions' => $conditions));

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

		setVariable('listData', $listData);
		setVariable('limit', $limit);
		setVariable('page', $page);
		setVariable('totalPage', $totalPage);
		setVariable('back', $back);
		setVariable('next', $next);
		setVariable('urlPage', $urlPage);
	} else {
		$modelOption->redirect($urlHomes);
	}
}

?>