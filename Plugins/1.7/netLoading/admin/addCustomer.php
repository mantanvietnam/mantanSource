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
						'url'=>$urlPlugins.'admin/netLoading-admin-listCustomer.php',
						'sub'=>array('name'=>'Thông tin khách hàng')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
  
	<div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
		<font color='red'><?php echo @$mess;?></font>
	</div>
	
	  <div class="taovien">
	    <form action="" method="post" name="listForm">
	    	<input type="hidden" value="<?php echo @$data['Customer']['id'];?>" name="id" />
	        <table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
			  <tr>
	            <td align="right" >Trạng thái</td>
	            <td align="left">
					<select name="status">
						<option <?php if(isset($data['Customer']['status']) && $data['Customer']['status']=='active') echo 'selected'; ?> value="active">Kích hoạt</option>
						<option <?php if(isset($data['Customer']['status']) && $data['Customer']['status']=='lock') echo 'selected'; ?> value="lock">Khóa</option>
					</select>
				</td>
	          </tr>
			  <tr>
	            <td align="right" >Loại tài khoản</td>
	            <td align="left">
					<select name="chuxe">
						<option <?php if(isset($data['Customer']['chuxe']) && $data['Customer']['chuxe']==false) echo 'selected'; ?> value="0">Chủ hàng</option>
						<option <?php if(isset($data['Customer']['chuxe']) && $data['Customer']['chuxe']==true) echo 'selected'; ?> value="1">Chủ xe</option>
					</select>
				</td>
	          </tr>
	          
	          
	          <tr>
	            <td align="right" >Họ tên (*)</td>
	            <td align="left">
					<input style="width: 300px;" value="<?php echo @$data['Customer']['fullName'];?>" autocomplete="off" required type="text" name="fullName" id="fullName" />
				</td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Điện thoại</td>
	            <td align="left">
					<input style="width: 300px;" disabled value="<?php echo @$data['Customer']['fone'];?>" autocomplete="off" type="text" name="fone" id="fone" />
				</td>
	          </tr>
	          <tr>
	            <td align="right" width="200" >Email (*)</td>
	            <td align="left">
					<input style="width: 300px;" required value="<?php echo @$data['Customer']['email'];?>" autocomplete="off" type="email" name="email" id="email" />
				</td>
	          </tr>
	          <tr>
	            <td align="right" width="200" >Số dư tài khoản</td>
	            <td align="left">
					<?php echo @number_format($data['Customer']['email']);?>đ
				</td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Địa chỉ (*)</td>
	            <td align="left">
					<input style="width: 300px;" required value="<?php echo @$data['Customer']['company']['address'];?>" autocomplete="off" type="text" name="addressCompany" id="addressCompany" />
				</td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Tên hãng xe</td>
	            <td align="left">
					<input style="width: 300px;" value="<?php echo @$data['Customer']['company']['name'];?>" autocomplete="off" type="text" name="nameCompany" id="nameCompany" />
				</td>
	          </tr>
			  
			  <tr>
	            <td align="right" >Mã số thuế</td>
	            <td align="left">
					<input style="width: 300px;" value="<?php echo @$data['Customer']['company']['tax'];?>" autocomplete="off" type="text" name="taxCompany" id="taxCompany" />
				</td>
	          </tr>
			  
			  <tr>
	            <td align="right" >Tọa độ GPS (*)</td>
	            <td align="left">
					<input style="width: 300px;" required value="<?php echo @$data['Customer']['company']['gps'];?>" autocomplete="off" type="text" name="gpsCompany" id="gpsCompany" />
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
	  
	  