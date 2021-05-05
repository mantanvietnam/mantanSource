
<?php include('header_nav.php');?>
<style type="text/css" media="screen">
.agency-info .agency-level{
    max-width: none;
    overflow: hidden;
        text-overflow: inherit;
    white-space: normal;
}
</style>

<div class="container title-page">
    <a href="/wallet" class="back">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
    </a>
    <p>Lịch sử thông báo nạp tiền</p>
</div>


<div class="container g_search">
    <form action="" method="get" accept-charset="utf-8">
        <div class="form-group col-xs-6">
            <select name="idStatus" placeholder="--Trạng thái--" class="form-control">
                <option value="">--Trạng thái--</option>
                <?php
                    $getStatusDefault= getStatusDefault();
                    foreach($getStatusDefault as $status){
                        if(empty($_GET['idStatus']) || $_GET['idStatus']!=$status['id']){
                            echo '<option value="'.$status['id'].'">'.$status['name'].'</option>';
                        }else{
                            echo '<option selected value="'.$status['id'].'">'.$status['name'].'</option>';
                        }
                    }
                ?>
            </select>
        </div>
        <div class="form-group col-xs-6">
            <input type="submit" class="btn btn-gavi1" value="Tìm kiếm" name="">
        </div>
    </form>
</div>

<div class="container page-content agency-list">
    <?php
    if(!empty($listData)){
        foreach($listData as $data){
            echo '  <div class="col-xs-12 col-sm-12 qr-item">
            <div id="id_qrcode1" class="id-qrcode"></div>
            <div class="agency-info">
            <p>'.$data['Notification']['date']['text'].'</p>
            <p class="agency-level">Số tiền: '.number_format($data['Notification']['money']).'</p>
            <p class="agency-level">Trạng thái: '.@$getStatusDefault[$data['Notification']['status']]['name'].'</p>
            <p class="agency-level">Ghi chú: '.$data['Notification']['note'].'</p>
            </div>
            </div>';
        }
    }
    ?>


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
</div>

<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>


</body>
</html>
