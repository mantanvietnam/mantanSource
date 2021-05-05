
<?php include('header_nav.php');?>

<style type="text/css" media="screen">
.form-group{
    margin-bottom: 3px;
}
.g_search .col-xs-6{
    padding: 0;
}
</style>
<div class="container title-page">
    <!-- <a href="/dashboardAgency" class="back"> -->
        <a href="/dashboardAgency" class="back">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <p>Đơn hàng bán</p>
        
    </div>

    <nav class="menu-item">
        <div class="container">
            <div class="collapse-item">
                <div class="nav-menu-item">
                    <div class="nav-menu-item-a <?php if(!isset($_GET['idStatus'])) echo 'current-tab';?>"><a href="/listOrderSell">Tất cả</a></div>
                    <div class="nav-menu-item-a <?php if(isset($_GET['idStatus']) && $_GET['idStatus']==1) echo 'current-tab';?>"><a href="/listOrderSell?idStatus=1">Chờ duyệt</a></div>
                    <div class="nav-menu-item-a <?php if(isset($_GET['idStatus']) && $_GET['idStatus']==3) echo 'current-tab';?>"><a href="/listOrderSell?idStatus=3">Từ chối</a></div>
                    <div class="nav-menu-item-a <?php if(isset($_GET['idStatus']) && $_GET['idStatus']==2) echo 'current-tab';?>"><a href="/listOrderSell?idStatus=2">Đã hoàn thành</a></div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container g_search">
        <form action="" method="get" accept-charset="utf-8">
            <div class="form-group col-xs-6 col-sm-4">
                <input type="text" class="form-control" placeholder="Mã đơn hàng" name="code" value="<?php echo @$_GET['code'];?>">
            </div>
            <div class="form-group col-xs-6 col-sm-4">
                <input type="text" class="form-control datepicker" placeholder="Từ ngày" name="dateStart" value="<?php echo @$_GET['dateStart'];?>">
            </div>
            <div class="form-group col-xs-6 col-sm-4">
                <input type="text" class="form-control datepicker" placeholder="Đến ngày" name="dateEnd" value="<?php echo @$_GET['dateEnd'];?>">
            </div>
            <div class="form-group col-xs-6 col-sm-4">
                <input type="text" class="form-control" placeholder="Mã đại lý" name="codeAgency" value="<?php echo @$_GET['codeAgency'];?>">
            </div>
            <div class="form-group col-xs-6 col-sm-4">
                <input type="text" class="form-control" placeholder="SĐT đại lý" name="phoneAgency" value="<?php echo @$_GET['phoneAgency'];?>">
            </div>
            <div class="form-group col-xs-4 col-xs-offset-4 col-sm-4">
                <input type="submit" class="btn btn-gavi1" value="Tìm kiếm" name="">
            </div>
            
        </form>
    </div>
   
    
    <div class="container page-content buy">
        <form action="">
            <div class="product-list">
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
            <?php 
            if(!empty($listData)){
               $modelAgency= new Agency();
               foreach($listData as $data){
                $listProduct= array();
                if(!empty($data['Order']['product'])){
                    foreach($data['Order']['product'] as $product){
                        $listProduct[]= $product['quantily'].' chai '.$product['name'];
                    }
                }
                $infoAgency= $modelAgency->getAgencyByCode($data['Order']['codeAgency'],array('fullName','phone'));

                echo '<div class="col-xs-12 col-md-12 product-item">
                <a class="p_a" href="">
                <div class="thumb">
                <img src="/app/Plugin/gavi/view/agency/img/logo.png">
                </div>
                <div class="product-name">
                <label>'.$data['Order']['code'].' đại lý '.$infoAgency['Agency']['fullName'].' - '.$infoAgency['Agency']['phone'].'</label>
                <label>Trạng thái: <span> '.$statusOrder[$data['Order']['status']]['name'].'</span></label>
                <span>Đơn hàng: '.implode(', ', $listProduct).'</span>';
                if(!empty($data['Order']['note'])){
                    echo '<br/><span>Ghi chú: '.$data['Order']['note'].'</span>';
                }
                echo        '</div>
                <div class="product-total">
                <span>'.$data['Order']['dateCreate']['text'].'</span>
                </div>
                </a>
                <div class="total-price">';
                if($data['Order']['status']==1){
                    echo '<a href="/activeOrderAgency?id='.$data['Order']['id'].'" onclick="return confirm(\'Bạn có chắc chắn muốn duyệt bán đơn hàng này không ?\');"><i class="fa fa-check" aria-hidden="true"></i> Duyệt bán</a> <a href="/refuseOrderAgency?id='.$data['Order']['id'].'" onclick="return confirm(\'Bạn có chắc chắn muốn từ chối đơn hàng này ?\');"><i class="fa fa-trash" aria-hidden="true"></i> Từ chối</a>';
                }
                echo        'Tổng tiền: '.number_format($data['Order']['price']).'đ
                </div>
                </div>';
            }
        }
        ?>
        
        

        <div class="col-sm-12 text-center p_navigation" style="width: 100%; float:left;">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php
                    if ($page > 4) {
                        $startPage = $page - 4;
                    } else {
                        $startPage = 1;
                    }

                    if ($totalPage > $page + 4) {
                        $endPage = $page + 4;
                    } else {
                        $endPage = $totalPage;
                    }
                    ?>
                    <li class="<?php if($page==1) echo'disabled';?>">
                        <a href="<?php echo $urlPage . $back; ?>" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>
                    <?php 
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        if ($i != $page) {
                            echo '  <li><a href="' . $urlPage . $i . '">' . $i . '</a></li>';
                        } else {
                            echo '<li class="active"><a href="' . $urlPage . $i . '">' . $i . '</a></li>';
                        }
                    }
                    ?>
                    <li class="<?php if($page==$endPage) echo'disabled';?>">
                        <a href="<?php echo $urlPage . $next ?>" aria-label="Next">
                            <span aria-hidden="true">»</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</form>
</div>

<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>

<link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css'>
<!-- <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> -->
<script src='//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

<script>
    $(document).ready(function() {
        $('.back-store').click(function(){
            $('.ul_buy').slideToggle();
        });
    });

    $(".datepicker").datepicker({
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

<script>
    $(document).ready(function() {
        $('.back-store').click(function(){
            $('.ul_buy').slideToggle();
        });
    });
</script>
<script>
 $("#showM").on('shown.bs.modal', function(){
  $(this).find('button').focus();
 });
 $(window).on('load',function(){
  $('#showM').modal({show:true});
  $('.modal-dialog').draggable({
   handle: ".modal-header"
  });
 });

 $('input, textarea').blur(function(){
   $(this).val($.trim($(this).val()));
  });
</script>
</body>
</html>
