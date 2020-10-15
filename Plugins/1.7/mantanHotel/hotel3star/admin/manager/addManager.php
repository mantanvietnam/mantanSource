<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $urlHomes.'app/Plugin/mantanHotel/script.js';?>"></script>
<?php
global $languageProduct;

$breadcrumb = array('name' => 'Quản lý tài khoản',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-manager-listManager.php',
    'sub' => array('name' => 'Thêm tài khoản')
);
addBreadcrumbAdmin($breadcrumb);
?>  

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
  $( function() {
    $( "#deadline" ).datepicker({
      dateFormat: "dd-mm-yy"
    });
  } );
</script>

<div class="taovien row">
    <?php if (!empty($mess)) { ?>
        <p style="font-weight: bold; color: red;"> <?php echo $mess; ?></p>
    <?php } ?>
    <form action="" method="post" name="">
        <div class="taovien col-md-6 col-sm-12 col-xs-12" >
            <?php
            if (isset($_GET['status'])) {
                switch ($_GET['status']) {
                    case 1: echo '<p style="color:red;">Thêm tài khoản thành công!</p>';
                        break;
                    case -1: echo '<p style="color:red;">Thêm tài khoản không thành công!</p>';
                        break;
                }
            }
            ?>
            <div class="form-group">
                <label for="Tài khoản">Tài khoản (*)</label>
                <input type="text" name="user" class="form-control" id="user" onkeyup="checkSpaceInKeyUp('user');"  required="" >
            </div>
            <div class="form-group">
                <label for="Tên đầy đủ">Họ và tên (*)</label>
                <input type="text" name="fullname" class="form-control" id="fullname" required="">
            </div>
            <div class="form-group">
                <label for="Tên đầy đủ">Email </label>
                <input type="email" name="email" class="form-control" id="email" >
            </div>

            <div class="form-group">
                <label for="Điện thoại">Mật khẩu (*)</label>
                <input type="text" name="password" class="form-control" id="" required="" >
            </div>
            <div class="form-group">
                <label for="Ngày hết hạn">Ngày hết hạn (*)</label>
                <input type="text" name="deadline" class="form-control" id="deadline" required="">
            </div>
            <div class="form-group">
                <label for="Số phòng tối đa">Số phòng tối đa (*)</label>
                <input type="text" name="numberRoomMax" class="form-control" id="numberRoomMax" required="" value="20">
            </div>
            <div class="form-group">
                <label for="Email đại lý giới thiệu">Email đại lý giới thiệu</label>
                <input type="text" name="agency" class="form-control" id="agency" value="">
            </div>
        </div>
        <div class="taovien col-md-6 col-sm-12 col-xs-12" >

            <div class="form-group">
                <label for="Địa chỉ">Địa chỉ (*)</label>
                <input type="text" name="address" class="form-control" id="address" required style="word-break: break-word;">
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
                <textarea name="desc" class="form-control" rows="7"></textarea>
            </div>
            

        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; margin-bottom: 15px;"><button type="submit" onclick="return checkFullname('fullname');" class="btn btn-primary">Thêm</button></div>
    </form>
</div>

