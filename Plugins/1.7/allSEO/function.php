<?php
	$menus= array();
	$menus[0]['title']= 'SEO';
    $menus[0]['sub'][0]= array('name'=>'All in Seo','url'=>$urlPlugins.'admin/allSEO-setting.php','classIcon'=>'fa-search','permission'=>'allInSeo',
	 'permission'=>'allInSeoSetting');
    
    addMenuAdminMantan($menus);
    
	function showSeoHome()
	{
		global $metaTitleMantan;
		global $metaKeywordsMantan;
		global $metaDescriptionMantan;
		global $metaImageMantan;
		global $modelOption;
		
		global $isHome;
		global $isCategory;
		global $isPost;
		global $isPage;
		global $isPlugin;
		global $categoryNotice;
		global $infoNotice;
		global $infoSite;
		
		global $urlNow;
		global $urlHomes;
		
		$page= explode('page:', $urlNow);
		if(count($page)>1)
		{
			$page= explode('/', $page[1]);
			$page= (int) $page[0];
		}
		else
		{
			$page=1;
			if(isset($_GET['page']) && $_GET['page']>0){
				$page= (int) $_GET['page'];
			}
		}
		
		//echo 'abc '.$this->Paginator->numbers();
	
		$listData= $modelOption->getOption('allSeo');
		$metaTitleMantanDefault= $infoSite['Option']['value']['title'];
		$metaKeywordsMantanDefault= $infoSite['Option']['value']['key'];
		$metaDescriptionMantanDefault= $infoSite['Option']['value']['description'];
		
		if($isCategory)
		{
			if(isset($listData['Option']['value']['category']['title']) && $listData['Option']['value']['category']['title']!='')
			{
				$metaTitleMantan= str_replace('%title%', $metaTitleMantanDefault, $listData['Option']['value']['category']['title']);
				$metaTitleMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaTitleMantan);
				$metaTitleMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaTitleMantan);
				
				if(isset($categoryNotice['name'])){
					$metaTitleMantan= str_replace('%categoryName%', $categoryNotice['name'], $metaTitleMantan);
				}

				if(isset($categoryNotice['key'])){
					$metaTitleMantan= str_replace('%categoryKeyword%', $categoryNotice['key'], $metaTitleMantan);
				}

				if(isset($categoryNotice['description'])){
					$metaTitleMantan= str_replace('%categoryDescription%', $categoryNotice['description'], $metaTitleMantan);
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
			
			if(isset($listData['Option']['value']['category']['keyword']) && $listData['Option']['value']['category']['keyword']!='')
			{
				$metaKeywordsMantan= str_replace('%title%', $metaTitleMantanDefault, $listData['Option']['value']['category']['keyword']);
				$metaKeywordsMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaKeywordsMantan);
				$metaKeywordsMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaKeywordsMantan);
				
				if(isset($categoryNotice['name'])){
					$metaKeywordsMantan= str_replace('%categoryName%', $categoryNotice['name'], $metaKeywordsMantan);
				}

				if(isset($categoryNotice['key'])){
					$metaKeywordsMantan= str_replace('%categoryKeyword%', $categoryNotice['key'], $metaKeywordsMantan);
				}

				if(isset($categoryNotice['description'])){
					$metaKeywordsMantan= str_replace('%categoryDescription%', $categoryNotice['description'], $metaKeywordsMantan);
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
			
			if(isset($listData['Option']['value']['category']['description']) && $listData['Option']['value']['category']['description']!='')
			{
				$metaDescriptionMantan= str_replace('%title%', $metaTitleMantanDefault, $listData['Option']['value']['category']['description']);
				$metaDescriptionMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaDescriptionMantan);
				$metaDescriptionMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaDescriptionMantan);
				
				if(isset($categoryNotice['name'])){
					$metaDescriptionMantan= str_replace('%categoryName%', $categoryNotice['name'], $metaDescriptionMantan);
				}

				if(isset($categoryNotice['key'])){
					$metaDescriptionMantan= str_replace('%categoryKeyword%', $categoryNotice['key'], $metaDescriptionMantan);
				}

				if(isset($categoryNotice['description'])){
					$metaDescriptionMantan= str_replace('%categoryDescription%', $categoryNotice['description'], $metaDescriptionMantan);
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

			if(!empty($categoryNotice['image'])){
				if(strpos($categoryNotice['image'], 'http') === false){
					$metaImageMantan= $urlHomes.$categoryNotice['image'];
				}else{
					$metaImageMantan= $categoryNotice['image'];
				}
			}
		} else if($isPost || $isPage)
		{
			if(isset($listData['Option']['value']['post']['title']) && $listData['Option']['value']['post']['title']!='')
			{
				$metaTitleMantan= str_replace('%title%', $metaTitleMantanDefault, $listData['Option']['value']['post']['title']);
				$metaTitleMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaTitleMantan);
				$metaTitleMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaTitleMantan);
				
				$metaTitleMantan= str_replace('%postName%', $infoNotice['Notice']['title'], $metaTitleMantan);
				$metaTitleMantan= str_replace('%postKeyword%', $infoNotice['Notice']['key'], $metaTitleMantan);
				$metaTitleMantan= str_replace('%postDescription%', $infoNotice['Notice']['introductory'], $metaTitleMantan);
			}
			
			if(isset($listData['Option']['value']['post']['keyword']) && $listData['Option']['value']['post']['keyword']!='')
			{
				$metaKeywordsMantan= str_replace('%title%', $metaTitleMantanDefault, $listData['Option']['value']['post']['keyword']);
				$metaKeywordsMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaKeywordsMantan);
				$metaKeywordsMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaKeywordsMantan);
				
				$metaKeywordsMantan= str_replace('%postName%', $infoNotice['Notice']['title'], $metaKeywordsMantan);
				$metaKeywordsMantan= str_replace('%postKeyword%', $infoNotice['Notice']['key'], $metaKeywordsMantan);
				$metaKeywordsMantan= str_replace('%postDescription%', $infoNotice['Notice']['introductory'], $metaKeywordsMantan);
			}
			
			if(isset($listData['Option']['value']['post']['description']) && $listData['Option']['value']['post']['description']!='')
			{
				$metaDescriptionMantan= str_replace('%title%', $metaTitleMantanDefault, $listData['Option']['value']['post']['description']);
				$metaDescriptionMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaDescriptionMantan);
				$metaDescriptionMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaDescriptionMantan);
				
				$metaDescriptionMantan= str_replace('%postName%', $infoNotice['Notice']['title'], $metaDescriptionMantan);
				$metaDescriptionMantan= str_replace('%postKeyword%', $infoNotice['Notice']['key'], $metaDescriptionMantan);
				$metaDescriptionMantan= str_replace('%postDescription%', $infoNotice['Notice']['introductory'], $metaDescriptionMantan);
			}

			if(!empty($infoNotice['Notice']['image'])){
				
				if(strpos($infoNotice['Notice']['image'], 'http') === false){
					$metaImageMantan= $urlHomes.$infoNotice['Notice']['image'];
				}else{
					$metaImageMantan= $infoNotice['Notice']['image'];
				}
				
			}
		} else if($isPlugin)
		{
			if(isset($listData['Option']['value']['expand']['title']) && $listData['Option']['value']['expand']['title']!='')
			{
				$metaTitleMantan= str_replace('%title%', $metaTitleMantanDefault, $listData['Option']['value']['expand']['title']);
				$metaTitleMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaTitleMantan);
				$metaTitleMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaTitleMantan);
			}
			
			if(isset($listData['Option']['value']['expand']['keyword']) && $listData['Option']['value']['expand']['keyword']!='')
			{
				$metaKeywordsMantan= str_replace('%title%', $metaTitleMantanDefault, $listData['Option']['value']['expand']['keyword']);
				$metaKeywordsMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaKeywordsMantan);
				$metaKeywordsMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaKeywordsMantan);
			}
			
			if(isset($listData['Option']['value']['expand']['description']) && $listData['Option']['value']['expand']['description']!='')
			{
				$metaDescriptionMantan= str_replace('%title%', $metaTitleMantanDefault, $listData['Option']['value']['expand']['description']);
				$metaDescriptionMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaDescriptionMantan);
				$metaDescriptionMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaDescriptionMantan);
			}
		} else
		{
			if(isset($listData['Option']['value']['general']['title']) && $listData['Option']['value']['general']['title']!='')
			{
				$metaTitleMantan= str_replace('%title%', $metaTitleMantanDefault, $listData['Option']['value']['general']['title']);
				$metaTitleMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaTitleMantan);
				$metaTitleMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaTitleMantan);
			}
			
			if(isset($listData['Option']['value']['general']['keyword']) && $listData['Option']['value']['general']['keyword']!='')
			{
				$metaKeywordsMantan= str_replace('%title%', $metaTitleMantanDefault, $listData['Option']['value']['general']['keyword']);
				$metaKeywordsMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaKeywordsMantan);
				$metaKeywordsMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaKeywordsMantan);
			}
			
			if(isset($listData['Option']['value']['general']['description']) && $listData['Option']['value']['general']['description']!='')
			{
				$metaDescriptionMantan= str_replace('%title%', $metaTitleMantanDefault, $listData['Option']['value']['general']['description']);
				$metaDescriptionMantan= str_replace('%keyword%', $metaKeywordsMantanDefault, $metaDescriptionMantan);
				$metaDescriptionMantan= str_replace('%description%', $metaDescriptionMantanDefault, $metaDescriptionMantan);
			}

			if(!empty($listData['Option']['value']['general']['image'])){
				if(strpos($listData['Option']['value']['general']['image'], 'http') === false){
					$metaImageMantan= $urlHomes.$listData['Option']['value']['general']['image'];
				}else{
					$metaImageMantan= $listData['Option']['value']['general']['image'];
				}
			}
		}
		
		echo '<title>'.$metaTitleMantan.'</title>
			  <meta name="description" content="'.$metaDescriptionMantan.'" />
			  <meta name="keywords" content="'.$metaKeywordsMantan.'" />

			  <!-- Google / Search Engine Tags -->
			  <meta itemprop="name" content="'.$metaTitleMantan.'">
			  <meta itemprop="description" content="'.$metaDescriptionMantan.'">
			  <meta itemprop="image" content="'.$metaImageMantan.'">
			  ';
	}

	function checkFileExists($url)
	{
		$contents = file_get_contents($url);

		if (strlen($contents))
		{
		  return true; // yes it does exist
		}
		else
		{
		  return false; // oops
		}
	}
?>