<?php
class Comment extends AppModel
{
    var $name = 'Comment';
    function getPage($page, $limit, $condition){
        $array = array(
            'page' =>$page,
            'limit'=> $limit,
            'order'=>array('created'=> 'desc'),
            'condition'=>$condition

        );
        return $this->find('all',$array);
    }

    function getComment($idComment)
    {
        $dk = array ('_id' => $idComment);
        $comment = $this -> find('first', array('conditions' => $dk) );
        return $comment;

    }


    function getCommentTopic($idTopic)
    {
        $dk = array ('topicID' => $idTopic);
        $comment = $this -> find('first', array('conditions' => $dk) );
//       debug($comment);die;
        return $comment;

    }
    function getListComment(){

            $listComment=$this->find('all',array('order'=>array('created'=> 'desc')));
//            debug($listComment);die;
            return $listComment;

    }
    function deleteComment($idComment)
    {
        $this->delete($idComment);
    }
    function saveComment($comment,$id=null){
        if($id){
            $id = new MongoId($id);
            $dk=array('_id'=>$id);
            $this->updateAll($comment,$dk);
        }
        else
        {
            $save=$comment;
            $this->save($save);
        }
    }
    function updateComment($id){
        $dk = array ('_id' => $id);
        $comment = $this -> find('first', array('conditions' => $dk) );
//        debug($comment);die;
            $comment['Comment']['lock']= 0;
            $this->save($comment);
            
            
            return $comment;
    }

    function getGroupTopic($input){
//        debug($input);die;
        $dk=array('parentID'=> $input);
        $group=$this->find('first',array('conditions'=> $dk));
        debug($group);die;
        return $group;
    }

}

?>