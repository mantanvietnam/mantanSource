<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/script.js'; ?>"></script>
<?php
$breadcrumb = array('name' => 'Quản lý Khách hàng',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-custom-listCustomAdmin.php',
    'sub' => array('name' => 'Danh sách Khách hàng đặt phòng')
);
addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>

<div id="content">
    <?php
    if (isset($_GET['status'])) {
        switch ($_GET['status']) {
            case 1: echo '<p class="success_mess"><span class="glyphicon glyphicon-ok"> Thêm Khách hàng thành công!</p>';
                break;
            case -1: echo '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Thêm Khách hàng không thành công!</p>';
                break;
            case 3: echo '<p class="success_mess"><span class="glyphicon glyphicon-ok"> Sửa Khách hàng thành công!</p>';
                break;
            case -3: echo '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Sửa Khách hàng không thành công!</p>';
                break;
            case 4: echo '<p class="success_mess"><span class="glyphicon glyphicon-ok"> Xóa Khách hàng thành công!</p>';
                break;
        }
    }
    ?>
    <form action="" method="post" name="duan" class="taovienLimit">
        <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/mantanHotel-admin-custom-addCustomAdmin.php'; ?>" class="input">
            <img src="<?php echo $webRoot; ?>images/add.png"> Thêm
        </a>  
        <table class="table table-bordered" style="border: 1px solid #ddd!important; margin-top: 10px;">  
            <thead> 
                <tr> 
                    
                    <th>STT</th> 
                    <th>Tên khách hàng</th> 
                    <th>CMND/Passport</th> 
                    <th>Địa chỉ</th> 
                    <th>Thông tin giao dịch</th> 
                    <th>Điện thoại</th> 
                    <th>Quốc tịch</th> 
                    <th>Ngày sinh</th> 
                    <th>Ghi chú</th> 
                    <th style="text-align: center;">Chọn</th>  
                </tr> 
            </thead>
            <tbody> 
                <?php
                if (!empty($listData)) {
                    foreach ($listData as $key => $tin) {
                        ?>
                        <tr> 
                            <td class=""><?php echo $key + 1; ?></td> 
                            <td class="break_word"><?php echo $tin['Custom']['cus_name']; ?></td> 
                            <td class="break_word"><?php echo $tin['Custom']['cmnd']; ?></td> 
                            <td class="break_word"><?php echo $tin['Custom']['address']; ?></td> 
                            <td class="break_word"><?php echo @$tin['Custom']['info_deal']; ?></td> 
                            <td class="break_word"><?php echo $tin['Custom']['phone']; ?></td> 
                            <td class="break_word"><?php echo $tin['Custom']['nationality']; ?></td> 
                            <td class="break_word"><?php echo @$tin['Custom']['birthday']; ?></td> 
                            <td class="break_word"><?php echo isset($tin['Custom']['note'])?$tin['Custom']['note']:''; ?></td>
                            <td class="break_word" align="center">
                                <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/mantanHotel-admin-custom-editCustomAdmin.php?id=' . $tin['Custom']['id']; ?>" class="input"  >Sửa</a>  
                                <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/mantanHotel-admin-custom-deleteCustomAdmin.php?id=' . $tin['Custom']['id'] ?>" class="input" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"  >Xóa</a>
                            </td> 

                        </tr> 


                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td align="center" colspan="13">Chưa có khách hàng nào.</td>
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

            echo '<a href="' . $urlNow .'?page='. $back . '">Trang trước</a> ';
            for ($i = $startPage; $i <= $endPage; $i++) {
                echo ' <a href="' . $urlNow .'?page='. $i . '">' . $i . '</a> ';
            }
            echo ' <a href="' . $urlNow .'?page='. $next . '">Trang sau</a> ';

            echo 'Tổng số trang: ' . $totalPage;
            ?>
        </p>
    </form>
</div>