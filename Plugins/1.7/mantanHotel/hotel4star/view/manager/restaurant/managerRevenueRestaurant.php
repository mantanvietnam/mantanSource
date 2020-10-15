<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Báo cáo doanh thu phòng</h2>

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
                <li><span>Doanh thu</span></li>
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

            <h2 class="panel-title">Báo cáo doanh thu</h2>
        </header>
        <div class="panel-body">           

            <form class="form-inline" role="form" action="/managerRevenueBar" method="get">
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
                                    if (isset($_GET['idStaff']) && $_GET['idStaff'] == $staff['Staff']['id']) {
                                        echo ' selected';
                                    }
                                    ?> ><?php echo @$staff['Staff']['fullname'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                        </select>

                    </div>
                    <div class="form-group col-sm-6 text-left">
                       

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
                        <input type="submit" class="btn btn-primary btn-sm calculation" name="action"  value="Thống kê"/>
                        &nbsp;&nbsp;
                        <input type="submit" class="btn btn-default" name="action" value="Xuất Excel" />
                    </div>

                </div>
            </form>
            <br/>
            <h2 class="panel-title text-center">Thống kê các hóa đơn</h2>
            <br/>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none" id="">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Bàn</th>
                            <th>Tên khách hàng</th>
                            <th>Thời gian vào</th>
                            <th>Thời gian ra</th>
                            <th>Tổng tiền</th>
                            <th>Nv Checkin</th>
                            <th>Nv Checkout</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalMoney = 0;
                        if (!empty($listData)) {
                            $modelStaff = new Staff();
                            $modelManager = new Manager();
                            foreach ($listData as $key => $data) {
                                $dateCheckin = getdate($data['LogRestaurant']['dataTable']['Table']['checkin']['dateCheckin']);
                                $dateCheckout = $data['LogRestaurant']['today'];
                                $idStaffCheckin = $data['LogRestaurant']['dataTable']['Table']['checkin']['idStaff'];
                                $idStaffCheckout = $data['LogRestaurant']['dataTable']['Table']['checkin']['idStaffCheckout'];

                                if ($idStaffCheckin == $data['LogRestaurant']['dataTable']['Table']['checkin']['idManager']) {
                                    $infoStaffCheckin = $modelManager->getManager($idStaffCheckin);
                                    $staffCheckin = $infoStaffCheckin['Manager']['fullname'];
                                } else {
                                    $infoStaffCheckin = $modelStaff->getStaff($idStaffCheckin);
                                    $staffCheckin = $infoStaffCheckin['Staff']['fullname'];
                                }
                                if ($idStaffCheckout == $data['LogRestaurant']['dataTable']['Table']['checkin']['idManager']) {
                                    $infoStaffCheckout = $modelManager->getManager($idStaffCheckout);
                                    $staffCheckout = $infoStaffCheckout['Manager']['fullname'];
                                } else {
                                    $infoStaffCheckout = $modelStaff->getStaff($idStaffCheckout);
                                    $staffCheckout = $infoStaffCheckout['Staff']['fullname'];
                                }

                                $nameRoom = $data['LogRestaurant']['dataTable']['Table']['name'];
                                $totalMoney = $totalMoney + $data['LogRestaurant']['pricePay'];
                                ?>
                                <tr class="gradeX">
                                    <td><?php echo $key + 1 ?></td>
                                    <td><?php echo $nameRoom; ?></td>
                                    <td><?php echo $data['LogRestaurant']['dataTable']['Table']['checkin']['cus_name']; ?></td>
                                    <td><?php echo $dateCheckin['hours'] . ':' . $dateCheckin['minutes'] . ' ' . $dateCheckin['mday'] . '/' . $dateCheckin['mon'] . '/' . $dateCheckin['year']; ?></td>
                                    <td><?php echo $dateCheckout['hours'] . ':' . $dateCheckout['minutes'] . ' ' . $dateCheckout['mday'] . '/' . $dateCheckout['mon'] . '/' . $dateCheckout['year'] ?></td>
                                    <td><?php echo number_format($data['LogRestaurant']['pricePay']) . ' VNĐ'; ?></td>
                                    <td><?php echo $staffCheckin; ?></td>
                                    <td><?php echo $staffCheckout; ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr class="gradeX"><td colspan="9" align="center">Không có doanh thu</td></tr>';
                        }
                        ?>                 
                    </tbody>
                </table>
            </div>
            <br/>
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
            <h2 class="panel-title text-center">Tổng doanh thu theo các hóa đơn thống kê trong bảng trên</h2>
            <br/>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none" id="">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Số lượt khách</th>
                            <th>Doanh thu</th>                      
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Tổng cộng</strong></td>
                            <td><strong><?php echo count($listData); ?></strong></td>
                            <td><strong><?php echo number_format($totalMoney) . ' VNĐ'; ?></strong></td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- end: page -->
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>