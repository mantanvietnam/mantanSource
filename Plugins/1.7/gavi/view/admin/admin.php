<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Đăng nhập admin Gavi</title>

  <!-- Bootstrap -->
  <link href="/app/Plugin/gavi/view/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="/app/Plugin/gavi/view/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <!-- <link href="/app/Plugin/gavi/view/vendors/nprogress/nprogress.css" rel="stylesheet"> -->
  <!-- Animate.css -->
  <link href="/app/Plugin/gavi/view/vendors/animate.css/animate.min.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="/app/Plugin/gavi/view/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form method="post" action="">
            <h1>Gavi Admin</h1>
            <!-- <p style="color: red;"><?php echo $mess;?></p> -->
            
            
            <div>
              <input type="text" class="form-control" placeholder="Tên đăng nhập hoặc số điện thoại" required="" name="code" />
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Mật khẩu" required="" name="pass" />
            </div>
            <div>
              <button type="submit" class="btn btn-default submit">Đăng nhập</button>
              <!-- <a class="reset_pass" href="#">Lost your password?</a> -->
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">
                <a href="/forgetPassStaff" class="to_register"> Quên mật khẩu ? </a>
              </p>

              <div class="clearfix"></div>
              <br />

              <div>
                <!-- <h1><i class="fa fa-paw"></i> Gavi</h1> -->
                <p>©2018 All Rights Reserved. Design by Mantan Viet Nam</p>
              </div>
            </div>
          </form>
        </section>
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
          <button type="button" class="btn btn-default setfocus" data-dismiss="modal" autofocus>Đóng</button>
        </div>
      </div>

    </div>
  </div>
  <?php }?>
  <script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
  <script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
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
