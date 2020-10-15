<?php
   class Feedback extends AppModel
   {
       var $name = 'Feedback';
       
       function getPage($page=1,$limit=15,$conditions=array())
       {
	       $array= array(
	                        'limit' => $limit,
	                        'page' => $page,
	                        'order' => array('created' => 'desc'),
	                        'conditions' => $conditions
	
	                    );
	       return $this -> find('all', $array);             
       }
       
       function saveFeedback($feedback,$id=null)
       {
       	   if($id)
       	   {
       	   	   $id= new MongoId($id);
	       	   $dk = array ('_id' => $id);
	       	   
	       	   $this->updateAll($feedback,$dk);
       	   }
       	   else
       	   {
	       	   $save['Feedback']= $feedback;
	       	   $this->save($save);
       	   }
       }
       
       function getFeedback($idFeedback)
       {
       		 $idFeedback= new MongoId($idFeedback);
	         $dk = array ('_id' => $idFeedback);
	         $Feedback = $this -> find('first', array('conditions' => $dk) );
	         return $Feedback;
         
       }
       
       function deleteFeedback($idFeedback)
       {
       	   $this->delete($idFeedback);
       }
       
     
   }
?>