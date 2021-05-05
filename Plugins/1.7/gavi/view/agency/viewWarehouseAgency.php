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
            <a href="/listOrderBuy" class="back">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <p>Kho hàng</p>
    </div>

    <div class="container home-block">
        <a href="/historyDivineStore">
            <div class="col-xs-4 col-sm-4 item">
                <div class="bg_item"></div>
                <i class="fa fa-history"></i>
                <p>Lịch sử chia kho</p>
            </div>
        </a>
        <a href="/addOrder">
            <div class="col-xs-4 col-sm-4 item">
                <div class="bg_item"></div>
                <i class="fa fa-plus"></i>
                <p>Thêm hàng</p>
            </div>
        </a>
        <a href="/addShip">
            <div class="col-xs-4 col-sm-4 item">
                <div class="bg_item"></div>
                <i class="fa fa-random" aria-hidden="true"></i>
                <p>Chuyển hàng</p>
            </div>
        </a>
        <!-- <a href="/addOrder">
            <div class="col-xs-4 col-sm-4 item">
                <div class="bg_item"></div>
                <i class="fa fa-plus" aria-hidden="true">
                <p>Thêm hàng</p>
            </div>
        </a>
        <a href="/addShip">
            <div class="col-xs-4 col-sm-4 item">
                <div class="bg_item"></div>
                <i class="fa fa-random" aria-hidden="true"></i> 
                <p>Chuyển hàng</p>
            </div>
        </a> -->
    </div>

    <div class="container page-content letter-list stores-list">
        <?php
        if(!empty($listProduct)){
            foreach($listProduct as $product){
                echo '  <a target="_blank" href="'.$product['image'].'" class="col-xs-12 col-sm-12 item">
                <span>'.$product['name'].' - '.'</span>
                <span class="status" style="color:gray;">'.$product['quantity'].' '.$product['unit'].'</span>
                </a>';
            }
        }
        ?>
    </div>

    

    <script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
    <script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
    <script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
    <script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
    <script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>
</body>
</html>
