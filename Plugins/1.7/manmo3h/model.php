<?php
   class DK extends AppModel
   {
       var $name = 'DK';
       
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
       
       function getDK($idDK)
       {
           $idDK= new MongoId($idDK);
           $dk = array ('_id' => $idDK);
           $Feedback = $this -> find('first', array('conditions' => $dk) );
           return $Feedback;
         
       }
       
       function deleteDK($idDK)
       {
           $this->delete($idDK);
       }
       
     
   }
?>