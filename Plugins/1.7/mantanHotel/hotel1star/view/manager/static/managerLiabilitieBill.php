<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Quản lý công nợ</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php global $urlHomeManager;
echo $urlHomeManager;
?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Quản lý công nợ</span></li>
                <li><span>Công nợ chi</span></li>
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

            <h2 class="panel-title">Công nợ chi</h2>
            <div class="showMess"><?php echo $mess; ?></div>
        </header>
        <div class="panel-body">
            <div class="row" style="margin-bottom: 1em;">
                <form class="form-inline" role="form">
                    <div class="form-group col-sm-12 text-left">
                        <label class="control-label">Từ ngày</label>
                        <div class="input-daterange input-group" data-plugin-datepicker>
                            <input type="text" class="form-control" name="dateStart" value="<?php echo @$_GET['dateStart']; ?>"/>
                        </div>
                        <label>đến ngày</label>
                        <div class="input-daterange input-group" data-plugin-datepicker>
                            <input type="text" class="form-control" name="dateEnd" value="<?php echo @$_GET['dateEnd']; ?>"/>
                        </div>
                        <input type="submit" class="btn btn-primary btn-sm calculation" name="action"  value="Tìm kiếm"/>
                        &nbsp;&nbsp;
                        <input type="submit" class="btn btn-default" name="action" value="Xuất Excel" />
                    </div>
                </form>
            </div>
            <br/>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none" id="">
                    <thead>
                        <tr>
                            <th>Ngày tạo</th>
                            <th>Số tiền</th>
                            <th>Người nhận</th>
                            <th>Người chi</th>
                            <th>Ghi chú</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalMoney = 0;
                        if (!empty($listData)) {
                            foreach ($listData as $data) {
                                $dateCreate = getdate($data['Bill']['time']);
                                echo '  <tr>
                                            <td>' . $dateCreate['hours'] . ':' . $dateCreate['minutes'] . ' ' . $dateCreate['mday'] . '/' . $dateCreate['mon'] . '/' . $dateCreate['year'] . '</td>
                                            <td>' . number_format($data['Bill']['coin']) . '</td>
                                            <td>' . $data['Bill']['nguoi_nhan'] . '</td>
                                            <td>' . $data['Bill']['nguoi_chi'] . '</td>
                                            <td>' . nl2br($data['Bill']['note']) . '</td>
                                            <td class="actions">
                                                <a href="' . $urlHomes . 'managerAddBill?id=' . $data['Bill']['id'] . '" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                                <a href="' . $urlHomes . 'managerDeleteBill?id=' . $data['Bill']['id'] . '" class="on-default remove-row" onclick="return confirm(\'Bạn có chắc chắn muốn xóa không?\')"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>';

                                $totalMoney = $totalMoney + $data['Bill']['coin'];
                            }
                        } else {
                            echo '<tr><td colspan="7" align="center">Chưa có công nợ chi</td></tr>';
                        }
                        ?>

                    </tbody>
                </table>
            </div>
            <br/>
            <h2 class="panel-title text-center">Tổng công nợ chi theo các hóa đơn thống kê trong bảng trên</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none" id="">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Số công nợ</th>
                            <th>Số tiền</th>                      
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Tổng cộng:</strong></td>
                            <td><strong><?php echo count($listData); ?></strong></td>
                            <td><strong><?php echo number_format($totalMoney) . ' VNĐ'; ?></strong></td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row panel-body" style="margin-top: 1em;">
                <?php
                if($totalPage>0){
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
    
                    echo '<a href="' . $urlNow . '?page=' . $back . '">Trang trước</a> ';
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        echo ' <a href="' . $urlNow . '?page=' . $i . '">' . $i . '</a> ';
                    }
                    echo ' <a href="' . $urlNow . '?page=' . $next . '">Trang sau</a> ';
    
                    echo 'Tổng số trang: ' . $totalPage;
                }
                ?>
            </div>
        </div>
    </section>

    <!-- end: page -->
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>