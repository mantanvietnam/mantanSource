<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thanh toán trả phòng</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php global $urlHomeManager;
echo $urlHomeManager; ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Trả phòng</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            <form id="summary-form" method="post" action="<?php echo $urlHomes . 'managerCheckoutConfirm'; ?>" class="form-horizontal">
                <input type="hidden" value="<?php echo $dataRoom['Room']['id']; ?>" name="idroom" />
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Trả phòng: <?php echo $dataRoom['Room']['name']; ?></h2>
                    </header>
                    <div class="panel-body">
                        <div class="row">    
                            <div class="col-sm-6">
                                <h2 class="panel-title">Thông tin phòng</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-md-4">Tên khách hàng:</label>
                                    <div class="col-md-8">
                                        <label ><strong><?php echo $dataRoom['Room']['checkin']['Custom']['cus_name']; ?></strong></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4">Vào lúc:</label>
                                    <div class="col-md-8">
                                        <label>
                                            <strong>
                                                <?php
                                                $dateCheckin = getdate($dataRoom['Room']['checkin']['dateCheckin']);
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
                                    <label class="col-md-4">Loại phòng:</label>
                                    <div class="col-md-8">
                                        <label><strong><?php echo $typeRoom['TypeRoom']['roomtype']; ?></strong></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4">Email giới thiệu:</label>
                                    <div class="col-md-8">
                                        <label ><strong><?php echo @$dataRoom['Room']['checkin']['agency']; ?></strong></label>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <h2 class="panel-title"> Tiền phòng</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-sm-5">Hình thức ở checkin:</label>
                                    <div class="col-sm-7">
                                        <?php
                                        global $typeRegister;
                                        echo @$typeRegister[$dataRoom['Room']['checkin']['type_register']];
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-5">Hình thức ở checkout:</label>
                                    <div class="col-sm-7">
                                        <?php
                                        global $typeRegister;
                                        echo @$typeRegister[$type_register];
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-5">Chu kỳ thanh toán:</label>
                                    <div class="col-sm-7">
                                        <?php
                                        global $paymentCycle;
                                        echo @$paymentCycle[$dataRoom['Room']['checkin']['paymentCycle']['number']];
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-5">Thời gian đã ở:</label>
                                    <div class="col-sm-7">
                                        <label>
                                            <strong>
<?php echo $textUse; ?>
                                            </strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-5">Giá phòng khi checkin:</label>
                                    <div class="col-sm-7">
<?php echo number_format($dataRoom['Room']['checkin']['price']); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-5">Giá phòng khi checkout:</label>
                                    <div class="col-sm-7">
                                        <input type="number" name="priceCheckout" id="priceCheckout" class="form-control" value="<?php echo $priceRoom; ?>" required="required">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <?php
                            if(!empty($dataRoom['Room']['changePriceRoom'])){ 
                                foreach ($dataRoom['Room']['changePriceRoom'] as $changePriceRoom) { 
                                    $pricePay += $changePriceRoom['infoPay']['pricePay'];
                                    ?>
                                    <div class="row">                          
                                        <h2 class="panel-title" style="margin-left: 13px;">Thanh toán cho phòng <?php echo $changePriceRoom['nameRoom'];?></h2>
                                        <br/>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <ul>
                                                    <li style="float: left;width: 20%;"><b>Tiền phòng:</b> <?php echo number_format($changePriceRoom['infoPay']['priceRoom']); ?></li>
                                                    <li style="float: left;width: 20%;"><b>Tiền HH - DV:</b> <?php echo number_format($changePriceRoom['infoPay']['priceMerchandise']); ?></li>
                                                    <li style="float: left;width: 20%;"><b>Tiền giảm trừ:</b> <?php echo number_format($changePriceRoom['infoPay']['giam_tru']); ?></li>
                                                    <li style="float: left;width: 20%;"><b>Tiền trả trước:</b> <?php echo number_format($changePriceRoom['infoPay']['prepay']); ?></li>
                                                    <li style="float: left;width: 20%;"><b>Phí thêm người:</b> <?php echo number_format($changePriceRoom['infoPay']['pricePeople']); ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                            <?php }
                            }   
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <h2 class="panel-title">Tiền dịch vụ</h2>
                                <br/>
                                <?php
                                if (!empty($dataRoom['Room']['checkin']['hang_hoa'])) {
                                    foreach ($dataRoom['Room']['checkin']['hang_hoa'] as $hang_hoa => $info) {
                                        echo '  <div class="form-group">
                                                        <label class="col-md-4">' . $info['name'] . ':</label>
                                                        <div class="col-md-8">
                                                            <input type="number" name="priceMerchandise[' . $hang_hoa . ']" placeholder="Nhập số lượng đã dùng" class="form-control" value="' . $info['number'] . '" required="required">
                                                        </div>
                                                    </div>';
                                    }
                                }
                                ?>
                                <div class="form-group">
                                    <label class="col-md-4">Tổng cộng:</label>
                                    <div class="col-md-8">
<?php echo number_format($priceMerchandise); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <h2 class="panel-title">Phụ thu</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-md-4">Giảm trừ:</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="giam_tru" value="<?php echo $giam_tru; ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4">Trả trước:</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="prepay" value="<?php echo $dataRoom['Room']['checkin']['prepay']; ?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4">Phí ở thêm người:</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="pricePeople" value="<?php echo $pricePeople; ?>" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">                          
                            <h2 class="panel-title" style="margin-left: 13px;">Tổng cộng</h2>
                            <br/>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label class="col-md-6">Phải thanh toán:</label>
                                        <label class="col-md-6"><strong><?php echo number_format($pricePay); ?></strong></label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="col-md-6">Hình thức thu:</label>
                                        <div class="col-sm-6">
                                            <select name="hinhThucThu" class="form-control" required="">
                                                <option value="tien_mat">Tiền mặt</option>
                                                <option value="chuyen_khoan">Chuyển khoản</option>
                                                <option value="the_tin_dung">Thẻ tín dụng</option>
                                                <option value="hinh_thuc_khac">Hình thức khác</option>                                
                                            </select>
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="col-md-4">Trạng thái:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="statusPay">
                                                <?php
                                                global $statusPay;
                                                foreach ($statusPay as $key => $value) {
                                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label class="col-sm-2">Ghi chú:</label>
                                <div class="col-sm-10">
                                    <textarea name="note" class="form-control" type="text" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="text-center">
                                <button class="btn btn-primary">Trả phòng</button>
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