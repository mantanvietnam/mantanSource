<?php
   class Video extends AppModel
   {
       var $name = 'Video';

       function getNewVideo($limit=5,$dk=array())
       {
       	  $listData = $this->find('all', array('order' => array('time'=> 'DESC'),
                                              'limit' =>$limit,
                                              'conditions' => $dk

                                            ));
          return $listData;
       }
	   
	   function getPageData($page=1,$limit=null,$conditions=array(),$order=array('time'=>'desc','created' => 'desc','name'=>'asc'),$checkTime= false)
       {
		   if($checkTime){
			  $today= getdate();
			  $conditions['time']= array('$lte' => $today[0]);
		  }
		  
	       $array= array(
	                        'limit' => $limit,
	                        'page' => $page,
	                        'order' => $order,
	                        'conditions' => $conditions
	
	                    );
	       return $this -> find('all', $array);             
       }
       
       function saveData($name,$code,$slug,$image,$description,$id= null)
       {
       		 $modelSlug= ClassRegistry::init('Slug');
	         if($id)
	         {
	            $id= new MongoId($id);
	            $save= $this->getVideo($id);
	         }
	         else
	         {
	            $today= getdate();
	            $save['Video']['time']= $today[0];
	            $save['Video']['view']= 0;
	         }
	         if(!isset($save['Video']['idSlug'])) $save['Video']['idSlug']= '';
         	$infoSlug= $modelSlug->saveSlug($slug,$save['Video']['idSlug'],'videos','index');

	         $save['Video']['name']= $name;
	         $save['Video']['code']= $code;
	         $save['Video']['slug']= $infoSlug['slug'];
         	$save['Video']['idSlug']= $infoSlug['idSlug'];
			 $save['Video']['image']= $image;
			 $save['Video']['description']= $description;
	
	         $this->save($save);
	         return 1;
       }
       
       function getVideo($id)
       {
         $dk = array ('_id' => $id);
         $return = $this -> find('first', array('conditions' => $dk) );
         return $return;
       }
       
       function getSlugVideo($slug)
       {
         $dk = array ('slug' => $slug);
         $return = $this -> find('first', array('conditions' => $dk) );
         return $return;
       }

   }
?>