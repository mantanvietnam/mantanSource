<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/header.php'; ?>

<section role="main" class="content-body" id="fullscreen">

<!-- start: page -->

<section class="panel">
    <ul class="title_p list-inline">
        <li><a href="/addMoney"><i class="fa fa-home"></i> Nạp tiền</a></li>
        <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
        <li>Chuyển khoản ngân hàng</li>
    </ul>
    
    <div class="panel-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12">
                <p><b>Ngân hàng:</b> TP Bank</p>
                <p onclick="copyToClipboard('stk','mess')"><b>Số tài khoản:</b> <span id="stk">06931228001</span> <i class="fa fa-clone" aria-hidden="true"></i></p>
                <p><b>Chủ tài khoản:</b> Trần Ngọc Mạnh</p>
                <p><b>Số tiền nạp:</b> <?php echo number_format($_SESSION['numberAddMoney']);?>đ</p>
                <p onclick="copyToClipboard('contentPay','mess')">Nội dung chuyển tiền: <b id="contentPay"><?php echo $_SESSION['infoManager']['Manager']['phone'];?> quay so</b> <i class="fa fa-clone" aria-hidden="true"></i></p>
                <p>Vui lòng nhập đúng nội dung chuyển tiền, nhập sai không được cộng tiền chúng tôi không chịu trách nhiệm.</p>
                <p id="mess" style="color: red;"></p>
            </div>
        </div>
        
    </div>
</section>

<!-- end: page -->
</section>

<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/footer.php'; ?>