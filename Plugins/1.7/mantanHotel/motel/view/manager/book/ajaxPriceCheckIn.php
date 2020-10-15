<div class="form-group">
    <label class="col-md-4 control-label">Giá phòng: <span class="required">*</span></label>
    <div class="col-md-8" id="ajaxPrice">
        <input type="number" name="price" id="price" class="form-control" value="<?php echo $data;?>" required="required">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4 control-label">Tính giá theo ngày: <span class="required">*</span></label>
    <div class="col-sm-8">
        <select id="typeDate" class="form-control" name="typeDate" required >
            <?php
                global $typeDate;
                foreach($typeDate as $key=>$value){
                    if($typeDateCheck!=$key){
                        echo '<option value="'.$key.'">'.$value.'</option>';
                    }else{
                        echo '<option selected value="'.$key.'">'.$value.'</option>';
                    }
                }
            ?>
        </select>
    </div>
</div>
<div class="form-group" style="margin-bottom: 15px;">
    <label class="col-md-4 control-label">Khuyến mại:</label>
    <div class="col-md-8">
        <input type="number" name="promotion" value="<?php echo $promotion;?>" class="form-control" />
        <p>Giá trị khuyến mại nhỏ hơn 100 thì hiểu là giảm theo phần trăm</p>
    </div>
</div>