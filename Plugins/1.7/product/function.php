<?php
	global $urlLocal;
	global $modelOption;
	global $languageProduct;
    global $settingProduct;
	
	$settingProduct= $modelOption->getOption('settingProduct');
	if(!isset($settingProduct['Option']['value']['language'])) $settingProduct['Option']['value']['language']= 'en.php';
	include($urlLocal['urlLocalPlugin'].'product/language/'.$settingProduct['Option']['value']['language']);

// Tạo meunu
	$menus= array();
	$menus[0]['title']= $languageProduct['Products'];
	
    $menus[0]['sub'][0]= array('name'=>$languageProduct['ProductList'],'url'=>$urlPlugins.'admin/product-product-listProduct.php','permission'=>'listProduct');			   
    $menus[0]['sub'][1]= array('name'=>$languageProduct['Orders'],'url'=>$urlPlugins.'admin/product-order-listOrder.php','permission'=>'listOrderProduct');
    $menus[0]['sub'][2]= array('name'=>$languageProduct['Customers'],'url'=>$urlPlugins.'admin/product-user-listUser.php','permission'=>'listUserProduct');
    $menus[0]['sub'][3]= array(  'name'=>$languageProduct['ProductSettings'],
			    				 'url'=>$urlPlugins.'admin/product-setting-settingProduct.php',
			    				 'sub'=>array( array('name'=>$languageProduct['GeneralSettings'],'url'=>$urlPlugins.'admin/product-setting-settingProduct.php','permission'=>'settingProduct'),
			    							   array('name'=>$languageProduct['ProductCategory'],'url'=>$urlPlugins.'admin/product-category-listCategory.php','permission'=>'listCategoryProduct'),
			    							   array('name'=>$languageProduct['ManufacturerSettings'],'url'=>$urlPlugins.'admin/product-manufacturer-listManufacturer.php','permission'=>'listManufacturerProduct'),
			    							   array('name'=>$languageProduct['MoneySettings'],'url'=>$urlPlugins.'admin/product-typeMoney-listTypeMoney.php','permission'=>'listTypeMoneyProduct'),
			    							   array('name'=>$languageProduct['TransportFee'],'url'=>$urlPlugins.'admin/product-transportFee-listTransportFee.php','permission'=>'listTransportFeeProduct'),
			    							   array('name'=>$languageProduct['AdditionalAttributes'],'url'=>$urlPlugins.'admin/product-properties-listProperties.php','permission'=>'listPropertiesProduct'),
			    							   array('name'=>$languageProduct['SeoSettings'],'url'=>$urlPlugins.'admin/product-seo-settingSeo.php','permission'=>'settingSeoProduct'),
			    							   array('name'=>$languageProduct['SitemapSettings'],'url'=>$urlPlugins.'admin/product-sitemap-settingSitemap.php','permission'=>'settingSitemapProduct'),
			    							) ,
								'permission'=>'settingProduct'
			    			   );
    $menus[0]['sub'][4]= array(  'name'=>$languageProduct['SyncDatabase'],
			    				 'url'=>$urlPlugins.'admin/product-sync-syncProduct.php',
			    				 'sub'=>array( array('name'=>$languageProduct['SyncProduct'],'url'=>$urlPlugins.'admin/product-sync-syncProduct.php','permission'=>'syncProduct'),
			    							   array('name'=>$languageProduct['SyncCategory'],'url'=>$urlPlugins.'admin/product-sync-syncCategory.php','permission'=>'syncCategoryProduct'),
			    							   array('name'=>$languageProduct['SyncManufacturer'],'url'=>$urlPlugins.'admin/product-sync-syncManufacturer.php','permission'=>'syncManufacturerProduct'),
			    							   array('name'=>$languageProduct['SyncMoney'],'url'=>$urlPlugins.'admin/product-sync-syncMoney.php','permission'=>'syncMoneyProduct'),
			    							   array('name'=>$languageProduct['SyncAdditionalAttributes'],'url'=>$urlPlugins.'admin/product-sync-syncAdditionalAttributes.php','permission'=>'syncAdditionalAttributesProduct')
			    							) ,
			    				 'permission'=>'SyncDatabaseProduct'
			    			   );
    
    addMenuAdminMantan($menus);
	
	// Add menus Appearance
    $productCategory= $modelOption->getOption('productCategory');

    if(isset($productCategory['Option']['value']['category'])){
	    $category= array(array( 'title'=>'Category Product',
								'sub'=>changeTypeCategory($productCategory['Option']['value']['category'],getLinkCat())
								),
	    				array(  'title'=>'Page Product',
                                'sub'=>array(
                                                array (
                                                  'url' => getLinkDiscount(),
                                                  'name' => $languageProduct['Discounts']
                                                ),
                                                array (
                                                  'url' => getLinkCart(),
                                                  'name' => $languageProduct['Cart']
                                                ),
                                                array (
                                                  'url' => getLinkLogin(),
                                                  'name' => $languageProduct['Login']
                                                ),
                                                array (
                                                  'url' => getLinklogout(),
                                                  'name' => $languageProduct['Logout']
                                                ),
                                                array (
                                                  'url' => getLinkRegister(),
                                                  'name' => $languageProduct['Register']
                                                ),
                                                array (
                                                  'url' => getLinkSearch(),
                                                  'name' => $languageProduct['Search']
                                                ),
                                                array (
                                                  'url' => getLinkAllProduct(),
                                                  'name' => $languageProduct['AllProduct']
                                                ),
                                            )
                                )
							);
		addMenusAppearance($category);
	}
	
	function changeTypeCategory($category,$link)
	{
		foreach($category as $key=>$cat)
        {
        	$category[$key]= array  ( 'url' => $link.$cat['slug'].'.html',
								      'name' => $cat['name']
								    );
		    if(isset($cat['sub']) && count($cat['sub'])>0)
		    {
		    	$category[$key]['sub']= changeTypeCategory($cat['sub'],$link);
		    }
        }
        return $category;
	}
	// Chuyen mang danh muc SP da cap ve mang binh thuong
	function changeTypeCategoryToList($category,$parent,$link)
	{
		foreach($category as $key=>$cat)
        {
        	$category[$key]= array  ( 'id' => $key,
        							  'url' => $link.$cat['slug'].'.html',
								      'name' => $cat['name'],
								      'parent' => $parent,
								    );
		    if(isset($cat['sub']) && count($cat['sub'])>0)
		    {
		    	$category=$category+changeTypeCategoryToList($cat['sub'],$cat['id'],$link);
		    }
        }
        return $category;
	}
	// get List Category
	function getListCategory()
	{
		global $urlPlugins;
		global $modelOption;
		global $urlHomes;
		
		$listData= $modelOption->getOption('productCategory');
		$linkCat= getLinkCat();

		if(isset($listData['Option']['value']['category']) && count($listData['Option']['value']['category'])>0){
			foreach($listData['Option']['value']['category'] as $key=>$cat){
				$listData['Option']['value']['category'][$key]['url']= $linkCat.$cat['slug'].'.html';

				if(isset($cat['sub']) && count($cat['sub'])>0){
					foreach($cat['sub'] as $keySub=>$sub){
						$listData['Option']['value']['category'][$key]['sub'][$keySub]['url']= $linkCat.$sub['slug'].'.html';
					}
				}
			}
		}

		return $listData;
	}
	
	// get List Manufacturer
	function getListManufacturer()
	{
		global $modelOption;
		global $urlHomes;

		$listData= $modelOption->getOption('productManufacturer');
		$linkManufacturer= getLinkManufacturer();
		
		if(isset($listData['Option']['value']['category']) && count($listData['Option']['value']['category'])>0){
			foreach($listData['Option']['value']['category'] as $key=>$components)
			{
				if(!isset($components['image']) || $components['image']=='')
				{
					$listData['Option']['value']['category'][$key]['image']= $urlHomes.'/app/Plugin/product/images/150x150.gif';
				}

				$listData['Option']['value']['category'][$key]['url']= $linkManufacturer.$components['slug'].'.html';
			}
		}

		return $listData;
	}
	
	// get List Name Manufacturer
	function getListNameManufacturer()
	{
		global $modelOption;
		global $urlHomes;
		
		$listData= $modelOption->getOption('productManufacturer');
		$linkManufacturer= getLinkManufacturer();
		
		if(isset($listData['Option']['value']['category']) && count($listData['Option']['value']['category'])>0){
			
			foreach($listData['Option']['value']['category'] as $key=>$cat){
			
				$listData['Option']['value']['category'][$key]['urlManufacturer']= $linkManufacturer.$cat['slug'].'.html';

				if(isset($cat['sub']) && count($cat['sub'])>0){
				
					foreach($cat['sub'] as $keySub=>$sub){
					
						$listData['Option']['value']['category'][$key]['sub'][$keySub]['urlManufacturer']= $linkManufacturer.$sub['slug'].'.html';
					
						if(isset($sub['sub']) && count($sub['sub'])>0){
							foreach($sub['sub'] as $keySub2=>$sub2){
					
								$listData['Option']['value']['category'][$key]['sub'][$keySub]['sub'][$keySub2]['urlManufacturer']= $linkManufacturer.$sub2['slug'].'.html';
							
							}
						}
					}
				}
			}
		}

		return $listData;
	}
	
	// Vi du form Tim kiem don gian
	function showFormSearch()
	{
		global $urlHomes;
		echo '<form id="searchbox" action="'.getLinkSearch().'" method="get">
				<p>
				  <label for="search_query_top">
				  </label>
				  <input type="text" name="key" id="search_query_top" class="search_query ac_input" placeholder="Nhập sản phẩm cần tìm" value="'.@$_GET['key'].'">
				</p>
			  </form>';
	}
	
	
	function showListCategorySelect($cat,$sau,$nameInput)
	{
		if($cat['id']>0)
		{
			echo '<p style="padding-left: 10px;"  >';
			for($i=1;$i<=$sau;$i++)
			{
				echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			}
			if(isset($_GET[$nameInput.$cat['id']]) && $_GET[$nameInput.$cat['id']]==$cat['id'] )
			{
				echo '<input type="checkbox" checked="checked" name="'.$nameInput.$cat['id'].'" value="'.$cat['id'].'" />&nbsp&nbsp'.$cat['name'];
			}
			else
			{
				echo '<input type="checkbox" name="'.$nameInput.$cat['id'].'" value="'.$cat['id'].'" />&nbsp&nbsp'.$cat['name'];
			}
			echo '</p>';
		}

		if(isset($cat['sub']) && count($cat['sub'])>0){
			foreach($cat['sub'] as $sub)
			{
				showListCategorySelect($sub,$sau+1,$nameInput);
			}
		}
	}
	
	function showThumbCategoryActive($urlPlugins)
	{
		$modelOption= new Option();
		$listData= $modelOption->getOption('productCategory');
		$urlProductCategory= getLinkCat();
		foreach($listData['Option']['value']['category'] as $cat)
		{
			if($cat['show'])
			{
				echo '  <div class="col-sm-4">
							<h2>Sản phẩm <span class="standout">'.$cat['name'].'</span></h2>
							<div class="figure-wrapper">
								<figure>
									<img class="img-responsive" src="'.$cat['image'].'" alt="">
									<figcaption>
										<h3>'.$cat['name'].'</h3>
										<span>'.$cat['description'].'</span>
										<a href="'.$urlProductCategory.$cat['slug'].'.html">Xem chi tiết</a>
									</figcaption>
								</figure>
							</div><!-- / figure-wrapper -->
						</div><!-- / col-sm-4 -->';
			}

		}
	}
	
	function getListProduct($limit,$conditions)
	{
		global $urlHomes;
		global $infoSite;
		
		$modelProduct= new Product();
		$modelOption= new Option();
		
		$conditions['lock']= 0;
		
		$listData= $modelProduct->getPage(1,$limit,$conditions);
		$listTypeMoney= $modelOption->getOption('productTypeMoney');
		$linkProduct= getLinkProduct();
		
		if($listData)
		{ 
			$number= -1;
			foreach($listData as $news)
			{ 
				$number++;
				if(!isset($news['Product']['images'][0]))
				{
					$listData[$number]['Product']['images'][0]= $urlHomes.'/app/Plugin/product/images/no_image-100x100.jpg';
				}	
				$listData[$number]['Product']['urlProductDetail']= $linkProduct.$news['Product']['slug'].'.html';
			}
		}

		return $listData;
	}
// Lay thu muc cha cua thu muc con da biet
	function getParentCat($cats,$idCat)
	{
		if(isset($cats['sub'][$idCat]))
		{
			return $cats;
		}
		else
		{
			if(isset($cats['sub']) && count($cats['sub'])>0){
				foreach($cats['sub'] as $cat)
				{
					$return= getParentCat($cat,$idCat);
					if($return) return $return;
				}
			}
		}
		return null;
	}	
// Lay danh sach ID cac muc con trong mot muc cha
	function getIdInParentCat($cats= array(),$listId= array())
	{
		if(count($cats)>0){
			foreach($cats as $cat)
			{
				array_push($listId, $cat['id']);
				if(isset($cat['sub']))
				{
					$listId= getIdInParentCat($cat['sub'],$listId);
				}
			}
		}
		return $listId;
	}
// Tao slug
	function createSlug($key)
	{
		$marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
		"ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
		,"ế","ệ","ể","ễ",
		"ì","í","ị","ỉ","ĩ",
		"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
		,"ờ","ớ","ợ","ở","ỡ",
		"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
		"ỳ","ý","ỵ","ỷ","ỹ",
		"đ",
		"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
		,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
		"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
		"Ì","Í","Ị","Ỉ","Ĩ",
		"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
		,"Ờ","Ớ","Ợ","Ở","Ỡ",
		"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
		"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
		"Đ"," ","·","/","_",",",":",";",".");
		
		$marKoDau=array("a","a","a","a","a","a","a","a","a","a","a"
		,"a","a","a","a","a","a",
		"e","e","e","e","e","e","e","e","e","e","e",
		"i","i","i","i","i",
		"o","o","o","o","o","o","o","o","o","o","o","o"
		,"o","o","o","o","o",
		"u","u","u","u","u","u","u","u","u","u","u",
		"y","y","y","y","y",
		"d",
		"A","A","A","A","A","A","A","A","A","A","A","A"
		,"A","A","A","A","A",
		"E","E","E","E","E","E","E","E","E","E","E",
		"I","I","I","I","I",
		"O","O","O","O","O","O","O","O","O","O","O","O"
		,"O","O","O","O","O",
		"U","U","U","U","U","U","U","U","U","U","U",
		"Y","Y","Y","Y","Y",
		"D","-","-","-","-","-","-","-","");
		
		$key= str_replace($marTViet,$marKoDau,$key);
		return strtolower($key);
	}
// Lay danh sach sub ID cua category
	function getSubIdCategory($category,$listId)
	{
		if(isset($category['sub']) && count($category['sub'])>0)
		{
			foreach($category['sub'] as $sub)
			{
				array_push($listId, $sub['id']);
				$listId= getSubIdCategory($sub,$listId);
			}
		}
		return $listId;
	}
// Chuyen doi category dang cay sang dang thuong
	function convertCategoryMantan($cats= array(),$listCatNew=array())
	{
		if(count($cats)>0){
			foreach($cats as $cat)
			{
				if(isset($cat['sub'])){
					$sub= $cat['sub'];
					unset($cat['sub']);
					
					if(count($sub)>0)
					{
						$listCatNew= convertCategoryMantan($sub,$listCatNew);
					}
				}
				$listCatNew[ $cat['id'] ]= $cat;
			}
		}

		return $listCatNew;
	}

	function deleteCat($cats=array(),$idCatEdit,$parentNew,$parentOld)
   {
		$dem= -1;
		$ok= false;

		if(count($cats)>0){
	   		foreach($cats as $key=>$cat)
	   		{
	   			$dem++;
	   			if($parentNew!=$parentOld && $cat['id']==$idCatEdit){
	   				$ok=true;
	   				break;
	   			}else{
	   				if(isset($cat['sub'])){
	   					$cats[ $key ]['sub']= deleteCat($cat['sub'],$idCatEdit,$parentNew,$cat['id']);	
	   				}   			
	   			}
	   		}
   		}

		if($ok)
		{
			$tg= array();
			$dem2= -1;
			foreach($cats as $key2=>$cm)
			{
				$dem2++;
				if($cm['id'] != $cat['id'])
				{
					$tg[$key2]= $cm;
				}
			}
			$cats= $tg;
		}
   		return $cats;
   }

   function addCat($cats=array(),$parent,$save,$number=0)
   {
   		
   		$parent= (int) $parent;
   		
   		if($parent==0)
   		{
   			$check= true;
   			foreach($cats as $key=>$cat)
	   		{
		   		if(  $cat['id']==$save['id'] )
		   		{
			   		$cats[ $key ]= $save;
			   		$check= false;
			   		break;
		   		}
	   		}
	   		if($check)
	   		{
	   			$cats[$save['id']]= $save;
   			}
   		}else{
   			$dem= -1;
   			if(count($cats)>0){
	   			foreach($cats as $key=>$cat)
	   			{
	   				$dem++;
	   				if(isset($cat['id']) && $cat['id']==$parent)
	   				{
	   					$check= true;
	   					$demSub= -1;

	   					if(isset($cat['sub']) && count($cat['sub'])>0){
		   					foreach($cat['sub'] as $keySub=>$sub)
		   					{
		   						$demSub++;
			   					if($sub['id']==$save['id'])
			   					{
				   					$cats[ $key ]['sub'][ $keySub ]= $save;
				   					$check= false;
				   					break;
			   					}
		   					}
	   					}
	   					
	   					if($check)
	   					{
		   					$cats[ $key ]['sub'][ $save['id'] ]= $save;
		   					break;
	   					}
	   				}
	   				else
	   				{
	   					if(isset($cat['sub'])){
	   						$cats[ $key ]['sub']= addCat($cat['sub'],$parent,$save,$number+1);	
	   					}
	   				}
	   			}
   			}
   		}
   		return $cats;
   }
	   
	function getcat($cats=array(),$idCat)
   	{
   		if(count($cats)>0){
			foreach($cats as $cat)
			{
				if($cat['id']==$idCat)
				{
					return $cat;
				}
				else
				{
					if(isset($cat['sub'])){
						$return= getcat($cat['sub'],$idCat);
					}

					if(isset($return)) return $return;
				}
			}
		}
		return null;
	}
	
   function sapXepCat($type,$idMenu,$cats)
   {
       if($cats[$idMenu])
       {
       	   $valueArray= array_values( $cats );
       	   $keyArray= array_keys( $cats );
       	   $dem= count($valueArray);
       	   
       	   
       	   for($i=0;$i<$dem;$i++)
       	   {
	       		if($valueArray[$i]['id']==$idMenu)
	       		{
	       			$catNew= array();
		       		switch($type)
		       		{
			       		case 'top': if($i>0)
			       					{
				       					for($j=0;$j<($i-1);$j++)
				       					{
					       					$catNew[ $keyArray[$j] ]= $valueArray[$j];
				       					}
				       					$catNew[ $keyArray[$i] ]= $valueArray[$i];
				       					$catNew[ $keyArray[$i-1] ]= $valueArray[$i-1];
				       					for($j=($i+1);$j<$dem;$j++)
				       					{
					       					$catNew[ $keyArray[$j] ]= $valueArray[$j];
				       					}
			       					}
			       					break;
			       		case 'bottom':  if($i<($dem-1) )
			       						{
				       						for($j=0;$j<=($i-1);$j++)
					       					{
						       					$catNew[ $keyArray[$j] ]= $valueArray[$j];
					       					}
					       					$catNew[ $keyArray[$i+1] ]= $valueArray[$i+1];
					       					$catNew[ $keyArray[$i] ]= $valueArray[$i];
					       					
					       					for($j=($i+2);$j<$dem;$j++)
					       					{
						       					$catNew[ $keyArray[$j] ]= $valueArray[$j];
					       					}
			       						}
			       						break;
		       		}
		       		break;
	       		}	   
       	   }
       	   
       	   if($catNew) $cats= $catNew;
       	   
       }
       else
       {
	       foreach($cats as $key=>$cat)
	       {
		       $cats[$key]['sub']= sapXepCat($type,$idMenu,$cats[$key]['sub']);
	       }
       }
       return $cats;
       
   }
   
   function getNumberSlugCategory($cats=array(),$slug='',$number=0)
   {
   		if(count($cats)>0){
		    foreach($cats as $cat)
			{
				if(strpos($cat['slug'],$slug)!== false)
				{
					$number++;
				}
				
				if(isset($cat['sub']))
				{
					$number= getNumberSlugCategory($cat['sub'],$slug,$number);
				}
			}
		}
		return $number;
   }

	function getContentEmailRegisterSuccess($dataSend)
   	{
   		global $languageProduct;

   		if(function_exists('getContentEmailRegisterSuccessTheme')){
			return getContentEmailRegisterSuccessTheme($dataSend);
		}

   		global $urlHomes;
		global $modelOption;
		global $urlLocal;

		$content= $languageProduct['Hello'].' '.$dataSend['fullname'].' !<br/><br/>
					'.$languageProduct['LinkLogin'].': '.$urlHomes.getLinkLogin().'<br/><br/>
					'.$languageProduct['InfoUser'].':<br/>
					'.$languageProduct['Account'].': '.$dataSend['username'].'<br/>
					'.$languageProduct['Password'].': '.$dataSend['password'].'<br/>
					'.$languageProduct['Email'].': '.$dataSend['email'].'<br/>
					'.$languageProduct['Phone'].': '.$dataSend['phone'].'<br/>
					'.$languageProduct['Address'].': '.$dataSend['address'].'<br/>';

		return $content;
   	}

	function getContentEmailOrderSuccess($fullNamUser='',$email='',$phone='',$address='',$note='',$listTypeMoney=array(),$transportFee=0)
	{	
		if(function_exists('getContentEmailOrderSuccessTheme')){
			return getContentEmailOrderSuccessTheme($fullNamUser,$email,$phone,$address,$note,$listTypeMoney,$transportFee);
		}
		
		global $urlHomes;
		global $modelOption;
		global $urlLocal;
		global $languageProduct;
    global $settingProduct;

    $listProperties= $modelOption->getOption('propertiesProduct');

		$content= $languageProduct['Hello'].' '.$fullNamUser.' !<br/>'.$languageProduct['YouHaveSuccessfullyOrdered'].':<br/><br/>';
		
		$content .= '<table width="100%" border="1">
						<thead>
							<tr>
								<th>STT</th>
								<th>'.$languageProduct['Image'].'</th>
								<th>'.$languageProduct['ProductName'].'</th>
								<th>'.$languageProduct['Quantity'].'</th>
								<th>'.$languageProduct['Mass'].'</th>
								<th>'.$languageProduct['Saleprice'].'</th>
							</tr>
						</thead>
						<tbody>';
							
						$totalMoney= 0;
						$totalMass= 0;
						if(isset($_SESSION['orderProducts']) && count($_SESSION['orderProducts'])>0){
									
							$listOrderProduct= $_SESSION['orderProducts'];
							$number= 0;
							
							foreach($listOrderProduct as $data)
							{
								$number++;
								if(!isset($data['Product']['images'][0]) || $data['Product']['images'][0]=='')
								{
									$data['Product']['images'][0]= $urlHomes.'/app/Plugin/product/images/no_image-100x100.jpg';
								}else{
									if(!strpos(strtolower($data['Product']['images'][0]),'://'))
								 	{
									 	$data['Product']['images'][0]= $urlHomes.$data['Product']['images'][0]; 
								 	}
								}
								if(isset($data['Product']['codeDiscountInput']) && $data['Product']['codeDiscountInput']!='')
								{
									$priceShow= $data['Product']['priceDiscount'];
									$discount= true;
								}
								else
								{
									$priceShow= $data['Product']['price'];
									$discount= false;
								}
								
								if(!isset($data['Product']['numberOrder'])) $data['Product']['numberOrder']=1;
								
								$totalMoney+= $priceShow*$data['Product']['numberOrder'];
								$totalMass+= $data['Product']['mass']*$data['Product']['numberOrder'];

								// thuộc tính bổ sung
                $propertiesSelectShow = '';

                if(!empty($data['Product']['propertiesSelect'])){
                    foreach($data['Product']['propertiesSelect'] as $key=>$propertiesSelect){
                        if(!empty($listProperties['Option']['value']['allData'][$key]['allData'][$propertiesSelect])){
                            $propertiesSelectShow .= '<p><b>'.$listProperties['Option']['value']['allData'][$key]['name'].'</b>: '.$listProperties['Option']['value']['allData'][$key]['allData'][$propertiesSelect]['name'].'</p>';
                        }
                    }
                }
							
				$content .= '<tr>
								<td>'.$number.'</td>
								<td>
									<a href="'.$data['Product']['images'][0].'"><img width="120" src="'.$data['Product']['images'][0].'" alt=""></a>
								</td>
								<td>'.$data['Product']['title'].$propertiesSelectShow.'</td>
								<td>'.$data['Product']['numberOrder'].'</td>
								<td>'.number_format($data['Product']['mass'],2).'</td>
								<td>'.number_format($priceShow).' '.@$listTypeMoney['Option']['value']['allData'][$data['Product']['typeMoneyId']]['name'];
								
								if($discount) $content .= '<p>('.$languageProduct['PriceDiscount'].')</p>';
									
				$content .=		'</td>
							</tr>';
							}

                if(isset($settingProduct['Option']['value']['massMin']) && $totalMass<$settingProduct['Option']['value']['massMin']){
                    $totalMass= $settingProduct['Option']['value']['massMin'];
                }
				
				$content .=	'<tr>
								<td colspan="3">';
									
								if(isset($_SESSION['codeDiscountInput']))
								{
									$content .= $languageProduct['CodeDiscount'].': <input type="button" value="'.$_SESSION['codeDiscountInput'].'" >';
								}
				if($transportFee>0){
					$transportFeeText= '- '.$languageProduct['TransportFee'].': '.number_format($transportFee).' '.@$listTypeMoney['Option']['value']['allData'][$data['Product']['typeMoneyId']]['name'];
				}else{
					$transportFeeText= '';
				}	

				$content .=		'</td>
								<td align="right"><b>'.$languageProduct['TotalAmount'].':</b></td>
								<td>'.number_format($totalMass,2).' kg</td>
								<td align="left" colspan="2" >
									- '.$languageProduct['Saleprice'].': '.number_format($totalMoney).' '.@$listTypeMoney['Option']['value']['allData'][$data['Product']['typeMoneyId']]['name'].'
									<br/>'.$transportFeeText.'
								</td>
							</tr>';
						}else{ 
				$content .=	'<tr>
								<td colspan="5" align="center">
									'.$languageProduct['CartIsEmpty'].'
								</td>
							</tr>';
						}

			$content .=	'</tbody>
					</table>';
					
			$content .=	'<br/><br/>
						<b>'.$languageProduct['CustomerInformation'].':</b><br/>
						'.$languageProduct['FullName'].': '.$fullNamUser.'<br/>
						'.$languageProduct['Email'].': '.$email.'<br/>
						'.$languageProduct['Phone'].': '.$phone.'<br/>
						'.$languageProduct['Address'].': '.$address.'<br/>
						'.$languageProduct['Note'].': '.nl2br($note).'<br/><br/>';
						
		return $content;
	}

	function getLinkProduct($typeReturn="relative")
	{
		global $modelOption;
		global $urlHomes;

		$listData= $modelOption->getOption('seoProduct');
		$url= (isset($listData['Option']['value']['seoPath']['product']) && $listData['Option']['value']['seoPath']['product']!='')?$listData['Option']['value']['seoPath']['product']:'product';
		
		if($typeReturn=='absolute'){
			return $urlHomes.$url.'/';
		}else{
			return '/'.$url.'/';
		}
	}

	function getLinkCat($typeReturn="relative")
	{
		global $modelOption;
		global $urlHomes;

		$listData= $modelOption->getOption('seoProduct');
		$url= (isset($listData['Option']['value']['seoPath']['cat']) && $listData['Option']['value']['seoPath']['cat']!='')?$listData['Option']['value']['seoPath']['cat']:'cat';
		
		if($typeReturn=='absolute'){
			return $urlHomes.$url.'/';
		}else{
			return '/'.$url.'/';
		}
	}

	function getLinkManufacturer($typeReturn="relative")
	{
		global $modelOption;
		global $urlHomes;

		$listData= $modelOption->getOption('seoProduct');
		$url= (isset($listData['Option']['value']['seoPath']['manufacturer']) && $listData['Option']['value']['seoPath']['manufacturer']!='')?$listData['Option']['value']['seoPath']['manufacturer']:'manufacturer';
		
		if($typeReturn=='absolute'){
			return $urlHomes.$url.'/';
		}else{
			return '/'.$url.'/';
		}
	}

	function getLinkCart($typeReturn="relative")
	{
		global $modelOption;
		global $urlHomes;

		$listData= $modelOption->getOption('seoProduct');
		$url= (isset($listData['Option']['value']['seoPath']['cart']) && $listData['Option']['value']['seoPath']['cart']!='')?$listData['Option']['value']['seoPath']['cart']:'cart';
		
		if($typeReturn=='absolute'){
			return $urlHomes.$url.'/';
		}else{
			return '/'.$url.'/';
		}
	}

	function getLinkLogin($typeReturn="relative")
	{
		global $modelOption;
		global $urlHomes;

		$listData= $modelOption->getOption('seoProduct');
		$url= (isset($listData['Option']['value']['seoPath']['login']) && $listData['Option']['value']['seoPath']['login']!='')?$listData['Option']['value']['seoPath']['login']:'login';
		
		if($typeReturn=='absolute'){
			return $urlHomes.$url.'/';
		}else{
			return '/'.$url.'/';
		}
	}

	function getLinkLogout($typeReturn="relative")
	{
		global $modelOption;
		global $urlHomes;

		$listData= $modelOption->getOption('seoProduct');
		$url= (isset($listData['Option']['value']['seoPath']['logout']) && $listData['Option']['value']['seoPath']['logout']!='')?$listData['Option']['value']['seoPath']['logout']:'logout';
		
		if($typeReturn=='absolute'){
			return $urlHomes.$url.'/';
		}else{
			return '/'.$url.'/';
		}
	}
    
    function getLinkHistory($typeReturn="relative")
	{
		global $modelOption;
		global $urlHomes;

		$listData= $modelOption->getOption('seoProduct');
		$url= (isset($listData['Option']['value']['seoPath']['history']) && $listData['Option']['value']['seoPath']['history']!='')?$listData['Option']['value']['seoPath']['history']:'history';
		
		if($typeReturn=='absolute'){
			return $urlHomes.$url.'/';
		}else{
			return '/'.$url.'/';
		}
	}
    
    function getLinkUserInfo($typeReturn="relative")
	{
		global $modelOption;
		global $urlHomes;

		$listData= $modelOption->getOption('seoProduct');
		$url= (isset($listData['Option']['value']['seoPath']['userInfo']) && $listData['Option']['value']['seoPath']['userInfo']!='')?$listData['Option']['value']['seoPath']['userInfo']:'userInfo';
		
		if($typeReturn=='absolute'){
			return $urlHomes.$url.'/';
		}else{
			return '/'.$url.'/';
		}
	}

	function getLinkRegister($typeReturn="relative")
	{
		global $modelOption;
		global $urlHomes;

		$listData= $modelOption->getOption('seoProduct');
		$url= (isset($listData['Option']['value']['seoPath']['register']) && $listData['Option']['value']['seoPath']['register']!='')?$listData['Option']['value']['seoPath']['register']:'register';
		
		if($typeReturn=='absolute'){
			return $urlHomes.$url.'/';
		}else{
			return '/'.$url.'/';
		}
	}

	function getLinkSearch($typeReturn="relative")
	{
		global $modelOption;
		global $urlHomes;

		$listData= $modelOption->getOption('seoProduct');
		$url= (isset($listData['Option']['value']['seoPath']['search']) && $listData['Option']['value']['seoPath']['search']!='')?$listData['Option']['value']['seoPath']['search']:'search';
		
		if($typeReturn=='absolute'){
			return $urlHomes.$url.'/';
		}else{
			return '/'.$url.'/';
		}
	}

	function getLinkDiscount($typeReturn="relative")
	{
		global $modelOption;
		global $urlHomes;

		$listData= $modelOption->getOption('seoProduct');
		$url= (isset($listData['Option']['value']['seoPath']['discount']) && $listData['Option']['value']['seoPath']['discount']!='')?$listData['Option']['value']['seoPath']['discount']:'discount';
		
		if($typeReturn=='absolute'){
			return $urlHomes.$url.'/';
		}else{
			return '/'.$url.'/';
		}
	}

	function getLinkAllProduct($typeReturn="relative")
	{
		global $modelOption;
		global $urlHomes;

		$listData= $modelOption->getOption('seoProduct');
		$url= (isset($listData['Option']['value']['seoPath']['allProduct']) && $listData['Option']['value']['seoPath']['allProduct']!='')?$listData['Option']['value']['seoPath']['allProduct']:'allProduct';
		
		if($typeReturn=='absolute'){
			return $urlHomes.$url.'/';
		}else{
			return '/'.$url.'/';
		}
	}

	function sendDataConnect($url,$data=null)
    {
	    if($data){
	   		$stringSend= array();

	   		/*
	   		foreach($data as $key=>$value){
	   			$stringSend[]= $key.'='.$value;
	   		}
	   		*/

	   		$stringSend= implode('&', $data);
	   		
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$stringSend);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec ($ch);

			curl_close ($ch);

			return $server_output;
	    }else{
		   return file_get_contents($url);
	    }
    }

    function checkImageCategory($category=array(),$urlWeb='')
    {
    	if(count($category)>0){
			foreach($category as $key=>$value){
				if(!strpos($value['image'],'://') && strpos($value['image'],'app/webroot/upload')){
				 	$category[$key]['image']= $urlWeb.$value['image']; 
			 	}

			 	if(isset($value['sub']) && count($value['sub'])>0){
			 		$category[$key]['sub']= checkImageCategory($value['sub'],$urlWeb);
			 	}
			}
		}
		return $category;
    }
?>