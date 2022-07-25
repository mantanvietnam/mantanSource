<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/header.php'; ?>

<link rel="stylesheet" href="/app/Plugin/quayso/view/manager/css/pick-a-color-1.2.3.min.css">   
<script src="/app/Plugin/quayso/view/manager/js/tinycolor-0.9.15.min.js"></script>
<script src="/app/Plugin/quayso/view/manager/js/pick-a-color-1.2.3.min.js"></script>    

<section role="main" class="content-body" id="fullscreen">

<!-- start: page -->

<section class="panel">
    <ul class="title_p list-inline">
        <li><a href="/campaign"><i class="fa fa-home"></i> Chiến dịch</a></li>
        <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
        <li>Thông tin chiến dịch</li>
    </ul>
    
    <div class="panel-body"> 
        <?php 
        if(empty($_SESSION['infoManager']['Manager']['typeBuy'])){
            $_SESSION['infoManager']['Manager']['typeBuy']= 'buyTurn';
        }

        if( ($_SESSION['infoManager']['Manager']['typeBuy']=='' || $_SESSION['infoManager']['Manager']['typeBuy']=='buyTurn' ) && $numberCampaign<5){
            $number = 5 - $numberCampaign;
            echo '<p style="color: red;" class="text-center">Bạn còn '.$number.' chiến dịch miễn phí</p>';
        }
        ?>
        <form id="" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Tên chiến dịch <span class="required">*</span>:</label>
                <div class="col-sm-9">
                    <input name="name" class="form-control" placeholder="" required="" value="<?php echo @$data['Campaign']['name'];?>">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Mã bảo mật quay thưởng:</label>
                <div class="col-sm-9">
                    <input name="codeSecurity" class="form-control" placeholder="" value="<?php echo @$data['Campaign']['codeSecurity'];?>">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Người trúng thưởng là:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="typeUserWin">
                        <option value="">Người đăng ký tham gia</option>
                        <option value="checkin" <?php if(!empty($data['Campaign']['typeUserWin']) && $data['Campaign']['typeUserWin']=='checkin') echo 'selected';?> >Người đăng ký tham gia & đã checkin tại sự kiện</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Ảnh nền chiến dịch:</label>
                <div class="col-sm-9">
                    <input name="image" type="file" class="form-control" placeholder="">
                    <?php 
                    if(!empty($data['Campaign']['image'])){
                        echo '<br/><p><image src="'.$data['Campaign']['image'].'" width="100" /></p>';
                    }
                    ?>
                    <p>File ảnh dung lượng dưới 1Mb, định dạng ảnh jpg, png, gif</p>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Ảnh logo chiến dịch:</label>
                <div class="col-sm-9">
                    <input name="logo" type="file" class="form-control" placeholder="">
                    <?php 
                    if(!empty($data['Campaign']['logo'])){
                        echo '<br/><p><image src="'.$data['Campaign']['logo'].'" width="100" /></p>';
                    }
                    ?>
                    <p>File ảnh dung lượng dưới 1Mb, định dạng ảnh jpg, png, gif</p>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Màu chữ:</label>
                <div class="col-sm-9">
                    <input name="colorText" value="<?php echo @$data['Campaign']['colorText'];?>" type="text" class="form-control pick-a-color" placeholder="">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Mô tả:</label>
                <div class="col-sm-9">
                    <textarea name="note" maxlength="3000" rows="5" class="form-control" placeholder=""><?php echo @$data['Campaign']['note'];?></textarea>
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

<script type="text/javascript">
    
$(document).ready(function () {

    $(".pick-a-color").pickAColor({
        showSpectrum            : true,
        showSavedColors         : true,
        saveColorsPerElement    : true,
        fadeMenuToggle          : true,
        showAdvanced            : true,
        showBasicColors         : true,
        showHexInput            : true,
        allowBlank              : true,
        inlineDropdown          : true
    });
    
});

</script>

<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/footer.php'; ?>