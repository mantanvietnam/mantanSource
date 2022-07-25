<?php
function spin($input)
{
	global $modelUser;
	global $modelOption;
	global $urlHomes;
	global $isRequestPost;

	$modelCampaign = new Campaign();

	$conditions= array();
	$order= array('codeQT'=>'desc');
	
	$listAllUser= array();
	$listUserWin= array();
	$listUserWinNew= array();
	$kq= '0000';
	$namekq= 'Không có người trúng thưởng';
	$idUserkq= '';
	$checkManager = false;

	if(isset($input['request']->params['pass'][1])){
		$input['request']->params['pass'][1]= str_replace('.html', '', $input['request']->params['pass'][1]);
		$infoCampaign= $modelCampaign->find('first', array('conditions'=>array('urlSlug'=>$input['request']->params['pass'][1])));
		
		if(empty($infoCampaign)){
			$modelUser->redirect('/error');
		}else{
			if (!empty($_SESSION['infoManager'])) {
				$checkManager = true;
			}else{
				if($isRequestPost){
					$dataSend = arrayMap($input['request']->data);
					
					if(!empty($dataSend['codeSecurity']) && !empty($infoCampaign['Campaign']['codeSecurity']) && $dataSend['codeSecurity'] == $infoCampaign['Campaign']['codeSecurity']){
						$checkManager = true;
						$_SESSION['codeSecurity'] = $dataSend['codeSecurity'];
					}
				}
			}

			$conditions['campaign']= $infoCampaign['Campaign']['id'];

			if(!empty($infoCampaign['Campaign']['typeUserWin']) && $infoCampaign['Campaign']['typeUserWin']=='checkin'){
				$conditions['checkin']['$exists'] = true;
				$conditions['checkin']['$ne'] = 0;
			}

			$listAllUser= $modelUser->find('all', array('conditions'=>$conditions,'order'=>$order));

			if(!empty($infoCampaign['Campaign']['listUserWin'])){
				foreach($infoCampaign['Campaign']['listUserWin'] as $idUser=>$time){
					$listUserWin[$idUser]= $modelUser->getUser($idUser);
					if(!empty($listUserWin[$idUser])){
						$listUserWin[$idUser]['User']['time']= $time;
					}
				}
			}

			// fake start
			/*
			$stt= array();
			$number= -1;
			*/
			// fake end

			if(!empty($listAllUser)){
				foreach ($listAllUser as $key => $value) {
					if(empty($listUserWin[$value['User']['id']])){
						$listUserWinNew[]= $value;

						// fake start
						/*
						$number++;
						if(	   $value['User']['codeQT']==1312 
							|| $value['User']['codeQT']==1313 
							|| $value['User']['codeQT']==1314
						){
							$stt[]= $number;
						}
						*/
						// fake end
					}
				}
			}

			if(!empty($listUserWinNew)){
				$randUser= rand(0,count($listUserWinNew)-1);

				// fake start
				/*
				if(!empty($stt)){
					$random_keys=array_rand($stt,1);
					$randUser= $stt[$random_keys];
				}
				*/
				// fake end

				$kq= $listUserWinNew[$randUser]['User']['codeQT'];
				$namekq= $listUserWinNew[$randUser]['User']['fullName'].' - '.$listUserWinNew[$randUser]['User']['phone'];
				$idUserkq= $listUserWinNew[$randUser]['User']['id'];
			}
		}
	}else{
		$modelUser->redirect('/error');
	}

	setVariable('listAllUser', $listAllUser);
	setVariable('listUserWin', $listUserWin);
	setVariable('kq', $kq);
	setVariable('namekq', $namekq);
	setVariable('idUserkq', $idUserkq);
	setVariable('infoCampaign', $infoCampaign);
	setVariable('checkManager', $checkManager);
	
}
?>