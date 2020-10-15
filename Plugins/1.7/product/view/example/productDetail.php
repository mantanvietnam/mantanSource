<?php getHeader();?>
<script type="text/javascript">
	var urlPluginCart= "<?php echo getLinkCart(); ?>";
	var urlHomes= "<?php echo $urlHomes; ?>";

	function addToCartAnimation($from, $to, $clone) {
		$from.on('click', function(){
			var idProductShow= $('#idProductShow').val();
			
			$.ajax({
		      type: "POST",
		      url: urlHomes+"saveOrderProduct_addProduct",
		      data: {id:idProductShow}
		    }).done(function( msg ) { 	
				var cart = $to;
				var imgtodrag = $clone.eq(0);
				if (imgtodrag) {
					var imgclone = imgtodrag.clone()
					.offset({
					top: imgtodrag.offset().top,
					left: imgtodrag.offset().left
				})
				.css({
					'opacity': '0.5',
					'position': 'absolute',
					'height': '150px',
					'width': '150px',
					'z-index': '100'
				})
				.appendTo($('body')).animate({
					'top': cart.offset().top + 10,
					'left': cart.offset().left + 10,
					'width': 75,
					'height': 75
					},
					1000,
					'easeInOutExpo'
				);
				// setTimeout(function () {
				// 	cart.effect("shake", {
				// 		times: 2
				// 	}, 200);
				// }, 1500);
		
				imgclone.animate({
					'width': 0,
					'height': 0
				},
				function () {
					$(this).detach()
				});
				}
				window.setTimeout(function () {
					$('#numberOrderProduct').html(msg);
					
				}, 1500);
				window.setTimeout(function () {
					window.location= urlPluginCart;
					
				}, 1500);
				return false;
			});
			$("html, body").animate({ scrollTop: 0 }, "slow");
			return false;
		});
	}
</script>

<script type="text/javascript">
	$(document).ready(function(){
		/*  Add to cart animation */
		addToCartAnimation($('#addtocart'), $('#cart span'), $('.main-image-wrapper .main-image'));
	});
</script>

<!-- P R O D U C T S -->
<section class="body-section product-detail">
	<h1>
		<?php
			echo $tmpVariable['data']['Product']['title'];
			if($tmpVariable['data']['Product']['alias']!='')
			{
				echo ' ('.$tmpVariable['data']['Product']['alias'].')';
			}
		?>
	</h1>
	<div class="overview row">
		<div class="figures col-md-4 col-sm-12">
			<div class="main-image-wrapper media-container">
				<div class="inner">
					<img class="main-image img-responsive" src="<?php echo $tmpVariable['data']['Product']['images'][0];?>" alt="<?php echo $tmpVariable['data']['Product']['title'];?>" title="<?php echo $tmpVariable['data']['Product']['title'];?>">
					<div class="hover-overlay"></div>
					<a class="nivo-lightbox icon" href="<?php echo $tmpVariable['data']['Product']['images'][0];?>"><img src="<?php echo $urlThemeActive;?>images/magnifying-glass_64px.png" alt="" class="img-responsive"></a>
				</div><!-- / inner -->
			</div><!-- media-container -->
			<div class="thumbnail-figures">
				<?php
					foreach($tmpVariable['data']['Product']['images'] as $images)
					{
						echo '  <div class="a-thumbnail">
									<div class="inner">
										<a href="'.$images.'" class="nivo-lightbox" data-lightbox-gallery="gallery1">
											<img src="'.$images.'" class="img-responsive" alt="'.$tmpVariable['data']['Product']['title'].'" title="'.$tmpVariable['data']['Product']['title'].'">
										</a>
									</div><!-- / inner -->
								</div>';
					}
				?>
			</div><!-- / thumbnail-figures -->
		</div><!--  / figures -->
		<div class="price-order col-md-8 col-sm-12">
			<span>
				<a style="float:left;margin-right:10px;margin-top:-3px;" href="mailto:<?php echo $contactSite['Option']['value']['email'];?>" target="_blank" data-original-title="Email"><i class="fa fa-envelope" style="font-size:21px;"></i></a>
				<?php if(function_exists('showShareFacebook')) showShareFacebook();?>
				<?php if(function_exists('showLikeFacebook')) showLikeFacebook();?>
				<?php if(function_exists('showButtonGPlus')) showButtonGPlus();?>
			</span>
			<br/>

			<?php
				if($tmpVariable['data']['Product']['quantity']>0)
				{
					echo '<p class="status on">Tình trạng: <span>Còn hàng</span></p>';
				}
				else
				{
					echo '<p class="status off">Tình trạng: <span>Đặt hàng</span></p>';
				}

			?>
			<p>Mã sản phẩm: <span class="standout"><?php echo $tmpVariable['data']['Product']['code'];?></span></p>
			<div xmlns:v="http://rdf.data-vocabulary.org/#" id="crumbs">
				<p>Hãng xe:
					<span class="standout">
						<?php
							if(isset($tmpVariable['infoParentManufacturer']['name']))
							{
								echo ' <span typeof="v:Breadcrumb">
											<a rel="v:url" property="v:title" href="'.getLinkManufacturer().$tmpVariable['infoParentManufacturer']['slug'].'.html" title="Xem tất cả phụ tùng ô tô '.$tmpVariable['infoParentManufacturer']['name'].'">'.$tmpVariable['infoParentManufacturer']['name'].'</a>
										</span>';
							}
						?>
					</span>
				</p>
				<p>Model xe:
					<span class="standout">
						<?php
							if($tmpVariable['infoManufacturer'])
							{
								echo ' <span typeof="v:Breadcrumb">
											<a rel="v:url" property="v:title" href="'.getLinkManufacturer().$tmpVariable['infoManufacturer']['slug'].'.html" title="Xem tất cả phụ tùng ô tô '.$tmpVariable['infoManufacturer']['name'].'">'.$tmpVariable['infoManufacturer']['name'].'</a>
										</span>';
							}
						?>
					</span>
				</p>
			</div>
			<p class="price">Giá bán:
				<?php
					if($tmpVariable['data']['Product']['price']>0)
					{
						echo number_format($tmpVariable['data']['Product']['price']).' '.$tmpVariable['listTypeMoney']['Option']['value']['allData'][$tmpVariable['data']['Product']['typeMoneyId']]['name'];
					}
					else
					{
						echo 'Giá liên hệ';
					}
				?>
			</p>

			<input id="idProductShow" value="<?php echo $tmpVariable['data']['Product']['id'];?>" type="hidden" />
			<a id="addtocart" href="" class="custom-btn">Mua hàng</a>
		</div><!-- / detail -->
	</div><!-- / row -->

	<div class="detail row">
		<div class="detail-info col-sm-12">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#soluoc" data-toggle="tab">Mô tả sản phẩm</a></li>
				<?php
					global $phutungotottcThemeSettings;
					if(isset($phutungotottcThemeSettings['Option']['value']['idLinkWebCategoryProductDetail']) && function_exists('getListLinkWeb')){
						$getListLinkWeb= getListLinkWeb($phutungotottcThemeSettings['Option']['value']['idLinkWebCategoryProductDetail']);
						if(count($getListLinkWeb)>0){
							foreach($getListLinkWeb as $components){
								echo '<li><a target="_blank" href="'.$components['link'].'">'.$components['name'].'</a></li>';
							}
						}
					}
				?>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="soluoc">
					<ul class="custom-ulist">
						<?php echo $tmpVariable['data']['Product']['info'];?>
						<?php
							if($tmpVariable['data']['Product']['dateDiscountStart'])
							{
								$dateDiscountStart= getdate($tmpVariable['data']['Product']['dateDiscountStart']);
								$dateDiscountEnd= getdate($tmpVariable['data']['Product']['dateDiscountEnd']);

								$dateDiscountStart= $dateDiscountStart['mday'].'/'.$dateDiscountStart['mon'].'/'.$dateDiscountStart['year'];
								$dateDiscountEnd= $dateDiscountEnd['mday'].'/'.$dateDiscountEnd['mon'].'/'.$dateDiscountEnd['year'];
								echo '<li>Giảm giá: từ ngày <span style="color:red;">'.$dateDiscountStart.'</span> đến <span style="color:red;">'.$dateDiscountEnd.'</span> giảm giá sản phẩm còn <span style="color:red;">'.number_format($tmpVariable['data']['Product']['priceDiscount']).' '.$tmpVariable['listTypeMoney']['Option']['value']['allData'][$tmpVariable['data']['Product']['typeMoneyId']]['name'].'</span> với mã giảm giá <span style="color:red;">'.implode(', ', $tmpVariable['data']['Product']['codeDiscount']).'</span></li>';
							}
						?>
						<br/><br/>

						<p>
							<a href="<?php echo $urlHomes;?>">Phụ tùng ô tô TTC</a>: Chuyên cung cấp "<b><i><?php echo $tmpVariable['data']['Product']['title'];?></i></b>" hàng xịn, chính hãng giá tốt nhất, thuộc loại <a href="<?php echo getLinkManufacturer().$tmpVariable['infoManufacturer']['slug'].'.html';?>">phụ tùng ô tô <?php echo $tmpVariable['infoManufacturer']['name'];?> </a> | <a href="<?php if(isset($tmpVariable['infoParentManufacturer']['name'])) echo getLinkManufacturer().$tmpVariable['infoParentManufacturer']['slug'].'.html';?>">phụ tùng ô tô <?php if(isset($tmpVariable['infoParentManufacturer']['name'])) echo $tmpVariable['infoParentManufacturer']['name'];?></a> nhập khẩu chính hãng, phân phối toàn quốc, uy tín, cam kết chất lượng.
							<br/>
							<b>HOTLINE: 0913.50.54.55 / 0912.46.91.90</b>
							<br/>
							Để tra mã <a href="<?php echo $urlHomes;?>">Phụ tùng ô tô</a> vui lòng xem <a href="http://phutungotottc.com/notices/tra-ma-phu-tung-o-to-chinh-xac-nhat.html">Tra mã phụ tùng ô tô</a>
						</p>
						<p style="color:red;">
							Chúng tôi đề nghị sử dụng "<?php echo $tmpVariable['data']['Product']['title'];?>" đảm bảo chất lượng để có được đầy đủ lợi ích từ hoạt động tin cậy tuyệt đối của xe. Sử dụng phụ tùng không chính hãng hoặc giả mạo đôi khi có thể gây ra những hậu quả đáng tiếc.
						</p>
						

					</ul>
				</div>

			</div><!-- / tab-content -->
		</div><!-- / detail-info row -->
	</div><!-- / row -->

</section><!-- / products -->



<?php
	if(isset($tmpVariable['data']['Product']['key']))
	{
		$listKey= explode(',', $tmpVariable['data']['Product']['key']);
		$listKeyNew= array();
		if(count($listKey)>0){
			foreach($listKey as $key)
			{
				$key= '<a href="'.getLinkSearch().'?key='.$key.'" >'.$key.'</a>';
				array_push($listKeyNew, $key);
			}
			echo '<div class="body-section related-articles">
					<h2>Từ khóa</h2>';
			echo implode(', ', $listKeyNew);
			echo '</div>';
		}
	}
?>
<div class="body-section related-articles">
	<h2>
		Nhận xét về
		<?php
			echo $tmpVariable['data']['Product']['title'];
			if($tmpVariable['data']['Product']['alias']!='')
			{
				echo ' ('.$tmpVariable['data']['Product']['alias'].')';
			}
		?>
	</h2>
	<?php if(function_exists('showCommentFacebook')) showCommentFacebook($urlNow,5);?>
</div><!-- / facebook-plugin row -->

<section class="body-section related-products">
	<h2>Sản phẩm liên quan</h2>
	<div class="related-products-wrapper row">
		<?php
			if(count($tmpVariable['otherData'])>0){
				foreach($tmpVariable['otherData'] as $otherData)
				{
					if(!isset($otherData['Product']['images'][0]))
					{
						$otherData['Product']['images'][0]= $urlThemeActive.'images/no_image-100x100.jpg';
					}
					$urlProductDetail= getLinkProduct().$otherData['Product']['slug'].'.html';

					echo '  <div class="a-product col-lg-3 col-md-4 col-sm-6" data-prdid="'.$otherData['Product']['id'].'">
								<div class="inner">
									<div class="media-container">
										<a href="'.$urlProductDetail.'"><img class="img-responsive" src="'.$otherData['Product']['images'][0].'" alt=""></a>
									</div><!-- / media-container -->
									<div class="brief">
										<h3><a href="'.$urlProductDetail.'" class="prd-name">'.$otherData['Product']['title'].'</a></h3>
										<p>'.number_format($otherData['Product']['price']).' '.$tmpVariable['listTypeMoney']['Option']['value']['allData'][$otherData['Product']['typeMoneyId']]['name'].'</p>
										<a id="addtocart" href="'.$urlProductDetail.'" class="custom-btn btn-box"><i class="fa fa-shopping-cart"></i> Mua hàng</a>
									</div><!-- / brief -->
								</div><!-- / inner -->
							</div><!-- / a-product -->';
				}
			}
		?>
	</div><!-- / row -->
</section>

<?php getSidebar();?>
<?php getFooter();?>