
<?php include('header_nav.php');?>
<style type="text/css" media="screen">
.page-content .qr-item{
    height: auto;
}
.g_search .col-xs-6{
    padding: 0;
}
.form-group{
    margin-bottom: 3px;
}
</style>

<div class="container title-page">
    <a onclick="" href="/wallet" class="back">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
    </a>
    <p>Lịch sử chia kho</p>

</div>

<div class="container g_search">
    <form action="" method="get" accept-charset="utf-8">
        <div class="form-group col-xs-6 col-sm-3">
            <input type="text" class="form-control datepicker" placeholder="Từ ngày" name="dateStart" value="<?php echo @$_GET['dateStart'];?>">
        </div>
        <div class="form-group col-xs-6 col-sm-3">
            <input type="text" class="form-control datepicker" placeholder="Đến ngày" name="dateEnd" value="<?php echo @$_GET['dateEnd'];?>">
        </div>
        <div class="form-group col-xs-6 col-sm-3">
            <input type="text" class="form-control" placeholder="SĐT đại lý" name="phoneAgency" value="<?php echo @$_GET['phoneAgency'];?>">
        </div>
        <div class="form-group col-xs-6 col-sm-3">
            <input type="submit" class="btn btn-gavi1" value="Tìm kiếm" name="">
        </div>
    </form>
</div>
<?php
    if(!empty($listData)){
        $modelAgency= new Agency();
        $modelProduct= new Product();
        $listProduct= array();
        foreach($listData as $data){
            $infoAgency= $modelAgency->getAgencyByCode($data['Order']['codeAgency'],array('fullName','phone','code','level'));
            $start= array();
            if(!empty($data['Order']['productAgency']['start'])){
                foreach($data['Order']['productAgency']['start'] as $idProduct=>$number){
                    if(empty($listProduct[$idProduct])){
                        $listProduct[$idProduct]= $modelProduct->getProduct($idProduct);
                    }

                    if(!empty($listProduct[$idProduct])){
                        $start[]= $listProduct[$idProduct]['Product']['name'].'('.number_format($number).')';
                    }
                }
            }

            $end= array();
            if(!empty($data['Order']['productAgency']['end'])){
                foreach($data['Order']['productAgency']['end'] as $idProduct=>$number){
                    if(empty($listProduct[$idProduct])){
                        $listProduct[$idProduct]= $modelProduct->getProduct($idProduct);
                    }

                    if(!empty($listProduct[$idProduct])){
                        $end[]= $listProduct[$idProduct]['Product']['name'].'('.number_format($number).')';
                    }
                }
            }
            echo '<div class="container page-content agency-list">
                    <div class="col-xs-12 col-sm-12 qr-item">
                        <div class="agency-info">
                            <p style="display: inline-block;">C'.$infoAgency['Agency']['level'].'.'.$infoAgency['Agency']['fullName'].' - '.$infoAgency['Agency']['phone'].' ('.$infoAgency['Agency']['code'].')</p>
                            <p class="">Thời gian chia: '.$data['Order']['dateCreate']['text'].'</p>
                            <p class="">Số lượng trước khi chia: '.implode(', ', $start).'</p>
                            <p class="">Số lượng sau khi chia: '.implode(', ', $end).'</p>
                        </div>
                    </div>
                </div>';
        }
    }
?>

<div class="col-sm-12 text-center p_navigation">
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







<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>

<script src="https://www.jqueryscript.net/demo/Easy-jQuery-Input-Mask-Plugin-inputmask/dist/jquery.inputmask.bundle.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ace-elements.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ace.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/jquery.maskedinput.min.js"></script>

<link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css'>
<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
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
</body>
</html>
