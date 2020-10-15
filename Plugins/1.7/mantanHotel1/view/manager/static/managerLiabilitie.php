<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Quản lý công nợ</h2>

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
                <li><span>Quản lý công nợ</span></li>
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

            <h2 class="panel-title">Công nợ phải thu</h2>
            <div class="showMess"><?php echo $mess; ?></div>
        </header>
        <div class="panel-body">
            <div class="row">
                <form class="form-inline" role="form">
                    <div class="form-group col-sm-12 text-center">
                        <label class="control-label">Công nợ tổng hợp từ</label>
                        <div class="input-daterange input-group" data-plugin-datepicker>
                            <input type="text" class="form-control" name="dateStart" value="<?php echo @$_GET['dateStart'] ?>" >
                        </div>
                        <label>đến</label>
                        <div class="input-daterange input-group" data-plugin-datepicker>
                            <input type="text" class="form-control" name="dateEnd" value="<?php echo @$_GET['dateEnd'] ?>" >
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
                            <th>CMT</th>
                            <th>Họ tên</th>
                            <th>Địa chỉ</th>
                            <th>Email</th>
                            <th>Điện thoại</th>
                            <th>Ngày vào ra</th>
                            <th>Phòng</th>
                            <th>Số tiền</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalMoney = 0;
                        if (!empty($listData)) {
                            foreach ($listData as $data) {
                                $dateCheckin = getdate($data['Book']['dataRoom']['Room']['checkin']['dateCheckin']);
                                $dateCheckout = $data['Book']['today'];
                                echo '<tr class="gradeX">
                                        <td>' . $data['Book']['dataRoom']['Room']['checkin']['Custom']['cmnd'] . '</td>
                                        <td>' . $data['Book']['dataRoom']['Room']['checkin']['Custom']['cus_name'] . '</td>
                                        <td>' . $data['Book']['dataRoom']['Room']['checkin']['Custom']['address'] . '</td>
                                        <td>' . $data['Book']['dataRoom']['Room']['checkin']['Custom']['email'] . '</td>
                                        <td>' . $data['Book']['dataRoom']['Room']['checkin']['Custom']['phone'] . '</td>
                                        <td>' . $dateCheckin['mday'] . '/' . $dateCheckin['mon'] . '/' . $dateCheckin['year'] . ' - ' . $dateCheckout['mday'] . '/' . $dateCheckout['mon'] . '/' . $dateCheckout['year'] . '</td>
                                        <td>' . $data['Book']['dataRoom']['Room']['name'] . '</td>
                                        <td>' . number_format($data['Book']['pricePay']) . ' VNĐ</td>
                                        <td class="actions">
                                            <a href="/managerEditLiabilitie?id=' . $data['Book']['id'] . '" class="on-default edit-row" data-toggle="tooltip" data-trigger="hover" data-original-title="Sửa công nợ" id="inputTooltip"><i class="fa fa-pencil"></i></a>
                                            &nbsp;
                                            <a href="/managerListDebtbill?id=' . $data['Book']['dataRoom']['Room']['checkin']['Custom']['id'] . '" class="on-default" data-toggle="tooltip" data-trigger="hover" data-original-title="Xem danh sách hóa đơn nợ" id="inputTooltip"><i class="fa fa-list-ol"></i></a>
                                        </td>
                                    </tr>';
                                $totalMoney = $totalMoney + $data['Book']['pricePay'];
                            }
                        } else {
                            echo '<tr class="gradeX"><td colspan="9" align="center">Không có công nợ</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <br/>
            <h2 class="panel-title text-center">Tổng công nợ phải thu theo các hóa đơn thống kê trong bảng trên</h2>
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
            <div class="row" style="margin-top: 1em;">
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