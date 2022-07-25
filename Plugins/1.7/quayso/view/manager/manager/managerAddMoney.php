<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/header.php'; ?>

<section role="main" class="content-body" id="fullscreen">

<!-- start: page -->

<section class="panel">
    <ul class="title_p list-inline">
        <li><a href="/profile"><i class="fa fa-home"></i> Tài khoản</a></li>
        <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
        <li>Thông tin tài khoản</li>
    </ul>
    
    <div class="panel-body"> 
        <div class="row" style="margin-bottom: 1em;">
            <div class="col-md-12">
                <div class="mb-md">
                    <?php if(empty($_SESSION['infoManager']['Manager']['typeBuy']) || $_SESSION['infoManager']['Manager']['typeBuy']!='buyForever'){ ?>
                        <button onclick="$('#modalBuyMonth').modal('show');" type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Mua gói tháng</button>
                        <button onclick="$('#modalBuyForever').modal('show');" type="button" class="btn btn-danger btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Mua vĩnh viễn</button>
                    <?php }?>
                </div>
            </div>
        </div>
        <form id="" action="/addMoney" class="form-horizontal" method="post" enctype="multipart/form-data">
            <?php //echo @$_SESSION['tokenAddMoney'];?>
            <input type="hidden" name="type" value="buyTurn">

            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Gói cước sử dụng:</label>
                <div class="col-sm-9">
                    <?php 
                        if(empty($data['Manager']['typeBuy'])) $data['Manager']['typeBuy'] = 'buyTurn';
                        $typeBuy = '';
                        switch ($data['Manager']['typeBuy']) {
                            case 'buyTurn': $typeBuy = 'Trừ tiền mỗi lần tạo chiến dịch'; break;
                            case 'buyMonth': $deadline= date('d/m/Y', $data['Manager']['deadlineBuy']);$typeBuy = 'Không giới hạn tạo chiến dịch trong 30 ngày (hết ngày '.$deadline.')'; break;
                            case 'buyForever': $typeBuy = 'Không giới hạn tạo chiến dịch vĩnh viễn'; break;
                        }

                        echo '<input type="text" disabled name="typeBuy" value="'.$typeBuy.'" class="form-control">';
                    ?>
                </div>
            </div>

            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Số dư tài khoản:</label>
                <div class="col-sm-9">
                    <input type="text" disabled name="coin" value="<?php echo (int) @$data['Manager']['coin'] ?>" class="form-control input_money">
                </div>
            </div>

            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Số tiền muốn nạp <span class="required">*</span>:</label>
                <div class="col-sm-9">
                    <input type="text" name="numberCoin" value="" class="form-control input_money" value="<?php echo @$_POST['numberCoin']?>">
                    <p>Nạp tối thiểu 50.000đ</p>
                </div>
            </div>

            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Kênh thanh toán <span class="required">*</span>:</label>
                <div class="col-sm-9">
                    <input type="radio" name="typePay" value="bank" checked> Chuyển khoản ngân hàng <br/>
                    <input type="radio" name="typePay" value="momo"> Ví MoMo <br/>
                    <input type="radio" name="typePay" value="nganluong"> Ví Ngân lượng <br/>
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Nạp tiền</button>
                </div>
            </div>
        
        </form>
    </div>
</section>

<!-- end: page -->
</section>

<div id="modalBuyMonth" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Mua gói không giới hạn theo tháng</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="">Bạn mua 30 ngày tạo không giới hạn số lượng các chiến dịch với chi phí là 1.000.000đ</p>
            </div>
            <div class="modal-footer">
              <a class="buttonMM" href="/addMoney/?numberCoin=1000000&type=buyMonth">Đồng ý</a>
            </div>
        </div>
    </div>
</div>

<div id="modalBuyForever" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Mua gói không giới hạn vĩnh viễn</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="">Bạn được phép tạo không giới hạn số lượng các chiến dịch vĩnh viễn với chi phí là 5.000.000đ</p>
            </div>
            <div class="modal-footer">
              <a class="buttonMM" href="/addMoney/?numberCoin=1000000&type=buyForever">Đồng ý</a>
            </div>
        </div>
    </div>
</div>

<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/footer.php'; ?>