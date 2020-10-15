<link href="<?php echo $urlHomes.'app/Plugin/topic/style.css';?>" rel="stylesheet">

<?php
//debug($data);
$breadscrumb=array('name'=>'Quản lý chuyên đề',
    'url'=>  $urlPlugins.'admin/topic-admin-addTopics.php' ,
    'sub'=>array('name'=>'Bài viết chuyên đề'));
addBreadcrumbAdmin($breadscrumb);
?>
<script type="text/javascript">

    function save()
    {
        document.listForm.submit();
    }
</script>
<div class="thanhcongcu">
    <div class="congcu" onclick="save();">
        <input type="hidden" id="idChange" value=""/>
        <span id="save">
	          <input type="image" src="<?php echo $webRoot;?>images/save.png" />
	        </span>
        <br/>
        Save
    </div>
</div>

<div class="clear"></div>
<form method="post" action="<?php echo $urlPlugins.'admin/topic-admin-addTopic.php';?>" name="listForm">
    <input type="hidden" value="<?php if(!empty($data[0]['Topic']['id']))  echo $data[0]['Topic']['id'];?>" name="id" id="id"/>
    <input type="hidden" value="<?php if(!empty($userAdmins['Admin']['user']))  echo $userAdmins['Admin']['user'];?>" name="user"/>
    <div class="form-group">
        <table cellspacing="0" class="table" style="width: 100%;" >
            <tr>
                <td>
                    <p>Tên chuyên đề</p>
                    <input type="text" name="name" id="name" value="<?php if(!empty($data[0]['Topic']['name'])){ echo $data[0]['Topic']['name'];}?>">
                </td>

                <td>
                    <p>File</p>
                    <?php
                    if(empty($data[0]['Topic']['file'])){
                        $data[0]['Topic']['file']= null;
                    }
                    showUploadFile('file','file',$data[0]['Topic']['file'],0);
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Chuyên đề</p>
                    <select name="category" id='category'>
                        <?php
                        if(!empty($listData['Option']['value']['allData'])){
                            foreach($listData['Option']['value']['allData'] as $topic)
                            {
                                if($topic['lock']!=1){
                                    if($topic['id']!=$data['Topic']['category'] ){
                                        echo '<option value="'.$topic['id'].'">'.$topic['name'].'</option>';
                                    }else{
                                        echo '<option selected value="'.$topic['id'].'">'.$topic['name'].'</option>';
                                    }
                                }
                            }
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <p>Ảnh minh họa</p>
                    <?php
                    if(empty($data[0]['Topic']['image'])){
                        $data[0]['Topic']['image']=null;
                    }
                    showUploadFile('image','image',$data[0]['Topic']['image'],1);
                    ?>
                </td>

            </tr>
            <tr>
                <td>
                    <p>Mô tả</p>
                    <textarea maxlength="150" rows="6" cols="35" name="description"><?php if(!empty($data[0]['Topic']['description'])){ echo $data[0]['Topic']['description'];}?></textarea>
                </td>
                <td>
                    <p>Tác giả</p>
                    <input name="author" value=" <?php if(!empty($data[0]['Topic']['author'])){ echo $data[0]['Topic']['author'];}?>">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>Nội dung</p>
                    <?php
                    if(empty($data[0]['Topic']['content'])){
                        $data[0]['Topic']['content']='';
                    }
                    showEditorInput('content','content',$data[0]['Topic']['content']);
                    ?>
                </td>
            </tr>
        </table>
    </div>
</form>