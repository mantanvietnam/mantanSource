<script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/script.js'; ?>"></script>
<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<?php
$breadcrumb = array('name' => 'khách sạn',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-order-ListOrder.php',
    'sub' => array('name' => 'Danh sách yêu cầu báo giá')
);
addBreadcrumbAdmin($breadcrumb);
?>    

<div class="clear"></div>
<form method="get" action="">
    <div class="col-md-8 col-sm-6 col-xs-12">
        <h2 class="panel-title listrequest">Danh sách yêu cầu báo giá</h2>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12" style="    margin-top: -10px;">
        <select name="type_oder"  class="form-control user-success" onchange="this.form.submit()">
            <option <?php if (isset($_GET['type_oder']) && ($_GET['type_oder'] == 'empty')) echo 'selected'; ?> value="empty">--- Sắp xếp theo ---</option>
            <!--<option <?php if (isset($_GET['type_oder']) && ($_GET['type_oder'] == 'chuaXuLy')) echo 'selected'; ?> value="chuaXuLy">Chưa xử lý</option>-->
            <!--<option <?php if (isset($_GET['type_oder']) && ($_GET['type_oder'] == 'daXuLy')) echo 'selected'; ?> value="daXuLy">Đã xử lý</option>-->
            <option <?php if (isset($_GET['type_oder']) && ($_GET['type_oder'] == 'moiNhat')) echo 'selected'; ?> value="moiNhat">Mới nhất</option>
            <option <?php if (isset($_GET['type_oder']) && ($_GET['type_oder'] == 'cuNhat')) echo 'selected'; ?> value="cuNhat">Cũ nhất</option>
        </select>
    </div>
</form>

<div class="taovien" >
    
    <form action="" method="post" name="listForm">
        <table id="listTable" cellspacing="0" class="tableList">

            <tr>
                <th>STT</th>
                <th>Họ và tên</th>
                <th>Điện thoại</th>
                <th>Email</th>
                <th>Ngày đến</th>
                <th>Ngày đi</th>
                <th>Loại phòng</th>
                <th>Số phòng</th>
                <th>Tên phòng</th>
                <th>Số người</th>
                <th>Khách sạn</th>
            </tr>

            <?php
            if (!empty($listData)) {
                foreach ($listData as $key => $order) {
                    ?>
                    <tr id="trList<?php if (isset($tin['Order']['id'])) echo $tin['Order']['id']; ?>">
                        <td align="center" ><?php echo $key + 1; ?> </td>
                        <td height="" ><?php echo $order['Order']['name'] ?></td>
                        <td height="" ><?php echo $order['Order']['phone'] ?></td>
                        <td height="" ><?php echo @$order['Order']['email'] ?></td>
                        <td height="" ><?php echo @$order['Order']['date_start'] ?></td>
                        <td height="" ><?php echo @$order['Order']['date_end'] ?></td>
                        <td height="" ><?php echo @$order['Order']['nameTypeRoom'] ?></td>
                        <td height="" ><?php echo @$order['Order']['number_room'] ?></td>
                        <td height="" ><?php echo @$order['Order']['nameListRooms'] ?></td>
                        <td height="" ><?php echo @$order['Order']['number_people'] ?></td>
                        <td height="" ><?php echo @$order['Order']['nameHotel'] ?></td>
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

        </table>
        <p>
            <?php
            $urlListHotelAdmin = $urlPlugins . 'admin/mantanHotel-admin-order-ListOrder.php';
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

            echo '<a href="' . $urlListHotelAdmin . '?page=' . $back . '">Trang trước</a> ';
            for ($i = $startPage; $i <= $endPage; $i++) {
                echo ' <a href="' . $urlListHotelAdmin . '?page=' . $i . '">' . $i . '</a> ';
            }
            echo ' <a href="' . $urlListHotelAdmin . '?page=' . $next . '">Trang sau</a> ';

            echo 'Tổng số trang: ' . $totalPage;
            ?>
        </p>
    </form>
</div>
<script type="text/javascript">
    var urlWeb = "<?php echo $urlHomes; ?>options/";
    var urlNow = "<?php echo $urlHomes; ?>options/themes";

    function active(theme)
    {
        $.ajax({
            type: "POST",
            url: urlWeb + "changeTheme",
            data: {theme: theme}
        }).done(function (msg) {
            window.location = urlNow;
        })
                .fail(function () {
                    window.location = urlNow;
                });
    }
</script>


