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
    <label class="col-sm-4 control-label">Ngày sinh:</label>
    <div class="col-sm-8">
        <input type="text" name="birthday" id="birthday" value="<?php echo @$data['Custom']['birthday'];?>" data-plugin-datepicker class="form-control" />
    </div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Quốc tịch:<span class="required">*</span></label>
	<div class="col-sm-8">
		<select id="" name="nationality" class="form-control">
			<?php
                $listCountry= getListCountry();
                foreach($listCountry as $country){
                    if(empty($data['Custom']['nationality']) || $country['id']!=$data['Custom']['nationality']){
                        echo '<option value="'.$country['id'].'" >'.$country['name'].'</option>';
                    }else{
                        echo '<option selected value="'.$country['id'].'" >'.$country['name'].'</option>';
                    }
                }
            ?>
		</select>
		<label class="error" for="room"></label>
	</div>
</div>