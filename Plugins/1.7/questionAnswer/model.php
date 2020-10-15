<?php
   class Question extends AppModel
   {
       var $name = 'Question';
       
       function getPage($page=1,$limit=15,$conditions=array(),$fields=array())
       {
	       $array= array(
	                        'limit' => $limit,
	                        'page' => $page,
	                        'order' => array('created' => 'desc','active'=>'asc'),
	                        'conditions' => $conditions,
							'fields' => $fields
	                    );
	       return $this -> find('all', $array);             
       }
       
       function saveQuestion($title,$fullName,$email,$fone,$content,$address,$category)
       {
       	   $today= getdate();
	       $question['Question']['content']= nl2br($content);
	       $question['Question']['active']= 0;
	       $question['Question']['title']= $title;
	       $question['Question']['time']= $today[0];
	       $question['Question']['fullName']= $fullName;
	       $question['Question']['email']= $email;
	       $question['Question']['fone']= $fone;
	       $question['Question']['address']= $address;
	       $question['Question']['category']= $category;
	       
	       $this->save($question);
       }
       
       function getQuestion($idQuestion)
       {
	         $dk = array ('_id' => $idQuestion);
	         $question = $this -> find('first', array('conditions' => $dk) );
	         return $question;
         
       }
       
       function deleteQuestion($idQuestion)
       {
       	   $this->delete($idQuestion);
       }
       
       function saveReply($title,$idQuestion,$answer)
       {
	       $question= $this->getQuestion($idQuestion);
	       $today= getdate();
	       if($question)
	       {
		       $question['Question']['answer']= $answer;
		       $question['Question']['active']= 1;
		       $question['Question']['title']= $title;
		       $question['Question']['time']= $today[0];
		       $this->save($question, false, array('answer','active','title','time'));
	       }
       }
   }
?>