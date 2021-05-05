
        <?php include('header_nav.php');?>

        <div class="container title-page">
                <a href="/listShip" class="back">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                </a>
                <p>Thêm yêu cầu ship</p>
        </div>

        <div class="container page-content">
            <div class="col-xs-12 col-sm-12 agency-detail">
                <?php if(!empty($mess)){ ?>
                <div id="showM" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Thông báo</h4>
                    </div>
                    <div class="modal-body">
                        <div class="showMess"><?php echo $mess; ?></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default setfocus" data-dismiss="modal" autofocus>Đóng</button>
                    </div>
                </div>

            </div>
        </div>
        <?php }?>
        <div class="letter-content">
            <form action="" method="post">
                <input type="hidden" name="priceShip" id="priceShip" value="">
                <input type="hidden" name="numberContainer" id="numberContainer" value="">
                <div class="" id="selectAddress">
                    <Select id="colorselector1" class="form-control" onchange="addAddress(this.value);" style="margin-bottom: 10px;">
                        <option value="0">Địa chỉ khác</option>
                        <?php
                        if(!empty($_SESSION['infoAgency']['Agency']['addressTo'])){
                            foreach($_SESSION['infoAgency']['Agency']['addressTo'] as $key=>$addressTo){
                                echo '<option value="'.$key.'">'.$addressTo['address'].'</option>';
                            }
                            
                        }
                        ?>
                    </Select>
                </div>

                <div class="input_kh">
                    <div class="kh_basic">
                        <div class="form-group">
                            <input type="text" class="form-control" value="" id="name" name="name" placeholder="Người nhận*" required="">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Địa chỉ* (Điền đầy đủ thông tin số nhà, đường, quận, huyện, tỉnh/TP)" class="form-control" id="address" name="address" required="">
                        </div>
                        <div class="form-group">
                           <select name="city" class="form-control" required="">
                               <option value="">Chọn Tỉnh/Thành *</option>
                                <?php
                                    $listCity= getListCity();
                                    foreach($listCity as $city){
                                        echo '<option value="'.$city['id'].'">'.$city['name'].'</option>';
                                    }
                                ?>
                           </select>
                        </div>
                        <div class="form-group">
                            <input type="text" title="Vui lòng điền đúng theo định dạng đầu số điện thoại hiện hành theo quy định!"  class="form-control" placeholder="Số điện thoại*" id="phone" name="phone" required="" value="">
                        </div>
                        <div class="form-group">
                            <input type="text"  class="input_date1 form-control" id="date" name="date" placeholder="Ngày nhận" value="">
                        </div>
                        <div class="form-group">
                            <textarea type="email" class="form-control" id="note" name="note" placeholder="Ghi chú"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control input_money" name="money" value="" placeholder="Số tiền cần thu*" required="">
                        </div>
                        <div class="form-group">
                           <strong> Phí vận chuyển: <span class="total" id="totalShip">0</span>đ</strong>
                        </div>
                    </div>
                </div>

                <div class="form-sl">
                    <?php
                    if(!empty($listProduct)){
                        foreach($listProduct as $product){
                            echo '  <div class="form-group product">
                            <input type="hidden" value="'.$product['Product']['productContainer'].'" id="productContainer'.$product['Product']['id'].'" />
                            <input type="hidden" value="'.$product['Product']['priceShipContainer'].'" id="priceShipContainer'.$product['Product']['id'].'" />
                            <input type="hidden" value="'.$product['Product']['freeShipContainer'].'" id="freeShipContainer'.$product['Product']['id'].'" />
                            <label for="">'.$product['Product']['name'].': <span>'.number_format($product['Product']['quantity']).' chai</span></label>
                            <div class="form-sl-input">
                            <input onchange="checkProduct(\''.$product['Product']['id'].'\');" type="text" class=" form-control quant" placeholder="Số lượng" max="'.$product['Product']['quantity'].'" id="'.$product['Product']['id'].'" name="quantity['.$product['Product']['id'].']">
                            </div>
                            </div>';
                        }

                        echo '  <div class="letter-footer1">
                        <button type="submit" class="btn btn-gavi width-100" autocomplete="off">
                        <i class="fa fa-paper-plane" aria-hidden="true"></i> Gửi
                        </button>
                        </div>';
                    }else{
                        echo '<p>Bạn không có hàng trong kho nên không thể thực hiện yêu cầu ship hàng.</p>';
                    }
                    ?>
                </div>
            </form>
            <?php
                global $productPenalties;
                echo '<p class="ship_note"> <i class="fa fa-info-circle"></i> <span>Mỗi 1 đơn hàng bị trả lại sẽ bị phạt số tiền là '.number_format($productPenalties).'đ/lốc</span></p>';
            ?>
            
        </div>
    </div>
</div>

<script type="text/javascript">
    function checkProduct(id){
        var productContainer= parseInt($('#productContainer'+id).val());
        var priceShipContainer= parseInt($('#priceShipContainer'+id).val());
        var freeShipContainer= parseInt($('#freeShipContainer'+id).val());
        var number= parseInt($('#'+id).val());
        
        if(number%productContainer==0){
            update();
        }else{
            $('#'+id).val('');
            alert('Bạn phải nhập số sản phẩm là bội số của '+productContainer);
        }

        
    }

    function update() {
        var quantity=0;
        var id= '';
        var ship= 0.0;
        var productContainer= 1;
        var priceShipContainer= 0;
        var freeShipContainer= 0;
        var lo= 0;
        var numberContainer= 0;

        $('.product').each(function() {
            id= $(this).find('.quant').attr('id');
            quantity = $(this).find('.quant').val();

            productContainer= parseInt($('#productContainer'+id).val());
            priceShipContainer= parseInt($('#priceShipContainer'+id).val());
            freeShipContainer= parseInt($('#freeShipContainer'+id).val());
            lo= quantity/productContainer;
            if(lo<freeShipContainer){
                ship += lo*priceShipContainer;
            }
            numberContainer+= lo;
        });

        $('#totalShip').text(ship.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
        $('#priceShip').val($('#totalShip').text());
        $('#numberContainer').val(numberContainer);
    }
</script>

<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>


<script src="https://www.jqueryscript.net/demo/Easy-jQuery-Input-Mask-Plugin-inputmask/dist/jquery.inputmask.bundle.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ace-elements.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ace.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/jquery.maskedinput.min.js"></script>
<script>
 $(document).ready(function () {
     $("input.input_date").inputmask();
 });
</script>

<script src="/app/Plugin/gavi/view/agency/js/number-divider.js"></script>
<script>
 $(document).ready(function () {
     $('.input_money').divide({delimiter: '.',
         divideThousand: true});
 });
</script>

<script>
    var address= [];
    address[0]= [];
    address[0][0]= '';
    address[0][1]= '';
    address[0][2]= '';

    address[1]= [];
    address[2]= [];
    address[3]= [];
    address[4]= [];
    address[5]= [];
    <?php
    if(!empty($_SESSION['infoAgency']['Agency']['addressTo'])){
        foreach($_SESSION['infoAgency']['Agency']['addressTo'] as $key=>$addressTo){
            echo 'address['.$key.'][0]= "'.$addressTo['name'].'";';
            echo 'address['.$key.'][1]= "'.$addressTo['phone'].'";';
            echo 'address['.$key.'][2]= "'.$addressTo['address'].'";';
        }
        
    }
    ?>

    function addAddress(id)
    {
        $('#name').val(address[id][0]);
        $('#phone').val(address[id][1]);
        $('#address').val(address[id][2]);
    }
</script>

<script>
    $(document).ready(function () {
        $('.back-store').click(function () {
            $('.ul_buy').slideToggle();
        });
    });
</script>

<link rel='stylesheet prefetch' href='/app/Plugin/gavi/view/agency/css/jquery-ui.css'>
<script src='/app/Plugin/gavi/view/agency/js/jquery-ui.min.js'></script>
<link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css'>
<script src='//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
<script type="text/javascript">
    $(".input_date1").datepicker({
        minDate: 0,
        maxDate: "",
        numberOfMonths: 1
    });
    jQuery(function($){
        $.datepicker.regional['vi'] = {
            closeText: 'Đóng',
            prevText: '<Trước',
            nextText: 'Tiếp>',
            currentText: 'Hôm nay',
            monthNames: ['Tháng Một', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu',
            'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười Hai'],
            monthNamesShort: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
            'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            dayNames: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
            dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            weekHeader: 'Tu',
            dateFormat: 'dd/mm/yy',
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''};
            $.datepicker.setDefaults($.datepicker.regional['vi']);
        });
    </script>
</body>
</html>
