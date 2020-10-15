<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Sửa Nguyên liệu</h2>

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
                <li><span>Nguyên liệu</span></li>
                <li><span>Sửa Nguyên liệu</span></li>
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
            <form  action="" class="form-horizontal" method="post">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Sửa  Nguyên liệu</h2>
                    </header>
                    <div class="panel-body">


                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Tên Nguyên liệu:</label>
                            <div class="col-sm-9">
                                <input name="name"  class="form-control" value="<?php echo $data['Materials']['name']; ?>" placeholder="Tên Nguyên liệu" required="">
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Mã Nguyên liệu:</label>
                            <div class="col-sm-9">
                                <input name="code"  class="form-control" value="<?php echo $data['Materials']['code']; ?>" placeholder="Mã Nguyên liệu" required="">
                            </div>
                        </div>

                        <div class="col-md-12 form-group">

                            <label class="col-sm-3 control-label">Loại Nguyên liệu:</label>
                            <div class="col-sm-9">
                                <select id="company" name="type_materials" class="form-control" required>
                                    <?php
                                    foreach ($listMaterialsGroup as $MaterialsGroup) {
                                        ?>
                                        <option value="<?php echo $MaterialsGroup['MaterialsGroup']['id'] ?>" <?php
                                        if ($data['Materials']['type_materials'] == $MaterialsGroup['MaterialsGroup']['id']) {
                                            echo 'selected';
                                        }
                                        ?>><?php echo $MaterialsGroup['MaterialsGroup']['name'] ?></option>
                                            <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Ngày nhập:</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" required="" value="<?php echo $today['mday'].'/'.$today['mon'].'/'.$today['year'];?>" class="form-control" data-plugin-datepicker="" name="date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Khối lượng (kg):</label>
                            <div class="col-sm-9">
                                <input type="number" name="quantity"  class="form-control" min="0" value="<?php echo @$data['Materials']['quantity']; ?>"  required="">
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Giá nhập:</label>
                            <div class="col-sm-9">
                                <input type="number" name="priceInput"  class="form-control" min="0" value="<?php echo @$data['Materials']['priceInput']; ?>"  required="">
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Ghi chú:</label>
                            <div class="col-sm-9">
                                <textarea type="text" name="note" rows="5"class="form-control"><?php echo @$data['Materials']['note']; ?></textarea>
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