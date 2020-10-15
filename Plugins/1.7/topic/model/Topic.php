<?php
class Topic extends AppModel
{
    var $name = 'Topic';
    function getPage($page, $limit, $condition){
        $array = array(
            'page' =>$page,
            'limit'=> $limit,
            'order'=>array('created'=> 'desc'),
            'conditions'=>$condition

        );
        return $this->find('all',$array);
    }
    function addTopic($topic,$id=null){
        if($id){
            $id = new MongoId($id);
            $dk=array('_id'=>$id);
            $this->updateAll($topic,$dk);
        }
        else
        {
            $save['Topic']=$topic;
            $this->save($save);
        }
    }
    function getTopic($idTopic){
//        $idTopic = new MongoId($idTopic);
        $dk = array('_id'=>$idTopic);
        $Topic = $this->find('all',array('conditions'=>$dk));
        return $Topic;
    }
    function deleteTopic($idTopic){
        $this->delete($idTopic);
    }

    function getTopicSlug($slug){
        
        $dk=array('slug'=>$slug);
        //debug($dk);die;
        $return = $this->find('first', array('conditions'=>$dk));
        // debug($return);die;
        return $return;
    }
    
    function getcat($cats,$idcat,$type='id'){
        foreach ($cats as $cat){
            if($cat[$type]==$idcat){
                return $cat;
            }
        }
        return null;
    }
    function getCateTopic($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    function getOtherTopic($category=array(),$limit=5,$conditions=array(),$page=1)
    {
//        if(!$category) {
//            $conditions['category']= null;
//        }else{
//            $conditions['category']= array('$in'=>$category);
//        }
//        debug($category);
//        debug($conditions);
//        die;
        $notice = $this -> find('all', array('page'=>$page,'conditions' => $conditions,'limit' =>$limit,'order' => array('time'=>'DESC','created'=> 'DESC')) );
//       debug($notice);die;
        return $notice;
    }
    
    function listTopic($idCate){
        $dk=array('Topic'=>$idCate);
        $notices = $this->find('all',array('category'=>$dk));
        return $notices;
    }

}

?>