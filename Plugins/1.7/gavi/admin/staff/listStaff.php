<link href="<?php echo $urlHomes . 'app/Plugin/gavi/admin/style.css'; ?>" rel="stylesheet">
<?php
$breadcrumb = array('name' => 'Quản lý tài khoản nhân viên',
    'url' => $urlPlugins . 'admin/gavi-admin-staff-listStaff.php',
    'sub' => array('name' => 'Tất cả tài khoản')
);
addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>

<div id="content">
    <?php
    if (isset($_GET['stt'])) {
        switch ($_GET['stt']) {
            case 1: echo '<p style="color:red;">Lưu tài khoản thành công!</p>';
            break;
            case -1: echo '<p style="color:red;">Lưu tài khoản không thành công!</p>';
            break;
            case 3: echo '<p style="color:red;">Sửa tài khoản thành công!</p>';
            break;
            case -3: echo '<p style="color:red;">Sửa tài khoản không thành công!</p>';
            break;
            case 4: echo '<p style="color:red;">Cập nhập trạng thái tài khoản thành công!</p>';
            break;
        }
    }
    ?>
    <form action="" method="GET" name="duan" class="taovienLimit">
        <div class="table-responsive table1">

            <table class="table table-bordered">
                <tr>
                    <td>
                        <div class="add_p">
                            <a href="<?php echo $urlPlugins . 'admin/gavi-admin-staff-addStaff.php'; ?>">Thêm</a>
                        </div>
                    </td>
                    <td>
                        <table class="table table-bordered">
                            <tr>
                                <td>
                                    <input type="text" class="form-control" placeholder="Họ tên" name="name" value="<?php echo @arrayMap($_GET['name']);?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Mã nhân viên" name="code" value="<?php echo @arrayMap($_GET['code']);?>">
                                </td>
                                <td>
                                    <input type="text" value="<?php echo @$_GET['birthday'];?>" name="birthday" id="" placeholder="Ngày sinh" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989"  class="input_date form-control" >
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Email" name="email" value="<?php echo @arrayMap($_GET['email']);?>" maxlength="50">
                                </td>
                                
                                <td rowspan="4">
                                    <button class="add_p1">Tìm kiếm</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="phone" maxlength="50" placeholder="Số điện thoại" class="form-control" value="<?php echo @arrayMap($_GET['phone']);?>">
                                </td>
                                <td>
                                    <select name="area" placeholder="Vùng" class="form-control">
                                        <option value="">Chọn Vùng</option>
                                        <?php 
                                        global $listArea;
                                        foreach($listArea as $area){
                                            if(empty($_GET['area']) || $_GET['area']!=$area['id']){
                                                echo '<option value="'.$area['id'].'">'.$area['name'].'</option>';
                                            }else{
                                                echo '<option selected value="'.$area['id'].'">'.$area['name'].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="idCity" class="form-control" placeholder="Tỉnh/Thành phố" >
                                        <option value="">Chọn Tỉnh/Thành phố</option>
                                        <?php
                                        global $modelOption;
                                        $listCityKiosk= $modelOption->getOption('cityKiosk');
                                        if (!empty($listCityKiosk['Option']['value']['allData'])) {
                                            foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
                                                if (!isset($_GET['idCity']) || $_GET['idCity'] != $city['id']) {
                                                    echo '<option value="' . $city['id'] . '">' . $city['name'] . '</option>';
                                                } else {
                                                    echo '<option value="' . $city['id'] . '" selected>' . $city['name'] . '</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" value="<?php echo @arrayMap($_GET['indirectManager']);?>" class="form-control" placeholder="Quản lý gián tiếp" maxlength="100" name="indirectManager">
                                </td>
                                
                            </tr>
                            <tr>
                                
                                <td>
                                    <input type="text" value="<?php echo @arrayMap($_GET['directManager']);?>" class="form-control" placeholder="Quản lý trực tiếp" maxlength="100" name="directManager">
                                </td>
                                <td>
                                    <input type="text" value="<?php echo @arrayMap($_GET['dateTrial']);?>" name="dateTrial" id="" placeholder="Ngày vào thử việc" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" >
                                </td>
                                <td>
                                    <input type="text" value="<?php echo @arrayMap($_GET['dateStart']);?>" name="dateStart" id="" placeholder="Ngày làm chính thức" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" >
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="<?php echo @arrayMap($_GET['position']);?>" placeholder="Vị trí chức danh công việc" maxlength="100" name="position">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>

    </div>
    <div class="clear"></div>
    <br/>
    <table id=""  class="table_hy table-bordered">
        <thead> 
            <tr class=""> 
                <th class="text_table" style="width: 40px">STT</th>
                <th  class="text_table">Mã nhân viên</th> 
                <th  class="text_table">Họ và tên</th> 
                <th  class="text_table">Email</th> 
                <th  class="text_table">SĐT</th> 
                <th style="text-align: center;">Hành động</th>  
            </tr> 
        </thead>
        <tbody> 
            <?php
            if (!empty($listData)) {
                $i=$limit*($page-1);
                foreach ($listData as $tin) {
                    $i++;
                    if($tin['Staff']['status']=='active'){
                        $action= '<button type=""><a style="padding: 4px 8px;color: black" href="'. $urlPlugins . 'admin/gavi-admin-staff-updateStatusStaff.php?status=lock&id=' . $tin['Staff']['id'] .'" class="input" onclick="return confirm(\'Bạn có chắc chắn muốn khóa không ?\');"  >Khóa</a></button>';
                    }else{
                        $action= '<button type=""><a style="padding: 4px 8px;color: black" href="'. $urlPlugins . 'admin/gavi-admin-staff-updateStatusStaff.php?status=active&id=' . $tin['Staff']['id'] .'" class="input" onclick="return confirm(\'Bạn có chắc chắn muốn kích hoạt không ?\');"  >Kích hoạt</a></button>';
                    }

                    ?>

                    <tr class="table_hy"> 
                        <td  class="text_table"><?php echo $i;?></td>
                        <td class="break_word"><?php echo $tin['Staff']['code']; ?></td> 
                        <td class="break_word"><?php echo $tin['Staff']['fullName']; ?></td> 
                        <td class="break_word"><?php echo $tin['Staff']['email']; ?></td> 
                        <td class="break_word"><?php echo $tin['Staff']['phone']; ?></td> 
                        <td class="break_word" align="center">
                            <button type="" onclick="location.href='<?php echo $urlPlugins . 'admin/gavi-admin-staff-addStaff.php?id=' . $tin['Staff']['id']; ?>';">Sửa</button>  
                            <?php echo $action;?>
                        </td> 

                    </tr> 


                    <?php
                }
            } else {
                ?>
                <tr>
                    <td align="center" colspan="8">Chưa có tài khoản nào.</td>
                </tr>
                <?php }
                ?>
            </tbody> 
        </table>
        <p>
            <?php

            if ($page > 5) {
                $startPage = $page - 5;
            } else {
                $startPage = 1;
            }

            if ($totalPage > $page + 5) {
                $endPage = $page + 5;
            } else {
                $endPage = $totalPage;
            }

            echo '<a href="' . $urlPage . $back . '">Trang trước</a> ';
            for ($i = $startPage; $i <= $endPage; $i++) {
                echo ' <a href="' . $urlPage . $i . '" ';
                if (!empty($_GET['page'])&&$_GET['page']==$i) {
                    echo 'class="page"';
                }
                echo '>' . $i . '</a> ';
            }
            echo ' <a href="' . $urlPage . $next . '">Trang sau</a> ';

            echo 'Tổng số trang: ' . $totalPage;
            ?>
        </p>
    </form>
</div>
<style type="text/css">
.page
{
    text-decoration: underline;
}
</style>
<style type="text/css">
.text_table{
    text-align: center;
}

.table_hy{
    width: 100%;
}
.table_hy th {
    padding: 10px;
}
.table_hy td {
    padding: 10px;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
 border: 1px solid #ddd  !important; 
}
</style>

<script src="https://www.jqueryscript.net/demo/Easy-jQuery-Input-Mask-Plugin-inputmask/dist/jquery.inputmask.bundle.min.js"></script>

<script>
    $(document).ready(function(){
        $("input.input_date").inputmask();
        $("input.input-mask-date").inputmask();
    });
</script>
