<?php

   class OptionsController extends AppController

   {

	    var $name = 'Options';

        var $helpers = array('Session','Paginator');

        var $paginate = array();
        
// Category notice -------------------------------------------------------

        function categoryNotice()
        {
        	  //Configure::write('debug', 2);
	          $users= $this->Session->read('infoAdminLogin');
	
	          if($users)
	          {
	          		Controller::loadModel('Option');
		            $this->setup();
	
		            $chuyenmuc= $this->Option->getOption('categoryNotice');

		            $chuyenmuc['Option']['value']['category']= (isset($chuyenmuc['Option']['value']['category']))?$chuyenmuc['Option']['value']['category']:array();
	
		            $this->set('group', $chuyenmuc['Option']['value']['category']);
	
	          }
	          else 
              {
	            	$urlLocal= $this->getUrlLocal();
		            $this->redirect($urlLocal['urlAdmins'].'login');
              }
        }
        
        
		function saveCategoryNotice()
		{
			//Configure::write('debug', 2);
			$users= $this->Session->read('infoAdminLogin');
			
			Controller::loadModel('Option');
			//Controller::loadModel('Slug');

        	$urlLocal= $this->getUrlLocal();
        	
			if($users)
			{
				$idCatEdit= $_POST['idCatEdit'];
				$name= $_POST['name'];
				$parent= (int) $_POST['parent'];
				$slug= createSlugMantan($_POST['name']);
				//$slug= $this->Slug->saveSlug($slug,'notices','cat');
				$key= $_POST['key'];
                $image= $_POST['image'];
				$description= $_POST['description'];
				$content= $_POST['content'];
				
				$return= -1;
				if($name != '')
				{
					$return= $this->Option->saveCategoryNotice($slug,$idCatEdit,$name,$parent,$key,$description,$image,$content);
				}
				$this->redirect($urlLocal['urlOptions']."categoryNotice");
	
			}
			else 
            {
	            $this->redirect($urlLocal['urlAdmins'].'login');
            }
		}
		
		function deleteCatagery()
		{
			//Configure::write('debug', 2);
			
			$idCat= (int) $_POST['idDelete'];
			$slugCat= (int) $_POST['slugDelete'];
			$users= $this->Session->read('infoAdminLogin');
	
			if($users)
			{
				Controller::loadModel('Option');
				Controller::loadModel('Slug');

				$return= $this->Option->deleteCatageryNotice($idCat);
				$this->Slug->deleteSlug($slugCat);
			}
		}   
        
        function changeCategoryNotice()
        {
        	//Configure::write('debug', 2);
	        $users= $this->Session->read('infoAdminLogin');
	        if($users)
	        {
	        	Controller::loadModel('Option');
	        	$type= $_POST['type'];
	        	$idMenu= (int) $_POST['idMenu'];
	        	
	        	$this->Option->changeCategoryNotice($type,$idMenu);
	        }
        }
// Theme ---------------------------
	function themes()
	{
		//Configure::write('debug', 2);
        $users= $this->Session->read('infoAdminLogin');
        if($users)
        {
      		Controller::loadModel('Option');
            $this->setup();

            $theme= $this->Option->getOption('theme');
            $this->set('theme', $theme['Option']['value']);
            
            $urlLocal= $this->getUrlLocal();
	        $listFile= $this->list_files($urlLocal['urlLocalTheme']);
            
            $this->set('listFile',$listFile);

        }
        else 
        {
        	$urlLocal= $this->getUrlLocal();
            $this->redirect($urlLocal['urlAdmins'].'login');
        }
	}
	
	function changeTheme($theme)
	{
		//Configure::write('debug', 2);
        $users= $this->Session->read('infoAdminLogin');
        
        if($users)
        {
      		Controller::loadModel('Option');
      		if(!$theme) $theme= $_POST['theme'];
            $this->Option->saveOption('theme',$theme);
        }
	}
// Language ---------------------------
	function languages()
	{
		//Configure::write('debug', 2);
        $users= $this->Session->read('infoAdminLogin');
        if($users)
        {
      		Controller::loadModel('Option');
            $this->setup();

            $languages= $this->Option->getOption('language');
            $this->set('languages', $languages['Option']['value']);
            
            $urlLocal= $this->getUrlLocal();
	        $listFile= $this->list_files($urlLocal['urlLocalLanguage']);
            
            $this->set('listFile',$listFile);
            
        }
        else 
        {
        	$urlLocal= $this->getUrlLocal();
            $this->redirect($urlLocal['urlAdmins'].'login');
        }
	}
	
	function activeLanguage($code,$file)
	{
		//Configure::write('debug', 2);
		$users= $this->Session->read('infoAdminLogin');
		
		Controller::loadModel('Option');
    	$urlLocal= $this->getUrlLocal();
    	
        if($users)
        {
        	if($code)
        	{
	        	$this->Option->saveOption('language',array('code'=>$code,'file'=>$file));
        	}
        	$this->redirect($urlLocal['urlOptions'].'languages');
        }
        else 
        {
            $this->redirect($urlLocal['urlAdmins'].'login');
        }
	}

// Menu --------------------------
	function saveInfoMenu()
	{
		//Configure::write('debug', 2);
		$users= $this->Session->read('infoAdminLogin');
        
        Controller::loadModel('Option');
    	$urlLocal= $this->getUrlLocal();
    	
        if($users)
        {
        	$id= $_POST['id'];
        	$name= $_POST['name'];
        	
        	$this->Option->saveInfoMenu($name,$id);
        	$this->redirect($urlLocal['urlOptions'].'menus');
        }
        else 
        {
            $this->redirect($urlLocal['urlAdmins'].'login');
        }
	}
	
	function defaultMenu()
	{
		//Configure::write('debug', 2);
		$users= $this->Session->read('infoAdminLogin');
        
        Controller::loadModel('Option');
    	
        if($users && $_POST['idMenu']!='')
        {
        	$listData= $this->Option->getOption('defaultMenuMantan');
        	$listData['Option']['value']= $_POST['idMenu'];
        	$this->Option->saveOption('defaultMenuMantan',$listData['Option']['value']);
        }
	}
	
	function deleteOneMenu()
	{
		$users= $this->Session->read('infoAdminLogin');
            
        Controller::loadModel('Option');
    	$urlLocal= $this->getUrlLocal();
    	
        if($users && $_POST['idMenu']!='')
        {
        	$idMenu= new MongoId($_POST['idMenu']);
        	$this->Option->delete($idMenu);
        }
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
			    	$category[$key]['sub']= $this->changeTypeCategory($cat['sub'],$link);
			    }
	        }
	        return $category;
		}
		
		function menus()
		{
			//Configure::write('debug', 2);
            $users= $this->Session->read('infoAdminLogin');
            if($users)
            {
            	$this->setup();
	            global $hookMenusAppearanceMantan;
	            global $urlNotices;
	            global $languageMantan;
                global $infoSite;
	            
	            if(!is_array($hookMenusAppearanceMantan)) {
		            $hookMenusAppearanceMantan= array();
	            }
	            
            	Controller::loadModel('Option');
            	$urlLocal= $this->getUrlLocal();
                
                $categoryNotice= $this->Option->getOption('categoryNotice');
                $menus= $this->Option->getOption('menus','all');
                $this->set('menus', $menus);
                
                if(isset($_GET['id']) && $_GET['id']!='')
                {
	                foreach($menus as $menuUser)
	                {
		                if($menuUser['Option']['id']==$_GET['id'])
		                {
			                $menuShow= $menuUser;
			                break;
		                }
	                }
                }
                
                if(!isset($menuShow)){
	                if(isset($menus[0])){
		                $menuShow= $menus[0];
	                }else{
	                	$menuShow= array();
	                	$menuShow['Option']['value']['category']= array();
	                	$menuShow['Option']['id']= '';
	                }
            	}
                
                $this->set('menuShow', $menuShow);
                
                // Get Pages
                Controller::loadModel('Notice');
                
                $pages= $this->Notice->getAllPage();
                
                foreach($pages as $key=>$page)
                { 
                	$pages[$key]= array ( 'url' => '/'.$page['Notice']['slug'].'.html',
									      'name' => $page['Notice']['title']
									    );
                }

                if(!isset($categoryNotice['Option']['value']['category'])){
                	$categoryNotice['Option']['value']['category']= array();
                }
				
                $menusSystem=array (array('title'=>$languageMantan['menuSystem'],
                										'sub'=>array(
																	    array (
																	      'url' => '/',
																	      'name' => $languageMantan['homePage']
																	    ), 
																	    array (
																	      'url' => '/'.$infoSite['Option']['value']['seoURL']['albums'],
																	      'name' => $languageMantan['album']
																	    ),
																	    array (
																	      'url' => '/'.$infoSite['Option']['value']['seoURL']['videos'],
																	      'name' => $languageMantan['video']
																	    )
																	)
														),
													array('title'=>$languageMantan['newsCategories'],
                										  'sub'=>$this->changeTypeCategory($categoryNotice['Option']['value']['category'],'/')
														  ),
													array('title'=>$languageMantan['pages'],
                										  'sub'=>$pages
														  ),
												  );
											  
				$hookMenusAppearanceMantan= array_merge($menusSystem,$hookMenusAppearanceMantan);
				
				$defaultMenuMantan= $this->Option->getOption('defaultMenuMantan');
				if(!isset($defaultMenuMantan['Option']['value'])){
					$defaultMenuMantan['Option']['value']= '';
				}
				$this->set('defaultMenuMantan', $defaultMenuMantan['Option']['value']);
            }
            else 
            {
            	$urlLocal= $this->getUrlLocal();
	            $this->redirect($urlLocal['urlAdmins'].'login');
            }
		}
		
		function saveMenus()
		{
			//Configure::write('debug', 2);
			$users= $this->Session->read('infoAdminLogin');
            
            Controller::loadModel('Option');
        	$urlLocal= $this->getUrlLocal();
        	
            if($users)
            {
            	$idTD= $_POST['idTD'];
            	$idParent= (int) $_POST['idParent'];
            	$url= trim($_POST['url']);
            	$description= trim($_POST['description']);
            	$name= trim($_POST['name']);
            	$name= str_replace('\t', '', $name);
            	$name= trim($name);
            	$submit= $_POST['submit'];
            	if($_POST['idMenuShow']!='')
            	{
            		$idMenu= new MongoId($_POST['idMenuShow']);
            		$this->Option->saveMenus($idParent,$idTD,$name,$url,$description,$idMenu);
            	}
            	
            	$this->redirect($urlLocal['urlOptions'].'menus?id='.$_POST['idMenuShow']);
            }
            else 
            {
	            $this->redirect($urlLocal['urlAdmins'].'login');
            }
		}
		
		function changeMenus()
		{
			//Configure::write('debug', 2);
            $users= $this->Session->read('infoAdminLogin');

            if($users)
            {
            	Controller::loadModel('Option');
            	$type= $_POST['type'];
            	$idMenu= (int) $_POST['idMenu'];
            	$idParent= (int) $_POST['idParent'];
            	if($_POST['idMenuShow']!='')
            	{
	            	$idMenuShow= new MongoId($_POST['idMenuShow']);
					$this->Option->changeMenus($type,$idMenu,$idParent,$idMenuShow);
            	}
            }
		}
		function deleteMenus($idMenu,$idMenuShow)
		{
			//Configure::write('debug', 2);
			$users= $this->Session->read('infoAdminLogin');
            
            Controller::loadModel('Option');
        	$urlLocal= $this->getUrlLocal();
        	
            if($users)
            {
            	$idMenu= (int) $idMenu;
            	if($idMenuShow!='')
            	{
            		$idMenuShow= new MongoId($idMenuShow);
					$this->Option->deleteMenus($idMenu,$idMenuShow);
            	}
            	$this->redirect($urlLocal['urlOptions'].'menus?id='.$idMenuShow);
            }
            else 
            {
	            $this->redirect($urlLocal['urlAdmins'].'login');
            }

		}
// Setting info ------------------------------------------

        function infoSite()
        {
          $users= $this->Session->read('infoAdminLogin');
          if($users)
          {
          		Controller::loadModel('Option');
	          	$this->setup(true);
	            $infoSite= $this->Option->getOption('infoSite');
	            $contact= $this->Option->getOption('contact');
				$smtpSite= $this->Option->getOption('smtpSetting');
	            
	            $this->set('infoSite',$infoSite);
	            $this->set('contact',$contact);
				$this->set('smtpSite',$smtpSite);
          }
          else 
          {
        	  $urlLocal= $this->getUrlLocal();
              $this->redirect($urlLocal['urlAdmins'].'login');
          }

        }

        function saveInfoSite()
        { //Configure::write('debug', 2);

          $users= $this->Session->read('infoAdminLogin');
          Controller::loadModel('Option');
          $urlLocal= $this->getUrlLocal();
        	
          if($users)
          {
	        Controller::loadModel('Option');
			
			if($_POST['seoURL']['notices']=='') $_POST['seoURL']['notices']= 'notices';
			if($_POST['seoURL']['cat']=='') $_POST['seoURL']['cat']= 'cat';
			if($_POST['seoURL']['albums']=='') $_POST['seoURL']['albums']= 'albums';
			if($_POST['seoURL']['videos']=='') $_POST['seoURL']['videos']= 'videos';
			if($_POST['seoURL']['search']=='') $_POST['seoURL']['search']= 'search';
			if($_POST['seoURL']['users']=='') $_POST['seoURL']['users']= 'users';
			if($_POST['seoURL']['login']=='') $_POST['seoURL']['login']= 'login';
			if($_POST['seoURL']['register']=='') $_POST['seoURL']['register']= 'register';
			
            $return= $this->Option->saveInfoSite($_POST);
			
			if(file_exists('../Config/database.php')){
				$urlLocalConfig= '../Config/';
			}else{
				$urlLocalConfig= 'app/Config/';
			}
			
			$passEmail= str_replace('*', '', $_POST['password']);
			if(!empty($passEmail)){
				// write file email.php
				$string= '<?php 
							class EmailConfig {
								public $default = array(
									"transport" => "Smtp", 
									"from" => array("'.$_POST['account'].'" => "'.$_POST['show'].'"), 
									"host" => "'.$_POST['host'].'", 
									"port" => '.$_POST['port'].', 
									"timeout" => 30, 
									"emailFormat" => "html", 
									"username" => "'.$_POST['account'].'", 
									"password" => "'.$_POST['password'].'", 
									"tls" => false, 
									"log" => false, 
									"charset" => "utf-8", 
									"headerCharset" => "utf-8", 
									
								);
							}
						?>';
				$file = fopen($urlLocalConfig.'email.php','w');
				fwrite($file,$string);
				fclose($file);
			}
			
			// write file routesSEO.php
			$string= '<?php 
						// NoticesController
						Router::connect($urlBase."'.$_POST["seoURL"]["notices"].'/'.$_POST["seoURL"]["cat"].'/*", array("controller" => "notices", "action" => "cat"));
						Router::connect($urlBase."'.$_POST["seoURL"]["notices"].'/'.$_POST["seoURL"]["search"].'/*", array("controller" => "notices", "action" => "search"));
						Router::connect($urlBase."'.$_POST["seoURL"]["notices"].'/*", array("controller" => "notices", "action" => "index"));
						
						// VideosController
						Router::connect($urlBase."'.$_POST["seoURL"]["videos"].'/", array("controller" => "videos", "action" => "allVideos"));
						Router::connect($urlBase."'.$_POST["seoURL"]["videos"].'/*", array("controller" => "videos", "action" => "index"));
						
						// AlbumsController
						Router::connect($urlBase."'.$_POST["seoURL"]["albums"].'/", array("controller" => "albums", "action" => "allAlbums"));
						Router::connect($urlBase."'.$_POST["seoURL"]["albums"].'/*", array("controller" => "albums", "action" => "index"));
						
						// UsersController
						Router::connect($urlBase."'.$_POST["seoURL"]["users"].'/'.$_POST["seoURL"]["login"].'/*", array("controller" => "user", "action" => "login"));
						Router::connect($urlBase."'.$_POST["seoURL"]["users"].'/'.$_POST["seoURL"]["register"].'/*", array("controller" => "user", "action" => "register"));
						Router::connect($urlBase."'.$_POST["seoURL"]["users"].'/*", array("controller" => "user", "action" => "index"));
					?>';
			$file = fopen($urlLocalConfig.'routesSEO.php','w');
			fwrite($file,$string);
			fclose($file);
            
            $this->redirect($urlLocal['urlOptions'].'infoSite/?return='.$return);
          }
          else 
          {
            $this->redirect($urlLocal['urlAdmins'].'login');
          }
        }
// Site map ---------------
	function sitemap()
	{
		$users= $this->Session->read('infoAdminLogin');
        if($users)
        {
        	Controller::loadModel('Option');
        	$this->setup();
        	$listData= $this->Option->getOption('sitemapMantan');
        	
        	$this->set('listData',$listData);
        }
        else 
        {
        	$urlLocal= $this->getUrlLocal();
            $this->redirect($urlLocal['urlAdmins'].'login');
        }
	}
	
	// Create category stitemap
 	function changeCategorySitemap($cat,$listCategoryNew,$urlCategory)
 	{
 		$url= $urlCategory.$cat['slug'].'.html';
 		$catNew= array('id'=>$cat['id'],'url'=>$url);
	 	array_push($listCategoryNew, $catNew);

	 	if(isset($cat['sub']) && count($cat['sub'])>0){
			foreach($cat['sub'] as $sub)
			{
				$listCategoryNew= $this->changeCategorySitemap($sub,$listCategoryNew,$urlCategory);
			}
		}
		return $listCategoryNew;
 	}
 	
	function createSiteMap()
	{
		//Configure::write('debug', 2);
		$users= $this->Session->read('infoAdminLogin');
        if($users)
        {
        	$this->setup();
        	
        	global $urlNotices;
        	global $urlHomes;
        	global $urlOptions;
        	
        	if(function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules()))
	        {
	        	$urlLocalRoot= '../../';
	        }
	        else
	        {
	            $urlLocalRoot= '';
	        }

	        $urlLocalRoot= __DIR__.'/../../';
        	
        	Controller::loadModel('Option');
        	Controller::loadModel('Notice');
        	
        	if (!file_exists(__DIR__.'/../../sitemap')) {
                mkdir(__DIR__.'/../../sitemap', 0755, true);
            }

            if (!file_exists(__DIR__.'/../../sitemap/category.xml')) {
            	fopen(__DIR__.'/../../sitemap/category.xml', "w");
            }

        	$sitemap= array($urlHomes,$urlHomes.'sitemap/category.xml');
			
			// Save setting
		 	$dataSend= $this->data;
			$listData= $this->Option->getOption('sitemapMantan');
			
			$listData['Option']['value']['freq']= $dataSend['freq'];
			
			$listData['Option']['value']['lastmod']= $dataSend['lastmod'];
			$listData['Option']['value']['lastmodtime']= $dataSend['lastmodtime'];
			
			$listData['Option']['value']['priority']= $dataSend['priority'];
			$listData['Option']['value']['priorityCategory']= $dataSend['priorityCategory'];
			$listData['Option']['value']['priorityDetail']= $dataSend['priorityDetail'];
			
			$this->Option->saveOption('sitemapMantan',$listData['Option']['value']);
			// end save
			
			// Create category stitemap
			$urlCategory= $urlNotices.'cat/';
 	
		 	$listCategory= $this->Option->getOption('categoryNotice');
		 	
		 	$listCategoryNew= array();
		 	
		 	foreach($listCategory['Option']['value']['category'] as $cat)
		 	{
			 	$listCategoryNew= $this->changeCategorySitemap($cat,$listCategoryNew,$urlCategory);
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
		  		if(isset($dataSend['lastmodtime']) && $dataSend['lastmodtime']!=''){
		  			$dataSend['lastmodtime']= (int) $dataSend['lastmodtime'];
		  			$today= getdate($dataSend['lastmodtime']);
		  		}else{
		  			$today= getdate();
		  		}
			  	
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
				  
				  $r->appendChild( $b );
			}
		  
			$doc->save($urlLocalRoot.'sitemap/category.xml');
			
			// Create notices sitemap with month
			$listNotices= $this->Notice->find('all');
			
			foreach($listNotices as $data)
			{
				$date= getdate($data['Notice']['modified']->sec);
				
				$url= $urlNotices.$data['Notice']['slug'].'.html';
		 		$dataNew= array('id'=>$data['Notice']['id'],'url'=>$url);
		 		
		 		if(!isset($listMonth['notice'.$date['year'].'_'.$date['mon'] ]))
		 		{
			 		$listMonth['notice'.$date['year'].'_'.$date['mon'] ]= array();
		 		}
		 		
		 		array_push($listMonth['notice'.$date['year'].'_'.$date['mon'] ], $dataNew);
			}
			
			foreach($listMonth as $key=>$month)
			{
				$doc = new DOMDocument('1.0', 'utf-8');
			  	$doc->formatOutput = true;
			  
			  	$r = $doc->createElement( "urlset" );
			  	$doc->appendChild( $r );
			  	
			  	$xmlns = $doc->createAttribute('xmlns');
				$r->appendChild($xmlns);
				
				$value = $doc->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9');
				$xmlns->appendChild($value);
			  
			  	foreach( $month as $dataMonth )
			  	{
					  $b = $doc->createElement( "url" );
					  
					  $loc = $doc->createElement( "loc" );
					  $loc->appendChild( $doc->createTextNode( $dataMonth['url'] ));
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
					  
					  $r->appendChild( $b );
				}
			  	
			  	if (!file_exists(__DIR__.'/../../sitemap/'.$key.'.xml')) {
	            	fopen(__DIR__.'/../../sitemap/'.$key.'.xml', "w");
	            }

				$doc->save($urlLocalRoot.'sitemap/'.$key.'.xml');
				
				array_push($sitemap, $urlHomes.'sitemap/'.$key.'.xml');
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
		  
			$doc->save($urlLocalRoot.'sitemap.xml');
			$this->redirect($urlOptions.'sitemap?return=1');
        }
        else 
        {
        	$urlLocal= $this->getUrlLocal();
            $this->redirect($urlLocal['urlAdmins'].'login');
        }
	}
// Plugin -------
	function plugins()
	{
		  //Configure::write('debug', 2);
		  $users= $this->Session->read('infoAdminLogin');
          if($users)
          {
          		Controller::loadModel('Option');
	          	$this->setup();
	            $plugins= $this->Option->getOption('plugins');
	            
	            $urlLocal= $this->getUrlLocal();
	            $listFile= $this->list_files($urlLocal['urlLocalPlugin']);
	            
	            if(!isset($plugins['Option']['value']))
	            {
		            $plugins['Option']['value']= array();
	            }
	            
	            $listFileShow= array();
	            foreach($listFile as $file)
	            {
	            	if($file!='Mongodb' && $file!='.svn' && $file!='PhpExcel'){
		            	$filename = $urlLocal['urlLocalPlugin']."/".$file."/info.xml";
						$info= @simplexml_load_file($filename);
						
						if(empty($info)){
							$info= (object) '';
							$info->app= '';
							$info->verName= '';
							$info->des= '';
							$info->author= '';
							$info->email= '';
							$info->web= '';
						}
					
			            if(in_array($file, $plugins['Option']['value']))
			            {
				            array_push($listFileShow, array('name'=>$file,'active'=>1,'info'=>$info));
			            }
			            else
			            {
				            array_push($listFileShow, array('name'=>$file,'active'=>0,'info'=>$info));
			            }
			        }
	            }
	            
	            foreach($plugins['Option']['value'] as $file)
	            {
		            if(!in_array($file, $listFile))
		            {
			            array_push($listFileShow, array('name'=>$file,'active'=>-1));
		            }
	            }
	            
	            $this->set('listFileShow',$listFileShow);
          }
          else 
          {
        	$urlLocal= $this->getUrlLocal();
            $this->redirect($urlLocal['urlAdmins'].'login');
          }
	}
	
	function list_files($directory = '.')
	{
		$listFile= array();
	    if ($directory != '.')
	    {
	        $directory = rtrim($directory, '/') . '/';
	    }
	    
	    if ($handle = opendir($directory))
	    {
	        while (false !== ($file = readdir($handle)))
	        {
	            if ($file != '.' && $file != '..')
	            {
	                array_push($listFile,  $file);
	            }
	        }
	        
	        closedir($handle);
	    }
	    return $listFile;
	}
	
	function activePlugin($nameFile)
	{
		//Configure::write('debug', 2);
		$users= $this->Session->read('infoAdminLogin');
		
		Controller::loadModel('Option');
    	$urlLocal= $this->getUrlLocal();
    	
        if($users)
        {
        	if($nameFile)
        	{
	        	$this->Option->activePlugin($nameFile);
        	}
        	$this->redirect($urlLocal['urlOptions'].'plugins');
        }
        else 
        {
            $this->redirect($urlLocal['urlAdmins'].'login');
        }
	}
	
	function deactivePlugin($nameFile)
	{
		//Configure::write('debug', 2);
		$users= $this->Session->read('infoAdminLogin');
		
		Controller::loadModel('Option');
    	$urlLocal= $this->getUrlLocal();
    	
        if($users)
        {
        	if($nameFile)
        	{
	        	$this->Option->deactivePlugin($nameFile);
        	}
        	$this->redirect($urlLocal['urlOptions'].'plugins');
        }
        else 
        {
            $this->redirect($urlLocal['urlAdmins'].'login');
        }
	}
	
	function deletePlugin($nameFile)
	{
		$users= $this->Session->read('infoAdminLogin');
		
		Controller::loadModel('Option');
    	$urlLocal= $this->getUrlLocal();
    	
        if($users)
        {
        	if($nameFile)
        	{
	        	$this->Option->deletePlugin($nameFile);
	        	$this->removeDirectory($urlLocal['urlLocalPlugin'].$nameFile) ;
        	}
        	$this->redirect($urlLocal['urlOptions'].'plugins');
        }
        else 
        {
            $this->redirect($urlLocal['urlAdmins'].'login');
        }
	}
	
	function removeDirectory($dir) 
	{
		if ($handle = opendir("$dir")) 
		{
			while (false !== ($item = readdir($handle))) 
			{
				if ($item != "." && $item != "..") 
				{
					if (is_dir("$dir/$item")) 
					{
						$this->removeDirectory("$dir/$item");
					} 
					else 
					{
						unlink("$dir/$item");
						//echo " removing $dir/$item<br>\n";
					}
				}
			}
			closedir($handle);
			rmdir($dir);
			//echo "removing $dir<br>\n";
		}
	}
  }
?>