<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Phiếu thu</title>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        
        <style type="text/css">
            #payment_bill {
                font-size: 16px;
                padding: 3em 0;
            }
            #payment_bill h2 {
                margin-top: 3em;
            }
            #payment_bill p {
                margin: 0;
            }
            #payment_bill  p.times {
                display: inline-flex;
                display: -webkit-inline-flex;
            }
            .form-control {
                margin: -5px 5px;
                border: none;
                box-shadow: none;
                border-bottom: 1px dotted;
            }
            .last {
                display: -webkit-inline-box;
                display: -moz-box;
                display: -o-box;
            }
            .content {
                margin-top: 5px;
            }
            .content .form-control {
                margin: 0 5px;
            }
            input {
                border: none;
            }
            .sign {
                margin-top: 1em;
            }
        </style>
    </head>
    <body>
        <div class="container" id="payment_bill">
            <div class="row text-center">
                <div class="col-sm-6">
                    <p><strong>Đơn vị: <?php echo $dataHotel['Hotel']['name'];?></strong></p>
                    <strong><i>Địa chỉ: <?php echo $dataHotel['Hotel']['address'];?></i></strong>
                </div>
                <div class="col-sm-6">
                    <p><strong>Mẫu số 02 - TT</strong></p>
                    <i>(Ban hành theo Thông tư số: 200/2014/TT-BTC ngày 24/12/2014 của BTC)</i>
                </div>
            </div>
            <div class="row text-center">
                <h2 class="text-uppercase">Phiếu thu</h2>
                <p class="times"><?php echo 'Ngày '.$today['mday'] . ' tháng ' . $today['mon'] . ' năm ' . $today['year'];?></p>               
            </div>
            <div class="row text-right">
                <p class="times text-right">Số: ..../<?php echo $today['year'];?></p>
            </div>
            <div class="content">
                <div class="row text-left">
                    <p>
                        <span class="col-sm-3">Người nộp tiền:</span>
                        <span class="col-sm-9"><?php echo @$data['CollectionBill']['nguoi_nop'];?></span>
                    </p>
                </div>
                <div class="row text-left">
                    <p>
                        <span class="col-sm-3">Địa chỉ: </span>
                        <span class="col-sm-9" style="overflow: hidden;height: 30px;">
                            . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . 
                        </span>
                    </p>
                </div>
                <div class="row text-left">
                    <p>
                        <span class="col-sm-3">Lý do thu: </span>
                        <span class="col-sm-9"><?php echo @$data['CollectionBill']['note'];?></span>
                    </p>
                </div>
                <div class="row text-left">
                    <p>
                        <span class="col-sm-3">Số tiền: </span>
                        <span class="col-sm-9"><?php echo number_format(@$data['CollectionBill']['coin']);?>đ (<?php echo convert_number_to_words($data['CollectionBill']['coin']);?>)</span>
                    </p>
                </div>
                <div class="row text-left">
                    <p>
                        <span class="col-sm-6" style="overflow: hidden; height: 30px;">
                            Kèm theo: . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . 
                        </span>
                        <span class="col-sm-6" style="overflow: hidden; height: 30px;">
                            Chứng từ gốc . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . 
                        </span>
                    </p>
                </div>
            </div>
            <div class="sign">
                <div class="row">
                    <div class="col-sm-3 text-center">
                        <p><strong>Giám đốc</strong></p>
                        <p><i>(Ký, họ tên)</i></p>
                        <br/>
                        <br/>
                        <br/>
                    </div>
                    <div class="col-sm-3 text-center">
                        <p><strong>Kế toán trưởng</strong></p>
                        <p><i>(Ký, họ tên)</i></p>
                        <br/>
                        <br/>
                        <br/>
                    </div>
                    <div class="col-sm-3 text-center">
                        <p><strong>Thủ quỹ</strong></p>
                        <p><i>(Ký, họ tên)</i></p>
                        <br/>
                        <br/>
                        <br/>
                    </div>
                    <div class="col-sm-3 text-center">
                        <p><strong>Người nộp tiền</strong></p>
                        <p><i>(Ký, họ tên)</i></p>
                        <br/>
                        <br/>
                        <br/>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
</html>