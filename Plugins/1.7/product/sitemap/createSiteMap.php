 <?php
 	global $modelOption;
	global $urlHomes;
	global $urlNow;
	global $urlPlugins;
	global $isRequestPost;

	if(checkAdminLogin()){
	 	$sitemap= array($urlHomes,$urlHomes.'app/Plugin/product/sitemap/export/category.xml',$urlHomes.'app/Plugin/product/sitemap/export/manufacturer.xml');
	 	
	 	$dataSend= $this->data;
		$listData= $modelOption->getOption('sitemapProduct');
		
		$listData['Option']['value']['freq']= $dataSend['freq'];
		
		$listData['Option']['value']['lastmod']= $dataSend['lastmod'];
		$listData['Option']['value']['lastmodtime']= $dataSend['lastmodtime'];
		
		$listData['Option']['value']['priority']= $dataSend['priority'];
		$listData['Option']['value']['priorityCategory']= $dataSend['priorityCategory'];
		$listData['Option']['value']['priorityDetail']= $dataSend['priorityDetail'];
		
		$modelOption->saveOption('sitemapProduct',$listData['Option']['value']);
		
	 	// Create category stitemap
	 	function changeCategory($cat,$listCategoryNew,$urlProductCategory)
	 	{
	 		$url= $urlProductCategory.$cat['slug'].'.html';
	 		$catNew= array('id'=>$cat['id'],'url'=>$url);
		 	array_push($listCategoryNew, $catNew);

		 	if(isset($cat['sub']) && count($cat['sub'])>0){
				foreach($cat['sub'] as $sub)
				{
					$listCategoryNew= changeCategory($sub,$listCategoryNew,$urlProductCategory);
				}
			}

			return $listCategoryNew;
	 	}
	 	
	 	$urlProductCategory= getLinkCat();
	 	
	 	$listCategory= $modelOption->getOption('productCategory');
	 	
	 	$listCategoryNew= array();
	 	
	 	foreach($listCategory['Option']['value']['category'] as $cat)
	 	{
		 	$listCategoryNew= changeCategory($cat,$listCategoryNew,$urlProductCategory);
	 	}
	  
	  	$doc = new DOMDocument('1.0', 'utf-8');
	  	$doc->formatOutput = true;
	  
	  	$r = $doc->createElement( "urlset" );
	  	$doc->appendChild( $r );
	  	
	  	$xmlns = $doc->createAttribute('xmlns');
		$r->appendChild($xmlns);
		
		$value = $doc->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9');
		$xmlns->appendChild($value);
	  
	  	if($dataSend['lastmod']==1)
	  	{
		  	$today= getdate();
	  	}
	  	else
	  	{
	  		$dataSend['lastmodtime']= (int) $dataSend['lastmodtime'];
		  	$today= getdate($dataSend['lastmodtime']);
	  	}
	  	
	  	if($today['mon']<10) $today['mon']= '0'.$today['mon'];
	  	if($today['mday']<10) $today['mday']= '0'.$today['mday'];
	  	$today= $today['year'].'-'.$today['mon'].'-'.$today['mday'];
	  
	  	foreach( $listCategoryNew as $category )
	  	{
			  $b = $doc->createElement( "url" );
			  
			  $loc = $doc->createElement( "loc" );
			  $loc->appendChild( $doc->createTextNode( $category['url'] ));
			  $b->appendChild( $loc );
			  
			  if($dataSend['lastmod']>0)
			  {
				  $lastmod = $doc->createElement( "lastmod" );
				  $lastmod->appendChild( $doc->createTextNode( $today ) );
				  $b->appendChild( $lastmod );
			  }
			  
			  if($dataSend['freq']!='')
			  {
				  $changefreq = $doc->createElement( "changefreq" );
				  $changefreq->appendChild( $doc->createTextNode( $dataSend['freq'] ) );
				  $b->appendChild( $changefreq );
			  }
			  
			  if($dataSend['priority']==1)
			  {
				  $priority = $doc->createElement( "priority" );
				  $priority->appendChild( $doc->createTextNode( $dataSend['priorityCategory'] ) );
				  $b->appendChild( $priority );
			  }
			  
			  $id = $doc->createElement( "id" );
			  $id->appendChild( $doc->createTextNode( $category['id'] ) );
			  $b->appendChild( $id );
			  
			  $r->appendChild( $b );
		}
	  
		$doc->save($urlLocal['urlLocalPlugin'].'product/sitemap/export/category.xml');
		
	// Create manufacturer stitemap
	 	$urlProductCategory= getLinkManufacturer();
	 	
	 	$listCategory= $modelOption->getOption('productManufacturer');
	 	$listCategoryNew= array();
	 	
	 	foreach($listCategory['Option']['value']['category'] as $cat)
	 	{
		 	$listCategoryNew= changeCategory($cat,$listCategoryNew,$urlProductCategory);
	 	}
	  
	  	$doc = new DOMDocument('1.0', 'utf-8');
	  	$doc->formatOutput = true;
	  
	  	$r = $doc->createElement( "urlset" );
	  	$doc->appendChild( $r );
	  	
	  	$xmlns = $doc->createAttribute('xmlns');
		$r->appendChild($xmlns);
		
		$value = $doc->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9');
		$xmlns->appendChild($value);
	  
	  	foreach( $listCategoryNew as $category )
	  	{
			  $b = $doc->createElement( "url" );
			  
			  $loc = $doc->createElement( "loc" );
			  $loc->appendChild( $doc->createTextNode( $category['url'] ));
			  $b->appendChild( $loc );
			  
			  if($dataSend['lastmod']>0)
			  {
				  $lastmod = $doc->createElement( "lastmod" );
				  $lastmod->appendChild( $doc->createTextNode( $today ) );
				  $b->appendChild( $lastmod );
			  }
			  
			  if($dataSend['freq']!='')
			  {
				  $changefreq = $doc->createElement( "changefreq" );
				  $changefreq->appendChild( $doc->createTextNode( $dataSend['freq'] ) );
				  $b->appendChild( $changefreq );
			  }
			  
			  if($dataSend['priority']==1)
			  {
				  $priority = $doc->createElement( "priority" );
				  $priority->appendChild( $doc->createTextNode( $dataSend['priorityCategory'] ) );
				  $b->appendChild( $priority );
			  }
			  
			  $id = $doc->createElement( "id" );
			  $id->appendChild( $doc->createTextNode( $category['id'] ) );
			  $b->appendChild( $id );
			  
			  $r->appendChild( $b );
		}
	  
		$doc->save($urlLocal['urlLocalPlugin'].'product/sitemap/export/manufacturer.xml');
		
		// Create product sitemap with month
		$modelProduct= new Product();
		$listProduct= $modelProduct->find('all');
		
		foreach($listProduct as $product)
		{
			$date= getdate($product['Product']['modified']->sec);
			
			$url= getLinkProduct().$product['Product']['slug'].'.html';
	 		$productNew= array('id'=>$product['Product']['id'],'url'=>$url);
	 		
	 		if(!isset($listProductMonth['product'.$date['year'].'_'.$date['mon'] ]))
	 		{
		 		$listProductMonth['product'.$date['year'].'_'.$date['mon'] ]= array();
	 		}
	 		
	 		array_push($listProductMonth['product'.$date['year'].'_'.$date['mon'] ], $productNew);
		}
		
		foreach($listProductMonth as $key=>$month)
		{
			$doc = new DOMDocument('1.0', 'utf-8');
		  	$doc->formatOutput = true;
		  
		  	$r = $doc->createElement( "urlset" );
		  	$doc->appendChild( $r );
		  	
		  	$xmlns = $doc->createAttribute('xmlns');
			$r->appendChild($xmlns);
			
			$value = $doc->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9');
			$xmlns->appendChild($value);
		  
		  	foreach( $month as $productMonth )
		  	{
				  $b = $doc->createElement( "url" );
				  
				  $loc = $doc->createElement( "loc" );
				  $loc->appendChild( $doc->createTextNode( $productMonth['url'] ));
				  $b->appendChild( $loc );
				  
				  if($dataSend['lastmod']>0)
				  {
					  $lastmod = $doc->createElement( "lastmod" );
					  $lastmod->appendChild( $doc->createTextNode( $today ) );
					  $b->appendChild( $lastmod );
				  }
				  
				  if($dataSend['freq']!='')
				  {
					  $changefreq = $doc->createElement( "changefreq" );
					  $changefreq->appendChild( $doc->createTextNode( $dataSend['freq'] ) );
					  $b->appendChild( $changefreq );
				  }
				  
				  if($dataSend['priority']==1)
				  {
					  $priority = $doc->createElement( "priority" );
					  $priority->appendChild( $doc->createTextNode( $dataSend['priorityDetail'] ) );
					  $b->appendChild( $priority );
				  }
				  
				  $id = $doc->createElement( "id" );
				  $id->appendChild( $doc->createTextNode( $productMonth['id'] ) );
				  $b->appendChild( $id );
				  
				  $r->appendChild( $b );
			}
		  
			$doc->save($urlLocal['urlLocalPlugin'].'product/sitemap/export/'.$key.'.xml');
			
			array_push($sitemap, $urlHomes.'app/Plugin/product/sitemap/export/'.$key.'.xml');
		}
		
		// Create sitemap all
		$doc = new DOMDocument('1.0', 'utf-8');
	  	$doc->formatOutput = true;
	  
	  	$r = $doc->createElement( "urlset" );
	  	$doc->appendChild( $r );
	  	
	  	$xmlns = $doc->createAttribute('xmlns');
		$r->appendChild($xmlns);
		
		$value = $doc->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9');
		$xmlns->appendChild($value);
	  
	  	foreach( $sitemap as $url )
	  	{
			  $b = $doc->createElement( "url" );
			  
			  $loc = $doc->createElement( "loc" );
			  $loc->appendChild( $doc->createTextNode( $url ));
			  $b->appendChild( $loc );
			  
			  if($dataSend['lastmod']>0)
			  {
				  $lastmod = $doc->createElement( "lastmod" );
				  $lastmod->appendChild( $doc->createTextNode( $today ) );
				  $b->appendChild( $lastmod );
			  }
			  
			  if($dataSend['freq']!='')
			  {
				  $changefreq = $doc->createElement( "changefreq" );
				  $changefreq->appendChild( $doc->createTextNode( $dataSend['freq'] ) );
				  $b->appendChild( $changefreq );
			  }
			  
			  $r->appendChild( $b );
		}
	  
		$doc->save($urlLocal['urlLocalPlugin'].'product/sitemap/sitemap.xml');
		
		// --------------
		$modelOption->redirect($urlPlugins.'admin/product-sitemap-settingSitemap.php?return=1');
	}else{
		$modelOption->redirect($urlHomes);
	}
  ?>