<?php
   class Brochure extends AppModel
   {
       var $name = 'Brochure';
       
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
       
       function saveBrochure($fullName,$email,$fone,$contentFull)
       {
       	   $today= getdate();
	       $Brochure['Brochure']['time']= $today[0];
	       $Brochure['Brochure']['fullName']= $fullName;
	       $Brochure['Brochure']['email']= $email;
	       $Brochure['Brochure']['fone']= $fone;
	       $Brochure['Brochure']['content']= $contentFull;

	       $this->save($Brochure);
       }
       
       function getBrochure($idBrochure)
       {
		   $idBrochure= new MongoId($idBrochure);
	         $dk = array ('_id' => $idBrochure);
	         $Brochure = $this -> find('first', array('conditions' => $dk) );
	         return $Brochure;
         
       }
       
       function deleteBrochure($idBrochure)
       {
       	   $this->delete($idBrochure);
       }
       
     
   }
?>