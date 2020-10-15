<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Sửa nhóm phân quyền</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php global $urlHomeManager; echo $urlHomeManager; ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Nhóm phân quyền</span></li>
                <li><span>Sửa nhóm phân quyền</span></li>
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
            <form id="summary-form" action="" class="form-horizontal" method="post">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Sửa nhóm phân quyền mới</h2>
                    </header>
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tên nhóm phân quyền (*) <span class="required"></span></label>
                            <div class="col-sm-6">
                                <input type="text" name="name" class="form-control" required value="<?php echo $permission['Permission']['name'] ?>"/>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Ghi chú:<span></span></label>
                            <div class="col-sm-6">
                                <input type="text" name="note" class="form-control" value="<?php echo $permission['Permission']['note'] ?>" />
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
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-right.php'; ?>