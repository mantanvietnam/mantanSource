<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $urlHomes.'app/Plugin/mantanHotel/script.js';?>"></script>
<?php
global $languageProduct;

$breadcrumb = array('name' => 'Quản lý đặt phòng',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-book-listBookAdmin.php',
    'sub' => array('name' => 'Đặt phòng')
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
                    case 1: echo '<p style="color:red;">Đặt phòng thành công!</p>';
                        break;
                    case -1: echo '<p style="color:red;">Đặt phòng không thành công!</p>';
                        break;
                }
            }
            ?>
            <div class="form-group">
                <label for="Tài khoản">Mã đặt phòng (*)</label>
                <input type="text" name="codeBook" class="form-control" id="codeBook" onkeyup="checkSpaceInKeyUp('codeBook');"  required="">
            </div>
            <div class="form-group">
                <label >Tên khách hàng (*)</label>
                <input type="text" name="cus_name" class="form-control" id="" required="">
            </div>
            <div class="form-group">
                <label >CMND/Passport (*)</label>
                <input type="text" name="cmnd" class="form-control" id="" required="">
            </div>
            <div class="form-group">
                <label >Checkin(*)</label>
                <input type="date" name="checkin" class="form-control" id="" required >
            </div>
            <div class="form-group">
                <label >Checkout(*)</label>
                <input type="date" name="checkout" class="form-control" id="" required >
            </div>
            
        </div>
        <div class="taovien col-md-6 col-sm-12 col-xs-12" >

            <div class="form-group">
                <label >Phòng (*)</label>
                <input type="text" name="room" class="form-control" id="room" required>
            </div>
            <div class="form-group">
                <label >Loại phòng (*)</label>
                <input type="text" name="type_room" class="form-control" id="type_room" >
            </div>
            
            
            <div class="form-group">
                <label >Nguồn</label>
                <input type="text" name="source" class="form-control" id="" >
            </div>
            <div class="form-group">
                <label >Công ty</label>
                <input type="text" name="company" class="form-control" id="">
            </div>
            <div class="form-group">
                <label >Trạng thái</label>
                <input type="text" name="status" class="form-control" id="">
            </div>
            <div class="form-group">
                <label >Ghi chú</label>
                <input type="text" name="note" class="form-control" id="" >
            </div>
            <div class="form-group">
                <label >Đặt cọc</label>
                <input type="number" name="deposit" class="form-control" id="">
            </div>

        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; margin-bottom: 15px;"><button type="submit" onclick="return checkFullname('fullname');" class="btn btn-primary">Đặt phòng</button></div>
    </form>
</div>

