<?php
	function loadAjaxNotice($nameClass,$idCat)
	{
		global $urlHomes;
		?>
		<script type="text/javascript">
			var urlHomes= '<?php echo $urlHomes;?>';
			var page=2;
			var idCat= <?php echo $idCat; ?>

			function getListNotice()
			{
				$.ajax({
					  type: "POST",
					  url: urlHomes+"ajaxNotice",
					  data: { page:page, idCat:idCat}
					}).done(function( msg ) {
				  		var listAlbumShow= $('.<?php echo $nameClass; ?>').html();
				  		$('.<?php echo $nameClass; ?>').html(listAlbumShow+msg);
				  		page++;

				  		loadMassonry();
					})
					.fail(function() {
						alert('Quá trình load sản phẩm gặp lỗi !');
						return false;
					});
			}
		</script>
		<?php
	}
?>