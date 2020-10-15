<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Sửa  Hàng hóa - Dịch vụ</h2>

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
                <li><span>Sửa Hàng hóa - Dịch vụ</span></li>
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

                        <h2 class="panel-title">Sửa  Hàng hóa - Dịch vụ</h2>
                    </header>
                    <div class="panel-body">


                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Tên Hàng hóa - Dịch vụ:</label>
                            <div class="col-sm-9">
                                <input name="name"  class="form-control" value="<?php echo $data['Merchandise']['name']; ?>" placeholder="Tên Hàng hóa - Dịch vụ" required="">
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Mã Hàng hóa - Dịch vụ:</label>
                            <div class="col-sm-9">
                                <input name="code"  class="form-control" value="<?php echo $data['Merchandise']['code']; ?>" placeholder="Mã Hàng hóa - Dịch vụ" required="">
                            </div>
                        </div>

                        <div class="col-md-12 form-group">

                            <label class="col-sm-3 control-label">Loại Hàng hóa - Dịch vụ:</label>
                            <div class="col-sm-9">
                                <select id="company" name="type_merchandise" class="form-control" required>
                                    <?php
                                    foreach ($listMerchandiseGroup as $merchandiseGroup) {
                                        ?>
                                        <option value="<?php echo $merchandiseGroup['MerchandiseGroup']['id'] ?>" <?php
                                        if ($data['Merchandise']['type_merchandise'] == $merchandiseGroup['MerchandiseGroup']['id']) {
                                            echo 'selected';
                                        }
                                        ?>><?php echo $merchandiseGroup['MerchandiseGroup']['name'] ?></option>
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
                                <input type="number" name="quantity"  class="form-control" min="0" value="<?php echo @$data['Merchandise']['quantity']; ?>"  required="">
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Giá nhập:</label>
                            <div class="col-sm-9">
                                <input type="number" name="priceInput"  class="form-control" min="0" value="<?php echo @$data['Merchandise']['priceInput']; ?>"  required="">
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Giá bán:</label>
                            <div class="col-sm-9">
                                <input type="number" name="price"  class="form-control" min="0" value="<?php echo @$data['Merchandise']['price']; ?>"  required="">
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="col-sm-3 control-label">Ghi chú:</label>
                            <div class="col-sm-9">
                                <textarea type="text" name="note" rows="5"class="form-control"><?php echo @$data['Merchandise']['note']; ?></textarea>
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
                                    <?php
                                        if(!empty($listMaterials)){
                                            $n= count($listMaterials);
                                            for($i=1;$i<=$n;$i++){ $k= $i-1; ?>
                                                <tr class="gradeX">
                                                    <td>
                                                        <select name="idNhomHangHoa" onchange="getAjaxMaterials(this.value,<?php echo $i;?>)"  class="form-control">
                                                            <option value="">Chọn nhóm Nguyên liệu</option>
                                                            <?php 
                                                                foreach ($dataMaterialsGroup as $MaterialsGroup) { 
                                                                    if($MaterialsGroup['MaterialsGroup']['id']!=$listMaterials[$k]['Materials']['type_materials']){
                                                                        echo '<option  value="'.$MaterialsGroup['MaterialsGroup']['id'].'">'.$MaterialsGroup['MaterialsGroup']['name'].'</option>';
                                                                    }else{
                                                                        echo '<option  value="'.$MaterialsGroup['MaterialsGroup']['id'].'" selected>'.$MaterialsGroup['MaterialsGroup']['name'].'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="idHangHoa[<?php echo $i;?>]" id="idHangHoa-<?php echo $i;?>" class="form-control">
                                                            <option value="">Chọn nguyên liệu</option>
                                                            <?php 
                                                                if(!empty($listMaterialsGroup[$listMaterials[$k]['Materials']['type_materials']])){
                                                                    foreach ($listMaterialsGroup[$listMaterials[$k]['Materials']['type_materials']] as $MaterialsGroup) { 
                                                                        if($MaterialsGroup['Materials']['id']!=$listMaterials[$k]['Materials']['id']){
                                                                            echo '<option data-price="'.$MaterialsGroup['Materials']['price'].'"  value="'.$MaterialsGroup['Materials']['id'].'">'.$MaterialsGroup['Materials']['name'].'</option>';
                                                                        }else{
                                                                            echo '<option data-price="'.$MaterialsGroup['Materials']['price'].'"  value="'.$MaterialsGroup['Materials']['id'].'" selected>'.$MaterialsGroup['Materials']['name'].'</option>';
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="soluong[<?php echo $i;?>]" min="0" class="form-control" value="<?php echo @$data['Merchandise']['materials'][$listMaterials[$k]['Materials']['id']];?>"  placeholder="Khối lượng (kg)"/></td>
                                                </tr>
                                            <?php    
                                            }
                                        }
                                    ?>
                                    <?php for($i=$n+1;$i<=$numberProduct;$i++){ ?>
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
                                <button type="submit" class="btn btn-primary">Sửa</button>
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
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>