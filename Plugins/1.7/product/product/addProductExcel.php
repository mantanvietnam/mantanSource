<?php
	global $languageProduct;
?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>

<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">

<?php
	$breadcrumb= array( 'name'=>$languageProduct['ProductList'],
						'url'=>$urlPlugins.'admin/product-product-listProduct.php',
						'sub'=>array('name'=>$languageProduct['AddProduct'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 
  
    <script type="text/javascript">
	
	    function saveData()
	    {
	        var tieude= document.getElementById("data").value;
	        
	        if(tieude == '')
	        {
		        alert('<?php echo $languageProduct['YouMustFillOutTheInformationBelow'];?>');
	        }
	        else
	        {
	
	            document.dangtin.submit();
	
	        }
	
	    }
		
	</script>
	
	
	<div class="thanhcongcu">
	    <div class="congcu" onclick="saveData();">
	        <input type="hidden" id="idChange" value="" />
	        <span id="save">
	          <input type="image" src="<?php echo $webRoot;?>images/save.png" />
	        </span>
	        <br/>
	        <?php echo $languageProduct['Save'];?>
	    </div>
	
	</div>
	
	<div class="clear"></div>
	
	<div id="content">
	
	<form action="" method="post" name="dangtin" enctype="multipart/form-data">
	    <p>Download file excel: <a href="/app/Plugin/product/product.xlsx">/app/Plugin/product/product.xlsx</a></p>
	    <div id="tabs">
			<ul>
				<li><a href="#tabs-1"><?php echo $languageProduct['ProductDescription'];?></a></li>
				
				
			</ul>
			<!-- Product Description -->
			
			<div id="tabs-1">
				<table width="100%">
					<tr>
						<td valign="top">
							<p style="clear: both;">Tên sản phẩm | Mã sản phẩm | Mô tả ngắn | ID danh mục | Giá bán | Giá thị trường | Số lượng | Bảo hành | Khối lượng | Link ảnh 1 | Link ảnh 2 | Link ảnh 3 | Link ảnh 4</p>
							<textarea class="form-control"  name="dataExcel"  id="data" cols="59" rows="10"></textarea>
						</td>
					</tr>
				</table>
			</div>
			
			
		</div>
	</form>
</div>
