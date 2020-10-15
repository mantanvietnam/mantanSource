<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thông tin chi tiết phòng</h2>

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
                <li><span>Thông tin chi tiết phòng</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            <form id="summary-form" action="" method="post" class="form-horizontal">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Phòng: <?php echo $dataRoom['Room']['name']; ?></h2>
                        <div class="showMess"><?php echo $mess; ?></div>
                    </header>
                    <div class="panel-body">
                        <div class="row">    
                            <div class="col-sm-7">
                                <h2 class="panel-title">Thông tin khách hàng</h2>
                                <br/>
                                
                                <div class="form-group">
                                	<label class="col-sm-4 control-label">Tên khách hàng: <span class="required">*</span></label>
                                	<div class="col-sm-8">                                    
                                		<input type="text" name="cus_name" class="form-control" value="<?php echo @$dataRoom['Room']['checkin']['Custom']['cus_name'];?>" required />
                                	</div>
                                </div>
                                <div class="form-group">
                                	<label class="col-sm-4 control-label">Địa chỉ:</label>
                                	<div class="col-sm-8">
                                		<input type="text" name="cus_address"  class="form-control" value="<?php echo @$dataRoom['Room']['checkin']['Custom']['address'];?>" />
                                	</div>
                                </div>
                                <div class="form-group">
                                	<label class="col-sm-4 control-label">Điện thoại:</label>
                                	<div class="col-sm-8">
                                		<input type="text" name="phone" class="form-control" value="<?php echo @$dataRoom['Room']['checkin']['Custom']['phone'];?>"  />
                                	</div>
                                </div>
                                <div class="form-group">
                                	<label class="col-sm-4 control-label">Email:</label>
                                	<div class="col-sm-8">
                                		<input type="text" name="email" class="form-control" value="<?php echo @$dataRoom['Room']['checkin']['Custom']['email'];?>"  />
                                	</div>
                                </div>
                                <div class="form-group">
                                	<label class="col-sm-4 control-label">Quốc tịch:<span class="required">*</span></label>
                                	<div class="col-sm-8">
                                		<select id="company" name="nationality" class="form-control">
                                			<option value="0" <?php if(isset($dataRoom['Room']['checkin']['Custom']['nationality']) && $dataRoom['Room']['checkin']['Custom']['nationality']==0) echo 'selected';?>>Việt Nam</option>
                                			<option value="1" <?php if(isset($dataRoom['Room']['checkin']['Custom']['nationality']) && $dataRoom['Room']['checkin']['Custom']['nationality']==1) echo 'selected';?>>Khác</option>
                                		</select>
                                		<label class="error" for="room"></label>
                                	</div>
                                </div>
                                <div class="form-group">
                                	<label class="col-sm-4 control-label">Biển số xe:</label>
                                	<div class="col-sm-8">
                                		<input type="text" name="bienSoXe" class="form-control" value="<?php echo @$dataRoom['Room']['checkin']['Custom']['bienSoXe'];?>"  />
                                	</div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Email người giới thiệu:</label>
                                    <div class="col-sm-8">
                                        <input type="email" name="agency" class="form-control" value="<?php echo @$dataRoom['Room']['checkin']['agency'];?>"  />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Ghi chú checkin:</label>
                                    <div class="col-sm-8">
                                        <textarea rows="4" type="text" class="form-control" name="note"><?php echo @$dataRoom['Room']['checkin']['note'];?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <h2 class="panel-title"> Tiền phòng</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-sm-6"><strong>Hình thức checkin:</strong></label>
                                    <div class="col-sm-6">
                                        <?php
                                        global $typeRegister;
                                        echo @$typeRegister[$dataRoom['Room']['checkin']['type_register']];
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6"><strong>Hình thức checkout:</strong></label>
                                    <div class="col-sm-6">
                                        <?php
                                        global $typeRegister;
                                        echo @$typeRegister[$type_register];
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6"><strong>Thời gian đã ở:</strong></label>
                                    <div class="col-sm-6">
                                        <label>
                                            <strong>
                                                <?php echo $textUse; ?>
                                            </strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6"><strong>Tính giá theo ngày:</strong></label>
                                    <div class="col-md-6">
                                        <?php
                                            global $typeDate;
                                            echo @$typeDate[$dataRoom['Room']['checkin']['typeDate']];
                                        ?>
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label class="col-sm-6"><strong>Giá phòng checkin:</strong></label>
                                    <div class="col-sm-6">
                                        <?php echo number_format($dataRoom['Room']['checkin']['price']); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6"><strong>Giá phòng checkout:</strong></label>
                                    <div class="col-sm-6"> <?php echo number_format($priceRoom); ?></div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-sm-7">
                                <h2 class="panel-title">Thông tin phòng</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-md-4"><strong>Vào lúc:</strong></label>
                                    <div class="col-md-8">
                                        <?php
                                            $dateCheckin = getdate($dataRoom['Room']['checkin']['dateCheckin']);
                                            echo $dateCheckin['hours'] . ':' . $dateCheckin['minutes'] . ' ngày ' . $dateCheckin['mday'] . '/' . $dateCheckin['mon'] . '/' . $dateCheckin['year'];
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4"><strong>Thời gian ra dự kiến:</strong></label>
                                    <div class="col-md-8">
                                        <?php
                                            if (!empty($dataRoom['Room']['checkin']['dateCheckoutForesee'])) {
                                                $dateCheckoutForesee = getdate($dataRoom['Room']['checkin']['dateCheckoutForesee']);
                                                echo $dateCheckoutForesee['hours'] . ':' . $dateCheckoutForesee['minutes'] . ' ngày ' . $dateCheckoutForesee['mday'] . '/' . $dateCheckoutForesee['mon'] . '/' . $dateCheckoutForesee['year'];
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4"><strong>Loại phòng:</strong></label>
                                    <div class="col-md-8">
                                        <?php echo $typeRoom; ?>
                                    </div>
                                </div>  
                                                          
                            </div>
                            <div class="col-sm-5">
                                <h2 class="panel-title">Phụ thu</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-md-6"><strong>Giảm trừ:</strong></label>
                                    <div class="col-md-6"><?php echo number_format($giam_tru); ?></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6"><strong>Trả trước:</strong></label>
                                    <div class="col-md-6"><?php echo number_format($dataRoom['Room']['checkin']['prepay']); ?></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6"><strong>Phí ở thêm người:</strong></label>
                                    <div class="col-md-6"><?php echo number_format($pricePeople); ?></div>
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
                            <div class="col-sm-7">
                                <h2 class="panel-title">Tiền dịch vụ</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-md-4"><b>Hàng hóa - Dịch vụ</b></label>
                                    <div class="col-md-2"><b>Số lượng</b></div>
                                    <div class="col-md-3"><b>Giá bán</b></div>
                                    <div class="col-md-3"><b>Thành tiền</b></div>
                                </div>
                                <?php
                                if (!empty($dataRoom['Room']['checkin']['hang_hoa'])) {
                                    foreach ($dataRoom['Room']['checkin']['hang_hoa'] as $hang_hoa => $info) {
                                        echo '  <div class="form-group">
                                                        <label class="col-md-4">' . $info['name'] . '</label>
                                                        <div class="col-md-2">' . $info['number'] . '</div>
                                                        <div class="col-md-3">' . number_format($info['price']) . '</div>
                                                        <div class="col-md-3">' . number_format($info['number']*$info['price']) . '</div>
                                                    </div>';
                                    }   
                                }
                                ?>

                            </div>
                            
                            <div class="col-sm-5">
                                <h2 class="panel-title">Tổng cộng</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-md-6"><strong>Tiền phòng:</strong></label>
                                    <div class="col-md-6"><?php echo number_format($priceRoom);?></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6"><strong>Tiền HH - DV:</strong></label>
                                    <div class="col-md-6"><?php echo number_format($priceMerchandise);?></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6"><strong>Tiền giảm trừ:</strong></label>
                                    <div class="col-md-6"><?php echo number_format($giam_tru);?></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6"><strong>Tiền trả trước:</strong></label>
                                    <div class="col-md-6"><?php echo number_format($dataRoom['Room']['checkin']['prepay']);?></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6"><strong>Phí thêm người:</strong></label>
                                    <div class="col-md-6"><?php echo number_format($pricePeople);?></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6" style="color: blue; font-size: 14px;"><strong>Phải thanh toán:</strong></label>
                                    <div class="col-md-6"><?php echo number_format($pricePay).' VNĐ';?></div>
                                </div>
                            </div>     
                        </div>
                        <br/>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label class="col-sm-2">Ghi chú:</label>
                                <div class="col-sm-10"><?php echo nl2br($dataRoom['Room']['checkin']['note']);?></div>
                            </div>
                        </div>
                    </div>
                    
                </section>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="<?php echo $urlHomes.'managerHotelDiagram';?>">
                                    <input type="button" value="Hủy" class="btn btn-default" />
                                </a>
                        </div>
                    </div>
                </footer>
            </form>
        </div>
    </div>
    <!-- end: page -->
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>