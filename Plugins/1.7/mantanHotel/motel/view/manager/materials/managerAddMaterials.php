<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thêm mới Nguyên liệu</h2>

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
                <li><span>Thêm Nguyên liệu</span></li>
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
            <form id="" action="" class="form-horizontal" method="post">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Thêm mới Nguyên liệu</h2>
                    </header>
                    <div class="panel-body">


                        <div class="col-md-12 form-group">

                            <label class="col-sm-3 control-label">Tên Nguyên liệu:</label>
                            <div class="col-sm-9">
                                <input type="text" name="name"  class="form-control" placeholder="Tên Nguyên liệu" required="">
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Mã Nguyên liệu:</label>
                            <div class="col-sm-9">
                                <input type="text" name="code"  class="form-control" placeholder="Mã Nguyên liệu" required="">
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Loại Nguyên liệu:</label>
                            <div class="col-sm-9">
                                <select id="company" name="type_materials" class="form-control" required>
                                    <option value="0">Chọn loại Nguyên liệu</option>
                                    <?php foreach ($listData as $type_materials) { ?>
                                        <option value="<?php echo $type_materials['MaterialsGroup']['id'] ?>"><?php echo $type_materials['MaterialsGroup']['name'] ?></option>
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
                                <input type="number" name="quantity"  class="form-control"  required="">
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Giá nhập:</label>
                            <div class="col-sm-9">
                                <input type="number" name="priceInput"  class="form-control"  required="">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="col-sm-3 control-label">Ghi chú:</label>
                            <div class="col-sm-9">
                                <textarea type="text" name="note" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Thêm</button>
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