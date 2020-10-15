<?php

   class Admin extends AppModel

   {

       var $name = 'Admin';

      
       
       function getAdmin($id)
       {
       	   if($id!='')
       	   {
		       $id= new MongoId($id);
	           $dk = array ('_id' => $id);
	           $return = $this -> find('first', array('conditions' => $dk) );
           }
           return $return;
       }
       
       
       function checkLogin($user,$password)
       {

         $dk = array ('user' => $user,'password'=>$password);

         $lay= array ('password'=> 0);

         $users= $this -> find('first', array('conditions' => $dk,'fields' => $lay) );
        
         return $users;

       }
       
       function savePowers($account)
       {
	       $id= new MongoId($account['id']);
	       $dk= array('_id'=>$id);
	
	       $admins= $this -> find('first', array('conditions' => $dk) );
	       if($admins){
		       $admins['Admin']['powers']= $account['powers'];
		       $this->updateAll($admins['Admin'],$dk);
			   return 1;
	       }
	       return -1;
       }
       
       function saveAccount($account)
       {
         if($account['id']!='')
       	 {
			 $id= new MongoId($account['id']);
	         $dk= array('_id'=>$id);
	
	         $admins= $this -> find('first', array('conditions' => $dk) );
         }
         
         if($admins)
         {
           if($admins['Admin']['password']== md5($account['passOld']))
           {
             $admins['Admin']['password']= $account['pass1'];
           }
           else if($account['passOld']!='') return -3;
		   
		   $admins['Admin']['email']= $account['email'];
		   $admins['Admin']['information']= $account['information'];
		   $this->updateAll($admins['Admin'],$dk);
		   return 1;
         }
         else if($account['id']=='' && $account['user']!='')
         {
         	 $dk= array('user'=>$account['user']);
         	 $admins= $this -> find('first', array('conditions' => $dk) );
         	 if(!$admins)
         	 {
		         $admins['Admin']['email']= $account['email'];
				 $admins['Admin']['information']= $account['information'];
				 $admins['Admin']['password']= $account['pass1'];
				 $admins['Admin']['user']= $account['user'];
				 $this->save($admins);
				 return 1;
			 }
			 else return -1;
         }
         else return -1;

       }
       
       function saveAdmin($user,$pass,$powers)
       {
	       $save['Admin']['user']= $user;
	       $save['Admin']['password']= $pass;
	       $save['Admin']['powers']= $powers;
	       
	       $this->save($save);
       }

	   function changePass($passOld='',$passNew='',$id='')
	   {
	   		if($id!=''){
	   			$id= new MongoId($account['id']);
	            $dk= array('_id'=>$id);
         	    $admins= $this -> find('first', array('conditions' => $dk) );
         	    
         	    if(isset($admins['Admin']['password']) && $admins['Admin']['password']== md5($passOld))
	            {
					$save['password']= md5($passNew);
					$this->updateAll($save,$dk);
					return true;
	            }
	   		}
	   		
	   		return false;
	   }
   }

?>