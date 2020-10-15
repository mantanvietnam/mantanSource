<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $urlHomes.'app/Plugin/mantanHotel/script.js';?>"></script>
<?php
global $languageProduct;

$breadcrumb = array('name' => 'Quản lý tài khoản người dùng',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-user-listUserAdmin.php',
    'sub' => array('name' => 'Thêm tài khoản người dùng')
);
addBreadcrumbAdmin($breadcrumb);
?>  

<div class="taovien row">
    <?php if (!empty($mess)) { ?>
        <p style="font-weight: bold; color: red;"> <?php echo $mess; ?></p>
    <?php } ?>
    <form action="" method="post" name="">
        <div class="taovien col-md-6 col-sm-12 col-xs-12" >
            <?php
            if (isset($_GET['status'])) {
                switch ($_GET['status']) {
                    case 1: echo '<p style="color:red;">Thêm tài khoản người dùng thành công!</p>';
                        break;
                    case -1: echo '<p style="color:red;">Thêm tài khoản người dùng không thành công!</p>';
                        break;
                }
            }
            ?>
            <div class="form-group">
                <label for="Tài khoản">Tài khoản (*)</label>
                <input type="text" name="user" class="form-control" id="user" onkeyup="checkSpaceInKeyUp('user');"  required="">
            </div>
            <div class="form-group">
                <label for="Tên đầy đủ">Họ và tên (*)</label>
                <input type="text" name="fullname" class="form-control" id="fullname" required="">
            </div>
            <div class="form-group">
                <label for="Tên đầy đủ">CMND/Passport (*)</label>
                <input type="text" name="cmnd" class="form-control" id="" required="">
            </div>
            <div class="form-group">
                <label for="Tên đầy đủ">Email (*)</label>
                <input type="email" name="email" class="form-control" id="email" required="">
            </div>

            <div class="form-group">
                <label for="Điện thoại">Mật khẩu (*)</label>
                <input type="text" name="password" class="form-control" id="" required="" minlength="6">
            </div>
        </div>
        <div class="taovien col-md-6 col-sm-12 col-xs-12" >

            <div class="form-group">
                <label for="Địa chỉ">Địa chỉ (*)</label>
                <input type="text" name="address" class="form-control" id="address" required  style="word-break: break-word;">
            </div>
            <div class="form-group">
                <label for="Điện thoại">Điện thoại (*)</label>
                <input type="text" name="phone" class="form-control" id="phone" required="">
            </div>
            <div class="form-group">
                <label for="exampleInputFile">Ảnh đại diện</label>
                <br>
                <?php showUploadFile('avatar', 'avatar'); ?>
            </div>
            <div class="form-group">
                <label for="Điện thoại">Trạng thái</label>
                    <select class="form-control" name="actived">
                        <option value="1">Kích hoạt</option>
                        <option value="0">Khóa</option>
                    </select>
            </div>
            <div class="form-group">
                <label for="Điện thoại">Mô tả</label>
                <input type="text" name="desc" class="form-control" id="" >
            </div>

        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; margin-bottom: 15px;"><button type="submit" onclick="return checkFullname('fullname');" class="btn btn-primary">Thêm</button></div>
    </form>
</div>

