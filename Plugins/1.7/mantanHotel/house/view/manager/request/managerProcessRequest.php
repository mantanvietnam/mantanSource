<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thực hiện báo giá</h2>

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
                <li><span>Yêu cầu</span></li>
                <li><span>Báo giá</span></li>
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

            <h2 class="panel-title">Thực hiện báo giá</h2>
        </header>
        <div class="panel-body">
            <form method="post" action="">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-none" >
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
                </div>
            </form>
        </div>
    </section>
    <!-- end: page -->
</section>
</div>

<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>