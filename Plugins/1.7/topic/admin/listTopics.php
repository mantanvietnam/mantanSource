<link href="<?php echo $urlHomes.'app/Plugin/topic/style.css';?>" rel="stylesheet">
<?php
$breadscrumb=array('name'=>'Quản lý chuyên đề',
                    'url'=>  $urlPlugins.'admin/topic-admin-listTopics.php' ,
                    'sub'=>array('name'=>'Bài viết chuyên đề'));
addBreadcrumbAdmin($breadscrumb);
?>
<div class="clear"></div>


<div class="clear"></div>
<div class="thanhcongcu">
    <div class="congcu">
        <a href="<?php echo $urlPlugins; ?>admin/topic-admin-addTopics.php">
            <span>
                <img src="<?php echo $webRoot; ?>images/add.png">
            </span>
            <br>
        </a>

    </div>

</div>

<br/>

<div id="content">
    <form action="" method="post" name="listForm">
        <table id="listTopics" class="tableList">
            <tr>
                <td align="center" width="150">Tên bài viết</td>
                <td align="center" width="90">Chuyên đề</td>
                <td align="center" width="130">Lựa chọn</td>
            </tr>
            <?php

                foreach($listTopic as $key => $topic)
            {
                if($topic['Topic']['user']==$userAdmins['Admin']['user']||$userAdmins['Admin']['user']=="admin"){
                ?>
                <tr>
                    <td height="40" id="name<?php echo $topic['Topic']['id'];?>">
                        <a href="<?php echo $topic['Topic']['file'];?>">
                            <?php echo $topic['Topic']['name'];?>
                        </a>
                    </td>
                    <td><?php echo @$listData['Option']['value']['allData'][ $topic['Topic']['category'] ]['name'];?></td>

                    <td align="center" >
                        <a style="padding: 4px 8px;" href="<?php echo $urlPlugins.'admin/topic-admin-addTopics.php/'.$topic['Topic']['id'] ?>" class="input" >Sửa</a>
                        &nbsp;&nbsp;
                        <a style="padding: 4px 8px;" href="<?php echo $urlPlugins.'admin/topic-deleteTopic.php/'.$topic['Topic']['id'] ?>" class="input" onclick="return confirm('Bạn có chắc muốn xóa dữ liệu vừa chọn ?');"  >Xóa</a>
                    </td>
                </tr>
                <?php
            }}
            ?>
        </table>
    </form>
</div>

<script type="text/javascript">
    var urlWeb="<?php echo $urlPlugins.'admin/topic-admin-addTopic.php';?>";
    var urlNow = "<?php echo $urlNow;?>";

    function deleteData(id)
    {
        var r=confirm("Bạn có muốn chắc chắn muốn xóa không?") ;
        if(r==true){
            $.ajax({
                type:"POST",
                url: urlWeb,
                data:{id:id,type:'delete',redirect:0}

            })
                .done(function (smg){
                    window.location=urlNow;
                })
                .fail(function (smg) {
                    window.location=urlNow;
                });
        }
    }
</script>