<br>   
<br>   
<div class="thanhcongcu">
    <div class="congcu">
        <a href="<?php echo $urlPlugins . 'admin/testSystem-admin-addQuestion.php?idTest=' . $_GET['idTest'] ?>" class="btn btn-success">Thêm Câu hỏi</a>
    </div>

</div>
<div class="clear"></div>
<br />

<div class="taovien">
    <div class="col-sm-12">
             <?php
        if (isset($_GET['status'])) {
            switch ($_GET['status']) {
                case 1: echo '<p style="color:red;">Thao tác thành công!</p>';
                    break;
               
            }
        }
        ?>
        <table style="width:100%" border="1">
            <tr>
                <td align="center" width="50">#</td>
                 <td align="center">Câu hỏi</td>
                <td align="center" width="160">Đáp án đúng</td>
                <td align="center">Lựa chọn</td>
            </tr>
            <?php
            $dem =0 ;
            if (!empty($listQuestions)) {
                foreach ($listQuestions as $value) {
                    $dem++;
                    ?>
            <tr>
                 <tr>
                     <td align="center" ><?php echo $dem;?></td>
                        <td align="center" ><?php if (!empty($value['Questions']['title'])) echo $value['Questions']['title']; ?></td>
                        <td  align="center"><?php if (!empty($value['Questions']['result'])) echo $value['Questions']['result']; ?></td>
                        <td align="center" width="160">
                            <a  href="<?php echo $urlPlugins . 'admin/testSystem-admin-addQuestion.php?idEdit=' . $value['Questions']['id'].'&idTest='.$_GET['idTest']; ?>" class="btn btn-danger"><i class="fa fa-pencil"></i></a>
                            <a  href="<?php echo $urlPlugins . 'admin/testSystem-admin-deleteQuestion.php?idDelete=' . $value['Questions']['id']; ?>" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
            </tr>
            <?php
                }
            }
            ?>
            
        </table>
    </div>
</div>

