<script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/script.js'; ?>"></script>
<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<?php
$breadcrumb = array('name' => 'khách sạn',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-request-ProcessRequest.php',
    'sub' => array('name' => 'Thực hiện báo giá')
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
                <tr>
                    <td>Giá báo</td>
                    <td>
                        <input type="number" min="0" placeholder="Nhập giá báo" name="price" class="form-control" required="required" value="" />
                    </td>
                </tr>
                <tr>
                    <td>Nội dung báo giá</td>
                    <td>
                        <textarea name="contentRequest" class="form-control" rows="4"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><button class="btn btn-primary">Gửi báo giá</button></td>
                </tr>
            </tbody>

        </table>

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


