<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Danh sách báo hỏng</h2>

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
                <li><span>CSKH</span></li>
                <li><span>Danh sách báo hỏng</span></li>
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

            <h2 class="panel-title">Danh sách báo hỏng</h2>
            <div class="showMess"><?php echo $mess; ?></div>
        </header>
        <div class="panel-body">           
            <div class="row" style="margin-bottom: 1em;">
                <form class="form-inline" role="form" method="get" action="">
                    <div class="form-group col-sm-6 text-left">
                        <a href="<?php echo $urlHomes; ?>managerAddReportRoom" class="btn btn-primary btn-sm">Thêm báo hỏng mới</a>
                    </div>
                    
                </form>
            </div>
            <br/>
            <div class="row" style="margin-bottom: 1em;">
                <form class="form-inline" role="form">
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
            <br/>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none" id="">
                    <thead>
                        <tr>
                            <th>Thời gian</th>
                            <th>Phòng</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($listData)) {
                            $dem = 0;
                            foreach ($listData as $data) {
                                $dem++;
                                echo '
                                <tr class="gradeX">
                                        <td>' . date('H:i d/m/Y', $data['Report']['time']). '</td>
                                        <td>'.$data['Report']['nameRoom'].'</td>
                                        <td>' . nl2br($data['Report']['content']) . '</td>
                                        <td>' . $data['Report']['status'] . '</td>
                                        <td class="actions">
                                                <a href="' . $urlHomes . 'managerEditReportRoom?idReport=' . $data['Report']['id'] . '" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                                <a href="#" class="on-default remove-row" onclick="deleteData(\'' . $data['Report']['id'] . '\');"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                </tr>
                        ';
                            }
                        } else {
                            echo '<tr>
                                    <td align="center" colspan="5">Không có báo hỏng nào.</td>
                                </tr>';
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
                    
                    echo '<a href="' . $urlPage . $back . '">Trang trước</a> ';
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        echo ' <a href="' . $urlPage. $i . '">' . $i . '</a> ';
                    }
                    echo ' <a href="' . $urlPage. $next . '">Trang sau</a> ';
    
                    echo 'Tổng số trang: ' . $totalPage;
                }
                ?>
            </div>

        </div>
    </section>

    <!-- end: page -->
</section>
</div>
<script type="text/javascript">
    var urlWeb = "<?php echo $urlHomes . 'managerDeleteReportRoom'; ?>";
    var urlNow = "<?php echo $urlNow; ?>";

    function deleteData(idDelete)
    {
        var check = confirm('Bạn có chắc chắn muốn xóa!');
        if (check)
        {
            $.ajax({
                type: "POST",
                url: urlWeb,
                data: {idDelete: idDelete}
            }).done(function (msg) {
                window.location = urlNow;
            })
                    .fail(function () {
                        window.location = urlNow;
                    });
        }
    }
</script>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>