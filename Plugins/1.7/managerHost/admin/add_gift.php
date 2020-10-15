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
<?php
	$breadcrumb= array( 'name'=>'Danh sách mã giảm giá',
						'url'=>$urlPlugins.'admin/managerHost-admin-list_gift.php',
						'sub'=>array('name'=>'Thêm khuyến mại')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  
	<div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
		<font color='red'><?php echo $messSave;?></font>
	</div>
	
	  <div class="taovien">
	    <form action="" method="post" name="listForm">
	    	<input type="hidden" value="<?php echo @$data['Gift']['id'];?>" name="id" />
	        <table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
			  <tr>
	            <td align="right" >Trạng thái</td>
	            <td align="left">
					<select name="status">
						<option <?php if(isset($data['Gift']['status']) && $data['Gift']['status']=='active') echo 'selected'; ?> value="active">Kích hoạt</option>
						<option <?php if(isset($data['Gift']['status']) && $data['Gift']['status']=='lock') echo 'selected'; ?> value="lock">Khóa</option>
					</select>
				</td>
	          </tr>
			  
	          <tr>
	            <td align="right" width="200" >Mã khuyến mại</td>
	            <td align="left"><input style="width: 300px;" type="text" required="" value="<?php echo @$data['Gift']['code'];?>" name="code" id="code" /></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Áp dụng cho dịch vụ</td>
	            <td align="left">
					<select name="product_id">
						<?php
							foreach($listProduct as $product){
								if(isset($data['Gift']['product_id']) && (string)$data['Gift']['product_id']==$product['Product']['id']){
									echo '<option selected value="'.$product['Product']['id'].'">'.$product['Product']['title'].'</option>';
								}else{
									echo '<option value="'.$product['Product']['id'].'">'.$product['Product']['title'].'</option>';
								}
							}
						?>
					</select>
				</td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Kiểu giảm giá</td>
	            <td align="left">
					<select name="type">
						<option <?php if(isset($data['Gift']['type']) && $data['Gift']['type']=='price') echo 'selected'; ?> value="price">Giảm tiền trực tiếp</option>
						<option <?php if(isset($data['Gift']['type']) && $data['Gift']['type']=='percent') echo 'selected'; ?> value="percent">Giảm phần trăm</option>
					</select>
				</td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Giá trị giảm</td>
	            <td align="left"><input style="width: 300px;" type="number" required="" value="<?php echo @$data['Gift']['value'];?>" name="value" id="value" placeholder="Nhập giá trị sau khi giảm, % nhỏ hơn 100" /></td>
	          </tr>

	          <tr>
	            <td align="right" >Giá trị VAT giảm</td>
	            <td align="left"><input style="width: 300px;" type="number" required="" value="<?php echo @$data['Gift']['vat'];?>" name="vat" id="vat" placeholder="Nhập giá trị sau khi giảm, % nhỏ hơn 100" /></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Số lượng giảm</td>
	            <td align="left"><input style="width: 300px;" type="number" required="" value="<?php echo @$data['Gift']['number'];?>" name="number" id="number" /></td>
	          </tr>
			  
			  <tr>
	            <td align="right" >Thời gian giảm</td>
	            <td align="left">
	            	<?php
	            		$timeStart= '';
		            	if(isset($data['Gift']['timeStart']) && $data['Gift']['timeStart']>0){
			            	$timeStart= getdate($data['Gift']['timeStart']);
			            	$timeStart= $timeStart['mon'].'/'.$timeStart['mday'].'/'.$timeStart['year'];
		            	}
		            	
		            	$timeEnd= '';
		            	if(isset($data['Gift']['timeEnd']) && $data['Gift']['timeEnd']>0){
			            	$timeEnd= getdate($data['Gift']['timeEnd']);
			            	$timeEnd= $timeEnd['mon'].'/'.$timeEnd['mday'].'/'.$timeEnd['year'];
		            	}
	            	?>
					<input style="width: 100px;" type="text" required="" value="<?php echo $timeStart;?>" name="timeStart" id="timeStart" />
					đến 
					<input style="width: 100px;" type="text" required="" value="<?php echo $timeEnd;?>" name="timeEnd" id="timeEnd" />
				</td>
	          </tr>
			  
	          <tr>
	            <td colspan="2">
		            <input type="submit" value="Lưu khuyến mại" />
	            </td>
	          </tr>
	      </table>
	    </form>
	  </div>
	  
	  <script>
		  $(function() {
		    $( "#timeStart" ).datepicker();
		    $( "#timeEnd" ).datepicker();
		  });
	  </script>