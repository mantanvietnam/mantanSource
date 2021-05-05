
<?php include('header_nav.php');?>


<div class="container title-page">
    <a onclick="" href="/account" class="back">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
    </a>
    <p>Thông tin tài khoản đại lý</p>
</div>

<div class="container page-content">
    <div class="col-xs-12 col-sm-12 agency-detail">
        <div class="letter-content input_border_b">
            <form action="" method="post">
                <div class="form-group">
                    <label class="control-label" for="">Tên đại lý<span class="required">*</span>: </label>
                    <input name="fullName" required="required" class="form-control" id="" maxlength="255" type="text" value="<?php echo @$data['Agency']['fullName'];?>">
                </div>

                <div class="form-group">
                    <label class="control-label" for="email">Email<span class="required">*</span>: </label>
                    <input name="email" required="required" class="form-control" id="email" maxlength="255" type="email" value="<?php echo @$data['Agency']['email'];?>">
                </div>

                <div class="form-group">
                    <label class="control-label" for="">Số chứng minh nhân dân: </label>
                    <input name="cmnd" class="form-control" id="" maxlength="255" type="text" value="<?php echo @$data['Agency']['cmnd'];?>">
                </div>

                <div class="form-group">
                    <label class="control-label" for="">Ảnh chứng minh thư nhân dân:</label>
                    <br/>
                    <?php                    
                    showUploadFile('imageCmnd','imageCmnd',@$data['Agency']['imageCmnd'],0);
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    if(!empty($data['Agency']['imageCmnd'])){
                        echo '<label>Hình ảnh CMTND/Căn cước</label><img src="'.$data['Agency']['imageCmnd'].'" class="img-responsive" style="margin:0; max-width: 100px;" alt="">';
                    }
                    ?>
                </div>

                <div class="form-group">
                    <label class="control-label" for="">Ảnh chân dung:</label>
                    <br/>
                    <?php                    
                    showUploadFile('avatar','avatar',@$data['Agency']['avatar'],1);
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    if(!empty($data['Agency']['avatar'])){
                        echo '<label>Hình ảnh chân dung</label><img src="'.$data['Agency']['avatar'].'" class="img-responsive" style="margin:0; max-width: 100px;" alt="">';
                    }
                    ?>
                </div>

                <div class="form-group">
                    <label class="control-label" for="">Tỉnh thành phố:</label>
                    <select class="form-control" name="idCity">
                        <option>Chọn tỉnh thành phố</option>
                        <?php
                        foreach($listCity as $city){
                            if(empty($data['Agency']['idCity']) || $data['Agency']['idCity']!=$city['id']){
                                echo '<option value="'.$city['id'].'">'.$city['name'].'</option>';
                            }else{
                                echo '<option selected value="'.$city['id'].'">'.$city['name'].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label" for="user_address">Địa chỉ:</label>
                    <input name="address" class="form-control" id="user_address" maxlength="" type="text" value="<?php echo @$data['Agency']['address'];?>">
                </div>

                <div class="form-group">
                    <label class="control-label" for="">Mô tả:</label>
                    <textarea class="form-control" name="note"><?php echo @$data['Agency']['note'];?></textarea>
                </div>
                <div class="form-group">
                    <label class="control-label" for="">Mã đại lý:</label>
                    <input name="code" class="form-control" id="" maxlength="255" type="text" disabled="" value="<?php echo @$data['Agency']['code'];?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="user_mobile">Điện thoại: </label>
                    <input name="phone" disabled="" class="form-control" id="user_mobile" maxlength="200" type="text" value="<?php echo @$data['Agency']['phone'];?>">
                </div>
                <div class="form-group capDL_NC">
                    <div class="capDL">
                        <label class="control-label" for="">Cấp đại lý:</label>
                        <input name="code" class="form-control" id="" maxlength="255" type="text" disabled="" value="<?php echo @$listAgency[$data['Agency']['level']]['name'];?>">
                    </div>
                    <div class="btnNC">
                        <?php
                            $updateLevel= array();
                            $listConfigAgency= getListAgency();
                            $totalMoney= @$data['Agency']['wallet']['deposit']+@$data['Agency']['wallet']['purchaseFund']+$data['Agency']['wallet']['active']-@$data['Agency']['wallet']['penalties'];

                            foreach($listConfigAgency as $config){
                                if($config['id']<$data['Agency']['level'] && $totalMoney>=($config['money_product']+$config['money_deposit']) ){
                                    $updateLevel[]= $config; 
                                }
                            }

                            if(!empty($updateLevel)){
                                echo '<a href="javascript:void(0);" class="nangCap" data-toggle="modal" data-target="#nangCap">Nâng cấp</a>';
                            }
                        ?>
                    <!-- </div>
                </div> -->
                     </div>

                </div>
                <div class="form-group">
                    <label class="control-label" for="">Ngày tham gia:</label>
                    <input type="text" maxlength="50" disabled="" class="form-control input_date1" placeholder="" name="dateStart" value="<?php echo @$data['Agency']['dateStart']['text'];?>">
                </div>

                <div class="form-group">
                    <label class="control-label" for="">Mã đại lý cấp cha:</label>
                    <input name="codeAgencyFather" disabled="" class="form-control" id="" maxlength="" type="text" value="<?php echo @$data['Agency']['codeAgencyFather'];?>">
                </div>

                <div class="form-group">
                    <label class="control-label" for="">Mã đại lý giới thiệu:</label>
                    <input name="codeAgencyIntroduce" disabled="" class="form-control" id="" maxlength="" type="text" value="<?php echo @$data['Agency']['codeAgencyIntroduce'];?>">

                </div>
                <div class="letter-footer">
                    <button type="submit" data-loading-text="Loading..." class="btn btn-gavi width-100" autocomplete="off">
                      <i class="fa fa-paper-plane" aria-hidden="true"></i> Lưu
                  </button>
              </div>
          </form>
      </div>

  </div>
</div>


<?php if(!empty($mess)){ ?>
    <div id="showM" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Thông báo</h4>
        </div>
        <div class="modal-body">
            <div class="showMess"><?php echo $mess; ?></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        </div>
    </div>

</div>
</div>
<?php }?>
<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>

<link rel='stylesheet prefetch' href='/app/Plugin/gavi/view/agency/css/jquery-ui.css'>
<script src='/app/Plugin/gavi/view/agency/js/jquery-ui.min.js'></script>
<link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css'>
<script src='//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
<script type="text/javascript">
    $(".input_date1").datepicker({
        minDate: 0,
        maxDate: "",
        numberOfMonths: 1
    });
    jQuery(function($){
        $.datepicker.regional['vi'] = {
            closeText: 'Đóng',
            prevText: '<Trước',
            nextText: 'Tiếp>',
            currentText: 'Hôm nay',
            monthNames: ['Tháng Một', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu',
            'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười Hai'],
            monthNamesShort: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
            'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            dayNames: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
            dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            weekHeader: 'Tu',
            dateFormat: 'dd/mm/yy',
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''};
            $.datepicker.setDefaults($.datepicker.regional['vi']);
        });
    </script>

<?php
    if(!empty($updateLevel)){
        echo '  <div class="modal" id="nangCap">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Nâng cấp</h4>
        </div>
        <div class="modal-body">
        <form action="/saveRequestLevel" method="post" accept-charset="utf-8">
        <div class="form-group">
        <label>Bạn chọn cấp độ: </label>
        <select name="levelNew" class="form-control" required="">
        <option value="">--Chọn cấp--</option>';
        foreach($updateLevel as $update){
            echo '<option value="'.$update['id'].'">'.$update['name'].'</option>';
        }
        echo                    '</select>
        </div>
        <div class="form-group">
        <input type="submit" value="Gửi" class="btn-gavi" style="padding: 5px 30px; outline: none; border:none;" name="">
        </div>
        </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default setfocus" data-dismiss="modal">Đóng</button>
        </div>

        </div>
        </div>

        </div>';

    }
?>
</body>
</html>
