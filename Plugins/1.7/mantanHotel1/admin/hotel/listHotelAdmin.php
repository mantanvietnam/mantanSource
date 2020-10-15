<script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/script.js'; ?>"></script>
<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<?php
$breadcrumb = array('name' => 'khách sạn',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-hotel-listHotelAdmin.php',
    'sub' => array('name' => 'Danh sách khách sạn')
);
addBreadcrumbAdmin($breadcrumb);
?>    

<div class="clear"></div>

<div class="taovien" >
    <?php
    if (isset($_GET['status'])) {
        switch ($_GET['status']) {
            case 1: echo '<p style="color:red;">Thêm khách sạn thành công!</p>';
                break;
            case -1: echo '<p style="color:red;">Thêm khách sạn không thành công!</p>';
                break;
            case 3: echo '<p style="color:red;">Sửa khách sạn thành công!</p>';
                break;
            case -3: echo '<p style="color:red;">Sửa khách sạn không thành công!</p>';
                break;
            case 4: echo '<p style="color:red;">Xóa khách sạn thành công!</p>';
                break;
        }
    }
    ?>
    <form action="" method="post" name="listForm">
        <table id="listTable" cellspacing="0" class="tableList">

            <tr>
                <th>STT</th>
                <th>Tên khách sạn</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Website</th>
                <th>Thao tác</th>
            </tr>
            <?php
            if (!empty($listData)) {
                foreach ($listData as $key => $data) {
                    ?>
                    <tr id="trList<?php if (isset($data['Hotel']['id'])) echo $data['Hotel']['id']; ?>">
                        <td align="center" ><?php if (isset($key)) echo $key + 1; ?> </td>
                        <td height="" id="name<?php if (isset($data['Hotel']['name'])) echo $data['Hotel']['name']; ?>"><?php if (isset($data['Hotel']['name'])) echo $data['Hotel']['name']; ?></td>
                        <td height="" id="code<?php if (isset($data['Hotel']['address'])) echo $data['Hotel']['address']; ?>"><?php if (isset($data['Hotel']['address'])) echo $data['Hotel']['address']; ?></td>
                        <td height="" id="describe<?php if (isset($data['Hotel']['phone'])) echo $data['Hotel']['phone']; ?>"><?php if (isset($data['Hotel']['phone'])) echo $data['Hotel']['phone']; ?></td>
                        <td height="" id="describe<?php if (isset($data['Hotel']['email'])) echo $data['Hotel']['email']; ?>"><?php if (isset($data['Hotel']['email'])) echo $data['Hotel']['email']; ?></td>
                        <td height="" id="describe<?php if (isset($data['Hotel']['website'])) echo $data['Hotel']['website']; ?>"><?php if (isset($data['Hotel']['website'])) echo $data['Hotel']['website']; ?></td>
                        <td align="center" width="165" >
                            <?php if ($data['Hotel']['best'] == 1) { ?>
                                <a class="btn btn-primary"  href="<?php echo $urlPlugins . 'admin/mantanHotel-admin-hotel-listHotelAdmin.php?idHotel=' . $data['Hotel']['id']; ?>">Tốt nhất</a>
                            <?php } else { ?>
                                <a class="btn btn-default"  href="<?php echo $urlPlugins . 'admin/mantanHotel-admin-hotel-listHotelAdmin.php?idHotel=' . $data['Hotel']['id']; ?>">Thường</a>
                            <?php } ?>
                            <a class="btn btn-danger"  href="<?php echo $urlPlugins . 'admin/mantanHotel-admin-hotel-deleteHotelAdmin.php?idHotel=' . $data['Hotel']['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');" >Xóa</a>

                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo '<tr><td align="center" colspan="7">Chưa có dữ liệu </td></tr>';
            }
            ?>

        </table>
        <p>
            <?php
            $urlListHotelAdmin = $urlPlugins . 'admin/mantanHotel-admin-hotel-listHotelAdmin.php';
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


