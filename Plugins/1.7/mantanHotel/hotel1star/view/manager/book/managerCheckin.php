<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-left.php'; ?>

<script type="text/javascript">
    var urlHomes= '<?php echo $urlHomes;?>';
    function checkKhachDoan(type)
    {
        if(type=='co'){
            $.ajax({
              type: "POST",
              url: urlHomes+"ajaxListKhachDoan",
              data: {}
            }).done(function( msg ) {
                $('#listKhachDoan').html(msg);
                $('#listKhachDoanColor').fadeIn();
                $('#colorGroup').val('');

            })
            .fail(function() {
                alert('Quá trình load gặp lỗi !');
                return false;
            });
        }else{
            $('#listKhachDoan').html('');
            $('#listKhachDoanColor').fadeOut();
        }
    }

    function checkSelectDoan(type)
    {
        if(type=='new'){
            document.getElementById("colorGroup").disabled= false;
        }else{
            document.getElementById("colorGroup").disabled= true;
        }
    }
</script>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Nhận phòng</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php global $urlHomeManager; echo $urlHomeManager; ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Nhận phòng</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($mess)) { ?>
                    <p style="font-weight: bold; color: red;"> <?php echo $mess; ?></p>
                <?php } ?> 
            <form id="summary-form" action="" method="post" class="form-horizontal">
				<input name="idroom" type="hidden" value="<?php echo $dataRoom['Room']['id']; ?>" />
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Nhận phòng: <?php echo $dataRoom['Room']['name']; ?></h2>
                    </header>
                    <div class="panel-body">
                        <div class="row">
							<div class="col-md-6">
                                <h2 class="panel-title"> Thông tin khách hàng</h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Khách đoàn: <span class="required"></span></label>
                                    <div class="col-sm-8">                                    
                                        <select id="company" name="khachDoan" class="form-control" onchange="checkKhachDoan(this.value);">
                                            <option value="khong" >Không</option>
                                            <option value="co" >Có</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="listKhachDoan"></div>
                                <div class="form-group" id="listKhachDoanColor" style="display: none;">
                                    <label class="col-sm-4 control-label">Chọn màu: <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group color colorpicker-element" data-color="rgb(255, 146, 180)" data-color-format="rgb" data-plugin-colorpicker="">
                                            <span class="input-group-addon"><i style="background-color: rgb(255, 146, 180);"></i></span>
                                            <input type="text" name="color" id="colorGroup" class="form-control" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Số CMND (Passport):</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="cmnd" id="cmnd" class="form-control" placeholder="Nhập số CMND/Passport"/>
                                    </div>
                                </div>
								<div class="text-center">
									<a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="getUser();">Tìm khách hàng</a>
								</div>
								<div id="ajax">
                                    <br />
                                    <input name="idUser" type="hidden" value="" />
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Tên khách hàng:</label>
                                        <div class="col-sm-8">                                    
                                            <input type="text" name="cus_name" class="form-control" value=""  />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Địa chỉ:</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="cus_address"  class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Điện thoại:</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="phone" class="form-control" value=""  />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Email:</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="email" class="form-control" value=""  />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Ngày sinh:</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="birthday" id="birthday" value="" data-plugin-datepicker class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Quốc tịch:</label>
                                        <div class="col-sm-8">
                                            <select id="company" name="nationality" class="form-control">
                                                <?php
                                                    $listCountry= getListCountry();
                                                    foreach($listCountry as $country){
                                                        echo '<option value="'.$country['id'].'" >'.$country['name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                            <label class="error" for="room"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Biển số xe:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="bienSoXe" class="form-control" value=""  />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Tài khoản ManMo:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="user" class="form-control" value=""  />
                                    </div>
                                </div>
                                
								<script>
									function getUser()
									{
										var cmnd=document.getElementById('cmnd').value;
										var urlHomes= '<?php echo $urlHomes; ?>';
										$.ajax({
										  type: "POST",
										  url: urlHomes+"ajaxCusForCheckIn",
										  data: { cmnd:cmnd}
										}).done(function( msg ) {
										$('#ajax').html(msg);
										})
										.fail(function() {
											alert('Quá trình load gặp lỗi !');
											return false;
										});
									}
								</script>
								
                            </div>
                        
                            <div class="col-md-6">
                                <h2 class="panel-title"> Thông tin đăng ký - <?php echo $typeRoom['TypeRoom']['roomtype']; ?></h2>
                                <br/>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Ngày vào: <span class="required">*</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" name="date_checkin" id="date_checkin" value="<?php echo $today['mday'].'/'.$today['mon'].'/'.$today['year'];?>" data-plugin-datepicker class="form-control" required />                                          
                                            <span class="input-group-addon">lúc</span>
                                            <input type="text" name="time_checkin" id="time_checkin" value="<?php echo $today['hours'].':'.$today['minutes'];?>" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false}' required />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Ngày ra dự kiến:</label>
                                    <div class="col-md-8">
                                        <div class="input-group">                                            
                                            <input type="text" name="date_checkout_foresee" data-plugin-datepicker class="form-control"/>                                          
                                            <span class="input-group-addon">lúc</span>
                                            <input type="text" name="time_checkout_foresee" value="<?php echo $today['hours'].':'.$today['minutes'];?>" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false }'>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Đăng ký ở: <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <select id="typeCheckin" onchange="getPrice();" class="form-control" name="type_register" required >
                                            <option value="">-Chọn-</option>
                                            <?php
                                                global $typeRegister;
                                                foreach($typeRegister as $key=>$value){
                                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    function getPrice()
                                    {
                                        var typeCheckin = document.getElementById('typeCheckin').value;
                                        var typeRoom = '<?php echo $typeRoom['TypeRoom']['id']; ?>'
                                        var date_checkin=document.getElementById('date_checkin').value;
                                        var time_checkin=document.getElementById('time_checkin').value;
                                        
                                        if (typeCheckin=='linh_hoat')
                                        {
                                            if (date_checkin=='' || time_checkin=='')
                                            {
                                                alert ('Bạn cần phải chọn đầy đủ ngày và giờ check in!');
                                            }else{
                                                $('#price').prop('disabled', false);
                                            }
                                        }
                                        else
                                        {
                                            if (typeCheckin=='')
                                            {
                                                alert('Bạn phải chọn 1 kiểu đăng ký ở!');
                                            }else if (date_checkin=='' || time_checkin=='')
                                            {
                                                alert ('Bạn cần phải chọn đầy đủ ngày và giờ check in!');
                                            }else if (date_checkin!='' && time_checkin!='' && typeCheckin!='')
                                            {
                                                var urlHomes= '<?php echo $urlHomes; ?>';
                                                $.ajax({
                                                  type: "POST",
                                                  url: urlHomes+"ajaxPriceCheckIn",
                                                  data: { typeRoom:typeRoom,typeCheckin:typeCheckin,date_checkin:date_checkin,time_checkin:time_checkin}
                                                }).done(function( msg ) {
                                                    $('#ajaxPrice').html(msg);
                                                })
                                                .fail(function() {
                                                    alert('Quá trình load gặp lỗi !');
                                                    return false;
                                                });
                                            }
                                        }
                                    }

                                </script>
                                <div id="ajaxPrice">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Giá phòng: <span class="required">*</span></label>
                                        <div class="col-md-8">
                                            <input type="number" name="price" id="price" class="form-control" required="required" disabled  />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group" style="margin-bottom: 15px;">
                                        <label class="col-md-4 control-label">Khuyến mại:</label>
                                        <div class="col-md-8">
                                            <input type="number" name="promotion" value="" class="form-control" />
                                            <p>Giá trị khuyến mại nhỏ hơn 100 thì hiểu là giảm theo phần trăm</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Chu kỳ thanh toán:</label>
                                    <div class="col-md-8">
                                        <select id="" class="form-control" name="paymentCycle" >
                                            <?php
                                                global $paymentCycle;
                                                foreach($paymentCycle as $key=>$value){
                                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Tiền đặt cọc:</label>
                                    <div class="col-md-8">
                                        <input type="number" name="prepay" value="0" class="form-control" required="required"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Số lượng người: <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                            <input min="1" type="number" name="number_people" id="number_people" class="form-control" required="required" value="<?php echo $typeRoom['TypeRoom']['so_nguoi']; ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Email người giới thiệu:</label>
                                    <div class="col-md-8">
                                        <input type="email" name="agency" value="" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Ghi chú checkin:</label>
                                    <div class="col-sm-8">
                                        <textarea name="note" class="form-control" type="text" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Nhận phòng</button>
                                <a href="<?php echo $urlHomes.'managerHotelDiagram';?>">
                                    <input type="button" value="Hủy" class="btn btn-default" />
                                </a>
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
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-right.php'; ?>