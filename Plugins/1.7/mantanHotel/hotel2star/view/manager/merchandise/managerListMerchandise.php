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
        <h2>Danh sách Hàng hóa - Dịch vụ</h2>

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
                <li><span>Danh sách Hàng hóa - Dịch vụ</span></li>
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

            <h2 class="panel-title">Danh sách Hàng hóa - Dịch vụ</h2>
        </header>
        <div class="panel-body">
            <?php
            if ($mess != '') {
                echo $mess;
            }
            ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-md">
                        <a href="managerAddMerchandise"><button id="" class="btn btn-primary">Thêm Hàng hóa - Dịch vụ <i class="fa fa-plus"></i></button></a>
                       
                    </div>
                </div>
            </div>
            
            <div class="row" style="margin-bottom: 1em;">
                <form class="form-inline" role="form">
                    <div class="form-group col-sm-12">
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
                        <label class="control-label">Mã hàng hóa</label>
                        <input type="text" class="form-control" name="code" value="<?php echo @$_GET['code']; ?>"/>
                        
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
                            <th>Tên Hàng hóa - Dịch vụ</th>
                            <th>Mã Hàng hóa - Dịch vụ</th>
                            <th>Nhóm Hàng hóa - Dịch vụ</th>
                            <th>Số lượng</th>
                            <th>Giá bán</th>
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
                                    <td><?php echo $tin['Merchandise']['name'] ?></td> 
                                    <td><?php echo $tin['Merchandise']['code'] ?></td> 
                                    <td><?php echo @$listNameGroup[$tin['Merchandise']['type_merchandise']]; ?></td> 
                                    <td><?php echo @$tin['Merchandise']['quantity'] ?></td> 
                                    <td><?php echo @$tin['Merchandise']['price'] ?></td> 
                                    <td><?php echo $tin['Merchandise']['note'] ?></td> 
                                    <td class="actions" align="center">
                                        <a href="<?php echo $urlHomes . 'managerEditMerchandise?id=' . $tin['Merchandise']['id']; ?>" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                        <a href="<?php echo $urlHomes . 'managerDeleteMerchandise?id=' . $tin['Merchandise']['id']; ?>" class="on-default remove-row" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr> 
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td align="center" colspan="13">Chưa có Hàng hóa - Dịch vụ nào.</td>
                            </tr>
                        <?php }
                        ?>   
                    </tbody>
                </table>
            </div>

            <br>
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
    </section>
    <!-- end: page -->
</section>
</div>

<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>