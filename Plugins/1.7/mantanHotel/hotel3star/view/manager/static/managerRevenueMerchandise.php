<script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/jspdf/jquery.base64.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/jspdf/html2canvas.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/jspdf/sprintf.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/jspdf/jspdf.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/jspdf/tableExport.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/mantanHotel/view/manager'; ?>/js/jspdf/base64.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thống kê doanh số Hàng hóa - Dịch vụ</h2>

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
                <li><span>Thống kê doanh số</span></li>
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

            <h2 class="panel-title">Thống kê doanh số Hàng hóa - Dịch vụ</h2>
        </header>
        <div class="panel-body">
            <?php
            if ($mess != '') {
                echo $mess;
            }
            ?>
            
            <div class="row" style="margin-bottom: 1em;">
                <form class="form-inline" role="form">
                    <div class="form-group col-sm-12" style="margin-bottom: 1em;">
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
                        &nbsp;&nbsp;
                        <select name="idNhomHangHoa" class="form-control">
                            <option value="">Chọn nhóm hàng hóa</option>
                            <?php 
                                $listNameGroup= array();
                                foreach ($listMerchandiseGroup as $merchandiseGroup) { 
                                    $listNameGroup[$merchandiseGroup['MerchandiseGroup']['id']]= $merchandiseGroup['MerchandiseGroup']['name'];
                                    $select= '';
                                    if(isset($_GET['idNhomHangHoa']) && $_GET['idNhomHangHoa']==$merchandiseGroup['MerchandiseGroup']['id']){
                                        $select= 'selected';
                                    }
                                    
                                    echo '<option '.$select.' value="'.$merchandiseGroup['MerchandiseGroup']['id'].'">'.$merchandiseGroup['MerchandiseGroup']['name'].'</option>';
                                }
                            ?>
                        </select>
                        &nbsp;&nbsp;
                        <label class="control-label">Mã hàng hóa</label>
                        <input type="text" class="form-control" name="code" value="<?php echo @$_GET['code']; ?>"/>
                    </div>
                    <div class="form-group col-sm-12">
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
            
            <div class="table-responsive">
                <table id="tableID" class="table table-bordered table-striped mb-none" >
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ngày bán</th>
                            <th>Tên Hàng hóa - Dịch vụ</th>
                            <th>Mã HH - DV</th>
                            <th>Nhóm HH - DV</th>
                            <th>Số lượng</th>
                            <th>Giá bán</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($listData)) {
                            foreach ($listData as $key => $tin) {
                                $dateCreate= $tin['MerchandiseStatic']['time'];
                                ?>
                                <tr> 
                                    <td><?php echo $key + 1; ?></td> 
                                    <td><?php echo $dateCreate['hours'] . ':' . $dateCreate['minutes'] . ' ' . $dateCreate['mday'] . '/' . $dateCreate['mon'] . '/' . $dateCreate['year']?></td>
                                    <td><?php echo $tin['MerchandiseStatic']['name'] ?></td> 
                                    <td><?php echo $tin['MerchandiseStatic']['code'] ?></td> 
                                    <td><?php echo @$listNameGroup[$tin['MerchandiseStatic']['idMerchandiseGroup']]; ?></td> 
                                    <td><?php echo @$tin['MerchandiseStatic']['number'] ?></td> 
                                    <td><?php echo @$tin['MerchandiseStatic']['price'] ?></td> 
                                </tr> 
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td align="center" colspan="13">Chưa bán được Hàng hóa - Dịch vụ nào.</td>
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
                $urlNow = $urlHomes . 'managerListMerchandise';
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