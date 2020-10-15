<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thêm mới khuyến mại</h2>

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
                <li><span>Khuyến mại</span></li>
                <li><span>Thêm khuyến mại</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            <form id="" action="" class="form-horizontal" method="post">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Thêm mới khuyến mại</h2>
                        <div class="showMess"><?php echo $mess; ?></div>
                    </header>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Giờ bắt đầu:</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </span>
                                        <input type="text" name="time_start" data-plugin-timepicker class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Giờ kết thúc:</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </span>
                                        <input type="text" name="time_end" data-plugin-timepicker class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Loại phòng:</label>
                                <div class="col-sm-8">
                                    <select id="company" name="type_room" class="form-control" required>
                                        <?php
    										foreach ($listTypeRoom as $typeRoom)
    										{
    											echo '<option value="'.$typeRoom['TypeRoom']['id'].'">'.$typeRoom['TypeRoom']['roomtype'].'</option>';
    										}
    									?>
                                    </select>
                                    <label class="error" for="room"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Ngày bắt đầu:</label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" name="date_start" data-plugin-datepicker class="form-control" required/>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Ngày kết thúc:</label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" name="date_end" data-plugin-datepicker class="form-control" required/>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <lable class="col-sm-5 control-label">Giảm trừ khi checkout:</lable>
                                <div class="col-sm-7">
                                    <input type="number" name="promotion_value" class="form-control" required/>
                                    <p>Giá trị khuyến mại nhỏ hơn 100 thì hiểu là giảm theo phần trăm</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nội dung khuyến mại:</label>
                                <div class="col-sm-10">
                                    <textarea type="text" name="content" rows="5" class="form-control"  required=""></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Thêm</button>
                                <button type="reset" class="btn btn-default">Hủy</button>
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
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-right.php'; ?>