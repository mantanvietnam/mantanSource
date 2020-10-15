<link href="<?php echo $urlHomes.'app/Plugin/topic/style.css';?>" rel="stylesheet">
<?php
$breadcrumb= array( 'name'=>'Quản lý Chuyên đề',
    'url'=>$urlPlugins.'admin/topic-admin-listCategoryTopics.php',
    'sub'=>array('name'=>'Danh mục chuyên đề')
);
addBreadcrumbAdmin($breadcrumb);
?>

<form name="dangtin" method="post" action="<?php echo $urlPlugins.'admin/topic-admin-addCategory.php';?>" role="form">
    <div class="form-group">
        <input type="hidden" value="" name="id" id="idData" />
        <input type="hidden" value="save" name="type" />
        <input type="hidden" value="1" name="redirect" />
        <table cellspacing="0" class="table" style="width: 100%;" >
            <tr>
                <td width="150"><?php echo 'Tên chuyên đề'?></td>
                <td><input class="form-control" type="text" name="name" id="name" value="" /></td>
                <td width="150" align="right"><?php echo 'Mô tả';?></td>
                <td><textarea class="form-control"  name="author" id="key" rows="5" value=""></textarea></td>
            </tr>
            <tr>
                <td rowspan="2" ><?php echo 'Trạng thái';?></td>
                <td>
                        <input type="radio" name="lock" value="0" style="margin: 10px;" checked="checked" >Mở</input>
                        <input type="radio" name="lock" value="1" style="margin: 10px" >Khóa</input>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <input type="submit" value="Lưu chuyên đề" class="btn btn-default"  />
                </td>
            </tr>
        </table>
    </div>
</form>
<div id="content">
    <form action="" method="post" name="listForm">
        <table id="listTopics" class="tableList">
            <tr>
                <td align="center">STT</td>
                <td align="center" >Chuyên đề</td>
                <td align="center" >Trạng thái</td>
                <td align="center" >Lựa chọn</td>
            </tr>
            <?php
            if(!empty($listData['Option']['value']['allData'])){
                $count =1;
                foreach ($listData['Option']['value']['allData'] as $key => $topic){

                    ?>
                    <tr id="trList<?php echo $topic['id']?>">
                        <td align="center"><?php echo $count++;?></td>
                        <td align="center"><a href="<?php echo $urlHomes.'listCategoryTopics/'. $topic['slug'].'.html'?>"><?php echo $topic['name']?></a></td>
                        <td align="center" ><?php echo ($topic['lock'] ==1 )? 'Khóa': 'Mở';?></td>
                        <td align="center" width="165" >
                            <input class="input" type="button" value="Sửa" onclick="adjust(<?php echo $topic['id'];?>,'<?php echo $topic['name'];?>');">
                            <input class="input" type="button" value="Xóa" onclick="deleteData('<?php echo $topic['id'];?>');">
                        </td>
                    </tr>

                    <?php
                }

            }
            ?>

        </table>
    </form>
</div>
<script type="text/javascript">
    var urlWeb="<?php echo $urlPlugins.'admin/topic-admin-addCategory.php';?>";
    var urlNow = "<?php echo $urlNow;?>";
    function adjust(id,name,author,lock) {
        document.getElementById('idData').value=id;
        document.getElementById('name').value=name;
        document.getElementById('author').value=author;
        document.getElementById('lock').value=lock;

    }
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
