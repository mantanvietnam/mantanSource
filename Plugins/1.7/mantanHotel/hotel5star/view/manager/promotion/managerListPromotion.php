<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Danh sách khuyến mại</h2>

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
                <li><span>Khuyến mại</span></li>
                <li><span>Danh sách khuyến mại</span></li>
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

            <h2 class="panel-title">Danh sách khuyến mại</h2>
        </header>
        <div class="panel-body">
            <?php
            if (isset($_GET['status'])) {
                switch ($_GET['status']) {
                    case 1: echo '<p class="success_mess""><span class="glyphicon glyphicon-ok"></span> Thêm khuyến mại thành công!</p>';
                        break;
                    case -1: echo '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Thêm khuyến mại không thành công!</p>';
                        break;
                    case 3: echo '<p class="success_mess""><span class="glyphicon glyphicon-ok"></span> Sửa khuyến mại thành công!</p>';
                        break;
                    case -3: echo '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Sửa khuyến mại không thành công!</p>';
                        break;
                    case 4: echo '<p class="success_mess""><span class="glyphicon glyphicon-ok"></span> Xóa khuyến mại thành công!</p>';
                        break;
                }
            }
            ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-md">
                        <a href="/managerAddPromotion"><button id="" class="btn btn-primary">Thêm <i class="fa fa-plus"></i></button></a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none" >
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Thời gian bắt đầu</th>
                            <th>Thời gian kết thúc</th>
                            <th>Loại phòng</th>
                            <th>Trị giá khuyến mại</th>
                            <th>Nội dung khuyến mại</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($listData)) {

                            foreach ($listData as $key => $tin) {
                                $time_start = getdate($tin['Promotion']['time_start']);
                                $time_end = getdate($tin['Promotion']['time_end']);
                                ?>
                                <tr> 
                                    <td><?php echo $key + 1; ?></td> 
                                    <td><?php echo $time_start['hours'] . ':' . $time_start['minutes'] . ' ' . $time_start['mday'] . '/' . $time_start['mon'] . '/' . $time_start['year']; ?></td>
                                    <td><?php echo $time_end['hours'] . ':' . $time_end['minutes'] . ' ' . $time_end['mday'] . '/' . $time_end['mon'] . '/' . $time_end['year']; ?></td>
                                    <td><?php echo @$listTypeRoom[$tin['Promotion']['type_room']] ?></td> 
                                    <td><?php echo $tin['Promotion']['promotion_value'] ?></td> 
                                    <td><?php echo $tin['Promotion']['content'] ?></td> 

                                    <td class="actions" align="center">
                                        <a href="<?php echo $urlHomes . 'managerEditPromotion?id=' . $tin['Promotion']['id']; ?>" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                        <a href="<?php echo $urlHomes . 'managerDeletePromotion?id=' . $tin['Promotion']['id']; ?>" class="on-default remove-row" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr> 
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td align="center" colspan="13">Chưa có khuyến mại nào.</td>
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
            $urlNow = $urlHomes.'managerListPromotion';
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