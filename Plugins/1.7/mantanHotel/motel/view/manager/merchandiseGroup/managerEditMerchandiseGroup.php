<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Sửa  nhóm Hàng hóa - Dịch vụ</h2>

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
                <li><span>Hàng hóa - Dịch vụ</span></li>
                <li><span>Sửa nhóm Hàng hóa - Dịch vụ</span></li>
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

                        <h2 class="panel-title">Sửa  nhóm Hàng hóa - Dịch vụ</h2>
                    </header>
                    <div class="panel-body">


                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Tên nhóm Hàng hóa - Dịch vụ:</label>
                            <div class="col-sm-9">
                                <input name="name"  class="form-control" value="<?php echo $data['MerchandiseGroup']['name']; ?>" placeholder="Tên nhóm Hàng hóa - Dịch vụ" required="">
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Ghi chú:</label>
                            <div class="col-sm-9">
                                <textarea name="note" rows="5" class="form-control" placeholder="Nội dung nhóm Hàng hóa - Dịch vụ"><?php echo @$data['MerchandiseGroup']['note']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Sửa</button>
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