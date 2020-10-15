<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Danh sách người dùng đặt phòng</h2>

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
                <li> <a href="<?php echo $urlNow; ?>"><span>Danh sách đặt phòng chưa xử lý</span></a></li>
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

            <h2 class="panel-title">Danh sách đặt phòng chưa xử lý</h2>

            <?php
            if (isset($_GET['status'])) {
                switch ($_GET['status']) {
                    case 1: echo '<p style="color:red;">Đặt phòng thành công!</p>';
                        break;
                    case -1: echo '<p style="color:red;">Đặt phòng không thành công!</p>';
                        break;
                    case 3: echo '<p style="color:red;">Sửa đặt phòng thành công!</p>';
                        break;
                    case -3: echo '<p style="color:red;">Sửa đặt phòng không thành công!</p>';
                        break;
                    case 4: echo '<p style="color:red;">Xóa đặt phòng thành công!</p>';
                        break;
                }
            }
            ?>
        </header>
        <div class="panel-body">           
            <!--            <div class="row" style="margin-bottom: 1em;">
            
                            <form class="form-inline" role="form">
                                <div class="form-group col-sm-6 text-left">
                                        
                                </div>
                                <div class="form-group col-sm-6 text-right">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="q" id="q" placeholder="Search...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>-->
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none">
                    <thead>
                        <tr> 
                            <th>STT</th>
                            <th>Họ và tên </th>
                            <th>Điện thoại </th>
                            <th>Ngày đến </th>
                            <th>Ngày đi </th>
                            <th>Loại phòng </th>
                            <th>Số phòng </th>
                            <th>Số người </th>
                            <th>Khách sạn </th>      
                            <th style="text-align: center;">Thao tác</th>  
                        </tr> 
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($listData)) {
                            foreach ($listData as $key => $order) {
                                ?>
                                <tr> 
                                    <td class=""><?php echo $key + 1; ?></td> 
                                    <td class="break_word"><?php echo $order['Order']['name'] ?></td> 
                                    <td class="break_word"><?php echo $order['Order']['phone'] ?></td> 
                                    <td class="break_word"><?php echo $order['Order']['date_start']; ?></td> 
                                    <td class="break_word"><?php echo $order['Order']['date_end']; ?></td> 
                                    <td class="break_word"><?php echo $order['Order']['nameTypeRoom'] ?></td> 
                                    <td class="break_word"><?php echo $order['Order']['number_room'] ?></td> 
                                    <td class="break_word"><?php echo $order['Order']['number_people'] ?></td> 
                                    <td class="break_word"><?php echo $order['Order']['nameHotel'] ?></td> 
                                    <td class="" align="center">
                                        <a class="btn btn-default"  href="<?php echo $urlHomes . 'managerProcessOrder?id=' . $order['Order']['id']; ?>">Xem</a>
                                        &nbsp;
                                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa không?');" class="btn btn-default"  href="<?php echo $urlHomes . 'managerDeleteOrder?id=' . $order['Order']['id']; ?>">Xóa</a>
                                    </td> 

                                </tr> 


                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td align="center" colspan="13">Chưa có danh sách đặt phòng nào.</td>
                            </tr>
                        <?php }
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
                    $urlNow = $urlHomes.'managerListOrderPending';
                    echo '<a href="' . $urlNow . '?page=' . $back . '">Trang trước</a> ';
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        echo ' <a href="' . $urlNow . '?page=' . $i . '">' . $i . '</a> ';
                    }
                    echo ' <a href="' . $urlNow . '?page=' . $next . '">Trang sau</a> ';
    
                    echo 'Tổng số trang: ' . $totalPage;
                }
                ?>
            </div>
        </div>
    </section>

    <!-- end: page -->
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>