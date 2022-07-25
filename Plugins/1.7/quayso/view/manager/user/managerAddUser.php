<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/header.php'; ?>

<section role="main" class="content-body" id="fullscreen">

<!-- start: page -->

<section class="panel">
    <ul class="title_p list-inline">
        <li><a href="/campaign"><i class="fa fa-home"></i> Chiến dịch</a></li>
        <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
        <li>Thêm người tham gia</li>
    </ul>
    
    <div class="panel-body"> 
        <form id="" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Chiến dịch <span class="required">*</span>:</label>
                <div class="col-sm-9">
                    <select name="campaign" class="form-control" required>
                        <option value="">Chọn chiến dịch</option>
                        <?php
                        if (!empty($listAllCampaignManager)) {
                            foreach ($listAllCampaignManager as $item) {
                                if(empty($_SESSION['idCampaignView']) || $_SESSION['idCampaignView']!=$item['Campaign']['id']){
                                    echo '<option value="'.$item['Campaign']['id'].'">'.$item['Campaign']['name'].'</option>';
                                }else{
                                    echo '<option selected value="'.$item['Campaign']['id'].'">'.$item['Campaign']['name'].'</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Họ tên <span class="required">*</span>:</label>
                <div class="col-sm-9">
                    <input type="text" name="fullName" value="" class="form-control" required>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Số điện thoại <span class="required">*</span>:</label>
                <div class="col-sm-9">
                    <input type="text" name="phone" value="" class="form-control" required>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Email:</label>
                <div class="col-sm-9">
                    <input type="text" name="email" value="" class="form-control">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Công việc:</label>
                <div class="col-sm-9">
                    <input type="text" name="job" value="" class="form-control">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="col-sm-3 control-label">Ghi chú:</label>
                <div class="col-sm-9">
                    <textarea name="note" class="form-control"></textarea>
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