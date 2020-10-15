<option value="">Chọn nguyên liệu</option>
<?php 
    if(!empty($dataMaterials)){
        foreach ($dataMaterials as $MaterialsGroup) { 
            echo '<option data-price="'.$MaterialsGroup['Materials']['price'].'"  value="'.$MaterialsGroup['Materials']['id'].'">'.$MaterialsGroup['Materials']['name'].'</option>';
        }
    }
?>