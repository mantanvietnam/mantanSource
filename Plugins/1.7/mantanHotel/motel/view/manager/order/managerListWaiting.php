<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Danh sách khách chờ phòng</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.php">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Cài đặt chung</span></li>
                <li><span>Danh sách khách chờ</span></li>
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

            <h2 class="panel-title">Danh sách khách chờ phòng <?php echo $room['Room']['name']; ?></h2>
        </header>
        <div class="panel-body">           
            <div class="row" style="margin-bottom: 1em;">
                <form class="form-inline" role="form">
                    <div class="form-group col-sm-6 text-left">
                        <a target="_blank" href="<?php echo $urlHomes . 'managerListOrder'; ?>" class="btn btn-primary btn-sm">Danh sách đặt phòng</a>
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
            <br/>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none" id="">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Họ và tên</th>
                            <th>Điện thoại</th>
                            <th>Ngày đến</th>
                            <th>Ngày đi</th>
                            <th>Số phòng</th>
                            <th>Số người</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($listData)) {
                            $number = 0;
                            foreach ($listData as $data) {
                                $number++;
                                echo '  <tr class="gradeX">
                                            <td>' . $number . '</td>
                                            <td>' . $data['Order']['name'] . '</td>
                                            <td>' . $data['Order']['phone'] . '</td>
                                            <td>' . $data['Order']['date_start'] . '</td>
                                            <td>' . $data['Order']['date_end'] . '</td>
                                            <td>' . $data['Order']['number_room'] . '</td>
                                            <td>' . $data['Order']['number_people'] . '</td>
                                            <td class="actions">
                                                <a href="' . $urlHomes . 'managerProcessOrder?id=' . $data['Order']['id'] . '" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                                <a href="' . $urlHomes . 'managerDeleteOrder?id=' . $data['Order']['id'] . '" onclick="return confirm(\'Bạn có chắc chắn muốn xóa không?\');" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>';
                            }
                        } else {
                            echo '<tr><td colspan="8" align="center">Chưa có ai đặt phòng này</td></tr>';
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- end: page -->
</section>
</div>

<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>