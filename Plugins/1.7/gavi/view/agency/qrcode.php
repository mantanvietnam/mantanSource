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

    <style>
    #goTop {
        bottom: 25px;
        cursor: pointer;
        height: 50px;
        position: fixed;
        right: 25px;
        width: 50px;
        z-index: 1000;
        box-shadow: 1px 5px 10px 0px #ccc;
        border-radius: 50%;
        border: 1px solid #ccc;
        background: #fff;
    }
    #goTop i {
        margin-left: 13px;
        margin-top: 10px;
        font-size: 25px;
    }
    .id-qrcode{
        height: 155px;
    }
    .agency-info{
        float: none;
        width: 100%;
    }
    .qr-item{
        height: auto !important
    }
    .qr_l{
        float: left;
    }
    .qr_r{
        float: right;
    }
    .agency-info .agency-level {
    max-width: none;
    overflow: auto;
    text-overflow: inherit;
    white-space: normal;
}
.page-content .qr-item .letter-info p, .page-content .qr-item .agency-info p{
    display: block;
}
    @media screen and (max-width: 767px){
        .qr_r{
            float: left;
            display: block;
        }
    }

</style>
</head>

<body onload=onReady()>

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
    
    <div class="container title-page">

        <a href="/dashboardAgency" class="back">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <p>
            <?php
            switch (@$_GET['status']) {
                case 'done': echo 'Mã QR đã kích hoạt';break;
                case 'active': echo 'Mã QR chờ kích hoạt';break;
                case 'cancel': echo 'Mã QR hết hạn';break;

                default: echo 'Tất cả mã QR';break;
            }
            ?>
        </p>

        <a href="javascript:void(0);" class="back-store"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
        <ul class="list-unstyled ul_buy">
            <li>
                <a href="/qrcode" class="">Tất cả</a>
            </li>
            <li>
                <a href="/qrcode?status=done" class="">Đã kích hoạt</a>
            </li>
            <li>
                <a href="/qrcode?status=active" class="">Chờ kích hoạt</a>
            </li>
            <li>
                <a href="/qrcode?status=cancel" class="">Bị quá hạn</a>
            </li>
        </ul>
        
        <input type="text" id="clipboardText" value="" name="" style="opacity: 0; position: absolute;top:0;left:30px;z-index: -1;">
    </div>

    <div class="container page-content account">
        <div class="">
            <div class="col-xs-12 col-sm-12 item">
                <a href="/createQR" style="display: inline-block;height: 19px;"><i class="fa fa-qrcode" aria-hidden="true"></i>
                    <p class="qr_l">Tạo mã QR kích hoạt đại lý</p></a>
                    <span class="qr_r">*Đại lý phân phối sẽ được tạo ngay khi bạn sử dụng mã QR</span>
                </div>
            </div>
        </div>
        <div class="container page-content account">
            <?php
            if(!empty($listData)){
                foreach($listData as $data){
                    $status= '';
                    $link= '';
                    switch ($data['Qrcode']['status']) {
                        case 'active':  $status= 'Chờ kích hoạt';
                        $link= '<p class="agency-level abc" style="max-width: 100%;"><a href="javascript:void(0);" data-toggle="modal" data-target="#showQR" class="btn btn-gavi" style="line-height: normal; float: left; padding: 5px 10px;" onclick="showCopyLink(\''.$urlHomes.'activeQRCode?code='.$data['Qrcode']['code'].'&idAgencyFather='.$_SESSION['infoAgency']['Agency']['id'].'\')">Sao chép link tạo tài khoản</a></p><p class="agency-level abc"><a href="/cancelQRCodeAgency?id='.$data['Qrcode']['id'].'" onclick="return confirm(\'Bạn có chắc chắn muốn hủy bỏ mã QR này không ?\')">Hủy bỏ mã QR</a></p>';
                        break;
                        case 'done':    $status= 'Đã kích hoạt';
                        $link= '<p class="agency-level abc" style="max-width: 100%;"><a href="javascript:void(0);" data-toggle="modal" data-target="#showQR" class="btn btn-gavi" style="line-height: normal; float: left; padding: 5px 10px;" onclick="showCopyLink(\''.$urlHomes.'createAgency?id='.$data['Qrcode']['idAgencyActive'].'&idQrcode='.$data['Qrcode']['id'].'\')">Sao chép link tạo tài khoản</a></p>';
                        break;
                        case 'cancel': $status= 'Hết hạn';break;
                        case 'delete': $status= 'Bị hủy bỏ';break;
                    }

                    echo '  <div class="col-xs-12 col-sm-12 qr-item" style="">
                    <div id="'.$data['Qrcode']['id'].'" class="id-qrcode"></div>
                    <div class="agency-info agency-no-use">
                    <p>'.$status.'</p>
                    <p class="agency-level"><b>Cấp:</b> '.$listAgency[$data['Qrcode']['level']]['name'].' <b>Mã:</b> '.$data['Qrcode']['code'].'</p>
                    <p class="agency-level"><b>Ngày tạo:</b> '.date('H:i:s d/m/Y',$data['Qrcode']['time']).'</p>
                    <p class="agency-level"><b>Hết hạn:</b> '.date('H:i:s d/m/Y',$data['Qrcode']['deadline']).'</p>
                    '.$link.'</p>
                    </div>
                    </div>';
                }
            }
            ?>
        </div>



        <div class="col-sm-12 text-center p_navigation">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php
                    if ($page > 4) {
                        $startPage = $page - 4;
                    } else {
                        $startPage = 1;
                    }

                    if ($totalPage > $page + 4) {
                        $endPage = $page + 4;
                    } else {
                        $endPage = $totalPage;
                    }
                    ?>
                    <li class="<?php if($page==1) echo'disabled';?>">
                        <a href="<?php echo $urlPage . $back; ?>" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>
                    <?php 
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        if ($i != $page) {
                            echo '  <li><a href="' . $urlPage . $i . '">' . $i . '</a></li>';
                        } else {
                            echo '<li class="active"><a href="' . $urlPage . $i . '">' . $i . '</a></li>';
                        }
                    }
                    ?>
                    <li class="<?php if($page==$endPage) echo'disabled';?>">
                        <a href="<?php echo $urlPage . $next ?>" aria-label="Next">
                            <span aria-hidden="true">»</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div id="showQR" class="modal fade in" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Link kích hoạt</h4>
            </div>
            <div class="modal-body">
                <div class="showMess" id="contentShow"></div>
                <p class="agency-level" style="max-width: 100%;"><a href="javascript:void(0);" id="buttonCoppy" onclick="" class="btn btn-gavi" style="line-height: normal; padding: 5px 10px; margin-top:10px;">Sao chép link tạo tài khoản</a></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
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
        $('.back-store').click(function(){
            $('.ul_buy').slideToggle();
        });
    });
</script>

<script type="text/javascript">
    function onReady()
    {
        <?php
        if(!empty($listData)){
            foreach($listData as $data){
                echo 'var qrcode = new QRCode("'.$data['Qrcode']['id'].'",{  text:"'.$urlHomes.'activeQRCode?code='.$data['Qrcode']['code'].'&idAgencyFather='.$_SESSION['infoAgency']['Agency']['id'].'",
                height: "155",
                width: "155",
                colorDark:"#000000",
                colorLight:"#ffffff",
                correctLevel:QRCode.CorrectLevel.H
            }
        );';
    }
}
?>
}
</script>

<script>
    $(document).ready(function() {
        var w =$(window).innerWidth();
        if(w<768){
                // $('.qr-item').css({'height': '290px'});
                $('.agency-info').css({'padding-left': '0', 'margin-top': '10px'});
                // $('.agency-info .agency-level').css({'max-width': '100%'});
            } else{
                // $('.qr-item').css({'height': '172px'});
                // $('.agency-info .agency-level').css({'max-width': '300px'});

            }

            $('.abc a').css({'line-height': 'normal', 'float': 'left', 'padding': '5px 10px'});
            $('.abc a').addClass('btn btn-gavi');
        });
    </script>
    <script type="text/javascript">
        function copyLink(url)
        {
            var clipboardText = document.getElementById("clipboardText");
            clipboardText.value= url;
            clipboardText.select();
            document.execCommand("Copy");
            alert("Sao chép thành công đường dẫn vào bộ nhớ máy");
        }

        function showCopyLink(url)
        {
            $('#contentShow').html(url);
            $('#buttonCoppy').attr('onclick','copyLink(\''+url+'\')');
        }


    </script>

</body>
</html>
