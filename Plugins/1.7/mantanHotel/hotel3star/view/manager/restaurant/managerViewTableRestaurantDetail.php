<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thông tin chi tiết bàn nhà hàng</h2>

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
                <li><span>Thông tin chi tiết bàn nhà hàng</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">bàn nhà hàng: <?php echo @$dataTable['Table']['name']; ?></h2>
                    </header>
                    <div class="panel-body">
                        <div class="row">    
                            <div class="col-sm-6">
                                <h2 class="panel-title">Thông tin bàn nhà hàng</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-md-4"><strong>Tên khách hàng:</strong></label>
                                    <div class="col-md-8">
                                        <label ><strong><?php echo @$dataTable['Table']['checkin']['cus_name']; ?></strong></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4"><strong>Vào lúc:</strong></label>
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
                            </div>
                            <div class="col-sm-6">
                                <h2 class="panel-title"> Thông tin sử dụng</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-sm-5"><strong>Thời gian dùng bàn:</strong></label>
                                    <div class="col-sm-7">
                                        <label>
                                            <strong>
                                                <?php echo $textUse; ?>
                                            </strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                                <h2 class="panel-title" style="margin-left: 13px;">Tiền dịch vụ</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-md-3"><b>Hàng hóa - Dịch vụ</b></label>
                                    <div class="col-md-3"><b>Số lượng</b></div>
                                    <div class="col-md-3"><b>Giá bán</b></div>
                                    <div class="col-md-3"><b>Thành tiền</b></div>
                                </div>
                                <?php
                                if (!empty($dataTable['Table']['checkin']['hang_hoa'])) {
                                    foreach ($dataTable['Table']['checkin']['hang_hoa'] as $hang_hoa => $info) {
                                        echo '  <div class="form-group">
                                                        <label class="col-md-3">' . $info['name'] . '</label>
                                                        <div class="col-md-3">' . $info['number'] . '</div>
                                                        <div class="col-md-3">' . number_format($info['price']) . '</div>
                                                        <div class="col-md-3">' . number_format($info['number']*$info['price']) . '</div>
                                                    </div>';
                                    }   
                                }
                                ?>

                            
                        </div>
                        <br/>
                        <div class="row">                          
                            <h2 class="panel-title" style="margin-left: 13px;">Tổng cộng</h2>
                            <br/>
                            <div class="col-sm-6">
                                <div class="form-group" style="color: red;">
                                    <label class="col-md-6" style="color: blue; font-size: 14px;"><strong>Phải thanh toán:</strong></label>
                                    <label class="col-md-6"><strong><?php echo number_format($pricePay).' VNĐ';?></strong></label>
                                </div>
                                
                            </div>
                        </div>
                        <br/>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="text-center">
                                <a href="<?php echo $urlHomes.'managerRestaurantDiagram'; ?>"><button class="btn btn-primary">Quay lại</button></a>
                            </div>
                        </div>
                    </footer>
                </section>
        </div>
    </div>
    <!-- end: page -->
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>