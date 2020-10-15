<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Bán lẻ Hàng hóa</h2>

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
                <li><span>Bán lẻ Hàng hóa</span></li>
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

                    <h2 class="panel-title">Bán lẻ Hàng hóa</h2>
                </header>
                <div class="panel-body">
                    <form id="" action="" class="form-horizontal" method="post">
                        <div class="form-inline">
                            <label class="control-label">Số mặt hàng cần bán</label>
                            <input type="number" required="" name="numberProduct" min="1" value="<?php echo $numberProduct;?>" class="form-control"  placeholder="Nhập số mặt hàng cần bán"/>
                            <button type="submit" class="btn btn-primary">Hiển thị</button>
                        </div>
                    </form>
                    <form id="" action="" class="form-horizontal" method="post">
                        <div class="table-responsive" style="margin-top: 15px;">
                            <table class="table table-bordered table-striped mb-none">
                                <thead>
                                    <tr>
                                        <th>Nhóm hàng hóa</th>
                                        <th>Hàng hóa</th>
                                        <th>Số lượng</th>
                                        <th>Giá bán</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for($i=1;$i<=$numberProduct;$i++){ ?>
                                    <tr class="gradeX">
                                        <td>
                                            <select name="idNhomHangHoa[<?php echo $i;?>]" onchange="getAjaxMerchandise(this.value,<?php echo $i;?>)"  class="form-control">
                                                <option value="">Chọn nhóm hàng hóa</option>
                                                <?php 
                                                    foreach ($dataMerchandiseGroup as $merchandiseGroup) { 
                                                        echo '<option  value="'.$merchandiseGroup['MerchandiseGroup']['id'].'">'.$merchandiseGroup['MerchandiseGroup']['name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="idHangHoa[<?php echo $i;?>]" id="idHangHoa-<?php echo $i;?>" required=""  class="form-control">
                                                <option value="">Chọn hàng hóa</option>
                                            </select>
                                        </td>
                                        <td><input type="number" required="" onchange="tinhGia(this.value,<?php echo $i;?>);" name="soluong[<?php echo $i;?>]" min="1" class="form-control"  placeholder="Số lượng (cái, chiếc, chai, lọ)"/></td>
                                        <td><input type="number" required="" id="price-<?php echo $i;?>" name="price[<?php echo $i;?>]" min="1" class="form-control"  placeholder="Thành tiền"/></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="row" style="margin-top: 15px;">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Bán hàng</button>
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
    
        function tinhGia(soluong,stt)
        {
            var price= parseInt($('#idHangHoa-'+stt+' option:selected').attr('data-price'));
            var total= 0;
            if(price>0 && parseInt(soluong)>0){
                total= price*soluong;
            }
            
            $('#price-'+stt).val(total);
        }
    </script>
    
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-right.php'; ?>