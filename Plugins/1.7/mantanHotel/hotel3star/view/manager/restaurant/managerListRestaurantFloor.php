<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Danh sách tầng</h2>

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
                <li><span>Danh sách tầng</span></li>
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

            <h2 class="panel-title">Danh sách tầng</h2>
        </header>
        <div class="panel-body">           
            <div class="row" style="margin-bottom: 1em;">
                <form class="form-inline" role="form">
                    <div class="form-group col-sm-6 text-left">
                        <a href="<?php echo $urlHomes; ?>managerAddRestaurantFloor" class="btn btn-primary btn-sm">Thêm tầng</a>
                    </div>
                    <div class="form-group col-sm-6 text-right">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" id="q" placeholder="Search..." />
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
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
                            <th>Tên tầng</th>
                            <th>Màu sắc</th>
                            <th>Số phòng</th>
                            <th>Ghi chú</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dem = 0;
                        if (!empty($listData)) {
                            foreach ($listData as $data) {
                                $dem++;
                                echo '
                                    <tr class="gradeX">
                                            <td>' . $dem . '</td>
                                            <td>' . $data['RestaurantFloor']['name'] . '</td>
                                            <td><div style="width: 18px;height:18px;background-color:' . $data['RestaurantFloor']['color'] . ';"></div></td>
                                            <td>' . @$data['RestaurantFloor']['tables'] . '</td>
                                            <td>' . $data['RestaurantFloor']['note'] . '</td>
                                            <td class="actions">
                                                    <a href="' . $urlHomes . 'managerAddRestaurantFloor?idRestaurantFloor=' . $data['RestaurantFloor']['id'] . '" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                                    <a href="#" class="on-default remove-row" onclick="deleteData(\'' . $data['RestaurantFloor']['id'] . '\');"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                    </tr>
                            ';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        var urlWeb = "<?php echo $urlHomes . 'managerDeleteRestaurantFloor'; ?>";
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
    <!-- end: page -->
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>