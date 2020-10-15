<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thêm số lượng Nguyên liệu</h2>

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
                <li><span>Thêm số lượng Nguyên liệu</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                        <a href="#" class="fa fa-times"></a>
                    </div>

                    <h2 class="panel-title">Thêm số lượng Nguyên liệu</h2>
                </header>
                <div class="panel-body">
                    <form id="" action="" class="form-horizontal" method="post">
                        <div class="form-inline">
                            <label class="control-label">Số loại nguyên liệu cần nhập kho</label>
                            <input type="number" required="" name="numberProduct" min="1" value="<?php echo $numberProduct;?>" class="form-control"  placeholder="Nhập số mặt hàng cần nhập kho"/>
                            <button type="submit" class="btn btn-primary">Hiển thị</button>
                        </div>
                    </form>
                    <form id="" action="" class="form-horizontal" method="post">
                        <div class="table-responsive" style="margin-top: 15px;">
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
                                            <select name="idHangHoa[<?php echo $i;?>]" id="idHangHoa-<?php echo $i;?>" required=""  class="form-control">
                                                <option value="">Chọn Nguyên liệu</option>
                                            </select>
                                        </td>
                                        <td><input type="number" required="" name="soluong[<?php echo $i;?>]" min="1" class="form-control"  placeholder="Khối lượng (kg)"/></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="row" style="margin-top: 15px;">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Thêm</button>
                            </div>
                        </div>
                    </form> 
                </div>
                
            </section>
              
        </div>
    </div>
    <!-- end: page -->
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
    
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-right.php'; ?>