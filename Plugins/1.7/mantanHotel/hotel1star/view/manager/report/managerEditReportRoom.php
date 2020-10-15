<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Báo hỏng phòng</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php global $urlHomeManager; echo $urlHomeManager; ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Sửa báo hỏng</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            <form id="summary-form" action="" class="form-horizontal" method="post">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Sửa báo hỏng</h2>
                    </header>
                    <div class="panel-body">                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tên phòng: </label>
                            <div class="col-sm-6">
                                <?php
                                    foreach($listData as $room){
                                        if($room['Room']['id'] == $data['Report']['idRoom']){
                                            echo '<input class="form-control" name="name" value="'.$room['Room']['name'].'" disabled="" type="text">';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Trạng thái xử lý: </label>
                            <div class="col-sm-6">
                                <select id="" class="form-control" name="status" required="">
                                    <option value="new" <?php if($data['Report']['status']=='new') echo 'selected';?> >Mới báo hỏng</option>
                                    <option value="process" <?php if($data['Report']['status']=='process') echo 'selected';?> >Đang xử lý</option>
                                    <option value="done" <?php if($data['Report']['status']=='done') echo 'selected';?> >Đã xử lý xong</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nội dung báo: <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" type="text" name="content" rows="5" required><?php echo $data['Report']['content'];?></textarea>
                            </div>
                        </div>
						
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="text-center">
                                <button class="btn btn-primary">Lưu</button>
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