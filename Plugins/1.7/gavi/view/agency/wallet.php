<?php include('header.php');?>
<style type="text/css" media="screen">
.home-block .item{
    height: 100px;
}
.item li em{
    color: black;
    font-style: normal;
}
</style>
<div class="container home-block">
    <div class="">
        <a href="/pay">
            <div class="col-xs-4 item">
                <i class="fa fa-gavel" aria-hidden="true"></i>
                <p>Rút tiền</p>
            </div>
        </a>
        <a href="/walletAddMoney">
            <div class="col-xs-4 item">
                <i class="fa fa-bullhorn" aria-hidden="true"></i>
                <p>Thông báo nạp tiền</p>
            </div>
        </a>
        <a href="/walletHistory">
            <div class="col-xs-4 item">
                <i class="fa fa-history" aria-hidden="true"></i>
                <p>Lịch sử</p>
            </div>
        </a>
        <!-- <a href="/listPay">
            <div class="col-xs-12 item" style="text-align: left;padding-top: 12px; height: auto">
                <ul class="list-unstyled">
                    <li>Danh sách yêu cầu rút tiền</li>
                </ul>
            </div>
        </a> -->
        
        <div class="col-xs-12 item" style="text-align: left;padding-top: 12px;height:auto;">
            <ul class="list-unstyled">
                <!--
                <li><em>Tiền chờ rút:</em> <?php echo number_format(@$agency['Agency']['wallet']['request']); ?> đ</li>
                <li><em>Tiền mua hàng bị đóng băng:</em> <?php echo number_format(@$agency['Agency']['wallet']['order']); ?> đ</li>
                <li><em>Tiền tạo mã QR bị đóng băng:</em> <?php echo number_format(@$agency['Agency']['wallet']['qrcode']); ?> đ</li>
                <li><em>Tiền bán hàng đợi kế toán duyệt:</em> <?php echo number_format(@$agency['Agency']['wallet']['waitingOrder']); ?> đ</li>
                <li><em>Tiền thưởng phát triển đại lý đợi duyệt:</em> <?php echo number_format(@$agency['Agency']['wallet']['waitingBonus']); ?> đ</li>
                <li><em>Tiền thường giới thiệu đại lý đợi duyệt:</em> <?php echo number_format(@$agency['Agency']['wallet']['waitingQRBonus']); ?> đ</li>
                <li><em>Tiền giao hàng nhờ thu hộ:</em> <?php echo number_format(@$agency['Agency']['wallet']['waitingShip']); ?> đ</li>
                <li><em>Tổng tiền mặt đã nạp vào hệ thống:</em> <?php echo number_format(@$agency['Agency']['wallet']['recharge']); ?> đ</li>
                -->
                <li><em>Tiền đặt cọc:</em> <?php echo number_format(@$agency['Agency']['wallet']['deposit']); ?> đ</li>
                <li><em>Quỹ mua hàng:</em> <?php echo number_format(@$agency['Agency']['wallet']['purchaseFund']); ?> đ</li>
                <li><em>Tiền được rút:</em> <?php echo number_format(@$agency['Agency']['wallet']['active']); ?> đ</li>
            </ul>
        </div>
    </div>
</div>

<?php include('footer.php');?>
