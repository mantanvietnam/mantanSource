    <?php include('header_nav.php');?>
    
    <div class="container title-page">
        <a href="/dashboardAgency" class="back">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <p>Chứng nhận nhà phân phối Gavi+</p>
        <a target="_blank" download href="<?php echo '/app/webroot/upload/shield/'.$_SESSION['infoAgency']['Agency']['code'].'.png?time='.time();?>" class="back-store"><i class="fa fa-download" aria-hidden="true"></i></a>
    </div>

    <div class="container page-content account">
        <div class="shield">
            <img src="<?php echo '/app/webroot/upload/shield/'.$_SESSION['infoAgency']['Agency']['code'].'.png?time='.time();?>">
        </div>
    </div>

    <script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
    <script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
    <script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
    <script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
    <script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>
</body>
</html>
