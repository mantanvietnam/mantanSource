<!-- <!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GAVI Agency Site</title>

    <link href="/app/Plugin/gavi/view/agency/css/bootstrap.min.css" rel="stylesheet">
    <link href="/app/Plugin/gavi/view/agency/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="/app/Plugin/gavi/view/agency/css/mystyle.css" rel="stylesheet">
</head>

<body> -->
    
    <?php include('header_nav.php');?>
    <div class="container title-page">
            <a onclick="" href="/dashboardAgency" class="back">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <p>Tài khoản</p>
    </div>

    <div class="container banner" style="margin-bottom: 5px;">
        <a href="">
            <img src="/app/Plugin/gavi/view/agency/img/banner.png">
        </a>
    </div>

    <div class="container page-content account">
        <div class="">
            <a href="/profile" class="col-xs-12 col-sm-12 item">
                <i class="fa fa-user" aria-hidden="true"></i>
                <p>Xem thông tin cá nhân</p>
            </a>
            <a href="/address" class="col-xs-12 col-sm-12 item">
                <i class="fa fa-location-arrow" aria-hidden="true"></i>
                <p>Xem địa chỉ giao hàng</p>
            </a>
            <a href="/bank" class="col-xs-12 col-sm-12 item">
                <i class="fa fa-university" aria-hidden="true"></i>
                <p>Xem tài khoản ngân hàng</p>
            </a>
            <a href="/changePassword" class="col-xs-12 col-sm-12 item">
                <i class="fa fa-key" aria-hidden="true"></i>
                <p>Đổi mật khẩu</p>
            </a>
            <a href="/logoutAgency" class="col-xs-12 col-sm-12 btn btn-gavi logout">
                Đăng xuất
                <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>

    <script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
    <script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
    <script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
    <script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
    <script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>
</body>
</html>
