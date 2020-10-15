<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $urlHomes.'app/Plugin/mantanHotel/script.js';?>"></script>

<?php
global $languageProduct;

$breadcrumb = array('name' => 'Quản lý tài khoản',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-manager-listManager.php',
    'sub' => array('name' => 'Sửa tài khoản')
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

<div class="taovien row" >

    <form action="" method="post" name="">
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
        <div class="taovien col-md-6 col-sm-12 col-xs-12" >
            <div class="form-group">
                <label for="">Tên tài khoản: <span style="color: blue;" id="user" ><?php echo $data['Manager']['user'] ?></span></label>
            </div>
            <div class="form-group">
                <label for="">Ngày tạo: <span style="color: red;" ><?php echo date('d-m-Y h:i:s', $data['Manager']['created']->sec); ?></span></label>
            </div>
            <div class="form-group">
                <label for="Tên đầy đủ">Họ và tên (*)</label>
                <input type="text" name="fullname" class="form-control" id="fullname" value="<?php echo $data['Manager']['fullname'] ?>" required="">
            </div>
            <div class="form-group">
                <label for="Tên đầy đủ">Email (*)</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo $data['Manager']['email'] ?>" required="" >
            </div>
            <div class="form-group">
                <label for="">Mật khẩu (*)</label>
                <input type="text" name="password" class="form-control"  value="" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="Ngày hết hạn">Ngày hết hạn (*)</label>
                <input type="text" name="deadline" class="form-control" id="deadline" required="" value="<?php echo $deadline; ?>">
            </div>
            <div class="form-group">
                <label for="Số phòng tối đa">Số phòng tối đa (*)</label>
                <input type="text" name="numberRoomMax" class="form-control" id="numberRoomMax" required="" value="<?php echo @$data['Manager']['numberRoomMax'] ?>">
            </div>
            <div class="form-group">
                <label for="Email đại lý giới thiệu">Email đại lý giới thiệu</label>
                <input type="text" name="agency" class="form-control" id="agency" value="<?php echo @$data['Manager']['agency'] ?>">
            </div>
        </div>
        <div class="taovien col-md-6 col-sm-12 col-xs-12" >
            <div class="form-group">
                <label for="Địa chỉ">Địa chỉ (*)</label>
                <input type="text" name="address" class="form-control" id="address"value="<?php echo $data['Manager']['address'] ?>" required="" >
            </div>
            <div class="form-group">
                <label for="Điện thoại">Điện thoại (*)</label>
                <input type="text" name="phone" class="form-control" id="phone" value="<?php echo $data['Manager']['phone'] ?>" required="">
            </div>
            <div class="form-group">
                <label for="exampleInputFile">Ảnh đại diện</label>
                <br>
                <?php
                if (!empty($data['Manager']['avatar'])) {
                    $image = $data['Manager']['avatar'];
                } else {
                    $image = '';
                }

                showUploadFile('avatar', 'avatar', $image);
                ?>
            </div>
            <div class="form-group">
                <label for="">Trạng thái</label>
                <select class="form-control" name="actived">
                    <option value="1" <?php if($data['Manager']['actived']==1) echo 'selected'; ?>>Kích hoạt</option>
                    <option value="0" <?php if($data['Manager']['actived']==0) echo 'selected'; ?>>Khóa</option>
                </select>
            </div>
            <div class="form-group">
                <label for="Điện thoại">Mô tả</label>
                <textarea name="desc" class="form-control" rows="7"><?php echo isset($data['Manager']['desc']) ? $data['Manager']['desc'] : ''; ?></textarea>
            </div>

        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; margin-bottom: 15px;"><button type="submit" onclick="return checkFullname('fullname');" class="btn btn-primary">Sửa</button></div>

    </form>
</div>
