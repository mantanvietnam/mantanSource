<?php
	function syncSetting($input)
	{
		global $modelOption;
		global $urlHomes;
		global $isRequestPost;

		if(checkAdminLogin()){
			$data= $modelOption->getOption('settingProductBizman');
			$mess= '';

			if($isRequestPost){
				$dataSend= $input['request']->data;

				$data['Option']['value']['dateSync']= (int) $dataSend['dateSync'];
				$data['Option']['value']['ipHostBizman']= $dataSend['ipHostBizman'];
				$data['Option']['value']['checkPrice']= (isset($dataSend['checkPrice']))?$dataSend['checkPrice']:'web';
				$data['Option']['value']['lengthCode']= (int) $dataSend['lengthCode'];
				$data['Option']['value']['keyFlag']= trim($dataSend['keyFlag']);
				
				$modelOption->saveOption('settingProductBizman', $data['Option']['value']);
				$mess= 'Lưu dữ liệu thành công';
			}

			setVariable('data',$data);
			setVariable('mess',$mess);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function listStore($input)
	{
		global $modelOption;
		global $urlHomes;
		global $isRequestPost;

		if(checkAdminLogin()){
			$listStore= GetAllListStore();
			$listStore= json_decode($listStore, true);
			$settingProduct= $modelOption->getOption('settingProductBizman');

			setVariable('listStore',$listStore);
			setVariable('settingProduct',$settingProduct);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function saveStore($input)
	{
		global $modelOption;
		global $urlHomes;
		global $isRequestPost;
		global $urlPlugins;

		if(checkAdminLogin()){
			if(isset($input['request']->query['id'])){
				$data= $modelOption->getOption('settingProductBizman');
				$data['Option']['value']['storeDefault']= $input['request']->query['id'];
				
				$modelOption->saveOption('settingProductBizman', $data['Option']['value']);
			}

			$modelOption->redirect($urlPlugins.'admin/bizman-store-listStore.php');
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function saveStoreDiscount($input)
	{
		global $modelOption;
		global $urlHomes;
		global $isRequestPost;
		global $urlPlugins;

		if(checkAdminLogin()){
			if(isset($input['request']->query['id'])){
				$data= $modelOption->getOption('settingProductBizman');
				$data['Option']['value']['storeDiscount']= $input['request']->query['id'];
				
				$modelOption->saveOption('settingProductBizman', $data['Option']['value']);
			}

			$modelOption->redirect($urlPlugins.'admin/bizman-store-listStore.php');
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function checkProductStore($input)
	{
		global $modelOption;
		global $urlHomes;
		global $isRequestPost;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin() && $isRequestPost){
			if(isset($_POST['storeIdCheck']))
			{	
				$listProductStore= GetStockByStoreId($_POST['productCode'],$_POST['storeIdCheck']); 
				$listProductStore= json_decode($listProductStore, true);
			}
			else
			{
				$listProductStore= GetTotalStockInAllStores($_POST['productCode']); 
				$listProductStore= json_decode($listProductStore, true);
			}

			setVariable('listProductStore',$listProductStore);
		}
	}

	function syncCategory($input)
	{
		global $modelOption;
		global $urlHomes;
		global $isRequestPost;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin()){
			$mess= '';
			$infoSync= null;

			if($isRequestPost){
				if(isset($input['request']->data['infoSync']) && count($input['request']->data['infoSync'])>0){
					$listCategoryBizman= LoadAllProductCatelogy();
					$listCategoryBizman= json_decode($listCategoryBizman, true);

					$listMantan= array();
					$idRoot= 1;
					$infoSync= $input['request']->data['infoSync'];
					$listMantan= convertBizmanToMantan($listCategoryBizman,$idRoot,$listMantan,$idRoot,$infoSync);

					$max= 0;
					foreach($listCategoryBizman as $category)
					{
						if($category['IDCatelogy']>$max)
						{
							$max= $category['IDCatelogy'];
						}
					}
					
					$groups= $modelOption->getOption('productCategory');
					$groups['Option']['value']['category']= $listMantan;
					$groups['Option']['value']['tCategory']= $max;
					
					$modelOption->saveOption('productCategory', $groups['Option']['value']);

					$mess= 'Đồng bộ danh mục thành công';
				}else{
					$mess= 'Bạn chưa chọn thuộc tính đồng bộ';
				}
			}

			setVariable('mess',$mess);
			setVariable('infoSync',$infoSync);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function syncProduct($input)
	{
		global $modelOption;
		global $urlHomes;
		global $isRequestPost;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin()){
			$mess= '';
			$infoSync= null;

			if($isRequestPost){
				if(!class_exists('Product')){
					$mess= 'Đồng bộ thất bại do bạn chưa kích hoạt Plugin product';
				}elseif(isset($input['request']->data['infoSync']) && count($input['request']->data['infoSync'])>0){
					$infoSync= $input['request']->data['infoSync'];
					$settingProduct= $modelOption->getOption('settingProductBizman');
					$settingProduct['Option']['value']['dateSync']= (isset($settingProduct['Option']['value']['dateSync']))? (int) $settingProduct['Option']['value']['dateSync']:null;
					$dateSync = getdate($settingProduct['Option']['value']['dateSync']);
					
					$dateSync = '/Date('.$dateSync[0].'000+0700)/';
					//$listProduct= SyncProductWeb($dateSync);
					$listProduct= SyncProductWebByAlias($dateSync);
					$listProduct= json_decode($listProduct, true);
				
					$listIdBizMan= array();
					$modelProduct= new Product();
					$dem= -1;
					$today= getdate();
					
					if(count($listProduct)>0)
					{
						foreach($listProduct as $keyBizman=>$productBM)
						{
							$dem++;
							$product= $modelProduct-> find('first', array('conditions' => array ('idBizman' => $productBM['productId'])) );
							$listIdBizMan[$productBM['productId']]= 1;

							$product['Product']['idBizman']= $productBM['productId'];
							if(!isset($product['Product']['timeUp'])) $product['Product']['timeUp']= $today[0];

							// Neu chon dong bo ten san pham
							if(in_array('title', $infoSync)){
								if(mb_strlen($settingProduct['Option']['value']['keyFlag'])>0){
									$productName= explode($settingProduct['Option']['value']['keyFlag'], $productBM['productName']);
									$productBM['productName']= $productName[0];
								}

								$slug= createSlugMantan($productBM['productName']);

								if(!isset($product['Product']['slug']) || $slug!=$product['Product']['slug']) {
									$listSlug= $modelProduct->find('all', array('conditions' => array('slug'=>array('$regex' => $slug)  ) ));
									$number= count($listSlug);
									
									if( $number>0 && 
										(!isset($product['Product']['id']) || $number>1 || $product['Product']['id']!=$listSlug[0]['Product']['id'])
									){
										$slug= $slug.'-'.$number;
									}
								}

								$product['Product']['slug']= $slug;
								$product['Product']['title']= $productBM['productName'];
							}

							// Neu chon dong bo trang thai cua san pham
							if(in_array('lock', $infoSync)){
								if($productBM['Active']==1) {
									$product['Product']['lock']= 0;
								} else {
									$product['Product']['lock']= 1;
								}
							}

							// Neu chon dong bo gia ban
							if(in_array('price', $infoSync)){
								if(!empty($productBM['PriceAndQuantityInfo'])){
									foreach($productBM['PriceAndQuantityInfo'] as $infoBM)
									{
										if($infoBM['KHOID']==$settingProduct['Option']['value']['storeDefault'] || $infoBM['KHOID']=='00000000-0000-0000-0000-000000000000')
										{
											$product['Product']['price']= (int) $infoBM['PRICE'];
										}
									}
								}
							}

							// Neu chon dong bo ten goi khac alias
							if(in_array('alias', $infoSync)){
								if(strlen($productBM['Alias'])>0) {
								    $slugAlias= createSlugMantan($productBM['Alias']);
								} else {
									$slugAlias= '';
								}

								$product['Product']['alias']= $productBM['Alias'];
								$product['Product']['slugAlias']=$slugAlias;
							}

							// Neu chon mo ta ngan
							if(in_array('description', $infoSync)){
								$product['Product']['description']= $productBM['Descripton'];
							}

							// Neu chon mo ta chi tiet
							if(in_array('info', $infoSync)){
								$product['Product']['info']= $productBM['Note'];
							}
							
							// Neu chon so luong
							if(in_array('quantity', $infoSync)){
								$quantity= 0;
								if(!empty($productBM['PriceAndQuantityInfo'])){
									foreach($productBM['PriceAndQuantityInfo'] as $infoBM)
									{
										$quantity+= $infoBM['QUANTITY'];
									}
								}

								$product['Product']['quantity']= $quantity;
							}

							// Neu chon dong bo nhom danh muc san pham
							if(in_array('category', $infoSync)){
								$product['Product']['category']= array($productBM['productCatelogyID']);
							}
							
							// Neu chon dong bo ma san pham
							if(in_array('code', $infoSync)){
								if($settingProduct['Option']['value']['lengthCode']<0){
									$product['Product']['code']= $productBM['productCode'];
								}else{
									$product['Product']['code']= substr( $productBM['productCode'],  0, $settingProduct['Option']['value']['lengthCode']);
								}
							}
							
							$modelProduct->create();
							$modelProduct->save($product);
							
							unset($listProduct[$keyBizman]);
						}
					}
					
					
					$settingProduct['Option']['value']['dateSync']= $today[0];
					$modelOption->saveOption('settingProductBizman', $settingProduct['Option']['value']);

					$mess= 'Đồng bộ sản phẩm thành công';
				}else{
					$mess= 'Bạn chưa chọn thuộc tính đồng bộ';
				}
			}

			setVariable('mess',$mess);
			setVariable('infoSync',$infoSync);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function checkDiscountBizman($input)
	{
		global $modelOption;

		$data= $modelOption->getOption('settingProductBizman');
		
		if(isset($data['Option']['value']['storeDiscount'])){
			$store= array(array('KHOID'=>$data['Option']['value']['storeDiscount']));
			$dataBizman= GetProductBySKU($store,$input['request']->data['codeDiscount']);
			$dataBizman= json_decode($dataBizman,true);

			if(isset($dataBizman[0]['productId'])){
				$dataBizman= GetProductInfoByProductId($dataBizman[0]['productId']);
				$dataBizman= json_decode($dataBizman,true);

				if(isset($dataBizman['PriceAndQuantityInfo']) && count($dataBizman['PriceAndQuantityInfo'])>0){
					foreach($dataBizman['PriceAndQuantityInfo'] as $PriceAndQuantityInfo){
						if($PriceAndQuantityInfo['KHOID']==$data['Option']['value']['storeDiscount']){
							foreach($_SESSION['orderProducts'] as $key=>$product){
								$_SESSION['orderProducts'][$key]['Product']['codeDiscountInput']= $input['request']->data['codeDiscount'];
								$_SESSION['orderProducts'][$key]['Product']['priceDiscount']= $PriceAndQuantityInfo['PRICE'];
							}
							$_SESSION['codeDiscountInput']= $input['request']->data['codeDiscount'];
							break;
						}
					}
				}else{
					// khong co kho giam gia
					foreach($_SESSION['orderProducts'] as $key=>$product){
						unset($_SESSION['orderProducts'][$key]['Product']['codeDiscountInput']);
						unset($_SESSION['codeDiscountInput']);
					}
				}
			}else{
				// khong dung ma giam gia
				foreach($_SESSION['orderProducts'] as $key=>$product){
					unset($_SESSION['orderProducts'][$key]['Product']['codeDiscountInput']);
					unset($_SESSION['codeDiscountInput']);
				}
			}
		}
	}

	function saveOrderProduct_addOrder_Bizman($input)
	{
		global $urlHomes;
		global $isRequestPost;
		global $modelOption;
		global $smtpSite;
		global $contactSite;
		global $urlLocal;
        global $settingProduct;

		$modelOrder= new Order();
		$modelProduct= new Product();

		if($isRequestPost){
			$settingProduct= $modelOption->getOption('settingProduct');
			$settingProductBizman= $modelOption->getOption('settingProductBizman');

			if(!isset($settingProduct['Option']['value']['language'])) $settingProduct['Option']['value']['language']= 'en.php';
			include($urlLocal['urlLocalPlugin'].'product/language/'.$settingProduct['Option']['value']['language']);

			$dataSend= arrayMap($input['request']->data);

			$fullname= (isset($dataSend['fullname']))?$dataSend['fullname']:'';      
			$email= (isset($dataSend['email']))?$dataSend['email']:'';      
			$phone= (isset($dataSend['phone']))?$dataSend['phone']:'';      
			$address= (isset($dataSend['address']))?$dataSend['address']:'';      
			$note= (isset($dataSend['note']))?$dataSend['note']:'';        
			$userId= (isset($dataSend['userId']))?$dataSend['userId']:'';

			$sex= (isset($dataSend['sex']))? (int)$dataSend['sex']:0;     
			$fax= (isset($dataSend['fax']))?$dataSend['fax']:'';     
			$promotionCode= '';
			$district= (isset($dataSend['district']))?$dataSend['district']:'';

			$totalMoney= 0;
			$totalMass= 0;
			$productTransportFee= $modelOption->getOption('productTransportFee');


			$orderOwnerCompany= (isset($dataSend['orderOwnerCompany']))?$dataSend['orderOwnerCompany']:'';       
			$orderOwnerName= (isset($dataSend['orderOwnerName']))?$dataSend['orderOwnerName']:'';         
			$orderOwnerPhone= (isset($dataSend['orderOwnerPhone']))?$dataSend['orderOwnerPhone']:'';        
			$orderOwnerTaxCode= (isset($dataSend['orderOwnerTaxCode']))?$dataSend['orderOwnerTaxCode']:'';        
			$orderOwnerAddress= (isset($dataSend['orderOwnerAddress']))?$dataSend['orderOwnerAddress']:'';       
			$orderOwnerSex= (isset($dataSend['orderOwnerSex']))? (int)$dataSend['orderOwnerSex']:0;      
		
			$listOrderProduct= (isset($_SESSION['orderProducts']))?$_SESSION['orderProducts']:array();
			
			if($fullname!='' && $phone!='' && count($listOrderProduct)>0)
			{
				$listProduct= array();
				$orderDetails= array();

				foreach($listOrderProduct as $data)
				{
					// tao thong tin don hang gui cho Bizman
					if(!isset($data['Product']['idBizman'])) $data['Product']['idBizman']='';
					
					$detail= array( "freeShipCode"=>"PS",
									"originalPrice"=>(int)$data['Product']['price'],
									"productId"=>$data['Product']['idBizman'],
									"promotionCode"=>$data['Product']['code'],
									"quantity"=>$data['Product']['numberOrder'],
									"storeId"=>$settingProductBizman['Option']['value']['storeDefault'],
									"unitPrice"=>(int)$data['Product']['price'],
									"unitTax"=>0
								  );
								  
					if(isset($data['Product']['codeDiscountInput']) && $data['Product']['codeDiscountInput']!='')
					{
						$listProduct[]= array('id'=>$data['Product']['id'],
											'number'=>$data['Product']['numberOrder'],
											'price'=>$data['Product']['priceDiscount'],
											'mass'=>$data['Product']['mass'],
											'codeDiscount'=>$data['Product']['codeDiscountInput']);
						
						$detail['promotionCode']= $data['Product']['codeDiscountInput'];
						$promotionCode= $data['Product']['codeDiscountInput'];
						$priceShow= $data['Product']['priceDiscount'];
					}else{
						$listProduct[]= array('id'=>$data['Product']['id'],
											'number'=>$data['Product']['numberOrder'],
											'mass'=>$data['Product']['mass'],
											'price'=>$data['Product']['price']);
						$priceShow= $data['Product']['price'];
					}
					
					array_push($orderDetails, $detail);

					$totalMoney+= $priceShow*$data['Product']['numberOrder'];
					$totalMass+= $data['Product']['mass']*$data['Product']['numberOrder'];
				}
                
                if(isset($settingProduct['Option']['value']['massMin']) && $totalMass<$settingProduct['Option']['value']['massMin']){
                    $totalMass= $settingProduct['Option']['value']['massMin'];
                }
				
				if($district>0 && isset($dataSend['district']) && isset($productTransportFee['Option']['value']['allData'][$dataSend['district']])){
					$transportFee= $totalMass*$productTransportFee['Option']['value']['allData'][$dataSend['district']]['transportFee'];
				}else{
					if(isset($settingProduct['Option']['value']['transportFeeMin'])){
				        $transportFee= $settingProduct['Option']['value']['transportFeeMin'];
                    }else{
				        $transportFee= 0;
                    }
				}

				$modelOrder->saveOrder($fullname,$email,$phone,$address,$note,$listProduct,$userId,$totalMoney,$totalMass,$transportFee,$district);
				$idOrder= $modelOrder->getLastInsertId();

				// gui du lieu xuong bizman
				$date = getdate();
				$receiveDate = '/Date('.$date[0].'000+0700)/';
				$paymentBankId = getGUID();
				$paymentTypeId = getGUID();
				
				if($userId=='') $userId="KHVL";
				
				$dataSendBizman = json_encode( array( "freeShipCode"=>"PS",
												"orderDetails"=>$orderDetails,
												// thong tin nguoi dat hang
												"orderOwnerAddress"=>$address,
												"orderOwnerCompany"=>$orderOwnerCompany,
												"orderOwnerMobile"=>$phone,
												"orderOwnerName"=>$fullname,
												"orderOwnerPhone"=>$phone,
												"orderOwnerSex"=> (int)$sex,
												"orderOwnerTaxCode"=>$orderOwnerTaxCode,
												
												// thong tin nguoi nhan hang
												"orderReceiveAddress"=>$address,
												"orderReceiveEmail"=>$email,
												"orderReceiveFax"=>$fax,
												"orderReceiveMobile"=>$phone,
												"orderReceiveName"=>$fullname,
												"orderReceiveNote"=>$note,
												"orderReceivePhone"=>$phone,
												"orderReceiveSex"=>$sex,
												
												// thong tin thanh toan va van chuyen
												"orderValue"=>$totalMoney,
												"paymentBankId"=>$paymentBankId,
												"paymentTypeId"=>$paymentTypeId,
												"promotionCode"=>$promotionCode,
												"receiveDate"=>$receiveDate,
												"shipingTypeId"=>0,
												"shipingTypeName"=>"",
												"shipingValue"=>$transportFee
											  )
									   );
				//var_dump($dataSend);
				$returnBizman= AddOrder($dataSendBizman);
		    	$returnBizman= json_decode($returnBizman,true) ;
                //debug($dataSendBizman);
                //debug($returnBizman);die;
                
                // send email for user and admin
				$from= array($contactSite['Option']['value']['email'] =>  $smtpSite['Option']['value']['show']);
				$to= array();
				if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$to[]= $email;
				}
				
				if (filter_var($contactSite['Option']['value']['email'], FILTER_VALIDATE_EMAIL)) {
					$to[]= $contactSite['Option']['value']['email'];
				}
				
				$cc= array();
				$bcc= array();
				$subject= '['.$smtpSite['Option']['value']['show'].'] '.$languageProduct['OrderSuccess'];
				
				$listTypeMoney= $modelOption->getOption('productTypeMoney');
				$content= getContentEmailOrderSuccessTheme($fullname,$email,$phone,$address,$note,$listTypeMoney,$transportFee,$returnBizman['OrderID']);

				$modelOrder->sendMail($from,$to,$cc,$bcc,$subject,$content);
                
				unset($_SESSION['orderProducts']); 
				unset($_SESSION['codeDiscountInput']); 

				if(isset($dataSend['redirect']) && $dataSend['redirect']!='')
				{
					$modelOrder->redirect($dataSend['redirect'].'?status=1');
				}
				else
				{
					$modelOrder->redirect(getLinkCart().'?status=1');
				}
			}
			else
			{
				if(!isset($dataSend['redirect']) || $dataSend['redirect']=='')
				{
					$modelOrder->redirect(getLinkCart().'?status=-1');
				}
				else
				{
					$modelOrder->redirect($dataSend['redirect'].'?status=-1');
				}
			}
		}
	}

?>