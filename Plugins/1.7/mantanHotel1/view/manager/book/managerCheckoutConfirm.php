<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thanh toán trả phòng</h2>

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
                <li><span>Trả phòng</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            <form id="summary-form" method="post" action="<?php echo $urlHomes . 'managerCheckoutProcess'; ?>" class="form-horizontal">
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
                                    <label class="col-md-4">Email người giới thiệu:</label>
                                    <div class="col-md-8">
                                        <label><strong><?php echo @$dataRoom['Room']['checkin']['agency']; ?></strong></label>
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
                                    <div class="col-sm-7"> <?php echo number_format($priceRoom); ?></div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-sm-6">
                                <h2 class="panel-title">Tiền dịch vụ</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-md-4"><b>Hàng hóa - Dịch vụ</b></label>
                                    <div class="col-md-4"><b>Số lượng</b></div>
                                    <div class="col-md-4"><b>Giá bán</b></div>
                                </div>
                                <?php
                                if (!empty($dataRoom['Room']['checkin']['hang_hoa'])) {
                                    foreach ($dataRoom['Room']['checkin']['hang_hoa'] as $hang_hoa => $info) {
                                        echo '  <div class="form-group">
                                                        <label class="col-md-4">' . $info['name'] . '</label>
                                                        <div class="col-md-4">' . $info['number'] . '</div>
                                                        <div class="col-md-4">' . number_format($info['price']) . '</div>
                                                    </div>';
                                    }
                                }
                                ?>

                            </div>
                            <div class="col-sm-6">
                                <h2 class="panel-title">Phụ thu</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-md-4">Giảm trừ:</label>
                                    <div class="col-md-8"><?php echo number_format($giam_tru); ?></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4">Trả trước:</label>
                                    <div class="col-md-8"><?php echo number_format($prepay); ?></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4">Phí ở thêm người:</label>
                                    <div class="col-md-8"><?php echo number_format($pricePeople); ?></div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <?php
                            if(!empty($dataRoom['Room']['changePriceRoom'])){ 
                                foreach ($dataRoom['Room']['changePriceRoom'] as $changePriceRoom) { 
                                    $pricePay += $changePriceRoom['infoPay']['pricePay'];

                                    $_SESSION['infoCheckout']['giam_tru'] += $changePriceRoom['infoPay']['giam_tru'];
                                    $_SESSION['infoCheckout']['prepay'] += $changePriceRoom['infoPay']['prepay'];
                                    $_SESSION['infoCheckout']['priceMerchandise'] += $changePriceRoom['infoPay']['priceMerchandise'];
                                    $_SESSION['infoCheckout']['pricePay'] += $changePriceRoom['infoPay']['pricePay'];
                                    $_SESSION['infoCheckout']['pricePeople'] += $changePriceRoom['infoPay']['pricePeople'];
                                    $_SESSION['infoCheckout']['priceRoom'] += $changePriceRoom['infoPay']['priceRoom'];

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
                            <h2 class="panel-title" style="margin-left: 13px;">Tổng cộng</h2>
                            <br/>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <ul>
                                        <li style="float: left;width: 20%;"><b>Tiền phòng:</b> <?php echo number_format($priceRoom); ?></li>
                                        <li style="float: left;width: 20%;"><b>Tiền HH - DV:</b> <?php echo number_format($priceMerchandise); ?></li>
                                        <li style="float: left;width: 20%;"><b>Tiền giảm trừ:</b> <?php echo number_format($giam_tru); ?></li>
                                        <li style="float: left;width: 20%;"><b>Tiền trả trước:</b> <?php echo number_format($prepay); ?></li>
                                        <li style="float: left;width: 20%;"><b>Phí thêm người:</b> <?php echo number_format($pricePeople); ?></li>
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
                                <button class="btn btn-primary">Trả phòng</button>
                                <?php
                                    if(empty($dataRoom['Room']['changePriceRoom'])){ 
                                        echo '<button class="btn btn-primary" type="button" onclick="changRoom();" style="background-color: red;border-color:red;">Chuyển hóa đơn</button>';
                                    }
                                ?>
                                <a href="<?php echo $urlHomes . 'managerHotelDiagram' ?>" class="btn btn-default">Hủy</a>
                            </div>
                        </div>
                    </footer>
                </section>
            </form>
        </div>
    </div>
    <!-- end: page -->
    <style>
        #dialog{
            background-color: #fff;
            padding: 10px;
            z-index: 9999999999;
            position: fixed;
            top: 50%;
            left: 50%;
            display: none;
            /* bring your own prefixes */
            transform: translate(-50%, -50%);
        }
        #my_popup_wrapper{
            opacity: 0.8; 
            visibility: visible; 
            position: fixed; 
            overflow: auto; 
            z-index: 100001; 
            width: 100%; 
            height: 100%; 
            top: 0px; 
            left: 0px; 
            text-align: center; 
            display: none;
            background-color: #000;
        }
    </style>

    <script type="text/javascript">

        function changRoom(value)
        {
            $("#my_popup_wrapper").show();
            $("#dialog").show();

        }
        function closePopup()
        {
            $("#my_popup_wrapper").hide();
            $("#dialog").hide();
        }
    </script>

    <div id="my_popup_wrapper"></div>
    <div id="dialog">
        <form action="<?php echo $urlHomes.'changePriceRoom';?>" method="post">
            <input type="hidden" value="<?php echo $dataRoom['Room']['id'];?>" name="idRoomFrom" />
            Chọn phòng tính tiền
            <select name="idRoomTo">
                <?php
                foreach ($listFloor as $floor) {
                    echo '<option value="0" disabled style="">' . $floor['Floor']['name'] . '</option>';
                    foreach ($listRooms[$floor['Floor']['id']] as $infoRoom) {
                        if (!empty($infoRoom['Room']['checkin']) && $infoRoom['Room']['id']!=$dataRoom['Room']['id']) {
                            echo '<option value="' . $infoRoom['Room']['id'] . '">|--' . $infoRoom['Room']['name'] . '</option>';
                        }
                    }
                }
                ?>
            </select>

            <p>
                <button type="button" onclick="closePopup()" >Đóng</button>
                <button type="submit" >Chuyển</button>
            </p>
        </form>
    </div>
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>