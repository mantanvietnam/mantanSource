<link href="<?php echo $urlHomes . 'app/Plugin/mantanHotel/style.css'; ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/script.js'; ?>"></script>
<?php
global $languageProduct;

$breadcrumb = array('name' => 'Quản lý đặt phòng',
    'url' => $urlPlugins . 'admin/mantanHotel-admin-book-listBookAdmin.php',
    'sub' => array('name' => 'Sửa đặt phòng')
);
addBreadcrumbAdmin($breadcrumb);
?>  

<div class="taovien row">
    <?php if (!empty($mess)) { ?>
        <p style="font-weight: bold; color: red;"> <?php echo $mess; ?></p>
    <?php } ?>
    <div class="form-group">
        <label for="">Mã đặt phòng : <span style="color: blue;" id="user" ><?php echo $data['Book']['codeBook'] ?></span></label>
    </div>
    <form id="summary-form" action="" method="post" class="form-horizontal">
                <section class="panel">
                    
                    <div class="panel-body">
                        <div class="row">                          
                            <div class="col-md-6">
                                <h2 class="panel-title"> Thông tin đăng ký - Phòng đơn</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Mã đặt phòng: <span class="required">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="codeBook" disabled="" value="<?php echo $data['Book']['codeBook']; ?>" class="form-control" required="required"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Giá: <span class="required">*</span></label>
                                    <div class="col-md-8">
                                        <input type="number" value="1" name="price" class="form-control" required="required"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Ngày vào: <span class="required">*</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">                                            
                                            <input type="text" name="date_checkin" value="<?php echo date( "d-m-Y", $data['Book']['date_checkin']);?>" data-plugin-datepicker class="form-control" required/>                                          
                                            <span class="input-group-addon">lúc</span>
                                            <input type="text" name="time_checkin" value="<?php echo date( "H:i:s", $data['Book']['time_checkin']);?>" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false }'>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Ngày ra dự kiến:</label>
                                    <div class="col-md-8">
                                        <div class="input-group">                                            
                                            <input type="text" value="<?php echo date( "d-m-Y", $data['Book']['date_checkout_foresee']);?>" name="date_checkout_foresee" data-plugin-datepicker class="form-control" required/>                                          
                                            <span class="input-group-addon">lúc</span>
                                            <input type="text" value="<?php echo date( "H:i:s", $data['Book']['time_checkout_foresee']);?>" name="time_checkout_foresee" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false }'>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Trả trước:</label>
                                    <div class="col-md-8">
                                        <input type="number" value="<?php echo $data['Book']['prepay']; ?>" name="prepay" class="form-control" required="required"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Giảm trừ:</label>
                                    <div class="col-md-8">
                                        <input type="number" value="<?php echo $data['Book']['deduction']; ?>" name="deduction" class="form-control" required="required"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Đăng ký ở: <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <select id="company" class="form-control" name="type_register" required>
                                            <option value="1" <?php if($data['Book']['type_register']=='1'){echo 'selected';} ?>>Theo giờ</option>
                                            <option value="2" <?php if($data['Book']['type_register']=='2'){echo 'selected';} ?>>Qua đêm</option>
                                            <option value="3" <?php if($data['Book']['type_register']=='3'){echo 'selected';} ?>>Theo ngày</option>
                                        </select>
                                        <label class="error" for="room"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Số lượng người: <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <select id="company" name="number_people" class="form-control" required>
                                            <option value="1" <?php if($data['Book']['number_people']=='1'){echo 'selected';} ?>>1 người</option>
                                            <option value="2" <?php if($data['Book']['number_people']=='2'){echo 'selected';} ?>>2 người</option>
                                            <option value="3" <?php if($data['Book']['number_people']=='3'){echo 'selected';} ?>>3 người</option>
                                            <option value="4" <?php if($data['Book']['number_people']=='4'){echo 'selected';} ?>>Nhiều hơn 3 người</option>
                                        </select>
                                        <label class="error" for="room"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Ghi chú:</label>
                                    <div class="col-sm-8">
                                        <textarea name="note"  class="form-control" type="text" rows="5"><?php echo $data['Book']['note']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h2 class="panel-title"> Thông tin khách hàng</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Tên khách hàng: <span class="required">*</span></label>
                                    <div class="col-sm-8">                                    
                                        <input type="text" value="<?php echo $data['Book']['cus_name']; ?>" name="cus_name" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Số CMND/Passport: <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="number" value="<?php echo $data['Book']['cmnd']; ?>" name="cmnd" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Ngày cấp:</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="<?php echo date( "d-m-Y", $data['Book']['date_cmnd']);?>" name="date_cmnd" data-plugin-datepicker class="form-control"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <lable class="col-sm-4 control-label">Địa chỉ:</lable>
                                    <div class="col-sm-8">
                                        <input type="text" value="<?php echo $data['Book']['cus_address']; ?>" name="cus_address"  class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <lable class="col-sm-4 control-label">Điện thoại:</lable>
                                    <div class="col-sm-8">
                                        <input type="number" value="<?php echo $data['Book']['phone']; ?>" name="phone" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Giới tính:</label> 
                                    <div class="col-sm-8">
                                        <span class="radio-custom radio-primary">
                                            <input  name="sex" type="radio" required="" <?php if($data['Book']['sex']=='male'){echo 'checked';} ?> value="male">
                                            <label>Nam</label>
                                        </span>&nbsp; &nbsp; 
                                        <span class="radio-custom radio-primary">
                                            <input  name="sex" type="radio" value="female" <?php if($data['Book']['sex']=='female'){echo 'checked';} ?>>
                                            <label>Nữ</label>
                                        </span>&nbsp; &nbsp; 
                                        <span class="radio-custom radio-primary">
                                            <input  name="sex" type="radio" value="other" <?php if($data['Book']['sex']=='other'){echo 'checked';} ?>>
                                            <label>Khác</label>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Quốc tịch:</label>
                                    <div class="col-sm-8">
                                        <select id="company" name="nationlaty" class="form-control">
                                            <option value="VN" <?php if($data['Book']['nationlaty']=='VN'){echo 'selected';} ?>>Việt Nam</option>
                                            <option value="other" <?php if($data['Book']['nationlaty']=='other'){echo 'selected';} ?>>Khác</option>
                                        </select>
                                        <label class="error" for="room"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Ghi chú:</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="cus_note" type="text" rows="6"><?php echo $data['Book']['cus_note']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Sửa nhận phòng</button>
                                <button type="reset" class="btn btn-default">Hủy</button>
                            </div>
                        </div>
                    </footer>
                </section>
            </form>
</div>

