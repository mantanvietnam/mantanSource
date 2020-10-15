<option value="">Chọn hàng hóa</option>
<?php 
    if(!empty($dataMerchandise)){
        foreach ($dataMerchandise as $merchandiseGroup) { 
            echo '<option data-price="'.$merchandiseGroup['Merchandise']['price'].'"  value="'.$merchandiseGroup['Merchandise']['id'].'">'.$merchandiseGroup['Merchandise']['name'].'</option>';
        }
    }
?>