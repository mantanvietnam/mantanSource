<?php
	function listProduct($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;

		$modelProduct= new Product();

		if(checkAdminLogin()){
			$listProductCategory= $modelOption->getOption('productCategory');
			$listManufacturer= $modelOption->getOption('productManufacturer');

			$page= (isset($_GET['page']))? (int) $_GET['page']:1;
        	if($page<=0) $page=1;
        	$limit= 15;
        	$conditions= array();
        	
        	if(isset($_GET['priceFrom']) && $_GET['priceFrom']!=''){
				$priceFrom= (int) $_GET['priceFrom'];
			}else{
				$priceFrom= '';
			}

			if(isset($_GET['priceTo']) && $_GET['priceTo']!=''){
				$priceTo= (int) $_GET['priceTo'];
			}else{
				$priceTo= '';
			}

        	if(isset($_GET['code']) && $_GET['code']!='')
        	{
	        	$conditions['code']= array('$regex' => $_GET['code']);
        	}
        	
        	if(isset($_GET['manufacturer']) && $_GET['manufacturer']!='')
        	{
	        	$conditions['manufacturerId']= (int) $_GET['manufacturer'];
        	}
        	
        	if(isset($_GET['category']) && $_GET['category']>0)
        	{
        		$idCat= (int) $_GET['category'];
        		
				$categorySearch= $modelProduct->getcat($listProductCategory['Option']['value']['category'],$idCat);
				
        		$listId= array($idCat);
				$listId= getSubIdCategory($categorySearch,$listId);
				
				$conditions= array('category'=>array('$in'=>$listId));
        	}
        	
        	if(is_numeric($priceFrom) && $priceFrom>=0)
        	{
	        	$conditions['price']['$gte']= $priceFrom;
        	}

        	if(is_numeric($priceTo) && $priceTo>=0 && $priceTo>=$priceFrom)
        	{
	        	$conditions['price']['$lte']= $priceTo;
        	}
        	
        	if(isset($_GET['bestsellers']) && $_GET['bestsellers']!='')
        	{
        		if($_GET['bestsellers']=='yes')
        		{
	        		$conditions['hot']= 1;
        		}
	        	else
	        	{
		        	$conditions['hot']= 0;
	        	} 
        	}
        	
        	if(isset($_GET['title']) && $_GET['title']!='')
        	{
				$key= createSlugMantan($_GET['title']);
				$conditions['slug']= array('$regex' => $key);
        	}
        	

	        $listData= $modelProduct->getPage($page,$limit,$conditions);
            $listTypeMoney= $modelOption->getOption('productTypeMoney');

            if(!empty($_POST['saveProducts']) && !empty($listData)){
            	foreach($listData as $key=>$data){
            		$modelProduct->create();
            		$update['$set']['priority']= (int) $_POST['priority_'.$data['Product']['id']];
            		$update['$set']['price']= (int) $_POST['price_'.$data['Product']['id']];
            		$update['$set']['lock']= (int) $_POST['lock_'.$data['Product']['id']];
            		$id= new MongoId($data['Product']['id']);
            		$dk= array('_id'=>$id);
            		$modelProduct->updateAll($update,$dk);
            		$listData[$key]['Product']['priority']= $_POST['priority_'.$data['Product']['id']];
            		$listData[$key]['Product']['price']= $_POST['price_'.$data['Product']['id']];
            		$listData[$key]['Product']['lock']= $_POST['lock_'.$data['Product']['id']];
            	}
            }
            
            $listCatNew= array();
            if(isset($listProductCategory["Option"]['value']['category']) && count($listProductCategory["Option"]['value']['category'])>0){
            	$listCatNew= convertCategoryMantan($listProductCategory["Option"]['value']['category'],$listCatNew);
        	}

        	$listManufacturerNew= array();
            if(isset($listManufacturer["Option"]['value']['category']) && count($listManufacturer["Option"]['value']['category'])>0){
            	$listManufacturerNew= convertCategoryMantan($listManufacturer["Option"]['value']['category'],$listManufacturerNew);
        	}

            $totalData= $modelProduct->find('count',array('conditions' => $conditions));
		
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

			setVariable('listProductCategory',$listProductCategory);
			setVariable('listManufacturer',$listManufacturer);
			setVariable('listTypeMoney',$listTypeMoney);
			setVariable('listCatNew',$listCatNew);
			setVariable('listData',$listData);
			setVariable('listManufacturerNew',$listManufacturerNew);
			

			setVariable('priceTo',$priceTo);
			setVariable('priceFrom',$priceFrom);

			setVariable('page',$page);
			setVariable('totalPage',$totalPage);
			setVariable('back',$back);
			setVariable('next',$next);
			setVariable('urlPage',$urlPage);

		}else{
			$modelProduct->redirect($urlHomes);
		}
	}

	function addProduct($input)
	{
		global $modelOption;
		global $urlHomes;

		$modelProduct= new Product();

		if(checkAdminLogin()){
			if(isset($input['request']->params['pass'][1])){
				$idEdit= new MongoId($input['request']->params['pass'][1]);
				$news= $modelProduct->getProduct($idEdit);
			}else{
				$news= null;
			}
			
			$listManufacturer= $modelOption->getOption('productManufacturer');
			$listTypeMoney= $modelOption->getOption('productTypeMoney');
			$listCategory= $modelOption->getOption('productCategory');
			$listProperties= $modelOption->getOption('propertiesProduct');
			
			setVariable('news',$news);
			setVariable('listManufacturer',$listManufacturer);
			setVariable('listTypeMoney',$listTypeMoney);
			setVariable('listCategory',$listCategory);
			setVariable('listProperties',$listProperties);
		}else{
			$modelProduct->redirect($urlHomes);
		}
	}

	function deleteProduct($input)
	{
		global $urlHomes;
		global $urlPlugins;
	
		$modelProduct= new Product();
		if(checkAdminLogin()){
			if(isset($input['request']->params['pass'][1])){
				$idDelete= new MongoId($input['request']->params['pass'][1]);
				$modelProduct->delete($idDelete);
			}
			$modelProduct->redirect($urlPlugins.'admin/product-product-listProduct.php');
		}else{
			$modelProduct->redirect($urlHomes);
		}

	}
	
	function saveProduct($input)
	{
		$dataSend= $input['request']->data;
		global $modelOption;
		global $urlPlugins;
		global $isRequestPost;
		global $urlHomes;
	
		$modelProduct= new Product();
		if(checkAdminLogin() && $isRequestPost){
			if($dataSend['title']!='')
			{
				$title= $dataSend['title'];
				$description= $dataSend['description'];
				$keySearch= $dataSend['key'];
				$slugKeys= createSlugMantan($keySearch);
				$slug= createSlugMantan($dataSend['title']);
				$info= $dataSend['info'];
				$code= $dataSend['code'];
				$manufacturerId= (isset($dataSend['manufacturerId']))? (int)$dataSend['manufacturerId']:'';
				$price= (int)$dataSend['price'];
				$priceOther= (int)$dataSend['priceOther'];
				$typeMoneyId= (isset($dataSend['typeMoneyId']))? (int)$dataSend['typeMoneyId']:'';
				$quantity= (int)$dataSend['quantity'];
				$warranty= $dataSend['warranty'];
				$lock= (int)$dataSend['lock'];
				$id= $dataSend['id'];
				$hot= (isset($dataSend['hot']))? (int)$dataSend['hot']:0;
				$mass= (isset($dataSend['mass']))? (double)$dataSend['mass']:0;
				$alias= $dataSend['alias'];
				$nameSeo= $dataSend['nameSeo'];
				$otherProductTitle= $dataSend['otherProductTitle'];
				$otherProductID= $dataSend['otherProductID'];

				$dateDiscountStart= null;
				$dateDiscountEnd= null;
				$priceDiscount= null;
				$codeDiscount= null;
				$numberDiscount= null;
				
				$today= getdate();
				if(isset($dataSend['ngay']) && isset($dataSend['thang']) && isset($dataSend['nam']))
				{
					$timeUp= mktime($today['hours'], $today['minutes'], $today['seconds'], $dataSend['thang'], $dataSend['ngay'], $dataSend['nam']);
				}else{
					$timeUp= $today[0];
				}
				
				if($dataSend['dateStart'] && $dataSend['monthStart'] && $dataSend['yearStart'])
				{
					$dateDiscountStart= mktime(0, 0, 0, $dataSend['monthStart'], $dataSend['dateStart'], $dataSend['yearStart']);
				}
				
				if($dataSend['dateEnd'] && $dataSend['monthEnd'] && $dataSend['yearEnd'])
				{
					$dateDiscountEnd= mktime(23, 59, 59, $dataSend['monthEnd'], $dataSend['dateEnd'], $dataSend['yearEnd']);
				}
				
				if($dateDiscountStart && $dateDiscountEnd)
				{
					$priceDiscount= (int) $dataSend['priceDiscount'];
					$numberDiscount= (int) $dataSend['numberDiscount'];
					$codeDiscount= explode(',', strtoupper($dataSend['codeDiscount']));
				}
				
				$category= array();

				if(isset($dataSend['check_list']) && count($dataSend['check_list'])>0){
					foreach ($dataSend['check_list'] as $key => $value) {
						$category[]= (int) $value;
					}
				}
			    
			    $number= -1;
			    $images= array();
			    for($i=0;$i<=11;$i++)
			    {
					if($dataSend['image'.$i]!='')
					{
						$number++;
						$images[$number]= $dataSend['image'.$i];
					}    
			    }
			  
			    // Doc cac thuoc tinh bo sung
			    $listProperties= $modelOption->getOption('propertiesProduct');
			    $properties= array();
			    if(isset($listProperties['Option']['value']['allData']) && count($listProperties['Option']['value']['allData'])>0){
					foreach($listProperties['Option']['value']['allData'] as $components)
					{
						switch($components['typeShow'])
						{
							case 1: $nameInput='value'.$components['id'];
									if(isset($_POST[$nameInput]) && $_POST[$nameInput]!='') $properties[$components['id']]= array((int) $_POST[$nameInput]);
									break;
							case 2: $nameInput='value'.$components['id'];
									if(isset($_POST[$nameInput]) && count($_POST[$nameInput])>0) $properties[$components['id']]= $_POST[$nameInput];
									break;
							case 3: $nameInput='value'.$components['id'];
									if(isset($_POST[$nameInput]) && $_POST[$nameInput]!='') $properties[$components['id']]= $_POST[$nameInput];
									break;	
						}
					}
				}

				$listSlug= array();
		        $number= 0;
		        $slugStart= $slug;
		        do
		        {
		       	 	 $number++;
			       	 $listSlug= $modelProduct->find('all', array('conditions' => array('slug'=>$slug) ));
					 if(count($listSlug)>0 && $listSlug[0]['Product']['id']!=$id)
					 {
					 	$slug= $slugStart.'-'.$number;
			       	 }
		        } while (count($listSlug)>0 && $listSlug[0]['Product']['id']!=$id);

				$saveProduct['Product']= array( 'title'=>$title,
												'description'=>$description,
												'key'=>$keySearch,
												'slug'=>$slug,
												'info'=>$info,
												'code'=>$code,
												'manufacturerId'=>$manufacturerId,
												'price'=>$price,
												'priceOther'=>$priceOther,
												'typeMoneyId'=>$typeMoneyId,
												'quantity'=>$quantity,
												'warranty'=>$warranty,
												'lock'=>$lock,
												'category'=>$category,
												'images'=>$images,
												'hot'=>$hot,
												'dateDiscountStart'=>$dateDiscountStart,
												'dateDiscountEnd'=>$dateDiscountEnd,
												'priceDiscount'=>$priceDiscount,
												'codeDiscount'=>$codeDiscount,
												'alias'=>$alias,
												'nameSeo'=>$nameSeo,
												'slugKeys'=>$slugKeys,
												'properties'=>$properties,
												'otherProductTitle'=>$otherProductTitle,
												'otherProductID'=>$otherProductID,
												'timeUp'=>$timeUp,
												'mass'=>$mass,
												'numberDiscount'=>$numberDiscount,
												'numberDiscountActive'=> (int) @$dataSend['numberDiscountActive'],
											);


			    $modelProduct->saveProduct($saveProduct,$id);
			}
			$modelProduct->redirect($urlPlugins.'admin/product-product-listProduct.php');
		}else{
			$modelProduct->redirect($urlHomes);
		}

	}

	function addProductExcel($input)
	{
		$dataSend= $input['request']->data;
		global $modelOption;
		global $urlPlugins;
		global $isRequestPost;
		global $urlHomes;
	
		$modelProduct= new Product();

		if(checkAdminLogin()){
			if($isRequestPost && !empty($dataSend['dataExcel']))
			{
				$dataSend['dataExcel']= nl2br($dataSend['dataExcel']);
                $dataSend['dataExcel']= explode('<br />', $dataSend['dataExcel']);
                if(!empty($dataSend['dataExcel'])){
                    foreach($dataSend['dataExcel'] as $listData){
                        //$data= explode('\t', $listData);
                        $data= preg_split('/[\t]/', trim($listData));
                        if(!empty($data[0])){
                        	$listSlug= array();
					        $number= 0;
					        $slug= createSlugMantan($data[0]);
					        $slugStart= $slug;
					        do
					        {
					       	 	 $number++;
						       	 $listSlug= $modelProduct->find('all', array('conditions' => array('slug'=>$slug) ));
								 if(count($listSlug)>0)
								 {
								 	$slug= $slugStart.'-'.$number;
						       	 }
					        } while (count($listSlug)>0);

					        $images= array();
					        if(!empty($data[9])) $images[]= $data[9];
					        if(!empty($data[10])) $images[]= $data[10];
					        if(!empty($data[11])) $images[]= $data[11];
					        if(!empty($data[12])) $images[]= $data[12];

					        $category= array();
							if(isset($data[3])){
								$data[3]= explode(',', $data[3]);
								if(count($data[3])>0){
									foreach ($data[3] as $key => $value) {
										$category[]= (int) $value;
									}
								}
							}

                            $modelProduct->create();
                            $save= array();
                            $save['Product']= array( 'title'=>$data[0],
												'description'=>$data[2],
												'key'=> '',
												'slug'=> $slug,
												'info'=>'',
												'code'=>$data[1],
												'manufacturerId'=>'',
												'price'=> (int) $data[4],
												'priceOther'=>(int) $data[5],
												'typeMoneyId'=>'',
												'quantity'=>(int) $data[6],
												'warranty'=>$data[7],
												'lock'=>0,
												'category'=> $category,
												'images'=> $images,
												'hot'=>0,
												'dateDiscountStart'=>'',
												'dateDiscountEnd'=>'',
												'priceDiscount'=>'',
												'codeDiscount'=> array(),
												'alias'=>'',
												'nameSeo'=>'',
												'slugKeys'=>'',
												'properties'=> array(),
												'otherProductTitle'=>'',
												'otherProductID'=>'',
												'timeUp'=> time(),
												'mass'=>$data[8],
												'numberDiscount'=>0,
												'numberDiscountActive'=> 0,
											);

                            $modelProduct->save($save);
                        }
                    }
                }

                $modelProduct->redirect($urlPlugins.'admin/product-product-listProduct.php');
			}
		}else{
			$modelProduct->redirect($urlHomes);
		}

	}

	function copyProduct($input)
	{
		$dataSend= $input['request']->data;
		global $modelOption;
		global $urlPlugins;
		global $isRequestPost;
		global $urlHomes;
	
		$modelProduct= new Product();

		if(checkAdminLogin()){
			if(!empty($_GET['id'])){
				$product= $modelProduct->getProduct($_GET['id']);

				if($product){
					unset($product['Product']['id']);
					$product['Product']['title']= 'copy - '.$product['Product']['title'];
					$product['Product']['slug']= $product['Product']['slug'].rand(1,1000);
					$modelProduct->save($product);
				}
			}

			$modelProduct->redirect($urlPlugins.'admin/product-product-listProduct.php');
		}else{
			$modelProduct->redirect($urlHomes);
		}

	}

	function listCategory($input)
	{
		global $modelOption;
		global $urlHomes;
	
		if(checkAdminLogin()){
			$listData= $modelOption->getOption('productCategory');

			setVariable('listData',$listData);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function addCategory($input){
		global $modelOption;
		global $urlHomes;
		global $isRequestPost;
		global $urlPlugins;
		global $isRequestPost;
		if(checkAdminLogin()){
		$listData= $modelOption->getOption('productCategory');
		if(!empty($_GET['idCatEdit'])){
			$idEdit = $_GET['idCatEdit'];
			$dataEdit = $modelOption->getcat($listData['Option']['value']['category'],$idEdit);
			setVariable('dataEdit',$dataEdit);
		}		
		$dataSend= $input['request']->data;
		if(!empty($dataSend['name'])){
			$name= (isset($dataSend['name']))?$dataSend['name']:'';
			$idCatEdit= (isset($dataSend['idCatEdit']))?$dataSend['idCatEdit']:'' ;
			$parent= (isset($dataSend['parent']))?(int) $dataSend['parent']:'';
			$slug= (isset($dataSend['slug']))?$dataSend['slug']:'';
			$show= (isset($dataSend['show']))?$dataSend['show']:'';
			$image= (isset($dataSend['image']))?$dataSend['image']:'';
			$description= (isset($dataSend['description']))?$dataSend['description']:'';
			$nameSeo= (isset($dataSend['nameSeo']))?$dataSend['nameSeo']:'';
			$key= (isset($dataSend['key']))?$dataSend['key']:'';
			$infoCategory= (isset($dataSend['infoCategory']))?$dataSend['infoCategory']:'';

	        $groups= $modelOption->getOption('productCategory');
	   		if(!empty($groups['Option']['value']['category'])){
	   			$number= getNumberSlugCategory($groups['Option']['value']['category'],$slug,0);
	   		}else{
	   			$number= 0;
	   		}

	   		$slugStart= $slug;
	   		if($number>0)
	   		{
		   		$slug= $slug.'-'.$number;
	   		}
	   		
			if(empty($dataSend['idCatEdit']))
			{
				
				if(isset($groups['Option']['value']['tCategory'])){
					$groups['Option']['value']['tCategory']+= 1;
				}else{
					$groups['Option']['value']['tCategory']= 1;
				}
				$save= array(
					'name'=>$name,
					'id'=>$groups['Option']['value']['tCategory'],
					'slug'=>$slug,
					'show'=>$show,
					'image'=>$image,
					'description'=>$description,
					'nameSeo'=>$nameSeo,
					'key'=>$key,			
					'infoCategory'=>$infoCategory,
					'parent'	=>$parent			
							); 	 
				if($parent==0)
				{
					$groups['Option']['value']['category'][ $groups['Option']['value']['tCategory'] ]= $save;
				}  	
				else
				{
					$groups['Option']['value']['category']= addCat($groups['Option']['value']['category'],$parent,$save);	
				}	
				
				$idCatEdit= $groups['Option']['value']['tCategory'];
				}
				else
				{
					$idCatEdit= (int) $idCatEdit;
					
					$cats= getcat($groups['Option']['value']['category'],$idCatEdit);
					if($cats)
					{
						if($cats['slug']!=$slugStart)
						{
							$cats['slug']= $slug;
						}
						$cats['name']= $name;
						$cats['show']= $show;
						$cats['image']= $image;
						$cats['description']= $description;
						$cats['nameSeo']= $nameSeo;
						$cats['key']= $key;
						$cats['infoCategory'] =$infoCategory;
						$cats['parent'] =$parent;
						$groups['Option']['value']['category']= deleteCat($groups['Option']['value']['category'],$idCatEdit,$parent,0);
						$groups['Option']['value']['category']= addCat($groups['Option']['value']['category'],$parent,$cats);
						
					}
				}
				$modelOption->saveOption('productCategory', $groups['Option']['value']);
				$modelOption->redirect($urlPlugins.'admin/product-category-listCategory.php');

		}
			setVariable('listData',$listData);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function saveCategory($input)
	{
		global $modelOption;
		global $urlHomes;
		global $isRequestPost;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin()){
			$dataSend= $input['request']->data;
		
			$name= (isset($dataSend['name']))?$dataSend['name']:'';
			$type= (isset($dataSend['type']))?$dataSend['type']:'';
			
			 if($type=='delete')
			{
				$idCat= (int) $dataSend['idDelete'];
				
				$groups= $modelOption->getOption('productCategory');
		   		
				$cats= getcat($groups['Option']['value']['category'],$idCat);
				if($cats)
				{
					$groups['Option']['value']['category']= deleteCat($groups['Option']['value']['category'],$idCat,-1,0);
					$modelOption->saveOption('productCategory', $groups['Option']['value']);
				}
			}
			else if($type=='change')
			{
				$type= $dataSend['typeChange'];
			    $idMenu= (int) $dataSend['idMenu'];
			    
			    $groups= $modelOption->getOption('productCategory');
			    $groups['Option']['value']['category']= sapXepCat($type,$idMenu,$groups['Option']['value']['category']);
		        $modelOption->saveOption('productCategory', $groups['Option']['value']);
			}
			
			$modelOption->redirect($urlPlugins.'admin/product-category-listCategory.php');

		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function settingFindCategory($input)
	{
		global $modelOption;
		global $urlHomes;

		if(checkAdminLogin()){
			$modelProduct= new Product();
			$listCategory= $modelOption->getOption('productCategory');
			$category= $modelProduct->getcat($listCategory['Option']['value']['category'],$_POST['idCategory']);
			
			$listData= $modelOption->getOption('propertiesProduct');

			setVariable('listData',$listData);
			setVariable('listCategory',$listCategory);
			setVariable('category',$category);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function listUser($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;

		if(checkAdminLogin()){
			$modelUser= new User();
        	$page= (isset($_GET['page']))? (int) $_GET['page']:1;
        	if($page<=0) $page=1;
        	$limit= 15;
        	$conditions= array();
        	
	        $listData= $modelUser->getPage($page,$limit);

	        $totalData= $modelUser->find('count',array('conditions' => $conditions));
		
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
			$modelOption->redirect($urlHomes);
		}
	}

	function addUser($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;

		if(checkAdminLogin()){
			$modelUser= new User();
			$data= $modelUser->getUser($_GET['id']);

			if(!$data){
				$modelOption->redirect($urlPlugins.'admin/product-user-listUser.php');
			}
			setVariable('data',$data);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function saveUserAdmin($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin() && $isRequestPost){
			$modelUser= new User();
			$dataSend= arrayMap($input['request']->data);
	
			$save['User']['fullname']= $dataSend['fullname'];
			$save['User']['email']= $dataSend['email'];
			$save['User']['phone']= $dataSend['phone'];
			$save['User']['address']= $dataSend['address'];
            $save['User']['birthday']= $dataSend['birthday'];
			if($dataSend['password']!='')
			{
				$save['User']['password']= md5($dataSend['password']);
			}
			$dk['_id']= new MongoId($dataSend['idUser']);
			$modelUser->updateAll($save['User'],$dk);
			
			$modelUser->redirect($urlPlugins.'admin/product-user-addUser.php?status=1&id='.$dataSend['idUser']);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function deleteUser($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;

		if(checkAdminLogin()){
			$modelUser= new User();
			if(isset($_GET['id']))
			{
				$idDelete= new MongoId($_GET['id']);
				$modelUser->delete($idDelete);
			}
			$modelUser->redirect($urlPlugins.'admin/product-user-listUser.php');
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function listManufacturer($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlPlugins;

		if(checkAdminLogin()){
			$listData= $modelOption->getOption('productManufacturer');
			setVariable('listData',$listData);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function saveManufacturer($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin() && $isRequestPost){
			$dataSend= $input['request']->data;
	
			$name= $dataSend['name'];
			$type= $dataSend['type'];
			
			if($name != '' && $type=='save')
			{
				$idCatEdit= $dataSend['idCatEdit'];
				$parent= (int) $dataSend['parent'];
				$slug= $dataSend['slug'];
				$show= $dataSend['show'];
				$image= $dataSend['image'];
				$description= $dataSend['description'];
				$key= $dataSend['key'];
				
				$address= $dataSend['address'];
				$email= $dataSend['email'];
				$phone= $dataSend['phone'];
				$fax= $dataSend['fax'];
				$ownerName= $dataSend['ownerName'];
				$taxCode= $dataSend['taxCode'];
				
		        $groups= $modelOption->getOption('productManufacturer');
		   		
		   		if(isset($groups['Option']['value']['category']) && count($groups['Option']['value']['category'])>0){
		   			$number= getNumberSlugCategory($groups['Option']['value']['category'],$slug,0);
		   		}else{
		   			$number= 0;
		   		}

		   		$slugStart= $slug;
		   		if($number>0)
		   		{
			   		$slug= $slug.'-'.$number;
		   		}
		   		
				if($idCatEdit=='')
				{
					if(isset($groups['Option']['value']['tCategory'])){
						$groups['Option']['value']['tCategory']+= 1;
					}else{
						$groups['Option']['value']['tCategory']= 1;
					}

					$save= array(
									'name'=>$name,
									'id'=>$groups['Option']['value']['tCategory'],
									'slug'=>$slug,
									'show'=>$show,
									'image'=>$image,
									'description'=>$description,
									'key'=>$key,
									'address'=>$address,
									'email'=>$email,
									'phone'=>$phone,
									'fax'=>$fax,
									'ownerName'=>$ownerName,
									'taxCode'=>$taxCode						
								); 	 
					if($parent==0)
					{
						$groups['Option']['value']['category'][ $groups['Option']['value']['tCategory'] ]= $save;
					}  	
					else
					{
						$groups['Option']['value']['category']= addCat($groups['Option']['value']['category'],$parent,$save);	
					}	
					
					$idCatEdit= $groups['Option']['value']['tCategory'];
				}
				else
				{
					$idCatEdit= (int) $idCatEdit;
					
					$cats= getcat($groups['Option']['value']['category'],$idCatEdit);
					if($cats)
					{
						if($cats['slug']!=$slugStart)
						{
							$cats['slug']= $slug;
						}
						$cats['name']= $name;
						$cats['show']= $show;
						$cats['image']= $image;
						$cats['description']= $description;
						$cats['key']= $key;
						$cats['address']= $address;
						$cats['email']= $email;
						$cats['phone']= $phone;
						$cats['fax']= $fax;
						$cats['ownerName']= $ownerName;
						$cats['taxCode']= $taxCode;
						
						$groups['Option']['value']['category']= deleteCat($groups['Option']['value']['category'],$idCatEdit,$parent,0);
						$groups['Option']['value']['category']= addCat($groups['Option']['value']['category'],$parent,$cats);
						
					}
				}
				$modelOption->saveOption('productManufacturer', $groups['Option']['value']);
				
			}
			else if($type=='delete')
			{
				$idCat= (int) $dataSend['idDelete'];
				
				$groups= $modelOption->getOption('productManufacturer');
		   		
				$cats= getcat($groups['Option']['value']['category'],$idCat);
				if($cats)
				{
					$groups['Option']['value']['category']= deleteCat($groups['Option']['value']['category'],$idCat,-1,0);
					$modelOption->saveOption('productManufacturer', $groups['Option']['value']);
				}
			}
			else if($type=='change')
			{
				$type= $dataSend['typeChange'];
			    $idMenu= (int) $dataSend['idMenu'];
			    
			    $groups= $modelOption->getOption('productManufacturer');
			    $groups['Option']['value']['category']= sapXepCat($type,$idMenu,$groups['Option']['value']['category']);
		        $modelOption->saveOption('productManufacturer', $groups['Option']['value']);
			}
			
			$modelOption->redirect($urlPlugins.'admin/product-manufacturer-listManufacturer.php');
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function listProperties($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlPlugins;

		if(checkAdminLogin()){
			$listData= $modelOption->getOption('propertiesProduct');
			setVariable('listData',$listData);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function saveProperties($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin() && $isRequestPost){
			$name= (isset($_POST['name']))?$_POST['name']:'';
			$code= (isset($_POST['code']))?$_POST['code']:'';
			$typeShow= (isset($_POST['typeShow']))?$_POST['typeShow']:'';
			$type= (isset($_POST['type']))?$_POST['type']:'';
			
			if($name!='' && $type=='save')
			{
				$listData= $modelOption->getOption('propertiesProduct');
				if($_POST['id']=='')
				{
					if(isset($listData['Option']['value']['tData'])){
						$listData['Option']['value']['tData'] += 1;
					}else{
						$listData['Option']['value']['tData'] = 1;
					}

					$listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]= array( 'id'=> $listData['Option']['value']['tData'], 'name'=>$name,'code'=>$code,'typeShow'=>$typeShow );
				}
				else
				{
					$idClassEdit= (int) $_POST['id'];
					$listData['Option']['value']['allData'][$idClassEdit]['name']= $name;
					$listData['Option']['value']['allData'][$idClassEdit]['code']= $code;
					$listData['Option']['value']['allData'][$idClassEdit]['typeShow']= $typeShow;
				}
				
				$modelOption->saveOption('propertiesProduct',$listData['Option']['value']);
			}
			else if($name!='' && $type=='saveValue')
			{
				$listData= $modelOption->getOption('propertiesProduct');
				if($listData['Option']['value']['allData'][$_POST['idProperties']])
				{
					if($_POST['id']=='')
					{
						if(isset($listData['Option']['value']['allData'][$_POST['idProperties']]['tData'])){
							$listData['Option']['value']['allData'][$_POST['idProperties']]['tData'] += 1;
						}else{
							$listData['Option']['value']['allData'][$_POST['idProperties']]['tData'] = 1;
						}

						$listData['Option']['value']['allData'][$_POST['idProperties']]['allData'][ $listData['Option']['value']['allData'][$_POST['idProperties']]['tData'] ]= array( 'id'=> $listData['Option']['value']['allData'][$_POST['idProperties']]['tData'], 'name'=>$name);
					}
					else
					{
						$idClassEdit= (int) $_POST['id'];
						$listData['Option']['value']['allData'][$_POST['idProperties']]['allData'][$idClassEdit]['name']= $name;
					}
				}
				$modelOption->saveOption('propertiesProduct',$listData['Option']['value']);
				
				$modelOption->redirect($urlPlugins.'admin/product-properties-valueProperties.php/'.$_POST['idProperties']);
			}
			else if($type=='delete')
			{
				$idDelete= (int) $_POST['id'];
				$listData= $modelOption->getOption('propertiesProduct');
				unset($listData['Option']['value']['allData'][$idDelete]);
				$modelOption->saveOption('propertiesProduct',$listData['Option']['value']);
			}
			else if($type=='deleteValue')
			{
				$idDelete= (int) $_POST['id'];
				$listData= $modelOption->getOption('propertiesProduct');
				unset($listData['Option']['value']['allData'][$_POST['idProperties']]['allData'][$idDelete]);
				$modelOption->saveOption('propertiesProduct',$listData['Option']['value']);
			}
			
			if($_POST['redirect']>0)
			{
				$modelOption->redirect($urlPlugins.'admin/product-properties-listProperties.php');
			}
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function valueProperties($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin()){
			$listData= $modelOption->getOption('propertiesProduct');

			if(isset($input['request']->params['pass'][1]) && isset($listData['Option']['value']['allData'][$input['request']->params['pass'][1]])){
				setVariable('listData',$listData);
				setVariable('idProperties',$input['request']->params['pass'][1]);
			}else{
				$modelOption->redirect($urlPlugins.'admin/product-properties-listProperties.php');
			}
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function settingSeo($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin()){
			$listData= $modelOption->getOption('seoProduct');
			setVariable('listData',$listData);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function saveSettingSeo($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin() && $isRequestPost){
			$dataSend= $input['request']->data;
			$listData= $modelOption->getOption('seoProduct');
			
			$listData['Option']['value']['category']['title']= $dataSend['categoryTitle'];
			$listData['Option']['value']['category']['keyword']= $dataSend['categoryKeyword'];
			$listData['Option']['value']['category']['description']= $dataSend['categoryDescription'];
			
			$listData['Option']['value']['detail']['title']= $dataSend['detailTitle'];
			$listData['Option']['value']['detail']['keyword']= $dataSend['detailKeyword'];
			$listData['Option']['value']['detail']['description']= $dataSend['detailDescription'];
			
			$listData['Option']['value']['search']['title']= $dataSend['searchTitle'];
			$listData['Option']['value']['search']['keyword']= $dataSend['searchKeyword'];
			$listData['Option']['value']['search']['description']= $dataSend['searchDescription'];
			
			$listData['Option']['value']['manufacturer']['title']= $dataSend['manufacturerTitle'];
			$listData['Option']['value']['manufacturer']['keyword']= $dataSend['manufacturerKeyword'];
			$listData['Option']['value']['manufacturer']['description']= $dataSend['manufacturerDescription'];

			$listData['Option']['value']['seoPath']['product']= trim($dataSend['seoPathProduct']);
			$listData['Option']['value']['seoPath']['cat']= trim($dataSend['seoPathCat']);
			$listData['Option']['value']['seoPath']['manufacturer']= trim($dataSend['seoPathManufacturer']);
			$listData['Option']['value']['seoPath']['cart']= trim($dataSend['seoPathCart']);
			$listData['Option']['value']['seoPath']['login']= trim($dataSend['seoPathLogin']);
			$listData['Option']['value']['seoPath']['logout']= trim($dataSend['seoPathLogout']);
			$listData['Option']['value']['seoPath']['register']= trim($dataSend['seoPathRegister']);
			$listData['Option']['value']['seoPath']['search']= trim($dataSend['seoPathSearch']);
			$listData['Option']['value']['seoPath']['discount']= trim($dataSend['seoPathDiscount']);
			$listData['Option']['value']['seoPath']['allProduct']= trim($dataSend['seoPathAllProduct']);
            $listData['Option']['value']['seoPath']['userInfo']= trim($dataSend['seoPathUserInfo']);
            $listData['Option']['value']['seoPath']['history']= trim($dataSend['seoPathHistory']);
			
			$modelOption->saveOption('seoProduct',$listData['Option']['value']);
			//var_dump($listData['Option']['value']);
			$modelOption->redirect($urlPlugins.'admin/product-seo-settingSeo.php');
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function settingSitemap($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin()){
			$listData= $modelOption->getOption('sitemapProduct');
			setVariable('listData',$listData);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function listTypeMoney($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin()){
			$listData= $modelOption->getOption('productTypeMoney');
			setVariable('listData',$listData);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function saveTypeMoney($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin() && $isRequestPost){
			$dataSend= $input['request']->data;
	
			$name= (isset($dataSend['name']))? $dataSend['name']:'';
			$type= (isset($dataSend['type']))? $dataSend['type']:'';
			
			if($name!='' && $type=='save')
			{
				$listData= $modelOption->getOption('productTypeMoney');
				
				if($dataSend['id']=='')
				{
					$listData['Option']['value']['tData']= (isset($listData['Option']['value']['tData']))?$listData['Option']['value']['tData']+1:1;
					$listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]= array( 'id'=> $listData['Option']['value']['tData'], 'name'=>$name );
				}
				else
				{
					$idClassEdit= (int) $dataSend['id'];
					$listData['Option']['value']['allData'][$idClassEdit]['name']= $name;
				}
				
				$modelOption->saveOption('productTypeMoney',$listData['Option']['value']);
				
			}
			else if($type=='delete')
			{
				$idDelete= (int) $dataSend['id'];
				$listData= $modelOption->getOption('productTypeMoney');
				unset($listData['Option']['value']['allData'][$idDelete]);
				$modelOption->saveOption('productTypeMoney',$listData['Option']['value']);
			}
			
			if($dataSend['redirect']>0)
			{
				$modelOption->redirect($urlPlugins.'admin/product-typeMoney-listTypeMoney.php');
			}
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function listTransportFee($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin()){
			$listData= $modelOption->getOption('productTransportFee');
			setVariable('listData',$listData);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function saveTransportFee($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin() && $isRequestPost){
			$dataSend= $input['request']->data;
	
			$address= (isset($dataSend['address']))? $dataSend['address']:'';
			$transportFee= (isset($dataSend['transportFee']))? (int)$dataSend['transportFee']:0;
			$type= (isset($dataSend['type']))? $dataSend['type']:'';
			
			if($address!='' && $type=='save')
			{
				$listData= $modelOption->getOption('productTransportFee');
				
				if($dataSend['id']=='')
				{
					$listData['Option']['value']['tData']= (isset($listData['Option']['value']['tData']))?$listData['Option']['value']['tData']+1:1;
					$listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]= array( 'id'=> $listData['Option']['value']['tData'], 'address'=>$address, 'transportFee'=>$transportFee );
				}
				else
				{
					$idClassEdit= (int) $dataSend['id'];
					$listData['Option']['value']['allData'][$idClassEdit]['address']= $address;
					$listData['Option']['value']['allData'][$idClassEdit]['transportFee']= $transportFee;
				}
				
				$modelOption->saveOption('productTransportFee',$listData['Option']['value']);
				
			}
			else if($type=='delete')
			{
				$idDelete= (int) $dataSend['id'];
				$listData= $modelOption->getOption('productTransportFee');
				unset($listData['Option']['value']['allData'][$idDelete]);
				$modelOption->saveOption('productTransportFee',$listData['Option']['value']);
			}
			
			if($dataSend['redirect']>0)
			{
				$modelOption->redirect($urlPlugins.'admin/product-transportFee-listTransportFee.php');
			}
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function listOrder($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;

		$modelOrder= new Order();

		if(checkAdminLogin()){
			

			$page= (isset($_GET['page']))? (int) $_GET['page']:1;
        	if($page<=0) $page=1;
        	$limit= 15;
        	$conditions= array();

        	if(isset($_GET['email']) && $_GET['email']!=''){
	        	$conditions['email']= $_GET['email'];
        	}

        	if(isset($_GET['phone']) && $_GET['phone']!=''){
	        	$conditions['phone']= $_GET['phone'];
        	}

        	if(isset($_GET['fromDate']) && $_GET['fromDate']!=''){
        		$fromDate= explode('-', $_GET['fromDate']);
	        	$conditions['time']['$gte']= mktime(0, 0, 0, $fromDate[1], $fromDate[0], $fromDate[2]);
        	}

        	if(isset($_GET['toDate']) && $_GET['toDate']!=''){
        		$toDate= explode('-', $_GET['toDate']);
	        	$conditions['time']['$lte']= mktime(23, 59, 59, $toDate[1], $toDate[0], $toDate[2]);
        	}

        	$listData= $modelOrder->getPage($page,$limit,$conditions);

            $totalData= $modelOrder->find('count',array('conditions' => $conditions));
		
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
			$modelProduct->redirect($urlHomes);
		}
	}

	function saveOrderProduct_updateOrder($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin() && $isRequestPost){
			$dataSend= arrayMap($input['request']->data);
	
			$modelOrder= new Order();
			
			$fullname= $dataSend['fullname'];
			$email= $dataSend['email'];
			$phone= $dataSend['phone'];
			$address= $dataSend['address'];
			$note= $dataSend['note'];
			$lock= (int) $dataSend['lock'];
			$id= $dataSend['id'];
			
			if($fullname!='' && $email!='' && $phone!='' )
			{
				$modelOrder->updateOrder($fullname,$email,$phone,$address,$note,$id,$lock);
				$modelOrder->redirect($urlPlugins.'admin/product-order-infoOrder.php?status=1&id='.$id);
			}
			else $modelOrder->redirect($urlPlugins.'admin/product-order-infoOrder.php?status=-1&id='.$id);

		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function infoOrder($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;

		$modelOrder= new Order();
		$modelProduct= new Product();

		if(checkAdminLogin()){
			$idEdit= new MongoId($_GET['id']);
			$news= $modelOrder->getOrder($idEdit);

			if($news){
				$listTypeMoney= $modelOption->getOption('productTypeMoney');

				foreach($news['Order']['listProduct'] as $key=>$product){
					$data= $modelProduct->getProduct($product['id']);
					if(!isset($data['Product']['images'][0]) || $data['Product']['images'][0]=='')
					{
						$data['Product']['images'][0]= $urlHomes.'/app/Plugin/product/images/no_image-100x100.jpg';
					}

					$data['Product']['number']= $product['number'];
					$data['Product']['price']= $product['price'];
					$data['Product']['codeDiscount']= (isset($product['codeDiscount']))? $product['codeDiscount']:'';

					$news['Order']['listProduct'][$key]= $data['Product'];
				}

				setVariable('news',$news);
				setVariable('listTypeMoney',$listTypeMoney);

			}else{
				$modelOrder->redirect($urlHomes);
			}
		}else{
			$modelOrder->redirect($urlHomes);
		}
	}

	function printOrder($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;

		$modelOrder= new Order();
		$modelProduct= new Product();

		if(checkAdminLogin()){
			$idEdit= new MongoId($_GET['id']);
			$news= $modelOrder->getOrder($idEdit);

			if($news){
				$listTypeMoney= $modelOption->getOption('productTypeMoney');

				foreach($news['Order']['listProduct'] as $key=>$product){
					$data= $modelProduct->getProduct($product['id']);
					if(!isset($data['Product']['images'][0]) || $data['Product']['images'][0]=='')
					{
						$data['Product']['images'][0]= $urlHomes.'/app/Plugin/product/images/no_image-100x100.jpg';
					}

					$data['Product']['number']= $product['number'];
					$data['Product']['price']= $product['price'];
					$data['Product']['codeDiscount']= (isset($product['codeDiscount']))? $product['codeDiscount']:'';

					$news['Order']['listProduct'][$key]= $data['Product'];
				}

				setVariable('news',$news);
				setVariable('listTypeMoney',$listTypeMoney);

			}else{
				$modelOrder->redirect($urlHomes);
			}
		}else{
			$modelOrder->redirect($urlHomes);
		}
	}

	function deleteOrder($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlPlugins;

		$modelOrder= new Order();

		if(checkAdminLogin()){
			if(isset($_GET['id']))
			{
				$idDelete= new MongoId($_GET['id']);
				$modelOrder->delete($idDelete);
			}

			$modelOrder->redirect($urlPlugins.'admin/product-order-listOrder.php');
		}else{
			$modelOrder->redirect($urlHomes);
		}
	}

	function settingProduct($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlPlugins;

		if(checkAdminLogin()){
			$data= $modelOption->getOption('settingProduct');
			setVariable('data',$data);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function saveSetting($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin() && $isRequestPost){
			$dataSend= arrayMap($input['request']->data);

			$data= $modelOption->getOption('settingProduct');
	
			$data['Option']['value']['language']= $dataSend['language'];
			$data['Option']['value']['numberPost']= (int) $dataSend['numberPost'];
			$data['Option']['value']['passSynch']= trim($dataSend['passSynch']);
            $data['Option']['value']['massMin']= (double) $dataSend['massMin'];
            $data['Option']['value']['transportFeeMin']= (double) $dataSend['transportFeeMin'];
			
			$modelOption->saveOption('settingProduct', $data['Option']['value']);
			$modelOption->redirect($urlPlugins.'admin/product-setting-settingProduct.php?status=1');
		}else{
			$modelOption->redirect($urlHomes);
		}

	}

	// Sync
	function syncMoney($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;
		global $isRequestPost;
		global $languageMantan;

		if(checkAdminLogin()){
			$data= $modelOption->getOption('syncDatabaseProduct');
			$mess= '';

			if($isRequestPost){
				$dataSend= arrayMap($input['request']->data);

				$data['Option']['value']['syncMoney']['web']= $dataSend['websiteSync'];
				$data['Option']['value']['syncMoney']['pass']= $dataSend['passSync'];
				$modelOption->saveOption('syncDatabaseProduct', $data['Option']['value']);

				$dataSendSync= array('pass='.$dataSend['passSync']);
				$syncMoney= sendDataConnect($dataSend['websiteSync'].'/syncMoneyApi',$dataSendSync);
				
				$syncMoney= json_decode($syncMoney,true);
				
				if($syncMoney){
					$listTypeMoney= $modelOption->getOption('productTypeMoney');
					$listTypeMoney['Option']['value']= $syncMoney;
					$modelOption->create();
					$modelOption->saveOption('productTypeMoney', $listTypeMoney['Option']['value']);
				}

				$mess= $languageMantan['saveSuccess'];
			}

			setVariable('data',$data);
			setVariable('mess',$mess);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function syncManufacturer($input)
	{
		Configure::write('debug', 2);

		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;
		global $isRequestPost;
		global $languageMantan;

		if(checkAdminLogin()){
			$data= $modelOption->getOption('syncDatabaseProduct');
			$mess= '';

			if($isRequestPost){
				$dataSend= arrayMap($input['request']->data);

				$data['Option']['value']['syncManufacturer']['web']= $dataSend['websiteSync'];
				$data['Option']['value']['syncManufacturer']['pass']= $dataSend['passSync'];
				$data['Option']['value']['syncManufacturer']['idManufacturer']= $dataSend['idManufacturer'];
				$modelOption->saveOption('syncDatabaseProduct', $data['Option']['value']);

				$dataSendSync= array('pass='.$dataSend['passSync']);
				$syncData= sendDataConnect($dataSend['websiteSync'].'/syncManufacturerApi',$dataSendSync);
				
				$syncData= json_decode($syncData,true);
				

				if(count($syncData['category'])>0){
					$syncData['category']= checkImageCategory($syncData['category'],$dataSend['websiteSync']);
				}
				
				if($syncData){
					$listManufacturer= $modelOption->getOption('productManufacturer');
					$listIDManufacturer= explode(',', $dataSend['idManufacturer']);

					if(!empty($listIDManufacturer)){
						$listData= array();
						foreach($syncData['category'] as $key=>$value){
							if(!in_array($key, $listIDManufacturer)){
								unset($syncData['category'][$key]);
							}
						}
					}

					$listManufacturer['Option']['value']= $syncData;


					
					$modelOption->create();
					$modelOption->saveOption('productManufacturer', $listManufacturer['Option']['value']);
				}

				$mess= $languageMantan['saveSuccess'];
			}

			setVariable('data',$data);
			setVariable('mess',$mess);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function syncCategory($input)
	{
		Configure::write('debug', 2);

		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;
		global $isRequestPost;
		global $languageMantan;

		if(checkAdminLogin()){
			$data= $modelOption->getOption('syncDatabaseProduct');
			$mess= '';

			if($isRequestPost){
				$dataSend= arrayMap($input['request']->data);

				$data['Option']['value']['syncCategory']['web']= $dataSend['websiteSync'];
				$data['Option']['value']['syncCategory']['pass']= $dataSend['passSync'];
				$data['Option']['value']['syncCategory']['idCategory']= $dataSend['idCategory'];
				$modelOption->saveOption('syncDatabaseProduct', $data['Option']['value']);

				$dataSendSync= array('pass='.$dataSend['passSync']);
				$syncData= sendDataConnect($dataSend['websiteSync'].'/syncCategoryApi',$dataSendSync);
				
				$syncData= json_decode($syncData,true);

				if(count($syncData['category'])>0){
					$syncData['category']= checkImageCategory($syncData['category'],$dataSend['websiteSync']);
				}
				
				if($syncData){
					$listCategory= $modelOption->getOption('productCategory');

					$listIDCategory= explode(',', $dataSend['idCategory']);

					if(!empty($listIDCategory)){
						$listData= array();
						foreach($syncData['category'] as $key=>$value){
							if(!in_array($key, $listIDCategory)){
								unset($syncData['category'][$key]);
							}else{
								if(!empty($value['sub'])){
									foreach ($value['sub'] as $keySub => $valueSub) {
										if(!in_array($keySub, $listIDCategory)){
											unset($syncData['category'][$key]['sub'][$keySub]);
										}
									}
								}
							}
						}
					}

					//debug($syncData['category']);die;

					$listCategory['Option']['value']= $syncData;
					$modelOption->create();
					$modelOption->saveOption('productCategory', $listCategory['Option']['value']);
				}

				$mess= $languageMantan['saveSuccess'];
			}

			setVariable('data',$data);
			setVariable('mess',$mess);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function syncAdditionalAttributes($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;
		global $isRequestPost;
		global $languageMantan;

		if(checkAdminLogin()){
			$data= $modelOption->getOption('syncDatabaseProduct');
			$mess= '';

			if($isRequestPost){
				$dataSend= arrayMap($input['request']->data);

				$data['Option']['value']['syncAdditionalAttributes']['web']= $dataSend['websiteSync'];
				$data['Option']['value']['syncAdditionalAttributes']['pass']= $dataSend['passSync'];
				$modelOption->saveOption('syncDatabaseProduct', $data['Option']['value']);

				$dataSendSync= array('pass='.$dataSend['passSync']);
				$syncData= sendDataConnect($dataSend['websiteSync'].'/syncAdditionalAttributesApi',$dataSendSync);
				
				$syncData= json_decode($syncData,true);
				
				if($syncData){
					$listProperties= $modelOption->getOption('propertiesProduct');
					$listProperties['Option']['value']= $syncData;
					$modelOption->create();
					$modelOption->saveOption('propertiesProduct', $listProperties['Option']['value']);
				}

				$mess= $languageMantan['saveSuccess'];
			}

			setVariable('data',$data);
			setVariable('mess',$mess);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function syncProduct($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;
		global $isRequestPost;
		global $languageMantan;

		if(checkAdminLogin()){
			$data= $modelOption->getOption('syncDatabaseProduct');
			$mess= '';
			$modelProduct= new Product();
			$listCategory= $modelOption->getOption('productCategory');
			$listManufacturer= $modelOption->getOption('productManufacturer');

			if($isRequestPost){
				$dataSend= arrayMap($input['request']->data);

				$data['Option']['value']['syncProduct']['web']= $dataSend['websiteSync'];
				$data['Option']['value']['syncProduct']['pass']= $dataSend['passSync'];
				$modelOption->saveOption('syncDatabaseProduct', $data['Option']['value']);

				$listIdCategory= array();

				if($dataSend['category']>0){
					$category= $modelProduct->getcat($listCategory['Option']['value']['category'],$dataSend['category']);
					$listIdCategory= array($category['id']);
					$listIdCategory= getSubIdCategory($category,$listIdCategory);
				}else{
					$listAll['sub']= $listCategory['Option']['value']['category'];
					$listIdCategory= getSubIdCategory($listAll,$listIdCategory);
				}

				$listIdManufacturer= array();

				if($dataSend['manufacturer']>0){
					$category= $modelProduct->getcat($listManufacturer['Option']['value']['category'],$dataSend['manufacturer']);
					$listIdManufacturer= array($category['id']);
					$listIdManufacturer= getSubIdCategory($category,$listIdManufacturer);
				}else{
					$listAll['sub']= $listManufacturer['Option']['value']['category'];
					$listIdManufacturer= getSubIdCategory($listAll,$listIdManufacturer);
				}

				$dataSendSync= array('pass'=>$dataSend['passSync'],'category'=>$listIdCategory,'manufacturer'=>$listIdManufacturer);

				
				$stringSend= array();
				foreach($dataSendSync as $key=>$value){
		   			if(is_array($value)){
		   				foreach($value as $valueArray){
		   					$stringSend[]= $key.'[]='.$valueArray;
		   				}
		   			}else{
		   				$stringSend[]= $key.'='.$value;
		   			}
		   		}

				$syncData= sendDataConnect($dataSend['websiteSync'].'/syncProductApi',$stringSend);

				$syncData= json_decode($syncData,true);

				if($syncData){
					foreach($syncData as $product){
						$modelProduct->create();
						if(isset($product['Product']['images']) && count($product['Product']['images'])>0){
							foreach($product['Product']['images'] as $key=>$images){
								if(!strpos($images,'://') && strpos($images,'app/webroot/upload')){
								 	$product['Product']['images'][$key]= $dataSend['websiteSync'].$images; 
							 	}
							}
						}
						$modelProduct->save($product);
					}
				}

				$mess= $languageMantan['saveSuccess'];
			}

			setVariable('data',$data);
			setVariable('mess',$mess);
			setVariable('listCategory',$listCategory);
			setVariable('listManufacturer',$listManufacturer);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
	
	function searchAjaxProductOther($input)
	{
		$modelProduct= new Product();

		$dataSend= arrayMap($input['request']->data);

		if(empty($dataSend['key'])) $dataSend['key']= '';
		$key= createSlugMantan($dataSend['key']);
		$conditions['$or'][0]['slug']= array('$regex' => $key);
		$conditions['$or'][1]['slugKeys']= array('$regex' => $key);
		$conditions['$or'][2]['code']= array('$regex' => $key);
		$conditions['$or'][3]['alias']= array('$regex' => $key);

		$page= null;
		$limit= null;

		$listData= $modelProduct->getPage($page,$limit,$conditions);
		$listDataShow= array();
		if(!empty($listData)){
			foreach($listData as $data){
				$array= array();
				$array['id']= $data['Product']['id'];
				$array['label']= $data['Product']['title'];
				$array['value']= $data['Product']['id'];
				
				$listDataShow[]= $array;
			}
		}
	
		setVariable('listData',$listDataShow);
	}

	function checkCodeProductAPI($input)
	{
		$modelProduct= new Product();
		//echo $_GET['code'].' ';
		if(isset($_GET['code'])){
			$conditions= array('code'=>$_GET['code']);

			$data= $modelProduct->find('first', array('conditions'=>$conditions));

			if($data){
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 2;
		}
		die;
	}
?>