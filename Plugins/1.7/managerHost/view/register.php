	<?php getHeader();?>

    <!-- Breadcrumps -->
    <div class="breadcrumbs">
        <div class="row">
            <div class="col-sm-6">
                <h1>Đăng ký</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li>Bạn đang ở: </li>
                    <li><a href="<?php echo $urlHomes;?>">Trang chủ</a></li>
                    <li class="active">Đăng ký</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- End of Breadcrumps -->

    <!-- Contact -->
    <section class="contact">
        <div class="row">
            <div class="col-sm-8">
                <form method="post" action="">
                    <h3>Đăng ký</h3>
                    <div id="sendstatus"><?php echo $messReg;?></div>
                    <div id="contactform">

                            <p><label for="name">Họ tên:*</label> <input value="<?php echo @$data['name'];?>" autocomplete="off" required type="text" class="form-control" name="name" id="name" tabindex="1" /></p>
                            <p><label for="email">Email:*</label> <input value="<?php echo @$data['email'];?>" autocomplete="off" required type="email" class="form-control" name="email" id="email" tabindex="2" /></p>
                            <p><label for="pass">Mật khẩu:*</label> <input value="<?php echo @$data['pass'];?>" autocomplete="off" minlength="6" required type="password" class="form-control" name="pass" id="pass" tabindex="3" /></p>
                            <p><label for="passAgain">Nhập lại mật khẩu:*</label> <input value="<?php echo @$data['passAgain'];?>" autocomplete="off" required type="password" class="form-control" name="passAgain" id="passAgain" tabindex="4" /></p>
                            <p><label for="phone">Điện thoại:</label> <input value="<?php echo @$data['phone'];?>" autocomplete="off" type="tel" class="form-control" name="phone" id="phone" tabindex="5" /></p>
                            <p><label for="address">Địa chỉ:</label> <input value="<?php echo @$data['address'];?>" autocomplete="off" type="text" class="form-control" name="address" id="address" tabindex="6" /></p>
                    </div>

                    <h3>Thông tin cá nhân</h3>
                    <div id="contactform">
                        <p><label for="email">Số CMND:*</label> <input value="<?php echo @$data['numberCMT'];?>" required type="text" class="form-control" name="numberCMT" id="numberCMT" tabindex="7" /></p>
                        <p><label for="name">Ngày cấp:*</label> <input value="<?php echo @$data['dateCMT'];?>" required type="text" class="form-control" name="dateCMT" id="dateCMT" tabindex="8" /></p>
                        <p><label for="phone">Nơi cấp:*</label> <input value="<?php echo @$data['addressCMT'];?>" required  type="text" class="form-control" name="addressCMT" id="addressCMT" tabindex="9" /></p>
                        <p><input name="submit" type="submit" id="submit" class="submit" value="Đăng ký" tabindex="10" /></p>
                    </div>
                </form>

            </div>

            <?php include('sidebar.php');?>
        </div>
    </section>
    <!-- End of Contact  -->

    <?php getFooter();?>