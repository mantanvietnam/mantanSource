
<?php include('header_nav.php');?>
<style type="text/css" media="screen">
    .page-content .item{
        margin-left: 0;
        margin-right: 0;
    }
</style>
<div class="container title-page">
    <a href="/wallet" class="back">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
    </a>
    <p>Danh sách yêu cầu rút tiền</p>
</div>

<div class="container g_search">
    <form action="" method="get" accept-charset="utf-8">
        <div class="form-group col-xs-6">
            <select name="idStatus" class="form-control">
                <option value="">Tất cả</option>
                <?php
                    $statusDefault= getStatusDefault();
                    foreach($statusDefault as $status){
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


<div class="container page-content letter-list stores-list">
    <?php
    if(!empty($listData)){
        foreach($listData as $data){
            echo '  <div class="row item">
            <p class="col-xs-10">
                <span style="color:#f9561b;"> '.$data['Request']['bank']['bankAccount'].' - '.$data['Request']['bank']['bankNumber'].' - '.$data['Request']['bank']['bankName'].'</span>
                <br/>
                <span class="status" style="color:gray;">'.number_format($data['Request']['money']).'đ</span>
                <br/>
                <span style="color:#f9561b;">'.$statusPay[$data['Request']['status']]['name'].'</span> <br>
                
            </p>
            <p class="col-xs-2">';
            if($data['Request']['status']=='new'){
                echo '<a href="/deletePay?id='.$data['Request']['id'].'" onclick="return confirm(\'Bạn có chắc chắn muốn hủy yêu cầu rút tiền này không ?\');">
                <span1><i class="fa fa-trash" aria-hidden="true"></i></span1>
                </a>';
            }
            echo        '</p>
            </div>';
        }
    }
    ?>

    <div class="row">

        <div class="col-sm-12 text-center p_navigation" style="    width: 100%;
        float: left;">
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
</body>
</html>
