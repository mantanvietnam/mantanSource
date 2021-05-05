
<?php include('header_nav.php');?>
<style type="text/css" media="screen">
.form-group{
    margin-bottom: 3px;
}
.g_search .col-xs-6{
    padding: 0;
}
.ava_qr{
    float: none;
}
.page-content .qr-item .letter-info, .page-content .qr-item .agency-info{
    float: none;
    padding-left: 0;
}
.ava_qr{
    width: 60px;
    height: 60px;
}
@media screen and (min-width: 768px){
    .ava_qr {
        width: 200px;
        height: 200px;margin-right: 20px;
    }
    .qr-item{
        padding-top: 20px !important;
    }
}
</style>
<div class="container title-page">
    <a href="/agency" class="back">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
    </a>
    <p>Chi tiết Đại lý</p>
</div>

<div class="container page-content agency-list agency1">
   <div class="col-xs-12 col-sm-12 qr-item">
    <div class="ava_qr">
        <img src="<?php echo $data['Agency']['avatar'];?>" class="img-responsive" alt="">
    </div>
    <div class="agency-info-detail">
        <p><strong>Tên đại lý: </strong><?php echo $data['Agency']['fullName'];?></p>
        <p><strong>Cấp đại lý: </strong><?php echo $listLevelAgency[$data['Agency']['level']]['name'];?></p>
        <p><strong>Mã đại lý: </strong><?php echo $data['Agency']['code'];?></p>
        <p><strong>Ngày vào hệ thống: </strong><?php echo $data['Agency']['dateStart']['text'];?></p>

        <?php if($data['Agency']['idAgencyFather']==$_SESSION['infoAgency']['Agency']['id']){ ?>
        <p><strong>Số điện thoại:  </strong><?php echo $data['Agency']['phone'];?></p>
        <p><strong>Email:  </strong><?php echo $data['Agency']['email'];?></p>
        <p><strong>Địa chỉ: </strong><?php echo $data['Agency']['address'];?></p>
        
        
        <div class="total_dt"><strong>Tồn kho hiện tại: </strong>
            <ul class="list-unstyled ul_dt">
                <?php
                if(!empty($listProduct)){
                    foreach($listProduct as $product){
                        echo '<li>'.$product['name'].': '.$product['quantity'].' '.$product['unit'].'</li>';
                    }
                }
                ?>
            </ul>
        </div>

        <div class="total_dt"><strong>Tổng doanh thu theo tháng: </strong>
            <ul class="list-unstyled ul_dt">
                <?php
                    $today= getdate();
                    for($i=1;$i<=$today['mon'];$i++){
                        $total= number_format(@$data['Agency']['walletStatic']['order'][$today['year']][$i]+@$data['Agency']['walletStatic']['introduce'][$today['year']][$i]+@$data['Agency']['walletStatic']['productBonus'][$today['year']][$i]);

                        echo '<li>Tháng '.$i.': <strong>'.$total.'đ</strong></li>';
                    }
                ?>
            </ul>
        </div>
        <?php }?>
    </div>
</div>
</div>


<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>
<script>
    $(document).ready(function() {
        var a = $('.total_dt').innerHeight();
        $('.total_dt::after').css({'height': a});
    });
    
</script>

</body>
</html>
