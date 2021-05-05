<?php
	function qrcode($input)
    {
        global $urlHomes;
        global $metaTitleMantan;
        global $modelOption;
        global $metaTitleMantan;
        global $urlNow;
        $metaTitleMantan= 'Mã QR';

        $modelStaff= new Staff();
        if(!empty($_SESSION['infoAgency'])){
        	$page = (!empty($_GET['page']))?(int)$_GET['page']:1;
            if($page<1) $page=1;
            $limit= 15;
            $conditions=array('idAgencyFather'=>$_SESSION['infoAgency']['Agency']['id']);
            $order = array('created'=>'DESC');
            $fields= array();
            $modelQrcode= new Qrcode();
            $mess= '';

            if(!empty($_GET['code'])){
                $conditions['code']= strtoupper($_GET['code']);
            }

            if(!empty($_GET['status'])){
                $conditions['status']= $_GET['status'];
            }
            
            $listData= $modelQrcode->getPage($page, $limit , $conditions, $order, $fields );

            $totalData= $modelQrcode->find('count',array('conditions' => $conditions));
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

            setVariable('listAgency',getListAgency());
        }else{
            $modelStaff->redirect($urlHomes.'login?status=-2');
        }
    }

    function createQR($input)
    {
        global $urlHomes;
        global $metaTitleMantan;
        global $modelOption;
        global $metaTitleMantan;
        global $isRequestPost;
        $metaTitleMantan= 'Tạo mã QR';

        $modelStaff= new Staff();
        if(!empty($_SESSION['infoAgency'])){
        	$modelAgency= new Agency();
        	$modelQrcode= new Qrcode();
            $modelHistory= new History();

            $agency= $modelAgency->getAgency($_SESSION['infoAgency']['Agency']['id'],array('wallet'));
            $listAgency= getListAgency();
            $mess= '';

            if($isRequestPost){
            	$dataSend= $input['request']->data;
            	if(!empty($listAgency[$dataSend['level']])){
                    $moneyPause= $listAgency[$dataSend['level']]['money_deposit']+$listAgency[$dataSend['level']]['money_product'];

                    if(($agency['Agency']['wallet']['purchaseFund']+$agency['Agency']['wallet']['active'])>=$moneyPause){
                        if($agency['Agency']['wallet']['purchaseFund']>=$moneyPause){
                            $saveAgency['$inc']['wallet.purchaseFund']= 0-$moneyPause;
                        }else{
                            $saveAgency['$inc']['wallet.active']= $agency['Agency']['wallet']['purchaseFund']-$moneyPause;
                            $saveAgency['$inc']['wallet.purchaseFund']= 0;
                        }
                		
                		$saveAgency['$inc']['wallet.qrcode']= $moneyPause;
                		$dkAgency= array('_id'=>new MongoId($_SESSION['infoAgency']['Agency']['id']));

                		if($modelAgency->updateAll($saveAgency,$dkAgency)){
                            $agency['Agency']['wallet']['purchaseFund'] -= $moneyPause;
                            if(empty($agency['Agency']['wallet']['qrcode'])){
                                $agency['Agency']['wallet']['qrcode']= $moneyPause;
                            }else{
                                $agency['Agency']['wallet']['qrcode'] += $moneyPause;
                            }
                            

                			$mess= 'Tạo mã thành công, bạn lưu mã QR về máy rồi gửi cho đại lý cần kích hoạt';

                			$code= $modelOption->getOption('codeQRGavi');
    	                    $code['Option']['value']['count']= (isset($code['Option']['value']['count']))?$code['Option']['value']['count']+1:1;
    	                    $codeQR= 'QR'.$code['Option']['value']['count'];
    	                    $modelOption->saveOption('codeQRGavi',$code['Option']['value']);

                			$qrcode['Qrcode']['idAgencyFather']= $_SESSION['infoAgency']['Agency']['id'];
                			$qrcode['Qrcode']['codeAgencyFather']= $_SESSION['infoAgency']['Agency']['code'];
                			$qrcode['Qrcode']['level']= $dataSend['level'];
                			$qrcode['Qrcode']['code']= $codeQR;
                            $qrcode['Qrcode']['money_deposit']= $listAgency[$dataSend['level']]['money_deposit'];
                			$qrcode['Qrcode']['money_product']= $listAgency[$dataSend['level']]['money_product'];
                			$qrcode['Qrcode']['time']= time();
                			$qrcode['Qrcode']['status']= 'active';
                			$qrcode['Qrcode']['deadline']= $qrcode['Qrcode']['time']+864000;


                			$modelQrcode->save($qrcode);

                            // Lưu lịch sử giao dịch
                            $saveHistory['History']['mess']= 'Hệ thống trừ '.number_format($moneyPause).'đ từ tài khoản khả dụng của bạn do bạn đã tạo mã QR kích hoạt '.$codeQR;
                            $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                            $saveHistory['History']['time']['time']= time();
                            $saveHistory['History']['price']= $moneyPause;
                            $saveHistory['History']['idAgency']= $_SESSION['infoAgency']['Agency']['id'];
                            $saveHistory['History']['codeAgency']= $_SESSION['infoAgency']['Agency']['code'];
                            $saveHistory['History']['typeExchange']= 4; // mua hàng
                            $modelHistory->create();
                            $modelHistory->save($saveHistory);

                			setVariable('codeQR',$codeQR);
                		}else{
                			$mess= 'Lỗi hệ thống';
                		}
                    }else{
                        $mess= 'Số dư tài khoản không đủ để tạo mã QR';
                    }
            	}else{
            		$mess= 'Bạn cần chọn cấp đại lý phù hợp';
            	}
            }

            $_SESSION['infoAgency']['Agency']['wallet']= $agency['Agency']['wallet'];

            setVariable('agency',$agency);
            setVariable('listAgency',$listAgency);
            setVariable('mess',$mess);
        }else{
            $modelStaff->redirect($urlHomes.'login?status=-2');
        }
    }

    function activeQRCode($input)
    {
    	global $urlHomes;
    	global $modelOption;

    	$modelQrcode= new Qrcode();
    	$modelAgency= new Agency();
        $modelHistory= new History();

    	if(!empty($_GET['code']) && !empty($_GET['idAgencyFather'])){
    		$data= $modelQrcode->getQrcodeByCode($_GET['code']);
    		$listAgency= getListAgency();
            $today= getdate();

    		if($data && $data['Qrcode']['idAgencyFather']==$_GET['idAgencyFather']){
    			if($data['Qrcode']['status']=='active'){
    				if($data['Qrcode']['deadline']>=time()){
	    				// tạo dữ liệu cho agency mới
	    				$agencyFather= $modelAgency->getAgency($data['Qrcode']['idAgencyFather'],array('level'));
	    				
	                    $code= $modelOption->getOption('codeAgencyGavi');
	                    $code['Option']['value']['count']= (isset($code['Option']['value']['count']))?$code['Option']['value']['count']+1:1;
	                    $modelOption->saveOption('codeAgencyGavi',$code['Option']['value']);

	                    $saveAgency['Agency']['status']= 'active';
	                    $saveAgency['Agency']['code']= 'DL'.$code['Option']['value']['count'];
	                    $saveAgency['Agency']['pass']= md5('123456');
	                    $saveAgency['Agency']['level']= (int) $data['Qrcode']['level']; //cộng tác viên

                        // tiền ra
                        $data['Agency']['wallet']['order']= 0; // tiền đặt cọc mua hàng chờ duyệt
                        $data['Agency']['wallet']['qrcode']= 0; // tiền đặt cọc tạo mã qr chờ duyệt
                        $data['Agency']['wallet']['penalties']= 0; // tiền phạt chờ duyệt
                        $data['Agency']['wallet']['ship']= 0; // tiền vận chuyển hàng chờ duyệt
                        
                        // tiền vào
                        $data['Agency']['wallet']['waitingOrder']= 0; // tiền bán hàng chờ duyệt
                        $data['Agency']['wallet']['waitingBonus']= 0; // tiền thưởngban bán hàng đại lý chờ duyệt
                        $data['Agency']['wallet']['waitingQRBonus']= 0; // tiền thưởng giới thiệu đại lý chờ duyệt
                        $data['Agency']['wallet']['waitingShip']= 0; // tiền đại lý nhờ thu hộ khi giao hàng chờ duyệt

                        $saveAgency['Agency']['wallet']['active']= 0; // tiền khả dụng
                        $saveAgency['Agency']['wallet']['request']= 0; // tiền tạm giữ chờ rút
	                    
	                    $saveAgency['Agency']['wallet']['deposit']= (int) $data['Qrcode']['money_deposit']; // tiền đặt cọc đại lý
                        $saveAgency['Agency']['wallet']['recharge']= 0;
	                    $saveAgency['Agency']['wallet']['purchaseFund']= (int) $data['Qrcode']['money_product'];

	                    if($agencyFather['Agency']['level']<=$data['Qrcode']['level']){
	                    	$saveAgency['Agency']['codeAgencyFather']= $data['Qrcode']['codeAgencyFather'];
	                    	$saveAgency['Agency']['idAgencyFather']= $data['Qrcode']['idAgencyFather'];
                            
	                    }else{
	                    	$saveAgency['Agency']['codeAgencyFather']= '';
	                    	$saveAgency['Agency']['idAgencyFather']= '';
	                    }
	                    
                        $saveAgency['Agency']['codeAgencyIntroduce']= $data['Qrcode']['codeAgencyFather'];
                        $saveAgency['Agency']['idAgencyIntroduce']= $data['Qrcode']['idAgencyFather'];
	                    $saveAgency['Agency']['slug']= '';
	                    $saveAgency['Agency']['fullName']= '';
	                    $saveAgency['Agency']['email']= '';
	                    $saveAgency['Agency']['phone']= '';
	                    $saveAgency['Agency']['cmnd']= '';
	                    $saveAgency['Agency']['address']= '';
	                    $saveAgency['Agency']['note']= '';
	                    $saveAgency['Agency']['avatar']= '';
	                    $saveAgency['Agency']['idCity']= '';
	                    $saveAgency['Agency']['dateStart']['time']= time();
	                    $saveAgency['Agency']['dateStart']['text']= date('d/m/Y',$saveAgency['Agency']['dateStart']['time']);
	                    $saveAgency['Agency']['bank']= array();
	                    $saveAgency['Agency']['addressTo']= array();
	                    $saveAgency['Agency']['idQrcode']= $data['Qrcode']['id'];

	                    if($modelAgency->save($saveAgency)){
	                    	$data['Qrcode']['status']= 'done';
	    					$data['Qrcode']['timeActive']= $saveAgency['Agency']['dateStart']['time'];
	    					$data['Qrcode']['idAgencyActive']= $modelAgency->getLastInsertId();
	    					$data['Qrcode']['codeAgencyActive']= $saveAgency['Agency']['code'];

	    					$modelQrcode->save($data);

	    					// tính tiền cho đại lý giới thiệu

                            //$saveAgencyCreate['$inc']['wallet.waitingQRBonus']= $listAgency[$data['Qrcode']['level']]['money_bonus'];
                            $saveAgencyCreate['$inc']['wallet.active']= $listAgency[$data['Qrcode']['level']]['money_bonus'];
                            $saveAgencyCreate['$inc']['wallet.qrcode']= 0-$data['Qrcode']['money_deposit'];
                            
                            $saveAgencyCreate['$inc']['walletStatic.introduce.'.$today['year'].'.'.$today['mon'] ]= (int) $listAgency[$data['Qrcode']['level']]['money_bonus'];

		            		$dkAgency= array('_id'=>new MongoId($data['Qrcode']['idAgencyFather']));
		            		$modelAgency->create();
		            		$modelAgency->updateAll($saveAgencyCreate,$dkAgency);

                            // Lưu lịch sử giao dịch
                            $saveHistory['History']['mess']= 'Hệ thống cộng '.number_format($listAgency[$data['Qrcode']['level']]['money_bonus']).'đ tiền thưởng giới thiệu đại lý vào tài khoản được rút của bạn';
                            $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                            $saveHistory['History']['time']['time']= time();
                            $saveHistory['History']['price']= $listAgency[$data['Qrcode']['level']]['money_bonus'];
                            $saveHistory['History']['idAgency']= $data['Qrcode']['idAgencyFather'];
                            $saveHistory['History']['codeAgency']= $data['Qrcode']['codeAgencyFather'];
                            $saveHistory['History']['typeExchange']= 5; // mua hàng
                            $modelHistory->create();
                            $modelHistory->save($saveHistory);

                            /*
                            $saveHistory['History']['mess']= 'Hệ thống trừ '.number_format($data['Qrcode']['money_deposit']).'đ tiền đặt cọc chờ kích hoạt mã QR từ tài khoản chờ xử lý của bạn sau khi mã '.$data['Qrcode']['code'].' được kích hoạt thành công';
                            $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                            $saveHistory['History']['time']['time']= time();
                            $saveHistory['History']['price']= $data['Qrcode']['money_deposit'];
                            $saveHistory['History']['idAgency']= $data['Qrcode']['idAgencyFather'];
                            $saveHistory['History']['codeAgency']= $data['Qrcode']['codeAgencyFather'];
                            $saveHistory['History']['typeExchange']= 4; // mua hàng
                            $modelHistory->create();
                            $modelHistory->save($saveHistory);
                            */

	    					$modelQrcode->redirect($urlHomes.'createAgency?id='.$data['Qrcode']['idAgencyActive'].'&idQrcode='.$data['Qrcode']['id']);
	                    }else{
	                    	echo '<html><head><meta charset="utf-8"></head><body><center>Tạo dữ liệu lỗi</center></body></html';
	                    }
	                }else{
	                	$data['Qrcode']['status']= 'cancel';
                        $moneyPause= $data['Qrcode']['money_deposit']+$data['Qrcode']['money_product'];
                        
                        $saveAgency['$inc']['wallet.purchaseFund']= $moneyPause;
                        $saveAgency['$inc']['wallet.qrcode']= 0-$moneyPause;
                        
                        $dkAgency= array('_id'=>new MongoId($data['Qrcode']['idAgencyFather']));

                        if($modelAgency->updateAll($saveAgency,$dkAgency)){
                            // Lưu lịch sử giao dịch
                            $saveHistory= array();
                            $saveHistory['History']['mess']= 'Hệ thống hoàn '.number_format($moneyPause).'đ tiền tạo mã QR bị đóng băng vào Quỹ mua hàng';
                            $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                            $saveHistory['History']['time']['time']= time();
                            $saveHistory['History']['price']= $moneyPause;
                            $saveHistory['History']['idAgency']= $data['Qrcode']['idAgencyFather'];
                            $saveHistory['History']['codeAgency']= $data['Qrcode']['codeAgencyFather'];
                            $saveHistory['History']['typeExchange']= 5; // mua hàng
                            $modelHistory->create();
                            $modelHistory->save($saveHistory);
                        }

	                	$modelQrcode->save($data);
                        echo '<html><head><meta charset="utf-8"></head><body><center>Mã QR hết hạn sử dụng</center></body></html';
	                }
    			}else{
    				echo '<html><head><meta charset="utf-8"></head><body><center>Mã QR đã được sử dụng</center></body></html';
    			}
    		}else{
    			echo '<html><head><meta charset="utf-8"></head><body><center>Thông tin mã QR sai</center></body></html';
    		}
    	}else{
    		$modelQrcode->redirect($urlHomes);
    	}
    }

    function cancelQRCodeAgency($input)
    {
        global $urlHomes;
        global $modelOption;

        $modelQrcode= new Qrcode();
        $modelAgency= new Agency();
        $modelHistory= new History();

        if(!empty($_SESSION['infoAgency'])){
            if(!empty($_GET['id'])){
                $data= $modelQrcode->getQrcode($_GET['id']);

                if($data && $data['Qrcode']['idAgencyFather']==$_SESSION['infoAgency']['Agency']['id']){
                    if($data['Qrcode']['status']=='active'){
                        $data['Qrcode']['status']= 'delete';

                        $moneyPause= $data['Qrcode']['money_deposit']+$data['Qrcode']['money_product'];
                        
                        $saveAgency['$inc']['wallet.purchaseFund']= $moneyPause;
                        $saveAgency['$inc']['wallet.qrcode']= 0-$moneyPause;
                        
                        $dkAgency= array('_id'=>new MongoId($_SESSION['infoAgency']['Agency']['id']));

                        if($modelAgency->updateAll($saveAgency,$dkAgency)){
                            // Lưu lịch sử giao dịch
                            $saveHistory= array();
                            $saveHistory['History']['mess']= 'Hệ thống hoàn '.number_format($moneyPause).'đ tiền tạo mã QR bị đóng băng vào Quỹ mua hàng';
                            $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                            $saveHistory['History']['time']['time']= time();
                            $saveHistory['History']['price']= $moneyPause;
                            $saveHistory['History']['idAgency']= $_SESSION['infoAgency']['Agency']['id'];
                            $saveHistory['History']['codeAgency']= $_SESSION['infoAgency']['Agency']['code'];
                            $saveHistory['History']['typeExchange']= 5; // mua hàng
                            $modelHistory->create();
                            $modelHistory->save($saveHistory);
                        }

                        $modelQrcode->save($data);
                        $modelQrcode->redirect($urlHomes.'qrcode');
                    }else{
                        $modelQrcode->redirect($urlHomes.'qrcode');
                    }
                }else{
                    $modelQrcode->redirect($urlHomes.'qrcode');
                }
            }else{
                $modelQrcode->redirect($urlHomes.'qrcode');
            }
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }
?>