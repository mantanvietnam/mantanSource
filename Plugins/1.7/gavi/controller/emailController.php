<?php
function listMail($input) {
	global $modelOption;
	global $isRequestPost;
	global $urlHomes;
	global $urlPlugins;
	global $contactSite;
	global $smtpSite;
	global $urlNow;

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listMail', $_SESSION['infoStaff']['Staff']['permission']))){
			$mess= '';
			$modelAgency= new Agency();
			$modelEmail= new Email();

			if(!empty($_GET['status'])){
				switch ($_GET['status']) {
					case 'sendEmailDone': $mess= 'Gửi mail thành công';break;
					case 'sendEmailFail': $mess= 'Gửi mail thất bại';break;
				}
			}

			$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
            if($page<1) $page=1;
            $limit= 15;
            $conditions=array();
            

			if(!empty($_GET['type'])){
	        	switch ($_GET['type']) {
	        		case 'agency': 	$conditions['type']='agency';
	        						break;
	        		case 'system': 	$conditions['type']= 'system';
		        					$conditions['idAgency']= '';
		        					break;
	        	}
	        }else{
                /*
	        	$conditions['$or']= array();
				$conditions['$or'][]= array('idAgency'=>'');
				$conditions['$or'][]= array('type'=>'agency');
				$conditions['$or'][]= array('type'=>'all');
                */
                $conditions['type']= array('$ne'=>'system');
                $conditions['lastSend']= '';
	        }

            $order = array('timeUpdate'=>'DESC');
            $fields= array('subject','time','status','phoneAgency','codeAgency','listView');
            
            $listData= $modelEmail->getPage($page, $limit , $conditions, $order, $fields );

            $totalData= $modelEmail->find('count',array('conditions' => $conditions));
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
            $modelOption->redirect($urlHomes.'dashboard');
        }
	} else {
		$modelOption->redirect($urlHomes);
	}
}

function viewMail($input)
{
    global $urlHomes;
    global $metaTitleMantan;
    global $modelOption;
    global $metaTitleMantan;
    global $isRequestPost;
    $metaTitleMantan= 'Xem thông báo';

    $modelEmail= new Email();
    if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('viewEmail', $_SESSION['infoStaff']['Staff']['permission']))){
        
	        $data= $modelEmail->getEmail($_GET['id']);
	        $mess= '';
	        if(empty($data)) $modelOption->redirect($urlHomes.'listMail');
	        $data['Email']['listView'][]= $_SESSION['infoStaff']['Staff']['id'];
	        $data['Email']['listView'] = array_unique($data['Email']['listView']);

	        if($isRequestPost){
	        	if($data['Email']['type']=='agency'){
	        		$dataSend= arrayMap($input['request']->data);

	        		if(empty($data['Email']['reply'])) $data['Email']['reply']= array();
	        		$data['Email']['reply'][]= array(	'time'=>time(),
	        											'content'=>$dataSend['content'],
	        											'nameFrom'=> 'Quản trị viên'
	        										);
                    $data['Email']['timeUpdate']= time();
	        		$data['Email']['lastSend']= '';
	        		$data['Email']['listView']= array($_SESSION['infoStaff']['Staff']['id']);
	        		if($modelEmail->save($data)){
	        			$mess= 'Gửi phản hồi thành công';
	        		}else{
	        			$mess= 'Gửi phản hồi thất bại';
	        		}
	        	}else{
	        		$modelOption->redirect($urlHomes.'listMail');
	        	}
	        }

	        if(empty($mess)) $modelEmail->save($data);

	        setVariable('data',$data);
	        setVariable('mess',$mess);
	    }else{
	    	$modelOption->redirect($urlHomes.'dashboard');
	    }
    }else{
        $modelEmail->redirect($urlHomes.'login?status=-2');
    }
}

function sendMail($input) {
	global $modelOption;
	global $isRequestPost;
	global $urlHomes;
	global $urlPlugins;
	global $contactSite;
	global $smtpSite;

	if(!empty($_SESSION['infoStaff'])){
		if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('sendMail', $_SESSION['infoStaff']['Staff']['permission']))){
			$mess= '';

			if($isRequestPost){
				$dataSend = arrayMap($input['request']->data);
				$modelAgency= new Agency();
				$modelEmail= new Email();

				$save['Email']['subject']= $dataSend['subject'];
				$save['Email']['content']= $dataSend['content'];
				$save['Email']['time']= time();
				$save['Email']['timeUpdate']= time();
				$save['Email']['type']= (isset($_GET['type']) && $_GET['type']=='agency')?'agency':'all';
				$save['Email']['codeAgency']= '';
                $save['Email']['idAgency']= '';
				$save['Email']['lastSend']= '';
				$save['Email']['nameFrom']= 'Quản trị viên';
				$save['Email']['listView']= array($_SESSION['infoStaff']['Staff']['id']);
				
				if($save['Email']['type']=='agency'){
					if(!empty($dataSend['phoneAgency'])){
						$agency= $modelAgency->getAgencyByPhone($dataSend['phoneAgency'],array('code','phone'));
						if($agency){
							$save['Email']['codeAgency']= $agency['Agency']['code'];
							$save['Email']['idAgency']= $agency['Agency']['id'];
							$save['Email']['phoneAgency']= $agency['Agency']['phone'];
						}else{
							$mess= 'Không tồn tại đại lý này';
						}
					}else{
						$mess= 'Không được để trống số điện thoại đại lý nhận thông báo';
					}
				}

				if($modelEmail->save($save)){
					$modelOption->redirect($urlHomes.'listMail?status=sendEmailDone');
				}else{
					$modelOption->redirect($urlHomes.'listMail?status=sendEmailFail');
				}
			}

			setVariable('mess',$mess);
		}else{
            $modelOption->redirect($urlHomes.'dashboard');
        }
	} else {
		$modelOption->redirect($urlHomes);
	}
}

// -------------------------------------------------------------------------------------
function listEmailAgency($input)
{
	global $urlHomes;
    global $modelOption;
    global $isRequestPost;
    global $urlNow;

    if(!empty($_SESSION['infoAgency'])){
        $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        $conditions= array();
        
        $order = array('timeUpdate'=>'DESC');
        $fields= array('subject','time','status','type','nameFrom','listView');
        $modelEmail= new Email();
        $mess= '';
      
        if(!empty($_GET['type'])){
        	switch ($_GET['type']) {
        		case 'inbox': 	$conditions['type']='agency';
        						$conditions['idAgency']=$_SESSION['infoAgency']['Agency']['id'];
        						break;
        		case 'sent':    $conditions['type']='agency';
                                $conditions['idAgency']=$_SESSION['infoAgency']['Agency']['id'];
                                $conditions['lastSend']=$_SESSION['infoAgency']['Agency']['id'];
                                break;
        	}
        }else{
            /*
        	$conditions['$or']= array();
			$conditions['$or'][]= array('idAgency'=>$_SESSION['infoAgency']['Agency']['id']);
			$conditions['$or'][]= array('type'=>'all');
            */
            $conditions['$or']= array();
            $conditions['$or'][]= array('type'=>'all');
            $conditions['$or'][]= array('type'=>'system','idAgency'=>$_SESSION['infoAgency']['Agency']['id']);
        }
        //debug($conditions);
        $listData= $modelEmail->getPage($page, $limit , $conditions, $order, $fields );

        $conditionsNotification= array();
        $conditionsNotification['$or']= array();
        $conditionsNotification['$or'][]= array('type'=>'all');
        $conditionsNotification['$or'][]= array('type'=>'system','idAgency'=>$_SESSION['infoAgency']['Agency']['id']);
        $conditionsNotification['listView']= array('$nin'=>array($_SESSION['infoAgency']['Agency']['id']));

        $conditionsInbox= array();
        $conditionsInbox['type']='agency';
        $conditionsInbox['idAgency']=$_SESSION['infoAgency']['Agency']['id'];
        $conditionsInbox['listView']= array('$nin'=>array($_SESSION['infoAgency']['Agency']['id']));

        /*
        $conditionsSent= array();
        $conditionsSent['type']='agency';
        $conditionsSent['idAgency']=$_SESSION['infoAgency']['Agency']['id'];
        $conditionsSent['lastSend']=$_SESSION['infoAgency']['Agency']['id'];
        $conditionsSent['listView']= array('$nin'=>array($_SESSION['infoAgency']['Agency']['id']));
        */

        $numberNotification= $modelEmail->find('count',array('conditions' => $conditionsNotification));
        $numberInbox= $modelEmail->find('count',array('conditions' => $conditionsInbox));
        //$numberSent= $modelEmail->find('count',array('conditions' => $conditionsSent));

        $totalData= $modelEmail->find('count',array('conditions' => $conditions));
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

        if(!empty($_GET['status'])){
			switch ($_GET['status']) {
				case 'sendEmailDone': $mess= 'Gửi mail thành công';break;
				case 'sendEmailFail': $mess= 'Gửi mail thất bại';break;
			}
		}

        setVariable('listData',$listData);
        setVariable('numberNotification',$numberNotification);
        setVariable('numberInbox',$numberInbox);
        setVariable('tabFooter','listEmailAgency');
        //setVariable('numberSent',$numberSent);

        setVariable('page',$page);
        setVariable('totalPage',$totalPage);
        setVariable('back',$back);
        setVariable('next',$next);
        setVariable('urlPage',$urlPage);
        setVariable('mess',$mess);

        setVariable('statusOrder',getStatusOrder());
    }else{
        $modelOption->redirect($urlHomes.'login?status=-2');
    }
}

function viewEmailAgency($input)
{
    global $urlHomes;
    global $metaTitleMantan;
    global $modelOption;
    global $metaTitleMantan;
    global $isRequestPost;
    $metaTitleMantan= 'Xem thông báo';

    $modelEmail= new Email();
    if(!empty($_SESSION['infoAgency'])){
        
        $data= $modelEmail->getEmail($_GET['id']);
        $mess= '';
        if(empty($data)) $modelOption->redirect($urlHomes.'listEmailAgency');
        $data['Email']['listView'][]= $_SESSION['infoAgency']['Agency']['id'];
        $data['Email']['listView'] = array_unique($data['Email']['listView']);

        if($isRequestPost){
        	if($data['Email']['type']=='agency'){
        		$dataSend= arrayMap($input['request']->data);

        		if(empty($data['Email']['reply'])) $data['Email']['reply']= array();
        		$data['Email']['reply'][]= array(	'time'=>time(),
        											'content'=>$dataSend['content'],
        											'nameFrom'=> $_SESSION['infoAgency']['Agency']['fullName'].' - '.$_SESSION['infoAgency']['Agency']['code']
        										);
        		$data['Email']['timeUpdate']= time();
        		$data['Email']['listView']= array($_SESSION['infoAgency']['Agency']['id']);
                $data['Email']['lastSend']= $_SESSION['infoAgency']['Agency']['id'];
        		if($modelEmail->save($data)){
        			$mess= 'Gửi phản hồi thành công';
        		}else{
        			$mess= 'Gửi phản hồi thất bại';
        		}
        	}else{
        		$modelOption->redirect($urlHomes.'listEmailAgency');
        	}
        }

        if(empty($mess)) $modelEmail->save($data);

        setVariable('data',$data);
        setVariable('mess',$mess);
    }else{
        $modelEmail->redirect($urlHomes.'login?status=-2');
    }
}

function addEmailAgency($input)
{
	global $urlHomes;
    global $metaTitleMantan;
    global $modelOption;
    global $metaTitleMantan;
    global $isRequestPost;
    $metaTitleMantan= 'Gửi thông báo';

    $modelEmail= new Email();
    if(!empty($_SESSION['infoAgency'])){
        $mess= '';

        if($isRequestPost){
			$dataSend = arrayMap($input['request']->data);
			$modelAgency= new Agency();
			$modelEmail= new Email();

			$save['Email']['subject']= $dataSend['subject'];
			$save['Email']['content']= $dataSend['content'];
			$save['Email']['time']= time();
			$save['Email']['timeUpdate']= time();
			$save['Email']['type']= 'agency';
			$save['Email']['codeAgency']= $_SESSION['infoAgency']['Agency']['code'];
			$save['Email']['phoneAgency']= $_SESSION['infoAgency']['Agency']['phone'];
			$save['Email']['idAgency']= $_SESSION['infoAgency']['Agency']['id'];
			$save['Email']['nameFrom']= $_SESSION['infoAgency']['Agency']['fullName'].' - '.$_SESSION['infoAgency']['Agency']['code'];
            $save['Email']['listView']= array($_SESSION['infoAgency']['Agency']['id']);
			$save['Email']['lastSend']= $_SESSION['infoAgency']['Agency']['id'];

			if($modelEmail->save($save)){
				$modelOption->redirect($urlHomes.'listEmailAgency?status=sendEmailDone');
			}else{
				$modelOption->redirect($urlHomes.'listEmailAgency?status=sendEmailFail');
			}
		}

        setVariable('mess',$mess);
    }else{
        $modelEmail->redirect($urlHomes.'login?status=-2');
    }
}
?>