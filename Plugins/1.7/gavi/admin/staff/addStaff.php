<link href="<?php echo $urlHomes . 'app/Plugin/gavi/admin/style.css'; ?>" rel="stylesheet">

<?php
if(!empty($data)){
    $name='Chỉnh sửa nhân viên';
}else{
    $name='Thêm mới nhân viên';
}
$breadcrumb = array('name' => 'Quản lý tài khoản nhân viên',
    'url' => $urlPlugins . 'admin/gavi-admin-staff-listStaff.php',
    'sub' => array('name' => $name)
);
addBreadcrumbAdmin($breadcrumb);
?> 

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
  $( function() {
    $( "#birthday" ).datepicker({
      dateFormat: "dd/mm/yy"
  });
} );
</script>

<div class="taovien row">
    <!-- <?php if (!empty($mess)) { ?>
    <p style="font-weight: bold; color: red;"> <?php echo $mess; ?></p>
    <?php } ?> -->
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
<form action="" method="post" name="">
    <div class="col-sm-12">
        <div class="col-sm-4">
            <div class="form_add">
                <div class="form-group">
                    <label>Họ tên<span class="color_red">*</span>: </label>
                    <input type="text" title="" maxlength="50" id="" placeholder="Họ tên" value="<?php echo @arrayMap($data['Staff']['fullName']);?>" class="form-control" name="fullName" required="">
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form_add">
                <div class="form-group">
                    <label>Mã nhân viên<span class="color_red">*</span>: </label>
                    <input type="text" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" id="updatecode" placeholder="Mã nhân viên" value="<?php echo @arrayMap($data['Staff']['code']);?>" class="form-control checkcode" name="code" required="" <?php if(!empty($data['Staff']['code']))echo'disabled';?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form_add">
                <div class="form-group">
                    <label>Giới tính<span class="color_red">*</span>: </label>
                    <select class="form-control" required="" name="sex">
                        <option value="">Chọn giới tính</option>
                        <option value="nam" <?php if(isset($data['Staff']['sex']) && $data['Staff']['sex']=='nam') echo 'selected';?> >Nam</option>
                        <option value="nu" <?php if(isset($data['Staff']['sex']) && $data['Staff']['sex']=='nu') echo 'selected';?> >Nữ</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form_add">
                <div class="form-group">
                    <label>Ngày sinh<span class="color_red">*</span>: </label>
                    <input type="text" required="" value="<?php echo @arrayMap($data['Staff']['birthday']);?>" name="birthday" id="birthday" placeholder="Ngày sinh" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" >
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form_add">
               <div class="form-group">
                <label for="">Trạng thái<span class="color_red">*</span></label>
                <select class="form-control" name="status" required>
                    <option value="active" <?php if(isset($data['Staff']['status']) && $data['Staff']['status']=='active') echo 'selected';?> >Kích hoạt</option>
                    <option value="lock" <?php if(isset($data['Staff']['status']) && $data['Staff']['status']=='lock') echo 'selected';?> >Khóa</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form_add">
            <div class="form-group">
                <label>Email<span class="color_red">*</span>: </label>
                <input type="email" title="" maxlength="50" id=""  placeholder="Email" value="<?php echo @arrayMap($data['Staff']['email']);?>" class="form-control" name="email" required="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form_add">
            <div class="form-group">
                <label for="">Mật khẩu<span class="color_red">*</span></label>
                <input type="password" name="password" placeholder="Nhập mật khẩu" class="form-control" id="" <?php if(empty($data['Staff']['pass'])){echo "required";}?>  >
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form_add">
            <div class="form-group">
                <label>Số điện thoại<span class="color_red">*</span>: </label>
                <input type="text" name="phone" maxlength="50"  placeholder="Số điên thoại"  value="<?php echo @arrayMap($data['Staff']['phone']);?>" class="form-control" required="" >
            </div>
        </div>
    </div>

    
    <div class="col-sm-4">
        <div class="form_add">
            <div class="form-group">
                <label for="">Chọn Tỉnh/Thành phố<span class="color_red">*</span>:</label>
                <select required name="idCity" class="form-control" placeholder="Tỉnh/Thành phố">
                    <option value="">Chọn Tỉnh/Thành phố</option>
                    <?php
                    if (!empty($listCityKiosk)) {
                        foreach ($listCityKiosk as $city) {
                            if (!isset($data['Staff']['idCity']) || $data['Staff']['idCity'] != $city['id']) {
                                echo '<option value="' . $city['id'] . '">' . $city['name'] . '</option>';
                            } else {
                                echo '<option value="' . $city['id'] . '" selected>' . $city['name'] . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    
    <div class="col-sm-4">
        <div class="form_add">
            <div class="form-group">
                <label>Số nhà, đường<span class="color_red">*</span>: </label>
                <input type="text" name="address" placeholder="Số nhà, đường"  maxlength="500" class="form-control" value="<?php echo @arrayMap($data['Staff']['address']);?>" required="">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form_add">
            <div class="form-group">
                <label>Ngày vào thử việc<span class="color_red">*</span>: </label>
                <input type="text" name="dateTrial" id="" placeholder="Ngày vào thử việc" class="input_date form-control" required="" data-inputmask="'alias': 'date'"  pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" value="<?php echo @$data['Staff']['dateTrial'];?>">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form_add">
            <div class="form-group">
                <label>Ngày làm chính thức<span class="color_red">*</span>: </label>
                <input type="text" name="dateStart" id="" placeholder="Ngày làm chính thức" class="input_date form-control" required="" data-inputmask="'alias': 'date'"  pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" value="<?php echo @$data['Staff']['dateStart'];?>">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form_add">
            <div class="form-group">
                <label>Vị trí, chức danh công việc<span class="color_red">*</span>: </label>
                <input type="text" title="" maxlength="500" id="" placeholder="Vị trí, chức danh công việc" class="form-control" name="position" required="" value="<?php echo @arrayMap($data['Staff']['position']);?>">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form_add">
            <div class="form-group">
                <label>Quản lý trực tiếp<span class="color_red">*</span>: </label>
                <input type="text" title="" maxlength="200" id="" placeholder="Quản lý trực tiếp" class="form-control" name="directManager" required="" value="<?php echo @arrayMap($data['Staff']['directManager']);?>">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form_add">
            <div class="form-group">
                <label>Quản lý gián tiếp<span class="color_red">*</span>: </label>
                <input type="text" title="" maxlength="200" id="" placeholder="Quản lý gián tiếp" class="form-control" name="indirectManager" required="" value="<?php echo @arrayMap($data['Staff']['indirectManager']);?>">
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <label>Mô tả:</label>
            <textarea class="form-control" maxlength="3000" placeholder="Mô tả" rows="3" name="desc"><?php echo @arrayMap($data['Staff']['desc']);?></textarea>

        </div>
    </div>
    <div class="col-sm-12" style="<?php if(empty($data)){echo'display: none;';}?>">
        <div class="form-group">
            <label>Lý do sửa<span class="color_red">*</span>:</label>
            <textarea class="form-control" maxlength="3000" rows="3" name="reason" <?php if(!empty($data))echo'required=""';?> placeholder="Lý do sửa"></textarea>

        </div>
    </div>
    
</div>
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; margin-bottom: 15px;">
    <button type="submit"  class="btn btn-primary">Lưu</button>
</div>
</form>
<a href="<?php echo $urlPlugins.'admin/gavi-admin-staff-listStaff.php';?>"  class="btn btn-primary">Quay lại</a>
</div>

<script src="https://www.jqueryscript.net/demo/Easy-jQuery-Input-Mask-Plugin-inputmask/dist/jquery.inputmask.bundle.min.js"></script>

<script src="<?php echo $urlHomes . 'app/Plugin/gavi/view/manager'; ?>/js/ace-elements.min.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/gavi/view/manager'; ?>/js/number-divider.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/gavi/view/manager'; ?>/js/ace.min.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/gavi/view/manager'; ?>/js/jquery.maskedinput.min.js"></script>


<script type="text/javascript">
    $(function () {
        $('.navbar-toggle-sidebar').click(function () {
            $('.navbar-nav').toggleClass('slide-in');
            $('.side-body').toggleClass('body-slide-in');
            $('#search').removeClass('in').addClass('collapse').slideUp(200);
        });

        $('#search-trigger').click(function () {
            $('.navbar-nav').removeClass('slide-in');
            $('.side-body').removeClass('body-slide-in');
            $('.search-input').focus();
        });
    });
</script>

<!-- <script type="text/javascript">
    jQuery(function ($) {
        $('.input-mask-date').mask('99/99/9999', {placeholder: "dd/mm/yyyy"});
    });
</script> -->


<script>
    $(document).ready(function(){
        $("input.input_date").inputmask();
        $("input.input-mask-date").inputmask();

        // $('.input_money').numbertor({
        //  allowEmpty: true
        // });
        $('.input_money').divide({delimiter: '.',
            divideThousand: true});

        $('.input_money').on('paste', function () {
            var element = this;
            var text = $(element).val();
            if(!isNaN(text)){
                $(element).val("");
                console.log('Phải nhập số');
            }
        });


    });
</script>

