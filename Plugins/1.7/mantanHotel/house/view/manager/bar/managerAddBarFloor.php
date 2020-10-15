<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/header.php'; ?>
<?php include $urlLocal['urlLocalPlugin'].'mantanHotel/view/manager/sidebar-left.php'; ?>
<section role="main" class="content-body">
    <header class="page-header">
		<?php
			if (isset($data['BarFloor']['id']))
				echo '<h2>Sửa tầng bar</h2>';
			else
				echo '<h2>Thêm mới tầng bar</h2>';
		?>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php global $urlHomeManager; echo $urlHomeManager; ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
				<?php
					if (isset($data['BarFloor']['id']))
						echo '<li><span>Sửa tầng bar</span></li>';
					else
						echo '<li><span>Thêm tầng bar</span></li>';
				?>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->

    <div class="row">
        <div class="col-md-12">
            <form id="summary-form" action="" method="post" class="form-horizontal">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                            <a href="#" class="fa fa-times"></a>
                        </div>
						<?php
							if (isset($data['BarFloor']['id']))
								echo '<h2 class="panel-title">Sửa tầng bar</h2>';
							else
								echo '<h2 class="panel-title">Thêm mới tầng bar</h2>';
						?>
                        <div class="showMess"><?php echo $mess;?></div>
                    </header>
                    <div class="panel-body">    
						<input type="hidden" id="id" name="id" value="<?php echo(isset($data['BarFloor']['id']))?$data['BarFloor']['id']:''; ?>"  />
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tên tầng: <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" value="<?php echo(isset($data['BarFloor']['name']))?$data['BarFloor']['name']:''; ?>" autocomplete="off" required />
                            </div>
                        </div>
						<?php
							if (!isset($data['BarFloor']['id']))
							{
						?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Số bàn: <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" min="1" name="table" value="<?php echo(isset($data['BarFloor']['table']))?$data['BarFloor']['table']:''; ?>" autocomplete="off" required />
                            </div>
                        </div>
						<?php
							}
						?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Chọn màu: <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <div class="input-group color colorpicker-element" data-color="<?php echo(isset($data['BarFloor']['color']))?$data['BarFloor']['color']:'rgb(255, 146, 180)'; ?>" data-color-format="rgb" data-plugin-colorpicker="">
                                    <span class="input-group-addon"><i style="background-color: <?php echo(isset($data['BarFloor']['color']))?$data['BarFloor']['color']:'rgb(255, 146, 180)'; ?>;"></i></span>
                                    <input type="text" name="color" required="" class="form-control" value="<?php echo(isset($data['BarFloor']['color']))?$data['BarFloor']['color']:''; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Ghi chú:</label>
                            <div class="col-sm-6">
                                <textarea  rows="5" class="form-control" name="note" ><?php echo(isset($data['BarFloor']['note']))?$data['BarFloor']['note']:''; ?></textarea>
                            </div>
                        </div>
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