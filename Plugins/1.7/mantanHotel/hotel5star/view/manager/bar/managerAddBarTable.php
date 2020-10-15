<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Thêm bàn bar</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php global $urlHomeManager; echo $urlHomeManager; ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Thêm bàn bar</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            <form id="summary-form" action="" class="form-horizontal" method="post">
				<input type="hidden" class="form-control" name="id" value="<?php echo @$data['BarTable']['id']; ?>" />
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>

                        <h2 class="panel-title">Thêm bàn bar mới</h2>
                    </header>
                    <div class="panel-body">                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tên bàn bar: <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" value="<?php echo @$data['BarTable']['name']; ?>" required />
                            </div>
                        </div>
						<?php
							if (!isset($data['BarTable']['id']))
							{
						?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tầng: <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <select id="company" class="form-control" name="floor" required />
									<option value="">- Chọn tầng bar -</option>
									<?php
										if (!empty($listFloor))
											foreach ($listFloor as $floor)
											{
												echo '<option '; 
												if (isset($data['BarTable']['BarFloor']) && $floor['BarFloor']['id']==$data['BarTable']['BarFloor'])
													echo 'selected ';
												if (isset($_GET['idFloor']) && $floor['BarFloor']['id']==$_GET['idFloor'])
													echo 'selected ';
												echo 'value="'.$floor['BarFloor']['id'].'">'.$floor['BarFloor']['name'].'</option>';
											}
									?>
                                </select>
                                <label class="error" for="select"></label>
                            </div>
                        </div>
						<?php
							}
						?>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="text-center">
                                <button class="btn btn-primary">Lưu</button>
                                <button type="reset" class="btn btn-default">Hủy</button>
                            </div>
                        </div>
                    </footer>
                </section>
            </form>
        </div>
    </div>
    <!-- end: page -->
</section>
</div>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-right.php'; ?>