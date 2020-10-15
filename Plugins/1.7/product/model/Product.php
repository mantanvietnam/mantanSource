<?php
	class Product extends AppModel
   {
       var $name = 'Product';
       
       function getPage($page=1,$limit=null,$conditions=array(),$order=array('timeUp'=>'desc','created' => 'desc','title'=>'asc'))
       {
	       $array= array(
	                        'limit' => $limit,
	                        'page' => $page,
	                        'order' => $order,
	                        'conditions' => $conditions
	
	                    );
	       return $this -> find('all', $array);             
       }
       
       function saveProduct($save,$id=null)
       {
	       if($id)
       	   {
	       	   $id= new MongoId($id);
	       	   $dk = array ('_id' => $id);
	       	   $this->updateAll($save['Product'],$dk);
       	   }
       	   else
       	   {
       	   	   $save['Product']['view']= 0;
	       	   $this->save($save);
	       }
       }
       
       function getProduct($id)
       {
       		 $id= new MongoId($id);
	         $dk = array ('_id' => $id);
	         $return = $this -> find('first', array('conditions' => $dk) );
	         return $return;
         
       }
       
       function updateView($id)
       {
	       $id= new MongoId($id);
	       $dk = array ('_id' => $id);
	       $product['$inc']['view']= 1;
	       $this->updateAll($product,$dk);
       }
       
       function getProductSlug($slug)
       {
	         $dk = array ('slug' => $slug);
	         $return = $this -> find('first', array('conditions' => $dk) );
	         return $return;
         
       }
       
       function getOtherData($limit=5,$conditions)
       {
	         $return = $this -> find('all', array(	'conditions' => $conditions,
	         										'order' => array('created'=> 'DESC'),
	         										'limit' =>$limit 
	         									));
	         return $return;
       }
       
       function getcat($cats= array(),$idCat,$type='id')
	   {
	   		if(count($cats)>0){
				foreach($cats as $cat)
				{
					if($cat[$type]==$idCat)
					{
						return $cat;
					}
					else
					{
						if(isset($cat['sub']) && count($cat['sub'])>0){
							$return= $this->getcat($cat['sub'],$idCat,$type);
		
							if($return) return $return;
						}
					}
				}
			}
			return null;
	   }
       
   }
?>