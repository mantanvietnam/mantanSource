<link href="<?php echo $urlHomes.'app/Plugin/bizman/style.css';?>" rel="stylesheet">

<?php
	$breadcrumb= array( 'name'=>'Bizman Product',
						'url'=>$urlPlugins.'admin/bizman-sync-syncSetting.php',
						'sub'=>array('name'=>'Danh sách kho')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  

<div id="content" class="clear">
	<form action="" method="post" name="duan" class="taovienLimit">
	    <table id="listTin" cellspacing="0" class="tableList">
	        <tr>
	            <th align="center">Id kho hàng</th>
	            <th align="center">Tên kho hàng</th>
	            <th align="center">Mã code</th>
	            <th align="center">Địa chỉ</th>
	            <th align="center">Trạng thái</th>
	            <th align="center">Mã Chi nhánh</th>
	            <th align="center">Chú thích</th>
	            <th align="center">Kho lấy giá</th>
	            <th align="center">Kho lấy khuyến mại</th>
	            <th align="center">Sản phẩm</th>
	        </tr>
	        
	        <?php
	            foreach($listStore as $tin)
	            {
	            	if($tin['storeVisible']==1){
	            		$storeVisible= 'Active';
	            	}else{
	            		$storeVisible= 'Deactivate';
	            	}

                    echo '<tr>
                              <td>'.$tin['storeId'].'</td>
                              <td>'.$tin['storeName'].'</td>
                              <td>'.$tin['storeCode'].'</td>
                              <td>'.$tin['storeAdress'].'</td>
                              <td>'.$storeVisible.'</td>
                              <td>'.$tin['storeSrid'].'</td>
                              <td>'.$tin['storeNote'].'</td>
                              <td>';
                              if(!isset($settingProduct['Option']['value']['storeDefault']) || $settingProduct['Option']['value']['storeDefault']!=$tin['storeId'])
                              {
	                              echo '<a href="'.$urlPlugins.'admin/bizman-saveStore.php?id='.$tin['storeId'].'">Kích hoạt</a>';
                              }
                              else
                              {
                              	  echo 'Mặc định';
                              }
                     echo      '</td><td>';
                     		  if(!isset($settingProduct['Option']['value']['storeDiscount']) || $settingProduct['Option']['value']['storeDiscount']!=$tin['storeId'])
                              {
	                              echo '<a href="'.$urlPlugins.'admin/bizman-saveStoreDiscount.php?id='.$tin['storeId'].'">Kích hoạt</a>';
                              }
                              else
                              {
                              	  echo 'Mặc định';
                              }

                     echo      '</td><td align="center">
								<input class="input" type="button" value="Tìm sản phẩm" onclick="showBoxSearch('."'".$tin['storeId']."'".');" />  
							  </td>
                          </tr>';
	            }
	
	        ?>
	        <tr>
		        <td colspan="10" align="right">
			        <input class="input" type="button" value="Tìm cả hệ thống" onclick="showBoxSearch();" />
		        </td>
	        </tr>
	    </table>
	</form>
</div>

<div id="themData">
	<p>Mã kho hàng: <span id="storeId"></span></p>
	<p>Mã sản phẩm: <input type="text" value="" id="productCode" /></p>
	<input class="input" type="button" value="Tìm kiếm" onclick="searchProductStore();" />  
</div>

<div id="editData"></div>

<script type="text/javascript">
	var storeIdCheck;
	function showBoxSearch(storeId)
	{
		storeIdCheck= storeId;
		if(!storeId) storeId="Tất cả các kho";
		document.getElementById("storeId").innerHTML = storeId;
		document.getElementById("productCode").value= '';
		
		$('#themData').lightbox_me({
	    centered: true, 
	    onLoad: function() { 
	        $('#themData').find('input:first').focus()
	        }
	    });
	}
	
	function searchProductStore()
	{
		var productCode= document.getElementById("productCode").value;
		$.ajax({
		      type: "POST",
		      url: '<?php echo $urlPlugins."admin/bizman-store-checkProductStore.php?layout=default";?>',
		      data: { storeIdCheck:storeIdCheck,productCode:productCode}
		    }).done(function( msg ) { 	
		    		document.getElementById("editData").innerHTML = msg;
			  		$('#themData').trigger('close');
			  		
			  		$('#editData').lightbox_me({
											    centered: true, 
											    onLoad: function() { 
											        $('#themData').find('input:first').focus()
											        }
											    });
			 })
			 .fail(function() {
					alert('Truy vấn thất bại');
				}); 
	}
</script>