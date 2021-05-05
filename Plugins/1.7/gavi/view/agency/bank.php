<!-- <!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GAVI Agency Site</title>

    <link href="/app/Plugin/gavi/view/agency/css/bootstrap.min.css" rel="stylesheet">
    <link href="/app/Plugin/gavi/view/agency/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="/app/Plugin/gavi/view/agency/css/mystyle.css" rel="stylesheet">
</head>

<body> -->
    <?php include('header_nav.php');?>

    
    <div class="container title-page">
            <a onclick="" href="/account" class="back">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </a>
            <p>Cài đặt tài khoản ngân hàng</p>
        </div>

        <div class="container page-content">
            <div class="col-xs-12 col-sm-12 agency-detail">
                <div class="letter-content input_border_b">
                    <!-- <p style="color: red;"><?php echo $mess;?></p> -->
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
                            <button type="button" class="btn btn-default setfocus" data-dismiss="modal" autofocus>Đóng</button>
                        </div>
                    </div>

                </div>
            </div>
            <?php }?>
            <form action="" method="post">
                <div class="form-group">
                    <label class="control-label" for="">Tài khoản ngân hàng 1: </label>
                    <input name="bankAccount[1]" placeholder="Tên chủ tài khoản" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['bank'][1]['bankAccount'];?>">
                    <input name="bankNumber[1]" placeholder="Số tài khoản" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['bank'][1]['bankNumber'];?>">
                    <select name="bankName[1]" class="form-control">
                        <option value="">Chọn tên ngân hàng</option>
                        <?php 
                        foreach($listBank as $bank){
                            if(empty($data['Agency']['bank'][1]['bankID']) || $data['Agency']['bank'][1]['bankID']!=$bank['id']){
                                echo '<option value="'.$bank['id'].'">'.$bank['name'].'</option>';
                            }else{
                                echo '<option selected value="'.$bank['id'].'">'.$bank['name'].'</option>';
                            }
                        }
                        ?>
                    </select>
                    <input name="bankBranch[1]" placeholder="Tên chi nhánh ngân hàng" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['bank'][1]['bankBranch'];?>">
                </div>
                <div class="form-group click_show click_show1">
                    <label class="control-label" for="">Tài khoản ngân hàng 2: </label>
                    <input name="bankAccount[2]" placeholder="Tên chủ tài khoản" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['bank'][2]['bankAccount'];?>">
                    <input name="bankNumber[2]" placeholder="Số tài khoản" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['bank'][2]['bankNumber'];?>">
                    <select name="bankName[2]" class="form-control">
                        <option value="">Chọn tên ngân hàng</option>
                        <?php 
                        foreach($listBank as $bank){
                            if(empty($data['Agency']['bank'][2]['bankID']) || $data['Agency']['bank'][2]['bankID']!=$bank['id']){
                                echo '<option value="'.$bank['id'].'">'.$bank['name'].'</option>';
                            }else{
                                echo '<option selected value="'.$bank['id'].'">'.$bank['name'].'</option>';
                            }
                        }
                        ?>
                    </select>
                    <input name="bankBranch[2]" placeholder="Tên chi nhánh ngân hàng" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['bank'][2]['bankBranch'];?>">
                </div>
                <div class="form-group click_show click_show2">
                    <label class="control-label" for="">Tài khoản ngân hàng 3: </label>
                    <input name="bankAccount[3]" placeholder="Tên chủ tài khoản" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['bank'][3]['bankAccount'];?>">
                    <input name="bankNumber[3]" placeholder="Số tài khoản" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['bank'][3]['bankNumber'];?>">
                    <select name="bankName[3]" class="form-control">
                        <option value="">Chọn tên ngân hàng</option>
                        <?php 
                        foreach($listBank as $bank){
                            if(empty($data['Agency']['bank'][3]['bankID']) || $data['Agency']['bank'][3]['bankID']!=$bank['id']){
                                echo '<option value="'.$bank['id'].'">'.$bank['name'].'</option>';
                            }else{
                                echo '<option selected value="'.$bank['id'].'">'.$bank['name'].'</option>';
                            }
                        }
                        ?>
                    </select>
                    <input name="bankBranch[3]" placeholder="Tên chi nhánh ngân hàng" class="form-control col-md-7 col-xs-12" id="" maxlength="225" type="text" value="<?php echo @$data['Agency']['bank'][3]['bankBranch'];?>">
                </div>
                
                <div class="form-group">
                    <a href="javascript:void(0)" class="btn btn-gavi btn_them "><i class="fa fa-plus"></i> Thêm</a>
                </div>
                
                <div class="letter-footer">
                    <button type="submit" data-loading-text="Loading..." class="btn btn-gavi width-100" autocomplete="off">
                      <i class="fa fa-paper-plane" aria-hidden="true"></i> Lưu
                  </button>
              </div>
          </form>
      </div>
      
  </div>
</div>

<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>

<script>
    $(document).ready(function() {
        var dem=0;
        $('.btn_them').click(function(){
            dem++;
            if(dem==1){
                $('.click_show1').css("display", "block");
            } if(dem==2){
                $('.click_show2').css("display", "block");$(this).hide();
            }
        });
    });
</script>
<style type="text/css" media="screen">
.click_show{
    display: none;
}
.btn_them{
    border: 1px solid #ff4400;
    background: white;
    color: #ff4400;
}
</style>

</body>
</html>
