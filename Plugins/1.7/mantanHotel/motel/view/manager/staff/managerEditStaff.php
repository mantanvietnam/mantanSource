<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Sửa nhân viên</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php
                    global $urlHomeManager;
                    echo $urlHomeManager;
                    ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Nhân viên</span></li>
                <li><span>Sửa nhân viên</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($mess)) { ?>
                <h5 style="color: red;" ><span class="glyphicon glyphicon-remove"></span> <?php echo $mess; ?></h5>
            <?php } ?>
            <form id="summary-form" action="" class="form-horizontal" method="post">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Sửa nhân viên</h2>
                    </header>
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tên đăng nhập (*) <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="user" class="form-control" required value="<?php echo $data['Staff']['user'] ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Đổi mật khẩu </label>
                            <div class="col-sm-6">
                                <input type="text" name="password" class="form-control" minlength="6" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Khách sạn được giao: <span class="required">(*)</span></label>
                            <div class="col-sm-6">
                                <?php foreach ($listHotel as $hotel) { ?>
                                    <input type="checkbox" id="" name="listHotel[]" value="<?php echo $hotel['Hotel']['id'] ?>" <?php
                                    foreach ($data['Staff']['listHotel']as $list_hotel) {
                                        if ($list_hotel == $hotel['Hotel']['id']) {
                                            echo 'checked';
                                        }
                                    }
                                    ?>>
                                    <label><?php echo $hotel['Hotel']['name'] ?></label><br>
                                <?php } ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nhóm phân quyền: <span class="required">(*)</span></label>
                            <div class="col-sm-6">

                                <?php foreach ($listPermission as $permission) {
                                    ?>
                                    <input type="checkbox" id="" name="groupPermission[]" value="<?php echo $permission['Permission']['id']; ?>"
                                    <?php
                                    foreach ($data['Staff']['groupPermission']as $ten_nhom_phan_quyen) {
                                        if ($ten_nhom_phan_quyen == $permission['Permission']['id']) {
                                            echo 'checked';
                                        }
                                    }
                                    ?>
                                           >
                                    <label><?php echo $permission['Permission']['name']; ?></label><br>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Trạng thái: <span class="required">(*)</span></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="actived">
                                    <option value="1" <?php
                                    if ($data['Staff']['actived'] == 1) {
                                        echo 'selected';
                                    }
                                    ?>>Kích hoạt</option>
                                    <option value="0" <?php
                                    if ($data['Staff']['actived'] == 0) {
                                        echo 'selected';
                                    }
                                    ?>>Khóa</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Họ và tên: <span class="required">(*)</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="fullname" class="form-control" required value="<?php echo $data['Staff']['fullname'] ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Số CMND: <span class="required">(*)</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="cmnd" class="form-control" required value="<?php echo $data['Staff']['cmnd'] ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Ngày cấp: <span class="required">(*)</span></label>
                            <div class="col-sm-6">
                                <input type="date" name="date_cmnd" class="form-control" required value="<?php echo $data['Staff']['date_cmnd'] ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Ngày sinh: <span class="required">(*)</span></label>
                            <div class="col-sm-6">
                                <input type="date" name="birthday" class="form-control" required value="<?php echo $data['Staff']['birthday'] ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Địa chỉ:<span class="required">(*)</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="address" class="form-control" required value="<?php echo $data['Staff']['address'] ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Số điện thoại:<span class="required">(*)</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="phone" class="form-control" required value="<?php echo $data['Staff']['phone'] ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email: <span class="required">(*)</span></label>
                            <div class="col-sm-6">
                                <input type="email" name="email" class="form-control" required value="<?php echo $data['Staff']['email'] ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Ngày bắt đầu làm:<span class="required">(*)</span></label>
                            <div class="col-sm-6">
                                <input type="date" name="date_start" class="form-control" required value="<?php echo $data['Staff']['date_start'] ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mô tả:<span></span></label>
                            <div class="col-sm-6">
                                <input type="text" name="desc" class="form-control" value="<?php echo @$data['Staff']['desc'] ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Phân quyền:<span></span></label>
                            <div class="col-sm-6">
                                <ul style="margin: 0;list-style: none outside none;padding:0;">
                                    <?php
                                    foreach ($listPermissionMenu as $permissionMenu) {
                                        if (!empty($permissionMenu['sub'])) {
                                            ?>
                                            <li>
                                                <span style="font-weight: bold;"><?php echo $permissionMenu['name'] ?></span>
                                                <ul style="margin-left: 20px;list-style: none outside none;padding:0;">
                                                    <?php
                                                    foreach ($permissionMenu['sub'] as $menu2) {
                                                        ?>
                                                        <li>
                                                            <input type="checkbox" <?php
                                                            if (isset($data['Staff']['check_list_permission']) && in_array($menu2['permission'], $data['Staff']['check_list_permission'])) {
                                                                echo 'checked';
                                                            }
                                                            ?> value="<?php echo $menu2['permission'] ?>" name="check_list_permission[]"> <?php echo $menu2['name'] ?>
                                                        </li>  
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </li>
                                        <?php } elseif (!empty($permissionMenu['permission'])) {
                                            ?>
                                            <li>
                                                <input  type="checkbox" <?php
                                                if (isset($data['Staff']['check_list_permission']) && in_array($permissionMenu['permission'], $data['Staff']['check_list_permission'])) {
                                                    echo 'checked';
                                                }
                                                ?> value="<?php echo $permissionMenu['permission'] ?>" name="check_list_permission[]"> <?php echo $permissionMenu['name'] ?>
                                            </li> 
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Phân quyền nâng cao:<span></span></label>
                            <div class="col-sm-6">
                                <ul style="margin: 0;list-style: none outside none;padding:0;">
                                    <?php
                                    foreach ($listPermissionAdvanced as $key=>$value) {
                                        if(isset($data['Staff']['permissionAdvanced']) && in_array($key,$data['Staff']['permissionAdvanced'])){
                                            $checked= 'checked';
                                        }else{
                                            $checked= '';
                                        }
                                        echo '<li>
                                                <input '.$checked.' type="checkbox" value="'.$key.'" name="permissionAdvanced[]"> '.$value.'
                                            </li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="text-center">
                                <button class="btn btn-primary">Sửa</button>
                            </div>
                        </div>
                    </footer>
                </section>
            </form>
        </div>
    </div>
    <!-- end: page -->
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>