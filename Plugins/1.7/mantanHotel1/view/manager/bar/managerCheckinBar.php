<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-left.php'; ?>


<section role="main" class="content-body">
    <header class="page-header">
        <h2>Nhận bàn bar</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php global $urlHomeManager; echo $urlHomeManager; ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Nhận bàn bar</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($mess)) { ?>
                    <p style="font-weight: bold; color: red;"> <?php echo $mess; ?></p>
                <?php } ?> 
            <form id="summary-form" action="" method="post" class="form-horizontal">
				<input name="idTable" type="hidden" value="<?php echo $dataTable['BarTable']['id']; ?>" />
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Nhận bàn bar: <?php echo $dataTable['BarTable']['name']; ?></h2>
                    </header>
                    <div class="panel-body">
                        <div class="row">
							<div class="col-md-6">
                                <h2 class="panel-title"> Thông tin khách hàng</h2>
                                <br/>
                                     <div class="form-group">
                                        <label class="col-sm-4 control-label">Tên khách hàng (Không bắt buộc):</label>
                                        <div class="col-sm-8">                                    
                                            <input type="text" name="cus_name" class="form-control" value="" />
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <h2 class="panel-title"> Thông tin đăng ký</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Ngày vào: <span class="required">*</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" name="date_checkin" id="date_checkin" value="<?php echo $today['mday'].'/'.$today['mon'].'/'.$today['year'];?>" data-plugin-datepicker class="form-control" required />                                          
                                            <span class="input-group-addon">lúc</span>
                                            <input type="text" name="time_checkin" id="time_checkin" value="<?php echo $today['hours'].':'.$today['minutes'];?>" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false}' required />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Số lượng người:</label>
                                    <div class="col-sm-8">
                                            <input min="1" type="number" name="number_people" id="number_people" class="form-control" value="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Nhận bàn bar</button>
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