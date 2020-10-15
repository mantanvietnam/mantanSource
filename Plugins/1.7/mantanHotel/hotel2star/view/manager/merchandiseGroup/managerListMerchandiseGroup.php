<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Danh sách nhóm Hàng hóa - Dịch vụ</h2>

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
                <li><span>Hàng hóa - Dịch vụ</span></li>
                <li><span>Danh sách nhóm Hàng hóa - Dịch vụ</span></li>
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

            <h2 class="panel-title">Danh sách nhóm Hàng hóa - Dịch vụ</h2>
        </header>
        <div class="panel-body">
            <?php
            if (isset($_GET['status'])) {
                switch ($_GET['status']) {
                    case 1: echo '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Thêm nhóm Hàng hóa - Dịch vụ thành công!</p>';
                        break;
                    case -1: echo '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Thêm nhóm Hàng hóa - Dịch vụ không thành công!</p>';
                        break;
                    case 3: echo '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Sửa nhóm Hàng hóa - Dịch vụ thành công!</p>';
                        break;
                    case -3: echo '<p class="error_mess"><span class="glyphicon glyphicon-remove"></span> Sửa nhóm Hàng hóa - Dịch vụ không thành công!</p>';
                        break;
                    case 4: echo '<p class="success_mess"><span class="glyphicon glyphicon-ok"></span> Xóa nhóm Hàng hóa - Dịch vụ thành công!</p>';
                        break;
                }
            }
            ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-md">
                        <a href="managerAddMerchandiseGroup"><button id="" class="btn btn-primary">Thêm <i class="fa fa-plus"></i></button></a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none" >
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên nhóm Hàng hóa - Dịch vụ</th>
                            <th>Ghi chú</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($listData)) {
                            foreach ($listData as $key => $tin) {
                                ?>
                                <tr> 
                                    <td><?php echo $key + 1; ?></td> 
                                    <td><?php echo $tin['MerchandiseGroup']['name'] ?></td> 
                                    <td><?php echo $tin['MerchandiseGroup']['note'] ?></td> 
                                    <td class="actions" align="center">
                                        <a href="<?php echo $urlHomes . 'managerEditMerchandiseGroup?id=' . $tin['MerchandiseGroup']['id']; ?>" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                        <a href="<?php echo $urlHomes . 'managerDeleteMerchandiseGroup?id=' . $tin['MerchandiseGroup']['id']; ?>" class="on-default remove-row" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr> 
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td align="center" colspan="13">Chưa có nhóm Hàng hóa - Dịch vụ nào.</td>
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
                $urlNow = $urlHomes.'managerListMerchandiseGroup';
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