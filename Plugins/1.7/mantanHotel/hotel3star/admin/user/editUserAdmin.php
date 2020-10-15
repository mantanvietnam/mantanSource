<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $urlHomes.'app/Plugin/mantanHotel/script.js';?>"></script>

<?php
global $languageProduct;

$breadcrumb = array('name' => 'Quản lý tài khoản người dùng',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-user-listUserAdmin.php',
    'sub' => array('name' => 'Sửa tài khoản người dùng')
);
addBreadcrumbAdmin($breadcrumb);
?>  
<div class="taovien row" >

    <form action="" method="post" name="">
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
        <div class="taovien col-md-6 col-sm-12 col-xs-12" >
            <div class="form-group">
                <label for="">Tên người dùng: <span style="color: blue;" id="user" ><?php echo $data['User']['user'] ?></span></label>
            </div>
            <div class="form-group">
                <label for="Tên đầy đủ">Họ và tên (*)</label>
                <input type="text" name="fullname" class="form-control" id="fullname" value="<?php echo $data['User']['fullname'] ?>" required="" minlength="6">
            </div>
            <div class="form-group">
                <label for="Tên đầy đủ">CMND/Passport (*)</label>
                <input type="text" name="cmnd" disabled class="form-control" id="" value="<?php echo $data['User']['cmnd'] ?>" required="" minlength="6">
            </div>
            <div class="form-group">
                <label for="Tên đầy đủ">Email (*)</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo $data['User']['email'] ?>" required="">
            </div>
            <div class="form-group">
                <label for="">Mật khẩu (*)</label>
                <input type="password" name="password" class="form-control"  value="<?php echo $data['User']['password'] ?>" required="" minlength="6">
            </div>

        </div>
        <div class="taovien col-md-6 col-sm-12 col-xs-12" >
            <div class="form-group">
                <label for="Địa chỉ">Địa chỉ (*)</label>
                <input type="text" name="address" class="form-control" id="address"value="<?php echo $data['User']['address'] ?>" required="" >
            </div>
            <div class="form-group">
                <label for="Điện thoại">Điện thoại (*)</label>
                <input type="text" name="phone" class="form-control" id="phone" value="<?php echo $data['User']['phone'] ?>" required="">
            </div>
            <div class="form-group row">
                
                <div class="col-md-8 col-sm-8 col-xs-8">
                    <label for="exampleInputFile">Ảnh đại diện</label>
                <br>
                <?php
                if (!empty($data['User']['avatar'])) {
                    $image = $data['User']['avatar'];
                } else {
                    $image = '';
                }
                
                showUploadFile('avatar', 'avatar', $image);
                
                if (!empty($data['User']['avatar'])) {
                            $avatarImage = $data['User']['avatar'];
                        } else {
                            $avatarImage = $webRoot . 'images/avatar_default.png';
                        }
                ?>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <img  style="width: 100px;" src="<?php echo $avatarImage;?>">
                </div>
            </div>
            <div class="form-group">
                <label for="">Trạng thái</label>
                <select class="form-control" name="actived">
                    <option value="1" <?php if($data['User']['actived']==1) echo 'selected'; ?>>Kích hoạt</option>
                    <option value="0" <?php if($data['User']['actived']==0) echo 'selected'; ?>>Khóa</option>
                </select>
            </div>
            <div class="form-group">
                <label for="Điện thoại">Mô tả</label>
                <input type="text" name="desc" class="form-control" id="phone"  value="<?php echo isset($data['User']['desc']) ? $data['User']['desc'] : ''; ?>">
            </div>

        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; margin-bottom: 15px;"><button type="submit" onclick="return checkFullname('fullname');" class="btn btn-primary">Sửa</button></div>

    </form>
</div>
