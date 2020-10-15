	<?php getHeader();?>

    <!-- Breadcrumps -->
    <div class="breadcrumbs">
        <div class="row">
            <div class="col-sm-6">
                <h1>Đăng nhập</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li>Bạn đang ở: </li>
                    <li><a href="<?php echo $urlHomes;?>">Trang chủ</a></li>
                    <li class="active">Đăng nhập</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- End of Breadcrumps -->

    <!-- Login -->
    <section class="login">

        <div class="row spacing-40">
            <div class="col-sm-12">
                <div class="login-form-panel">
                    <h3 class="badge">ĐĂNG NHẬP</h3>
					
                    <div class="row">
                        <div class="col-sm-5 center-block">
                            <div class="login-form">
								<div id="sendstatus"><center><?php echo $messReg;?></center></div>
                                <form method="post" action="">
                                    <input type="email" name="email" placeholder="E-mail address" value="<?php echo @$data['email'];?>" />
                                    <input type="password" name="password" placeholder="Password" value="<?php echo @$data['password'];?>" />
                                    <p class="text-center">
										<a href="">Quên mật khẩu?</a>
										<a href="<?php echo $urlHomes.'register';?>">Đăng ký mới</a>
									</p>
                                    <input type="submit" value="Đăng nhập" />
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>
    <!-- End of Login -->
    
	<?php getFooter();?>