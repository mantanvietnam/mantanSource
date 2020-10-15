<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thêm mới phiếu thu</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php global $urlHomeManager; echo $urlHomeManager; ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Phiếu thu</span></li>
                <li><span>Thêm phiếu thu</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            <form id="summary-form" action="" method="" class="form-horizontal">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Thêm mới phiếu thu</h2>
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
                                        <input type="text" data-plugin-timepicker class="form-control">
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
                                        <input type="text" data-plugin-timepicker class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Loại phòng:</label>
                                <div class="col-sm-8">
                                    <select id="company" class="form-control" required>
                                        <option value="">Chọn loại phòng</option>
                                        <option value="">Phòng đơn</option>
                                        <option value="">Phòng đôi</option>
                                        <option value="">Phòng đặc biệt</option>
                                    </select>
                                    <label class="error" for="room"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Ngày bắt đầu:</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" data-plugin-datepicker class="form-control" required/>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Ngày kết thúc:</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" data-plugin-datepicker class="form-control" required/>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <lable class="col-sm-4 control-label">Trị giá phiếu thu:</lable>
                                <div class="col-sm-8">
                                    <input type="number" name="money" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nội dung phiếu thu:</label>
                                <div class="col-sm-10">
                                    <textarea name="content" rows="5" class="form-control" placeholder="Nội dung phiếu thu"></textarea>
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
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>