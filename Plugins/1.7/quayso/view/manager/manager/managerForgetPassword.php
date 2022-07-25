<!doctype html>
<html class="fixed">
    <head>
        <title>Quên mật khẩu</title>
        <!-- Basic -->
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="/app/Plugin/quayso/view/manager/img/logoQuaySo.png" type="image/x-icon">
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- Web Fonts  -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/bootstrap.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/font-awesome.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/magnific-popup.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/datepicker3.css" />

        <!-- Theme CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/theme.css" />

        <!-- Skin CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/default.css" />

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/theme-custom.css">

        <!-- Head Libs -->
        <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/mOrdernizr.js"></script>

    </head>
    <body>
        <!-- start: page -->
        <section class="body-sign">
            <div class="center-sign">
                <div class="panel panel-sign">
                    <div class="panel-title-sign mt-xl text-right">
                        <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Quên mật khẩu</h2>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <?php if(!empty($mess)) echo $mess;?>
							<div class="form-group mb-lg">
                                <label>Nhập số điện thoại của bạn:</label>
                                <div class="input-group input-group-icon">
                                    <input name="phone" type="text" class="form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 ">
                                   <a href="/login">Đăng nhập</a>
                                </div>
                                <div class="col-sm-8 text-right">
                                    <button type="submit" class="btn btn-primary hidden-xs">Gửi</button>
                                    <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Gửi</button>
                                </div>
                            </div>
                            <br/>
                        </form>
                    </div>
                </div>

                <p class="text-center text-muted mt-md mb-md">TOP TOP DIGIRAL SOLUTION © Copyright 2022</p>
            </div>
        </section>
        <!-- end: page -->

        <!-- Vendor -->
        <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.browser.mobile.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/bootstrap.js"></script>
        <!-- <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/nanoscroller.js"></script> -->
        <!-- <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/bootstrap-datepicker.js"></script> -->
        <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/magnific-popup.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.placeholder.js"></script>

        <!-- Theme Base, Components and Settings -->
        <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/theme.js"></script>

        <!-- Theme Custom -->
        <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/theme.custom.js"></script>

        <!-- Theme Initialization Files -->
        <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/theme.init.js"></script>

    </body>
</html>