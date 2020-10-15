<?php
$breadcrumb = array
(
    'name' => 'Danh sách học sinh',
    'url' => '/plugins/admin/Studentystem-admin-editStudent.php',
    'sub' => array('name' => 'Sửa Thông tin học sinh')
    );
addBreadcrumbAdmin($breadcrumb);
?> 
<div class="clear"></div>
<div id="content">
    <form action="" method="post" class="taovienLimit">
    </form>
    <div class="col-sm-12">
        <?php
        if (isset($_GET['status'])) {
            switch ($_GET['status']) {
                case 2: echo '<p style="color:red;">Sửa tài khoản thành công!</p>';
                break;
                case -2: echo '<p style="color:red;">Sửa tài khoản không thành công!</p>';
                break;
                case 3: echo '<p style="color:red;">Xóa tài khoản thành công!</p>';
                break;
            }
        }
        ?>
    </div>
    <form action="" method="post">
        <div class="row">
            <?php if (isset($data))

            {?>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden" name="idEditStudent" value="<?php echo $data['Student']['id'] ?>" placeholder="">
                <div class="form-group">
                    <label>Họ tên </label>
                    <input class="form-control" value="<?php echo $data['Student']['fullname'] ?>" name="fullname" type="text" placeholder="Họ tên...">                 
                </div>          
                <div class="form-group">
                    <label>Tài khoản (*)</label>                 
                    <input class="form-control" name="username" value="<?php echo $data['Student']['username'] ?>"  readonly type="text" placeholder="Tài khoản...">
                </div>  
                <div class="form-group">
                    <label>Mật khẩu mới (*)</label>                 
                    <input class="form-control" value="" name="password" required="" minlength="6"  type="password" placeholder="">
                </div> 
                <div class="form-group">
                    <label>Nhập lại mật khẩu (*)</label>                 
                    <input class="form-control" value="" name="passwordAgain" required="" minlength="6" type="password" placeholder="">
                </div> 

            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 ">

                <div class="form-group">
                    <label>Email </label>
                    <input class="form-control" value="<?php echo $data['Student']['email'] ?>" name="email" type="email" placeholder="Email..." >                 
                </div> 
                <div class="form-group">
                    <label>Giới tính (*)</label>
                    <div class="checkbox">
                        <label>
                            <input type="radio" <?php if (isset($data['Student']['sex']) && $data['Student']['sex'] ==1) {
                                echo "checked";
                            }else{
                                echo "";
                            }?>  name="sex" value="1"   required="required">  Nam 
                        </label>
                        <label>
                            <input type="radio" value="0"  name="sex" <?php if (isset($data['Student']['sex']) && $data['Student']['sex'] ==0) {
                                echo "checked";
                            }else{
                                echo"";
                            }?>   required="required"> Nữ
                        </label>
                    </div>
                </div> 
                <div class="form-group">
                    <label>Điện thoại</label>                 
                    <input class="form-control" name="phone" value="<?php echo $data['Student']['phone'] ?>"  type="text" placeholder="Điện thoại...">
                </div>  
                <div class="form-group">
                    <label>Điạ chỉ</label>                 
                    <textarea class="form-control" name="address" value="" rows="4"  type="text" placeholder="Địa chỉ..."><?php echo $data['Student']['address'] ?></textarea>
                    <br>
                    <button type="submit" class="btn btn-primary ">Lưu</button> 
                </div>  

            </div>
            <?php  }?>
        </div>
    </form>

</div>