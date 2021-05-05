<?php
function listStaffAgency($input)
{
    global $urlHomes;
    global $isRequestPost;
    global $contactSite;
    global $urlNow;
    global $modelOption;
    global $metaTitleMantan;
    $metaTitleMantan= 'Danh sách nhân viên';
    
    $dataSend = $input['request']->data;
    $modelStaff= new Staff();
    $mess= '';
    $data= array();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listStaffAgency', $_SESSION['infoStaff']['Staff']['permission']))){

            $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
            if($page<1) $page=1;
            $limit= 15;
            $conditions=array('type'=>'staff');
            $order = array('status'=>'ASC');
            $fields= array();
            
            if(!empty($_GET['phone'])){
                $conditions['phone']= $_GET['phone'];
            }

            if(!empty($_GET['idStatus'])){
                $conditions['status']= $_GET['idStatus'];
            }

            if(!empty($_GET['email'])){
				$conditions['slug.email']=array('$regex' => createSlugMantan(trim($_GET['email'])));
			}

			if(!empty($_GET['fullName'])){
				$conditions['slug.fullName']=array('$regex' => createSlugMantan(trim($_GET['fullName'])));
			}
            
            $listData= $modelStaff->getPage($page, $limit , $conditions, $order, $fields );

            $totalData= $modelStaff->find('count',array('conditions' => $conditions));
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
                if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
                    $urlPage= $urlPage.'&page=';
                }else{
                    $urlPage= $urlPage.'page=';
                }
            }else{
                $urlPage= $urlPage.'?page=';
            }

            setVariable('listData',$listData);

            setVariable('page',$page);
            setVariable('totalPage',$totalPage);
            setVariable('back',$back);
            setVariable('next',$next);
            setVariable('urlPage',$urlPage);
            setVariable('mess',$mess);
        }else{
            $modelStaff->redirect($urlHomes.'dashboard');
        }
    }else{
        $modelStaff->redirect($urlHomes.'admin?status=-2');
    }
} 

function addStaffAgency($input)
{
	global $contactSite;
	global $isRequestPost;
	global $urlHomes;
	global $metaTitleMantan;
	global $contactSite;
	global $smtpSite;
	$metaTitleMantan= 'Lưu thông tin tài khoản nhân viên';

	$modelStaff= new Staff();
	$listData = array();
	$dataSend= $input['request']->data;
	$mess= '';
	$today= getdate();
	
	if(empty($_SESSION['infoStaff'])){
		$modelStaff->redirect($urlHomes.'admin');
	}else{
		$data= array();
		if(!empty($_GET['id'])){
			$data= $modelStaff->getStaff($_GET['id']);
		}

		if($isRequestPost){
			if(!empty($dataSend['fullName']) && !empty($dataSend['phone'])) {
				$checkStaff= $modelStaff->isExistUser($dataSend['phone'],'phone');

				if(empty($checkStaff) || (!empty($_GET['id']) && $_GET['id']==$checkStaff['Staff']['id']) ){

					if(empty($_GET['id']) || !empty($dataSend['pass'])){
						$data['Staff']['pass']= md5($dataSend['pass']);
					}

					$data['Staff']['fullName']= $dataSend['fullName'];
					$data['Staff']['email']= $dataSend['email'];
					$data['Staff']['phone']= $dataSend['phone'];
					$data['Staff']['birthday']= $dataSend['birthday'];
					$data['Staff']['address']= $dataSend['address'];
					$data['Staff']['desc']= $dataSend['desc'];
					$data['Staff']['status']= $dataSend['status'];
					$data['Staff']['permission']= $dataSend['permission'];
					$data['Staff']['type']= 'staff';

					$data['Staff']['slug']['email']= createSlugMantan($dataSend['email']);
					$data['Staff']['slug']['address']= createSlugMantan($dataSend['address']);
					$data['Staff']['slug']['fullName']= createSlugMantan($dataSend['fullName']);

					if($modelStaff->save($data)){
						$mess= 'Lưu dữ liệu thành công';
					}else{
						$mess= 'Lưu dữ liệu thất bại';
					}  
				}else{
					$mess= 'Số điện thoại đã tồn tại';
				}
			}else{
				$mess= 'Nhập thiếu dữ liệu';
			}
		}

		setVariable('mess',$mess);
		setVariable('data',$data);
	}
}

function logout($input)
{
	global $urlHomes;
	$modelStaff= new Staff();

	session_destroy();
	$modelStaff->redirect('/admin');
}

function infoStaff($input)
{
	global $contactSite;
	global $isRequestPost;
	global $urlHomes;
	global $metaTitleMantan;
	global $contactSite;
	global $smtpSite;
	$metaTitleMantan= 'Thông tin tài khoản';

	$modelStaff= new Staff();
	$listData = array();
	$dataSend= $input['request']->data;
	$mess= '';
	$today= getdate();

	if(empty($_SESSION['infoStaff'])){
		$modelStaff->redirect($urlHomes.'admin');
	}else{
		$data= $modelStaff->getStaff($_SESSION['infoStaff']['Staff']['id']);

		if($isRequestPost){
			if(!empty($dataSend['fullName']) && !empty($dataSend['email'])) {
				$data['Staff']['fullName']= $dataSend['fullName'];
				$data['Staff']['email']= $dataSend['email'];
				$data['Staff']['birthday']= $dataSend['birthday'];
				$data['Staff']['address']= $dataSend['address'];
				$data['Staff']['desc']= $dataSend['desc'];

				if($modelStaff->save($data)){
					$_SESSION['infoStaff']= $data;
					$mess= 'Lưu dữ liệu thành công';
				}else{
					$mess= 'Lưu dữ liệu thất bại';
				}  

			}else{
				$mess= 'Nhập thiếu dữ liệu';
			}
		}

		setVariable('mess',$mess);
		setVariable('data',$data);
	}
}

function changePassStaff($input)
{
	global $contactSite;
	global $isRequestPost;
	global $urlHomes;
	global $metaTitleMantan;
	global $contactSite;
	global $smtpSite;
	$metaTitleMantan= 'Đổi mật khẩu';

	$modelStaff= new Staff();
	$listData = array();
	$dataSend= $input['request']->data;
	$mess= '';
	$today= getdate();

	if(empty($_SESSION['infoStaff'])){
		$modelStaff->redirect($urlHomes.'admin');
	}else{
		$data= $modelStaff->getStaff($_SESSION['infoStaff']['Staff']['id']);

		if($isRequestPost){
			if(!empty($dataSend['passOld']) && !empty($dataSend['passNew']) && !empty($dataSend['passAgain'])) {

				if($data['Staff']['pass']==md5($dataSend['passOld'])){

				if($dataSend['passNew']==$dataSend['passAgain']){
					if($data['Staff']['pass']==md5($dataSend['passNew'])){
						$mess= 'Nhập mật khẩu mới không trùng với mật khẩu cũ';
					}else{
						$data['Staff']['pass']= md5($dataSend['passNew']);

						if($modelStaff->save($data)){
							$_SESSION['infoStaff']= $data;
							$mess= 'Lưu dữ liệu thành công';
							$from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
							$to = array(trim($data['Staff']['email']));
							$cc = array();
							$bcc = array();
							$subject = '[' . $smtpSite['Option']['value']['show'] . '] Thay đổi mật khẩu thành công';


							$content = 'Xin chào '.$_SESSION['infoStaff']['Staff']['fullName'].'<br/>';
							$content.= '
							<br>Bạn đã thay đổi mật khẩu thành công</br>
							<br/>Thông tin đăng nhập của bạn là:<br/>
							Tên đăng nhập: '.$_SESSION['infoStaff']['Staff']['code'].'<br/>
							Mật khẩu: '.$dataSend['passNew'].'<br/>
							Link đăng nhập tại: <a href="'.$urlHomes.'admin">'.$urlHomes.'admin </a><br/>';

							$modelStaff->sendMail($from, $to, $cc, $bcc, $subject, $content);
						}else{
							$mess= 'Lưu dữ liệu thất bại';
						}
					}
				}
				else
				{
					$mess= 'Xác nhận mật khẩu mới nhập chưa khớp';

				}
			}else{
					$mess= 'Nhập sai mật khẩu cũ';
				}
			}else{
				$mess= 'Nhập thiếu dữ liệu';
			}
		}

		setVariable('mess',$mess);
		setVariable('data',$data);
	}
}

function admin($input)
{
	global $contactSite;
	global $isRequestPost;
	global $urlHomes;

	$modelStaff= new Staff();

	if(!empty($_SESSION['infoStaff'])){
		$modelStaff->redirect($urlHomes.'dashboard');
	}else{
		$mess= '';
		if(!empty($_GET['forgetPass'])){
			if($_GET['forgetPass']==1){
				$mess= "Lấy lại mật khẩu thành công";
			}
		}
		if($isRequestPost){
			$dataSend= $input['request']->data;

			if(!empty($dataSend['code']) && !empty($dataSend['pass'])){
				$userByFone  = $modelStaff->checkLogin($dataSend['code'],$dataSend['pass']);

				if($userByFone){
					$_SESSION['infoStaff']= $userByFone;
					$_SESSION['CheckAuthentication']= true;
					$_SESSION['urlBaseUpload']= '/app/webroot/upload/admin/staff/'.$userByFone['Staff']['id'].'/';

					$modelStaff->redirect($urlHomes.'dashboard');
				}else{
					$mess= 'Sai mã nhân viên hoặc mật khẩu';
				}
			}else{
				$mess= 'Không được để trống mã nhân viên hoặc mật khẩu';
			}
		}

		setVariable('mess',$mess);
	}
}

function dashboard($input)
{
	global $urlHomes;
	global $metaTitleMantan;
	global $modelOption;
	global $metaTitleMantan;
	$metaTitleMantan= 'Trang chủ';

	$modelStaff= new Staff();
	if(!empty($_SESSION['infoStaff'])){

	}else{
        $modelStaff->redirect($urlHomes.'admin?status=-2');
	}
}

function forgetPassStaff($input)
{
	$modelStaff= new Staff();
	global $contactSite;
	global $isRequestPost;
	global $urlHomes;

	if($isRequestPost){
		$dataSend= $input['request']->data;
		$data= $modelStaff->getStaffByCode($dataSend['code']);
		if ($data!=null) {
			if ($data['Staff']['status']!='lock') {
		if($data['Staff']['email']){
			$data['Staff']['codeForgetPass']= rand(100000,999999);
			$modelStaff->save($data);

            // Gửi email thông báo
			$from=array($contactSite['Option']['value']['email']);
			$to=array($data['Staff']['email']);
			$cc=array();
			$bcc=array();
			$subject='[Gavi] Mã cấp lại mật khẩu';
			$content= ' <p>Xin chào '.$data['Staff']['fullName'].' !</p>
			<br/>Thông tin đăng nhập của bạn là:<br/>
			Tên đăng nhập: '.$dataSend['code'].'<br/>
			Bạn vui lòng nhập mã sau để lấy lại mật khẩu: <b>'.$data['Staff']['codeForgetPass'].'</b><br>
			Link đăng nhập tại: <a href="'.$urlHomes.'admin">'.$urlHomes.'admin </a><br/>';


			$modelStaff->sendMail($from,$to,$cc,$bcc,$subject,$content);
		}

		$modelStaff->redirect($urlHomes.'forgetPassStaffProcess?code='.$dataSend['code']);
	}else
$modelStaff->redirect($urlHomes.'forgetPassStaff?mess=1');
}
	else
$modelStaff->redirect($urlHomes.'forgetPassStaff?mess=-1');
}
}

function forgetPassStaffProcess($input)
{
	$modelStaff= new Staff();
	global $contactSite;
	global $urlHomes;
	global $isRequestPost;
	$mess= '';

	if($isRequestPost){
		$dataSend= $input['request']->data;
		$data= $modelStaff->getStaffByCode($dataSend['code']);

		if($data['Staff']['email'] && isset($data['Staff']['codeForgetPass']) && $data['Staff']['codeForgetPass']==$dataSend['codeForgetPass']){

			$save['$set']['pass']= md5($dataSend['pass']);
			if (md5($dataSend['codeForgetPass'])!=md5($dataSend['pass'])) {
			$save['$unset']['codeForgetPass']= true;
			$dk= array('_id'=>new MongoId($data['Staff']['id']));
			if($modelStaff->updateAll($save,$dk)){
                // Gửi email thông báo
				$from=array($contactSite['Option']['value']['email']);
				$to=array($data['Staff']['email']);
				$cc=array();
				$bcc=array();
				$subject='[Gavi] Lấy mật khẩu thành công';
				$content= ' <p>Xin chào '.$data['Staff']['fullName'].' !</p>
				<br/>Thông tin đăng nhập của bạn là:<br/>
				Tên đăng nhập: '.$dataSend['code'].'<br>
				Mật khẩu mới của bạn là: <b>'.$dataSend['pass'].'</b><br>
				Link đăng nhập tại: <a href="'.$urlHomes.'admin">'.$urlHomes.'admin </a>';

				$modelStaff->sendMail($from,$to,$cc,$bcc,$subject,$content);
				$modelStaff->redirect($urlHomes.'admin?forgetPass=1');
			}else{
				$mess= "Lưu thất bại";
			}
		}
		else
		{
			$mess= "Không nhập mật khẩu mới trùng với mã lấy lại mật khẩu";
		}
		}else{
			$mess= "Sai tài khoản hoặc sai mã xác nhận";
		}
	}

	setVariable('mess',$mess);
}


?>