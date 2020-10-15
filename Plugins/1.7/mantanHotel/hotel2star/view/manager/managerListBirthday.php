<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Danh sách sinh nhật</h2>

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
                <li><span>CSKH</span></li>
                <li><span>Danh sách sinh nhật</span></li>
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

            <h2 class="panel-title">Danh sách khách hàng gần đến sinh nhật</h2>
        </header>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none" >
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên khách</th>
                            <th>Ngày sinh</th>
                            <th>Điện thoại</th>
                            <th>Phòng ở</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($listData)) {

                            foreach ($listData as $key => $tin) {
                                ?>
                                <tr> 
                                    <td><?php echo $key + 1; ?></td> 
                                    <td><?php echo $tin['Room']['checkin']['Custom']['cus_name']; ?></td> 
                                    <td><?php echo $tin['Room']['checkin']['Custom']['birthday']; ?></td> 
                                    <td><?php echo $tin['Room']['checkin']['Custom']['phone']; ?></td> 
                                    <td><?php echo $tin['Room']['name']; ?></td> 
                                </tr> 
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td align="center" colspan="5">Chưa có khách hàng nào gần đến ngày sinh nhật.</td>
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

<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>