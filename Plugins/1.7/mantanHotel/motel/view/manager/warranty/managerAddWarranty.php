<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thêm bảo hành</h2>

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
                <li><span>CSKH</span></li>
                <li><span>Thêm bảo hành</span></li>
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

                            <h2 class="panel-title">Thêm bảo hành</h2>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Đối tác: <span class="required">(*)</span></label>
                                <div class="col-sm-6">
                                    <select name="idPartner" class="form-control">
                                        <option value="">Thợ tự do</option>
                                        <?php 
                                            if(!empty($listPartner)){
                                                foreach ($listPartner as $partner) { 
                                                    echo '<option value="'.$partner['Partner']['id'].'">'.$partner['Partner']['fullname'].'</option>';
                                                }
                                            } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Số điện thoại:<span class="required">(*)</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="phone" class="form-control" required value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Ghi chú:<span></span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="note" class="form-control" value="" />
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
    <!--end: page -->
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php';
?>