<?php getHeader();?>
<section class="body-section products-grid">
	<!-- U S E R   S E C T I O N -->
	
	<div class="title-wrapper">
		<h2>Giỏ hàng</h2>
	</div>
	<div class="row">
		<form action="<?php echo $urlHomes.'saveOrderProduct_reloadOrder';?>" method="post" class="custom-form">
			<div class="table-responsive col-xs-12">
				<span>Sản phẩm đã chọn</span>
				<?php
					if(isset($_SESSION['codeDiscountInput']))
					{
						echo '<p>Mã giảm giá được sử dụng: <b>'.$_SESSION['codeDiscountInput'].'</b></p>';
					}

					if(isset($_GET['status'])){
						switch($_GET['status'])
						{
							case 1: echo '<p>Đặt hàng thành công !</p>';break;
							case -1: echo '<p>Đặt hàng thất bại !</p>';break;
						}
					}
				?>
				<table class="table table-bordered table-hover tablesorter">
					<thead>
						<tr>
						<th class="header headerSortDown">STT <i class="fa fa-sort"></i></th>
						<th class="header">Ảnh sản phẩm</i></th>
						<th class="header">Tên sản phẩm <i class="fa fa-sort"></i></th>
						<th class="header">Số lượng</th>
						<th class="header">Thành tiền <i class="fa fa-sort"></i></th>
						<th class="header">Xóa</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$totalMoney= 0;
							if(isset($_SESSION['orderProducts']) && count($_SESSION['orderProducts'])>0){
								global $modelOption;
								$listOrderProduct= $_SESSION['orderProducts'];
								$number= 0;
								$listTypeMoney= $modelOption->getOption('productTypeMoney');
								
								foreach($listOrderProduct as $data)
								{
									$number++;
									if(!$data['Product']['images'][0])
									{
										$data['Product']['images'][0]= $urlHomes.'/app/Plugin/product/images/no_image-100x100.jpg';
									}
									if(isset($data['Product']['codeDiscountInput']) && $data['Product']['codeDiscountInput']!='' && in_array($data['Product']['codeDiscountInput'], $data['Product']['codeDiscount']))
									{
										$priceShow= $data['Product']['priceDiscount'];
										$discount= true;
									}
									else
									{
										$priceShow= $data['Product']['price'];
										$discount= false;
									}
									
									$totalMoney+= $priceShow*$data['Product']['numberOrder'];
								?>
								<tr>
									<td><?php echo $number;?></td>
									<td>
										<a href="<?php echo $data['Product']['images'][0];?>" class="cart-thumbnail nivo-lightbox"><img class="img-responsive" src="<?php echo $data['Product']['images'][0];?>" alt=""></a>
									</td>
									<td><?php echo $data['Product']['title'];?></td>
									<td>
										<div class="form-group custom-form">
											<label class="sr-only" for="quantity">Số lượng</label>
											<input type="text" class="form-control" id="quantity" name="quantity<?php echo $data['Product']['id'];?>" value="<?php echo $data['Product']['numberOrder'];?>">
										</div>
									</td>
									<td>
										<?php 
											echo number_format($priceShow).' '.$listTypeMoney['Option']['value']['allData'][$data['Product']['typeMoneyId']]['name'];
											if($discount) echo '<p>(Giảm giá)</p>';
											?>
									</td>
									<td class="remove"><a href="javascript:void(0);" onclick="deleteProductCart('<?php echo $data['Product']['id'];?>');"><i class="fa fa-trash-o fa-2x"></i></a></td>
								</tr>
							<?php }?>
							<tr>
								<td colspan="3">
									<input id="codeDiscount" class="form-control" type="text" value="" name="codeDiscount" placeholder="Nhập mã giảm giá sau đó ấn Cập nhập giỏ hàng">
								</td>
								<td align="right"><b>Tổng tiền:</b></td>
								<td align="left">
									 <?php echo number_format($totalMoney);?>
								</td>
								<td></td>
							</tr>
						<?php }else{ ?>
							<tr>
								<td colspan="6" align="center">
									Giỏ hàng trống
								</td>
							</tr>
						<?php }?>
					</tbody>
				</table>
			</div><!-- / table-resonsive -->
			<div class="btn-group btn-group-right col-xs-12">
				<button type="submit" class="custom-btn">Cập nhật giỏ hàng <i class="fa fa-refresh"></i></button>
				<button type="button" class="custom-btn" onclick="clearCart();">Làm trống giỏ hàng <i class="fa fa-trash-o"></i></button>
			</div><!-- / btn-group -->
		</form>
	</div><!-- / row -->
	<div class="row">
		<div class="col-xs-12">
		<hr>
		<form class="custom-form form-horizontal" role="form" action="<?php echo $urlHomes.'saveOrderProduct_addOrder';?>" method="post">
			<input type="hidden" name="userId" value="<?php echo (isset($_SESSION['infoUser']['User']['id']))?$_SESSION['infoUser']['User']['id']:'';?>" />
			<input type="hidden" name="totalMoney" value="<?php echo $totalMoney;?>" />
			<div class="form-group">
				<label for="fullname" class="col-sm-2 control-label">Tên đầy đủ<span class="form-require"> (*)</span></label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="fullname" name="fullname" placeholder="Tên đầy đủ" value="<?php echo (isset($_SESSION['infoUser']['User']['fullname']))?$_SESSION['infoUser']['User']['fullname']:'';?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="email" class="col-sm-2 control-label">Email<span class="form-require"> (*)</span></label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo (isset($_SESSION['infoUser']['User']['email']))?$_SESSION['infoUser']['User']['email']:'';?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="phone" class="col-sm-2 control-label">Điện thoại<span class="form-require"> (*)</span></label>
				<div class="col-sm-10">
					<input type="number" class="form-control" id="phone" name="phone" placeholder="Điện thoại" value="<?php echo (isset($_SESSION['infoUser']['User']['phone']))?$_SESSION['infoUser']['User']['phone']:'';?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="address" class="col-sm-2 control-label">Địa chỉ</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="3" name="address" placeholder="Địa chỉ giao hàng"><?php echo (isset($_SESSION['infoUser']['User']['address']))?$_SESSION['infoUser']['User']['address']:'';?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="note" class="col-sm-2 control-label">Ghi chú</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="3" name="note" placeholder="Ghi chú"></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="custom-btn">Gửi đơn hàng</button>
				</div>
			</div>
		</form>
		</div><!-- / -->
	</div><!-- / row -->
	
</section>

<script type="text/javascript">
	var urlHomes= "<?php echo $urlHomes; ?>";
    var urlPluginCart= "<?php echo getLinkCart(); ?>";
	
	function deleteProductCart(idProduct)
	{
		var r= confirm('Bạn có chắc chắn muốn xóa không?');
		if(r)
		{
			$.ajax({
		      type: "POST",
		      url: urlHomes+"saveOrderProduct_deleteProductCart",
		      data: {idProduct:idProduct}
		    }).done(function( msg ) { 	
			  		window.location= urlPluginCart;
			})
			.fail(function() {
					alert('Quá trình xử lý bị lỗi !');
					return false;
			});
		}
	}
	
	function clearCart()
	{
		var r= confirm('Bạn có chắc chắn muốn làm trống giỏ hàng không?');
		if(r)
		{
			$.ajax({
		      type: "POST",
		      url: urlPluginProduct+"saveOrderProduct_clearCart",
		      data: {}
		    }).done(function( msg ) { 	
			  		window.location= urlPluginCart;
			})
			.fail(function() {
					alert('Quá trình xử lý bị lỗi !');
					return false;
			});
		}
	}
</script>		

<?php getSidebar();?>
<?php getFooter();?>