<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Sửa  ngày lễ</h2>

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
                <li><span>Ngày lễ</span></li>
                <li><span>Sửa ngày lễ</span></li>
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
            <form id="" action="" class="form-horizontal" method="post">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Sửa  Ngày lễ</h2>
                    </header>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <lable class="col-sm-3 control-label">Tên ngày lễ (*)</lable>
                                <div class="col-sm-9">
                                    <input type="text" name="name" value="<?php echo $data['Holiday']['name']; ?>" class="form-control" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Mô tả</label>
                                <div class="col-sm-9">
                                    <textarea name="describe" rows="5" class="form-control" placeholder="Mô tả ngày lễ" ><?php echo $data['Holiday']['describe']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Giờ bắt đầu (*)</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </span>
                                        <input type="text" name="time_start" data-plugin-timepicker value="<?php echo date("H:i", $data['Holiday']['dateTimeStart']); ?>"  class="form-control" data-plugin-options='{ "showMeridian": false}'>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Ngày bắt đầu (*)</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" name="date_start" value="<?php echo date("d/m/Y", $data['Holiday']['dateTimeStart']); ?>" data-plugin-datepicker class="form-control" required/>
                                    </div>

                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Giờ kết thúc (*)</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </span>
                                        <input type="text" name="time_end" data-plugin-timepicker value="<?php echo date("H:i", $data['Holiday']['dateTimeEnd']); ?>"  class="form-control" data-plugin-options='{ "showMeridian": false}'>
                                    </div>
                                </div>
                            </div> 

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Ngày kết thúc (*)</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" name="date_end" value="<?php echo date("d/m/Y", $data['Holiday']['dateTimeEnd']); ?>" data-plugin-datepicker class="form-control" required/>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Sửa</button>
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