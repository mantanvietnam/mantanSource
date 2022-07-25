<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/header.php'; ?>
<section role="main" class="content-body" id="fullscreen">

<!-- start: page -->

<section class="panel">
    <ul class="title_p list-inline">
        <li><a href="/"><i class="fa fa-home"></i> Trang chủ</a></li>
        <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
        <li>Người chơi</li>
    </ul>
    
    <div class="panel-body"> 
        <div class="row" style="margin-bottom: 1em;">
            <form class="form-inline" role="form" id="formSearch">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-xs-6 col-sm-3 col-md-3">
                            <select name="idCampaign" class="form-control">
                                <option value="">Tất cả chiến dịch</option>
                                <?php
                                if (!empty($listAllCampaignManager)) {
                                    foreach ($listAllCampaignManager as $item) {
                                        ?>
                                        <option value="<?php echo $item['Campaign']['id'] ?>" <?php
                                        if (isset($_GET['idCampaign']) && $_GET['idCampaign'] == $item['Campaign']['id']) {
                                            echo ' selected';
                                        }
                                        ?> ><?php echo $item['Campaign']['name'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-xs-6 col-sm-3 col-md-3">
                            <select name="typeUser" class="form-control">
                                <option value="">Tất cả người chơi</option>
                                <option value="checkin" <?php if(!empty($_GET['typeUser']) && $_GET['typeUser']=='checkin') echo 'selected';?> >Đã checkin</option>
                                <option value="nocheckin" <?php if(!empty($_GET['typeUser']) && $_GET['typeUser']=='nocheckin') echo 'selected';?> >Chưa checkin</option>
                            </select>
                        </div>

                        <div class="col-xs-6 col-sm-2 col-md-2">
                            <input type="text" name="phone" placeholder="Số điện thoại" value="<?php echo @$_GET['phone'];?>" class="form-control">
                        </div>

                        <div class="col-xs-6 col-sm-2 col-md-2">
                            <input type="text" name="codeQT" placeholder="Mã tham dự" value="<?php echo @$_GET['codeQT'];?>" class="form-control">
                        </div>
                        
                        <div class="col-xs-6 col-sm-2 col-md-2">
                            <input type="submit" class="btn btn-primary btn-sm calculation" name=""  value="Tìm kiếm"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row" style="margin-bottom: 1em;">
            <div class="col-sm-12">
                <a href="/addUser" class="btn btn-danger"><i class="fa fa-plus" aria-hidden="true"></i> Thêm người tham gia</a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover mb-none">
                <thead>
                    <tr> 
                        <th>Checkin </th> 
                        <th>Mã dự thưởng </th>
                        <th>Tên người chơi </th>
                        <th>Liên hệ </th>
                        <th>Công việc </th>
                        <th>Chiến dịch </th>  
                        <th>Đăng ký </th> 
                        <th>Ghi chú </th> 
                        <th>Xóa </th> 
                    </tr> 
                </thead>
                <tbody>
                    <?php

                    if (!empty($listData)) {
                        foreach ($listData as $item) {
                            if(!empty($item['User']['checkin'])){
                                $checkin = date('H:i d/m/Y', $item['User']['checkin']).'<p><a class="btn btn-danger" href="/deleteCheckin/?idCampaign='.$item['User']['campaign'].'&idUser='.$item['User']['id'].'&urlBack='.urlencode($urlNow).'" onclick="return confirm(\'Bạn có chắc chắn muốn xóa checkin cho người dùng này không?\');">Xóa checkin</a></p>';
                            }
                            else{
                                $checkin = 'Chưa checkin<p><a class="btn btn-primary" href="/checkin/?idCampaign='.$item['User']['campaign'].'&idUser='.$item['User']['id'].'&urlBack='.urlencode($urlNow).'" onclick="return confirm(\'Bạn có chắc chắn muốn checkin cho người dùng này không?\');">Checkin</a></p>';
                            }

                            if($_SESSION['infoManager']['Manager']['typeBuy']=='buyForever'){
                                $deleteUser = '<a href="/deleteUser?idUser='.$item['User']['id'].'" onclick="return confirm(\'Bạn có chắc chắn muốn xóa người dùng này không?\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                            }else{
                                $deleteUser = '';
                            }

                            echo '  <tr>
                                        <td align="center">'.$checkin.'</td>
                                        <td>'.$item['User']['codeQT'].'</td>
                                        <td align="center">
                                            <p><img src="'.$item['User']['avatar'].'" width="100" /></p>
                                            <a href="https://www.messenger.com/t/'.$item['User']['idMessUser'].'">'.$item['User']['fullName'].'</a>
                                        </td>
                                        <td><a href="tel:'.$item['User']['phone'].'">'.$item['User']['phone'].'</a><br/>'.$item['User']['email'].'</td>
                                        <td>'.@$item['User']['job'].'</td>
                                        <td>'.$item['User']['nameCampaign'].'</td>
                                        <td>'.date('H:i d/m/Y', $item['User']['time']).'</td>
                                        <td>'.@$item['User']['note'].'</td>
                                        <td align="center">'.$deleteUser.'</td>
                                    </tr>'; 
                        }
                    } else {
                        echo '<tr>
                                <td align="center" colspan="13">Chưa có người chơi nào.</td>
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