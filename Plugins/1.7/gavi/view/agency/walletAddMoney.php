
<?php include('header_nav.php');?>

<div class="container title-page">
  <a href="/wallet" class="back">
    <i class="fa fa-angle-left" aria-hidden="true"></i>
  </a>
  <p>Thông báo nạp tiền</p>
  <!-- <a href="javascript:void(0);" class="back-store"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
  <ul class="list-unstyled ul_buy">
    <li>
      <a href="/walletNotification" class="">Lịch sử thông báo</a>
    </li>
  </ul> -->
</div>

<div class="container home-block" style="margin-top: 52px;">
  <div class="">
    <a href="/walletNotification">
      <div class="col-xs-12 item" style="text-align: left;padding-top: 12px; height: auto">
        <ul class="list-unstyled">
          <li>Danh sách Lịch sử thông báo</li>
        </ul>
      </div>
    </a> 
  </div>
</div>

<div class="container wallet-add-money">
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
    <form action="" method="post" enctype="multipart/form-data">
      <div class="col-xs-12 col-sm-12 item" style="padding-top: 10px;">
        <div class="form-group">
          <input class="input_money form-control" type="text" placeholder="Số tiền nạp*" name="money" value=""  pattern="^[\d/.]{7,16}$" title="Số tiền nạp thấp nhất là 100.000 đ" required="">
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 item">
        <div class="form-group">
          <input type="text" placeholder="Ngày nạp tiền*" id="" class="form-control input_date1" value="" name="date"  required="">
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 item">
        <div class="form-group">
          <textarea class="form-control" name="note" placeholder="Lý do nạp tiền" rows="3"></textarea>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 item">
        <label>File UNC: </label>
        <input type="file" name="file" style="margin-bottom: 5px;">
      </div>
      <div class="col-xs-12 col-sm-12 item">
       <!--  <label>Thông tin tài khoản tương ứng với tài khoản công ty được chọn: </label> -->

       <select id="colorselector1" class="form-control" required="" name="bankSelect" style="font-size: 14px;margin:6px 0 20px;">
        <option value="">Chọn tài khoản ngân hàng *</option>
        <?php
        foreach($_SESSION['infoAgency']['Agency']['bank'] as $key=>$bank){
          echo '<option value="'.$key.'">'.$bank['bankAccount'].' - '.$bank['bankName'].'</option>';
        }
        ?>
        <option value="new">Ngân hàng khác</option>
      </select>

      <div id="new" class="div_h" style="display:none">
        <div class="form-group">
          <input class="form-control" type="text" placeholder="Tên chủ tài khoản *" name="bankAccount" value=""  >
        </div>
        <div class="form-group">
          <input class="form-control" type="text" placeholder="Số tài khoản *" name="bankNumber" value=""  >
        </div>
        <div class="form-group">
          <input class="form-control" type="text" placeholder="Tên chi nhánh *" name="bankBranch" value=""  >
        </div>
        <div class="form-group">
          <select name="bankID" class="form-control" >
            <option value="">Chọn ngân hàng *</option>
            <?php 
            foreach($listBank as $bank){
              echo '<option value="'.$bank['id'].'">'.$bank['name'].'</option>';
            }
            ?>
          </select>
        </div>
      </div>

      


      <div class="form-group">
        <button type="submit" data-loading-text="Loading..." class="btn btn-gavi width-100" data-toggle="modal" data-target="#myModal" autocomplete="off">
          <i class="fa fa-paper-plane" aria-hidden="true"></i> Nạp tiền
        </button>
      </div>
    </div>
  </form>
</div>


<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>

<script src="https://www.jqueryscript.net/demo/Easy-jQuery-Input-Mask-Plugin-inputmask/dist/jquery.inputmask.bundle.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ace-elements.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ace.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/jquery.maskedinput.min.js"></script>

<script src="/app/Plugin/gavi/view/agency/js/number-divider.js"></script>
<script>
  $(document).ready(function() {
    $('.input_money').divide({delimiter: '.',
      divideThousand: true});
  });
</script>


<script>
  $(document).ready(function() {
    $('.back-store').click(function(){
      $('.ul_buy').slideToggle();
    });


    $(function() {
      $('.div_h').hide();
      $('#colorselector1').change(function(){
        $('.div_h').hide();
        $('#' + $(this).val()).show();
      });
    });
  });
</script>

<link rel='stylesheet prefetch' href='/app/Plugin/gavi/view/agency/css/jquery-ui.css'>
<script src='/app/Plugin/gavi/view/agency/js/jquery-ui.min.js'></script>
<link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css'>
<script src='//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
<script type="text/javascript">
  $(".input_date1").datepicker({
    // minDate: 0,
    // maxDate: "",
    // numberOfMonths: 1
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
      // firstDay: 0,
      // isRTL: false,
      // showMonthAfterYear: false,
      // yearSuffix: ''
    };
      $.datepicker.setDefaults($.datepicker.regional['vi']);
    });
  </script>
</body>
</html>
