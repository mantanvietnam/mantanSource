<?php
$menus= array();
$menus[0]['title']= 'Quản lý chuyên đề';
$menus[0]['sub'][0]= array('name'=>'Bài viết chuyên đề','classIcon'=>'fa-list-alt','url'=> $urlPlugins.'admin/topic-admin-listTopics.php');
$menus[0]['sub'][1]= array('name'=>'Danh mục chuyên đề','classIcon'=>'fa-list-alt','url'=> $urlPlugins.'admin/topic-admin-listCategoryTopics.php');
$menus[0]['sub'][2]= array('name'=>'Quản lý bình luận','classIcon'=>'fa-users','url'=> $urlPlugins.'admin/topic-admin-listComments.php');

addMenuAdminMantan($menus);
global $modelOption;
$topicCategory= $modelOption->getOption('topicCategory');

$category= array();
if(!empty($topicCategory['Option']['value']['allData'])) {
    $category= array(array( 'title'=>'Topic',
        'sub'=>changeTypeCategoryDoc($topicCategory['Option']['value']['allData'],'/listCategoryTopics/')
    )
    );
}
addMenusAppearance($category);


function changeTypeCategory($category,$link)
{
    foreach($category as $key=>$cat)
    {
        $category[$key]= array  ( 'url' => $link.$cat['slug'].'.html',
            'name' => $cat['name']
        );
        if(isset($cat['sub']) && count($cat['sub'])>0)
        {
            $category[$key]['sub']= $this->changeTypeCategory($cat['sub'],$link);
        }
    }
    return $category;
}

function showListTopic($limit,$conditions){
    global $urlHomes;
    global $infoSite;
    global $modelOption;

    $modelTopic= new Topic();

    $conditions['lock']= 0;
    $listNotices= $modelTopic->getPage(1,$limit,$conditions);

    return $listNotices;
}
function getATopic($idTopic){
    global $urlHomes;
    global $inforSite;
    global $modelOption;
    $modelTopic= new Topic();
    $topic = $modelTopic ->getTopic($idTopic);
    return $topic;
    
}

?>