<!doctype html>
<html class="fixed">
    <head>
        <title>Đăng nhập hệ thống</title>
        <!-- Basic -->
        <meta charset="UTF-8">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- Web Fonts  -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/bootstrap.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/font-awesome.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/magnific-popup.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/datepicker3.css" />

        <!-- Theme CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/theme.css" />

        <!-- Skin CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/default.css" />

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/css/theme-custom.css">

        <!-- Head Libs -->
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/mOrdernizr.js"></script>

    </head>
    <body>
        <!-- start: page -->
        <section class="body-sign">
            <div class="center-sign">
                <a href="/" class="logo pull-left">
                    <img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/logo.png" height="120" style="margin-top: -45px;" alt="Hotel Admin" />
                </a>

                <div class="panel panel-sign">
                    <div class="panel-title-sign mt-xl text-right">
                        <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Đăng nhập</h2>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <?php
                            if (isset($_GET['status']))
                                switch ($_GET['status']) {
                                    case -1: echo '<p style="color:red;">Sai thông tin đăng nhập</p>';
                                        break;
                                    case -2: echo '<p style="color:red;">Tài khoản đang tạm khóa</p>';
                                        break;
                                    case -3: echo '<p style="color:red;">Tài khoản hết hạn hợp đồng</p>';
                                        break;
                                }
                            ?>
							<div class="form-group mb-lg">
                                <label>Username</label>
                                <div class="input-group input-group-icon">
                                    <input name="user" type="text" class="form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group mb-lg">
                                <label class="pull-left">Password</label>
                                <div class="input-group input-group-icon">
                                    <input name="password" type="password" class="form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                    </span>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-sm-4 ">
                                    <div class=" text-left">                                    
                                        <a href="/managerForgetPassword" class="pull-right">Quên mật khẩu?</a>
                                    </div>
                                </div>
                                <div class="col-sm-8 text-right">
                                    <button type="submit" class="btn btn-primary hidden-xs">Đăng nhập</button>
                                    <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Đăng nhập</button>
                                </div>
                            </div>
                            <br/>
                            <!--	<span class="mt-lg mb-lg line-thru text-center text-uppercase">
                                        <span>or</span>
                                </span>

                                <div class="mb-xs text-center">
                                        <a class="btn btn-facebook mb-md ml-xs mr-xs">Connect with <i class="fa fa-facebook"></i></a>
                                        <a class="btn btn-twitter mb-md ml-xs mr-xs">Connect with <i class="fa fa-twitter"></i></a>
                                </div> -->

                            <!--<p class="text-center">Chưa có tài khoản? <a href="pages-signup.html">Đăng ký ngay!</a>-->

                        </form>
                    </div>
                </div>

                <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2015. All Rights Reserved.</p>
            </div>
        </section>
        <!-- end: page -->

        <!-- Vendor -->
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/jquery.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/jquery.browser.mobile.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/bootstrap.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/nanoscroller.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/bootstrap-datepicker.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/magnific-popup.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/jquery.placeholder.js"></script>

        <!-- Theme Base, Components and Settings -->
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/theme.js"></script>

        <!-- Theme Custom -->
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/theme.custom.js"></script>

        <!-- Theme Initialization Files -->
        <script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/theme.init.js"></script>

    </body>
</html>