<script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/script.js'; ?>"></script>
<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<?php
$breadcrumb = array('name' => 'khách sạn',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-request-ListRequest.php',
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
            <option <?php if (isset($_GET['type_oder']) && ($_GET['type_oder'] == 'chuaXuLy')) echo 'selected'; ?> value="chuaXuLy">Chưa xử lý</option>
            <option <?php if (isset($_GET['type_oder']) && ($_GET['type_oder'] == 'daXuLy')) echo 'selected'; ?> value="daXuLy">Đã xử lý</option>
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
                <th>Thời gian yêu cầu</th>
                <th>Nội dung yêu cầu</th>
                <th>Nội dung báo giá</th>
                <th>Báo giá</th>
            </tr>

            <?php
            if (!empty($listData)) {
                $modelHotel = new Hotel();
                 $stt =1;
                foreach ($listData as $key => $tin) {
                   
                    $time_start = getdate($tin['Request']['time']);
                    if (!empty($tin['Request']['hotelProcess'])) {
                        $hotelProcess = $tin['Request']['hotelProcess'];
                    }
                    if (!empty($hotelProcess)) {
                        foreach ($hotelProcess as $key => $hotel) {
                            $idHotel = $key;
                            if ($key != 'miniHotel') {
                                $infoHotel = $modelHotel->getHotel($key);
                                break;
                            }
                        }
                    }
                    ?>
                    <tr id="trList<?php if (isset($tin['Request']['id'])) echo $tin['Request']['id']; ?>">
                        <td align="center" ><?php if (isset($stt)) echo $stt; ?> </td>
                        <td height="" ><?php echo $time_start['hours'] . ':' . $time_start['minutes'] . ' ' . $time_start['mday'] . '/' . $time_start['mon'] . '/' . $time_start['year']; ?></td>
                        <td height="" ><?php echo $tin['Request']['content'] ?></td>
                        <td height="" ><?php echo @$tin['Request']['hotelProcess'][$idHotel]['contentRequest']; ?></td>
                        <td class="actions" align="center">
                            <?php
                            if (!empty($idHotel)&& !empty($tin['Request']['hotelProcess'][$idHotel]['price'])) {
                                $url1 = $urlPlugins . 'admin/mantanHotel-admin-request-ViewProcessRequest.php?id=' . $tin['Request']['id'];
                                echo '<a href="' . $url1 . '" class="btn btn-primary">Xem</a><br>';
                                echo number_format($tin['Request']['hotelProcess'][$idHotel]['price']);
                            } else {
                                $url = $urlPlugins . 'admin/mantanHotel-admin-request-ProcessRequest.php?id=' . $tin['Request']['id'];
                                echo '<a  class="btn btn-primary" href="' . $url . '">Báo giá <i class="fa fa-plus"></i></a>';
                            }
                            ?>
                        </td>

                    </tr>
                    <?php
                    $stt ++;
                }
            } else {
                echo '<tr><td align="center" colspan="7">Chưa có dữ liệu </td></tr>';
            }
            ?>

        </table>
        <p>
            <?php
            $urlListHotelAdmin = $urlPlugins . 'admin/mantanHotel-admin-request-ListRequest.php';
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


