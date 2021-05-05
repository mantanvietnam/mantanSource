
<?php include('header_nav.php');?>
<style type="text/css" media="screen">
.page-content .qr-item a {
    line-height: normal;
    float: none;
    padding: 0;
    margin-right: 0;
}
</style>
<div class="container title-page">
    <a href="/dashboardAgency" class="back">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
    </a>
    <p>Đại lý phân phối</p>
</div>

<div class="container sub-title store">
    <li class="col-xs-6 col-md-6"><a href="/agency">Đại lý trực thuộc</a></li>
    <li class="col-xs-6 col-md-6 current-tab"><a href="/agencySub">Đại lý phân phối</a></li>
</div>
<div class="container g_search">
    <form action="" method="get" accept-charset="utf-8">
        <div class="form-group col-xs-4 col-sm-4">
            <select name="level" class="form-control">
                <option value="">Cấp đại lý</option>
                <?php
                foreach($listLevelAgency as $status){
                    if(empty($_GET['level']) || $_GET['level']!=$status['id']){
                        echo '<option value="'.$status['id'].'">'.$status['name'].'</option>';
                    }else{
                        echo '<option selected value="'.$status['id'].'">'.$status['name'].'</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group col-xs-4 col-sm-4">
            <input type="text" class="form-control" placeholder="Tên đại lý" name="fullName" value="<?php echo @$_GET['fullName'];?>">
        </div>
        <div class="form-group col-xs-4 col-sm-offset-4 col-sm-4">
            <input type="submit" class="btn btn-gavi1" value="Tìm kiếm" name="">
        </div>
        
    </form>
</div>

<!-- <div class="container note_color">
    <?php
    foreach($listLevelAgency as $level){
        echo '  <div class="col-xs-6">
        <div class="c_item">
        <a href="/agencySub?level='.$level['id'].'">
        <span style="background-color: '.$level['color'].'"></span><span>'.$level['name'].'</span>
        </a>
        </div>
        </div>';
    }
    ?>
</div> -->

<div class="container page-content agency-list agency1">
    <?php
    function showAgencySub($listAll,$listLevelAgency,$codeSearch='')
    {
        if(!empty($listAll)){
            foreach($listAll as $data){
                if(empty($codeSearch) || $codeSearch==$data['Agency']['code']){
                    if(empty($data['Agency']['avatar'])) $data['Agency']['avatar']= '/app/Plugin/gavi/view/agency/img/avatar.png';
                    echo '  <div class="col-xs-12 col-sm-12 qr-item pr_1">
                    <div class="ava_qr">
                    <img src="'.$data['Agency']['avatar'].'" class="img-responsive" alt="">
                    </div>
                    <div class="agency-info">
                    <p><a href="/detailAgency?id='.$data['Agency']['id'].'">'.$data['Agency']['fullName'].' - '.$data['Agency']['code'].'</a></p>
                    <p class="agency-level">Cấp: '.$listLevelAgency[$data['Agency']['level']]['name'].'</p>
                    <p class="agency-level">Ngày vào: '.$data['Agency']['dateStart']['text'].'</p>
                    </div>
                    </div>';
                }

                if(!empty($data['Agency']['sub'])) showAgencySub($data['Agency']['sub'],$listLevelAgency,$codeSearch);
            }
        }
    }

    if(!empty($listData)){
        foreach($listData as $data){
            if(!empty($data['Agency']['sub'])) showAgencySub($data['Agency']['sub'],$listLevelAgency,strtoupper(@$_GET['code']));
        }
    }
    ?>
</div>

<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>


</body>
</html>
