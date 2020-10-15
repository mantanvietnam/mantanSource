<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Danh sách các loại phòng</h2>

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
                <li><span>Danh sách các loại phòng</span></li>
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

            <h2 class="panel-title">Danh sách các loại phòng</h2>
        </header>
        <div class="panel-body">
            <div class="row" style="margin-bottom: 1em;">
                <?php
                if (isset($_GET['status'])) {
                    switch ($_GET['status']) {
                        case 1: echo '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Thêm loại phòng thành công!</p>';
                            break;
                        case -1: echo '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Thêm loại phòng không thành công!</p>';
                            break;
                        case 3: echo '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Sửa loại phòng thành công!</p>';
                            break;
                        case -3: echo '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Sửa loại phòng không thành công!</p>';
                            break;
                        case 4: echo '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Xóa loại phòng thành công!</p>';
                            break;
                    }
                }
                ?>
                <form class="form-inline  col-md-4" role="form">                  
                    <div class="form-group">
                        <a href="managerAddTypeRoom" class="btn btn-primary btn-sm">Thêm loại phòng</a>
                    </div>
                </form>


            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none">
                    <thead>
                        <tr style="vertical-align: middle; text-align: center">
                            <th>STT</th>
                            <th>Loại phòng</th>
                            <th>Giá phòng ngày thường</th>
                            <th>Cài đặt giá</th>
                            <th>Quy định phụ trội</th>
                            <th>Số giường</th>
                            <th>Số người</th>
                            <th>Mô tả</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($listData)) {
                            foreach ($listData as $key => $room) {
                                ?>
                                <tr class="gradeX">
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $room['TypeRoom']['roomtype']; ?></td>
                                    <td><?php echo number_format($room['TypeRoom']['ngay_thuong']['gia_ngay']); ?></td>
                                    <td>
                                        <ul>
                                            <li>1 ngày giá: <strong><?php echo number_format($room['TypeRoom']['ngay_thuong']['gia_ngay']); ?></strong></li>
                                            <li>Qua đêm giá: <strong><?php echo number_format($room['TypeRoom']['ngay_thuong']['gia_qua_dem']); ?></strong></li>
                                            <li><strong>Tính theo giờ:</strong>
                                                <ul>
                                                    <?php
                                                    if (!empty($room['TypeRoom']['ngay_thuong']['gia_theo_gio'])) {
                                                        foreach ($room['TypeRoom']['ngay_thuong']['gia_theo_gio'] as $key => $gia) {
                                                            ?>
                                                            <li>Giờ thứ <strong><?php echo $key; ?></strong> giá: <strong><?php echo number_format($gia); ?></strong></li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li><span class="text-danger">Phụ trội quá giờ Checkout ở ngày</span>
                                                <ul>
                                                    <?php
                                                    if (!empty($room['TypeRoom']['ngay_thuong']['phu_troi_checkout_ngay'])) {
                                                        foreach ($room['TypeRoom']['ngay_thuong']['phu_troi_checkout_ngay'] as $key => $gia) {
                                                            ?>
                                                            <li>Giờ thứ <strong><?php echo $key; ?></strong> giá: <strong><?php echo number_format($gia); ?></strong></li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <li>Quá quy định trên sẽ tính thành 1 ngày</li>
                                                </ul>
                                            </li>
                                            <li><span class="text-danger">Phụ trội quá giờ Checkout ở qua đêm</span>
                                                <ul>
                                                    <?php
                                                    if (!empty($room['TypeRoom']['ngay_thuong']['phu_troi_checkout_dem'])) {
                                                        foreach ($room['TypeRoom']['ngay_thuong']['phu_troi_checkout_dem'] as $key => $gia) {
                                                            ?>
                                                            <li>Giờ thứ <strong><?php echo $key; ?></strong> giá: <strong><?php echo number_format($gia); ?></strong></li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <li>Quá quy định trên sẽ tính thành 1 ngày</li>
                                                </ul>
                                            </li>
                                            <li><span class="text-danger">Phụ trội vào sớm giờ Checkin ở ngày</span>
                                                <ul>
                                                    <?php
                                                    if (!empty($room['TypeRoom']['ngay_thuong']['phu_troi_checkin_ngay'])) {
                                                        foreach ($room['TypeRoom']['ngay_thuong']['phu_troi_checkin_ngay'] as $key => $gia) {
                                                            ?>
                                                            <li>Giờ thứ <strong><?php echo $key; ?></strong> giá: <strong><?php echo number_format($gia); ?></strong></li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <li>Quá quy định trên sẽ tính thành 1 ngày</li>
                                                </ul>
                                            </li>
                                            <li><span class="text-danger">Phụ trội vào sớm giờ Checkin ở đêm</span>
                                                <ul>
                                                    <?php
                                                    if (!empty($room['TypeRoom']['ngay_thuong']['phu_troi_checkin_dem'])) {
                                                        foreach ($room['TypeRoom']['ngay_thuong']['phu_troi_checkin_dem'] as $key => $gia) {
                                                            ?>
                                                            <li>Giờ thứ <strong><?php echo $key; ?></strong> giá: <strong><?php echo number_format($gia); ?></strong></li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <li>Quá quy định trên sẽ tính thành 1 đêm</li>
                                                </ul>
                                            </li>
                                            <li><span class="text-danger">Phụ trội quá số lượng người ở</span>
                                                <ul>
                                                    <li>Phụ trội mỗi người tiếp theo: <strong><?php echo number_format($room['TypeRoom']['ngay_thuong']['phu_troi_them_khach']); ?></strong></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                    <td><?php echo $room['TypeRoom']['so_giuong']; ?></td>
                                    <td><?php echo $room['TypeRoom']['so_nguoi']; ?></td>
                                    <td><?php echo @$room['TypeRoom']['desc']; ?></td>
                                    <td class="break_word" align="center">
                                        <a style="padding: 4px 8px;" href="<?php echo $urlHomes . 'managerEditTypeRoom?id=' . $room['TypeRoom']['id']; ?>" class="input"  >Sửa</a>  
                                        <a style="padding: 4px 8px;" href="<?php echo $urlHomes . 'managerDeleteTypeRoom?id=' . $room['TypeRoom']['id'] ?>" class="input" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"  >Xóa</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td align="center" colspan="9">Chưa có loại phòng nào.</td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>             
                </table>
            </div>
        </div>
    </section>

    <!-- end: page -->
</section>
</div>
<div id="dialog" class="modal-block mfp-hide">
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">Bạn có chắc?</h2>
        </header>
        <div class="panel-body">
            <div class="modal-wrapper">
                <div class="modal-text">
                    <p>Bạn có chắc muốn xóa dòng này?</p>
                </div>
            </div>
        </div>
        <footer class="panel-footer">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button id="dialogConfirm" class="btn btn-primary">Xóa</button>
                    <button id="dialogCancel" class="btn btn-default">Hủy</button>
                </div>
            </div>
        </footer>
    </section>
</div>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>