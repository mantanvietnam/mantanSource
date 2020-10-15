<?php
function categoryTopic($input){

    global $modelOption;
    global $urlHomes;
    if(checkAdminLogin()){
        $listData=$modelOption->getOption('topicCategory');

        setVariable('listData',$listData);
    }else{
        $modelOption->redirect($urlHomes);
    }
}
function addCategory($input){
    global $modelOption;
    global $urlPlugins;
    global $urlHomes;
    if(checkAdminLogin()) {
        $dataSend = $input['request']->data;
        $name = $dataSend['name'];
        $type = $dataSend['type'];
        $author = $dataSend['author'];
        $lock = $dataSend['lock'];
        $slug = createSlugMantan($dataSend['name']);
        if($name!='' && $type=='save')
        {
            $listData= $modelOption->getOption('topicCategory');

            if($dataSend['id']=='')
            {
                if(empty($listData['Option']['value']['tData'])){
                    $listData['Option']['value']['tData']= 1;
                }else{
                    $listData['Option']['value']['tData'] += 1;
                }

                $listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]= array( 'id'=> $listData['Option']['value']['tData'], 'name'=>$name,'slug'=>$slug, 'author'=>$author, 'lock'=>$lock );
            }
            else
            {
                $idClassEdit= (int) $dataSend['id'];
                $listData['Option']['value']['allData'][$idClassEdit]['name']= $name;
                $listData['Option']['value']['allData'][$idClassEdit]['slug']= $slug;
               $listData['Option']['value']['allData'][$idClassEdit]['author']= $author;
               $listData['Option']['value']['allData'][$idClassEdit]['lock']= $lock;
            }

            $modelOption->saveOption('topicCategory',$listData['Option']['value']);

        }
        else if($type=='delete')
        {
            $idDelete= (int) $dataSend['id'];
            $listData= $modelOption->getOption('topicCategory');
            unset($listData['Option']['value']['allData'][$idDelete]);
            $modelOption->saveOption('topicCategory',$listData['Option']['value']);
        }
        if($dataSend['redirect']>0)
        {
            $modelOption->redirect($urlPlugins.'admin/topic-admin-listCategoryTopics.php');
        }
    }else{
        $modelOption->redirect($urlHomes);

    }

}
function addTopic($input){
    global $urlPlugins;
    global $urlHomes;
    global $modelOption;
    global $userAdmins;

    if(checkAdminLogin()){

        $modelTopic= new Topic();
        $dataSend= $input['request']->data;

        $topic['name']= $dataSend['name'];
        $topic['user']= $dataSend['user'];
        $topic['slug']= createSlugMantan($dataSend['name']);
        $topic['file']= $dataSend['file'];
        $topic['category']= $dataSend['category'];
        $topic['image']= $dataSend['image'];
        $topic['description']= $dataSend['description'];
        $topic['author']= $dataSend['author'];
        $topic['content']= $dataSend['content'];
        $topic['idAdmin']= $userAdmins['Admin']['id'];

        $data = $modelTopic->addTopic($topic,$dataSend['id']);
        $modelTopic->redirect($urlPlugins.'admin/topic-admin-listTopics.php');

    }else{
        $modelOption->redirect($urlHomes);
    }
}
function deleteTopic($input){
    global $modelOption;
    global $urlHomes;
    global $urlPlugins;
    if (checkAdminLogin()){
        $modelTopic = new Topic();
        $data = $modelTopic->deleteTopic($input['request']->params['pass'][1]);
        $modelTopic->redirect($urlPlugins.'admin/topic-admin-listTopics.php');
    }
    else
    {
        $modelOption->redirect($urlHomes);
    }
}
function deleteComment($input){
    global $modelOption;
    global $urlHomes;
    global $urlPlugins;

    if(checkAdminLogin()){
        $modelComment = new Comment();
        $data=$modelComment->deleteComment($input['request']->params['pass'][1]);
        $modelComment->redirect($urlPlugins.'admin/topic-admin-listComments.php');

    }  else
    {
        $modelOption->redirect($urlHomes);
    }
}
function listTopics($input){
    global $modelOption;
    global $urlHomes;
    global $userAdmins;
    if(checkAdminLogin()){
        $modelTopic=new Topic();
        $page = 1;
        $limit = 15;
        $listTopic = $modelTopic->getPage($page, $limit, $conditions =array('idAdmin'=>$userAdmins['Admin']['id']));
        
        $listData = $modelOption->getOption('topicCategory');
        setVariable('listData',$listData);
        setVariable('listTopic',$listTopic);
    }
    else {
        $modelOption->redirect($urlHomes);
    }
}

function listCategoryTopics($input){
    global $modelOption;
    global $urlHomes;
    if(checkAdminLogin()){
        $listData = $modelOption->getOption('topicCategory');
        setVariable('listData',$listData);
    } else{
        $modelOption->redirect($urlHomes);
    }

}

function addTopics($input){
    global $modelOption;
    global $urlHomes;

    if(checkAdminLogin()){
        $listDataDetail = $modelOption->getOption('topic');
        $listData = $modelOption->getOption('topicCategory');
        $modelTopic = new Topic();
        if(isset($input['request']->params['pass'][1])){
            $data = $modelTopic->getTopic($input['request']->params['pass'][1]);
            setVariable('data',$data);
        }
        setVariable('listData',$listData);
        setVariable('listDataDetail',$listDataDetail);

    }
    else {
        $modelOption->redirect($urlHomes);
    }
}

function viewDetail($input) {

    global $urlHomes;

    if(isset($_GET['page'])){
        $page= (int) $_GET['page'];
    } else {
        $page=1;
    }
    $limit =5;
    $modelTopic = new Topic();
    $data= $modelTopic->getTopicSlug($input['request']->params['pass'][1]);
    $conditions= array('category'=> $data['Topic']['category']);
    $category=$modelTopic->getPage($page,$limit=null,$conditions);
    $otherData=$modelTopic->getOtherTopic($category,$limit,$conditions,$page);
    $modelComment = new Comment();
    $listComment = $modelComment->getListComment($data['Topic']['id']);

    $root =[];
    $all = [];
    if(!empty($listComment)){
        foreach ($listComment as $comment){
            if($comment['Comment']['parentID']==0){
                $comment['Comment']['child']=[];
                $root[]=$comment;
            } else {
                $sub[]=$comment;
            }

        }
        if(!empty($sub)){
            foreach ($root as $parentC ){
                foreach ($sub as $c){
                    if ($c['Comment']['parentID']==$parentC['Comment']['id']){
                        $parentC['Comment']['child'][]= $c;

                    }
                }
                $all[]=$parentC;
            }

        } else{
           $all = $listComment;
        }

    }
//    setVariable('listComment',$listComment);
    setVariable('listTopic',$data);
    setVariable('listCmt',$all);
    setVariable('otherData',$otherData);
}

function listViewCate($input){
    global $modelOption;
    global $urlNow;
    $modelTopic= new Topic();

    if(isset($_GET['page'])){
        $page= (int) $_GET['page'];
    } else {
        $page=1;
    }
    $limit= 16;
    $data = $modelOption->getOption('topicCategory');
    $topicCate = $modelOption->getOption('topicCategory');
    $conditions= null;
    $category= null;

    if(!empty($input['request']->params['pass'][1])){
        $slug = str_replace('.html', '', $input['request']->params['pass'][1]);
        $category= $modelTopic->getcat($data['Option']['value']['allData'],$slug,'slug');
        $conditions= array('category'=> (string)$category['id']);
        $listNotices= $modelTopic->getPage($page,$limit,$conditions);
    }else{
        $listNotices= $modelTopic->getPage($page,$limit,$conditions);
    }

    // $listNotices = showListDocument($limit, $conditions);
    $totalData= $modelTopic->find('count',array('conditions' => $conditions));

    $balance= $totalData%$limit;
    $totalPage= ($totalData-$balance)/$limit;
    if($balance>0)$totalPage+=1;

    $back=$page-1;$next=$page+1;
    if($back<=0) $back=1;
    if($next>=$totalPage) $next=$totalPage;

    if(isset($_GET['page'])){
        $urlPage= str_replace('&page='.$_GET['page'], '', $urlNow);
        $urlPage= str_replace('page='.$_GET['page'], '', $urlPage);
    }else{
        $urlPage= $urlNow;
    }

    if(strpos($urlPage,'?')!== false){
        if(count($_GET)>=1){
            $urlPage= $urlPage.'&page=';
        }else{
            $urlPage= $urlPage.'page=';
        }
    }else{
        $urlPage= $urlPage.'?page=';
    }
    setVariable('listNotices',$listNotices);
    setVariable('category', $category);
    setVariable('topicCate', $topicCate);
    setVariable('page',$page);
    setVariable('totalPage',$totalPage);
    setVariable('back',$back);
    setVariable('next',$next);
    setVariable('urlPage',$urlPage);

}
function saveUser($input){

    global $urlHomes;
    global $isRequestPost;
    global $contactSite;
    global $smtpSite;
    global $modelOption;
    global $urlLocal;

    $input['request']->data= arrayMap($input['request']->data);
    $modelUser= new User();
    $dataSend= $input['request']->data;

    if(isset($dataSend['fullname']) && isset($dataSend['username']) && isset($dataSend['email']) && isset($dataSend['phone']) && isset($dataSend['address']) && isset($dataSend['password']) && isset($dataSend['passwordAgain'])){
        $save= array();

        $save['User']['fullname']= $dataSend['fullname'];
        $save['User']['user']= $dataSend['username'];
        $save['User']['phone']= $dataSend['phone'];
        $save['User']['email']= $dataSend['email'];
        $save['User']['address']= $dataSend['address'];
        $save['User']['birthday']= (isset($dataSend['birthday']))?$dataSend['birthday']:'';
        if($dataSend['password']==$dataSend['passwordAgain'] && $dataSend['password']!='')
        {
            $save['User']['password']= md5($dataSend['password']);

            if($save['User']['fullname']!='' && $save['User']['user']!='' && $save['User']['email']!='' && $save['User']['phone']!='' && $save['User']['address']!='')
            {
                $checkUserName= $modelUser->getUserCode($save['User']['user']);
                if(!$checkUserName)
                {
                    $modelUser->save($save);

                    $username= $dataSend['username'];
                    $password= md5($dataSend['password']);

                    $user= $modelUser->checkLogin($username,$password);
                    if($user){
                        $_SESSION['infoUser']= $user;
                        $modelUser->redirect($urlHomes);
                    }

                    $modelUser->redirect($urlHomes.'register?status=1');
                }
                else $modelUser->redirect($urlHomes.'register?status=-2');
            }
            else $modelUser->redirect($urlHomes.'register?status=-1');
        }
        else $modelUser->redirect($urlHomes.'register?status=-3');
    }else{
        $modelUser->redirect($urlHomes);
    }
}

function checkLogin($input){
    global $urlHomes;
    $input['request']->data= arrayMap($input['request']->data);
    $modelUser= new User();

    if(isset($input['request']->data['username']) && isset($input['request']->data['password'])){
        $username= $input['request']->data['username'];
        $password= md5($input['request']->data['password']);

        $user= $modelUser->checkLogin($username,$password);
        if($user){
            $_SESSION['infoUser']= $user;
            $modelUser->redirect($urlHomes);
        }else{
            $modelUser->redirect($urlHomes.'login?status=-1');
        }
    }else{
        $modelUser->redirect($urlHomes);
    }
}
function logout($input){
    global $urlHomes;
    global $modelOption;
    session_destroy();
    $modelOption->redirect($urlHomes);
}

function saveComment($input){
    global $urlHomes;
    global $modelOption;
    $id= $input['request']->data['userID'];
    if(!empty($id)){
        $modelComment= new Comment();
        global $urlNow;
        $dataSend= $input['request']->data;
        $today= getdate();
        $comment['Comment']['content']= $dataSend['content'];
        $comment['Comment']['lock']= 1;
        $comment['Comment']['time']= $today[0];
        $comment['Comment']['userID']=  $dataSend['userID'];
        $comment['Comment']['username']=  $dataSend['username'];
        $comment['Comment']['topicID']=  $dataSend['topicID'];
        $comment['Comment']['topicSlug']=  $dataSend['topicSlug'];
        $comment['Comment']['parentID']=  $dataSend['parentID'];

        $data = $modelComment->saveComment($comment);
        $modelComment->redirect($urlHomes.'topic/'.$dataSend['topicSlug'].'?status=1');
    }else{
        $dataSend= $input['request']->data;
        $modelOption->redirect($urlHomes.'topic/'.$dataSend['topicSlug'].'?status=-1');
    }
}
function updateComment($input){
//debug($input);die;
    global $modelOption;
    global $modelComment;
    global $urlHomes;
    global $urlPlugins;
    if(checkAdminLogin()){
            $modelComment= new Comment();
            global $urlNow;
            $id= $input['request']->params['pass'][1];

            $data = $modelComment->updateComment($id);
//            debug($data);die;
            $modelComment->redirect($urlPlugins.'admin/topic-admin-listComments.php?status=1');
    }else{
        $modelComment->redirect($urlHomes);
    }

}
function addCat($cats,$parent,$save,$number=0){

    $parent= (int) $parent;

    if($parent==0)
    {
        $check= true;
        foreach($cats as $key=>$cat)
        {
            if(  $cat['id']==$save['id'] )
            {
                $cats[ $key ]= $save;
                $check= false;
                break;
            }
        }
        if($check)
        {
            $cats[$save['id']]= $save;
        }
    }
    else
    {
        $dem= -1;
        foreach($cats as $key=>$cat)
        {
            $dem++;
            if(isset($cat['id']) && $cat['id']==$parent)
            {
                $check= true;
                $demSub= -1;
                foreach($cat['sub'] as $keySub=>$sub)
                {
                    $demSub++;
                    if($sub['id']==$save['id'])
                    {
                        $cats[ $key ]['sub'][ $keySub ]= $save;
                        $check= false;
                        break;
                    }
                }
                if($check)
                {
                    $cats[ $key ]['sub'][ $save['id'] ]= $save;
                    break;
                }
            }
            else
            {
                $cats[ $key ]['sub']= $this->addCat($cat['sub'],$parent,$save,$number+1);
            }
        }
    }
    return $cats;
}
function listComment($input){

    global $modelOption;
    global $urlNow;
    $modelComment = new Comment();

    if(isset($_GET['page'])){
        $page= (int) $_GET['page'];
    } else {
        $page=1;
    }
    $limit= 16;
    $data = $modelOption->getOption('topicCategory');
    $topicCate = $modelOption->getOption('topicCategory');
    $conditions= null;
    $category= null;
    $listComment = $modelComment->getCommentTopic('58d428d8a7f8211958a2f30c');
//    debug($listComment);die;
    if(!empty($input['request']->params['pass'][1])){
        $slug = str_replace('.html', '', $input['request']->params['pass'][1]);
        $category= $modelComment->getcat($data['Option']['value']['allData'],$slug,'slug');
        $conditions= array('category'=> (string)$category['id']);
        $listNotices= $modelComment->getPage($page,$limit,$conditions);
    }else{
        $listNotices= $modelComment->getPage($page,$limit,$conditions);
    }

    // $listNotices = showListDocument($limit, $conditions);
    $totalData= $modelComment->find('count',array('conditions' => $conditions));

    $balance= $totalData%$limit;
    $totalPage= ($totalData-$balance)/$limit;
    if($balance>0)$totalPage+=1;

    $back=$page-1;$next=$page+1;
    if($back<=0) $back=1;
    if($next>=$totalPage) $next=$totalPage;

    if(isset($_GET['page'])){
        $urlPage= str_replace('&page='.$_GET['page'], '', $urlNow);
        $urlPage= str_replace('page='.$_GET['page'], '', $urlPage);
    }else{
        $urlPage= $urlNow;
    }

    if(strpos($urlPage,'?')!== false){
        if(count($_GET)>=1){
            $urlPage= $urlPage.'&page=';
        }else{
            $urlPage= $urlPage.'page=';
        }
    }else{
        $urlPage= $urlPage.'?page=';
    }
    setVariable('listComment',$listComment);
    setVariable('listNotices',$listNotices);
    setVariable('category', $category);
    setVariable('topicCate', $topicCate);
    setVariable('page',$page);
    setVariable('totalPage',$totalPage);
    setVariable('back',$back);
    setVariable('next',$next);
    setVariable('urlPage',$urlPage);
}
function listComments(){
    global $modelOption;
    global $urlHomes;

    if(checkAdminLogin()){
        $modelComment = new Comment();
       $listComment = $modelComment->getListComment();
//debug($listComment);die;
        setVariable('listComment',$listComment);
    }

    else {
        $modelOption->redirect($urlHomes);
    }

}
?>