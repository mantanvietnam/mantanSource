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
	$breadcrumb= array( 'name'=>'Dịch vụ khách thuê',
						'url'=>$urlPlugins.'admin/managerHost-admin-list_service.php',
						'sub'=>array('name'=>'Thêm dịch vụ')
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
	    	<input type="hidden" value="<?php echo @$data['Service']['id'];?>" name="id" />
	    	
	    	<p><b>Gửi email thông báo</b></p>
	    	<input type="radio" value="1" name="sendMail" checked /> Có gửi 
	    	<input type="radio" value="0" name="sendMail" /> Không gửi 
	    	<br/><br/>

	    	<p><b>Thông tin quản lý dịch vụ</b></p>
			<table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
		          <tr>
		            <td align="right" width="200" >Trang quản trị</td>
		            <td align="left"><input required="" style="width: 300px;" type="text" value="<?php echo @$data['Service']['urlPanel'];?>" name="urlPanel" id="urlPanel" /></td>
		          </tr>
				  <tr>
		            <td align="right" >Tài khoản</td>
		            <td align="left"><input required="" style="width: 300px;" type="text" value="<?php echo @$data['Service']['account'];?>" name="account" id="account" /></td>
		          </tr>
				  <tr>
		            <td align="right" >Mật khẩu</td>
		            <td align="left"><input required="" style="width: 300px;" type="text" value="<?php echo @$data['Service']['pass'];?>" name="pass" id="pass" /></td>
		          </tr>
				  <tr>
		            <td colspan="2">
			            <input type="submit" value="Lưu dịch vụ" />
		            </td>
		          </tr>
		    </table>
		      
		    <p><b>Thông tin đơn hàng</b></p>
	        <table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
			  <tr>
	            <td align="right" >Loại dịch vụ</td>
	            <td align="left">
					<select name="typeService">
						<?php
							foreach($typeService as $key=>$type){
								if(isset($data['Service']['typeService']) && (int)$data['Service']['typeService']==$key){
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
	            <td align="right" >Dịch vụ</td>
	            <td align="left">
					<select name="product_id">
						<?php
							foreach($listProduct as $product){
								if(isset($data['Service']['product_id']) && (string)$data['Service']['product_id']==$product['Product']['id']){
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
	            <td align="right" width="200" >Ghi chú</td>
	            <td align="left"><textarea style="width: 300px;" rows="5" name="info" id="info"><?php echo @$data['Service']['info'];?></textarea></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Tình trạng</td>
	            <td align="left">
					<select name="status">
			            <?php
				            foreach($typeStatusDomain as $key=>$value){
					            if(isset($data['Service']['status']) && $key==$data['Service']['status']){
						            echo '<option selected value="'.$key.'">'.$value.'</option>';
					            }else{
						            echo '<option value="'.$key.'">'.$value.'</option>';
					            }
				            }
			            ?>
		            </select>
				</td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Ngày kích hoạt</td>
	            <td align="left"><input style="width: 300px;" type="text" required="" value="<?php echo @$data['Service']['timeStart'];?>" name="timeStart" id="timeStart" /></td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Ngày hết hạn</td>
	            <td align="left"><input style="width: 300px;" type="text" required="" value="<?php echo @$data['Service']['timeEnd'];?>" name="timeEnd" id="timeEnd" /></td>
	          </tr>
			  
			  <tr>
	            <td align="right" >Email người đăng ký</td>
	            <td align="left"><input style="width: 300px;" type="email" required="" value="<?php echo @$data['Service']['user_email'];?>" name="user_email" id="user_email" /></td>
	          </tr>
			  
			  <tr>
	            <td align="right" >Email người giới thiệu</td>
	            <td align="left"><input style="width: 300px;" type="email" value="<?php echo @$data['Service']['referral'];?>" name="referral" id="referral" /></td>
	          </tr>
			  
			  <tr>
	            <td align="right" >Tổng phí ban đầu</td>
	            <td align="left"><input style="width: 300px;" type="number" required="" value="<?php echo @$data['Service']['priceTotal'];?>" name="priceTotal" id="priceTotal" /></td>
	          </tr>
	          
			  <tr>
	            <td align="right" >Phí duy trì</td>
	            <td align="left"><input style="width: 300px;" type="number" required="" value="<?php echo @$data['Service']['priceMainten'];?>" name="priceMainten" id="priceMainten" /></td>
	          </tr>
			  
			  <tr>
	            <td align="right" >Mã giảm giá</td>
	            <td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Service']['gift'];?>" name="gift" id="gift" /></td>
	          </tr>
	          
	          <tr>
	            <td colspan="2">
		            <input type="submit" value="Lưu dịch vụ" />
	            </td>
	          </tr>
	      </table>
		  
		  <p><b>Thông tin người quản trị</b></p>
		  <table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
	          <tr>
	            <td align="right" width="200" >Họ tên</td>
	            <td align="left"><input required="" style="width: 300px;" type="text" value="<?php echo @$data['Service']['name'];?>" name="name" id="name" /></td>
	          </tr>
			  <tr>
	            <td align="right" >Email quản trị</td>
	            <td align="left"><input required="" style="width: 300px;" type="email" value="<?php echo @$data['Service']['emailManager'];?>" name="email" id="email" /></td>
	          </tr>
			  <tr>
	            <td align="right" >Email nhận thông báo</td>
	            <td align="left"><input required="" style="width: 300px;" type="text" value="<?php echo @$data['Service']['notification'];?>" name="notification" id="notification" /></td>
	          </tr>
			  <tr>
	            <td align="right" >Điện thoại</td>
	            <td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Service']['phone'];?>" name="phone" id="phone" /></td>
	          </tr>
			  <tr>
	            <td align="right" >Địa chỉ</td>
	            <td align="left"><input style="width: 300px;" type="text" value="<?php echo @$data['Service']['address'];?>" name="address" id="address" /></td>
	          </tr>
			  
			  <tr>
	            <td colspan="2">
		            <input type="submit" value="Lưu dịch vụ" />
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