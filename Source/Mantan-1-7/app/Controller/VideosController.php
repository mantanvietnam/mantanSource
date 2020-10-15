<?php
   class VideosController extends AppController
   {
	    var $name = 'Videos';
	    var $helpers = array('Session','Paginator');

        var $paginate = array();
        
       function listVideos()
       {
         //Configure::write('debug', 2);

         $users= $this->Session->read('infoAdminLogin');
         if($users)
         {
	         	 $this->setup();
	             
	             Controller::loadModel('Video');
				 $dk= array();
                 $this->paginate = array(

                                        'limit' => 15,

                                        'conditions' => $dk,

                                        'order' => array('created'=> 'DESC')

                                        );

                
                $return = $this->paginate("Video");
                
                $this->set('listData', $return);


         }
         else 
         {
        	$urlLocal= $this->getUrlLocal();

            $this->redirect($urlLocal['urlAdmins'].'login');
         }

       }
   
       function saveData()
       {
	       $users= $this->Session->read('infoAdminLogin');
	       
        	$urlLocal= $this->getUrlLocal();
        	
	       if($users)
	       {
	       		Controller::loadModel('Video');
	       		//Controller::loadModel('Slug');

	       		$name= $_POST['name'];
	       		$code= $_POST['code'];
				
				$image= ($_POST['image']!='')?$_POST['image']:"http://img.youtube.com/vi/".$_POST['code']."/0.jpg";
				$description= $_POST['description'];
				
	       		$id= $_POST['id'];
	       		$slug= createSlugMantan($name);
	       		//$slug= $this->Slug->saveSlug($slug,'videos','index');

	       		$this->Video->saveData($name,$code,$slug,$image,$description,$id);
	       		$this->redirect($urlLocal['urlVideos'].'listVideos');
	       }
	       else 
           {
	            $this->redirect($urlLocal['urlAdmins'].'login');
           }
       }
       
       function deleteData()
       {
	       $users= $this->Session->read('infoAdminLogin');
	       if($users)
	       {
	       		if($_POST['id'])
	       		{
	       			Controller::loadModel('Video');
	       			Controller::loadModel('Slug');

		       		$id= new MongoId($_POST['id']);
		       		$data= $this->Video->find('first',array('conditions'=>array('_id'=>$id)));
	                  if($data){
	                    $this->Slug->deleteSlug($data['Video']['slug']);
	                    $this->Video->delete($id);
	                  }
	                  
	       		}
	       }
       }
// Theme ------
       function allVideos()
		{
			$this->setup();
			$this->layout='default';
			
			$urlLocal= $this->getUrlLocal();
         	Controller::loadModel('Video');
         	global $infoSite;
     	
			$today= getdate();
			$dk['time']= array('$lte' => $today[0]);
			
			$page= (isset($_GET['page']))? (int) $_GET['page']:1;
			if($page<=0) $page=1;
			$limit= $infoSite['Option']['value']['postsOnThePage'];
			$order=array('time'=>'desc','created' => 'desc','name'=>'asc');
			$checkTime= true;
			
			$return = $this->Video->getPageData($page,$limit,$dk,$order,$checkTime);
			
			$totalData= $this->Video->find('count',array('conditions' => $dk));
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
            
            $this->set('listVideos', $return);
            
            global $metaTitleMantan;
            $metaTitleMantan= 'Videos | '.$metaTitleMantan;
		}	

		function index($slug=null)
		{
			$this->setup();
			$this->layout='default';
			
			$urlLocal= $this->getUrlLocal();
         	Controller::loadModel('Video');
         	global $infoSite;
         	if(empty($slug)) $slug= $this->request->url;
     	
        	$slug= str_replace('.html', '', $slug);
            $infoVideo= $this->Video->getSlugVideo($slug);
            
            if($infoVideo)
            {
            	$this->set('infoVideo', $infoVideo);
            	
            	global $metaTitleMantan;
				$metaTitleMantan= $infoVideo['Video']['name'].' | '.$metaTitleMantan;
            }
            else
			{
				$this->redirect($urlLocal['urlHomes']);
			}

            $this->set('slug', $slug);
		}	   
   }
?>