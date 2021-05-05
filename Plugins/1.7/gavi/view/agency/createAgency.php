<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GAVI Agency Site</title>

    <link href="/app/Plugin/gavi/view/agency/css/bootstrap.min.css" rel="stylesheet">
    <link href="/app/Plugin/gavi/view/agency/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="/app/Plugin/gavi/view/agency/css/mystyle.css" rel="stylesheet">
</head>

<body> 


    <div class="container title-page">
        <a href="/" class="back">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <p>Thông tin tài khoản đại lý</p>
    </div>

    <div class="container page-content">
        <div class="col-xs-12 col-sm-12 agency-detail">
            <div class="letter-content input_border_b">
                <!-- <p style="color: red;"><?php echo $mess;?></p> -->
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
                        <button type="button" class="btn btn-default setfocus" data-dismiss="modal" autofocus>Đóng</button>
                    </div>
                </div>

            </div>
        </div>
        <?php }?>
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
                <label class="control-label" for="">Mật khẩu<span class="required">*</span>: </label>
                <input name="pass" required="required" class="form-control" id="" maxlength="200" type="password" autocomplete="off">
            </div>

            <div class="form-group">
                <label class="control-label" for="">Nhập lại mật khẩu<span class="required">*</span>: </label>
                <input name="passAgain" required="required" class="form-control" id="" maxlength="200" type="password" autocomplete="off">
            </div>

            <div class="form-group">
                <label class="control-label" for="user_mobile">Điện thoại<span class="required">*</span>: </label>
                <input name="phone" required="required" class="form-control" id="user_mobile" maxlength="200" type="text" value="<?php echo @$data['Agency']['phone'];?>">
            </div>

            <div class="form-group">
                <label class="control-label" for="">Chứng minh thư nhân dân<span class="required">*</span>:</label>

                <input name="cmnd" class="form-control" required="required" id="" maxlength="12" type="text" value="<?php echo @$data['Agency']['cmnd'];?>"> 
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

</body>
</html>
