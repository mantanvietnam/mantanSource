<?php
	class Order extends AppModel
   {
       var $name = 'Order';
       
       function getPage($page=1,$limit=15,$conditions=array(),$order=array('lock' => 'asc','created' => 'desc'))
       {
	       $array= array(
	                        'limit' => $limit,
	                        'page' => $page,
	                        'order' => $order,
	                        'conditions' => $conditions
	
	                    );
	       return $this -> find('all', $array);             
       }
       
       function saveOrder($fullname,$email,$phone,$address,$note,$listProduct,$userId,$totalMoney,$totalMass,$transportFee,$district)
       {
       	   $today= getdate();

       	   $save['Order']['fullname']= $fullname;
       	   $save['Order']['email']= $email;
       	   $save['Order']['phone']= $phone;
       	   $save['Order']['address']= $address;
       	   $save['Order']['note']= $note;
	       $save['Order']['listProduct']= $listProduct;
	       $save['Order']['userId']= $userId;
	       $save['Order']['totalMoney']= $totalMoney;
	       $save['Order']['lock']= 0;
	       $save['Order']['time']= $today[0];
	       $save['Order']['transportFee']= $transportFee;
	       $save['Order']['totalMass']= $totalMass;
	       $save['Order']['district']= $district;
	     
	       $this->save($save);
       }
       
       function updateOrder($fullname,$email,$phone,$address,$note,$id,$lock)
       {
	       $id= new MongoId($id);
	       $dk = array ('_id' => $id);
	       $update['fullname']= $fullname;
	       $update['email']= $email;
	       $update['phone']= $phone;
	       $update['address']= $address;
	       $update['note']= $note;
	       $update['lock']= $lock;
	       
	       $this->updateAll($update,$dk);
       }
       
       function getOrder($id)
       {
       		 $id= new MongoId($id);
	         $dk = array ('_id' => $id);
	         $return = $this -> find('first', array('conditions' => $dk) );
	         return $return;
         
       }
   }
?>