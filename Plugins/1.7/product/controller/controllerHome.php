<?php
	function allProduct($input)
	{
		$modelProduct= new Product();
		$modelOption= new Option();
		
		$page= (isset($_GET['page']))? (int) $_GET['page']:1;
		if($page<=0) $page=1;
		
		global $metaTitleMantan;
		global $metaKeywordsMantan;
		global $metaDescriptionMantan;
		global $urlNow;
		
		$settingProduct= $modelOption->getOption('settingProduct');
		$limit= (isset($settingProduct['Option']['value']['numberPost']) && $settingProduct['Option']['value']['numberPost']>0)?$settingProduct['Option']['value']['numberPost']:15;
		$conditions= array();
		$order= array('priority'=>'asc','timeUp'=>'desc');
		
		$listData= $modelProduct->getPage($page,$limit,$conditions,$order);
		if(count($listData)>0){
			$number= -1;
			foreach ($listData as $orther) {
				$number++;
				$listData[$number]['Product']['urlProductDetail']= getLinkProduct().$orther['Product']['slug'].'.html';
			}
		}

		$listTypeMoney= $modelOption->getOption('productTypeMoney');
		$listManufacturer= $modelOption->getOption('productManufacturer');
		
		$totalData= $modelProduct->find('count',array('conditions' => $conditions));
		
		$balance= $totalData%$limit;
		$totalPage= ($totalData-$balance)/$limit;
		if($balance>0)$totalPage+=1;
		
		if( ($page-2)>0 ) $headPage=$page-2;else $headPage=1;
		if( ($page+2) <= $totalPage) $endPage=$page+2;else $endPage=$totalPage;
		
		$back=$page-1;$next=$page+1;
		if($back<=0) $back=1;
		if($next>=$totalPage) $next=$totalPage;
		
		if(strpos($urlNow,'?')!== false)
		{
			$urlFix= explode('?', $urlNow);
            $urlFix2= (isset($urlFix[1])) ?$urlFix[1]:'';
			
			if(isset($_GET['page'])){
				$urlFix2= str_replace('?page='.$_GET['page'], '', $urlFix[1]);
				$urlFix2= str_replace('&page='.$_GET['page'], '', $urlFix2);
				$urlFix2= str_replace('page='.$_GET['page'], '', $urlFix2);
			}
			
			if(isset($urlFix2) && $urlFix2!='')
			{
				$urlPage= $urlFix[0].'?'.$urlFix2.'&page=';
			}
			else
			{
				$urlPage= $urlFix[0].'?page=';
			}
		}
		else
		{
			$urlPage= $urlNow.'?page=';
		}
		
		setVariable('listData',$listData);
		setVariable('headPage',$headPage);
		setVariable('endPage',$endPage);
		setVariable('urlPage',$urlPage);
		
		setVariable('listTypeMoney',$listTypeMoney);
		setVariable('back',$back);
        setVariable('page',$page);
        setVariable('totalPage',$totalPage);
        setVariable('next',$next);
        setVariable('totalData',$totalData);
	}

	function category($input)
	{
		$modelProduct= new Product();
		$modelOption= new Option();

		global $urlHomes;

		if(isset($input['request']->params['pass'][1])){
			$input['request']->params['pass'][1]= str_replace('.html', '', $input['request']->params['pass'][1]);
			
			$listCategory= $modelOption->getOption('productCategory');
			$category= $modelProduct->getcat($listCategory['Option']['value']['category'],$input['request']->params['pass'][1],'slug');

			if(count($category)>0){
			
				$page= (isset($_GET['page']))? (int) $_GET['page']:1;
				if($page<=0) $page=1;
				
				global $metaTitleMantan;
				global $metaKeywordsMantan;
				global $metaDescriptionMantan;
				global $urlNow;
				
				$seoProduct= $modelOption->getOption('seoProduct');
				
				$metaTitleMantanDefault= $metaTitleMantan;
				$metaKeywordsMantanDefault= $metaKeywordsMantan;
				$metaDescriptionMantanDefault= $metaDescriptionMantan;
				
				if(isset($seoProduct['Option']['value']['category']['title']) && isset($category['nameSeo']) && $seoProduct['Option']['value']['category']['title']!='' && $category['nameSeo']=='')
				{
					$metaTitleMantan= str_replace('%title%', $metaTitleMantanDefault, $seoProduct['Option']['value']['category']['title']);
					$metaTitleMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaTitleMantan);
					$metaTitleMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaTitleMantan);
					
					$metaTitleMantan= str_replace('%categoryName%', $category['name'], $metaTitleMantan);
					$metaTitleMantan= str_replace('%categoryKeyword%', isset($category['key'])?$category['key']:'', $metaTitleMantan);
					$metaTitleMantan= str_replace('%categoryDescription%', $category['description'], $metaTitleMantan);
					$metaTitleMantan= str_replace('%page%', $page, $metaTitleMantan);
					
					if($page>1)
					{
						$metaTitleMantan= str_replace('%pageMore%', $page, $metaTitleMantan);
					}
					else
					{
						$metaTitleMantan= str_replace('%pageMore%', '', $metaTitleMantan);
					}
				}
				else if(isset($category['nameSeo']) && $category['nameSeo']!='')
				{
					$metaTitleMantan= $category['nameSeo'];
				}
				
				if(isset($seoProduct['Option']['value']['category']['keyword']) && $seoProduct['Option']['value']['category']['keyword']!='')
				{
					$metaKeywordsMantan= str_replace('%title%', $metaTitleMantanDefault, $seoProduct['Option']['value']['category']['keyword']);
					$metaKeywordsMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaKeywordsMantan);
					$metaKeywordsMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaKeywordsMantan);
					
					$metaKeywordsMantan= str_replace('%categoryName%', $category['name'], $metaKeywordsMantan);
					$metaKeywordsMantan= str_replace('%categoryKeyword%', isset($category['key'])?$category['key']:'', $metaKeywordsMantan);
					$metaKeywordsMantan= str_replace('%categoryDescription%', $category['description'], $metaKeywordsMantan);
					$metaKeywordsMantan= str_replace('%page%', $page, $metaKeywordsMantan);
					
					if($page>1)
					{
						$metaKeywordsMantan= str_replace('%pageMore%', $page, $metaKeywordsMantan);
					}
					else
					{
						$metaKeywordsMantan= str_replace('%pageMore%', '', $metaKeywordsMantan);
					}
				}
				
				if(isset($seoProduct['Option']['value']['category']['description']) && $seoProduct['Option']['value']['category']['description']!='')
				{
					$metaDescriptionMantan= str_replace('%title%', $metaTitleMantanDefault, $seoProduct['Option']['value']['category']['description']);
					$metaDescriptionMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaDescriptionMantan);
					$metaDescriptionMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaDescriptionMantan);
					
					$metaDescriptionMantan= str_replace('%categoryName%', $category['name'], $metaDescriptionMantan);
					$metaDescriptionMantan= str_replace('%categoryKeyword%', isset($category['key'])?$category['key']:'', $metaDescriptionMantan);
					$metaDescriptionMantan= str_replace('%categoryDescription%', $category['description'], $metaDescriptionMantan);
					$metaDescriptionMantan= str_replace('%page%', $page, $metaDescriptionMantan);
					
					if($page>1)
					{
						$metaDescriptionMantan= str_replace('%pageMore%', $page, $metaDescriptionMantan);
					}
					else
					{
						$metaDescriptionMantan= str_replace('%pageMore%', '', $metaDescriptionMantan);
					}
				}
				
				$listId= array($category['id']);
				$listId= getSubIdCategory($category,$listId);
				$idCat= (int) $category['id'];
				$conditions= array('category'=>array('$in'=>$listId),'lock'=>0);
				$order= array('priority'=>'asc','timeUp'=>'desc');
				
				// Tìm kiếm theo các tiêu chí mở rộng
				$listProperties= $modelOption->getOption('propertiesProduct');

				if(isset($listProperties['Option']['value']['allData']) && count($listProperties['Option']['value']['allData'])>0){
					foreach($listProperties['Option']['value']['allData'] as $components)
					{
						$valueProperties= array();
						if(isset($components['allData']) && count($components['allData'])>0){
							foreach($components['allData'] as $allData)
							{
								if(isset($_GET['properties'.$components['id'].'-'.$allData['id']]) && $_GET['properties'.$components['id'].'-'.$allData['id']] != '')
								{
									array_push($valueProperties, $allData['id']);
								}
							}
						}
						
						if(count($valueProperties)>0)
						{
							$conditions['properties.'.$components['id']]= array('$in'=>$valueProperties);
						}
					}
				}
				// Sap xep tuy chinh 
				if (isset($_GET['sort']))
				{
					switch ($_GET['sort']) {
						case 'timeNew':
							$order=array('priority'=>'asc','timeUp'=>'desc','created' => 'desc','title'=>'asc');
							break;
						case 'timeOld':
							$order=array('priority'=>'asc','timeUp'=>'asc','created' => 'desc','title'=>'asc');
							break;
						case 'priceHigh':
							$order=array('priority'=>'asc','price'=>'desc','created' => 'desc','title'=>'asc');
							break;
						case 'priceLow':
							$order=array('priority'=>'asc','price'=>'asc','created' => 'desc','title'=>'asc');
							break;
					}
				}
				
				$settingProduct= $modelOption->getOption('settingProduct');
				$limit= (isset($settingProduct['Option']['value']['numberPost']) && $settingProduct['Option']['value']['numberPost']>0)?$settingProduct['Option']['value']['numberPost']:15;
				$listData= $modelProduct->getPage($page,$limit,$conditions,$order);

				if(count($listData)>0){
					$number= -1;
					foreach ($listData as $orther) {
						$number++;
						$listData[$number]['Product']['urlProductDetail']= getLinkProduct().$orther['Product']['slug'].'.html';
					}
				}
				
				$listTypeMoney= $modelOption->getOption('productTypeMoney');
				$listManufacturer= $modelOption->getOption('productManufacturer');
				
				$totalData= $modelProduct->find('count',array('conditions' => $conditions));
				
				$balance= $totalData%$limit;
				$totalPage= ($totalData-$balance)/$limit;
				if($balance>0)$totalPage+=1;
				
				if( ($page-2)>0 ) $headPage=$page-2;else $headPage=1;
				if( ($page+2) <= $totalPage) $endPage=$page+2;else $endPage=$totalPage;
				
				$back=$page-1;$next=$page+1;
				if($back<=0) $back=1;
				if($next>=$totalPage) $next=$totalPage;
				
				if(strpos($urlNow,'?')!== false)
				{
					$urlFix= explode('?', $urlNow);
                    $urlFix2= (isset($urlFix[1])) ?$urlFix[1]:'';
					
					if(isset($_GET['page'])){
						$urlFix2= str_replace('?page='.$_GET['page'], '', $urlFix[1]);
						$urlFix2= str_replace('&page='.$_GET['page'], '', $urlFix2);
						$urlFix2= str_replace('page='.$_GET['page'], '', $urlFix2);
					}
					
					if(isset($urlFix2) && $urlFix2!='')
					{
						$urlPage= $urlFix[0].'?'.$urlFix2.'&page=';
					}else{
						$urlPage= $urlFix[0].'?page=';
					}
				}
				else
				{
					$urlPage= $urlNow.'?page=';
				}
				
				setVariable('category',$category);
				setVariable('listProperties',$listProperties);
				setVariable('listData',$listData);
				setVariable('headPage',$headPage);
				setVariable('endPage',$endPage);
				setVariable('urlPage',$urlPage);
				
				setVariable('listTypeMoney',$listTypeMoney);
				setVariable('back',$back);
		        setVariable('page',$page);
		        setVariable('totalPage',$totalPage);
		        setVariable('next',$next);
		        setVariable('totalData',$totalData);
		    }else{
    			$modelProduct->redirect($urlHomes);
    		}
    	}else{
    		$modelProduct->redirect($urlHomes);
    	}

	}
	
	function manufacturer($input)
	{
		$modelProduct= new Product();
		$modelOption= new Option();

		global $urlHomes;

		if(isset($input['request']->params['pass'][1])){
			$input['request']->params['pass'][1]= str_replace('.html', '', $input['request']->params['pass'][1]);
			
			$listManufacturer= $modelOption->getOption('productManufacturer');
			$category= $modelProduct->getcat($listManufacturer['Option']['value']['category'],$input['request']->params['pass'][1],'slug');

			if(count($category)>0){
				$listId= array($category['id']);

				if(isset($category['sub']) && count($category['sub'])>0){
					$listId= getIdInParentCat($category['sub'],$listId);
				}
				
				$conditions['manufacturerId']= array('$in'=>$listId);
				$conditions['lock']= 0;
				
				$page= (isset($_GET['page']))? (int) $_GET['page']:1;
				if($page<=0) $page=1;
				
				// Xu ly Seo
				global $metaTitleMantan;
				global $metaKeywordsMantan;
				global $metaDescriptionMantan;
				global $urlNow;
				
				$seoProduct= $modelOption->getOption('seoProduct');
				
				$metaTitleMantanDefault= $metaTitleMantan;
				$metaKeywordsMantanDefault= $metaKeywordsMantan;
				$metaDescriptionMantanDefault= $metaDescriptionMantan;

				$category['key']= (isset($category['key']))?$category['key']:'';
				$category['name']= (isset($category['name']))?$category['name']:'';
				$category['description']= (isset($category['description']))?$category['description']:'';
				
				if(isset($seoProduct['Option']['value']['manufacturer']['title']) && $seoProduct['Option']['value']['manufacturer']['title']!='')
				{
					$metaTitleMantan= str_replace('%title%', $metaTitleMantanDefault, $seoProduct['Option']['value']['manufacturer']['title']);
					$metaTitleMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaTitleMantan);
					$metaTitleMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaTitleMantan);
					
					$metaTitleMantan= str_replace('%manufacturerName%', $category['name'], $metaTitleMantan);
					$metaTitleMantan= str_replace('%manufacturerKeyword%', $category['key'], $metaTitleMantan);
					$metaTitleMantan= str_replace('%manufacturerDescription%', $category['description'], $metaTitleMantan);
					$metaTitleMantan= str_replace('%page%', $page, $metaTitleMantan);
					
					if($page>1)
					{
						$metaTitleMantan= str_replace('%pageMore%', $page, $metaTitleMantan);
					}
					else
					{
						$metaTitleMantan= str_replace('%pageMore%', '', $metaTitleMantan);
					}
				}
				
				if(isset($seoProduct['Option']['value']['manufacturer']['keyword']) && $seoProduct['Option']['value']['manufacturer']['keyword']!='')
				{
					$metaKeywordsMantan= str_replace('%title%', $metaTitleMantanDefault, $seoProduct['Option']['value']['manufacturer']['keyword']);
					$metaKeywordsMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaKeywordsMantan);
					$metaKeywordsMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaKeywordsMantan);
					
					$metaKeywordsMantan= str_replace('%manufacturerName%', $category['name'], $metaKeywordsMantan);
					$metaKeywordsMantan= str_replace('%manufacturerKeyword%', $category['key'], $metaKeywordsMantan);
					$metaKeywordsMantan= str_replace('%manufacturerDescription%', $category['description'], $metaKeywordsMantan);
					$metaKeywordsMantan= str_replace('%page%', $page, $metaKeywordsMantan);
					
					if($page>1)
					{
						$metaKeywordsMantan= str_replace('%pageMore%', $page, $metaKeywordsMantan);
					}
					else
					{
						$metaKeywordsMantan= str_replace('%pageMore%', '', $metaKeywordsMantan);
					}
				}
				
				if(isset($seoProduct['Option']['value']['manufacturer']['description']) && $seoProduct['Option']['value']['manufacturer']['description']!='')
				{
					$metaDescriptionMantan= str_replace('%title%', $metaTitleMantanDefault, $seoProduct['Option']['value']['manufacturer']['description']);
					$metaDescriptionMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaDescriptionMantan);
					$metaDescriptionMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaDescriptionMantan);
					
					$metaDescriptionMantan= str_replace('%manufacturerName%', $category['name'], $metaDescriptionMantan);
					$metaDescriptionMantan= str_replace('%manufacturerKeyword%', $category['key'], $metaDescriptionMantan);
					$metaDescriptionMantan= str_replace('%manufacturerDescription%', $category['description'], $metaDescriptionMantan);
					$metaDescriptionMantan= str_replace('%page%', $page, $metaDescriptionMantan);
					
					if($page>1)
					{
						$metaDescriptionMantan= str_replace('%pageMore%', $page, $metaDescriptionMantan);
					}
					else
					{
						$metaDescriptionMantan= str_replace('%pageMore%', '', $metaDescriptionMantan);
					}
				}
				
				
				$settingProduct= $modelOption->getOption('settingProduct');
				$limit= (isset($settingProduct['Option']['value']['numberPost']) && $settingProduct['Option']['value']['numberPost']>0)?$settingProduct['Option']['value']['numberPost']:15;
				$order= array('priority'=>'asc','timeUp'=>'desc');

				$listData= $modelProduct->getPage($page,$limit,$conditions,$order);
				if(count($listData)>0){
					$number= -1;
					foreach ($listData as $orther) {
						$number++;
						$listData[$number]['Product']['urlProductDetail']= getLinkProduct().$orther['Product']['slug'].'.html';
					}
				}

				$listTypeMoney= $modelOption->getOption('productTypeMoney');
				$listTypeMoney= $modelOption->getOption('productTypeMoney');
				$listManufacturer= $modelOption->getOption('productManufacturer');
			
				$totalData= $modelProduct->find('count',array('conditions' => $conditions));
				
				$balance= $totalData%$limit;
				$totalPage= ($totalData-$balance)/$limit;
				if($balance>0)$totalPage+=1;
				
				if( ($page-2)>0 ) $headPage=$page-2;else $headPage=1;
				if( ($page+2) <= $totalPage) $endPage=$page+2;else $endPage=$totalPage;
				
				$back=$page-1;$next=$page+1;
				if($back<=0) $back=1;
				if($next>=$totalPage) $next=$totalPage;
				
				if(strpos($urlNow,'?')!== false)
				{
					$urlFix= explode('?', $urlNow);
                    $urlFix2= (isset($urlFix[1])) ?$urlFix[1]:'';
					
					if(isset($_GET['page'])){
						$urlFix2= str_replace('?page='.$_GET['page'], '', $urlFix[1]);
						$urlFix2= str_replace('&page='.$_GET['page'], '', $urlFix2);
						$urlFix2= str_replace('page='.$_GET['page'], '', $urlFix2);
					}
					
					if(isset($urlFix2) && $urlFix2!='')
					{
						$urlPage= $urlFix[0].'?'.$urlFix2.'&page=';
					}
					else
					{
						$urlPage= $urlFix[0].'?page=';
					}
				}
				else
				{
					$urlPage= $urlNow.'?page=';
				}
				
				setVariable('category',$category);
				setVariable('listData',$listData);
				setVariable('headPage',$headPage);
				setVariable('endPage',$endPage);
				setVariable('urlPage',$urlPage);
				
				setVariable('listTypeMoney',$listTypeMoney);
				setVariable('back',$back);
		        setVariable('page',$page);
		        setVariable('totalPage',$totalPage);
		        setVariable('next',$next);
		        setVariable('totalData',$totalData);
		    }else{
		    	$modelProduct->redirect($urlHomes);
		    }
	    }else{
    		$modelProduct->redirect($urlHomes);
    	}
	}
	
	function productDiscount($input)
	{
		$modelProduct= new Product();
		$modelOption= new Option();
		
		global $urlNow;
		
		$page= (isset($_GET['page']))? (int) $_GET['page']:1;
		if($page<=0) $page=1;
		
		$today= getdate();
		$conditions['dateDiscountStart']= array('$lte' => $today[0]);
		$conditions['dateDiscountEnd']= array('$gte' => $today[0]);
		$conditions['lock']= 0;
		
		$settingProduct= $modelOption->getOption('settingProduct');
		$limit= (isset($settingProduct['Option']['value']['numberPost']) && $settingProduct['Option']['value']['numberPost']>0)?$settingProduct['Option']['value']['numberPost']:15;
		$order= array('priority'=>'asc','timeUp'=>'desc');

		$listData= $modelProduct->getPage($page,$limit,$conditions,$order);
		if(count($listData)>0){
			$number= -1;
			foreach ($listData as $orther) {
				$number++;
				$listData[$number]['Product']['urlProductDetail']= getLinkProduct().$orther['Product']['slug'].'.html';
			}
		}

		$listTypeMoney= $modelOption->getOption('productTypeMoney');
		$listTypeMoney= $modelOption->getOption('productTypeMoney');
		$listManufacturer= $modelOption->getOption('productManufacturer');
		
		$totalData= $modelProduct->find('count',array('conditions' => $conditions));
		
		$balance= $totalData%$limit;
		$totalPage= ($totalData-$balance)/$limit;
		if($balance>0)$totalPage+=1;
		
		if( ($page-2)>0 ) $headPage=$page-2;else $headPage=1;
		if( ($page+2) <= $totalPage) $endPage=$page+2;else $endPage=$totalPage;
		
		$back=$page-1;$next=$page+1;
		if($back<=0) $back=1;
		if($next>=$totalPage) $next=$totalPage;
		
		if(strpos($urlNow,'?')!== false)
		{
			$urlFix= explode('?', $urlNow);
            $urlFix2= (isset($urlFix[1])) ?$urlFix[1]:'';
			
			if(isset($_GET['page'])){
				$urlFix2= str_replace('?page='.$_GET['page'], '', $urlFix[1]);
				$urlFix2= str_replace('&page='.$_GET['page'], '', $urlFix2);
				$urlFix2= str_replace('page='.$_GET['page'], '', $urlFix2);
			}
			
			if(isset($urlFix2) && $urlFix2!='')
			{
				$urlPage= $urlFix[0].'?'.$urlFix2.'&page=';
			}
			else
			{
				$urlPage= $urlFix[0].'?page=';
			}
		}
		else
		{
			$urlPage= $urlNow.'?page=';
		}
		
		setVariable('listData',$listData);
		setVariable('headPage',$headPage);
		setVariable('endPage',$endPage);
		setVariable('urlPage',$urlPage);
		
		setVariable('listTypeMoney',$listTypeMoney);
		setVariable('back',$back);
        setVariable('page',$page);
        setVariable('totalPage',$totalPage);
        setVariable('next',$next);
        setVariable('totalData',$totalData);
	}
	
	function search($input)
	{
		$modelProduct= new Product();
		$modelOption= new Option();
		
		$page= (isset($_GET['page']))? (int) $_GET['page']:1;
		if($page<=0) $page=1;
		
		// Xu ly Seo
		global $metaTitleMantan;
		global $metaKeywordsMantan;
		global $metaDescriptionMantan;
		global $urlNow;
		
		$seoProduct= $modelOption->getOption('seoProduct');
		
		$metaTitleMantanDefault= $metaTitleMantan;
		$metaKeywordsMantanDefault= $metaKeywordsMantan;
		$metaDescriptionMantanDefault= $metaDescriptionMantan;
		
		if(isset($seoProduct['Option']['value']['search']['title']) && $seoProduct['Option']['value']['search']['title']!='')
		{
			$metaTitleMantan= str_replace('%title%', $metaTitleMantanDefault, $seoProduct['Option']['value']['search']['title']);
			$metaTitleMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaTitleMantan);
			$metaTitleMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaTitleMantan);
			if(isset($_GET['key'])){
				$metaTitleMantan= str_replace('%keySearch%', $_GET['key'], $metaTitleMantan);
			}
			$metaTitleMantan= str_replace('%page%', $page, $metaTitleMantan);
			
			if($page>1)
			{
				$metaTitleMantan= str_replace('%pageMore%', $page, $metaTitleMantan);
			}
			else
			{
				$metaTitleMantan= str_replace('%pageMore%', '', $metaTitleMantan);
			}
		}
		
		if(isset($seoProduct['Option']['value']['search']['keyword']) && $seoProduct['Option']['value']['search']['keyword']!='')
		{
			$metaKeywordsMantan= str_replace('%title%', $metaTitleMantanDefault, $seoProduct['Option']['value']['search']['keyword']);
			$metaKeywordsMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaKeywordsMantan);
			$metaKeywordsMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaKeywordsMantan);
			if(isset($_GET['key'])){
				$metaKeywordsMantan= str_replace('%keySearch%', $_GET['key'], $metaKeywordsMantan);
			}
			$metaKeywordsMantan= str_replace('%page%', $page, $metaKeywordsMantan);
			
			if($page>1)
			{
				$metaKeywordsMantan= str_replace('%pageMore%', $page, $metaKeywordsMantan);
			}
			else
			{
				$metaKeywordsMantan= str_replace('%pageMore%', '', $metaKeywordsMantan);
			}
		}
		
		if(isset($seoProduct['Option']['value']['search']['description']) && $seoProduct['Option']['value']['search']['description']!='')
		{
			$metaDescriptionMantan= str_replace('%title%', $metaTitleMantanDefault, $seoProduct['Option']['value']['search']['description']);
			$metaDescriptionMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaDescriptionMantan);
			$metaDescriptionMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaDescriptionMantan);
			if(isset($_GET['key'])){
				$metaDescriptionMantan= str_replace('%keySearch%', $_GET['key'], $metaDescriptionMantan);
			}
			$metaDescriptionMantan= str_replace('%page%', $page, $metaDescriptionMantan);
			
			if($page>1)
			{
				$metaDescriptionMantan= str_replace('%pageMore%', $page, $metaDescriptionMantan);
			}
			else
			{
				$metaDescriptionMantan= str_replace('%pageMore%', '', $metaDescriptionMantan);
			}
		}
		
		$conditions= array();
        $conditions['lock']= 0;
		// tim theo tu khoa
		if(isset($_GET['key']) && $_GET['key']!='')
		{
			$key= createSlugMantan($_GET['key']);
			$conditions['$or'][0]['slug']= array('$regex' => $key);
			$conditions['$or'][1]['slugKeys']= array('$regex' => $key);
			$conditions['$or'][2]['code']= array('$regex' => $key);
			$conditions['$or'][3]['alias']= array('$regex' => $key);
		}
		// tim theo gia
		if(isset($_GET['price']) && $_GET['price']!='')
		{
			$price= explode(';', $_GET['price']);
			
			$priceFrom= (int) $price[0];
			$priceTo= (int) $price[1];

	    	$conditions['price']= array('$gte' => $priceFrom,'$lte' => $priceTo);
		}
		
		$listCategory= $modelOption->getOption('productCategory');
		$listManufacturer= $modelOption->getOption('productManufacturer');
		
		if(isset($_GET['category']) && $_GET['category']!='')
		{
			$idCat= (int) $_GET['category'];
			$infoCategory= $modelProduct->getcat($listCategory['Option']['value']['category'],$idCat);
			
			$categorySearch= array($idCat);
			$categorySearch= getSubIdCategory($infoCategory,$categorySearch);
			
			setVariable('infoCategorySearch',$infoCategory);
		}
		else
		{
			$categorySearch= array();
		}
		
	    
	    $manufacturerSearch= array();
	    if(isset($listManufacturer["Option"]["value"]['allData']) && count($listManufacturer["Option"]["value"]['allData'])>0){
		    foreach($listManufacturer["Option"]["value"]['allData'] as $cat)
		    {
				$manufacturerSearch= getCheckCategorySearch($cat,$manufacturerSearch,'manufacturer');
		    }
		}
	    
	    if($categorySearch)
	    {
	    	$conditions['category']= array('$in'=>$categorySearch);
	    }
	    
	    if($manufacturerSearch)
	    {
	    	$conditions['manufacturerId']= array('$in'=>$manufacturerSearch);
	    }
		
		
		$settingProduct= $modelOption->getOption('settingProduct');
		$limit= (isset($settingProduct['Option']['value']['numberPost']) && $settingProduct['Option']['value']['numberPost']>0)?$settingProduct['Option']['value']['numberPost']:15;
		
		// Sap xep tuy chinh
		$order= array('priority'=>'asc','timeUp'=>'desc');
		if (isset($_GET['sort']))
		{
			switch ($_GET['sort']) {
				case 'timeNew':
					$order=array('priority'=>'asc','timeUp'=>'desc','created' => 'desc','title'=>'asc');
					break;
				case 'timeOld':
					$order=array('priority'=>'asc','timeUp'=>'asc','created' => 'desc','title'=>'asc');
					break;
				case 'priceHigh':
					$order=array('priority'=>'asc','price'=>'desc','created' => 'desc','title'=>'asc');
					break;
				case 'priceLow':
					$order=array('priority'=>'asc','price'=>'asc','created' => 'desc','title'=>'asc');
					break;
			}
		}	
		$listData= $modelProduct->getPage($page,$limit,$conditions,$order);
		
		if(count($listData)>0){
			$number= -1;
			foreach ($listData as $orther) {
				$number++;
				$listData[$number]['Product']['urlProductDetail']= getLinkProduct().$orther['Product']['slug'].'.html';
			}
		}

		$listTypeMoney= $modelOption->getOption('productTypeMoney');
	
		$totalData= $modelProduct->find('count',array('conditions' => $conditions));
		
		$balance= $totalData%$limit;
		$totalPage= ($totalData-$balance)/$limit;
		if($balance>0)$totalPage+=1;
		
		if( ($page-2)>0 ) $headPage=$page-2;else $headPage=1;
		if( ($page+2) <= $totalPage) $endPage=$page+2;else $endPage=$totalPage;
		
		$back=$page-1;$next=$page+1;
		if($back<=0) $back=1;
		if($next>=$totalPage) $next=$totalPage;
		
		if(strpos($urlNow,'?')!== false)
		{
			$urlFix= explode('?', $urlNow);
			$urlFix2= (isset($urlFix[1])) ?$urlFix[1]:'';
			if(isset($_GET['page'])){
				$urlFix2= str_replace('?page='.$page, '', $urlFix[1]);
				$urlFix2= str_replace('&page='.$page, '', $urlFix2);
				$urlFix2= str_replace('page='.$page, '', $urlFix2);
			}
			
			if(isset($urlFix2) && $urlFix2!='')
			{
				$urlPage= $urlFix[0].'?'.$urlFix2.'&page=';
			}
			else
			{
				$urlPage= $urlFix[0].'?page=';
			}
		}
		else
		{
			$urlPage= $urlNow.'?page=';
		}
		
		//setVariable('category',$category);
		setVariable('listData',$listData);
		setVariable('headPage',$headPage);
		setVariable('endPage',$endPage);
		setVariable('urlPage',$urlPage);
		
		setVariable('listTypeMoney',$listTypeMoney);
		setVariable('back',$back);
        setVariable('page',$page);
        setVariable('totalPage',$totalPage);
        setVariable('next',$next);
        setVariable('totalData',$totalData);
	}
	
	function productDetail($input)
	{
		global $metaTitleMantan;
		global $metaKeywordsMantan;
		global $metaDescriptionMantan;
		global $metaImageMantan;
		global $infoSite;
		global $urlHomes;
		
		$modelOption= new Option();
		$modelProduct= new Product();

		if(isset($input['request']->params['pass'][1])){
			$input['request']->params['pass'][1]= str_replace('.html', '', $input['request']->params['pass'][1]);
			$data= $modelProduct->getProductSlug($input['request']->params['pass'][1]);
			$folderProduct= $urlHomes.'/app/Plugin/product/';
		}
		
		if(empty($data))
		{
			$modelProduct->redirect($urlHomes);
		}
		else
		{
			$data['Product']['urlProductDetail']= getLinkProduct().$data['Product']['slug'].'.html';

			$listTypeMoney= $modelOption->getOption('productTypeMoney');
			$listManufacturer= $modelOption->getOption('productManufacturer');
			
			if(!isset($data['Product']['images'][0]))
			{
				$data['Product']['images'][0]= $folderProduct.'images/no_image.jpg';
			}	
			
			$http= substr($data['Product']['images'][0],1,4);
            if($http!='http'){
            	$metaImageMantan= $urlHomes.$data['Product']['images'][0];
            }else{
            	$metaImageMantan= $data['Product']['images'][0];
            }
            
			//$conditions= array('category'=> array('$in'=>$data['Product']['category']));
			$otherData= array();
			if(isset($data['Product']['otherProductID']) && mb_strlen(trim($data['Product']['otherProductID']))>0){
				$otherProductID= explode(',', $data['Product']['otherProductID']);
				foreach($otherProductID as $otherID){
					$productOther= $modelProduct->getProduct($otherID);
                    if($productOther){
                        $otherData[]= $productOther;
                    }
				}
			}elseif(isset($data['Product']['manufacturerId'])){
				$conditions= array();
				$conditions['$or'][0]['manufacturerId']= $data['Product']['manufacturerId'];
				$conditions['$or'][1]['category']= array('$in'=>$data['Product']['category']);
		
				$otherData= $modelProduct->getOtherData(8,$conditions);
			}

			if(count($otherData)>0){
				$number= -1;
				foreach ($otherData as $other) {
					$number++;
					$otherData[$number]['Product']['urlProductDetail']= getLinkProduct().$other['Product']['slug'].'.html';
				}
			}
			
			$modelProduct->updateView($data['Product']['id']);
			
			// Xu ly Seo
			$seoProduct= $modelOption->getOption('seoProduct');
			
			$metaTitleMantanDefault= $metaTitleMantan;
			$metaKeywordsMantanDefault= $metaKeywordsMantan;
			$metaDescriptionMantanDefault= $metaDescriptionMantan;
			
			if (!isset($data['Product']['nameSeo']))
				$data['Product']['nameSeo']='';
			if (!isset($data['Product']['key']))
				$data['Product']['key']='';

			if(isset($seoProduct['Option']['value']['detail']['title']) && $seoProduct['Option']['value']['detail']['title']!='' && $data['Product']['nameSeo']=='')
			{
				$metaTitleMantan= str_replace('%title%', $metaTitleMantanDefault, $seoProduct['Option']['value']['detail']['title']);
				$metaTitleMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaTitleMantan);
				$metaTitleMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaTitleMantan);
				
				$metaTitleMantan= str_replace('%productName%', $data['Product']['title'], $metaTitleMantan);
				$metaTitleMantan= str_replace('%productKeyword%', $data['Product']['key'], $metaTitleMantan);
				$metaTitleMantan= str_replace('%productDescription%', $data['Product']['description'], $metaTitleMantan);
			}
			else if(isset($data['Product']['nameSeo']) && $data['Product']['nameSeo']!='')
			{
				$metaTitleMantan= $data['Product']['nameSeo'];
			}
			
			if(isset($seoProduct['Option']['value']['detail']['keyword']) && $seoProduct['Option']['value']['detail']['keyword']!='')
			{
				$metaKeywordsMantan= str_replace('%title%', $metaTitleMantanDefault, $seoProduct['Option']['value']['detail']['keyword']);
				$metaKeywordsMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaKeywordsMantan);
				$metaKeywordsMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaKeywordsMantan);
				
				$metaKeywordsMantan= str_replace('%productName%', $data['Product']['title'], $metaKeywordsMantan);
				$metaKeywordsMantan= str_replace('%productKeyword%', $data['Product']['key'], $metaKeywordsMantan);
				$metaKeywordsMantan= str_replace('%productDescription%', $data['Product']['description'], $metaKeywordsMantan);
			}
			
			if(isset($seoProduct['Option']['value']['detail']['description']) && $seoProduct['Option']['value']['detail']['description']!='')
			{
				$metaDescriptionMantan= str_replace('%title%', $metaTitleMantanDefault, $seoProduct['Option']['value']['detail']['description']);
				$metaDescriptionMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaDescriptionMantan);
				$metaDescriptionMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaDescriptionMantan);
				
				$metaDescriptionMantan= str_replace('%productName%', $data['Product']['title'], $metaDescriptionMantan);
				$metaDescriptionMantan= str_replace('%productKeyword%', $data['Product']['key'], $metaDescriptionMantan);
				$metaDescriptionMantan= str_replace('%productDescription%', $data['Product']['description'], $metaDescriptionMantan);
			}
		}
		
		$settingProduct= $modelOption->getOption('settingProduct');
		$listManufacturer= $modelOption->getOption('productManufacturer');
		$listProperties= $modelOption->getOption('propertiesProduct');

		if(isset($listManufacturer['Option']['value']['category'])){
			if(isset($data['Product']['manufacturerId'])){
				$infoManufacturer= $modelProduct->getcat($listManufacturer['Option']['value']['category'],$data['Product']['manufacturerId']);
			}else{
				$infoManufacturer= array();
			}

			$listRoot['sub']= $listManufacturer['Option']['value']['category'];
		}else{
			$infoManufacturer= array();
			$listRoot['sub']= array();
		}

		if(isset($infoManufacturer['id'])){
			$infoParentManufacturer= getParentCat($listRoot,$infoManufacturer['id']);
		}else{
			$infoParentManufacturer= array();
		}

		setVariable('data',$data);
		setVariable('listTypeMoney',$listTypeMoney);
		setVariable('settingProduct',$settingProduct);
		setVariable('infoManufacturer',$infoManufacturer);
		setVariable('infoParentManufacturer',$infoParentManufacturer);
		setVariable('otherData',$otherData);
		setVariable('listProperties',$listProperties);
	}

	function checkLogin($input)
	{
		global $urlHomes;
		$input['request']->data= arrayMap($input['request']->data);
		$modelUser= new User();
		
		if(isset($input['request']->data['username']) && isset($input['request']->data['password'])){
			$username= $input['request']->data['username'];
			$password= md5($input['request']->data['password']);
			
			$user= $modelUser->checkLogin($username,$password);
			if($user){
				$_SESSION['infoUser']= $user;
				$modelUser->redirect($urlHomes);
			}else{ 
				$modelUser->redirect(getLinkLogin().'?status=-1');
			}
		}else{
			$modelUser->redirect($urlHomes);
		}
	}
    
    function history($input)
    {
        global $urlHomes;
        global $urlNow;
		$modelOrder= new Order();
        
        if(isset($_SESSION['infoUser'])){
            $page= (isset($_GET['page']))? (int) $_GET['page']:1;
        	if($page<=0) $page=1;
        	$limit= 15;
        	$conditions= array();

        	$conditions['email']= $_SESSION['infoUser']['User']['email'];

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
				if(count($_GET)>1){
					$urlPage= $urlPage.'&page=';
				}else{
					$urlPage= $urlPage.'page=';
				}
			}else{
				$urlPage= $urlPage.'?page=';
			}

			if( ($page-2)>0 ) $headPage=$page-2;else $headPage=1;
			if( ($page+2) <= $totalPage) $endPage=$page+2;else $endPage=$totalPage;
                
			setVariable('listData',$listData);

			setVariable('page',$page);
			setVariable('totalPage',$totalPage);
			setVariable('back',$back);
			setVariable('next',$next);
			setVariable('urlPage',$urlPage);
            setVariable('headPage',$headPage);
            setVariable('endPage',$endPage);
        }else{
            $modelOrder->redirect($urlHomes);
        }
    }
    
	function saveUser($input)
	{
		global $urlHomes;
		global $isRequestPost;
		global $contactSite;
		global $smtpSite;
		global $modelOption;
		global $urlLocal;
		global $languageProduct;

		$input['request']->data= arrayMap($input['request']->data);
		$modelUser= new User();
		$dataSend= $input['request']->data;

		if(isset($dataSend['fullname']) && isset($dataSend['username']) && isset($dataSend['email']) && isset($dataSend['phone']) && isset($dataSend['address']) && isset($dataSend['password']) && isset($dataSend['passwordAgain'])){
			$save= array();
	
			$save['User']['fullname']= $dataSend['fullname'];
			$save['User']['user']= $dataSend['username'];
			$save['User']['email']= $dataSend['email'];
			$save['User']['phone']= $dataSend['phone'];
			$save['User']['address']= $dataSend['address'];
            $save['User']['birthday']= (isset($dataSend['birthday']))?$dataSend['birthday']:'';
			if($dataSend['password']==$dataSend['passwordAgain'] && $dataSend['password']!='')
			{
				$save['User']['password']= md5($dataSend['password']);
				
				if($save['User']['fullname']!='' && $save['User']['user']!='' && $save['User']['email']!='' && $save['User']['phone']!='' && $save['User']['address']!='')
				{
					$checkUserName= $modelUser->getUserCode($save['User']['user']);
					if(!$checkUserName)
					{
						$modelUser->save($save);

						// send email for user and admin
						$from= array($contactSite['Option']['value']['email'] =>  $smtpSite['Option']['value']['show']);
						$to= array(trim($dataSend['email']),trim($contactSite['Option']['value']['email']));
						$cc= array();
						$bcc= array();
						$subject= '['.$smtpSite['Option']['value']['show'].'] '.$languageProduct['RegisterSuccess'];
						
						$content= getContentEmailRegisterSuccess($dataSend);

						$modelOption->sendMail($from,$to,$cc,$bcc,$subject,$content);
                        
                        $username= $dataSend['username'];
            			$password= md5($dataSend['password']);
            			
            			$user= $modelUser->checkLogin($username,$password);
            			if($user){
            				$_SESSION['infoUser']= $user;
            				$modelUser->redirect($urlHomes);
            			}
                        
						$modelUser->redirect(getLinkRegister().'?status=1');
					}
					else $modelUser->redirect(getLinkRegister().'?status=-2');
				}
				else $modelUser->redirect(getLinkRegister().'?status=-1');
			}
			else $modelUser->redirect(getLinkRegister().'?status=-3');
		}else{
			$modelUser->redirect($urlHomes);
		}
	}

	function logout($input)
	{
		global $urlHomes;
		global $modelOption;

		session_destroy();
		$modelOption->redirect($urlHomes);
	}

	function cart()
	{
		global $modelOption;
		$listTypeMoney= $modelOption->getOption('productTypeMoney');
		$productTransportFee= $modelOption->getOption('productTransportFee');
		$listProperties= $modelOption->getOption('propertiesProduct');

		$listOrderProduct= (isset($_SESSION['orderProducts']))? $_SESSION['orderProducts']:array();
		$infoUser= (isset($_SESSION['infoUser']))? $_SESSION['infoUser']:array();

		setVariable('listTypeMoney',$listTypeMoney);
		setVariable('productTransportFee',$productTransportFee);
		setVariable('listProperties',$listProperties);

		setVariable('listOrderProduct',$listOrderProduct);
		setVariable('infoUser',$infoUser);
	}

	// Process order
	function saveOrderProduct_addProduct($input)
	{
		global $urlHomes;
		global $isRequestPost;

		$modelProduct= new Product();

		if($isRequestPost){
			$dataSend= arrayMap($input['request']->data);
			$product= $modelProduct->getProduct($dataSend['id']);

			$listOrderProduct= (isset($_SESSION['orderProducts']))?$_SESSION['orderProducts']:array();

			if($product)
			{
				$today= getdate();

				if(isset($product['Product']['codeDiscount']) &&  
					isset($product['Product']['dateDiscountStart']) && 
					isset($product['Product']['dateDiscountEnd']) &&
					isset($_SESSION['codeDiscountInput']) &&
					$_SESSION['codeDiscountInput']!='' && 
					in_array(strtoupper($_SESSION['codeDiscountInput']), $product['Product']['codeDiscount']) && 
					$today[0]>= $product['Product']['dateDiscountStart'] && 
					$today[0]<= $product['Product']['dateDiscountEnd'])
				{
					$product['Product']['codeDiscountInput']= $_SESSION['codeDiscountInput'];
				}

				if(!empty($dataSend['properties'])){
					$dataSend['properties'] = str_replace('&quot;', '"', $dataSend['properties']);
					$product['Product']['propertiesSelect'] = json_decode($dataSend['properties'], true);
				}else{
					$product['Product']['propertiesSelect'] = [];
				}
				

				if(empty($_POST['numberOrder'])) $_POST['numberOrder']=1;

				$product['Product']['numberOrder']= (int) $_POST['numberOrder'];
				$product['Product']['dataSend']= $dataSend;
				$listOrderProduct[]= $product;
				

				$_SESSION['orderProducts']= $listOrderProduct;
			}
			
			if(!empty($dataSend['linkRedirect'])){
				$modelProduct->redirect($dataSend['linkRedirect']);
			}else{
				echo count($listOrderProduct);
			}
		}
	}

	function saveOrderProduct_addOrder($input)
	{
		global $urlHomes;
		global $isRequestPost;
		global $modelOption;
		global $smtpSite;
		global $contactSite;
		global $urlLocal;
		global $languageProduct;
        global $settingProduct;

		$modelOrder= new Order();
		$modelProduct= new Product();

		if($isRequestPost){

			$dataSend= arrayMap($input['request']->data);

			$fullname= $dataSend['fullname'];
			$email= $dataSend['email'];
			$phone= $dataSend['phone'];
			$address= $dataSend['address'];
			$note= $dataSend['note'];
			$userId= (isset($dataSend['userId']))?$dataSend['userId']:'';
			$district= (isset($dataSend['district']))?$dataSend['district']:'';
		
			$listOrderProduct= (isset($_SESSION['orderProducts']))?$_SESSION['orderProducts']:array();
			$totalMoney= 0;
			$totalMass= 0;
			$productTransportFee= $modelOption->getOption('productTransportFee');
			
			if($fullname!='' && $phone!='' && count($listOrderProduct)>0)
			{
				$listProduct= array();
				foreach($listOrderProduct as $data)
				{
					if(isset($data['Product']['codeDiscountInput']) && $data['Product']['codeDiscountInput']!='' && in_array($data['Product']['codeDiscountInput'], $data['Product']['codeDiscount']))
					{
						$listProduct[]= array(  'id'=>$data['Product']['id'],
                                                'mass'=>$data['Product']['mass'],
                                                'number'=>$data['Product']['numberOrder'],
                                                'price'=>$data['Product']['priceDiscount'],
                                                'codeDiscount'=>$data['Product']['codeDiscountInput'],
                                                'name'=>$data['Product']['title'],
                                                'image'=>@$data['Product']['images'][0],
                                                'propertiesSelect'=>@$data['Product']['propertiesSelect'],
                                            );
						$priceShow= $data['Product']['priceDiscount'];

						$updateProduct= array();
						$updateProduct['$inc']['numberDiscountActive']= 1;
						$dkProduct= array('_id'=>new MongoId($data['Product']['id']) );
						$modelProduct->create();
						$modelProduct->updateAll($updateProduct,$dkProduct);
					}
					else
					{
						$listProduct[]= array(  'id'=>$data['Product']['id'],
                                                'mass'=>$data['Product']['mass'],
                                                'number'=>$data['Product']['numberOrder'],
                                                'price'=>$data['Product']['price'],
                                                'name'=>$data['Product']['title'],
                                                'image'=>@$data['Product']['images'][0],
                                                'propertiesSelect'=>@$data['Product']['propertiesSelect'],
                                            );
						$priceShow= $data['Product']['price'];
					}

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
				$content= getContentEmailOrderSuccess($fullname,$email,$phone,$address,$note,$listTypeMoney,$transportFee);

				$modelOrder->sendMail($from,$to,$cc,$bcc,$subject,$content);

				unset($_SESSION['orderProducts']); 
				unset($_SESSION['codeDiscountInput']); 

				if(function_exists('createPayNL')){
					createPayNL($totalMoney, $fullname, $phone, $email, $idOrder);
					die;
				}
				
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

	function saveOrderProduct_clearCart($input)
	{
		unset($_SESSION['orderProducts']); 
		echo 1;
	}

	function saveOrderProduct_deleteProductCart($input)
	{
		if(isset($input['request']->data['key']) &&  !empty($_SESSION['orderProducts'][$input['request']->data['key']])){
			unset($_SESSION['orderProducts'][$input['request']->data['key']]);
		}
		 
		echo 1;
	}

	function saveOrderProduct_reloadOrder($input)
	{
		global $urlHomes;
		global $isRequestPost;

		$modelOrder= new Order();
		$modelProduct= new Product();

		if($isRequestPost){
			$dataSend= arrayMap($input['request']->data);

			$listOrderProduct= $_SESSION['orderProducts'];
			$today= getdate();

			foreach($listOrderProduct as $key=>$data)
			{
				$listOrderProduct[$key]['Product']['numberOrder']= (isset($dataSend['quantity'.$key]))? (int) $dataSend['quantity'.$key]:1;
				$product= $modelProduct->getProduct($data['Product']['id']);
				if(isset($data['Product']['codeDiscount']) &&  
					isset($data['Product']['dateDiscountStart']) && 
					isset($data['Product']['dateDiscountEnd']) &&
					isset($dataSend['codeDiscount']) &&
					$dataSend['codeDiscount']!='' && 
					in_array(strtoupper($dataSend['codeDiscount']), $data['Product']['codeDiscount']) && 
					$today[0]>= $data['Product']['dateDiscountStart'] && 
					$today[0]<= $data['Product']['dateDiscountEnd']&&
					$product['Product']['numberDiscountActive']<$product['Product']['numberDiscount']
				)
				{
					$listOrderProduct[$key]['Product']['codeDiscountInput']= $dataSend['codeDiscount'];
					$_SESSION['codeDiscountInput']= $dataSend['codeDiscount'];
				}else{
					unset($_SESSION['codeDiscountInput']);
					unset($listOrderProduct[$key]['Product']['codeDiscountInput']);
				}
			}
			$_SESSION['orderProducts']= $listOrderProduct;
			
			$modelProduct->redirect(getLinkCart());
		}
	}

	// API
	function syncMoneyApi($input)
	{
		global $urlHomes;
		global $isRequestPost;
		global $modelOption;

		if($isRequestPost){
			$dataSend= arrayMap($input['request']->data);
			$listTypeMoney= null;

			$settingProduct= $modelOption->getOption('settingProduct');
			if(isset($dataSend['pass']) && isset($settingProduct['Option']['value']['passSynch']) && $dataSend['pass']==$settingProduct['Option']['value']['passSynch'] && $settingProduct['Option']['value']['passSynch']!=''){
				$listTypeMoney= $modelOption->getOption('productTypeMoney');
			}

			setVariable('listTypeMoney',$listTypeMoney);
		}else{
			$modelOption->redirect($urlHomes);
		}

	}

	function syncManufacturerApi($input)
	{
		global $urlHomes;
		global $isRequestPost;
		global $modelOption;

		if($isRequestPost){
			$dataSend= arrayMap($input['request']->data);
			$listManufacturer= null;

			$settingProduct= $modelOption->getOption('settingProduct');
			if(isset($dataSend['pass']) && isset($settingProduct['Option']['value']['passSynch']) && $dataSend['pass']==$settingProduct['Option']['value']['passSynch'] && $settingProduct['Option']['value']['passSynch']!=''){
				$listManufacturer= $modelOption->getOption('productManufacturer');
			}

			setVariable('listManufacturer',$listManufacturer);
		}else{
			$modelOption->redirect($urlHomes);
		}

	}

	function syncCategoryApi($input)
	{
		global $urlHomes;
		global $isRequestPost;
		global $modelOption;

		if($isRequestPost){
			$dataSend= arrayMap($input['request']->data);
			$listCategory= null;

			$settingProduct= $modelOption->getOption('settingProduct');
			if(isset($dataSend['pass']) && isset($settingProduct['Option']['value']['passSynch']) && $dataSend['pass']==$settingProduct['Option']['value']['passSynch'] && $settingProduct['Option']['value']['passSynch']!=''){
				$listCategory= $modelOption->getOption('productCategory');
			}

			setVariable('listCategory',$listCategory);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function syncAdditionalAttributesApi($input)
	{
		global $urlHomes;
		global $isRequestPost;
		global $modelOption;

		if($isRequestPost){
			$dataSend= arrayMap($input['request']->data);
			$listProperties= null;

			$settingProduct= $modelOption->getOption('settingProduct');
			if(isset($dataSend['pass']) && isset($settingProduct['Option']['value']['passSynch']) && $dataSend['pass']==$settingProduct['Option']['value']['passSynch'] && $settingProduct['Option']['value']['passSynch']!=''){
				$listProperties= $modelOption->getOption('propertiesProduct');
			}

			setVariable('listProperties',$listProperties);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function syncProductApi($input)
	{
		global $urlHomes;
		global $isRequestPost;
		global $modelOption;

		if($isRequestPost){
			$dataSend= arrayMap($input['request']->data);
			$listData= null;

			$settingProduct= $modelOption->getOption('settingProduct');

			if(isset($dataSend['pass']) && isset($settingProduct['Option']['value']['passSynch']) && $dataSend['pass']==$settingProduct['Option']['value']['passSynch'] && $settingProduct['Option']['value']['passSynch']!=''){
				$modelProduct= new Product();
				
				$page= null;
				$limit= null; 

				$conditions= array();

				if(!empty($dataSend['category'])){
					$dataCategory= array();
					foreach($dataSend['category'] as $category){
						$dataCategory[]= (int) $category;
					}
					$conditions['category']= array('$in'=>$dataCategory);
				}

				if(!empty($dataSend['manufacturer'])){
					$dataManufacturer= array();
					foreach($dataSend['manufacturer'] as $category){
						$dataManufacturer[]= (int) $category;
					}
					$conditions['manufacturerId']= array('$in'=>$dataManufacturer);
				}

				$listData= $modelProduct->find('all',array('conditions' => $conditions,'order' => array('created' => 'asc')));
			}
			
			setVariable('listData',$listData);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function searchAjax($input)
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
		setVariable('listData',$listData);
	}

?>