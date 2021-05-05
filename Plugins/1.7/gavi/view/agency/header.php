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

<style>
body{
    background: #2f3235;
}
.home-block .item {
    border-right: 2px solid #2f3235;
    border-left: 2px solid #2f3235;
    /*opacity: 0.9;*/
}
.wallet-total {
    border-left: 5px solid #2f3235;
    border-right: 5px solid #2f3235;
    width: 100%;
    display: inline-flex;
    display: -webkit-inline-flex;
    display: -ms-inline-flexbox;
}
.ava_in{
    margin-top: 11px;
    float: left;
    background: white;
}
.info_per{

}
.wallet-total.ab span{
    color: black;
    font-size: 13px;
}
.wallet-total .agency-name{
    margin-top: 5px;
}
.a_logout{
    float: right;
    border: 1px solid white;
    padding: 4px 7px;
    border-radius: 10px;
    margin-right: 5px;
    font-size: 11px;
    margin-top: 4px;
}
</style>


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
    
    <div class="container header">
    </div>
    <div class="container">
        <div class=" wallet-total ab">
            <div class="ava_qr ava_in">
                <img src="<?php echo (!empty($_SESSION['infoAgency']['Agency']['avatar']))?$_SESSION['infoAgency']['Agency']['avatar']:'/app/Plugin/gavi/view/agency/img/avatar.png';?>" class="img-responsive" alt="">
            </div>
            <div class="info_per">
                <?php $listConfigAgency= getListAgency();?>
                <label class="agency-name"><?php echo $_SESSION['infoAgency']['Agency']['fullName'];?> </label>
                <span><?php echo $_SESSION['infoAgency']['Agency']['phone'];?></span> <a class="a_logout" href="/logoutAgency" style="color:white;">Đăng xuất</a><br>
                <span><?php echo $_SESSION['infoAgency']['Agency']['code'].' - '.$listConfigAgency[$_SESSION['infoAgency']['Agency']['level']]['name'];?> </span>
                <br>

                <span>Số dư tài khoản:</span>
                <?php
                $totalMoney= @$_SESSION['infoAgency']['Agency']['wallet']['deposit']+@$_SESSION['infoAgency']['Agency']['wallet']['purchaseFund']+$_SESSION['infoAgency']['Agency']['wallet']['active']-@$_SESSION['infoAgency']['Agency']['wallet']['penalties'];

                echo '<span style="color:white;">'.number_format($totalMoney).'đ </span>';
                ?>
            </div>

        </div>
    </div>
</div>
</div>