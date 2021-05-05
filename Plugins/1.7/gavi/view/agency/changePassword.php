
    <?php include('header_nav.php');?>

    
    <div class="container title-page">
            <a onclick="" href="/account" class="back">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </a>
            <p>Đổi mật khẩu</p>
        </div>

        <div class="container page-content">
            <div class="col-xs-12 col-sm-12 agency-detail">
                <div class="letter-content input_border_b">
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
                            <button type="button" class="btn btn-default setfocus" data-dismiss="modal" autofocus>Đóng</button>
                        </div>
                    </div>

                </div>
            </div>
            <?php }?>
            <form action="" method="post">
                <div class="form-group">
                    <label class="control-label" for="">Mật khẩu cũ<span class="required">*</span>: </label>
                    <input name="passOld" required="required" class="form-control" id="" maxlength="255" type="password" value="">
                </div>
                <div class="form-group">
                    <label class="control-label" for="">Mật khẩu mới<span class="required">*</span>: </label>
                    <input name="pass" required="required" class="form-control" id="" maxlength="255" type="password" value="">
                </div>
                <div class="form-group">
                    <label class="control-label" for="">Nhập lại mật khẩu mới<span class="required">*</span>: </label>
                    <input name="passAgain" required="required" class="form-control" id="" maxlength="255" type="password" value="">
                </div>

                <div class="letter-footer">
                    <button type="submit" data-loading-text="Loading..." class="btn btn-gavi width-100" autocomplete="off">
                      <i class="fa fa-paper-plane" aria-hidden="true"></i> Lưu
                  </button>
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

</body>
</html>
