<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thêm đồ ăn trong nhà hàng</h2>

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
                <li><span>Nhà hàng</span></li>
                <li><span>Thêm đồ ăn</span></li>
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

                    <h2 class="panel-title">Bàn: <?php echo $dataTable['Table']['name']; ?></h2>
                </header>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form id="" action="" class="form-horizontal" method="post">
                            <div class="form-inline">
                                <label class="control-label">Số đồ ăn khách gọi</label>
                                <input type="number" required="" name="numberProduct" min="1" value="<?php echo $numberProduct;?>" class="form-control"  placeholder="Nhập số mặt hàng cần nhập kho"/>
                                <button type="submit" class="btn btn-primary">Hiển thị</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <p style="font-weight: bold; color: red;"> Chỉ thêm đồ ăn đồ uống sau khi pha chế xong</p>
                    </div>
                    <form id="" action="" class="form-horizontal col-md-12" method="post">
                        <div class="table-responsive" style="margin-top: 15px;">
                            <table class="table table-bordered table-striped mb-none">
                                <thead>
                                    <tr>
                                        <th>Nhóm hàng hóa</th>
                                        <th>Hàng hóa</th>
                                        <th>Số lượng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for($i=1;$i<=$numberProduct;$i++){ ?>
                                    <tr class="gradeX">
                                        <td>
                                            <select name="idNhomHangHoa" onchange="getAjaxMerchandise(this.value,<?php echo $i;?>)"  class="form-control">
                                                <option value="">Chọn nhóm hàng hóa</option>
                                                <?php 
                                                    foreach ($dataMerchandiseGroup as $merchandiseGroup) { 
                                                        echo '<option  value="'.$merchandiseGroup['MerchandiseGroup']['id'].'">'.$merchandiseGroup['MerchandiseGroup']['name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="idHangHoa[<?php echo $i;?>]" id="idHangHoa-<?php echo $i;?>" class="form-control">
                                                <option value="">Chọn hàng hóa</option>
                                            </select>
                                        </td>
                                        <td><input type="number" name="soluong[<?php echo $i;?>]" min="1" class="form-control"  placeholder="Số lượng (cái, chiếc, chai, lọ)"/></td>
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
        
        function getAjaxMerchandise(idNhomHangHoa,stt)
        {
            $.ajax({
              type: "POST",
              url: urlHomes+"getAjaxMerchandise",
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