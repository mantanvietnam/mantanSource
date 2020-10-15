<?php
   class Manager extends AppModel
   {
       var $name = 'Manager';
       
       function getPage($page,$limit,$conditions)
       {
	       $array= array(
	                        'limit' => $limit,
	                        'page' => $page,
	                        'order' => array('created' => 'desc'),
	                        'conditions' => $conditions
	
	                    );
	       return $this -> find('all', $array);             
       }
       
       function saveManager($document,$id=null)
       {
       	   if($id)
       	   {
       	   	   $id= new MongoId($id);
	       	   $dk = array ('_id' => $id);
	       	   
	       	   $this->updateAll($document,$dk);
       	   }
       	   else
       	   {
	       	   $save['Manager']= $document;
	       	   $this->save($save);
       	   }
       }
       
       function getManager($idDocument)
       {
       		 $idDocument= new MongoId($idDocument);
	         $dk = array ('_id' => $idDocument);
	         $Document = $this -> find('first', array('conditions' => $dk) );
	         return $Document;
         
       }
       
       function deleteManager($idDocument)
       {
          // echo "delete";
       	   $this->delete($idDocument);

       }
       
       function getManagerSlug($slug)
       {
           $$idDocument= new MongoId($idDocument);
           $dk = array ('slug' => $slug);
           $return = $this -> find('first', array('conditions' => $dk) );
           return $return;
         
       }

       function getcat($cats,$idCat,$type='id')
       {
        foreach($cats as $cat)
        {
          if($cat[$type]==$idCat)
          {
            return $cat;
          }
          
        }
        return null;
       }
     
   }
?>