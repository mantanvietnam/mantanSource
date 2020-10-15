<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Quản lý công nợ</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php global $urlHomeManager;
echo $urlHomeManager; ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Quản lý công nợ</span></li>
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

            <h2 class="panel-title">Công nợ phải thu của khách hàng <?php echo $dataCustom['Custom']['cus_name']; ?></h2>
        </header>
        <div class="panel-body">
            <!--    <div class="row" style="margin-bottom: 1em;">
                    <form class="form-inline" role="form">
                        <div class="form-group col-sm-6 text-left">
                            <label  for="selectreceipts">Hiển thị </label>
                            <select id="selectreceipts" class="form-control">
                                <option value="">5</option>
                                <option value="">10</option>
                                <option value="">20</option>
                                <option value="">50</option>
                                <option value="">100</option>
                            </select>
                            <label> công ty</label>
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
                </div>
                <br/> -->
            <div class="row">
                <form class="form-inline" role="form">
                    <div class="form-group col-sm-12 text-center">
                        <label class="control-label">Chi tiết công nợ trong kỳ từ</label>
                        <div class="input-daterange input-group" data-plugin-datepicker>
                            <input type="text" class="form-control" name="start" disabled="disabled">
                        </div>
                        <label>đến</label>
                        <div class="input-daterange input-group" data-plugin-datepicker>
                            <input type="text" class="form-control" name="end" disabled="disabled">
                        </div>
                    </div>
                </form>
            </div>
            <br/>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none" >
                    <tr>
                        <td colspan="3">Nợ đầu kỳ ></td>
                        <?php
                        $tong = 0;
                        foreach ($listData as $data)
                            $tong = $tong + $data['Book']['pricePay'];
                        ?>
                        <td><?php echo number_format($tong, 0, ',', '.'); ?></td>
                        <td colspan="5"></td>
                    </tr>
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ngày xuất hóa đơn</th>
                            <th>Tên khách hàng</th>
                            <th>Thành tiền</th>
                            <th>Đã trả</th>
                            <th>Còn nợ</th>
                            <th>Ngày vào</th>
                            <th>Phòng</th>
                            <th>Loại phòng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dem = 0;
                        $tru = 0;
                        foreach ($listData as $data) {
                            $dem++;
                            if ($data['Book']['statusPay'] == 'cong_no') {
                                $datra = 0;
                                $conlai = $data['Book']['pricePay'];
                            } else {
                                $datra = $data['Book']['pricePay'];
                                $tru = $tru + $data['Book']['pricePay'];
                                $conlai = 0;
                            }

                            echo '
                                <tr class="gradeX">
                                    <td>' . $dem . '</td>
                                    <td>' . date('d/m/Y', $data['Book']['created']->sec) . '</td>
                                    <td>' . $data['Book']['dataRoom']['Room']['checkin']['Custom']['cus_name'] . '</td>                                    
                                    <td>' . number_format($data['Book']['pricePay'], 0, ',', '.') . '</td>
                                    <td>' . number_format($datra, 0, ',', '.') . '</td>
                                    <td>' . number_format($conlai, 0, ',', '.') . '</td>
                                    <td>' . date("d/m/Y", $data['Book']['dataRoom']['Room']['checkin']['dateCheckin']) . '</td>
                                    <td>' . $data['Book']['dataRoom']['Room']['name'] . '</td>
                                    <td>' . $data['Book']['typeRoom']['TypeRoom']['roomtype'] . '</td>                      
                                </tr>
                            ';
                        }
                        ?>
                        <tr>
                            <td colspan="3">Tổng cộng trong kỳ ></td>
                            <td><?php echo number_format($tong, 0, ',', '.'); ?></td>
                            <td><?php echo number_format($tru, 0, ',', '.'); ?></td>
                            <td><?php echo number_format($tong - $tru, 0, ',', '.'); ?></td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td colspan="5">Nợ cuối kỳ ></td>
                            <td><?php echo number_format($tong - $tru, 0, ',', '.'); ?></td>
                            <td colspan="3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!--            <div class="row" style="margin-top: 1em;">
                            <form class="form-inline" role="form">
                                <div class="form-group col-sm-12 text-right">
                                    <button class="btn btn-default" type="submit"><i class="fa fa-file-excel-o"></i> Xuất Excel</button>
                                    <button class="btn btn-default" type="submit"><i class="fa fa-print"></i> In File</button>                        
                                </div>
                            </form>
                        </div>-->
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