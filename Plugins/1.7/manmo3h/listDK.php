<?php
$breadcrumb= array( 'name'=>'Danh sách đăng ký miễn phí',
	'url'=>$urlPlugins.'admin/manmo3h-listDK.php',
	'sub'=>array('name'=>'')
);
addBreadcrumbAdmin($breadcrumb);
?> 
<?php //pr($listNotices);?>
<div class="clear"></div>

<div id="content">
	<style>
	.tableList{
		width: 100%;
		margin-bottom: 20px;
		border-collapse: collapse;
		border-spacing: 0;
		border-top: 1px solid #bcbcbc;
		border-left: 1px solid #bcbcbc;
	}
	.tableList td{
		padding: 5px;
		border-bottom: 1px solid #bcbcbc;
		border-right: 1px solid #bcbcbc;
	}
</style>
<form action="" method="post" name="duan" class="taovienLimit">

	<table id="listTin" cellspacing="0" class="tableList">

		<tr>
			<td align="center">Ngày</td>
			<td align="center">Họ tên</td>
			<td align="center">SĐT</td>
			<td align="center">Email</td>
			<td align="center">Địa chỉ</td>
			<td align="center">Website</td>
			<td align="center">Ghi chú</td>
			<td align="center">Nguồn</td>
			<td align="center">Loại hình</td>

			<td align="center" colspan="2">Choice</td>
		</tr>
		
			<?php 
			if(!empty($listNotices)){
				foreach ($listNotices as $key => $value) {
					?>
					<tr>
					<td><?php echo date('d/m/Y',@$value['DK']['time']);?></td>
					<td><?php echo $value['DK']['name'];?></td>
					<td><?php echo $value['DK']['fone'];?></td>
					<td><?php echo $value['DK']['email'];?></td>
					<td><?php echo $value['DK']['adrees'];?></td>
					<td><?php echo $value['DK']['web'];?></td>
					<td><?php echo @$value['DK']['note'];?></td>
					<td><?php echo @$value['DK']['from'].' '.@$value['DK']['utm_source'].' '.@$value['DK']['utm_campaign'];?></td>
					<td><?php echo $value['DK']['type'];?></td>
					<td><a href="<?php echo $urlPlugins.'admin/manmo3h-deleteDK.php?idDelete='.$value['DK']['id'];?>">Xóa</a></td>
					<td><a href="javascript:void(0);" onclick="showNote('<?php echo $value['DK']['id'];?>');">Nhập note</a></td>
					</tr>
					<?php 
				}
			}
			?>
		
	</table>
</form
<p>
  <?php
  if($page>5){
    $startPage= $page-5;
  }else{
    $startPage= 1;
  }

  if($totalPage>$page+5){
    $endPage= $page+5;
  }else{
    $endPage= $totalPage;
  }

  echo '<a href="'.$urlPage.$back.'">Previous Page</a> ';
  for($i=$startPage;$i<=$endPage;$i++){
    echo ' <a href="'.$urlPage.$i.'">'.$i.'</a> ';
  }
  echo ' <a href="'.$urlPage.$next.'">Next Page</a> ';
  ?>
</p>

<script type="text/javascript">
	function showNote(idOrder)
	{
		var note= prompt("Nhập ghi chú");
		if (note != null) {
			$.ajax({
			  method: "POST",
			  url: "/plugins/admin/manmo3h-saveNoteDKAjax.php",
			  data: { note: note, idOrder: idOrder }
			})
			.done(function( msg ) {
				//alert(msg);
				window.location= '<?php echo $urlNow;?>';    
			});
		} 
	}
</script>