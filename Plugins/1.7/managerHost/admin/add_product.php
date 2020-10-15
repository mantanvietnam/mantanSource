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
	$breadcrumb= array( 'name'=>'Danh sách dịch vụ',
						'url'=>$urlPlugins.'admin/managerHost-admin-list_product.php',
						'sub'=>array('name'=>'Thêm dịch vụ')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
	<div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
		<font color='red'><?php echo $messSave;?></font>
	</div>
	
	  <div class="taovien">
	    <form action="" method="post" name="listForm">
	    	<input type="hidden" value="<?php echo @$data['Product']['id'];?>" name="id" />
	        <table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
	          <tr>
	            <td align="right" >Loại dịch vụ</td>
	            <td align="left">
					<select name="typeService">
						<?php
							foreach($typeService as $key=>$type){
								if(isset($data['Product']['typeService']) && (int)$data['Product']['typeService']==$key){
									echo '<option selected value="'.$key.'">'.$type.'</option>';
								}else{
									echo '<option value="'.$key.'">'.$type.'</option>';
								}
							}
						?>
					</select>
				</td>
	          </tr>
	          <tr>
	            <td align="right" width="200" >Tên dịch vụ</td>
	            <td align="left"><input style="width: 300px;" type="text" required="" value="<?php echo @$data['Product']['title'];?>" name="title" id="title" /></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Phí khởi tạo</td>
	            <td align="left"><input style="width: 300px;" type="number" required="" value="<?php echo @$data['Product']['priceInstall'];?>" name="priceInstall" id="priceInstall" /></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Phí duy trì/năm</td>
	            <td align="left"><input style="width: 300px;" type="number" required="" value="<?php echo @$data['Product']['priceMainten'];?>" name="priceMainten" id="priceMainten" /></td>
	          </tr>

	          <tr>
	            <td align="right" >Thuế VAT</td>
	            <td align="left"><input style="width: 300px;" type="number" required="" value="<?php echo @$data['Product']['priceVat'];?>" name="priceVat" id="priceVat" /></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Phí chuyển đổi nhà cung cấp</td>
	            <td align="left"><input style="width: 300px;" type="number" required="" value="<?php echo @$data['Product']['priceTransfer'];?>" name="priceTransfer" id="priceTransfer" /></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Mô tả</td>
	            <td align="left">
	            	<textarea rows="10" style="width: 300px;" name="info"><?php echo @$data['Product']['info'];?></textarea>
	            </td>
	          </tr>
	          <tr>
	            <td colspan="2">
		            <input type="submit" value="Lưu dịch vụ" />
	            </td>
	          </tr>
	      </table>
	    </form>
	  </div>
