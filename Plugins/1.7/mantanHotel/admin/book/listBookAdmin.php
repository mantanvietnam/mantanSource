<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/script.js'; ?>"></script>
<?php
$breadcrumb = array('name' => 'Quản lý Đặt phòng',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-book-listBookAdmin.php',
    'sub' => array('name' => 'Danh sách Đặt phòng')
);
addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>

<div id="content">
    <?php
    if (isset($_GET['status'])) {
        switch ($_GET['status']) {
            case 1: echo '<p style="color:red;">Đặt phòng thành công!</p>';
                break;
            case -1: echo '<p style="color:red;">Đặt phòng không thành công!</p>';
                break;
            case 3: echo '<p style="color:red;">Sửa Đặt phòng thành công!</p>';
                break;
            case -3: echo '<p style="color:red;">Sửa Đặt phòng không thành công!</p>';
                break;
            case 4: echo '<p style="color:red;">Xóa Đặt phòng thành công!</p>';
                break;
        }
    }
    ?>
    <form action="" method="post" name="duan" class="taovienLimit">
        <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/mantanHotel-admin-book-addBookAdmin.php'; ?>" class="input">
            <img src="<?php echo $webRoot; ?>images/add.png"> Thêm
        </a>  
        <div class="table-responsive">
            <table class="table table-bordered" style="border: 1px solid #ddd!important; margin-top: 10px;">  
                <thead> 
                    <tr> 

                        <th>Mã đặt phòng</th> 
                        <th>Tên khách hàng</th> 
                        <th>CMND/Passport</th> 
                        <th>Checkin</th> 
                        <th>Checkout</th> 
                        <th>Phòng</th> 
                        <th>Quốc tịch</th> 
                        <th>Ghi chú</th> 
                        <th>Đặt cọc</th> 
                        <th style="text-align: center;">Chọn</th>  
                    </tr> 
                </thead>
                <tbody> 
                    <?php
                    if (!empty($listData)) {
                        foreach ($listData as $tin) {
                            ?>
                            <tr> 
                                <td class="break_word"><?php echo $tin['Book']['codeBook']; ?></td> 
                                <td class="break_word"><?php echo $tin['Book']['cus_name']; ?></td> 
                                <td class="break_word"><?php echo $tin['Book']['cmnd']; ?></td> 
                                <td class="break_word"><?php echo date("d-m-Y", $tin['Book']['date_checkin']); ?></td> 
                                <td class="break_word"><?php echo date("d-m-Y", $tin['Book']['date_checkout_foresee']); ?></td> 
                                <td class="break_word"><?php // echo $tin['Book']['room'];  ?></td> 
                                <td class="break_word"><?php echo $tin['Book']['nationlaty']; ?></td> 
                                <td class="break_word"><?php echo isset($tin['Book']['note']) ? $tin['Book']['note'] : ''; ?></td> 
                                <td class="break_word"><?php echo $tin['Book']['prepay']; ?></td> 
                                <td class="break_word" align="center">
                                    <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/mantanHotel-admin-book-editBookAdmin.php?id=' . $tin['Book']['id']; ?>" class="input"  >Sửa</a>  
                                    <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/mantanHotel-admin-book-deleteBookAdmin.php?id=' . $tin['Book']['id'] ?>" class="input" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"  >Xóa</a>
                                </td> 

                            </tr> 


                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td align="center" colspan="13">Chưa có danh sách đặt phòng nào.</td>
                        </tr>
                    <?php }
                    ?>
                </tbody> 
            </table>
        </div>
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

            echo '<a href="' . $urlNow . '?page=' . $back . '">Trang trước</a> ';
            for ($i = $startPage; $i <= $endPage; $i++) {
                echo ' <a href="' . $urlNow . '?page=' . $i . '">' . $i . '</a> ';
            }
            echo ' <a href="' . $urlNow . '?page=' . $next . '">Trang sau</a> ';

            echo 'Tổng số trang: ' . $totalPage;
            ?>
        </p>
    </form>
</div>