<?php
   class Booking extends AppModel
   {
       var $name = 'Booking';
       
       function getPage($page,$limit,$conditions)
       {
	       $array= array(
	                        'limit' => $limit,
	                        'page' => $page,
	                        'order' => array('created' => 'desc'),
	                        'conditions' => $dk
	
	                    );
	       return $this -> find('all', $array);             
       }
       
       function saveBooking($date,$email,$fone,$numberDay,$numberRoom)
       {
       	   $today= getdate();
	       $Booking['Booking']['date']= $date;
	       $Booking['Booking']['time']= $today[0];
	       $Booking['Booking']['numberDay']= $numberDay;
	       $Booking['Booking']['email']= $email;
	       $Booking['Booking']['fone']= $fone;
	       $Booking['Booking']['numberRoom']= $numberRoom;
	       
	       $this->save($Booking);
       }
       
       function getBooking($idBooking)
       {
       		 $idBooking= new MongoId($idBooking);
	         $dk = array ('_id' => $idBooking);
	         $Booking = $this -> find('first', array('conditions' => $dk) );
	         return $Booking;
         
       }
       
       function deleteBooking($idBooking)
       {
       	   $this->delete($idBooking);
       }
       
     
   }
?>