<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/script.js'; ?>"></script>
<?php
$breadcrumb = array('name' => 'Quản lý tài khoản',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-manager-listManager.php',
    'sub' => array('name' => 'Tất cả tài khoản')
);
addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>

<div id="content">
    <?php
    if (isset($_GET['status'])) {
        switch ($_GET['status']) {
            case 1: echo '<p style="color:red;">Thêm tài khoản thành công!</p>';
                break;
            case -1: echo '<p style="color:red;">Thêm tài khoản không thành công!</p>';
                break;
            case 3: echo '<p style="color:red;">Sửa tài khoản thành công!</p>';
                break;
            case -3: echo '<p style="color:red;">Sửa tài khoản không thành công!</p>';
                break;
            case 4: echo '<p style="color:red;">Xóa tài khoản thành công!</p>';
                break;
        }
    }
    ?>
    <form action="" method="post" name="duan" class="taovienLimit">
        <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/mantanHotel-admin-manager-addManager.php'; ?>" class="input">
            <img src="<?php echo $webRoot; ?>images/add.png"> Thêm
        </a>  
        <table class="table table-bordered" style="border: 1px solid #ddd!important; margin-top: 10px;">  
            <thead> 
                <tr> 

                    <th>Tài khoản</th> 
                    <th>Họ và tên</th> 
                    <th>Ngày hết hạn</th> 
                    <th>Phòng</th> 
                    <th>Email</th> 
                    <th>SĐT</th> 
                    <th style="text-align: center;">Chọn</th>  
                </tr> 
            </thead>
            <tbody> 
                <?php
                if (!empty($listData)) {
                    foreach ($listData as $tin) {

                        if(!empty($tin['Manager']['deadline'])){
                            $deadline = date('d-m-Y', $tin['Manager']['deadline']);
                        }else{
                            $deadline = '';
                        }

                        if (!empty($tin['Manager']['avatar'])) {
                            $avatarImage = $tin['Manager']['avatar'];
                        } else {
                            $avatarImage = $webRoot . 'images/avatar_default.png';
                        }
                        ?>

                        <tr> 
                            <td class="break_word"><?php echo $tin['Manager']['user']; ?></td> 
                            <td class="break_word"><?php echo $tin['Manager']['fullname']; ?></td> 
                            <td class="break_word"><?php echo $deadline;?></td> 
                            <td class="break_word"><?php echo @$tin['Manager']['numberRoomMax']; ?></td> 
                            <td class="break_word"><?php echo $tin['Manager']['email']; ?></td> 
                            <td class="break_word"><?php echo $tin['Manager']['phone']; ?></td> 
                            <td class="break_word" align="center">
                                <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/mantanHotel-admin-manager-editManager.php?id=' . $tin['Manager']['id']; ?>" class="input"  >Sửa</a>  
                                <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/mantanHotel-admin-manager-deleteManager.php?id=' . $tin['Manager']['id'] ?>" class="input" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"  >Xóa</a>
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
            $urlListmanagerAdmin = $urlPlugins . 'admin/mantanHotel-admin-manager-listManager.php';
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

            echo '<a href="' . $urlListmanagerAdmin . '?page=' . $back . '">Trang trước</a> ';
            for ($i = $startPage; $i <= $endPage; $i++) {
                echo ' <a href="' . $urlListmanagerAdmin . '?page=' . $i . '">' . $i . '</a> ';
            }
            echo ' <a href="' . $urlListmanagerAdmin . '?page=' . $next . '">Trang sau</a> ';

            echo 'Tổng số trang: ' . $totalPage;
            ?>
        </p>
    </form>
</div>