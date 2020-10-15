<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thông tin đặt phòng</h2>

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
                <li><span>Người dùng đặt phòng</span></li>
                <li> <a href="<?php echo $urlNow; ?>"><span>Danh sách phòng đã đặt</span></a></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="fa fa-caret-down"></a>
                <a href="#" class="fa fa-times"></a>
            </div>

            <h2 class="panel-title">Danh sách phòng khách hàng đã đặt</h2>
        </header>
        <div class="panel-body">
            <form class="" method="post" action="">
                <div class="form-group col-sm-6">
                    <i>Họ và tên:</i>
                    <input type="text" name="name" value="<?php echo @$data['Order']['name'] ?>" class="form-control" required="">                                          
                </div>
                <div class="form-group col-sm-6">
                    <i>Số ĐT:</i>
                    <input type="text" name="phone" value="<?php echo @$data['Order']['phone'] ?>" class="form-control" required="">                                          
                </div>
                <div class="form-group col-sm-6">
                    <i>Email:</i>
                    <input type="email" name="email" value="<?php echo @$data['Order']['email'] ?>" class="form-control" required="">                                          
                </div>
                <div class="form-group col-sm-6">
                    <img src="<?php echo $urlThemeActive; ?>images/calendar.gif" alt="..." title="...">
                    <i>Ngày đến</i>
                    <input type="text" data-plugin-datepicker  name="date_start" placeholder="YY-mm-dd" value="<?php echo @$data['Order']['date_start']; ?>" class="form-control" required="">                                          
                </div>
                <div class="form-group col-sm-6">
                    <img src="<?php echo $urlThemeActive; ?>images/calendar.gif" alt="..." title="...">
                    <i>Ngày đi</i>
                    <input type="text" data-plugin-datepicker  name="date_end" placeholder="YY-mm-dd" value="<?php echo @$data['Order']['date_end']; ?>" class="form-control" required="">                                          
                </div>
                <div class="form-group col-sm-6">
    
                    <i>Loại phòng</i>
                    <select name="typeRoom" class="form-control">
                        <option value="">Chưa xác định</option>
                        <?php
                            if(!empty($listTypeRoom)){
                                foreach($listTypeRoom as $typeRoom){
                                    if(!isset($data['Order']['typeRoom']) || $typeRoom['TypeRoom']['id']!=$data['Order']['typeRoom']){
                                        echo '<option value="'.$typeRoom['TypeRoom']['id'].'">'.$typeRoom['TypeRoom']['roomtype'].'</option>';
                                    }else{
                                        echo '<option selected value="'.$typeRoom['TypeRoom']['id'].'">'.$typeRoom['TypeRoom']['roomtype'].'</option>';
                                    }
                                }
                            }
                        ?>
                    </select>                                          
                </div>
                <div class="form-group col-sm-6">
    
                    <i>Số phòng</i>
                    <input type="number" name="number_room" value="<?php echo @$data['Order']['number_room'] ?>" class="form-control" required="">                                          
                </div>
                <div class="form-group col-sm-6">
    
                    <i>Số người lớn</i>
                    <input type="number" name="number_people" value="<?php echo @$data['Order']['number_people'] ?>" class="form-control" required="">                                          
                </div>
                <div class="form-group col-sm-6">
                    <i>Giá thỏa thuận / ngày</i>
                    <input type="number" name="price" value="<?php echo @$data['Order']['price'] ?>" class="form-control" required="">                                          
                </div>
                <div class="form-group col-sm-6">
                    <i>Trả trước</i>
                    <input type="number" name="prepay" value="<?php echo (int) @$data['Order']['prepay'] ?>" class="form-control" required="">                                          
                </div>
                <div class="form-group col-sm-6">
                    <i>Email người giới thiệu</i>
                    <input type="email" name="agency" value="<?php echo @$data['Order']['agency'] ?>" class="form-control" />                                          
                </div>
                <div class="form-group col-sm-12">
    
                    <label class="col-sm-12" ><strong>Dự kiến xếp phòng</strong></label>
                    <?php
                        foreach($listFloor as $floor){
                            echo '<div class="col-sm-6"><p><b>'.$floor['Floor']['name'].'</b></p>';
                            
                            if(!empty($listRooms[$floor['Floor']['id']])){
                                foreach($listRooms[$floor['Floor']['id']] as $room){
                                    if(isset($data['Order']['listRooms']) && in_array($room['Room']['id'],$data['Order']['listRooms'])){
                                        $checked= 'checked';
                                    }else{
                                        $checked= '';
                                    }
                                    echo '  <div class="form-group col-sm-3">
                                                <div class="checkbox-custom chekbox-primary">
                                                    <input '.$checked.' type="checkbox" name="listRooms[]" value="'.$room['Room']['id'].'" />
        											<label>'.$room['Room']['name'].'</label>
        										</div>
                                            </div>';
                                }
                            }
                            echo '</div>';
                        }
                    ?>                                         
                </div>
                <div class="form-group col-sm-12">
                    <br>
                    <input type="submit" value="Đặt phòng" class="btn btn-sm btn-primary">                           
                </div>
            </form>

        </div>
    </section>

    <!-- end: page -->
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>