<?php

   class AlbumsController extends AppController

   {

	    var $name = 'Albums';

        var $helpers = array('Session','Paginator');

        var $paginate = array();
		
		
// Quan ly album anh -----------------------------------------------------

        function listAlbums()
        {
        	//Configure::write('debug', 2);
            $users= $this->Session->read('infoAdminLogin');

            if($users)
            {
	            	$this->setup();
	            
                 	Controller::loadModel('Album');
				 	
				 	$dk= array();
                    $this->paginate = array(

                                            'limit' => 15,

                                            'conditions' => $dk,

                                            'order' => array('time' => 'desc'),

                                            );

                    $return = $this->paginate("Album");
                    
                    $this->set('listNotices', $return);
            }
            else 
            {
            	$urlLocal= $this->getUrlLocal();

	            $this->redirect($urlLocal['urlAdmins'].'login');
            }

        }

        function editInfoAlbum()
        {
	        $users= $this->Session->read('infoAdminLogin');

            if($users)
            {
            	Controller::loadModel('Album');
            	$this->setup();
            	$this->layout="default";
            	if($_POST['id']!='')
            	{
            		$id= new MongoId($_POST['id']);

					$return= $this->Album->getAlbum($id);

					$this->set('news', $return);
				}
            }
        }
        
        function saveAlbum()
        {   
        	//Configure::write('debug', 2);
            $users= $this->Session->read('infoAdminLogin');
        	$urlLocal= $this->getUrlLocal();
        	
            if($users)
            {
                //Controller::loadModel('Slug');
	            $this->setup();
	            Controller::loadModel('Album');
	            $title= $_POST['title'];
				$lock= (int) $_POST['lock'];
	            $image= $_POST['image'];

	            $key= $_POST['key'];

	            $id= $_POST['id'];
	            $slug= createSlugMantan(trim($_POST['title']));
                //$slug= $this->Slug->saveSlug($slug,'albums','index');

	            if($id=="") $id= null;

	            $today= getdate();
	            if($_POST['ngay'] && $_POST['thang'] && $_POST['nam'])
	            {
	              	$time= mktime($today['hours'], $today['minutes'], $today['seconds'], $_POST['thang'], $_POST['ngay'], $_POST['nam']);
	            }
	            else
	            {
	              	$time= $today[0];
	            }

	            if($title != "" && $image != "")
	            {
                	$return= $this->Album->saveAlbumNew($time,$title,$image,$key,$slug,$lock,$id);
                }
                
                $this->redirect($urlLocal['urlAlbums'].'infoAlbum/'.$return);

            }
            else 
            {
	            $this->redirect($urlLocal['urlAdmins'].'login');
            }

        }

        function infoAlbum($id)
        {
            //Configure::write('debug', 2);
            Controller::loadModel('Option');
        	$urlLocal= $this->getUrlLocal();

            $users= $this->Session->read('infoAdminLogin');
            if($users)
            {
	            $this->setup();
	            Controller::loadModel('Album');
                if(!$id) 
                {
                	$this->redirect($urlLocal['urlAlbums']);
                }
                else
                {
                  $albums= $this->Album->getAlbum($id);
                  $this->set('albums', $albums);
                }
            }
            else 
            {
	            $this->redirect($urlLocal['urlAdmins'].'login');
            }
        }

        function saveImgAlbum()
        {   //Configure::write('debug', 2);

            $users= $this->Session->read('infoAdminLogin');
        	$urlLocal= $this->getUrlLocal();

            if($users)
            {
	            Controller::loadModel('Album');
	            if($_POST['id']!='')
	            {
		            $id= new MongoId($_POST['id']);
	            }
                
                $idIMG= $_POST['idIMG'];
                $image= $_POST['image'];
                $note= $_POST['note'];
				$title= $_POST['title'];
				$description= $_POST['description'];
                $link= $_POST['link'];

                if($image!="")
                {
                  $return= $this->Album->saveImgAlbum($image,$note,$id,$link,$title,$description,$idIMG);
                }

                $this->redirect($urlLocal['urlAlbums'].'infoAlbum/'.$_POST['id']);

            }
            else 
            {
	            $this->redirect($urlLocal['urlAdmins'].'login');
            }
        }

        function deleteAlbum()
        {
            $users= $this->Session->read('infoAdminLogin');
        	$urlLocal= $this->getUrlLocal();
        	
            if($users)
            {
                if($_POST['id']!="")
                {

                  Controller::loadModel('Album');
                  Controller::loadModel('Slug');

				  $id= new MongoId($_POST['id']);
                  $data= $this->Album->find('first',array('conditions'=>array('_id'=>$id)));
                  if($data){
                    $this->Slug->deleteSlug($data['Album']['slug']);
                    $this->Album->delete($id);
                  }
                  

                }
                //$this->redirect($urlLocal['urlAlbums'].'listAlbums');
            }
            else 
            {
	            $this->redirect($urlLocal['urlAdmins'].'login');
            }

        }

        function deleteImgAlbum()
        {
            $users= $this->Session->read('infoAdminLogin');
            if($users)
            {
                if($_POST['idIMG']!="" && $_POST['idAlbum']!='')
                {

                  Controller::loadModel('Album');
				  $id= new MongoId($_POST['idAlbum']);
                  $idXoa= (int) $_POST['idIMG'];

                  $return= $this->Album->deleteImgAlbum($idXoa,$id);

                }
            }

        }
// Theme ------
        function index($slug=null)
        {
            $this->setup();
            $this->layout='default';
            $urlLocal= $this->getUrlLocal();
            Controller::loadModel('Album');
            
            global $infoSite;
            if(empty($slug)) $slug= $this->request->url;
            
            $slug= str_replace('.html', '', $slug);
            $infoAlbum= $this->Album->getSlugAlbum($slug);
            
            if($infoAlbum)
            {
                $this->set('infoAlbum', $infoAlbum);
                
                global $metaTitleMantan;
                $metaTitleMantan= $infoAlbum['Album']['title'];
            }
            else
            {
                $this->redirect($urlLocal['urlHomes']);
            }
            
            $this->set('slug', $slug);
        }

		function allAlbums()
		{
			$this->setup();
			$this->layout='default';
			$urlLocal= $this->getUrlLocal();
         	Controller::loadModel('Album');
         	
			global $infoSite;
			
     		$dk= array('lock'=>array('$ne'=>1) );
			$today= getdate();
			$dk['time']= array('$lte' => $today[0]);
			
			$page= (isset($_GET['page']))? (int) $_GET['page']:1;
			if($page<=0) $page=1;
			$limit= $infoSite['Option']['value']['postsOnThePage'];
			$order=array('time'=>'desc','created' => 'desc','title'=>'asc');
			$checkTime= true;
			
			$return = $this->Album->getPageData($page,$limit,$dk,$order,$checkTime);
			
			$totalData= $this->Album->find('count',array('conditions' => $dk));
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
            
            $this->set('listAlbums', $return);
            
            global $metaTitleMantan;
            $metaTitleMantan= 'Albums | '.$metaTitleMantan;
        
		}
         
    }
?>