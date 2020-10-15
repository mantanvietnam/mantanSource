<link href="<?php echo $urlHomes.'app/Plugin/topic/style.css';?>" rel="stylesheet">
<?php
global $urlPlugins;
global $urlHomes;
//debug($tmpVariable);
$breadcrumb = array('name' => 'Quản lý chuyên đề',
    'url' => $urlPlugins . 'admin/topic-admin-listComments.php',
    'sub' => array('name' => 'Quản lý bình luận')
);
addBreadcrumbAdmin($breadcrumb);
?>

<div class="clear"></div>


<br/>
<?php
if(isset($_GET['status'])){

    switch($_GET['status'])
    {
        case 1: echo '<script type="text/javascript">
                        alert("Bình luận đã được hiển thị")
                    </script>';break;
        case -1:echo '<script type="text/javascript">
                        alert("Bình luận vẫn chưa đưuọc hiển thị")
                    </script>';break;

    }
}
?>

<div id="content" class="clear">
    <form action="" method="post" name="duan" class="taovienLimit">
        <table id="listTin" cellspacing="0" class="tableList">
            <tr>
                <th align="center" width="50">STT</th>
                <th align="center" width="150">Người hỏi</th>
                <th align="center" >Nội dung bình luận</th>
                <th align="center" >Thời gian</th>
                <th align="center" width="100">Trạng thái</th>
                <th align="center" width="200">Lựa chọn</th>
            </tr>
            <?php $i=1; if(!empty($tmpVariable['listComment'])){
                foreach ($tmpVariable['listComment'] as $key => $comment){
                ?>
                <tr>
                    <td align="center"><?php echo $i++;?></td>
                    <td align="center"><?php echo $comment['Comment']['username']?></td>
                    <td align="center"><?php echo $comment['Comment']['content']?></td>
                    <td align="center"><?php echo date('d-m-y',$comment['Comment']['time']);?></td>
                    <td align="center"><?php echo ($lock = $comment['Comment']['lock']==0 )?'Hiện':'Ẩn';?></td>
                    <td align="center">
                        <a style="padding: 4px 8px;" href="<?php echo $urlPlugins.'admin/topic-admin-updateComment.php/'.$comment['Comment']['id']?>" class="input" >Phê duyệt</a>
                        <a style="padding: 4px 8px;" href="<?php echo $urlPlugins.'admin/topic-admin-deleteComment.php/'.$comment['Comment']['id'] ?>"  class="input" >Xóa</a>
                    </td>
                </tr>

                <?php }
            }?>
        </table>
        <p>
<!--            --><?php
//            if ($page > 5) {
//                $startPage = $page - 5;
//            } else {
//                $startPage = 1;
//            }
//
//            if ($totalPage > $page + 5) {
//                $endPage = $page + 5;
//            } else {
//                $endPage = $totalPage;
//            }
//
//            echo '<a href="' . $urlNow . '?page=' . $back . '">Trang trước</a> ';
//            for ($i = $startPage; $i <= $endPage; $i++) {
//                echo ' <a href="' . $urlNow . '?page=' . $i . '">' . $i . '</a> ';
//            }
//            echo ' <a href="' . $urlNow . '?page=' . $next . '">Trang sau</a> ';
//
//            echo 'Tổng số trang: ' . $totalPage;
//            ?>
        </p>
    </form>
</div>
<?php //echo $urlPlugins.'admin/topic-admin-deleteComment.php';?>
<script type="text/javascript">
    var urlWeb ="<?php echo $urlPlugins.'admin/topic-admin-saveComment.php';?>";
    var urlNow = "<?php echo $urlNow;?>";
    function adjust(id) {
       $.ajax({
           type:"POST",
           url: urlWeb,
           data:{id:id}
       })
           .done(function (smg) {
               window.location=urlNow;
           })
           .fail(function (smg) {
             window.location=urlNow;
           })

    }
</script>