<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/script.js'; ?>"></script>
<?php
$breadcrumb = array('name' => 'Quản lý tài khoản người dùng',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-user-listUserAdmin.php',
    'sub' => array('name' => 'Tất cả người dùng')
);
addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>

<div id="content">
    <?php
    if (isset($_GET['status'])) {
        switch ($_GET['status']) {
            case 1: echo '<p style="color:red;">Thêm tài khoản người dùng thành công!</p>';
                break;
            case -1: echo '<p style="color:red;">Thêm tài khoản người dùng không thành công!</p>';
                break;
            case 3: echo '<p style="color:red;">Sửa tài khoản người dùng thành công!</p>';
                break;
            case -3: echo '<p style="color:red;">Sửa tài khoản người dùng không thành công!</p>';
                break;
            case 4: echo '<p style="color:red;">Xóa tài khoản người dùng thành công!</p>';
                break;
        }
    }
    ?>
    <form action="" method="post" name="duan" class="taovienLimit">
        <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/mantanHotel-admin-user-addUserAdmin.php'; ?>" class="input">
            <img src="<?php echo $webRoot; ?>images/add.png"> Thêm
        </a>  
        <table class="table table-bordered" style="border: 1px solid #ddd!important; margin-top: 10px;">  
            <thead> 
                <tr> 
                    
                    <th>STT</th> 
                    <th>Tài khoản</th> 
                    <th>Họ và tên</th> 
                    <th>CMND</th> 
                    <th>Email</th> 
                    <th>SĐT</th> 
                    <th>Địa chỉ</th> 
                    <th style="text-align: center;">Chọn</th>  
                </tr> 
            </thead>
            <tbody> 
                <?php
                if (!empty($listData)) {
                    foreach ($listData as $key => $tin) {
                        ?>

                        <tr> 


                            <td class=""><?php echo $key+1; ?></td> 
                            <td class="break_word"><?php echo $tin['User']['user']; ?></td> 
                            <td class="break_word"><?php echo @$tin['User']['fullname']; ?></td> 
                            <td class="break_word"><?php echo @$tin['User']['cmnd']; ?></td> 
                            <td class="break_word"><?php echo @$tin['User']['email']; ?></td> 
                            <td class="break_word"><?php echo @$tin['User']['phone']; ?></td> 
                            <td class="break_word"><?php echo @$tin['User']['address']; ?></td>
                            <td class="break_word" align="center">
                                <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/mantanHotel-admin-user-editUserAdmin.php?id=' . $tin['User']['id']; ?>" class="input"  >Sửa</a>  
                                <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/mantanHotel-admin-user-deleteUserAdmin.php?id=' . $tin['User']['id'] ?>" class="input" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"  >Xóa</a>
                            </td> 

                        </tr> 


                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td align="center" colspan="8">Chưa có người dùng nào.</td>
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