<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Danh sách ngày nghỉ lễ</h2>

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
                <li><span>Ngày lễ</span></li>
                <li><span>Danh sách ngày nghỉ lễ</span></li>
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

            <h2 class="panel-title">Danh sách ngày nghỉ lễ</h2>
        </header>
        <div class="panel-body">
            <div class="row">
                <?php
                if (isset($_GET['status'])) {
                    switch ($_GET['status']) {
                        case 1: echo '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Thêm thành công!</p>';
                            break;
                        case -1: echo '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Thêm thất bại!</p>';
                            break;
                        case 3: echo '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Sửa thành công!</p>';
                            break;
                        case -3: echo '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Sửa không thành công!</p>';
                            break;
                        case 4: echo '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Xóa thành công!</p>';
                            break;
                    }
                }
                ?>
            </div>
            <a style="padding: 4px 8px;" href="<?php echo $urlHomes . 'managerAddHoliday'; ?>" class="input">
                <img src="<?php echo $webRoot; ?>images/add.png"> Thêm
            </a>  
            <br><br>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên ngày lễ</th>
                            <th>Bắt đầu</th>
                            <th>Kết thúc</th>
                            <th>Mô tả</th>
                            <th>chọn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($listData)) {
                            foreach ($listData as $key => $tin) {
                                ?>
                                <tr> 
                                    <td><?php echo $key + 1; ?></td> 
                                    <td><?php echo $tin['Holiday']['name'] ?></td> 
                                    <td><?php echo @date("H:i", $tin['Holiday']['dateTimeStart']).' '.@date("d/m/Y", $tin['Holiday']['dateTimeStart']); ?></td>
                                    <td><?php echo @date("H:i", $tin['Holiday']['dateTimeEnd']).' '.@date("d/m/Y", $tin['Holiday']['dateTimeEnd']); ?></td>
                                    <td><?php echo $tin['Holiday']['describe'] ?></td> 

                                    <td class="actions" align="center">
                                        <a href="<?php echo $urlHomes . 'managerEditHoliday?id=' . $tin['Holiday']['id']; ?>" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                        <a href="<?php echo $urlHomes . 'managerDeleteHoliday?id=' . $tin['Holiday']['id']; ?>" class="on-default remove-row" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr> 
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td align="center" colspan="13">Chưa có Ngày nghỉ lễ nào</td>
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