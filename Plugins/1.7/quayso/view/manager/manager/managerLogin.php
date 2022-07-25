<!doctype html>
<html class="fixed">

<head>
	<title>Đăng nhập hệ thống</title>
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
    <link href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/menu.css " rel="stylesheet"/>
	
	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/css/theme-custom.css">

	<!-- Head Libs -->
	<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/modernizr.js"></script>

	<meta name="description" content="Đăng nhập hệ thống phần mềm quản lý quay số trúng thưởng" />
	<meta name="keywords" content="phần mềm quay số trúng thưởng" />  
	<meta property="og:title" content="Đăng nhập hệ thống phần mềm quản lý quay số trúng thưởng"/>
	<meta property="og:type" content="website"/>
	<meta property="og:description" content="Đăng nhập hệ thống phần mềm quản lý quay số trúng thưởng"/>
	<meta property="og:url" content="<?php echo $urlHomes;?>"/>
	<meta property="og:site_name" content="Đăng nhập hệ thống phần mềm quản lý quay số trúng thưởng"/>
	<meta property="og:image" content="https://quayso.xyz/app/Plugin/quayso/view/manager/img/QuaySoXSpin.png" />
	<meta property="fb:admins" content="" />
	<meta property="fb:app_id" content="1695746487308818" /> 
	<meta property="og:image:width" content="900" />
	<meta property="og:image:height" content="603" />
</head>
<body>
	<style type="text/css" media="screen">
	.center-sign h3{
		color: #00A1E2;
		text-transform: uppercase;
		text-align: center;
		margin-bottom: 50px;
		text-shadow: 0 1px 0 rgba(255, 255, 255, 0.4);
		text-shadow: 
		1px 0px 1px #ccc, 0px 1px 1px #eee, 
		2px 1px 1px #ccc, 1px 2px 1px #eee,
		3px 2px 1px #ccc, 2px 3px 1px #eee,
		4px 3px 1px #ccc, 3px 4px 1px #eee,
		5px 4px 1px #ccc, 4px 5px 1px #eee,
		6px 5px 1px #ccc, 5px 6px 1px #eee,
		7px 6px 1px #ccc;
	}
	.body-sign .panel-sign{
		position: relative;
	}
	.logo_viettel {
		position: absolute;
		width: 150px;
	}
	@media screen and (max-width: 768px){

		.body-sign {
			height: 70vh;
			max-width: 600px;
		}
	}
	@media screen and (max-width: 600px){

		.body-sign {
			height: 100vh;
			max-width: 500px;
		}
	}
</style>
<!-- start: page -->
<section class="body-sign">
	<div class="center-sign">
		<h3 class="text-center">QUAY SỐ TRÚNG THƯỞNG</h3>
		<div class="panel panel-sign">
			<div class="logo_viettel">
				<img src="/app/Plugin/quayso/view/manager/img/logoQuaySo.png" style="width: 72px;margin-top: -50px;" class="img-responsive" alt="">
			</div>
			<div class="panel-title-sign mt-xl text-right">
				<h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Đăng nhập</h2>
			</div>
			<div class="panel-body">
				<form action="" method="post">
						<?php
						if (isset($_GET['status'])){
							switch ($_GET['status']) {
								case -1: echo '<p style="color: red;"><b>Sai thông tin đăng nhập</b></p>';
								break;
							}
						}
						?>
						<div class="form-group mb-lg">
							<label>Số điện thoại</label>
							<div class="input-group input-group-icon">
								<input name="phone" type="text" class="form-control input-lg" />
								<span class="input-group-addon">
									<span class="icon icon-lg">
										<i class="fa fa-phone" aria-hidden="true"></i>
									</span>
								</span>
							</div>
						</div>

						<div class="form-group mb-lg">
							<label class="pull-left">Mật khẩu</label>
							<div class="input-group input-group-icon">
								<input name="password" type="password" class="form-control input-lg" />
								<span class="input-group-addon">
									<span class="icon icon-lg">
										<i class="fa fa-lock"></i>
									</span>
								</span>
							</div>                                
						</div>

						<div class="row form-group">
							<div class="col-sm-6 ">
								<div class=" text-left">                                    
									<a href="/forgetPassword" class="">Quên mật khẩu?</a>
								</div>
							</div>
							<div class="col-sm-6 text-right ">
								<div class=" text-left">                                    
									<a href="/register" class="pull-right">Đăng ký</a>
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-sm-6">
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

                            <p class="text-center text-muted mt-md mb-md">TOP TOP DIGIRAL SOLUTION © Copyright 2022</p>
                        </div>
                    </section>
                    <!-- end: page -->

                    <!-- Vendor -->
                    <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.js"></script>
                    <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.browser.mobile.js"></script>
                    <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/bootstrap.js"></script>
                    <!-- <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/nanoscroller.js"></script> -->
                    <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/bootstrap-datepicker.js"></script>
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