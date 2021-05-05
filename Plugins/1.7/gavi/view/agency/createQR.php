
<?php include('header_nav.php');?>


<div class="container title-page">
    <a href="/qrcode" class="back">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
    </a>
    <p>Tạo mã QR</p>
</div>

<div class="container page-content account">
 <div class="qr-created">
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>

    </div>
</div>
<?php }?>
<form action="" method="post">
    <div class="col-sm-12">
        <h4><strong>Quỹ tạo mã QR: <span><?php echo number_format($agency['Agency']['wallet']['active']+@$agency['Agency']['wallet']['purchaseFund']);?>đ</span></strong></h4>
    </div>

    <div class="col-xs-12 col-sm-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Cấp đại lý</label>

            <Select id="colorselector" class="form-control" required name="level">
                <option value="0">Chọn cấp đại lý cần tạo mã QR*</option>
                <?php
                foreach($listAgency as $typeAgency){
                    echo '<option value="'.$typeAgency['id'].'">'.$typeAgency['name'].'</option>';
                }
                ?>
            </Select>

        </div>
    </div>
    <div class="col-xs-12 col-sm-4">
        <div id="0" class="colors"> 
            <div class="form-group">
                <label for="">Số tiền đặt cọc</label>
                <input class="form-control" type="text" value="0đ" disabled="" name="">
            </div>
        </div>
        <?php
        foreach($listAgency as $typeAgency){
            echo '  <div id="'.$typeAgency['id'].'" class="colors" style="display:none"> 
            <div class="form-group">
            <label for="">Số tiền đặt cọc</label>
            <input class="form-control" type="text" value="'.number_format($typeAgency['money_deposit']).'đ" disabled="" name="">
            </div>
            </div>';
        }
        ?>
    </div>
    <div class="col-xs-12 col-sm-4">
        <div id="0" class="money"> 
            <div class="form-group">
                <label for="">Số tiền mua hàng</label>
                <input class="form-control" type="text" value="0đ" disabled="" name="">
            </div>
        </div>
        <?php
        foreach($listAgency as $typeAgency){
            echo '  <div id="'.$typeAgency['id'].'money" class="money" style="display:none"> 
            <div class="form-group">
            <label for="">Số tiền mua hàng</label>
            <input class="form-control" type="text" value="'.number_format($typeAgency['money_product']).'đ" disabled="" name="">
            </div>
            </div>';
        }
        ?>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-gavi" onclick="return confirm('Khi tạo mã bạn sẽ bị tạm giữ tiền đặt cọc, số tiền này sẽ không thể hoàn lại được, bạn có chắc chắn muốn tạo mã không ?');"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Tạo mã</button>
    </div>


    <div class="note_i"><i class="fa fa-info-circle"></i> Tiền sẽ được chuyển từ 'tiền được rút' sang 'quỹ mua hàng' nếu quỹ mua hàng củ bạn không đủ để tạo mã QR !</div>
    <center>
        <br/>
        <div id="id_qrcode1" class="id-qrcode text-center" style="height: 150px;width: 150px;"></div>
        <br/><br/>
        <p id="id_qrcode2"></p>
    </center>
</form>
</div>
</div>


<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>
<script>
   $(function() {
    $('#colorselector').change(function(){
        $('.colors').hide();
        $('#' + $(this).val()).show();

        $('.money').hide();
        $('#' + $(this).val() + 'money').show();
    });
});
</script>
<script type="text/javascript">
    function onReady()
    {
        var qrcode = new QRCode("id_qrcode1",{  text:"<?php echo $urlHomes.'activeQRCode?code='.@$codeQR.'&idAgencyFather='.$_SESSION['infoAgency']['Agency']['id'];?>",
            height: '150',
            width: '150',
            colorDark:"#000000",
            colorLight:"#ffffff",
            correctLevel:QRCode.CorrectLevel.H
        }
        );

        $('#id_qrcode2').html('<?php echo $urlHomes.'activeQRCode?code='.@$codeQR.'&idAgencyFather='.$_SESSION['infoAgency']['Agency']['id'];?>');
    }
    <?php
    if(!empty($codeQR)) echo 'onReady();';
    ?>
</script>
</body>
</html>
