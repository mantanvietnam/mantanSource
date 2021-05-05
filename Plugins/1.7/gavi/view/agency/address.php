<!-- <!DOCTYPE html>
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
-->


<?php include('header_nav.php');?>
<div class="container title-page">
        <a onclick="" href="/account" class="back">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <p>Cài đặt địa chỉ giao hàng</p>
    </div>

    <div class="container page-content">
        <div class="col-xs-12 col-sm-12 agency-detail">
            <div class="letter-content input_border_b">
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
                <label class="control-label" for="">Địa chỉ giao hàng số 1: </label>
                <input name="addressName[1]" placeholder="Họ tên" class="form-control" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['addressTo'][1]['name'];?>" >
                <input name="addressPhone[1]" placeholder="Số điện thoại" class="form-control" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['addressTo'][1]['phone'];?>">
                <input name="addressAdd[1]" placeholder="Địa chỉ" class="form-control" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['addressTo'][1]['address'];?>">
            </div>
            <div class="form-group">
                <label class="control-label" for="">Địa chỉ giao hàng số 2: </label>
                <input name="addressName[2]" placeholder="Họ tên" class="form-control" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['addressTo'][2]['name'];?>">
                <input name="addressPhone[2]" placeholder="Số điện thoại" class="form-control" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['addressTo'][2]['phone'];?>">
                <input name="addressAdd[2]" placeholder="Địa chỉ" class="form-control" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['addressTo'][2]['address'];?>">
            </div>
            <div class="form-group">
                <label class="control-label" for="">Địa chỉ giao hàng số 3: </label>
                <input name="addressName[3]" placeholder="Họ tên" class="form-control" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['addressTo'][3]['name'];?>">
                <input name="addressPhone[3]" placeholder="Số điện thoại" class="form-control" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['addressTo'][3]['phone'];?>">
                <input name="addressAdd[3]" placeholder="Địa chỉ" class="form-control" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['addressTo'][3]['address'];?>">
            </div>
            <div class="form-group">
                <label class="control-label" for="">Địa chỉ giao hàng số 4: </label>
                <input name="addressName[4]" placeholder="Họ tên" class="form-control" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['addressTo'][4]['name'];?>">
                <input name="addressPhone[4]" placeholder="Số điện thoại" class="form-control" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['addressTo'][4]['phone'];?>">
                <input name="addressAdd[4]" placeholder="Địa chỉ" class="form-control" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['addressTo'][4]['address'];?>">
            </div>
            <div class="form-group">
                <label class="control-label" for="">Địa chỉ giao hàng số 5: </label>
                <input name="addressName[5]" placeholder="Họ tên" class="form-control" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['addressTo'][5]['name'];?>">
                <input name="addressPhone[5]" placeholder="Số điện thoại" class="form-control" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['addressTo'][5]['phone'];?>">
                <input name="addressAdd[5]" placeholder="Địa chỉ" class="form-control" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['addressTo'][5]['address'];?>">
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

</body>
</html>
