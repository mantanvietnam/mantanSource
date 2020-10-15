<?php getHeader();?>

<?php
	if(!isset($_GET['show']) || $_GET['show']=='')
	{
		if(isset($_SESSION['typeShow']))
		{
			$show= $_SESSION['typeShow'];
		}
		else
		{
			$_SESSION['typeShow']= 'grid';
			$show= 'grid';
		}
	}
	else
	{
		$show= $_GET['show'];
		$_SESSION['typeShow']= $show;
	}

	if(strpos($tmpVariable['urlPage'],'?')!== false)
	{
		$urlFix= explode('?', $tmpVariable['urlPage']);
		
		$urlPage1= $urlFix[0].'?page='.$tmpVariable['page'].'&show=grid';
		$urlPage2= $urlFix[0].'?page='.$tmpVariable['page'].'&show=list';
	}
	else
	{
		$urlPage1= $tmpVariable['urlPage'].'?show=grid';
		$urlPage2= $tmpVariable['urlPage'].'?show=list';
	}
?>

<?php if($show=='grid'){ ?>
<section class="body-section products-grid">
	<div class="title-wrapper">
		<h1>Sản phẩm đang giảm giá</h1>
		<p class="view">Kiểu xem:</p>
		<a class="grid-view" href="<?php echo $urlPage1;?>" title="Hiển thị dạng lưới"><i class="fa fa-th-large"></i></a>
		<a class="list-view" href="<?php echo $urlPage2;?>"><i class="fa fa-th-list" title="Hiển thị dạng danh sách"></i></a>
	</div><!-- / title-wrapper -->
	<div class="row">
		<?php 
		foreach($tmpVariable['listData'] as $news)
		{ 
			if(!$news['Product']['images'][0])
			{
				$news['Product']['images'][0]= $urlHomes.'/app/Plugin/product/images/no_image-100x100.jpg';
			}		

			$urlProductDetail= getLinkProduct().$news['Product']['slug'].'.html';
			
		?>
		
		<div class="a-product col-lg-3 col-md-4 col-sm-6" data-prdid="<?php echo $news['Product']['id'];?>">
			<div class="inner">
				<div class="media-container">
					<a href="<?php echo $urlProductDetail;?>"><img class="img-responsive" src="<?php echo $news['Product']['images'][0];?>" alt=""></a>
				</div><!-- / media-container -->
				<div class="brief">
					<h2 class="title"><a href="<?php echo $urlProductDetail;?>" title="<?php echo $news['Product']['title'];?>" class="prd-name"><?php echo $news['Product']['title'];?></a></h2>
					<p>
						<?php 
							if($news['Product']['price']>0)
							{
								echo number_format($news['Product']['price']).' '.$tmpVariable['listTypeMoney']['Option']['value']['allData'][$news['Product']['typeMoneyId']]['name'];
							}
							else
							{
								echo 'Giá liên hệ';
							}
						?>
					</p>
					<a id="addtocart" href="<?php echo $urlProductDetail;?>" class="custom-btn btn-box"><i class="fa fa-shopping-cart"></i> Mua hàng</a>
				</div><!-- / brief -->
			</div><!-- / inner -->
		</div><!-- / a-product -->
		<?php }?>
	</div><!-- / row -->
	
	<ul class="custom-pagination text-center">
		<li><a href="<?php echo $tmpVariable['urlPage'].$tmpVariable['back'];?>">First</a></li>
		<li><a href="<?php echo $tmpVariable['urlPage'].$tmpVariable['back'];?>"><i class="fa fa-chevron-left"></i></a></li>
		<?php
			for($i=$tmpVariable['headPage'];$i<=$tmpVariable['endPage'];$i++)
			{
				$classPage= '';
				if($i==$tmpVariable['page']) $classPage= 'class="active"';
				echo '<li '.$classPage.'><a href="'.$tmpVariable['urlPage'].$i.'">'.$i.'</a></li>';
			}
		?>
		<li><a href="<?php echo $tmpVariable['urlPage'].$tmpVariable['next'];?>"><i class="fa fa-chevron-right"></i></a></li>
		<li><a href="<?php echo $tmpVariable['urlPage'].$tmpVariable['next'];?>">Last</a></li>
	</ul>
		
		
</section><!-- / products -->
<?php } else { ?>
<section class="body-section products-list">
	<div class="title-wrapper">
		<h1><?php echo $tmpVariable['category']['name'];?></h1>
		<p class="view">Kiểu xem:</p>
		<a class="grid-view" href="<?php echo $urlPage1;?>" title="Hiển thị dạng lưới"><i class="fa fa-th-large"></i></a>
		<a class="list-view" href="<?php echo $urlPage2;?>"><i class="fa fa-th-list" title="Hiển thị dạng danh sách"></i></a>
	</div><!-- / title-wrapper -->
	<?php 
		foreach($tmpVariable['listData'] as $news)
		{ 
			if(!$news['Product']['images'][0])
			{
				$news['Product']['images'][0]= $urlHomes.'/app/Plugin/product/images/no_image-100x100.jpg';
			}		

			$urlProductDetail= getLinkProduct().$news['Product']['slug'].'.html';
			
		?>

		<div class="a-product" data-prdid="<?php echo $news['Product']['id'];?>">
			<div class="row">
				<div class="media-container col-lg-3 col-md-3 col-sm-4">
					<a href="<?php echo $urlProductDetail;?>"><img class="img-responsive" src="<?php echo $news['Product']['images'][0];?>" alt=""></a>
				</div><!-- / media-container -->
				<div class="detail col-lg-9 col-md-9 col-sm-8">
					<h2 class="title"><a href="<?php echo $urlProductDetail;?>" title="<?php echo $news['Product']['title'];?>" class="prd-name"><?php echo $news['Product']['title'];?></a></h2>
					<p>Giá: <span class="standout">
						<?php 
							if($news['Product']['price']>0)
							{
								echo number_format($news['Product']['price']).' '.$tmpVariable['listTypeMoney']['Option']['value']['allData'][$news['Product']['typeMoneyId']]['name'];
							}
							else
							{
								echo 'Giá liên hệ';
							}
						?>
					</span></p>
					<p class="brief">Mô tả: <span class="standout"><?php echo $news['Product']['description'];?></span></p>
					<a id="addtocart" href="<?php echo $urlProductDetail;?>" class="custom-btn btn-box"><i class="fa fa-shopping-cart"></i> Mua hàng</a>
				</div><!-- / brief -->
			</div><!-- / inner -->
		</div><!-- / a-product -->	
	<?php }?>
	<ul class="custom-pagination text-center">
		<li><a href="<?php echo $tmpVariable['urlPage'].$tmpVariable['back'];?>">First</a></li>
		<li><a href="<?php echo $tmpVariable['urlPage'].$tmpVariable['back'];?>"><i class="fa fa-chevron-left"></i></a></li>
		<?php
			for($i=$tmpVariable['headPage'];$i<=$tmpVariable['endPage'];$i++)
			{
				$classPage= '';
				if($i==$tmpVariable['page']) $classPage= 'class="active"';
				echo '<li '.$classPage.'><a href="'.$tmpVariable['urlPage'].$i.'">'.$i.'</a></li>';
			}
		?>
		<li><a href="<?php echo $tmpVariable['urlPage'].$tmpVariable['next'];?>"><i class="fa fa-chevron-right"></i></a></li>
		<li><a href="<?php echo $tmpVariable['urlPage'].$tmpVariable['next'];?>">Last</a></li>
	</ul>
</section><!-- / products -->
<?php }?>

<?php getSidebar();?>
<?php getFooter();?>

