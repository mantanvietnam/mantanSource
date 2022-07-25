<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/header.php'; ?>
<section role="main" class="content-body" id="fullscreen">

<!-- start: page -->

<section class="panel">
    <ul class="title_p list-inline">
        <li><a href="/addMoney"><i class="fa fa-home"></i> Nạp tiền</a></li>
        <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
        <li>Lịch sử giao dịch</li>
    </ul>
    
    <div class="panel-body"> 
        <div class="row" style="margin-bottom: 1em;">
            <div class="col-sm-12">
                <div class="mb-md">
                    <a href="<?php echo $urlHomes; ?>addMoney" class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Nạp tiền</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover mb-none">
                <thead>
                    <tr> 
                        <th>Thời gian</th>
                        <th>Số tiền </th>
                        <th>Số dư </th>
                        <th>Ghi chú </th>   
                    </tr> 
                </thead>
                <tbody>
                    <?php

                    if (!empty($listData)) {
                        foreach ($listData as $item) {
                            if($item['History']['type'] == 'plus'){
                                $numberCoin = '<span style="color: green;">+ '.number_format($item['History']['numberCoin']).'đ</span>';
                            }else{
                                $numberCoin = '<span style="color: red;">- '.number_format($item['History']['numberCoin']).'đ</span>';
                            }

                            echo '  <tr>
                                        <td>'.date('H:i d/m/Y', $item['History']['time']).'</td>
                                        <td>'.$numberCoin.'</td>
                                        <td>'.number_format($item['History']['numberCoinManager']).'đ</td>
                                        <td>'.$item['History']['note'].'</td>
                                    </tr>'; 
                        }
                    } else {
                        echo '<tr>
                                <td align="center" colspan="13">Chưa có giao dịch nào.</td>
                            </tr>';
                    }
                    ?>                 
                </tbody>
            </table> 
        </div>
            
        <div class="row panel-body" style="margin-top: 1em;">
            <?php
            if($totalPage>0){
                if ($page > 5) {
                    $startPage = $page - 5;
                } else {
                    $startPage = 1;
                }

                if ($totalPage > $page + 5) {
                    $endPage = $page + 5;
                } else {
                    $endPage = $totalPage;
                }
                
                echo '<a href="' . $urlPage . $back . '">Trang trước</a> ';
                for ($i = $startPage; $i <= $endPage; $i++) {
                    echo ' <a href="' . $urlPage . $i . '">' . $i . '</a> ';
                }
                echo ' <a href="' . $urlPage . $next . '">Trang sau</a> ';

                // echo 'Tổng số trang: ' . $totalPage;
                echo 'Hiển thị trang thứ '.$page.'/'.$totalPage;
            }
            ?>
        </div>
    </div>
</section>

<!-- end: page -->
</section>


<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/footer.php'; ?>