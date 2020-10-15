<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Báo cáo doanh thu cho đại lý</h2>

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

            <form class="form-inline" role="form" action="/managerRevenueAgency" method="get">
                <div class="row" style="margin-bottom: 1em;">

                    <div class="form-group col-sm-12 text-left">
                        <label  for="selectreceipts"> Email đại lý</label>
                        <input name="emailAgency" type="email" class="form-control" value="<?php echo @$_GET['emailAgency'] ?>"/>

                        <label class="control-label">Từ ngày</label>
                        <div class="input-daterange input-group" data-plugin-datepicker>
                            <input type="text" class="form-control" name="dateStart" value="<?php echo @$_GET['dateStart'] ?>" >
                        </div>

                        <label>đến</label>
                        <div class="input-daterange input-group" data-plugin-datepicker>
                            <input type="text" class="form-control" name="dateEnd" value="<?php echo @$_GET['dateEnd'] ?>" >
                        </div>
                        <input type="submit" class="btn btn-primary btn-sm calculation" name="action"  value="Thống kê"/>
                    </div>

                </div>

                <div class="row" style="margin-bottom: 1em;">

                    <div class="form-group col-sm-12 text-center">
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
                            <th>Phòng</th>
                            <th>Tên khách hàng</th>
                            <th>Đại lý</th>
                            <th>Thời gian checkout</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalMoney = 0;
                        if (!empty($listData)) {
                            foreach ($listData as $key => $data) {
                                $dateCheckout = $data['Agency']['timeCheckout'];
                                $totalMoney = $totalMoney + $data['Agency']['pricePay'];
                                ?>
                                <tr class="gradeX">
                                    <td><?php echo $key + 1 ?></td>
                                    <td><?php echo $data['Agency']['nameRoom']; ?></td>
                                    <td><?php echo $data['Agency']['nameCustom']; ?></td>
                                    <td><?php echo $data['Agency']['emailAgency']; ?></td>
                                    <td><?php echo $dateCheckout['hours'] . ':' . $dateCheckout['minutes'] . ' ' . $dateCheckout['mday'] . '/' . $dateCheckout['mon'] . '/' . $dateCheckout['year'] ?></td>
                                    <td><?php echo number_format($data['Agency']['pricePay']) . ' VNĐ'; ?></td>
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
                            <th>Số lượt thuê</th>
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