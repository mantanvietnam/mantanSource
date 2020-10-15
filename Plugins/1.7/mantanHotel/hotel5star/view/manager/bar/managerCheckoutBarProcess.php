<!DOCTYPE html>
<html>
    <head>
        <title>Phiếu thanh toán Bar</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/bootstrap-theme.min.css"/>     
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/style.css"/>     
        <script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <header class="text-center">
                <h3><?php echo $dataHotel['Hotel']['name'];?></h3>
                <h4>Đ/c: <?php echo $dataHotel['Hotel']['address'];?></h4>
                <h4>ĐT: <?php echo $dataHotel['Hotel']['phone'];?></h4>
            </header>
            <section>
                <div class="text-center">
                    <h2>Phiếu thanh toán</h2>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">Bàn: <?php echo $dataTable['BarTable']['name'];?></div>
                        
                        <div class="col-md-6 col-sm-6 col-xs-6">Thời gian ở: <?php echo $textUse; ?></div>
                        
                        <div class="col-md-6 col-sm-6 col-xs-6">Giờ vào: 
                            <?php
                            $dateCheckin = getdate($dataTable['BarTable']['checkin']['dateCheckin']);
                            echo $dateCheckin['hours'] . ':' . $dateCheckin['minutes'] . ' ngày ' . $dateCheckin['mday'] . '/' . $dateCheckin['mon'] . '/' . $dateCheckin['year'];
                            ?>
                        </div>
                        
                        <div class="col-md-6 col-sm-6 col-xs-6">Giờ ra: 
                            <?php
                            echo $today['hours'] . ':' . $today['minutes'] . ' ngày ' . $today['mday'] . '/' . $today['mon'] . '/' . $today['year'];
                            ?>
                        </div>
                        
                        
                    </div>
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <td><b>Danh mục</b></td>
                                    <td><b>Số lượng</b></td>
                                    <td><b>Giá bán</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($dataTable['BarTable']['checkin']['hang_hoa'])) {
                                    foreach ($dataTable['BarTable']['checkin']['hang_hoa'] as $hang_hoa => $info) {
                                        echo '  <tr>
                                                        <td>' . $info['name'] . '</td>
                                                        <td>' . $info['number'] . '</td>
                                                        <td>' . number_format($info['price']) . '</td>
                                                    </tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">Giảm trừ:</div>
                        <div class="col-md-6 col-sm-6 col-xs-6"><b><?php echo number_format($giam_tru);?></b></div>
                        <div class="col-md-6 col-sm-6 col-xs-6">Tổng cộng:</div>
                        <div class="col-md-6 col-sm-6 col-xs-6"><b><?php echo number_format($pricePay);?></b></div>
                    </div>
                    <p><b>Bằng chữ:</b> <em><?php echo convert_number_to_words($pricePay);?></em></p>
                   
                    <div class="row text-center footer">
                        <div class="col-md-6 col-sm-6 col-xs-6">Nhân viên</div>
                        <div class="col-md-6 col-sm-6 col-xs-6"><?php echo $_SESSION['infoManager']['Manager']['fullname'];?></div>
                    </div>
                </div>
            </section>
        </div>
        
        <script type="text/javascript">
            window.print();
            window.open('<?php echo $urlHomes . 'managerBarDiagram';?>');
        </script>
    </body>
</html>