    <?php include('header_nav.php');?>
    
    <div class="container title-page">
        <a href="/listEmailAgency" class="back">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <p>Chi tiết thư</p>
    </div>

    <div class="container page-content">
        <div class="col-xs-12 col-sm-12 agency-detail">
            <label><?php echo $data['Email']['subject'];?></label>
            <div class="letter-content">
                <div class="info_l">
                    <label>Người gửi: <?php echo $data['Email']['nameFrom'];?>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        Ngày gửi: <?php echo date('d/m/Y',$data['Email']['time']);?></label>
                </div>
            </div>
            <div class="letter-info">
            	<?php echo nl2br($data['Email']['content']);?>
            </div>

            <?php
                if(!empty($data['Email']['reply'])){
                    foreach($data['Email']['reply'] as $reply){
                        echo '  <div class="letter-content">
                                    <div class="info_l">
                                        <label>Người gửi: '.$reply['nameFrom'].'
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            Ngày gửi: '.date('d/m/Y',$reply['time']).'</label>
                                    </div>
                                </div>
                                <div class="letter-info">'.nl2br($reply['content']).'</div>';
                    }
                }
            ?>
            <?php if($data['Email']['type']=='agency'){ ?>
            <form action="" method="post">
                <div class="letter-content">
                    <div class="form-group">
                        <textarea class="form-control" name="content" placeholder="Nội dung phản hồi" required=""></textarea>
                    </div>
                </div>

                <div class="letter-footer">
                    <button type="submit" data-loading-text="Loading..." class="btn btn-gavi width-100" autocomplete="off">
                        <i class="fa fa-paper-plane" aria-hidden="true"></i> Gửi trả lời
                    </button>
                </div>
            </form>
            <?php }?>
     </div>
 </div>

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

<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>

</body>
</html>
