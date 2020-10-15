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
	$breadcrumb= array( 'name'=>'Danh sách đơn hàng',
						'url'=>$urlPlugins.'admin/managerHost-admin-list_order.php',
						'sub'=>array('name'=>'Xử lý đơn hàng')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
	<div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
		<font color='red'><?php echo $messSave;?></font>
	</div>
	
	  <div class="taovien">
	    <form action="" method="post" name="listForm">
	    	<input type="hidden" value="<?php echo @$data['Order']['id'];?>" name="id" />
	        <table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
	          <tr>
	            <td align="right" width="200" >Ngày đặt</td>
	            <td align="left"><?php echo $data['Order']['created'];?></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Tài khoản</td>
	            <td align="left"><?php echo $data['Order']['user_email'];?></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Mã giảm giá</td>
	            <td align="left"><?php echo $data['Order']['infoOrder']['codeGift'];?></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Người giới thiệu</td>
	            <td align="left"><?php echo $data['Order']['referral'];?></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Tổng tiền</td>
	            <td align="left"><?php echo number_format($data['Order']['infoOrder']['totalOrder']).'đ';?></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Giảm trừ</td>
	            <td align="left"><input style="width: 300px;" type="number" value="<?php echo @$data['Order']['infoOrder']['priceDiscount'];?>" name="priceDiscount" id="priceDiscount" /></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Thông tin đơn hàng</td>
	            <td align="left">
	            	<?php
		            	foreach($data['Order']['listOrder'] as $order){
							echo '  <p><b>'.$order['Product']['title'].'</b> : '.$order['Product']['year'].' năm . Duy trì: '.number_format($order['Product']['priceMainten']).'đ <a target="_blank" href="'.$urlPlugins.'admin/managerHost-admin-add_service.php?orderID='.$data['Order']['id'].'&productID='.$order['Product']['id'].'"><input type="button" value="Tạo dịch vụ"></a></p>
									<textarea name="info['.$order['Product']['id'].']" style="width: 300px;" rows="10">'.$order['Product']['info'].'</textarea>';
						}
	            	?>
	            </td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Hình thức thanh toán</td>
	            <td align="left">
		            <select name="pay">
			            <?php
				            foreach($typePay as $key=>$pay){
					            if($key!=$data['Order']['infoOrder']['pay']){
						            echo '<option value="'.$key.'">'.$pay.'</option>';
					            }else{
						            echo '<option selected value="'.$key.'">'.$pay.'</option>';
					            }
				            }
			            ?>
		            </select>
	            </td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Trạng thái thanh toán</td>
	            <td align="left">
		            <select name="payStatus">
			            <?php
				            foreach($typePayStatus as $key=>$pay){
					            if($key!=$data['Order']['payStatus']){
						            echo '<option value="'.$key.'">'.$pay.'</option>';
					            }else{
						            echo '<option selected value="'.$key.'">'.$pay.'</option>';
					            }
				            }
			            ?>
		            </select>
	            </td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Trạng thái xử lý</td>
	            <td align="left">
		            <select name="processStatus">
			            <?php
				            foreach($typeProcessStatus as $key=>$pay){
					            if($key!=$data['Order']['processStatus']){
						            echo '<option value="'.$key.'">'.$pay.'</option>';
					            }else{
						            echo '<option selected value="'.$key.'">'.$pay.'</option>';
					            }
				            }
			            ?>
		            </select>
	            </td>
	          </tr>
			  
	          <tr>
	            <td colspan="2">
		            <input type="submit" value="Lưu đơn hàng" />
	            </td>
	          </tr>
	      </table>
		  <p>Thông tin người quản trị</p>
		  <table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
	          <tr>
	            <td align="right" width="200" >Họ tên</td>
	            <td align="left"><input required="" style="width: 300px;" type="text" value="<?php echo @$data['Order']['infoOrder']['name'];?>" name="name" id="name" /></td>
	          </tr>
			  <tr>
	            <td align="right" >Email quản trị</td>
	            <td align="left"><input required="" style="width: 300px;" type="email" value="<?php echo @$data['Order']['infoOrder']['email'];?>" name="email" id="email" /></td>
	          </tr>
			  <tr>
	            <td align="right" >Email nhận thông báo</td>
	            <td align="left"><input required="" style="width: 300px;" type="text" value="<?php echo @$data['Order']['infoOrder']['notification'];?>" name="notification" id="notification" /></td>
	          </tr>
			  <tr>
	            <td align="right" >Điện thoại</td>
	            <td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Order']['infoOrder']['phone'];?>" name="phone" id="phone" /></td>
	          </tr>
			  <tr>
	            <td align="right" >Địa chỉ</td>
	            <td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Order']['infoOrder']['address'];?>" name="address" id="address" /></td>
	          </tr>
			  
			  <tr>
	            <td colspan="2">
		            <input type="submit" value="Lưu đơn hàng" />
	            </td>
	          </tr>
	      </table>
	    </form>
	  </div>
