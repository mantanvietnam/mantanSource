<?php
   class Appointment extends AppModel
   {
       var $name = 'Appointment';
       
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
       
       function saveAppointment($pm_app_form_name,$pm_app_form_email,$pm_app_form_phone,$pm_app_form_date,$pm_app_form_time)
       {
       	   $today= getdate();

	       $Appointment['Appointment']['time']= $today[0];
               $Appointment['Appointment']['pm_app_form_name']= $pm_app_form_name;
	       $Appointment['Appointment']['pm_app_form_email']= $pm_app_form_email;
	       $Appointment['Appointment']['pm_app_form_phone']= $pm_app_form_phone;
	       $Appointment['Appointment']['pm_app_form_date']= $pm_app_form_date;
	       $Appointment['Appointment']['pm_app_form_time']= $pm_app_form_time;
	       
	       $this->save($Appointment);
       }
       
       function getAppointment($idAppointment)
       {
       		 $idAppointment= new MongoId($idAppointment);
	         $dk = array ('_id' => $idAppointment);
	         $Appointment = $this -> find('first', array('conditions' => $dk) );
	         return $Appointment;
         
       }
       
       function deleteAppointment($idAppointment)
       {
       	   $this->delete($idAppointment);
       }
       
     
   }
?>