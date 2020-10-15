<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Quản lý thu</h2>

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
                <li><span>Quản lý thu</span></li>
                <li><span>Danh sách phiếu thu</span></li>
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

            <h2 class="panel-title">Danh sách phiếu thu</h2>
            <div class="showMess"><?php echo $mess; ?></div>
        </header>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-md">
                        <a href="<?php echo $urlHomes . 'managerAddCollectionBill'; ?>"><button id="" class="btn btn-primary">Thêm phiếu thu <i class="fa fa-plus"></i></button></a>
                         
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 1em;">
                <form class="form-inline" role="form">

                    <div class="form-group col-sm-12">
                        <select id="selectreceipts" name="idStaff" class="form-control">
                            <option value="">Chọn nhân viên</option>
                            <?php
                            if (!empty($listStaff)) {

                                foreach ($listStaff as $staff) {
                                    ?>
                                    <option value="<?php echo $staff['Staff']['id'] ?>" <?php
                                    if (isset($_GET['idStaff']) && $_GET['idStaff'] == $staff['Staff']['id']) {
                                        echo ' selected';
                                    }
                                    ?> ><?php echo $staff['Staff']['fullname'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                        </select>
                        <label class="control-label">Từ ngày</label>
                        <div class="input-daterange input-group" data-plugin-datepicker>
                            <input type="text" class="form-control" name="dateStart" value="<?php echo @$_GET['dateStart']; ?>"/>
                        </div>
                        <label>đến ngày</label>
                        <div class="input-daterange input-group" data-plugin-datepicker>
                            <input type="text" class="form-control" name="dateEnd" value="<?php echo @$_GET['dateEnd']; ?>"/>
                        </div>          
                        <input type="submit" class="btn btn-primary btn-sm calculation" name="action"  value="Tìm kiếm"/>
                        &nbsp;&nbsp;
                        <input type="submit" class="btn btn-default" name="action" value="Xuất Excel" />
                    </div>
                </form>
            </div>
            <br/>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none" id="">
                    <thead>
                        <tr>
                            <th>Ngày tạo</th>
                            <th>Số tiền</th>
                            <th>Hình thức</th>
                            <th>Người nộp</th>
                            <th>Người thu</th>
                            <th>Ghi chú</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($listData)) {
                            foreach ($listData as $data) {
                                $dateCreate = getdate($data['CollectionBill']['time']);
                                // check quyen chinh sua
                                if(!$_SESSION['infoManager']['Manager']['isStaff'] || in_array('editCollectionBill',$_SESSION['infoManager']['Manager']['permissionAdvanced'])){
                                    $inputShowEdit= '<a title="Sửa" href="' . $urlHomes . 'managerAddCollectionBill?id=' . $data['CollectionBill']['id'] . '" class="on-default edit-row"><i class="fa fa-pencil"></i></a>';
                                }else{
                                    $inputShowEdit= '';
                                }
                                // check quyen xoa
                                if(!$_SESSION['infoManager']['Manager']['isStaff'] || in_array('deleteCollectionBill',$_SESSION['infoManager']['Manager']['permissionAdvanced'])){
                                    $inputShowDelete= '<a title="Xóa" href="' . $urlHomes . 'managerDeleteCollectionBill?id=' . $data['CollectionBill']['id'] . '" class="on-default remove-row" onclick="return confirm(\'Bạn có chắc chắn muốn xóa không?\')"><i class="fa fa-trash-o"></i></a>';
                                }else{
                                    $inputShowDelete= '';
                                }
                                
                                echo '  <tr>
                                            <td>' . $dateCreate['hours'] . ':' . $dateCreate['minutes'] . ' ' . $dateCreate['mday'] . '/' . $dateCreate['mon'] . '/' . $dateCreate['year'] . '</td>
                                            <td>' . number_format($data['CollectionBill']['coin']) . '</td>
                                            <td>' . $typeCollectionBill[$data['CollectionBill']['typeCollectionBill']] . '</td>
                                            <td>' . $data['CollectionBill']['nguoi_nop'] . '</td>
                                            <td>' . $data['CollectionBill']['nguoi_nhan'] . '</td>
                                            <td>' . nl2br($data['CollectionBill']['note']) . '</td>
                                            <td class="actions">
                                                '.$inputShowEdit.'&nbsp;
                                                '.$inputShowDelete.'&nbsp
                                                <a target="_blank" title="In" href="' . $urlHomes . 'managerPrintCollectionBill?id=' . $data['CollectionBill']['id'] . '" class="on-default edit-row"><i class="fa fa-print"></i></a>
                                            </td>
                                        </tr>';
                            }
                        } else {
                            echo '<tr><td colspan="7" align="center">Chưa có phiếu thu</td></tr>';
                        }
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
                    $urlNow = $urlHomes . 'managerListCollectionBill';
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