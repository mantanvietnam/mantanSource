<!-- <!DOCTYPE html>
<html lang="vi">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>GAVI Agency Site</title>

	<link href="/app/Plugin/gavi/view/agency/css/bootstrap.min.css" rel="stylesheet">
	<link href="/app/Plugin/gavi/view/agency/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link href="/app/Plugin/gavi/view/agency/css/mystyle.css" rel="stylesheet">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>

<body> -->
	
	<?php include('header_nav.php');?>
	<div class="container title-page">
		<!-- <a href="/listOrderBuy" class="back"> -->
			<a href="/listOrderBuy"  class="back">
				<i class="fa fa-angle-left" aria-hidden="true"></i>
			</a>
			<p>Đơn mua mới</p>
			
		<!-- <a href="javascript:void(0);" class="back-store"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
		<ul class="list-unstyled ul_buy">
			<li>
				<a href="/listOrderBuy" class="">
					<i class="fa fa-list"></i> Danh sách đơn mua
				</a>
			</li>
		</ul> -->
	</div>

	<div class="container banner">
		<a href="">
			<img src="/app/Plugin/gavi/view/agency/img/banner.png">
		</a>
	</div>
	<form method="post">
		<div class="container">
			<div class="row1 b_money">
				<div class="col-xs-6 col-sm-4" style="padding-left: 0; padding-right: 0;">
					<p>
						<i class="fa fa-credit-card" aria-hidden="true"></i> <span><?php echo number_format(@$_SESSION['infoAgency']['Agency']['wallet']['purchaseFund']+@$_SESSION['infoAgency']['Agency']['wallet']['active']);?></span><span>đ</span>
					</p>
					
				</div>
				<div class="col-xs-6 col-sm-4" style="padding-left: 0; padding-right: 0;">
					<p title="Tiền mua hàng">
						<i class="fa fa-shopping-cart" aria-hidden="true"></i>  <span class="total" id="totalPrice"> </span><span>đ</span>
					</p>
				</div>
				<div class="col-xs-12 col-sm-4">
					<div class="product-count1">
						<button class="btn-gavi1 btn" type="submit" onclick="return confirm('Bạn có chắc chắn muốn gửi đơn hàng ?');">Mua hàng</button>
					</div>
				</div>
			</div>
		</div>

		<div class="container page-content letter-list" style="background: white;padding: 0px 0 20px 0;">
			<div class="product-list buy-product">
				<input type="hidden" name="price" id="price" value="">
				<!-- <p style="color: red;"><?php echo $mess;?></p> -->
				<?php if(!empty($mess)){ ?>
				<div id="showM" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Thông báo</h4>
							</div>
							<div class="modal-body">
								<div class="showMess"><?php echo $mess; ?></div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default setfocus" data-dismiss="modal" autofocus>Đóng</button>
							</div>
						</div>

					</div>
				</div>
				<?php }?>
				<?php
				if(!empty($listProduct)){
					foreach($listProduct as $product){
						echo '<div class="col-xs-12 col-md-12 product-item">
						<input type="hidden" value="'.$product['Product']['productContainer'].'" id="productContainer'.$product['Product']['id'].'" />
						<input type="hidden" value="'.$product['Product']['priceShipContainer'].'" id="priceShipContainer'.$product['Product']['id'].'" />
						<input type="hidden" value="'.$product['Product']['freeShipContainer'].'" id="freeShipContainer'.$product['Product']['id'].'" />
						<div class="thumb">
						<img src="'.$product['Product']['image'].'">
						</div>
						<div class="product-name">
						<label>'.$product['Product']['name'].'</label>
						<span class="price" data-price="30">'.number_format($product['Product']['priceAgency'][$_SESSION['infoAgency']['Agency']['level']]).'đ</span>
						<span class="price-old">'.number_format($product['Product']['price']).'đ</span>
						<span>Tồn kho: '.number_format(@$_SESSION['infoAgency']['Agency']['product'][$product['Product']['id']]).' '.$product['Product']['unit'].'</span>
						</div>
						<div class="product-count">
						<input onchange="checkProduct(\''.$product['Product']['id'].'\');" type="text" data-id="97" placeholder="Đơn vị: '.$product['Product']['unit'].', bội của '.$product['Product']['productContainer'].'" data-price="30" value="" class="input_money form-control quant" id="'.$product['Product']['id'].'" name="number['.$product['Product']['id'].']" />
						</div>
						</div>';
					}
				}
				?>


    <div class="note_i col-xs-12"><i class="fa fa-info-circle"></i> Tiền sẽ được chuyển từ 'tiền được rút' sang 'quỹ mua hàng' nếu quỹ mua hàng của bạn không đủ để đặt hàng !</div>
			</div>
		</div>
	</form>

	<script src="/app/Plugin/gavi/view/agency/js/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="/app/Plugin/gavi/view/agency/js/bootstrap.min.js"></script>
	<script src="/app/Plugin/gavi/view/agency/js/ie-emulation-modes-warning.js"></script>
	<script src="/app/Plugin/gavi/view/agency/js/ie10-viewport-bug-workaround.js"></script>
	<script src="/app/Plugin/gavi/view/agency/js/qrcode.min.js"></script>
	
	<script>
		$(document).ready(function() {
			$('.back-store').click(function(){
				$('.ul_buy').slideToggle();
			});
		});
	</script>

	<script>
		$(document).ready(function() {
			var t = $('.b_money').offset().top;
			var container= $('.container').innerWidth();

			$(window).scroll(function(){
				if ( $(window).scrollTop() >= 10 ){
					$('.b_money').addClass('b_fix');
					$('.b_money').css({'width': container});
				} else{
					$('.b_money').removeClass('b_fix');
					$('.b_money').css({'width': 'auto'});
				}
			});
		});
	</script>

	<script type="text/javascript">
		function checkProduct(id){
			var productContainer= parseInt($('#productContainer'+id).val());
			var priceShipContainer= parseInt($('#priceShipContainer'+id).val());
			var freeShipContainer= parseInt($('#freeShipContainer'+id).val());
			var number= parseInt($('#'+id).val());

			if(number%productContainer==0){
				update();
			}else{
				$('#'+id).val('');
				alert('Bạn phải nhập số sản phẩm là bội số của '+productContainer);
			}

			
		}

		function update() {
			var sum = 0.0;
			var quantity=0;
			var price=0;
			var amount=0;

			$('.product-item').each(function() {
				quantity = $(this).find('.quant').val();
				price = parseFloat($(this).find('.price').text().replace(',',''));
				amount = (quantity * price);
				sum += amount;
			});
			$('#totalPrice').text(sum.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));

			$('#price').val($('#totalPrice').text());
		}

		update();
	</script>
</body>
</html>
