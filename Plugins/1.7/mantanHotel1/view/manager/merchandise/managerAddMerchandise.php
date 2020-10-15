<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thêm mới Hàng hóa - Dịch vụ</h2>

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
                <li><span>Thêm Hàng hóa - Dịch vụ</span></li>
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

                        <h2 class="panel-title">Thêm mới Hàng hóa - Dịch vụ</h2>
                    </header>
                    <div class="panel-body">


                        <div class="col-md-12 form-group">

                            <label class="col-sm-3 control-label">Tên Hàng hóa - Dịch vụ:</label>
                            <div class="col-sm-9">
                                <input type="text" name="name"  class="form-control" placeholder="Tên Hàng hóa - Dịch vụ" required="">
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Mã Hàng hóa - Dịch vụ:</label>
                            <div class="col-sm-9">
                                <input type="text" name="code"  class="form-control" placeholder="Mã Hàng hóa - Dịch vụ" required="">
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Loại Hàng hóa - Dịch vụ:</label>
                            <div class="col-sm-9">
                                <select id="company" name="type_merchandise" class="form-control" required>
                                    <option value="0">Chọn loại Hàng hóa - Dịch vụ</option>
                                    <?php foreach ($listData as $type_merchandise) { ?>
                                        <option value="<?php echo $type_merchandise['MerchandiseGroup']['id'] ?>"><?php echo $type_merchandise['MerchandiseGroup']['name'] ?></option>
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
                            <label class="col-sm-3 control-label">Số lượng (cái, chiếc, chai, lọ):</label>
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
                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Giá bán:</label>
                            <div class="col-sm-9">
                                <input type="number" name="price"  class="form-control"  required="">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="col-sm-3 control-label">Ghi chú:</label>
                            <div class="col-sm-9">
                                <textarea type="text" name="note" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                       
                        <div class="table-responsive col-md-12" style="margin-top: 15px;">
                            <table class="table table-bordered table-striped mb-none">
                                <thead>
                                    <tr>
                                        <th>Nhóm Nguyên liệu</th>
                                        <th>Nguyên liệu</th>
                                        <th>Khối lượng (kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for($i=1;$i<=$numberProduct;$i++){ ?>
                                    <tr class="gradeX">
                                        <td>
                                            <select name="idNhomHangHoa" onchange="getAjaxMaterials(this.value,<?php echo $i;?>)"  class="form-control">
                                                <option value="">Chọn nhóm Nguyên liệu</option>
                                                <?php 
                                                    foreach ($dataMaterialsGroup as $MaterialsGroup) { 
                                                        echo '<option  value="'.$MaterialsGroup['MaterialsGroup']['id'].'">'.$MaterialsGroup['MaterialsGroup']['name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="idHangHoa[<?php echo $i;?>]" id="idHangHoa-<?php echo $i;?>" class="form-control">
                                                <option value="">Chọn nguyên liệu</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="soluong[<?php echo $i;?>]" min="0" class="form-control"  placeholder="Khối lượng (kg)"/></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
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
    <script type="text/javascript">
        var urlHomes= '<?php echo $urlHomes; ?>';
        
        function getAjaxMaterials(idNhomHangHoa,stt)
        {
            $.ajax({
              type: "POST",
              url: urlHomes+"getAjaxMaterials",
              data: { idNhomHangHoa:idNhomHangHoa}
            }).done(function( msg ) {
                $('#idHangHoa-'+stt).html(msg);
            })
            .fail(function() {
                alert('Quá trình load gặp lỗi !');
                return false;
            });
        }
    
    </script>
    <!-- end: page -->
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-right.php'; ?>