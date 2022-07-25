<?php 
function listManager($input)
{
	global $modelOption;
	global $urlHomes;
	global $urlNow;

	$modelManager = new Manager();

	if(checkAdminLogin()){
		$limit = 15;
        $conditions = array();

        if(!empty($_GET['phone'])){
        	$conditions['phone'] = $_GET['phone'];
        }

        if(!empty($_GET['email'])){
        	$conditions['email'] = $_GET['email'];
        }

        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0) $page = 1;

		$listData = $modelManager->getPage($page, $limit, $conditions, $order = array('created' => 'desc'));

        $totalData= $modelManager->find('count',array('conditions' => $conditions));
	
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
			if(count($_GET)>=1){
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

	}else{
		$modelManager->redirect($urlHomes);
	}
}

function addMoneyManager($input)
{
	global $modelOption;
	global $urlHomes;
	global $urlNow;
	global $isRequestPost;

	$modelManager = new Manager();
	$modelHistory = new History();

	if(checkAdminLogin()){
		if(!empty($_GET['id'])) {
			$infoManager = $modelManager->getData($_GET['id']);

			if($infoManager){
				$mess= '';

				if($isRequestPost){
					$dataSend= arrayMap($input['request']->data);

					if($dataSend['coin']>=50000){
						$infoManager['Manager']['coin'] += (int) $dataSend['coin'];

						if($modelManager->save($infoManager)){
							$mess = 'Nạp tiền thành công';

							$saveHistory['History']['time']= time();
		                    $saveHistory['History']['idManager']= $infoManager['Manager']['id'];
		                    $saveHistory['History']['numberCoin']= (int) $dataSend['coin'];
		                    $saveHistory['History']['numberCoinManager']= $infoManager['Manager']['coin'];
		                    $saveHistory['History']['type']= 'plus';
		                    $saveHistory['History']['note']= 'Nạp tiền vào tài khoản';
		                    
		                    $modelHistory->save($saveHistory);
						}else{
							$mess = 'Lỗi hệ thống';
						}
					}
				}

				setVariable('mess',$mess);
				setVariable('infoManager',$infoManager);
			}else{
				$modelManager->redirect('/plugins/admin/quayso-view-admin-listManager.php');
			}
		}else{
			$modelManager->redirect('/plugins/admin/quayso-view-admin-listManager.php');
		}
		

	}else{
		$modelManager->redirect($urlHomes);
	}
}

function changePackManager($input)
{
	global $modelOption;
	global $urlHomes;
	global $urlNow;
	global $isRequestPost;

	$modelManager = new Manager();

	if(checkAdminLogin()){
		if(!empty($_GET['id'])) {
			$infoManager = $modelManager->getData($_GET['id']);

			if($infoManager){
				$mess= '';

				if($isRequestPost){
					$dataSend= arrayMap($input['request']->data);

					$infoManager['Manager']['typeBuy'] = $dataSend['typeBuy'];

					if($dataSend['typeBuy']=='buyMonth'){
						$infoManager['Manager']['deadlineBuy'] = strtotime('+30 day');
					}

					if($modelManager->save($infoManager)){
						$mess = 'Đổi gói dịch vụ thành công';
					}else{
						$mess = 'Lỗi hệ thống';
					}
				}

				setVariable('mess',$mess);
				setVariable('infoManager',$infoManager);
			}else{
				$modelManager->redirect('/plugins/admin/quayso-view-admin-listManager.php');
			}
		}else{
			$modelManager->redirect('/plugins/admin/quayso-view-admin-listManager.php');
		}
		

	}else{
		$modelManager->redirect($urlHomes);
	}
}
?>