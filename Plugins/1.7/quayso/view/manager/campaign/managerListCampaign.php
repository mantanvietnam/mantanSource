<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/header.php'; ?>
<section role="main" class="content-body" id="fullscreen">

<!-- start: page -->

<section class="panel">
    <ul class="title_p list-inline">
        <li><a href="/"><i class="fa fa-home"></i> Trang chủ</a></li>
        <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
        <li>Chiến dịch</li>
    </ul>
    
    <div class="panel-body"> 
        <div class="row" style="margin-bottom: 1em;">
            <div class="col-sm-12">
                <div class="mb-md">
                    <a href="<?php echo $urlHomes; ?>addCampaign" class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Thêm chiến dịch</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <?php 
            if(empty($_SESSION['infoManager']['Manager']['typeBuy'])){
                $_SESSION['infoManager']['Manager']['typeBuy']= 'buyTurn';
            }

            if( ($_SESSION['infoManager']['Manager']['typeBuy']=='' || $_SESSION['infoManager']['Manager']['typeBuy']=='buyTurn' ) && $numberCampaign<5){
                $number = 5 - $numberCampaign;
                echo '<p style="color: red;">Bạn còn '.$number.' chiến dịch miễn phí</p>';
            }
            ?>
            <table class="table table-bordered table-striped table-hover mb-none">
                <thead>
                    <tr> 
                        <th>ID</th>
                        <th>Tên chiến dịch </th>
                        <th>Người tham gia </th>
                        <th>Người checkin </th>
                        <th>Người chiến thắng </th>   
                        <th>Sửa</th>  
                    </tr> 
                </thead>
                <tbody>
                    <?php

                    if (!empty($listData)) {
                        foreach ($listData as $item) {
                            if($_SESSION['infoManager']['Manager']['typeBuy']=='buyForever'){
                                $deleteUserCampain = '<br/><br/><a href="/deleteAllUserCampain?idCampaign='.$item['Campaign']['id'].'" onclick="return confirm(\'Bạn có chắc chắn muốn xóa toàn bộ người tham gia chiến dịch này không?\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                                
                                $deleteUserWinCampain = '<br/><br/><a href="/deleteAllUserWinCampain?idCampaign='.$item['Campaign']['id'].'" onclick="return confirm(\'Bạn có chắc chắn muốn xóa toàn bộ người chiến thắng của chiến dịch này không?\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                                
                                $deleteUserCheckinCampain = '<br/><br/><a href="/deleteAllUserChecinCampain?idCampaign='.$item['Campaign']['id'].'" onclick="return confirm(\'Bạn có chắc chắn muốn xóa toàn bộ người checkin của chiến dịch này không?\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                            }else{
                                $deleteUserCampain = '';
                                $deleteUserWinCampain = '';
                                $deleteUserCheckinCampain = '';
                            }

                            echo '  <tr>
                                        <td>
                                            '.$item['Campaign']['id'].'
                                            <p><a target="_blank" href="https://quayso.xyz/checkinCampaign/?idCampaign='.$item['Campaign']['id'].'">Mã QR checkin</a></p>
                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data='.urlencode('https://quayso.xyz/checkinCampaign/?idCampaign='.$item['Campaign']['id']).'" width="100" />
                                        </td>
                                        <td>
                                            <a target="_blank" href="/spin/'.$item['Campaign']['urlSlug'].'.html">'.$item['Campaign']['name'].'</a></td>
                                        <td align="center">
                                            <a href="/user/?idCampaign='.$item['Campaign']['id'].'">'.$item['Campaign']['numberUser'].'</a>
                                            '.$deleteUserCampain.'
                                        </td>
                                        <td align="center">
                                            '.$item['Campaign']['numberUserCheckin'].'
                                            '.$deleteUserCheckinCampain.'
                                        </td>
                                        <td align="center">
                                            <a href="/userWin/?idCampaign='.$item['Campaign']['id'].'">'.count($item['Campaign']['listUserWin']).'</a>
                                            '.$deleteUserWinCampain.'
                                        </td>
                                        <td align="center"><a href="/addCampaign?id='.$item['Campaign']['id'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                                    </tr>'; 
                        }
                    } else {
                        echo '<tr>
                                <td align="center" colspan="13">Chưa có chiến dịch nào.</td>
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