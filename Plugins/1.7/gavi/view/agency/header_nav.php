<!DOCTYPE html>
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

<!-- <style>
body{
    background: #2f3235;
}
.home-block .item {
    border-right: 2px solid #2f3235;
    border-left: 2px solid #2f3235;
}
.wallet-total {
    border-left: 5px solid #2f3235;
    border-right: 5px solid #2f3235;
}
</style> -->

<body>

    <nav class="navbar navbar-fixed-bottom footer-nav" role="navigation">
        <div class="container">
            <div id="navbar">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="/dashboardAgency" class="<?php if(!empty($tabFooter) && $tabFooter=='dashboardAgency') echo 'active';?>">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span>Trang chủ</span>
                        </a>
                    </li>
                    <li>
                        <a href="/viewWarehouseAgency" class="<?php if(!empty($tabFooter) && $tabFooter=='viewWarehouseAgency') echo 'active';?>">
                            <i class="fa fa-industry" aria-hidden="true"></i>
                            <span>Kho hàng</span>
                        </a>
                    </li>
                    <li>
                        <a href="/listEmailAgency" class="<?php if(!empty($tabFooter) && $tabFooter=='listEmailAgency') echo 'active';?>">
                            <i class="fa fa-envelope-o " aria-hidden="true"></i>
                            <span>Tin nhắn</span>
                        </a>
                    </li>
                    <li>
                        <a href="/account" class="<?php if(!empty($tabFooter) && $tabFooter=='account') echo 'active';?>">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                            <span>Tài khoản</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>