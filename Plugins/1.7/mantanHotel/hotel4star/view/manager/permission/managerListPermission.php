<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Danh sách nhóm phân quyền</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php global $urlHomeManager;
echo $urlHomeManager; ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Nhân viên</span></li>
                <li><span>Danh sách nhóm phân quyền</span></li>
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

            <h2 class="panel-title">Danh sách nhóm phân quyền</h2>
        </header>
        <div class="panel-body">

            <?php
            if (isset($_GET['status'])) {
                switch ($_GET['status']) {
                    case 1: echo '<p style="color:red;">Thêm nhóm phân quyền thành công!</p>';
                        break;
                    case -1: echo '<p style="color:red;">Thêm nhóm phân quyền không thành công!</p>';
                        break;
                    case 3: echo '<p style="color:red;">Sửa nhóm phân quyền thành công!</p>';
                        break;
                    case -3: echo '<p style="color:red;">Sửa nhóm phân quyền không thành công!</p>';
                        break;
                    case 4: echo '<p style="color:red;">Xóa nhóm phân quyền thành công!</p>';
                        break;
                }
            }
            ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-md">
                        <a href="managerAddPermission"><button id="" class="btn btn-primary">Thêm <i class="fa fa-plus"></i></button></a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên nhóm phân quyền</th>
                            <th>Ghi chú</th>
                            <th style="text-align: center;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($listData)) {
                            foreach ($listData as $key => $permission) {
                                ?>
                                <tr class="gradeX">
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $permission['Permission'] ['name']; ?></td>
                                    <td><?php echo $permission['Permission']['note']; ?></td>
                                    <td class="actions" align="center">
                                        <a href="<?php echo $urlHomes . 'managerEditPermission?id=' . $permission['Permission']['id']; ?>" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                        <a href="<?php echo $urlHomes . 'managerDeletePermission?id=' . $permission['Permission']['id']; ?>" class="on-default remove-row" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td align="center" colspan="8">Chưa có nhóm phân quyền nào.</td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
            <br>
            <?php
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
            $urlNow = $urlHomes.'managerListPermission';
            echo '<a href="' . $urlNow . '?page=' . $back . '">Trang trước</a> ';
            for ($i = $startPage; $i <= $endPage; $i++) {
                echo ' <a href="' . $urlNow . '?page=' . $i . '">' . $i . '</a> ';
            }
            echo ' <a href="' . $urlNow . '?page=' . $next . '">Trang sau</a> ';

            echo 'Tổng số trang: ' . $totalPage;
            ?>
        </div>
    </section>
    <!-- end: page -->
</section>
</div>
<div id="dialog" class="modal-block mfp-hide">
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">Bạn có chắc?</h2>
        </header>
        <div class="panel-body">
            <div class="modal-wrapper">
                <div class="modal-text">
                    <p>Bạn có chắc muốn xóa dòng này?</p>
                </div>
            </div>
        </div>
        <footer class="panel-footer">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button id="dialogConfirm" class="btn btn-primary">Xóa</button>
                    <button id="dialogCancel" class="btn btn-default">Hủy</button>
                </div>
            </div>
        </footer>
    </section>
</div>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>