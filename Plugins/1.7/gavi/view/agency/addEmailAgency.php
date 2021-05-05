    <?php include('header_nav.php');?>
    
    <div class="container title-page">
        <a href="/listEmailAgency" class="back">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <p>Gửi thư</p>
    </div>

    
        <div class="container page-content">
          <form action="" method="post">
            <div class="col-xs-12 col-sm-12 agency-detail">
                <div class="letter-content">
                		<div class="form-group">
                        <input type="text" class="checkvalue form-control" name="subject" placeholder="Tiêu đề*" required="">
                    </div>
                    <div class="form-group">
                      <textarea class="checkvalue form-control" name="content" placeholder="Nội dung*" required=""></textarea>
                    </div>
                </div>
                <div class="letter-footer">
                    <button type="submit" data-loading-text="Loading..." class="btn btn-gavi width-100" autocomplete="off">
                        <i class="fa fa-paper-plane" aria-hidden="true"></i> Gửi thư
                    </button>
                </div>
            </div>
          </form>
        </div>
    



<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>

</body>
</html>
