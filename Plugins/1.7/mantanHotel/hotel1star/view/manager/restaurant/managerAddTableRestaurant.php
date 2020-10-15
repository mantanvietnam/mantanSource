<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thêm bàn</h2>

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
                <li><span>Thêm bàn</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            <form id="summary-form" action="" class="form-horizontal" method="post">
                <input type="hidden" class="form-control" name="id" value="<?php echo @$data['Table']['id']; ?>" />
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Thêm bàn mới</h2>
                    </header>
                    <div class="panel-body">                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tên bàn: <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" value="<?php echo @$data['Table']['name']; ?>" required />
                            </div>
                        </div>
                        <?php
                        if (!isset($data['Table']['id'])) {
                            ?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tầng: <span class="required">*</span></label>
                                <div class="col-sm-6">
                                    <select id="company" class="form-control" name="floor" required />
                                    <option value="">- Chọn tầng -</option>
                                    <?php
                                    if (!empty($listRestaurantFloor)) {
                                        

                                        foreach ($listRestaurantFloor as $floor) {
                                            echo '<option ';
                                            if (isset($data['Table']['floor']) && $floor['RestaurantFloor']['id'] == $data['Table']['floor'])
                                                echo 'selected ';
                                            if (isset($_GET['idRestaurantFloor']) && $floor['RestaurantFloor']['id'] == $_GET['idRestaurantFloor'])
                                                echo 'selected ';
                                            echo 'value="' . $floor['RestaurantFloor']['id'] . '">' . $floor['RestaurantFloor']['name'] . '</option>';
                                        }
                                    }
                                    ?>
                                    </select>
                                    <label class="error" for="select"></label>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

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
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>