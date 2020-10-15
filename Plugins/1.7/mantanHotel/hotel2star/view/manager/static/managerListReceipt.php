<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Quản lý thu</h2>

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
                <li><span>Quản lý thu</span></li>
                <li><span>Danh sách phiếu thu</span></li>
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

            <h2 class="panel-title">Danh sách phiếu thu</h2>
        </header>
        <div class="panel-body">
            <form class="form-inline" role="form" action="/managerListReceipt" method="get">
                <div class="row" style="margin-bottom: 1em;">

                    <div class="form-group col-sm-4 text-left">
                        <label  for="selectreceipts"> Lựa chọn nhân viên</label>
                        <select id="selectreceipts" name="idStaff" class="form-control">
                            <option value="">Chọn nhân viên</option>
                            <?php
                            if (!empty($listStaff)) {
                                foreach ($listStaff as $staff) {
                                    ?>
                                    <option value="<?php echo $staff['Staff']['id'] ?>" <?php
                                    if ($_GET['idStaff'] == $staff['Staff']['id']) {
                                        echo ' selected';
                                    }
                                    ?> ><?php echo $staff['Staff']['fullname'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                        </select>

                    </div>
                    <div class="form-group col-sm-6 text-left">
                        <label  for="selectreceipts"> Nhập CMND khách hàng</label>
                        <input name="cmnd" type="text" class="form-control" value="<?php echo @$_GET['cmnd'] ?>"/>

                    </div>


                </div>
                <div class="row" style="margin-bottom: 1em;">

                    <div class="form-group col-sm-9 text-left">
                        <label class="control-label">Từ ngày</label>
                        <div class="input-daterange input-group" data-plugin-datepicker>
                            <input type="text" class="form-control" name="dateStart" value="<?php echo @$_GET['dateStart'] ?>" >
                        </div>
                        <label>đến</label>
                        <div class="input-daterange input-group" data-plugin-datepicker>
                            <input type="text" class="form-control" name="dateEnd" value="<?php echo @$_GET['dateEnd'] ?>" >
                        </div>
                        <button type="submit" href="" class="btn btn-primary btn-sm" title="" data-toggle="tooltip" data-trigger="hover" data-original-title="Tính phiếu thu theo thời gian" id="inputTooltip">Tổng kết</button>
                    </div>

                </div>
            </form>

            <br/>
            <h2 class="panel-title text-center">Danh sách phiếu thu</h2>
            <div class="form-group col-sm-offset-9 col-sm-3 text-right">
                <a href="/managerAddReceipt" class="btn btn-primary btn-sm">Thêm phiếu thu</a>
            </div>
            <br/>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none" id="">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ngày, giờ tạo</th>
                            <th>Diễn giải phiếu thu</th>
                            <th>Số tiền</th>
                            <th>Người trả</th>
                            <th>Tạo bởi</th>
                            <th>Ghi chú</th>
                            <!--<th>Thao tác</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalMoney = 0;
                        if (!empty($listData)) {
                            $modelStaff = new Staff();
                            foreach ($listData as $key => $data) {
                                $dateCheckin = getdate($data['Book']['dataRoom']['Room']['checkin']['dateCheckin']);
                                $dateCheckout = $data['Book']['today'];
                                $idStaff = $data['Book']['dataRoom']['Room']['checkin']['idStaff'];
                                $infoStaff = $modelStaff->getStaff($idStaff);
                                ?>
                                <tr class="gradeX">
                                    <td><?php echo $key++ ?></td>
                                    <td><?php echo $dateCheckin['mday'] . '/' . $dateCheckin['mon'] . '/' . $dateCheckin['year'] . ' - ' . $dateCheckout['mday'] . '/' . $dateCheckout['mon'] . '/' . $dateCheckout['year'] ?></td>
                                    <td>Tiền phòng</td>
                                    <td><?php echo number_format($data['Book']['pricePay']) . ' VNĐ'; ?></td>
                                    <td><?php echo $data['Book']['dataRoom']['Room']['checkin']['Custom']['cus_name']; ?></td>
                                    <td><?php echo $infoStaff['Staff']['fullname']; ?></td>
                                    <td><?php echo $data['Book']['note'] ?></td>
            <!--                                <td class="actions">
                                        <a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>
                                        <a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>
                                        <a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
                                    </td>-->
                                </tr>
                                <?php
                                $totalMoney = $totalMoney + $data['Book']['pricePay'];
                            }
                        } else {
                            echo '<tr class="gradeX"><td colspan="9" align="center">Không có phiếu thu</td></tr>';
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
            <div class="row" style="margin-top: 1em;">
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
                $urlNow = $urlHomes.'managerListReceipt';
                echo '<a href="' . $urlNow . '?page=' . $back . '">Trang trước</a> ';
                for ($i = $startPage; $i <= $endPage; $i++) {
                    echo ' <a href="' . $urlNow . '?page=' . $i . '">' . $i . '</a> ';
                }
                echo ' <a href="' . $urlNow . '?page=' . $next . '">Trang sau</a> ';

                echo 'Tổng số trang: ' . $totalPage;
                ?>
                <!--                <form class="form-inline" role="form">
                                    <div class="form-group col-sm-12 text-right">
                                        <button class="btn btn-default" type="submit"><i class="fa fa-file-excel-o"></i> Xuất Excel</button>
                                        <button class="btn btn-default" type="submit"><i class="fa fa-print"></i> In File</button>                        
                                    </div>
                                </form>-->
            </div>
        </div>
    </section>

    <!-- end: page -->
</section>
</div>

<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>