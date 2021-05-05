    <?php include('header_nav.php');?>
    
    <div class="container title-page">
        <a href="/dashboardAgency" class="back">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <p>Hộp thư</p>
        

        <a href="javascript:void(0);" class="back-store"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
        <ul class="list-unstyled ul_buy">
            <li>
                <a href="/addEmailAgency" class=""><i class="fa fa-plus"></i> Tạo thư mới</a>
            </li>
        </ul>
    </div>

    <div class="container sub-title store">
        <li class="col-xs-4 col-md-4 <?php if(empty($_GET['type'])) echo 'current-tab';?> "><a href="/listEmailAgency">Thông báo (<?php echo number_format($numberNotification);?>)</a></li>
        <li class="col-xs-4 col-md-4 <?php if(!empty($_GET['type']) && $_GET['type']=='inbox') echo 'current-tab';?> "><a href="/listEmailAgency?type=inbox">Hộp thư đến (<?php echo number_format($numberInbox);?>)</a></li>
        <li class="col-xs-4 col-md-4 <?php if(!empty($_GET['type']) && $_GET['type']=='sent') echo 'current-tab';?> "><a href="/listEmailAgency?type=sent">Hộp thư đi</a></li>
    </div>

    <div class="container page-content letter-list c_b">
        <?php
            if(!empty($listData)){
                foreach($listData as $data){
                    $type= '';
                    switch($data['Email']['type']){
                        case 'system': $type= 'Thông báo tự động';break;
                        case 'agency': $type= 'Quản trị viên';break;
                        case 'all': $type= 'Thông báo chung';break;
                    }
                    if(!in_array($_SESSION['infoAgency']['Agency']['id'], $data['Email']['listView'])){
                        $subject= '<b>'.$data['Email']['subject'].'</b>';
                    }else{
                        $subject= $data['Email']['subject'];
                    }

                    echo '  <a href="/viewEmailAgency?id='.$data['Email']['id'].'" class="col-xs-12 col-sm-12 item">
                                <table>
                                    <tr>
                                        <td width="30%">'.$type.'</td>
                                        <td width="60%" style="padding: 0 5px;">'.$subject.'</td>
                                        <td width="10%">'.date('d/m/Y',$data['Email']['time']).'</td>
                                    </tr>
                                </table>
                            </a>';
                }
            }
        ?>
    	
        
        <div class="col-sm-12 text-center p_navigation" style="width: 100%;float: left;">
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
    </div>

</div>


<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>

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

<script>
    $(document).ready(function() {
        $('.back-store').click(function(){
            $('.ul_buy').slideToggle();
        });
    });
</script>
</body>
</html>
