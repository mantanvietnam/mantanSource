<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Đăng nhập hệ thống Gavi</title>

    <link href="/app/Plugin/gavi/view/agency/css/bootstrap.min.css" rel="stylesheet">
    <link href="/app/Plugin/gavi/view/agency/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="/app/Plugin/gavi/view/agency/css/mystyle.css" rel="stylesheet">
</head>
<body>
    <div class="container auth-content">
        <div class="login">
        	<h1 class="logo"><a href=""><img src="/app/Plugin/gavi/view/agency/img/logo.png"></a></h1>
        	<?php
        		// if(!empty($mess)){
        		// 	echo '<center style="color: red;">'.$mess.'</center>';
        		// }
        	?>

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
    <form action="" method="post">
        <div class="form-group">
           <label for="exampleInputEmail1">Số điện thoại đại lý</label>
           <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nhập số điện thoại đại lý" name="phone" value="<?php echo @$_GET['phone'];?>">
       </div>
       <div class="form-group">
           <label for="exampleInputPassword1">Mật khẩu</label>
           <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Nhập mật khẩu" name="pass">
       </div>

       <div class="checkbox">
           <label>
              <input type="checkbox"> Lưu mật khẩu
          </label>
      </div>
      <button type="submit" class="btn btn-gavi btn-auth-submit">Đăng nhập</button>
  </form>
  <div class="forgot-password">
    <a href="/forgetPassAgency">Quên mật khẩu ?</a>
</div>
</div>
</div>

<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>
<script>
    $("#showM").on('shown.bs.modal', function(){
        $(this).find('button').focus();
    });

    $(window).on('load',function(){
        $('#showM').modal('show');
    });
</script>
<style>
@media (min-width: 768px){
    .modal-dialog {
        width: 400px;
        margin: 30px auto;
    }
}
.modal.fade .modal-dialog 
{
    -moz-transition: none !important;
    -o-transition: none !important;
    -webkit-transition: none !important;
    transition: none !important;

    -moz-transform: none !important;
    -ms-transform: none !important;
    -o-transform: none !important;
    -webkit-transform: none !important;
    transform: none !important;
}

</style>
</body>
</html>
