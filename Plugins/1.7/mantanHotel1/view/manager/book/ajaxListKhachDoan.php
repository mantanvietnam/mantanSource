<?php
	
	echo '	<label class="col-sm-4 control-label">Chọn đoàn: <span class="required"></span></label>
            <div class="col-sm-8">                                    
                <select id="idRoomDoan" name="idRoomDoan" class="form-control" onchange="checkSelectDoan(this.value);">
                    <option value="new">Tạo đoàn mới</option>';
                    if(!empty($listTruongDoan)){
	                    foreach ($listTruongDoan as $key => $data) {
	                    	echo '<option value="'.$data['idRoom'].'-'.$data['color'].'" >'.$data['cus_name'].'</option>';
	                    }
                    }
    echo        '</select>
            </div>
            ';
	
?>