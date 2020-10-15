<link href="<?php echo $urlHomes.'app/Plugin/bizman/style.css';?>" rel="stylesheet">
<?php
	$breadcrumb= array( 'name'=>'Bizman Product',
						'url'=>$urlPlugins.'admin/bizman-sync-syncSetting.php',
						'sub'=>array('name'=>'Đồng bộ sản phẩm')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
	
<div class="taovien clear">
	  <p class="textRed"><?php echo $mess;?></p>
    <form action="" method="post" name="listForm">
        <p>Các thuộc tính được đồng bộ:</p>
        <ul class="listComponents">
          <li>
            <input type="checkbox" value="title" name="infoSync[]" <?php if($infoSync==null || in_array('title', $infoSync)) echo 'checked';?> /> Tên sản phẩm
          </li>
          <li>
            <input type="checkbox" value="lock" name="infoSync[]" <?php if($infoSync==null || in_array('lock', $infoSync)) echo 'checked';?> /> Trạng thái (Khóa/Mở)
          </li>
          <li>
            <input type="checkbox" value="price" name="infoSync[]" <?php if($infoSync==null || in_array('price', $infoSync)) echo 'checked';?> /> Giá bán
          </li>
          <li>
            <input type="checkbox" value="alias" name="infoSync[]" <?php if($infoSync==null || in_array('alias', $infoSync)) echo 'checked';?> /> Tên gọi khác (Alias)
          </li>
          <li>
            <input type="checkbox" value="description" name="infoSync[]" <?php if($infoSync==null || in_array('description', $infoSync)) echo 'checked';?> /> Mô tả ngắn
          </li>
          <li>
            <input type="checkbox" value="info" name="infoSync[]" <?php if($infoSync==null || in_array('info', $infoSync)) echo 'checked';?> /> Ghi chú chi tiết
          </li>
          <li>
            <input type="checkbox" value="quantity" name="infoSync[]" <?php if($infoSync==null || in_array('quantity', $infoSync)) echo 'checked';?> /> Số lượng trong kho
          </li>
          <li>
            <input type="checkbox" value="category" name="infoSync[]" <?php if($infoSync==null || in_array('category', $infoSync)) echo 'checked';?> /> Nhóm danh mục sản phẩm
          </li>
          <li>
            <input type="checkbox" value="code" name="infoSync[]" <?php if($infoSync==null || in_array('code', $infoSync)) echo 'checked';?> /> Mã sản phẩm
          </li>
        </ul>

        <div class="clear"></div>
        <br/><br/>
        <input type="submit" value="Đồng bộ sản phẩm" />
    </form>
</div>
