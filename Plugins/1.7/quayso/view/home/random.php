<?php 
	getFileTheme('header.php');
	global $themeSettings; 
?>

<style type="text/css">
	.result_random{
		width: 200px;
		height: 200px;
		border: 1px solid #07357A;
		margin: 0 auto;
		border-radius: 110px;
		text-align: center;
		display: none;
		font-size: 20px;
		font-weight: bold;
	}
</style>

<section class="intro_main">
	<div class="container">
		<img src="<?php echo @$themeSettings['Option']['value']['banner']; ?>" width="100%">
		<div class="alert alert-info" role="alert" style="background-color: <?php echo @$themeSettings['Option']['value']['color']; ?>">
			<a href="/">Trang chủ</a> / <a href="/random">Quay số ngẫu nhiên</a>
		</div>
		<div class="row">
			<div class="col-md-8 col-12">
				<h1 style="color: #07357A; font-weight: bold;font-size: 25px">Quay số ngẫu nhiên</h1>
				
				<div class="content_viewNews" style="width: 100%">
					<div class="form-row">
					    <div class="form-group col-md-6">
					      	<label for="start">Số bắt đầu</label>
					      	<input type="number" class="form-control" id="start" placeholder="min">
					    </div>
					    <div class="form-group col-md-6">
					      	<label for="end">Số kết thúc</label>
					      	<input type="number" class="form-control" id="end" placeholder="max">
					    </div>
					</div>
					<div class="text-center">
						<button type="button" onclick="getRandom()" class="btn btn-primary">Quay số</button>
					</div>
					<div class="text-center mt-3 mb-3">
						<div class="result_random">
							<img src="/app/Plugin/quayso/view/home/image/loading.gif" width="100%">
						</div>
					</div>
				</div>
				
			</div>
			<?php getFileTheme('sidebar.php');?>
		</div>
	</div>
</section>

<script type="text/javascript">
	var random;

	function getRandom()
	{
		var start = $('#start').val();
		var end = $('#end').val();

		if(start=='') start= 1;
		if(end=='') end= 1000;

		do{
			random = Math.floor((Math.random() * end) + start);
		} while (random<start || random>end);

		$('.result_random').css('padding-top','0px');
		$('.result_random').html('<img src="/app/Plugin/quayso/view/home/image/loading.gif" width="100%">');
		$('.result_random').show();
		
		setTimeout(showResultRandom, 5000);
	}

	function showResultRandom()
	{
		$('.result_random').css('padding-top','90px');
		$('.result_random').html(random);
	}
</script>

<?php getFileTheme('footer.php'); ?>