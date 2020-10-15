<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body fa-height">
                    <header class="page-header">
                        <h2>Trang chủ</h2>

                        <div class="right-wrapper pull-right">
                            <ol class="breadcrumbs">
                                <li>
                                    <a href="<?php global $urlHomeManager; echo $urlHomeManager; ?>">
                                        <i class="fa fa-home"></i>
                                    </a>
                                </li>
                                <li><span>Trang chủ</span></li>
                            </ol>

                            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
                        </div>
                    </header>

                    <!-- start: page -->
                    <div class="row">
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="chart-data-selector" id="salesSelectorWrapper">
                                                <h2>
                                                    Thống kê doanh thu năm <?php echo $today['year'];?>:
                                                </h2>

                                                <div id="salesSelectorItems" class="chart-data-selector-items mt-sm">
                                                    <!-- Flot: Sales Porto Admin -->
                                                    <div class="chart chart-sm" data-sales-rel="Profit" id="flotDashSales1" class="chart-active"></div>
                                                    <script>

                                                        var flotDashSales1Data = [{
                                                                data: [
                                                                    <?php
                                                                        $array= array();
                                                                        for($i=1;$i<=12;$i++){
                                                                            $array[]= '["Tháng '.$i.'", '.$revenue[$i].']';
                                                                        }
                                                                        
                                                                        echo implode(',',$array);
                                                                    ?>
                                                                ],
                                                                color: "#0088cc"
                                                            }];

                                                        // See: assets/javascripts/dashboard/examples.dashboard.js for more settings.

                                                    </script>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="row">
                                <div class="col-md-12 col-lg-6 col-xl-6">
                                    <section class="panel panel-featured-left panel-featured-primary">
                                        <div class="panel-body">
                                            <div class="widget-summary">
                                                <div class="widget-summary-col widget-summary-col-icon">
                                                    <div class="summary-icon bg-primary">
                                                        <i class="fa fa-life-ring"></i>
                                                    </div>
                                                </div>
                                                <div class="widget-summary-col">
                                                    <div class="summary">
                                                        <h4 class="title">Khách chờ báo giá</h4>
                                                        <div class="info">
                                                            <strong class="amount"><?php echo number_format($countRequest);?></strong>
                                                        </div>
                                                    </div>
                                                    <div class="summary-footer">
                                                        <a href="<?php echo $urlHomes.'managerListRequest';?>" class="text-muted text-uppercase">(Chi tiết)</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-6">
                                    <section class="panel panel-featured-left panel-featured-secondary">
                                        <div class="panel-body">
                                            <div class="widget-summary">
                                                <div class="widget-summary-col widget-summary-col-icon">
                                                    <div class="summary-icon bg-secondary">
                                                        <i class="fa fa-usd"></i>
                                                    </div>
                                                </div>
                                                <div class="widget-summary-col">
                                                    <div class="summary">
                                                        <h4 class="title">Doanh thu phòng tháng <?php echo $today['mon'].'/'.$today['year'];?></h4>
                                                        <div class="info">
                                                            <strong class="amount"><?php echo number_format($revenue[$today['mon']]);?></strong>
                                                        </div>
                                                    </div>
                                                    <div class="summary-footer">
                                                        <a href="<?php echo $urlHomes.'managerRevenue'?>" class="text-muted text-uppercase">(Chi tiết)</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-6">
                                    <section class="panel panel-featured-left panel-featured-tertiary">
                                        <div class="panel-body">
                                            <div class="widget-summary">
                                                <div class="widget-summary-col widget-summary-col-icon">
                                                    <div class="summary-icon bg-tertiary">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </div>
                                                </div>
                                                <div class="widget-summary-col">
                                                    <div class="summary">
                                                        <h4 class="title">Yêu cầu đặt phòng</h4>
                                                        <div class="info">
                                                            <strong class="amount"><?php echo number_format($countOrder);?></strong>
                                                        </div>
                                                    </div>
                                                    <div class="summary-footer">
                                                        <a href="<?php echo $urlHomes.'managerListOrderPending';?>" class="text-muted text-uppercase">(Chi tiết)</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-6">
                                    <section class="panel panel-featured-left panel-featured-quartenary">
                                        <div class="panel-body">
                                            <div class="widget-summary">
                                                <div class="widget-summary-col widget-summary-col-icon">
                                                    <div class="summary-icon bg-quartenary">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="widget-summary-col">
                                                    <div class="summary">
                                                        <h4 class="title">Số lượt xem</h4>
                                                        <div class="info">
                                                            <strong class="amount"><?php echo number_format($view);?></strong>
                                                        </div>
                                                    </div>
                                                    <div class="summary-footer">
                                                        <a class="text-muted text-uppercase">
                                                            <a target="_blank" href="<?php echo $urlHomes.'hotel/'.$slug.'.html';?>" class="text-muted text-uppercase">(Chi tiết)</a>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                
                                <div class="col-md-12 col-lg-6 col-xl-6">
                                    <section class="panel panel-featured-left panel-featured-quartenary">
                                        <div class="panel-body">
                                            <div class="widget-summary">
                                                <div class="widget-summary-col widget-summary-col-icon">
                                                    <div class="summary-icon bg-secondary">
                                                        <i class="fa fa-bug"></i>
                                                    </div>
                                                </div>
                                                <div class="widget-summary-col">
                                                    <div class="summary">
                                                        <h4 class="title">Báo hỏng mới</h4>
                                                        <div class="info">
                                                            <strong class="amount"><?php echo number_format($countReport);?></strong>
                                                        </div>
                                                    </div>
                                                    <div class="summary-footer">
                                                        <a class="text-muted text-uppercase">
                                                            <a href="<?php echo $urlHomes.'managerListReportRoom';?>" class="text-muted text-uppercase">(Chi tiết)</a>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                
                                <div class="col-md-12 col-lg-6 col-xl-6">
                                    <section class="panel panel-featured-left panel-featured-quartenary">
                                        <div class="panel-body">
                                            <div class="widget-summary">
                                                <div class="widget-summary-col widget-summary-col-icon">
                                                    <div class="summary-icon bg-quartenary">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                                <div class="widget-summary-col">
                                                    <div class="summary">
                                                        <h4 class="title">Phòng sắp đến ngày trả phòng</h4>
                                                        <div class="info">
                                                            <strong class="amount"><?php echo number_format($countDeadlineCheckout);?></strong>
                                                        </div>
                                                    </div>
                                                    <div class="summary-footer">
                                                        <a class="text-muted text-uppercase">
                                                            <a href="<?php echo $urlHomes.'managerListDeadlineCheckout';?>" class="text-muted text-uppercase">(Chi tiết)</a>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end: page -->
                </section>
            </div>
            <?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-right.php'; ?>