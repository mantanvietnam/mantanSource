<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/header.php'; ?>

<section role="main" class="content-body" id="fullscreen">

<!-- start: page -->

<section class="panel">
    <ul class="title_p list-inline">
        <li><a href="/profile"><i class="fa fa-home"></i> Tài khoản</a></li>
        <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
        <li>Đổi mật khẩu</li>
    </ul>
    
    <div class="panel-body"> 
        <form id="" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Mật khẩu cũ <span class="required">*</span>:</label>
                <div class="col-sm-9">
                    <input type="password" name="passOld" value="" autocomplete="off" class="form-control" id="">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Mật khẩu mới <span class="required">*</span>:</label>
                <div class="col-sm-9">
                    <input type="password" name="passNew" value="" autocomplete="off" class="form-control" id="">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Nhập lại mật khẩu mới <span class="required">*</span>:</label>
                <div class="col-sm-9">
                    <input type="password" name="passAgain" value="" autocomplete="off" class="form-control" id="">
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