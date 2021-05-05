
    <?php include('header_nav.php');?>


    <div class="container title-page">
            <a onclick="" href="/listShip" class="back">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </a>
            <p>Thông tin yêu cầu chuyển hàng</p>
        </div>

        <div class="container page-content">
            <div class="col-xs-12 col-sm-12 agency-detail">
                <div class="letter-content input_border_b">
                    
                <form action="" method="post">
                    <div class="form-group">
                        <label class="control-label" for="">Mã yêu cầu: </label>
                        <input disabled="" class="form-control" id="" type="text" value="<?php echo $data['Ship']['code'];?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="">Trạng thái xử lý: </label>
                        <input disabled="" class="form-control" id="" type="text" value="<?php echo $listStatusShip[$data['Ship']['status']]['name'];?>">  
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="">Tên người nhận: </label>
                        <input disabled="" class="form-control" id="" type="text" value="<?php echo $data['Ship']['address']['name'];?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="">Địa chỉ nhận: </label>
                        <input disabled="" class="form-control" id="" type="text" value="<?php echo $data['Ship']['address']['address'];?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="">Điện thoại người nhận: </label>
                        <input disabled="" class="form-control" id="" type="text" value="<?php echo $data['Ship']['address']['phone'];?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="">Ngày giao hàng: </label>
                        <input disabled="" class="form-control" id="" type="text" value="<?php echo $data['Ship']['address']['date'];?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="">Số tiền cần thu: </label>
                        <input disabled="" class="form-control" id="" type="text" value="<?php echo number_format($data['Ship']['money']);?>đ">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="">Phí vận chuyển: </label>
                        <input disabled="" class="form-control" id="" type="text" value="<?php echo number_format($data['Ship']['moneyShip']);?>đ">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="">Phí phạt trả hàng: </label>
                        <input disabled="" class="form-control" id="" type="text" value="<?php echo number_format($data['Ship']['moneyPenalties']);?>đ">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="">Sản phẩm: </label>
                        <?php
                        if(!empty($data['Ship']['product'])){
                            foreach($data['Ship']['product'] as $product){
                                echo '<p>'.$product['name'].' : '.$product['quantily'].'</p>';
                            }
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="">Thông báo của admin: </label>
                        <textarea disabled="" class="form-control col-md-7 col-xs-12"><?php echo $data['Ship']['note'];?></textarea>
                    </div>
                </form>
      </div>
      
  </div>
</div>

<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>

<link rel='stylesheet prefetch' href='/app/Plugin/gavi/view/agency/css/jquery-ui.css'>
<script src='/app/Plugin/gavi/view/agency/js/jquery-ui.min.js'></script>
<link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css'>
<script src='//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

</body>
</html>
