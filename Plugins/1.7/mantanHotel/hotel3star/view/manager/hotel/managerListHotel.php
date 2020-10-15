<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Danh sách khách sạn</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php
                    global $urlHomeManager;
                    echo $urlHomeManager;
                    ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Cài đặt chung</span></li>
                <li><span>Danh sách khách sạn</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="fa fa-caret-down"></a>
                <a href="#" class="fa fa-times"></a>
            </div>

            <h2 class="panel-title">Danh sách khách sạn</h2>
        </header>
        <div class="panel-body">           
            <div class="row" style="margin-bottom: 1em;">
                <form class="form-inline" role="form" method="get" action="">
                    <div class="form-group col-sm-6 text-left">
                        <a href="<?php echo $urlHomes; ?>managerAddHotel" class="btn btn-primary btn-sm">Thêm khách sạn</a>
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <div class="input-group">
                            <input type="text" class="form-control" name="key" value="<?php echo @$_GET['key']; ?>" placeholder="Tìm kiếm...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" style="padding: 9px 12px;" type="submit"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <br/>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none" id="">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên khách sạn</th>
                            <th>Địa chỉ</th>
                            <th>Điện thoại</th>
                            <th>Email</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($listData)) {
                            $dem = 0;
                            foreach ($listData as $data) {
                                $dem++;
                                echo '
                                <tr class="gradeX">
                                        <td>' . $dem . '</td>
                                        <td><a href="/hotel/'.$data['Hotel']['slug'].'.html" target="_blank" >' . $data['Hotel']['name'] . '</a></td>
                                        <td>' . $data['Hotel']['address'] . '</td>
                                        <td>' . $data['Hotel']['phone'] . '</td>
                                        <td>' . $data['Hotel']['email'] . '</td>
                                        <td class="actions">
                                                <a href="' . $urlHomes . 'managerAddHotel?idHotel=' . $data['Hotel']['id'] . '" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                                <a href="#" class="on-default remove-row" onclick="deleteData(\'' . $data['Hotel']['id'] . '\');"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                </tr>
                        ';
                            }
                        } else {
                            echo '<tr>
                                    <td align="center" colspan="7">Không có khách sạn nào.</td>
                                </tr>';
                        }
                        ?>

                    </tbody>
                </table>
            </div>
            <br>

        </div>
    </section>

    <!-- end: page -->
</section>
</div>
<script type="text/javascript">
    var urlWeb = "<?php echo $urlHomes . 'managerDeleteHotel'; ?>";
    var urlNow = "<?php echo $urlNow; ?>";

    function deleteData(idDelete)
    {
        var check = confirm('Bạn có chắc chắn muốn xóa!');
        if (check)
        {
            $.ajax({
                type: "POST",
                url: urlWeb,
                data: {idDelete: idDelete}
            }).done(function (msg) {
                window.location = urlNow;
            })
                    .fail(function () {
                        window.location = urlNow;
                    });
        }
    }
</script>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>