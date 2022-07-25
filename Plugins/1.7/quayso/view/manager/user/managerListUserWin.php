<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/header.php'; ?>
<section role="main" class="content-body" id="fullscreen">

<!-- start: page -->

<section class="panel">
    <ul class="title_p list-inline">
        <li><a href="/"><i class="fa fa-home"></i> Trang chủ</a></li>
        <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
        <li>Người chơi chiến thắng</li>
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
        <br/>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover mb-none">
                <thead>
                    <tr> 
                        <th>Thời gian thắng </th>
                        <th>Mã dự thưởng </th>
                        <th>Tên người chơi </th>
                        <th>Liên hệ </th>
                        <th>Công việc </th>
                        <th>Chiến dịch thắng </th>   
                        <th>Xóa </th>   
                    </tr> 
                </thead>
                <tbody>
                    <?php

                    if (!empty($listUserWin)) {
                        foreach ($listUserWin as $timeWin=>$item) {
                            echo '  <tr>
                                        <td>'.date('H:i d/m/Y', $timeWin).'</td>
                                        <td>'.$item['User']['codeQT'].'</td>
                                        <td align="center">
                                            <p><img src="'.$item['User']['avatar'].'" width="100" /></p>
                                            <a href="https://www.messenger.com/t/'.$item['User']['idMessUser'].'">'.$item['User']['fullName'].'</a>
                                        </td>
                                        <td><a href="tel:'.$item['User']['phone'].'">'.$item['User']['phone'].'</a><br/>'.$item['User']['email'].'</td>
                                        <td>'.@$item['User']['job'].'</td>
                                        <td>'.$item['User']['nameCampaign'].'</td>
                                        <td title="Chỉ có thể xóa kết quả trong vòng 24h" align="center"><a onclick="return confirm(\'Bạn có chắc chắn muốn xóa kết quả người chơi chiến thắng này không?\');" href="/deleteUserWin?idUser='.$item['User']['id'].'&idCampaign='.$item['User']['idCampaign'].'"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                    </tr>'; 
                        }
                    } else {
                        echo '<tr>
                                <td align="center" colspan="13">Chưa có người chơi nào chiến thắng.</td>
                            </tr>';
                    }
                    ?>                 
                </tbody>
            </table> 
        </div>
    </div>
</section>

<!-- end: page -->
</section>


<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/footer.php'; ?>