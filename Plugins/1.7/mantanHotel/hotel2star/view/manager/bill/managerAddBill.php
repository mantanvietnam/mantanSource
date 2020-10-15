<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thêm phiếu chi</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php global $urlHomeManager; echo $urlHomeManager; ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Quản lý chi</span></li>
                <li><span>Thêm phiếu chi</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            <form id="summary-form" action="" class="form-horizontal" method="post">
                <input type="hidden" value="<?php echo @$data['Bill']['id'];?>" name="id" />
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Thêm phiếu chi mới</h2>
                    </header>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Thời gian: <span class="required">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </span>
                                    <input name="time" value="<?php echo $today['hours'].':'.$today['minutes'];?>" required="" type="text" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false }'>
                                    <span class="input-group-addon"> ngày </span>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input name="date" type="text" data-plugin-datepicker class="form-control" value="<?php echo $today['mday'].'/'.$today['mon'].'/'.$today['year'];?>" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Số tiền: <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" name="coin" required min="0" value="<?php echo @$data['Bill']['coin'];?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Người nhận tiền: <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="nguoi_nhan" required value="<?php echo @$data['Bill']['nguoi_nhan'];?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Hình thức chi: <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <select name="typeBill" class="form-control" required>
                                    <?php
                                        foreach($typeCollectionBill as $key=>$type){
                                            if(isset($data['Bill']['typeBill']) && $data['Bill']['typeBill']==$key){
                                                echo '<option selected value="'.$key.'">'.$type.'</option>';
                                            }else{
                                                echo '<option value="'.$key.'">'.$type.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                                <label class="error" for="select"></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Người chi: <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="nguoi_chi" value="<?php echo (isset($data['Bill']['nguoi_chi']))?$data['Bill']['nguoi_chi']:$_SESSION['infoManager']['Manager']['fullname'];?>" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Ghi chú:</label>
                            <div class="col-sm-6">
                                <textarea  rows="5" class="form-control" name="note"><?php echo @$data['Bill']['note'];?></textarea>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="text-center">
                                <button class="btn btn-primary">Lưu phiếu</button>
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