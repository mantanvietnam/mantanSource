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
	$breadcrumb= array( 'name'=>'Danh sách khách hàng',
						'url'=>$urlPlugins.'admin/managerHost-admin-list_user.php',
						'sub'=>array('name'=>'Thông tin khách hàng')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
  
	<div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
		<font color='red'><?php echo $messSave;?></font>
	</div>
	
	  <div class="taovien">
	    <form action="" method="post" name="listForm">
	    	<input type="hidden" value="<?php echo @$data['User']['id'];?>" name="id" />
	        <table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
			  <tr>
	            <td align="right" >Trạng thái</td>
	            <td align="left">
					<select name="status">
						<option <?php if(isset($data['User']['status']) && $data['User']['status']=='1') echo 'selected'; ?> value="active">Kích hoạt</option>
						<option <?php if(isset($data['User']['status']) && $data['User']['status']=='0') echo 'selected'; ?> value="lock">Khóa</option>
					</select>
				</td>
	          </tr>
			  
	          <tr>
	            <td align="right" width="200" >Email</td>
	            <td align="left">
					<input style="width: 300px;"  disabled value="<?php echo @$data['User']['email'];?>" autocomplete="off" type="email" name="email" id="email" />
				</td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Họ tên</td>
	            <td align="left">
					<input style="width: 300px;" value="<?php echo @$data['User']['name'];?>" autocomplete="off" required type="text" name="name" id="name" />
				</td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Điện thoại</td>
	            <td align="left">
					<input style="width: 300px;" value="<?php echo @$data['User']['phone'];?>" autocomplete="off" type="text" name="phone" id="phone" />
				</td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Địa chỉ</td>
	            <td align="left">
					<input style="width: 300px;" value="<?php echo @$data['User']['address'];?>" autocomplete="off" type="text" name="address" id="address" />
				</td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Số CMND</td>
	            <td align="left">
					<input style="width: 300px;" value="<?php echo @$data['User']['numberCMT'];?>" autocomplete="off" type="text" name="numberCMT" id="numberCMT" />
				</td>
	          </tr>
			  
			  <tr>
	            <td align="right" >Ngày cấp</td>
	            <td align="left">
					<input style="width: 300px;" value="<?php echo @$data['User']['dateCMT'];?>" autocomplete="off" type="text" name="dateCMT" id="dateCMT" />
				</td>
	          </tr>
			  
			  <tr>
	            <td align="right" >Nơi cấp</td>
	            <td align="left">
					<input style="width: 300px;" value="<?php echo @$data['User']['addressCMT'];?>" autocomplete="off" type="text" name="addressCMT" id="addressCMT" />
				</td>
	          </tr>
			  
			  <tr>
	            <td align="right" >Số dư tài khoản</td>
	            <td align="left">
					<input style="width: 300px;" value="<?php echo @$data['User']['coin'];?>" autocomplete="off" type="number" name="coin" id="coin" />
				</td>
	          </tr>
			  
			  <tr>
	            <td align="right" >Hoa hồng (1=100%)</td>
	            <td align="left">
					<input style="width: 300px;" value="<?php echo @$data['User']['percent'];?>" autocomplete="off" type="text" name="percent" id="percent" />
				</td>
	          </tr>
			  
			  <tr>
	            <td align="right" >Mật khẩu</td>
	            <td align="left">
					<input style="width: 300px;" value="" autocomplete="off" type="text" name="pass" id="pass" />
				</td>
	          </tr>
			  
	          <tr>
	            <td colspan="2">
		            <input type="submit" value="Lưu thông tin" />
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