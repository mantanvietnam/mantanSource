<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thanh toán bàn nhà hàng</h2>

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
                <li><span>Bàn nhà hàng</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            <form id="summary-form" method="post" action="<?php echo $urlHomes . 'managerCheckoutRestaurantProcess'; ?>" class="form-horizontal">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Bàn nhà hàng: <?php echo $dataTable['Table']['name']; ?></h2>
                    </header>
                    <div class="panel-body">
                        <div class="row">    
                            <div class="col-sm-6">
                                <h2 class="panel-title">Thông tin bàn nhà hàng</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-md-4">Tên khách hàng:</label>
                                    <div class="col-md-8">
                                        <label ><strong><?php echo $dataTable['Table']['checkin']['cus_name']; ?></strong></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4">Vào lúc:</label>
                                    <div class="col-md-8">
                                        <label>
                                            <strong>
                                                <?php
                                                $dateCheckin = getdate($dataTable['Table']['checkin']['dateCheckin']);
                                                echo $dateCheckin['hours'] . ':' . $dateCheckin['minutes'] . ' ngày ' . $dateCheckin['mday'] . '/' . $dateCheckin['mon'] . '/' . $dateCheckin['year'];
                                                ?>
                                            </strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4">Trả lúc:</label>
                                    <div class="col-md-8">
                                        <label>
                                            <strong>
                                                <?php
                                                echo $today['hours'] . ':' . $today['minutes'] . ' ngày ' . $today['mday'] . '/' . $today['mon'] . '/' . $today['year'];
                                                ?>
                                            </strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-5">Thời gian dùng:</label>
                                    <div class="col-sm-7">
                                        <label>
                                            <strong>
                                                <?php echo $textUse; ?>
                                            </strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">                              
                                <h2 class="panel-title">Tiền dịch vụ</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-md-4"><b>Hàng hóa - Dịch vụ</b></label>
                                    <div class="col-md-4"><b>Số lượng</b></div>
                                    <div class="col-md-4"><b>Giá bán</b></div>
                                </div>
                                <?php
                                if (!empty($dataTable['Table']['checkin']['hang_hoa'])) {
                                    foreach ($dataTable['Table']['checkin']['hang_hoa'] as $hang_hoa => $info) {
                                        echo '  <div class="form-group">
                                                        <label class="col-md-4">' . $info['name'] . '</label>
                                                        <div class="col-md-4">' . $info['number'] . '</div>
                                                        <div class="col-md-4">' . number_format($info['price']) . '</div>
                                                    </div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <br/>
                        <div class="row">                          
                            <h2 class="panel-title" style="margin-left: 13px;">Tổng cộng</h2>
                            <br/>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <ul>
                                        <li style="float: left;width: 20%;"><b>Tiền HH - DV:</b> <?php echo number_format($priceMerchandise); ?></li>
                                        <li style="float: left;width: 20%;"><b>Giảm trừ:</b> <?php echo number_format($giam_tru); ?></li>
                                    </ul>
                                </div>
                            </div>
                            <br />
                            <div class="col-sm-4">
                                <div class="form-group" style="color: red;">
                                    <label class="col-md-5">Phải thanh toán:</label>
                                    <label class="col-md-7"><strong><?php echo number_format($pricePay); ?></strong></label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-md-5 text-right">Hình thức thu:</label>
                                    <div class="col-sm-7"><?php
                                        global $typePay;
                                        $typePay = $hinhThucThu;
                                        echo $hinhThucThu;
                                        ?></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-md-4 text-right">Trạng thái:</label>
                                    <div class="col-sm-8"><?php
                                        global $statusPay;
                                        echo $statusPay[$statusPaySelect];
                                        ?></div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label class="col-sm-2">Ghi chú:</label>
                                <div class="col-sm-10"><?php echo nl2br($note); ?></div>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="text-center">
                                <button class="btn btn-primary">Trả bàn nhà hàng</button>
                                <a href="<?php echo $urlHomes . 'managerHotelDiagram' ?>" class="btn btn-default">Hủy</a>
                            </div>
                        </div>
                    </footer>
                </section>
            </form>
        </div>
    </div>
    <!-- end: page -->
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>