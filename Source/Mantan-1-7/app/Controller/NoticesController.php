<?php
   class NoticesController extends AppController
   {
	    var $name = 'Notices';
	    var $helpers = array('Session','Paginator');

        var $paginate = array();
		
		
        
// Quan ly tin tuc         
       function listNotices()
       {
         //Configure::write('debug', 2);

         $users= $this->Session->read('infoAdminLogin');
         if($users)
         {
	         	$this->setup();
	           
	             
	            Controller::loadModel('Option');
	            Controller::loadModel('Notice');
	
	            $chuyenmuc= $this->Option->getOption('categoryNotice');
	
	            $this->set('chuyenmuc', (isset($chuyenmuc["Option"]['value']['category']))?$chuyenmuc["Option"]['value']['category']:array());
	             
             	$dk['type']= 'post';
             	
	            if(isset($_GET['category']) && $_GET['category']>0)
	            {
		            $dk['category']= (int) $_GET['category'];
	            }
	            
	            if(isset($_GET['key']) && $_GET['key']!='')
	            {
					$key= createSlugMantan($_GET['key']);
					$dk['slug']= array('$regex' => $key);
	            }
				
				$page= (isset($_GET['page']))? (int) $_GET['page']:1;
				if($page<=0) $page=1;
				$limit= 15;
				
				$order=array('time'=>'desc','created' => 'desc','title'=>'asc');
				$checkTime= false;
				$fields=array('title','slug','event','view');

				$return = $this->Notice->getPageData($page,$limit,$dk,$order,$checkTime,$fields);
                //debug($return);die;
                $cat= array();
                /*
                foreach($return as $tin)
                {
                	foreach($tin['Notice']['category'] as $catNoti)
                	{
		                if(!isset($cat[ $catNoti ] ))
		                {
				            $catName= $this->Option->getcat($chuyenmuc["Option"]['value']['category'],$catNoti);
				            //debug($catName);
				            $cat[ $catNoti ]= $catName['name'];
		                }
	                }
                }
                */
				
				$totalData= $this->Notice->find('count',array('conditions' => $dk));
				//$totalData= 10;
				$urlNow= curPageURL(1);
		
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
                
                $this->set('nameCat', $cat);
                $this->set('listNotices', $return);
				$this->set('page', $page);
				$this->set('totalPage', $totalPage);
				$this->set('back', $back);
				$this->set('next', $next);
				$this->set('urlPage', $urlPage);
         }
         else 
         {
        	$urlLocal= $this->getUrlLocal();
            $this->redirect($urlLocal['urlAdmins'].'login');
         }

       }
       
       function addNotices($idNotice=null)
       {
       		//Configure::write('debug', 2);
       	 	$users= $this->Session->read('infoAdminLogin');
       	 	if($users)
       	 	{
	         	 $this->setup();
	             
	             Controller::loadModel('Option');
	             Controller::loadModel('Notice');
	
	             $chuyenmuc= $this->Option->getOption('categoryNotice');

	             $chuyenmuc["Option"]['value']['category']= (isset($chuyenmuc["Option"]['value']['category']))?$chuyenmuc["Option"]['value']['category']:array();

	             $this->set('chuyenmuc', $chuyenmuc["Option"]['value']['category']);

                 if($idNotice)
                 {
                    $idNotice= new MongoId($idNotice);

                    $return= $this->Notice->getNotice($idNotice);

                    $this->set('news', $return);
                 }
             }
             else 
             {
            	$urlLocal= $this->getUrlLocal();
	            $this->redirect($urlLocal['urlAdmins'].'login');
             }
       }
       
       function deleteNotice()
       {
         //Configure::write('debug', 2);
       		global $urlHomes;
         $users= $this->Session->read('infoAdminLogin');
         if($users)
         {
           $id= $_POST['id'];

           if($id != "")
           {
           	 Controller::loadModel('Notice');
           	 Controller::loadModel('Slug');

             $id= new MongoId($id);
             $data= $this->Notice->find('first',array('conditions'=>array('_id'=>$id)));
              if($data){
                $this->Slug->deleteSlug($data['Notice']['slug']);
                $this->Notice->delete($id);

                $url= 'https://'.$_SERVER['SERVER_NAME'].'/'.$data['Notice']['slug'].'.html';
         		sendDataConnectMantan('https://index.manmo.vn/?url='.urlencode($url).'&type=URL_DELETED');

              }
              
             
           }

         }

       }
       
       function getCheckCat($cat,$check)
       {
       		if(isset($_POST['category'.$cat['id']]))
       		{
       			$idCat= (int) $_POST['category'.$cat['id']];
	       		array_push($check, $idCat);
       		}
       		
       		if(!empty($cat['sub'])){
				foreach($cat['sub'] as $sub)
				{
					$check= $this->getCheckCat($sub,$check);
				}
			}
			return $check;
	   }
		
       function saveNotices()
       {
	       //Configure::write('debug', 2);
         $users= $this->Session->read('infoAdminLogin');
         Controller::loadModel('Option');
    	 $urlLocal= $this->getUrlLocal();
    	 
         if($users)
         {
         	 $dataSend= $this->data;
             $title= trim($dataSend['title']);
             $title= str_replace('"', '’', $title);
             $title= str_replace("'", '’', $title);

             if($title != "")

             {

              Controller::loadModel('Notice');
              //Controller::loadModel('Slug');

              $key= trim($dataSend['key']);

              $image= trim($dataSend['image']);

              $content= trim($dataSend['content']);
              $content= str_replace('><br></', '></', $content);
              $slug= createSlugMantan(trim($dataSend['title']));
              //$slug= $this->Slug->saveSlug($slug,'notices','index');
	
	          $chuyenmucAll= $this->Option->getOption('categoryNotice');

              $category= (!empty($dataSend['category']))?$dataSend['category']:array();
              if(!empty($category)){
              	$catArry= array();
              	foreach($category as $cate){
              		$catArry[]= (int) $cate;
              	}
              	$category= $catArry;
              }

              $event= (isset($dataSend['event']))?(int) $dataSend['event']:0;
              
              $author= trim($dataSend['author']);
			  $introductory= trim($dataSend['introductory']);

              $id= trim($dataSend['id']);

              if($id=="") $id= null;
              
              $today= getdate();
              if(isset($dataSend['ngay']) && isset($dataSend['thang']) && isset($dataSend['nam']))
              {
	              $time= mktime($today['hours'], $today['minutes'], $today['seconds'], $dataSend['thang'], $dataSend['ngay'], $dataSend['nam']);
              }
              else
              {
	              $time= $today[0];
              }

              $return= $this->Notice->saveNotices($slug,$time,$author,$title,$key,$content,$category,$image,$event,$introductory,$id);

             }

             $this->redirect($urlLocal['urlNotices'].'listNotices');

           }
           else 
           {
	            $this->redirect($urlLocal['urlAdmins'].'login');
           }

       }
       
// Quan ly trang tinh -------------
	function listPages()
	{
		 //Configure::write('debug', 2);

         $users= $this->Session->read('infoAdminLogin');
         if($users)
         {
	         	$this->setup();
	            Controller::loadModel('Notice');
                $dk = array ('type' => 'page');
				
				if(isset($_GET['key']) && $_GET['key']!='')
	            {
		            $key= createSlugMantan($_GET['key']);  
					$dk['slug']= array('$regex' => $key);
	            }
	            
                $this->paginate = array(

                                        'limit' => 15,

                                        'conditions' => $dk,

                                        'order' => array('created' => 'desc'),

                                        );

                $return = $this->paginate("Notice");

                $this->set('listNotices', $return);
         }
         else 
         {
        	$urlLocal= $this->getUrlLocal();

            $this->redirect($urlLocal['urlAdmins'].'login');
         }
	}
	
	function addPage($idNotice='')
	{
		 $users= $this->Session->read('infoAdminLogin');

         if($users)
         {
         		$this->setup();
         		if($idNotice!='')
         		{
         			Controller::loadModel('Notice');
	            	$idNotice= new MongoId($idNotice);
	
	                $return= $this->Notice->getNotice($idNotice);
	                $this->set('news', $return);
                }
         }
         else 
         {
        	$urlLocal= $this->getUrlLocal();

            $this->redirect($urlLocal['urlAdmins'].'login');
         }
	}
	
	
       function savePages()
       {
	       //Configure::write('debug', 2);
         $users= $this->Session->read('infoAdminLogin');
    	 $urlLocal= $this->getUrlLocal();
    	
         if($users)
         {
         	 $dataSend= $this->data;
	         $title= trim($dataSend['title']);

	         if($title != "")
	         {
		      Controller::loadModel('Notice');
		      //Controller::loadModel('Slug');

              $key= trim($dataSend['key']);
              $author= trim($dataSend['author']);
              $content= trim($dataSend['content']);
              $content= str_replace('><br></', '></', $content);
              $slug= createSlugMantan(trim($dataSend['title']));
              $id= trim($dataSend['id']);
              $image= trim($dataSend['image']);
			  $introductory= trim($dataSend['introductory']);
			  //$slug= $this->Slug->saveSlug($slug,'notices','index');

              if($id=="") $id= null;
			  
			  $today= getdate();
              if(isset($dataSend['ngay']) && isset($dataSend['thang']) && isset($dataSend['nam']))
              {
	              $time= mktime($today['hours'], $today['minutes'], $today['seconds'], $dataSend['thang'], $dataSend['ngay'], $dataSend['nam']);
              }
              else
              {
	              $time= $today[0];
              }

              $return= $this->Notice->savePages($slug,$author,$title,$key,$content,$image,$introductory,$time,$id);

             }

             $this->redirect($urlLocal['urlNotices'].'listPages');

         }
         else 
         {
            $this->redirect($urlLocal['urlAdmins'].'login');
         }
       }
// Page - Post
	function index($slug='')
	{
		global $infoNotice;
		//Configure::write('debug', 2);
		Controller::loadModel('Notice');
		
		$this->setup();
		$this->layout='default';
		$urlLocal= $this->getUrlLocal();
		
		if(empty($slug)) $slug= $this->request->url;
		$slug= str_replace('.html', '', $slug);
		$infoNotice= $this->Notice->getSlugNotice($slug);
		
		if($infoNotice)
		{
			$this->set('infoNotice', $infoNotice);

			$conditionsOtherNotices= array('_id'=>array('$ne'=>new MongoId($infoNotice['Notice']['id']) ));
			
			if(isset($infoNotice['Notice']['category']) && count($infoNotice['Notice']['category'])>0) {
				$otherNotices = $this->Notice->getOtherNotice($infoNotice['Notice']['category'], 5, $conditionsOtherNotices);
				
			}else{
				$otherNotices = $this->Notice->getOtherPageNotice(5, $conditionsOtherNotices);
			}
			$this->set('otherNotices', $otherNotices);

			global $isPost;
			global $isPage;
			
			if($infoNotice['Notice']['type']=='post')
			{
				$isPost= true;
			}
			else
			{
				$isPage= true;
			}
			
			global $metaTitleMantan;
			global $metaKeywordsMantan;
			global $metaDescriptionMantan;
			global $metaImageMantan;
			global $urlHomes;
			
			$metaTitleMantan= $infoNotice['Notice']['title'];
			$metaKeywordsMantan= $infoNotice['Notice']['key'];
			$metaDescriptionMantan= $infoNotice['Notice']['introductory'];
			$metaImageMantan= $infoNotice['Notice']['image'];
			
			if(!empty($metaImageMantan) && strpos($metaImageMantan, 'http') === false) $metaImageMantan= $urlHomes.$metaImageMantan;
			
			$this->Notice->updateView($infoNotice['Notice']['id']);
		}
		else
		{
			$this->redirect($urlLocal['urlHomes']);
		}
	}     
// Page Category	
	function cat($slug=null)
	{
		//Configure::write('debug', 2);
		global $categoryNotice;
		global $isCategory;
		global $infoSite;
		
		$isCategory= true;
		
		$this->setup();
		$this->layout='default';
		
		Controller::loadModel('Notice');
		Controller::loadModel('Option');
		
		$urlLocal= $this->getUrlLocal();
		if(empty($slug)) $slug= $this->request->url;
		$slug= str_replace('.html', '', $slug);
		$category= $this->Option->getOption('categoryNotice');
		
		$category= $this->Option->getcat($category['Option']['value']['category'],$slug,'slug');
		
		if($category)
		{
			$dk = array ('category' => (int)$category['id']);
			$today= getdate();
			$dk['time']= array('$lte' => $today[0]);
			
			$page= (isset($_GET['page']))? (int) $_GET['page']:1;
			if($page<=0) $page=1;
			$limit= $infoSite['Option']['value']['postsOnThePage'];
			$order=array('time'=>'desc','created' => 'desc','title'=>'asc');
			$checkTime= true;

			$return = $this->Notice->getPageData($page,$limit,$dk,$order,$checkTime);
			
			$totalData= $this->Notice->find('count',array('conditions' => $dk));
			$urlNow= curPageURL(1);
	
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
			
			$this->set('page', $page);
			$this->set('totalPage', $totalPage);
			$this->set('back', $back);
			$this->set('next', $next);
			$this->set('urlPage', $urlPage);
	        
	        $this->set('listNotices', $return);
	        $this->set('category', $category);
	        
	        $categoryNotice= $category;
	        
	        global $metaTitleMantan;
			global $metaKeywordsMantan;
			global $metaDescriptionMantan;
			
			$metaTitleMantan= (isset($category['name']))?$category['name']:'';
			$metaKeywordsMantan= (isset($category['key']))?$category['key']:'';
			$metaDescriptionMantan= (isset($category['description']))?$category['description']:'';
        }
        else
		{
			$this->redirect($urlLocal['urlHomes']);
		}
        
	}
// Page Search	
	function search()
	{
		//Configure::write('debug', 2);
		global $isSearch;
		global $infoSite;
		$isSearch= true;
		
		$this->setup();
		$this->layout='default';
		
		Controller::loadModel('Notice');
		Controller::loadModel('Option');
		
		if(!isset($_GET['key'])) $_GET['key']= '';
		
		$conditions['$or'][0]['slug']= array('$regex' => createSlugMantan($_GET['key']));
		$conditions['$or'][1]['key']= array('$regex' => $_GET['key']);
		$conditions['$or'][2]['content']= array('$regex' => $_GET['key']);
		
		$today= getdate();
		$conditions['time']= array('$lte' => $today[0]);
		
		$page= (isset($_GET['page']))? (int) $_GET['page']:1;
		if($page<=0) $page=1;
		$limit= $infoSite['Option']['value']['postsOnThePage'];
		$order=array('time'=>'desc','created' => 'desc','title'=>'asc');
		$checkTime= true;
		
		$return = $this->Notice->getPageData($page,$limit,$conditions,$order,$checkTime);
		
		$totalData= $this->Notice->find('count',array('conditions' => $conditions));
		$urlNow=curPageURL(1);

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
		
		$this->set('page', $page);
		$this->set('totalPage', $totalPage);
		$this->set('back', $back);
		$this->set('next', $next);
		$this->set('urlPage', $urlPage);
		
		$this->set('listNotices', $return);
	}
   
   }
?>