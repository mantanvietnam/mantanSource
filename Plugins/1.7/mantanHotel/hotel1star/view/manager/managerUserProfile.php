<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Trang cá nhân</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Pages</span></li>
                <li><span>Trang cá nhân</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="tabs">
            <ul class="nav nav-tabs tabs-primary">
                <li class="active">
                    <a href="#overview" data-toggle="tab">Thông tin người dùng</a>
                </li>
                <li>
                    <a href="#edit" data-toggle="tab">Sửa thông tin cá nhân</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="overview" class="tab-pane active">
                    <h4 class="mb-md">Thông tin hiện tại</h4>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="profileFirstName">Tài khoản</label>
                            <div class="col-md-8">
                                <label><?php echo $data['Manager']['user'] ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="profileLastName">Họ và tên</label>
                            <div class="col-md-8">
                                <label><?php echo $data['Manager']['fullname'] ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="profileAddress">Email</label>
                            <div class="col-md-8">
                                <label><?php echo $data['Manager']['email'] ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="profileCompany">Địa chỉ</label>
                            <div class="col-md-8">
                                <label><?php echo $data['Manager']['address'] ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="profileCompany">Điện thoại</label>
                            <div class="col-md-8">
                                <label><?php echo $data['Manager']['phone'] ?></label>
                            </div>
                        </div>
                    </fieldset>
                    <hr class="dotted tall">
                    <h4 class="mb-xlg">Giới thiệu</h4>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="profileBio">Vài nét về bản thân</label>
                            <div class="col-md-8">
                                <p><?php echo @$data['Manager']['desc'] ?></p>
                            </div>
                        </div>

                    </fieldset>

                </div>
                <div id="edit" class="tab-pane">
                    <form class="form-horizontal" method="post" action="">
                        <h4 class="mb-xlg">Thông tin cá nhân</h4>
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileFirstName">Tài khoản</label>
                                <div class="col-md-8">
                                    <input type="text" name="user"   value="<?php echo $data['Manager']['user'] ?>"class="form-control" id="profileFirstName">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileLastName">Họ và tên</label>
                                <div class="col-md-8">
                                    <input type="text" name="fullname" value="<?php echo $data['Manager']['fullname'] ?>" class="form-control" id="profileLastName">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileAddress">Email</label>
                                <div class="col-md-8">
                                    <input name="email" type="email" value="<?php echo $data['Manager']['email'] ?>" class="form-control" id="profileAddress">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileOldPassword">Mật khẩu</label>
                                <div class="col-md-8">
                                    <input type="text" name="password" value="" autocomplete="off" class="form-control" id="profileOldPassword">
                                </div>
                            </div>
                            <div class="form-group">

                                <label class="col-md-3 control-label" for="exampleInputFile">Ảnh đại diện</label>
                                <br>
                                <?php
                                if (!empty($data['Manager']['avatar'])) {
                                    $image = $data['Manager']['avatar'];
                                } else {
                                    $image = '';
                                }
                                ?>

                                <div class="col-md-4">
                                    <?php
                                    showUploadFile('avatar', 'avatar', $image);

                                    if (!empty($data['Manager']['avatar'])) {
                                        $avatarImage = $data['Manager']['avatar'];
                                    } else {
                                        $avatarImage = $webRoot . 'images/avatar_default.png';
                                    }
                                    ?>

                                </div>
                                <div class="col-md-2">
                                    <img  style="width: 100px;" src="<?php echo $avatarImage; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"  for="">Trạng thái</label>
                                <div class="col-md-8">
                                <select class="form-control" name="actived">
                                    <option value="1" <?php if ($data['Manager']['actived'] == 1) echo 'selected'; ?>>Kích hoạt</option>
                                    <option value="0" <?php if ($data['Manager']['actived'] == 0) echo 'selected'; ?>>Khóa</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileEmail">Địa chỉ</label>
                                <div class="col-md-8">
                                    <input name="address" type="text" value="<?php echo $data['Manager']['address'] ?>" class="form-control" id="profileEmail">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileEmail">Điện thoại</label>
                                <div class="col-md-8">
                                    <input type="text" name="phone" value="<?php echo $data['Manager']['phone'] ?>" class="form-control" id="profileEmail">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileBio">Vài nét về bản thân</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" name="desc" rows="3" id="profileBio"><?php echo @$data['Manager']['desc'] ?></textarea>
                                </div>
                            </div>

                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-md-9 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary">Lưu lại</button>
                                        <button type="reset" class="btn btn-default">Hủy bỏ</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end: page -->
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-right.php'; ?>