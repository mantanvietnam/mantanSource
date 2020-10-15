<input name="idUser" type="hidden" value="<?php echo @$data['Custom']['id']; ?>" />
<div class="form-group">
	<label class="col-sm-4 control-label">Tên khách hàng: <span class="required">*</span></label>
	<div class="col-sm-8">                                    
		<input type="text" name="cus_name" class="form-control" value="<?php echo @$data['Custom']['cus_name'];?>" required />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Địa chỉ:<span class="required">*</span></label>
	<div class="col-sm-8">
		<input type="text" name="cus_address"  class="form-control" value="<?php echo @$data['Custom']['address'];?>" required/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Điện thoại:</label>
	<div class="col-sm-8">
		<input type="text" name="phone" class="form-control" value="<?php echo @$data['Custom']['phone'];?>"  />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Email:</label>
	<div class="col-sm-8">
		<input type="text" name="email" class="form-control" value="<?php echo @$data['Custom']['email'];?>"  />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Quốc tịch:<span class="required">*</span></label>
	<div class="col-sm-8">
		<select id="company" name="nationality" class="form-control">
			<option value="0" <?php if(isset($data['Custom']['nationality']) && $data['Custom']['nationality']==0) echo 'selected';?>>Việt Nam</option>
			<option value="1" <?php if(isset($data['Custom']['nationality']) && $data['Custom']['nationality']==1) echo 'selected';?>>Khác</option>
		</select>
		<label class="error" for="room"></label>
	</div>
</div>