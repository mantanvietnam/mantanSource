<?php
   class Color extends AppModel
   {
       var $name = 'Color';
       
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
       
       function saveColor($code,$color,$img,$id=null)
       {
	       $Color['Color']['code']= $code;
	       $Color['Color']['color']= $color;
	       $Color['Color']['img']= $img;
	       if ($id!=null)
	    		$Color['Color']['id']= $id;
	   		//debug ($Color);
	       $this->save($Color);
       }
       
       function getColor($idColor)
       {
       		 $idColor= new MongoId($idColor);
	         $dk = array ('_id' => $idColor);
	         $Color = $this -> find('first', array('conditions' => $dk) );
	         return $Color;
         
       }
       
       function deleteColor($idColor)
       {
       	   $this->delete($idColor);
       }
       
       function getColorByCode($code='')
       {
	         $dk = array ('code' => $code);
	         $Color = $this -> find('first', array('conditions' => $dk) );
	         return $Color;
         
       }
   }
?>