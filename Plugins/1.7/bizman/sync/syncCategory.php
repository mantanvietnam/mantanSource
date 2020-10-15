<link href="<?php echo $urlHomes.'app/Plugin/bizman/style.css';?>" rel="stylesheet">
<?php
	$breadcrumb= array( 'name'=>'Bizman Product',
						'url'=>$urlPlugins.'admin/bizman-sync-syncSetting.php',
						'sub'=>array('name'=>'Đồng bộ danh mục sản phẩm')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
	
<div class="taovien clear">
	  <p class="textRed"><?php echo $mess;?></p>
    <form action="" method="post" name="listForm">
        <p>Các thuộc tính được đồng bộ:</p>
        <ul class="listComponents">
          <li>
            <input type="checkbox" value="name" name="infoSync[]" <?php if($infoSync==null || in_array('name', $infoSync)) echo 'checked';?> /> Tên danh mục
          </li>
          <li>
            <input type="checkbox" value="alias" name="infoSync[]" <?php if($infoSync==null || in_array('alias', $infoSync)) echo 'checked';?> /> Tên gọi khác (Alias)
          </li>
          <li>
            <input type="checkbox" value="descripton" name="infoSync[]" <?php if($infoSync==null || in_array('descripton', $infoSync)) echo 'checked';?> /> Mô tả
          </li>
          <li>
            <input type="checkbox" value="note" name="infoSync[]" <?php if($infoSync==null || in_array('note', $infoSync)) echo 'checked';?> /> Ghi chú
          </li>
        </ul>

        <div class="clear"></div>
        <br/><br/>
        <input type="submit" value="Đồng bộ danh mục" />
    </form>
</div>
