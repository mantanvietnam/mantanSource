
    <?php include('header_nav.php');?>

    <style type="text/css" media="screen">
    .col-xs-4{
        padding: 0;
    }
    label{
        margin: 4px 0;
    }
    .revenue{
        padding-left: 15px;
        padding-right: 15px;
    }
    .col-sm-12{
        padding: 0 2px;
    }
    .r_item1{
        margin-bottom: 5px;
        padding: 5px 8px;
        border: 1px solid #e9ebee;
    }
    .r_item_c1{
        margin-left: 30px;
        position: relative;
        color: #f9561b;
    }
    .r_item_c1.r_item1:after {
        content: '';
        border-top: 1px dotted #afafaf;
        display: inline-block;
        position: absolute;
        width: 12px;
        left: -15px;
        top: 48%;
    }
    .r_item1.a{
        position: relative;
    }
    .r_item1.a:after{
        content: '';
        display: inline-block;
        border-left: 1px dotted #afafaf;
        position: absolute;
        height: 116px;
        left: 13px;
        top: 100%;
    }
    .b_red{
        background: #f9561b;
        color: white;
    }
    .r_item_c1 span{
        color: black;
    }

</style>
<div class="container title-page">
        <a onclick="" href="/dashboardAgency" class="back">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
    </a>
    <p>Doanh thu</p>
</div>
<!-- <div class="container g_search">
    <form action="" method="get" accept-charset="utf-8">
        <div class="form-group col-xs-6 col-sm-4">
            <input type="text" class="form-control datepicker" placeholder="Từ ngày" name="">
        </div>
        <div class="form-group col-xs-6 col-sm-4">
            <input type="text" class="form-control datepicker" placeholder="Đến ngày" name="">
        </div>
        <div class="form-group col-xs-6 col-sm-4">
            <input type="submit" class="btn btn-gavi1" value="Tìm kiếm" name="">
        </div>
    </form>
</div> -->

<div class="container revenue">
    <div class="row">
        <div class="col-sm-12 r_item" style="padding:2px;">
            <div class="form-group" style="margin-bottom: 10px;">
                <form action="" method="get" name="" id="changeMonth">
                    <select name="months" class="form-control" onchange='document.getElementById("changeMonth").submit();'>
                        <?php
                        $today= getdate();

                        if(empty($_GET['months'])){
                            $_GET['months']= $today['mon'];
                        }

                        for($i=1;$i<=12;$i++){
                            if(empty($_GET['months']) || $_GET['months']!=$i){
                                echo '<option value="'.$i.'">Tháng '.$i.'/'.$today['year'].'</option>';
                            }else{
                                echo '<option selected value="'.$i.'">Tháng '.$i.'/'.$today['year'].'</option>';
                            }
                        }
                        ?>
                    </select>
                </form>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="r_item1 a b_red">
                <label>Tổng thu nhập: <?php echo number_format(@$agency['Agency']['walletStatic']['profit'][$today['year']][$_GET['months']]+@$agency['Agency']['walletStatic']['introduce'][$today['year']][$_GET['months']]+@$agency['Agency']['walletStatic']['productBonus'][$today['year']][$_GET['months']]);?>đ</label>
            </div>
            <div class="r_item_c">
                <div class="r_item_c1 r_item1">
                    <label>Lãi bán hàng: </label>
                    <span><?php echo number_format(@$agency['Agency']['walletStatic']['profit'][$today['year']][$_GET['months']]);?>đ</span>
                </div>
                <div class="r_item_c1 r_item1">
                    <label>Hoa hồng giới thiệu: </label>
                    <span><?php echo number_format(@$agency['Agency']['walletStatic']['introduce'][$today['year']][$_GET['months']]);?>đ</span>
                </div>
                <div class="r_item_c1 r_item1">
                    <label>Thưởng phát triển đại lý: </label>
                    <span><?php echo number_format(@$agency['Agency']['walletStatic']['productBonus'][$today['year']][$_GET['months']]);?>đ</span>
                </div>
                <!--
                <div class="r_item_c1 r_item1">
                    <label>Tiền phạt: </label>
                    <span><?php echo number_format(@$agency['Agency']['walletStatic']['penalties'][$today['year']][$_GET['months']]);?>đ</span>
                </div>
                -->
            </div>
            <div class="r_item1 b_red">
             <label>Tổng doanh thu: <?php echo number_format(@$agency['Agency']['walletStatic']['order'][$today['year']][$_GET['months']]+@$agency['Agency']['walletStatic']['introduce'][$today['year']][$_GET['months']]+@$agency['Agency']['walletStatic']['productBonus'][$today['year']][$_GET['months']]);?>đ</label>
         </div>
     </div>

 </div>

</div>

<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>

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
