<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<script>
    var numberPriceTime = 1;

    function deletePriceTime(idDelete)
    {
        $("#" + idDelete).remove();
    }

    function showBodyPrice(id)
    {
        $("#" + id).toggle();
    }

</script>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Sửa loại phòng</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php
                    global $urlHomeManager;
                    echo $urlHomeManager;
                    ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Sửa loại phòng</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($mess)) { ?>
                <h5 style="color: red;" ><span class="glyphicon glyphicon-remove"></span> <?php echo $mess; ?></h5>
            <?php } ?>
            <form id="summary-form" action="" method="post" class="form-horizontal">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Sửa loại phòng <br/><br/>
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#thongtinchung">Thông tin chung</a></li>
                                <li><a data-toggle="tab" href="#ngaythuong">Giá phòng ngày thường</a></li>
                                <li><a data-toggle="tab" href="#ngaycuoituan">Ngày cuối tuần</a></li>
                                <li><a data-toggle="tab" href="#ngayle">Ngày lễ</a></li>
                                <li><a data-toggle="tab" href="#hanghoa">Hàng hóa - Dịch vụ</a></li>
                            </ul>
                        </h2>
                    </header>

                    <div class="tab-content">
                        <div id="thongtinchung" class="tab-pane fade in active">
                            <div class="panel-body">
                                <div class=" col-md-10">
                                    <h2 class="panel-title text-center">Thông tin chung</h2>
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Loại phòng: <span class="required">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" name="roomtype" value="<?php echo $data['TypeRoom']['roomtype'] ?>" class="form-control" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Số giường: <span class="required">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="number" name="so_giuong" value="<?php echo $data['TypeRoom']['so_giuong'] ?>" class="form-control" required min="1"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Số người:<span class="required">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="number" name="so_nguoi" value="<?php echo $data['TypeRoom']['so_nguoi'] ?>" class="form-control" min="1" required="" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Hình đại diện</label>
                                        <div class="col-md-8">
                                            <?php showUploadFile('image', 'image', @$data['TypeRoom']['image'], 0); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Mô tả:</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="desc" type="text" rows="5"><?php echo @$data['TypeRoom']['gia_theo_thang'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="ngaythuong" class="tab-pane fade in">
                            <div class="panel-body">
                                <div class="col-md-6" id="priceHour">	
                                    <h2 class="panel-title">Giá theo giờ</h2><a href="javascript:void( 0 );" onclick="addPriceHour();"><img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/images.png" alt="" title=""/></a>
                                    <script>
                                        function addPriceHour()
                                        {
                                            numberPriceTime++;
                                            var chuoi = '<div id="priceTime' + numberPriceTime + '" class="form-group form-inline"><label class="col-sm-4 control-label" style="padding-top:0;"><span>Giờ thứ <input type="number" required name="time_gia_theo_gio[]" class="form-control" min="0" style="width:4em;"> </span></label><div class="col-sm-8"><input type="number" name="gia_theo_gio[]" class="form-control"  min="0" required/> <button onclick="deletePriceTime(\'priceTime' + numberPriceTime + '\')"><i class="fa fa-trash-o"></i></button></div></div>';

                                            $("#priceHour").append(chuoi);

                                        }
                                    </script>
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-12">
                                            <span class="text-danger">
                                                - Nếu ở quá 24h thì áp dụng phương thức tính giá theo ngày
                                                <br />
                                                - Nếu checkout sau thời điểm bắt đầu tính giá qua đêm thì áp dụng phương thức tính giá qua đêm
                                                <br />
                                                - Nếu ở quá quy định dưới đây thì tính thành 1 ngày 
                                            </span>
                                        </label>
                                    </div> 
                                    <?php foreach ($data['TypeRoom']['ngay_thuong']['gia_theo_gio'] as $key => $gia) { ?>
                                        <div class="form-group form-inline">
                                            <label class="col-sm-4 control-label" style="padding-top: 0;">Giờ thứ <input type="number" name="time_gia_theo_gio[]" value="<?php echo $key; ?>" min="0" required class="form-control" style="width: 4em;"></label>
                                            <div class="col-sm-8">
                                                <input type="number" name="gia_theo_gio[]" value="<?php echo $gia; ?>"  class="form-control" min="0" required />
                                            </div>
                                        </div>   
                                    <?php } ?> 
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h2 class="panel-title">Giá theo ngày</h2>  <br/>                                  
                                            <div class="form-group form-inline">
                                                <label class="col-sm-3 control-label" style="padding-top: 0;">Giá</label>
                                                <div class="col-sm-9">
                                                    <input type="number" name="gia_ngay_thuong" value="<?php echo $data['TypeRoom']['ngay_thuong']['gia_ngay']; ?>" class="form-control" min="0" style="width: 100%;"/>
                                                </div>
                                            </div> 
                                        </div>

                                        <div class="col-sm-6">
                                            <h2 class="panel-title">Giá qua đêm</h2>      <br/>                              
                                            <div class="form-group form-inline">
                                                <label class="col-sm-3 control-label" style="padding-top: 0;">Giá</label>
                                                <div class="col-sm-9">
                                                    <input type="number" name="gia_qua_dem_ngay_thuong" value="<?php echo $data['TypeRoom']['ngay_thuong']['gia_qua_dem']; ?>" class="form-control" min="0" style="width: 100%;"/>
                                                </div>
                                            </div>   
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 15px;">
                                        <div class="col-sm-12">
                                            Qua đêm từ 
                                            <select name="gio_qua_dem_ngay_thuong_start" class="form-control" style="width: 75px;display: inline;">
                                                <option value="24" <?php if (isset($data['TypeRoom']['ngay_thuong']['gio_qua_dem_start']) && $data['TypeRoom']['ngay_thuong']['gio_qua_dem_start'] == 24) echo 'selected'; ?>>24h</option>
                                                <option value="23" <?php if (isset($data['TypeRoom']['ngay_thuong']['gio_qua_dem_start']) && $data['TypeRoom']['ngay_thuong']['gio_qua_dem_start'] == 23) echo 'selected'; ?>>23h</option>
                                                <option value="22" <?php if (isset($data['TypeRoom']['ngay_thuong']['gio_qua_dem_start']) && $data['TypeRoom']['ngay_thuong']['gio_qua_dem_start'] == 22) echo 'selected'; ?>>22h</option>
                                                <option value="21" <?php if (isset($data['TypeRoom']['ngay_thuong']['gio_qua_dem_start']) && $data['TypeRoom']['ngay_thuong']['gio_qua_dem_start'] == 21) echo 'selected'; ?>>21h</option>
                                                <option value="20" <?php if (isset($data['TypeRoom']['ngay_thuong']['gio_qua_dem_start']) && $data['TypeRoom']['ngay_thuong']['gio_qua_dem_start'] == 20) echo 'selected'; ?>>20h</option>
                                            </select> 
                                            tối hôm trước đến 
                                            <select name="gio_qua_dem_ngay_thuong_end" class="form-control" style="width: 75px;display: inline;">
                                                <option value="1" <?php if (isset($data['TypeRoom']['ngay_thuong']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_thuong']['gio_qua_dem_end'] == 1) echo 'selected'; ?>>1h</option>
                                                <option value="2" <?php if (isset($data['TypeRoom']['ngay_thuong']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_thuong']['gio_qua_dem_end'] == 2) echo 'selected'; ?>>2h</option>
                                                <option value="3" <?php if (isset($data['TypeRoom']['ngay_thuong']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_thuong']['gio_qua_dem_end'] == 3) echo 'selected'; ?>>3h</option>
                                                <option value="4" <?php if (isset($data['TypeRoom']['ngay_thuong']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_thuong']['gio_qua_dem_end'] == 4) echo 'selected'; ?>>4h</option>
                                                <option value="5" <?php if (isset($data['TypeRoom']['ngay_thuong']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_thuong']['gio_qua_dem_end'] == 5) echo 'selected'; ?>>5h</option>
                                                <option value="6" <?php if (isset($data['TypeRoom']['ngay_thuong']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_thuong']['gio_qua_dem_end'] == 6) echo 'selected'; ?>>6h</option>
                                                <option value="7" <?php if (isset($data['TypeRoom']['ngay_thuong']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_thuong']['gio_qua_dem_end'] == 7) echo 'selected'; ?>>7h</option>
                                                <option value="8" <?php if (isset($data['TypeRoom']['ngay_thuong']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_thuong']['gio_qua_dem_end'] == 8) echo 'selected'; ?>>8h</option>
                                                <option value="9" <?php if (isset($data['TypeRoom']['ngay_thuong']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_thuong']['gio_qua_dem_end'] == 9) echo 'selected'; ?>>9h</option>
                                                <option value="10" <?php if (isset($data['TypeRoom']['ngay_thuong']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_thuong']['gio_qua_dem_end'] == 10) echo 'selected'; ?>>10h</option>
                                            </select> 
                                            sáng hôm sau
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="panel-body">
                                <div class="col-md-6" id="checkout">
                                    <h2 class="panel-title">Phụ trội quá giờ Checkout (theo ngày)</h2><a href="javascript:void( 0 );" onclick="addcheckout();"><img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/images.png" alt="" title=""/></a>
                                    <script>
                                        function addcheckout()
                                        {
                                            numberPriceTime++;
                                            var chuoi = '<div id="priceTime' + numberPriceTime + '" class="form-group form-inline"><label class="col-sm-4 control-label" style="padding-top:0;"><span>Giờ thứ <input type="number" required name="time_phu_troi_checkout_ngay[]" class="form-control" min="0" style="width:4em;"> </span></label><div class="col-sm-8"><input type="number" name="phu_troi_checkout_ngay[]" class="form-control"  min="0" required/> <button onclick="deletePriceTime(\'priceTime' + numberPriceTime + '\')"><i class="fa fa-trash-o"></i></button></div></div>';

                                            $("#checkout").append(chuoi);

                                        }
                                    </script>
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-12"><span class="text-danger">Nếu ở quá quy định dưới đây thì tính thành 1 ngày</span></label>
                                    </div>
                                    <?php foreach ($data['TypeRoom']['ngay_thuong']['phu_troi_checkout_ngay'] as $key => $gia) { ?>                                    
                                        <div class="form-group form-inline">

                                            <label class="col-sm-4 control-label" style="padding-top: 0;">Giờ thứ <input type="number" name="time_phu_troi_checkout_ngay[]"  min="0" value="<?php echo $key; ?>" required class="form-control" style="width: 4em;"></label>
                                            <div class="col-sm-8">
                                                <input type="number" name="phu_troi_checkout_ngay[]" value="<?php echo $gia; ?>" class="form-control" min="0" required />
                                            </div>
                                        </div>   
                                    <?php } ?>
                                </div>


                                <div class="col-md-6" id="checkoutnight">
                                    <h2 class="panel-title">Phụ trội quá giờ Checkout (qua đêm)</h2><a href="javascript:void( 0 );" onclick="addcheckoutnight();"><img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/images.png" alt="" title=""/></a>
                                    <script>
                                        function addcheckoutnight()
                                        {
                                            numberPriceTime++;
                                            var chuoi = '<div id="priceTime' + numberPriceTime + '" class="form-group form-inline"><label class="col-sm-4 control-label" style="padding-top:0;"><span>Giờ thứ <input type="number" name="time_phu_troi_checkout_dem[]" class="form-control" required min="0" style="width:4em; "> </span></label><div class="col-sm-8"><input type="number" name="phu_troi_checkout_dem[]" class="form-control"  min="0" required/> <button onclick="deletePriceTime(\'priceTime' + numberPriceTime + '\')"><i class="fa fa-trash-o"></i></button></div></div>';

                                            $("#checkoutnight").append(chuoi);

                                        }
                                    </script>
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-12"><span class="text-danger">Nếu ở quá quy định dưới đây thì tính thành 1 ngày</span></label>
                                    </div> 
                                    <?php foreach ($data['TypeRoom']['ngay_thuong']['phu_troi_checkout_dem'] as $key => $gia) { ?>  
                                        <div class="form-group form-inline">
                                            <label class="col-sm-4 control-label" style="padding-top: 0;">Giờ thứ <input type="number" name="time_phu_troi_checkout_dem[]" value="<?php echo $key; ?>" required class="form-control" style="width: 4em;"></label>
                                            <div class="col-sm-8">
                                                <input type="number" name="phu_troi_checkout_dem[]" value="<?php echo $gia; ?>" class="form-control" min="0" required="" />
                                            </div>
                                        </div>  
                                    <?php } ?>
                                </div>  
                            </div>
                            <br/>
                            <div class="panel-body">
                                <div class="col-md-6" id="checkinearly">
                                    <h2 class="panel-title">Phụ trội Checkin sớm (theo ngày)</h2><a href="javascript:void( 0 );" onclick="addcheckinearly();"><img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/images.png" alt="" title=""/></a>
                                    <script>
                                        function addcheckinearly()
                                        {
                                            numberPriceTime++;
                                            var chuoi = '<div id="priceTime' + numberPriceTime + '" class="form-group form-inline"><label class="col-sm-4 control-label" style="padding-top:0;"><span>Giờ thứ <input type="number"  name="time_phu_troi_checkin_ngay[]" required class="form-control" min="0" style="width:4em;"> </span></label><div class="col-sm-8"><input type="number" name="phu_troi_checkin_ngay[]" class="form-control"  min="0" required /> <button onclick="deletePriceTime(\'priceTime' + numberPriceTime + '\')"><i class="fa fa-trash-o"></i></button></div></div>';

                                            $("#checkinearly").append(chuoi);

                                        }
                                    </script>
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-12"><span class="text-danger">Nếu ở quá quy định dưới đây thì tính thành 1 ngày</span></label>
                                    </div> 
                                    <?php foreach ($data['TypeRoom']['ngay_thuong']['phu_troi_checkin_ngay'] as $key => $gia) { ?>  
                                        <div class="form-group form-inline">
                                            <label class="col-sm-4 control-label" style="padding-top: 0;">Giờ thứ <input type="number" name="time_phu_troi_checkin_ngay[]" value="<?php echo $key; ?>" min="0" class="form-control" required style="width: 4em;"></label>
                                            <div class="col-sm-8">
                                                <input type="number"  name="phu_troi_checkin_ngay[]" value="<?php echo $gia; ?>" class="form-control" min="0" required/>
                                            </div>
                                        </div>                                                                        
                                    <?php } ?>
                                </div>

                                <div class="col-md-6" id="checkinnight">
                                    <h2 class="panel-title">Phụ trội Checkin sớm (qua đêm)</h2><a href="javascript:void( 0 );" onclick="addcheckinnight();"><img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/images.png" alt="" title=""/></a>
                                    <script>
                                        function addcheckinnight()
                                        {
                                            numberPriceTime++;
                                            var chuoi = '<div id="priceTime' + numberPriceTime + '" class="form-group form-inline"><label class="col-sm-4 control-label" style="padding-top:0;"><span>Giờ thứ <input type="number" name="time_phu_troi_checkin_dem[]" required  class="form-control" min="0" style="width:4em;"> </span></label><div class="col-sm-8"><input type="number" name="phu_troi_checkin_dem[]" required class="form-control"  min="0" /> <button onclick="deletePriceTime(\'priceTime' + numberPriceTime + '\')"><i class="fa fa-trash-o"></i></button></div></div>';

                                            $("#checkinnight").append(chuoi);

                                        }
                                    </script>
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-12"><span class="text-danger">Nếu ở quá quy định dưới đây thì tính thành 1 ngày</span></label>
                                    </div> 
                                    <?php foreach ($data['TypeRoom']['ngay_thuong']['phu_troi_checkin_dem'] as $key => $gia) { ?>  
                                        <div class="form-group form-inline">

                                            <label class="col-sm-4 control-label" style="padding-top: 0;">Giờ thứ <input type="number" name="time_phu_troi_checkin_dem[]"  required value="<?php echo $key; ?>" class="form-control" style="width: 4em;"></label>
                                            <div class="col-sm-8">
                                                <input type="number" name="phu_troi_checkin_dem[]" value="<?php echo $gia; ?>" class="form-control" min="0" required />
                                            </div>
                                        </div>  
                                    <?php } ?>
                                </div>                                
                            </div>
                            <br/>
                            <div class="panel-body">
                                <div class="col-md-6">
                                    <h2 class="panel-title">Phụ trội thêm khách - Extra Bed</h2>
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Tiếp mỗi người: <span class="required">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="number" name="phu_troi_them_khach" value="<?php echo $data['TypeRoom']['ngay_thuong']['phu_troi_them_khach']; ?>" class="form-control" min="0" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h2 class="panel-title">Ghi chú</h2>
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Ghi chú:</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control"  name="note" type="text" rows="5"><?php echo @$data['TypeRoom']['ngay_thuong']['note']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="ngaycuoituan" class="tab-pane fade in">
                            <p><input name="ngaycuoituan_nhu_ngaythuong" type="checkbox" value="1" <?php if(!empty($data['TypeRoom']['ngaycuoituan_nhu_ngaythuong'])) echo 'checked';?>  onclick="showBodyPrice('bodyNgaycuoituan');" /> Ngày cuối tuần tính giá như ngày thường</p>
                            <div id="bodyNgaycuoituan" <?php if(!empty($data['TypeRoom']['ngaycuoituan_nhu_ngaythuong'])) echo 'style="display: none;"';?> >
                                <div class="panel-body">
                                    <div class="col-md-6" id="priceHour1">	
                                        <h2 class="panel-title">Giá theo giờ</h2><a href="javascript:void( 0 );" onclick="addPriceHour1();"><img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/images.png" alt="" title=""/></a>
                                        <script>
                                            function addPriceHour1()
                                            {
                                                numberPriceTime++;
                                                var chuoi = '<div id="priceTime' + numberPriceTime + '" class="form-group form-inline"><label class="col-sm-4 control-label" style="padding-top:0;"><span>Giờ thứ <input type="number" name="time_cuoituan_gia_theo_gio[]" required  class="form-control" min="0" style="width:4em;"> </span></label><div class="col-sm-8"><input type="number" name="cuoituan_gia_theo_gio[]" required class="form-control"  min="0" /> <button onclick="deletePriceTime(\'priceTime' + numberPriceTime + '\')"><i class="fa fa-trash-o"></i></button></div></div>';

                                                $("#priceHour1").append(chuoi);

                                            }
                                        </script>
                                        <br/>
                                        <div class="form-group">
                                            <label class="col-sm-12">
                                                <span class="text-danger">
                                                    - Nếu ở quá 24h thì áp dụng phương thức tính giá theo ngày
                                                    <br />
                                                    - Nếu checkout sau thời điểm bắt đầu tính giá qua đêm thì áp dụng phương thức tính giá qua đêm
                                                    <br />
                                                    - Nếu ở quá quy định dưới đây thì tính thành 1 ngày 
                                                </span>
                                            </label>
                                        </div> 
                                        <?php foreach ($data['TypeRoom']['ngay_cuoi_tuan']['gia_theo_gio'] as $key => $gia) { ?>  
                                            <div class="form-group form-inline">
                                                <label class="col-sm-4 control-label" style="padding-top: 0;">Giờ thứ <input type="number" required name="time_cuoituan_gia_theo_gio[]" value="<?php echo $key; ?>" class="form-control" style="width: 4em;"></label>
                                                <div class="col-sm-8">
                                                    <input type="number" name="cuoituan_gia_theo_gio[]" value="<?php echo $gia; ?>"  class="form-control" min="0" required=""/>
                                                </div>
                                            </div>    
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h2 class="panel-title">Giá theo ngày</h2>  <br/>                                  
                                                <div class="form-group form-inline">
                                                    <label class="col-sm-3 control-label" style="padding-top: 0;">Giá</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" value="<?php echo $data['TypeRoom']['ngay_cuoi_tuan']['gia_ngay']; ?>" name="gia_ngay_cuoi_tuan" class="form-control" min="0" style="width: 100%;"/>
                                                    </div>
                                                </div> 
                                            </div>

                                            <div class="col-sm-6">
                                                <h2 class="panel-title">Giá qua đêm</h2>      <br/>                              
                                                <div class="form-group form-inline">
                                                    <label class="col-sm-3 control-label" style="padding-top: 0;">Giá</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" value="<?php echo $data['TypeRoom']['ngay_cuoi_tuan']['gia_qua_dem']; ?>" name="gia_qua_dem_ngay_cuoi_tuan" class="form-control" min="0" style="width: 100%;"/>
                                                    </div>
                                                </div>   
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 15px;">
                                            <div class="col-sm-12">
                                                Qua đêm từ 
                                                <select name="gio_qua_dem_ngay_cuoi_tuan_start" class="form-control" style="width: 75px;display: inline;">
                                                    <option value="24" <?php if (isset($data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_start']) && $data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_start'] == 24) echo 'selected'; ?>>24h</option>
                                                    <option value="23" <?php if (isset($data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_start']) && $data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_start'] == 23) echo 'selected'; ?>>23h</option>
                                                    <option value="22" <?php if (isset($data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_start']) && $data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_start'] == 22) echo 'selected'; ?>>22h</option>
                                                    <option value="21" <?php if (isset($data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_start']) && $data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_start'] == 21) echo 'selected'; ?>>21h</option>
                                                    <option value="20" <?php if (isset($data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_start']) && $data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_start'] == 20) echo 'selected'; ?>>20h</option>
                                                </select> 
                                                tối hôm trước đến 
                                                <select name="gio_qua_dem_ngay_cuoi_tuan_end" class="form-control" style="width: 75px;display: inline;">
                                                    <option value="1" <?php if (isset($data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end'] == 1) echo 'selected'; ?>>1h</option>
                                                    <option value="2" <?php if (isset($data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end'] == 2) echo 'selected'; ?>>2h</option>
                                                    <option value="3" <?php if (isset($data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end'] == 3) echo 'selected'; ?>>3h</option>
                                                    <option value="4" <?php if (isset($data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end'] == 4) echo 'selected'; ?>>4h</option>
                                                    <option value="5" <?php if (isset($data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end'] == 5) echo 'selected'; ?>>5h</option>
                                                    <option value="6" <?php if (isset($data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end'] == 6) echo 'selected'; ?>>6h</option>
                                                    <option value="7" <?php if (isset($data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end'] == 7) echo 'selected'; ?>>7h</option>
                                                    <option value="8" <?php if (isset($data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end'] == 8) echo 'selected'; ?>>8h</option>
                                                    <option value="9" <?php if (isset($data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end'] == 9) echo 'selected'; ?>>9h</option>
                                                    <option value="10" <?php if (isset($data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_cuoi_tuan']['gio_qua_dem_end'] == 10) echo 'selected'; ?>>10h</option>
                                                </select> 
                                                sáng hôm sau
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <br/>
                                <div class="panel-body">
                                    <div class="col-md-6" id="checkout1">
                                        <h2 class="panel-title">Phụ trội quá giờ Checkout (theo ngày)</h2><a href="javascript:void( 0 );" onclick="addcheckout1();"><img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/images.png" alt="" title=""/></a>
                                        <script>
                                            function addcheckout1()
                                            {
                                                numberPriceTime++;
                                                var chuoi = '<div id="priceTime' + numberPriceTime + '" class="form-group form-inline"><label class="col-sm-4 control-label" style="padding-top:0;"><span>Giờ thứ <input type="number" required  name="time_cuoituan_phu_troi_checkout_ngay[]" class="form-control" min="0" style="width:4em;"> </span></label><div class="col-sm-8"><input type="number" required name="cuoituan_phu_troi_checkout_ngay[]" class="form-control"  min="0" /> <button onclick="deletePriceTime(\'priceTime' + numberPriceTime + '\')"><i class="fa fa-trash-o"></i></button></div></div>';

                                                $("#checkout1").append(chuoi);

                                            }
                                        </script>
                                        <br/>
                                        <div class="form-group">
                                            <label class="col-sm-12"><span class="text-danger">Nếu ở quá quy định dưới đây thì tính thành 1 ngày</span></label>
                                        </div>     
                                        <?php foreach ($data['TypeRoom']['ngay_cuoi_tuan']['phu_troi_checkout_ngay'] as $key => $gia) { ?>  
                                            <div class="form-group form-inline">

                                                <label class="col-sm-4 control-label" style="padding-top: 0;">Giờ thứ <input type="number" name="time_cuoituan_phu_troi_checkout_ngay[]" value="<?php echo $key; ?>" class="form-control" style="width: 4em;"></label>
                                                <div class="col-sm-8">
                                                    <input type="number" name="cuoituan_phu_troi_checkout_ngay[]" value="<?php echo $gia; ?>" required class="form-control" min="0" />
                                                </div>
                                            </div>   
                                        <?php } ?>

                                    </div>


                                    <div class="col-md-6" id="checkoutnight1">
                                        <h2 class="panel-title">Phụ trội quá giờ Checkout (qua đêm)</h2><a href="javascript:void( 0 );" onclick="addcheckoutnight1();"><img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/images.png" alt="" title=""/></a>
                                        <script>
                                            function addcheckoutnight1()
                                            {
                                                numberPriceTime++;
                                                var chuoi = '<div id="priceTime' + numberPriceTime + '" class="form-group form-inline"><label class="col-sm-4 control-label" style="padding-top:0;"><span>Giờ thứ <input type="number" required name="time_cuoituan_phu_troi_checkout_dem[]" class="form-control" min="0" style="width:4em;"> </span></label><div class="col-sm-8"><input type="number" required name="cuoituan_phu_troi_checkout_dem[]" class="form-control"  min="0" /> <button onclick="deletePriceTime(\'priceTime' + numberPriceTime + '\')"><i class="fa fa-trash-o"></i></button></div></div>';

                                                $("#checkoutnight1").append(chuoi);

                                            }
                                        </script>
                                        <br/>
                                        <div class="form-group">
                                            <label class="col-sm-12"><span class="text-danger">Nếu ở quá quy định dưới đây thì tính thành 1 ngày</span></label>
                                        </div> 
                                        <?php foreach ($data['TypeRoom']['ngay_cuoi_tuan']['phu_troi_checkout_dem'] as $key => $gia) { ?>  
                                            <div class="form-group form-inline">

                                                <label class="col-sm-4 control-label" style="padding-top: 0;">Giờ thứ <input type="number" name="time_cuoituan_phu_troi_checkout_dem[]"  value="<?php echo $key; ?>" class="form-control" style="width: 4em;"></label>
                                                <div class="col-sm-8">
                                                    <input type="number" required name="cuoituan_phu_troi_checkout_dem[]" value="<?php echo $gia; ?>" class="form-control" min="0" />
                                                </div>
                                            </div>  
                                        <?php } ?>
                                    </div> 
                                </div>
                                <br/>
                                <div class="panel-body">
                                    <div class="col-md-6" id="checkinearly1">
                                        <h2 class="panel-title">Phụ trội Ckeckin sớm (theo ngày)</h2><a href="javascript:void( 0 );" onclick="addcheckinearly1();"><img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/images.png" alt="" title=""/></a>
                                        <script>
                                            function addcheckinearly1()
                                            {
                                                numberPriceTime++;
                                                var chuoi = '<div id="priceTime' + numberPriceTime + '" class="form-group form-inline"><label class="col-sm-4 control-label" style="padding-top:0;"><span>Giờ thứ <input type="number" required name="time_cuoituan_phu_troi_checkin_ngay[]" class="form-control" min="0" style="width:4em;"> </span></label><div class="col-sm-8"><input type="number" required name="cuoituan_phu_troi_checkin_ngay[]" class="form-control"  min="0" /> <button onclick="deletePriceTime(\'priceTime' + numberPriceTime + '\')"><i class="fa fa-trash-o"></i></button></div></div>';

                                                $("#checkinearly1").append(chuoi);

                                            }
                                        </script>

                                        <div class="form-group">
                                            <label class="col-sm-12"><span class="text-danger">Nếu ở quá quy định dưới đây thì tính thành 1 ngày</span></label>
                                        </div> 
                                        <?php foreach ($data['TypeRoom']['ngay_cuoi_tuan']['phu_troi_checkin_ngay'] as $key => $gia) { ?>  
                                            <div class="form-group form-inline">

                                                <label class="col-sm-4 control-label" style="padding-top: 0;">Giờ thứ <input type="number" required name="time_cuoituan_phu_troi_checkin_ngay[]" value="<?php echo $key; ?>" class="form-control" style="width: 4em;"></label>
                                                <div class="col-sm-8">
                                                    <input type="number" name="cuoituan_phu_troi_checkin_ngay[]" value="<?php echo $gia; ?>" class="form-control" min="0" required=""/>
                                                </div>
                                            </div>                                                                         
                                        <?php } ?>
                                    </div>

                                    <div class="col-md-6" id="checkinnight1">
                                        <h2 class="panel-title">Phụ trội Checkin sớm (qua đêm)</h2><a href="javascript:void( 0 );" onclick="addcheckinnight1();"><img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/images.png" alt="" title=""/></a>
                                        <script>
                                            function addcheckinnight1()
                                            {
                                                numberPriceTime++;
                                                var chuoi = '<div id="priceTime' + numberPriceTime + '" class="form-group form-inline"><label class="col-sm-4 control-label" style="padding-top:0;"><span>Giờ thứ <input type="number" required name="time_cuoituan_phu_troi_checkin_dem[]" class="form-control" min="0" style="width:4em;"> </span></label><div class="col-sm-8"><input type="number" required name="cuoituan_phu_troi_checkin_dem[]" class="form-control"  min="0" /> <button onclick="deletePriceTime(\'priceTime' + numberPriceTime + '\')"><i class="fa fa-trash-o"></i></button></div></div>';

                                                $("#checkinnight1").append(chuoi);

                                            }
                                        </script>
                                        <br/>
                                        <div class="form-group">
                                            <label class="col-sm-12"><span class="text-danger">Nếu ở quá quy định dưới đây thì tính thành 1 ngày</span></label>
                                        </div> 
                                        <?php foreach ($data['TypeRoom']['ngay_cuoi_tuan']['phu_troi_checkin_dem'] as $key => $gia) { ?>  
                                            <div class="form-group form-inline">

                                                <label class="col-sm-4 control-label" style="padding-top: 0;">Giờ thứ <input type="number" name="time_cuoituan_phu_troi_checkin_dem[]" value="<?php echo $key; ?>" class="form-control" style="width: 4em;"></label>
                                                <div class="col-sm-8">
                                                    <input type="number" name="cuoituan_phu_troi_checkin_dem[]" value="<?php echo $gia; ?>" required class="form-control" min="0" />
                                                </div>
                                            </div>     
                                        <?php } ?>
                                    </div>                                
                                </div>
                                <br/>
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <h2 class="panel-title">Phụ trội thêm khách - Extra Bed</h2>
                                        <br/>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Tiếp mỗi người: <span class="required">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="number" name="cuoituan_phu_troi_them_khach" value="<?php echo $data['TypeRoom']['ngay_cuoi_tuan']['phu_troi_them_khach']; ?>" class="form-control" min="0" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h2 class="panel-title">Ghi chú</h2>
                                        <br/>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Ghi chú:</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="cuoituan_note"  type="text" rows="5"><?php echo @$data['TypeRoom']['ngay_cuoi_tuan']['note']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="ngayle" class="tab-pane fade in">
                            <p><input name="ngayle_nhu_ngaythuong" type="checkbox" value="1" <?php if(!empty($data['TypeRoom']['ngayle_nhu_ngaythuong'])) echo 'checked';?>  onclick="showBodyPrice('bodyNgayle');" /> Ngày lễ tính giá như ngày thường</p>
                            <div id="bodyNgayle" <?php if(!empty($data['TypeRoom']['ngayle_nhu_ngaythuong'])) echo 'style="display: none;"';?> >
                                <div class="panel-body">
                                    <div class="col-md-6" id="priceHour2">	
                                        <h2 class="panel-title">Giá theo giờ</h2><a href="javascript:void( 0 );" onclick="addPriceHour2();"><img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/images.png" alt="" title=""/></a>
                                        <script>
                                            function addPriceHour2()
                                            {
                                                numberPriceTime++;
                                                var chuoi = '<div id="priceTime' + numberPriceTime + '" class="form-group form-inline"><label class="col-sm-4 control-label" style="padding-top:0;"><span>Giờ thứ <input type="number" required name="time_ngayle_gia_theo_gio[]" class="form-control" min="0" style="width:4em;"> </span></label><div class="col-sm-8"><input type="number" name="ngayle_gia_theo_gio[]" required class="form-control"  min="0" /> <button onclick="deletePriceTime(\'priceTime' + numberPriceTime + '\')"><i class="fa fa-trash-o"></i></button></div></div>';

                                                $("#priceHour2").append(chuoi);

                                            }
                                        </script>
                                        <br/>
                                        <div class="form-group">
                                            <label class="col-sm-12">
                                                <span class="text-danger">
                                                    - Nếu ở quá 24h thì áp dụng phương thức tính giá theo ngày
                                                    <br />
                                                    - Nếu checkout sau thời điểm bắt đầu tính giá qua đêm thì áp dụng phương thức tính giá qua đêm
                                                    <br />
                                                    - Nếu ở quá quy định dưới đây thì tính thành 1 ngày 
                                                </span>
                                            </label>
                                        </div> 
                                        <?php foreach ($data['TypeRoom']['ngay_le']['gia_theo_gio'] as $key => $gia) { ?>  
                                            <div class="form-group form-inline">

                                                <label class="col-sm-4 control-label" style="padding-top: 0;">Giờ thứ <input type="number" name="time_ngayle_gia_theo_gio[]" value="<?php echo $key; ?>" class="form-control" style="width: 4em;"></label>
                                                <div class="col-sm-8">
                                                    <input type="number" name="ngayle_gia_theo_gio[]" value="<?php echo $gia; ?>" required  class="form-control" min="0" />
                                                </div>
                                            </div>   
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h2 class="panel-title">Giá theo ngày</h2>  <br/>                                  
                                                <div class="form-group form-inline">
                                                    <label class="col-sm-3 control-label" style="padding-top: 0;">Giá</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" value="<?php echo $data['TypeRoom']['ngay_le']['gia_ngay']; ?>" name="gia_ngay_le" class="form-control" min="0" style="width: 100%;"/>
                                                    </div>
                                                </div> 
                                            </div>

                                            <div class="col-sm-6">
                                                <h2 class="panel-title">Giá qua đêm</h2>      <br/>                              
                                                <div class="form-group form-inline">
                                                    <label class="col-sm-3 control-label" style="padding-top: 0;">Giá</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" value="<?php echo $data['TypeRoom']['ngay_le']['gia_qua_dem']; ?>" name="gia_qua_dem_ngay_le" class="form-control" min="0" style="width: 100%;"/>
                                                    </div>
                                                </div>   
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 15px;">
                                            <div class="col-sm-12">
                                                Qua đêm từ 
                                                <select name="gio_qua_dem_ngay_le_start" class="form-control" style="width: 75px;display: inline;">
                                                    <option value="24" <?php if (isset($data['TypeRoom']['ngay_le']['gio_qua_dem_start']) && $data['TypeRoom']['ngay_le']['gio_qua_dem_start'] == 24) echo 'selected'; ?>>24h</option>
                                                    <option value="23" <?php if (isset($data['TypeRoom']['ngay_le']['gio_qua_dem_start']) && $data['TypeRoom']['ngay_le']['gio_qua_dem_start'] == 23) echo 'selected'; ?>>23h</option>
                                                    <option value="22" <?php if (isset($data['TypeRoom']['ngay_le']['gio_qua_dem_start']) && $data['TypeRoom']['ngay_le']['gio_qua_dem_start'] == 22) echo 'selected'; ?>>22h</option>
                                                    <option value="21" <?php if (isset($data['TypeRoom']['ngay_le']['gio_qua_dem_start']) && $data['TypeRoom']['ngay_le']['gio_qua_dem_start'] == 21) echo 'selected'; ?>>21h</option>
                                                    <option value="20" <?php if (isset($data['TypeRoom']['ngay_le']['gio_qua_dem_start']) && $data['TypeRoom']['ngay_le']['gio_qua_dem_start'] == 20) echo 'selected'; ?>>20h</option>
                                                </select> 
                                                tối hôm trước đến 
                                                <select name="gio_qua_dem_ngay_le_end" class="form-control" style="width: 75px;display: inline;">
                                                    <option value="1" <?php if (isset($data['TypeRoom']['ngay_le']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_le']['gio_qua_dem_end'] == 1) echo 'selected'; ?>>1h</option>
                                                    <option value="2" <?php if (isset($data['TypeRoom']['ngay_le']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_le']['gio_qua_dem_end'] == 2) echo 'selected'; ?>>2h</option>
                                                    <option value="3" <?php if (isset($data['TypeRoom']['ngay_le']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_le']['gio_qua_dem_end'] == 3) echo 'selected'; ?>>3h</option>
                                                    <option value="4" <?php if (isset($data['TypeRoom']['ngay_le']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_le']['gio_qua_dem_end'] == 4) echo 'selected'; ?>>4h</option>
                                                    <option value="5" <?php if (isset($data['TypeRoom']['ngay_le']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_le']['gio_qua_dem_end'] == 5) echo 'selected'; ?>>5h</option>
                                                    <option value="6" <?php if (isset($data['TypeRoom']['ngay_le']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_le']['gio_qua_dem_end'] == 6) echo 'selected'; ?>>6h</option>
                                                    <option value="7" <?php if (isset($data['TypeRoom']['ngay_le']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_le']['gio_qua_dem_end'] == 7) echo 'selected'; ?>>7h</option>
                                                    <option value="8" <?php if (isset($data['TypeRoom']['ngay_le']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_le']['gio_qua_dem_end'] == 8) echo 'selected'; ?>>8h</option>
                                                    <option value="9" <?php if (isset($data['TypeRoom']['ngay_le']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_le']['gio_qua_dem_end'] == 9) echo 'selected'; ?>>9h</option>
                                                    <option value="10" <?php if (isset($data['TypeRoom']['ngay_le']['gio_qua_dem_end']) && $data['TypeRoom']['ngay_le']['gio_qua_dem_end'] == 10) echo 'selected'; ?>>10h</option>
                                                </select> 
                                                sáng hôm sau
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <br/>
                                <div class="panel-body">
                                    <div class="col-md-6" id="checkout2">
                                        <h2 class="panel-title">Phụ trội quá giờ Checkout (theo ngày)</h2><a href="javascript:void( 0 );" onclick="addcheckout2();"><img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/images.png" alt="" title=""/></a>
                                        <script>
                                            function addcheckout2()
                                            {
                                                numberPriceTime++;
                                                var chuoi = '<div id="priceTime' + numberPriceTime + '" class="form-group form-inline"><label class="col-sm-4 control-label" style="padding-top:0;"><span>Giờ thứ <input type="number" required name="time_ngayle_phu_troi_checkout_ngay[]" class="form-control" min="0" style="width:4em;"> </span></label><div class="col-sm-8"><input type="number" required name="ngayle_phu_troi_checkout_ngay[]" class="form-control"  min="0" /> <button onclick="deletePriceTime(\'priceTime' + numberPriceTime + '\')"><i class="fa fa-trash-o"></i></button></div></div>';

                                                $("#checkout2").append(chuoi);

                                            }
                                        </script>
                                        <br/>
                                        <div class="form-group">
                                            <label class="col-sm-12"><span class="text-danger">Nếu ở quá quy định dưới đây thì tính thành 1 ngày</span></label>
                                        </div>    
                                        <?php foreach ($data['TypeRoom']['ngay_le']['phu_troi_checkout_ngay'] as $key => $gia) { ?>  
                                            <div class="form-group form-inline">

                                                <label class="col-sm-4 control-label" style="padding-top: 0;">Giờ thứ <input type="number" name="time_ngayle_phu_troi_checkout_ngay[]" value="<?php echo $key; ?>" class="form-control" style="width: 4em;"></label>
                                                <div class="col-sm-8">
                                                    <input type="number" required name="ngayle_phu_troi_checkout_ngay[]" value="<?php echo $gia; ?>" class="form-control" min="0" />
                                                </div>
                                            </div>   
                                        <?php } ?>
                                    </div>


                                    <div class="col-md-6" id="checkoutnight2">
                                        <h2 class="panel-title">Phụ trội quá giờ Checkout (qua đêm)</h2><a href="javascript:void( 0 );" onclick="addcheckoutnight2();"><img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/images.png" alt="" title=""/></a>
                                        <script>
                                            function addcheckoutnight2()
                                            {
                                                numberPriceTime++;
                                                var chuoi = '<div id="priceTime' + numberPriceTime + '" class="form-group form-inline"><label class="col-sm-4 control-label" style="padding-top:0;"><span>Giờ thứ <input type="number"  name="time_ngayle_phu_troi_checkout_dem[]" class="form-control" required min="0" style="width:4em;"> </span></label><div class="col-sm-8"><input type="number" required name="ngayle_phu_troi_checkout_dem[]" class="form-control"  min="0" /> <button onclick="deletePriceTime(\'priceTime' + numberPriceTime + '\')"><i class="fa fa-trash-o"></i></button></div></div>';

                                                $("#checkoutnight2").append(chuoi);

                                            }
                                        </script>
                                        <br/>
                                        <div class="form-group">
                                            <label class="col-sm-12"><span class="text-danger">Nếu ở quá quy định dưới đây thì tính thành 1 ngày</span></label>
                                        </div> 
                                        <?php foreach ($data['TypeRoom']['ngay_le']['phu_troi_checkout_dem'] as $key => $gia) { ?>  
                                            <div class="form-group form-inline">

                                                <label class="col-sm-4 control-label" style="padding-top: 0;">Giờ thứ <input type="number" name="time_ngayle_phu_troi_checkout_dem[]"  required value="<?php echo $key; ?>" class="form-control" style="width: 4em;"></label>
                                                <div class="col-sm-8">
                                                    <input type="number" required value="<?php echo $gia; ?>" name="ngayle_phu_troi_checkout_dem[]" class="form-control" min="0" />
                                                </div>
                                            </div>     <?php } ?>                                  
                                    </div>

                                </div>
                                <br/>
                                <div class="panel-body">
                                    <div class="col-md-6" id="checkinearly2">
                                        <h2 class="panel-title">Phụ trội Ckeckin sớm (theo ngày)</h2><a href="javascript:void( 0 );" onclick="addcheckinearly2();"><img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/images.png" alt="" title=""/></a>
                                        <script>
                                            function addcheckinearly2()
                                            {
                                                numberPriceTime++;
                                                var chuoi = '<div id="priceTime' + numberPriceTime + '" class="form-group form-inline"><label class="col-sm-4 control-label" style="padding-top:0;"><span>Giờ thứ <input type="number" required name="time_ngayle_phu_troi_checkin_ngay[]" class="form-control" min="0" style="width:4em;"> </span></label><div class="col-sm-8"><input type="number" name="ngayle_phu_troi_checkin_ngay[]" required class="form-control"  min="0" /> <button onclick="deletePriceTime(\'priceTime' + numberPriceTime + '\')"><i class="fa fa-trash-o"></i></button></div></div>';

                                                $("#checkinearly2").append(chuoi);

                                            }
                                        </script>
                                        <br/>
                                        <div class="form-group">
                                            <label class="col-sm-12"><span class="text-danger">Nếu ở quá quy định dưới đây thì tính thành 1 ngày</span></label>
                                        </div> 
                                        <?php foreach ($data['TypeRoom']['ngay_le']['phu_troi_checkin_ngay'] as $key => $gia) { ?>  
                                            <div class="form-group form-inline">

                                                <label class="col-sm-4 control-label" style="padding-top: 0;">Giờ thứ <input type="number" name="time_ngayle_phu_troi_checkin_ngay[]" required value="<?php echo $key; ?>" class="form-control" style="width: 4em;"></label>
                                                <div class="col-sm-8">
                                                    <input type="number" value="<?php echo $gia; ?>" name="ngayle_phu_troi_checkin_ngay[]" required class="form-control" min="0" />
                                                </div>
                                            </div>                                                                        
                                        <?php } ?>
                                    </div>

                                    <div class="col-md-6" id="checkinnight2">
                                        <h2 class="panel-title">Phụ trội Checkin sớm (qua đêm)</h2><a href="javascript:void( 0 );" onclick="addcheckinnight2();"><img src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/images/images.png" alt="" title=""/></a>
                                        <script>
                                            function addcheckinnight2()
                                            {
                                                numberPriceTime++;
                                                var chuoi = '<div id="priceTime' + numberPriceTime + '" class="form-group form-inline"><label class="col-sm-4 control-label" style="padding-top:0;"><span>Giờ thứ <input type="number" name="time_ngayle_phu_troi_checkin_dem[]" required class="form-control" min="0" style="width:4em;"> </span></label><div class="col-sm-8"><input type="number" name="ngayle_phu_troi_checkin_dem[]" required class="form-control"  min="0" /> <button onclick="deletePriceTime(\'priceTime' + numberPriceTime + '\')"><i class="fa fa-trash-o"></i></button></div></div>';

                                                $("#checkinnight2").append(chuoi);

                                            }
                                        </script>
                                        <br/>
                                        <div class="form-group">
                                            <label class="col-sm-12"><span class="text-danger">Nếu ở quá quy định dưới đây thì tính thành 1 ngày</span></label>
                                        </div> 
                                        <?php foreach ($data['TypeRoom']['ngay_le']['phu_troi_checkin_dem'] as $key => $gia) { ?>  
                                            <div class="form-group form-inline">

                                                <label class="col-sm-4 control-label" style="padding-top: 0;">Giờ thứ <input type="number" required name="time_ngayle_phu_troi_checkin_dem[]"  value="<?php echo $key; ?>" class="form-control" style="width: 4em;"></label>
                                                <div class="col-sm-8">
                                                    <input type="number"  value="<?php echo $gia; ?>" name="ngayle_phu_troi_checkin_dem[]" required class="form-control" min="0" />
                                                </div>
                                            </div>   
                                        <?php } ?>
                                    </div>                                
                                </div>
                                <br/> 
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <h2 class="panel-title">Phụ trội thêm khách - Extra Bed</h2>
                                        <br/>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Tiếp mỗi người: <span class="required">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ngayle_phu_troi_them_khach" value="<?php echo $data['TypeRoom']['ngay_le']['phu_troi_them_khach']; ?>" required class="form-control" min="0" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h2 class="panel-title">Ghi chú</h2>
                                        <br/>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Ghi chú:</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="ngayle_note" type="text" rows="5"><?php echo @$data['TypeRoom']['ngay_le']['note']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="hanghoa" class="tab-pane fade in">
                            <div class="panel-body">
                                <h2 class="panel-title text-center">Danh sách Hàng hóa - Dịch vụ</h2>
                                <br/>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mb-none" >
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên hàng</th>
                                                <th>Loại hàng</th>
                                                <th>Số lượng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $dem = 0;
                                            if (!empty($listDataMerchandise))
                                                foreach ($listDataMerchandise as $merchan) {
                                                    $dem++;
                                                    echo '
                                                    <tr class="gradeX">
                                                        <input type="hidden" name="mechan[]" value="' . $merchan['Merchandise']['id'] . '" />
                                                        <td>' . $dem . '</td>
                                                        <td>' . $merchan['Merchandise']['name'] . '</td>
                                                        <td>' . $listMerchandiseGroup[$merchan['Merchandise']['type_merchandise']] . '</td>
                                                        <td><input type="number" name="countMechan[]" class="form-control" min="0" value="' . @$data['TypeRoom']['hang_hoa'][$merchan['Merchandise']['id']] . '"/></td>                                             
                                                    </tr>
                                                ';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="text-center">
                                <button class="btn btn-primary" type="submit">Sửa</button>
                                <button type="reset" class="btn btn-default">Hủy</button>
                            </div>
                        </div>
                    </footer>
                </section>
            </form>
        </div>
    </div>
    <!-- end: page -->
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>