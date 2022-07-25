<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/header.php'; ?>

<section role="main" class="content-body" id="fullscreen">

<!-- start: page -->

<section class="panel">
    <ul class="title_p list-inline">
        <li><a href="/addMoney"><i class="fa fa-home"></i> Nạp tiền</a></li>
        <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
        <li>Ví MoMo</li>
    </ul>
    
    <div class="panel-body">
        <div class="row text-center">
            <p>Mở ứng dụng MoMo trên điện thoại và quét mã QR thanh toán</p>
            
            <img width="150" id="qrcode" src="https://api.qrserver.com/v1/create-qr-code/?size=500x500&amp;data=2|99|0816560000|||0|0|<?php echo $_SESSION['numberAddMoney']?>" width="100%">

            <p onclick="copyToClipboard('contentPay','mess')">Nội dung chuyển tiền: <b id="contentPay"><?php echo $_SESSION['infoManager']['Manager']['phone'];?> quay so</b> <i class="fa fa-clone" aria-hidden="true"></i></p>
            <p>Vui lòng nhập đúng nội dung chuyển tiền, nhập sai không được cộng tiền chúng tôi không chịu trách nhiệm.</p>
            <p id="mess" style="color: red;"></p>
        </div>
        
    </div>
</section>

<!-- end: page -->
</section>

<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/footer.php'; ?>