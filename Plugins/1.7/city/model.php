<?php
   class City extends AppModel
   {
       var $name = 'City';
       
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
       
      
       function getCity($idCity)
       {
       		 $idCity= new MongoId($idCity);
	         $dk = array ('_id' => $idCity);
	         $City = $this -> find('first', array('conditions' => $dk) );
	         return $City;
         
       }
       
       function deleteCity($idCity)
       {
       	   $this->delete($idCity);
       }
       
     
   }
?>