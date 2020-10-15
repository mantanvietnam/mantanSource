
<div id="content" style="margin-top:30px">
    <h4 ><b> Điểm thi của học sinh theo đề thi</b></h4>

    <form action="" method="get" class="taovienLimit">
        Danh sách đề thi  
        <select name="idTest" class="form-control" style="width: auto;display: inline;margin-bottom: 15px;">
            <option value="">Lựa chọn</option>
            <?php
            if (!empty($listTest)) {
                foreach ($listTest as $value) {
                    ?>
                    <option <?php if(isset($_GET['idTest']) && $value['Tests']['id'] == $_GET['idTest']) echo 'selected="selected"';?> value="<?php echo $value['Tests']['id'] ?>"><?php echo $value['Tests']['name'] ?></option>
                <?php
                }
            }
            ?>
        </select>
        <input class="btn btn-default" type="submit" value="Hiển thị">
    </form>
    
    <table id="listTin" cellspacing="0" class="table table-striped">

        <tr>

            <td align="center">STT</td>
            <td align="center">Tên học sinh</td>
            <td align="center">Giới tinh</td>
            <td align="center">Điện thoại</td>
            <td align="center">Kết quả</td>
            <td align="center">Điểm</td>
        </tr>
        <?php
        if (!empty($dataStudent)) {
            $stt = 0;   
            foreach ($dataStudent as $value) {
                $stt++;
                ?>
                <tr>
                    <td align="center"><?php echo $stt;?></td>
                    <td align="center"><?php if(!empty($value['Student']['fullname']))echo $value['Student']['fullname'];?></td>
                    <td align="center"><?php if(!empty($value['Student']['sex']) && $value['Student']['sex'] == 1){echo 'Nam';}else {echo "Nữ";}?></td>
                    <td align="center"><?php if(!empty($value['Student']['phone']))echo $value['Student']['phone'];?></td>
                    <td align="center"><?php  echo $value['Student']['ketqua'][$_GET['idTest']]['socaudung'].'/'.$value['Student']['ketqua'][$_GET['idTest']]['socauhoi'];?></td>
                    <td align="center"><?php  echo  round($value['Student']['ketqua'][$_GET['idTest']]['point'], 2);?></td>
                </tr>
            <?php
            }
        }
        ?>
    </table>



</div>

