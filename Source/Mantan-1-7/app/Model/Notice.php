<?php
   class Notice extends AppModel
   {
       var $name = 'Notice';

       function getNewNotice($limit=5,$fields=null,$page=1)
       {
       	  $dk = array ( 'type'=> 'post' );
		  $today= getdate();
		  $dk['time']= array('$lte' => $today[0]);
       	  
          $notices = $this->find('all', array('order' => array('time'=>'DESC','created'=> 'DESC'),
                                              'limit' =>$limit,
                                              'conditions' => $dk,
                                              'fields'=>$fields,
                                              'page'=>$page
                                            ));
          return $notices;
       }
       
       function getTopEventNotice($limit=5,$fields=null,$page=1)
       {
    	  $dk = array ( 'type'=> 'post','event'=>1 );
		  $today= getdate();
		  $dk['time']= array('$lte' => $today[0]);
       	  
          $notices = $this->find('all', array('order' => array('time'=>'DESC','created'=> 'DESC'),
                                              'limit' =>$limit,
                                              'conditions' => $dk,
                                              'fields'=>$fields,
                                              'page'=>$page
                                            ));
          return $notices;
       }
       
       function getTopViewNotice($limit=5,$fields=null,$page=1)
       {
    	  $dk = array ( 'type'=> 'post' );
		  $today= getdate();
		  $dk['time']= array('$lte' => $today[0]);
       	  
          $notices = $this->find('all', array('order' => array('view'=>'DESC','time'=>'DESC','created'=> 'DESC'),
                                              'limit' =>$limit,
                                              'conditions' => $dk,
                                              'fields'=>$fields,
                                              'page'=>1
                                            ));
          return $notices;
       }
	   
	   function getPageData($page=1,$limit=null,$conditions=array(),$order=array('time'=>'desc','created' => 'desc','title'=>'asc'),$checkTime= false,$fields=null)
       {
		   if($checkTime){
			  $today= getdate();
			  $conditions['time']= array('$lte' => $today[0]);
		  }
		  
	       $array= array(
	                        'limit' => $limit,
	                        'page' => $page,
	                        'order' => $order,
	                        'conditions' => $conditions,
	                         'fields'=>$fields
	                    );
         
	       return $this -> find('all', $array);             
       }
       
       function getAllPage($fields=null)
       {
	       $dk = array ( 'type'=>'page' );
	       $today= getdate();
		   $dk['time']= array('$lte' => $today[0]);
       	  
           $notices = $this->find('all', array( 'order' => array('time'=>'DESC','created'=> 'DESC'),
                                             
                                             	'conditions' => $dk,
                                              'fields'=>$fields
                                            ));
          return $notices;
       }
       
       function savePages($slug,$author,$title,$key,$content,$image,$introductory,$time,$id=null)
       {
        global $urlHomes;
       		 $modelSlug= ClassRegistry::init('Slug');

         if($id != null)
         {
            $id= new MongoId($id);
            $save= $this->getNotice($id);
         }
         else
         {
            $save['Notice']['view']= 0;
            $save['Notice']['_id']= new MongoId();
         }

         if(!isset($save['Notice']['idSlug'])) $save['Notice']['idSlug']= '';
         $infoSlug= $modelSlug->saveSlug($slug,$save['Notice']['idSlug'],'notices','index');
	       	 
	        
	         $save['Notice']['title']= $title;
	         $save['Notice']['key']= $key;
	         $save['Notice']['content']= $content;
	         $save['Notice']['author']= $author;
	         $save['Notice']['slug']= $infoSlug['slug'];
         $save['Notice']['idSlug']= $infoSlug['idSlug'];
	         $save['Notice']['type']= 'page';
	         $save['Notice']['image']= $image;
	         if($introductory!=''){
				 $save['Notice']['introductory']= $introductory;
			 }else{
				 $save['Notice']['introductory']= $this->getIntroductory($content,30);
			 }
			 
			 $save['Notice']['time']= (int)$time;
	         
	         $this->save($save);

           $url= 'https://'.$_SERVER['SERVER_NAME'].'/'.$save['Notice']['slug'].'.html';
            sendDataConnectMantan('https://index.manmo.vn/?url='.urlencode($url).'&type=URL_UPDATED');

	         return 1;
       }
       
       function updateView($idNotice)
       {
       	   if($idNotice!='')
       	   {
		       $save['$inc']['view']= 1;
		       $idNotice= new MongoId($idNotice);
		       $dk= array('_id'=>$idNotice);
		       $this->updateAll($save,$dk);
	       }
       }
       
       function saveNotices($slug,$time,$author,$title,$key,$content,$category,$image,$event,$introductory,$id= null)
       {

       	 $listSlug= array();
       	 $modelSlug= ClassRegistry::init('Slug');

         if($id != null)
         {
            $id= new MongoId($id);
            $save= $this->getNotice($id);
         }
         else
         {
            $save['Notice']['view']= 0;
            $save['Notice']['_id']= new MongoId();
         }

         if(!isset($save['Notice']['idSlug'])) $save['Notice']['idSlug']= '';
         $infoSlug= $modelSlug->saveSlug($slug,$save['Notice']['idSlug'],'notices','index');
       	 $title= str_replace('"', '’', $title);
         $title= str_replace("'", '’', $title);

       	 $save['Notice']['title']= $title;
         $save['Notice']['slug']= $infoSlug['slug'];
         $save['Notice']['idSlug']= $infoSlug['idSlug'];
         $save['Notice']['key']= $key;
         $save['Notice']['content']= $content;
         $save['Notice']['category']= $category;
         $save['Notice']['image']= $image;
         $save['Notice']['event']= $event;
         $save['Notice']['author']= $author;    
		 
         if($introductory!=''){
    			 $save['Notice']['introductory']= $introductory;
    		 }else{
    			 $save['Notice']['introductory']= $this->getIntroductory($content,30);
    		 }
         
         $save['Notice']['time']= (int)$time;
         $save['Notice']['type']= 'post';
         
         $this->save($save);

         $url= 'https://'.$_SERVER['SERVER_NAME'].'/'.$save['Notice']['slug'].'.html';
         sendDataConnectMantan('https://index.manmo.vn/?url='.urlencode($url).'&type=URL_UPDATED');

         return 1;
       }
       
       function getNotice($idNotice=null,$fields=null)
       {
         $dk = array ('_id' => $idNotice);
         $notice = $this -> find('first', array('conditions' => $dk,'fields'=>$fields) );
         return $notice;
       }
       
       function getOtherNotice($category=array(),$limit=5,$conditions=array(),$page=1,$fields=null)
       {
       		 if(!$category) {
	       		 $conditions['category']= null;
       		 }else{
	         	$conditions['category']= array('$in'=>$category);
	         }
			 
			     $today= getdate();
			     $conditions['time']= array('$lte' => $today[0]);
			  
	         $notice = $this -> find('all', array('page'=>$page,'fields'=>$fields,'conditions' => $conditions,'limit' =>$limit,'order' => array('time'=>'DESC','created'=> 'DESC')) );
	         return $notice;
       }

       function getOtherPageNotice($limit=5,$conditions=array(),$page=1,$fields=null)
       {
          $conditions['type']= 'page';
  
           $notice = $this -> find('all', array('page'=>$page,'fields'=>$fields,'conditions' => $conditions,'limit' =>$limit,'order' => array('time'=>'DESC','created'=> 'DESC')) );
           return $notice;
       }
       
       function getSlugNotice($slug='',$fields=null)
       {
         $dk = array ('slug' => $slug);
         $notice = $this -> find('first', array('conditions' => $dk,'fields'=>$fields) );
         return $notice;
       }

        function getIntroductory($document,$soTu)
        {
          //$modau= $this->tachHTML($document);
          $modau= strip_tags($document, ""); 
		  $modau= str_replace('\r','',$modau);
		  $modau= str_replace('\n','',$modau);
		  $modau= str_replace('\t','',$modau);
		  
          $st= explode(" ", $modau);
          $modau= "";
          for($i=0;$i<$soTu;$i++)
          {
            if(isset($st[$i]))
            $modau= $modau." ".$st[$i];
          }
          $modau= $modau." ...";
          return $modau;
        }
        
        
   }
?>