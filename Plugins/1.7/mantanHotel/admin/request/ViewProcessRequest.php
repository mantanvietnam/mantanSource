<script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/script.js'; ?>"></script>
<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<?php
$breadcrumb = array('name' => 'khách sạn',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-request-ViewProcessRequest.php',
    'sub' => array('name' => 'Xem lại báo giá')
);
addBreadcrumbAdmin($breadcrumb);
?>
<div class="clear"></div>

<div class="taovien" >
    <form action="" method="post" name="listForm">
        <table id="listTable" cellspacing="0" class="tableList">

            <tbody>
                <tr>
                    <td>Thời gian yêu cầu</td>
                    <?php $time_start = getdate($data['Request']['time']); ?>
                    <td><?php echo $time_start['hours'] . ':' . $time_start['minutes'] . ' ' . $time_start['mday'] . '/' . $time_start['mon'] . '/' . $time_start['year']; ?></td>
                </tr>
                <tr>
                    <td>Người yêu cầu</td>
                    <td>
                        Họ tên: <?php echo $data['Request']['fullName'] ?> <br />
                        Email: <?php echo $data['Request']['email'] ?> <br />
                        Điện thoại: <?php echo $data['Request']['fone'] ?> <br />
                    </td>
                </tr>
                <tr>
                    <td>Nội dung yêu cầu</td>
                    <td><?php echo $data['Request']['content'] ?></td>
                </tr>

            </tbody>

        </table>
        <?php
        $modelHotel = new Hotel();
        $hotelProcess = $data['Request']['hotelProcess'];
        if (!empty($hotelProcess)) {
            foreach ($hotelProcess as $key => $hotel) {
                $idHotel = $key;
                if ($key != 'miniHotel') {
                    $infoHotel = $modelHotel->getHotel($key);
                    if (function_exists('getLinkHotelDetail')) {
                        $urlHotel = getLinkHotelDetail($infoHotel);
                    } else {
                        $urlHotel = '/';
                    }
                } else {
                    $urlHotel = $urlHomes;
                    $infoHotel['Hotel']['name'] = 'Hotel365.vn';
                }
                ?>
                <table id="" cellspacing="0" class="tableList">
                    <tbody>
                        <tr>
                            <td width="150">Tên khách sạn : </td>
                            <td><?php echo '<a href="' . $urlHotel . '">' . $infoHotel['Hotel']['name'] . '</a>'; ?></td>
                        </tr>
                        <tr>
                            <td width="150">Giá báo: </td>
                            <td><?php echo $data['Request']['hotelProcess'][$idHotel]['price'] ?></td>
                        </tr>
                        <tr>
                            <td width="150">Nội dung báo giá: </td>
                            <td><?php echo $data['Request']['hotelProcess'][$idHotel]['contentRequest']; ?> </td>
                        </tr>
                    </tbody>
                </table>
                <?php
            }
        }
        ?>
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


