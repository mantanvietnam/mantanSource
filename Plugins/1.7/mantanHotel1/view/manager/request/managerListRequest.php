<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-left.php'; ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Yêu cầu báo giá</h2>

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
                <li><span>Yêu cầu</span></li>
                <li><span>Danh sách yêu cầu</span></li>
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

            <form method="get" action="">

                <div class="row">
                    <div class="col-md-8 col-sm-6 col-xs-12">

                        <h2 class="panel-title listrequest">Danh sách yêu cầu báo giá</h2>

                    </div>


                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <select name="type_oder"  class="form-control user-success" onchange="this.form.submit()">
                            <option <?php if (isset($_GET['type_oder']) && ($_GET['type_oder'] == 'empty')) echo 'selected'; ?> value="empty">--- Sắp xếp theo ---</option>
                            <option <?php if (isset($_GET['type_oder']) && ($_GET['type_oder'] == 'chuaXuLy')) echo 'selected'; ?> value="chuaXuLy">Chưa xử lý</option>
                            <option <?php if (isset($_GET['type_oder']) && ($_GET['type_oder'] == 'daXuLy')) echo 'selected'; ?> value="daXuLy">Đã xử lý</option>
                            <option <?php if (isset($_GET['type_oder']) && ($_GET['type_oder'] == 'moiNhat')) echo 'selected'; ?> value="moiNhat">Mới nhất</option>
                            <option <?php if (isset($_GET['type_oder']) && ($_GET['type_oder'] == 'cuNhat')) echo 'selected'; ?> value="cuNhat">Cũ nhất</option>
                        </select>
                    </div>
                </div>
            </form>

        </header>
        <div class="panel-body">
            <div class="table-responsive">
                <?php if (!empty($mess)) { ?>
                    <p class="success_mess" ><?php echo $mess; ?>
                    </p>

                <?php } ?>
                <table class="table table-bordered table-striped mb-none" >
                    <thead>
                        <tr>
                            <th>Thời gian yêu cầu</th>
                            <th>Nội dung yêu cầu</th>
                            <th>Nội dung báo giá</th>
                            <th>Báo giá</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($listData)) {
                            foreach ($listData as $key => $tin) {
                                $time_start = getdate($tin['Request']['time']);
                                ?>
                                <tr> 
                                    <td><?php echo $time_start['hours'] . ':' . $time_start['minutes'] . ' ' . $time_start['mday'] . '/' . $time_start['mon'] . '/' . $time_start['year']; ?></td>
                                    <td><?php echo $tin['Request']['content'] ?></td> 
                                    <td><?php echo @$tin['Request']['hotelProcess'][$_SESSION['idHotel']]['contentRequest']; ?></td> 
                                    <td class="actions" align="center">
                                        <?php
                                        if (isset($tin['Request']['hotelProcess'][$_SESSION['idHotel']]['price'])) {
                                            echo '<a href="/managerViewProcessRequest?id=' . $tin['Request']['id'] . '"><button id="" class="btn btn-primary">Xem</button></a><br>';
                                            echo number_format($tin['Request']['hotelProcess'][$_SESSION['idHotel']]['price']);
                                        } else {
                                            echo '<a href="/managerProcessRequest?id=' . $tin['Request']['id'] . '"><button id="" class="btn btn-primary">Báo giá</button></a>';
                                        }
                                        ?>
                                        <br/><br/>
                                        <a href="/managerDeleteRequest?id=<?php echo $tin['Request']['id']; ?>"><button id="" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');">Xóa</button></a>
                                    </td>

                                </tr> 
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td align="center" colspan="3">Chưa có yêu cầu báo giá nào.</td>
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
            $urlNow = $urlHomes . 'managerListRequest';
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

<?php include $urlLocal['urlLocalPlugin'] . 'mantanHotel/view/manager/sidebar-right.php'; ?>