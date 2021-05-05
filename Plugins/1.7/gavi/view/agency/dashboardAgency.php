<?php include('header.php');?>

    <div class="container home-block">
        <div class="">
            <a href="/wallet">
                <div class="col-xs-4 col-sm-4 item" style="z-index: 1;box-shadow: 1px 4px 10px 3px rgba(128, 128, 128, 0.82);">
                    <!-- <i class="fa fa-google-wallet" aria-hidden="true"></i> -->
                    <img src="/app/Plugin/gavi/view/agency/img/icon_vdt.png" class="img-responsive" alt="" style="height: 44px;margin-bottom: -10px;">
                    <p>Ví tiền</p>
                </div>
            </a>
            <a href="/revenue">
                <div class="col-xs-4 col-sm-4 item">
                    <div class="bg_item"></div>
                    <!-- <i class="fa fa-envelope-o " aria-hidden="true"></i> -->
                    <img src="/app/Plugin/gavi/view/agency/img/icon_dt.png" class="img-responsive" alt="" style="height: 44px;margin-bottom: -10px;">
                    <p>Doanh thu</p>
                </div>
            </a>
            
            <a href="/agency">
                <div class="col-xs-4 col-sm-4 item">
                    <div class="bg_item"></div>
                    <!-- <i class="fa fa-user-secret" aria-hidden="true"></i> -->
                    <img src="/app/Plugin/gavi/view/agency/img/icon_dl.png" class="img-responsive" alt="" style="    height: 50px;margin-bottom: -14px;">
                    <p>Đại lý</p>
                </div>
            </a>
            <a href="/listOrderBuy">
                <div class="col-xs-4 col-sm-4 item">
                    <div class="bg_item"></div>
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <p>Đơn mua</p>
                </div>
            </a>
            <a href="/listShip">
                <div class="col-xs-4 col-sm-4 item">
                    <div class="bg_item"></div>
                    <i class="fa fa-truck" aria-hidden="true"></i>
                    <p>Ship hàng</p>
                </div>
            </a>
            <a href="/listOrderSell">
                <div class="col-xs-4 col-sm-4 item">
                    <div class="bg_item"></div>
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                    <p>Đơn bán</p>
                </div>
            </a>
            <a href="/account">
                <div class="col-xs-4 col-sm-4 item">
                    <div class="bg_item"></div>
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <p>Cài đặt</p>
                </div>
            </a>
            <a href="/shield">
                <div class="col-xs-4 col-sm-4 item">
                    <div class="bg_item"></div>
                    <!-- <i class="fa fa-shield" aria-hidden="true"></i> -->
                    <img src="/app/Plugin/gavi/view/agency/img/icon_cn.png" class="img-responsive" alt="">
                    <p>Chứng nhận</p>
                </div>
            </a>
            <a href="/qrcode">
                <div class="col-xs-4 col-sm-4 item">
                    <div class="bg_item"></div>
                    <i class="fa fa-qrcode" aria-hidden="true"></i>
                    <p>Mã QR</p>
                </div>
            </a>
        </div>
    </div>
<?php if(!empty($mess)){ ?>
            <div id="showM" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thông báo</h4>
                </div>
                <div class="modal-body">
                    <div class="showMess"><?php echo $mess; ?></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>

        </div>
    </div>
    <?php }?>
<?php include('footer.php');?>
