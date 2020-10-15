<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thanh toán bàn nhà hàng</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php global $urlHomeManager;
echo $urlHomeManager; ?>">
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
            <form id="summary-form" method="post" action="<?php echo $urlHomes . 'managerCheckoutRestaurantConfirm'; ?>" class="form-horizontal">
                <input type="hidden" value="<?php echo $dataTable['Table']['id']; ?>" name="idroom" />
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
                                    <label class="col-md-4">Ra lúc:</label>
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
                                    <label class="col-sm-5">Thời gian đã ở:</label>
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
                                <?php
                                if (!empty($dataTable['Table']['checkin']['hang_hoa'])) {
                                    foreach ($dataTable['Table']['checkin']['hang_hoa'] as $hang_hoa => $info) {
                                        if(!$_SESSION['infoManager']['Manager']['isStaff'] || in_array('editCheckoutRestaurant',$_SESSION['infoManager']['Manager']['permissionAdvanced'])){
                                            $inputShow= '<input type="number" name="priceMerchandise[' . $hang_hoa . ']" placeholder="Nhập số lượng đã dùng" class="form-control" value="' . $info['number'] . '" required="required" />';
                                        }else{
                                            $inputShow= $info['number'] .'<input type="hidden" name="priceMerchandise[' . $hang_hoa . ']" value="' . $info['number'] . '" />';
                                        }
                                        echo '  <div class="form-group">
                                                        <label class="col-md-4">' . $info['name'] . ':</label>
                                                        <div class="col-md-8">'.$inputShow.'</div>
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
                                <div class="form-group">
                                    <label class="col-md-4">Giảm trừ:</label>
                                    <div class="col-md-8">
                                        <input type="number" name="giam_tru" placeholder="Nhập số tiền giảm trừ" class="form-control" value="" min="0">
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
                                        <label class="col-md-5">Phải thanh toán:</label>
                                        <label class="col-md-7"><strong><?php echo number_format($pricePay); ?></strong></label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="col-md-5">Hình thức thu:</label>
                                        <div class="col-sm-7">
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
                                <button class="btn btn-primary">Ghi nhận</button>
                                <a href="<?php echo $urlHomes . 'managerRestaurantDiagram' ?>" class="btn btn-default">Hủy</a>
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