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
        <form id="" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Họ tên <span class="required">*</span>:</label>
                <div class="col-sm-9">
                    <input type="text" name="fullname" value="<?php echo $data['Manager']['fullname'] ?>" class="form-control">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Số điện thoại <span class="required">*</span>:</label>
                <div class="col-sm-9">
                    <input type="text" disabled name="phone" value="<?php echo $data['Manager']['phone'] ?>" class="form-control">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Email <span class="required">*</span>:</label>
                <div class="col-sm-9">
                    <input type="text" name="email" value="<?php echo $data['Manager']['email'] ?>" class="form-control">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Số dư tài khoản <span class="required">*</span>:</label>
                <div class="col-sm-9">
                    <input type="text" disabled name="coin" value="<?php echo (int) @$data['Manager']['coin'] ?>" class="form-control">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Gói dịch vụ:</label>
                <div class="col-sm-9">
                    <?php 
                        if(empty($data['Manager']['typeBuy'])) $data['Manager']['typeBuy'] = 'buyTurn';
                        $typeBuy = '';
                        switch ($data['Manager']['typeBuy']) {
                            case 'buyTurn': $typeBuy = 'Thanh toán theo từng lần tạo chiến dịch';break;
                            case 'buyMonth': $typeBuy = 'Không giới hạn tạo chiến dịch đến hết ngày '.date('d/m/Y', $data['Manager']['deadlineBuy']);break;
                            case 'buyForever': $typeBuy = 'Không giới hạn tạo chiến dịch vĩnh viễn';break;
                        }
                    ?>
                    <input type="text" disabled name="typeBuy" value="<?php echo $typeBuy;?>" class="form-control">
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                </div>
            </div>
        
        </form>
    </div>
</section>

<!-- end: page -->
</section>

<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/footer.php'; ?>