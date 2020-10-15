<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Lịch sử bảo hành</h2>

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
                <li><span>Lịch sử bảo hành</span></li>
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

            <h2 class="panel-title">Lịch sử bảo hành</h2>
        </header>
        <div class="panel-body">
            <?php
            if (isset($_GET['status'])) {
                switch ($_GET['status']) {
                    case 1: echo '<p class="success_mess""><span class="glyphicon glyphicon-ok"></span> Thêm bảo hành thành công!</p>';
                        break;
                    case -1: echo '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Thêm bảo hành không thành công!</p>';
                        break;
                    case 3: echo '<p class="success_mess""><span class="glyphicon glyphicon-ok"></span> Sửa bảo hành thành công!</p>';
                        break;
                    case -3: echo '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Sửa bảo hành không thành công!</p>';
                        break;
                    case 4: echo '<p class="success_mess""><span class="glyphicon glyphicon-ok"></span> Xóa bảo hành thành công!</p>';
                        break;
                }
            }
            ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-md">
                        <a href="/managerAddWarranty"><button id="" class="btn btn-primary">Thêm <i class="fa fa-plus"></i></button></a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none" >
                    <thead>
                        <tr>
                            <th>Thời gian</th>
                            <th>Đối tác</th>
                            <th>Điện thoại</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($listData)) {

                            foreach ($listData as $key => $tin) {
                                ?>
                                <tr> 
                                    <td><?php echo $tin['Warranty']['timeEnd'] ?></td> 
                                    <td><?php echo $tin['Warranty']['fullname'] ?></td> 
                                    <td><?php echo $tin['Warranty']['phone'] ?></td> 
                                    <td><?php echo $tin['Warranty']['note'] ?></td> 
                                </tr> 
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td align="center" colspan="5">Chưa bảo hành lần nào.</td>
                            </tr>
                        <?php }
                        ?>   
                    </tbody>
                </table>
            </div>
            <br>
            <?php
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
            $urlNow = $urlHomes.'managerListWarranty';
            echo '<a href="' . $urlNow . '?page=' . $back . '">Trang trước</a> ';
            for ($i = $startPage; $i <= $endPage; $i++) {
                echo ' <a href="' . $urlNow . '?page=' . $i . '">' . $i . '</a> ';
            }
            echo ' <a href="' . $urlNow . '?page=' . $next . '">Trang sau</a> ';

            echo 'Tổng số trang: ' . $totalPage;
            ?>
        </div>
    </section>
    <!-- end: page -->
</section>
</div>

<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>