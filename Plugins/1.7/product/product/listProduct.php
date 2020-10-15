<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">
<?php
	global $languageProduct;

	$breadcrumb= array( 'name'=>$languageProduct['ProductList'],
						'url'=>$urlPlugins.'admin/product-product-listProduct.php',
						'sub'=>array('name'=>$languageProduct['AllData'])
					  );
	addBreadcrumbAdmin($breadcrumb);
	
	function listCat($cat,$sau,$parent,$categorySelect)
	{
		if($cat['id']>0)
		{
			if($cat['id']!=$categorySelect)
			{
				echo '<option id="'.$parent.'" value="'.$cat['id'].'">';
			}
			else
			{
				echo '<option selected="" id="'.$parent.'" value="'.$cat['id'].'">';
			}
			
			for($i=1;$i<=$sau;$i++)
			{
				echo '&nbsp&nbsp&nbsp&nbsp';
			}
			echo $cat['name'].'</option>';
		}
		foreach($cat['sub'] as $sub)
		{
			listCat($sub,$sau+1,$cat['id']);
		}
	}
?> 

<div class="clear"></div>
<div class="thanhcongcu">

    <div class="congcu">

        <a href="<?php echo $urlPlugins;?>admin/product-product-addProduct.php">

          <span>

            <img src="<?php echo $webRoot;?>images/add.png">

          </span>

            <br>

            <?php echo $languageProduct['Add'];?>

        </a>

    </div>
</div>
<br/>
<div id="content" class="clear">
<center>
<form action="" method="get">
	<table width="100%" cellspacing="0" class="tableList">
		<tr>
			<td>
				<input name="title" value="<?php echo (isset($_GET['title']))?$_GET['title']:'';?>" placeholder="<?php echo $languageProduct['ProductName'];?>" style="float:left;margin-right: 5px;"/>
			</td>
			<td>
				<select style="float:left;margin-right: 5px;" name="category">
					<option value=""><?php echo $languageProduct['ProductCategory'];?></option>
					<?php
						if(!empty($listCatNew)){
							foreach ($listCatNew as $cat) {
								if(!isset($_GET['category']) || $cat['id']!=$_GET['category'])
								{
									echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
								}
								else
								{
									echo '<option selected="" value="'.$cat['id'].'">'.$cat['name'].'</option>';
								}
							}
						}
					?>
				</select> 
			</td>
			<td>
				<select name="bestsellers" style="float:left;margin-right: 5px;">
					<option value=""><?php echo $languageProduct['Bestsellers'];?></option>
					<option value="yes" <?php if(isset($_GET['bestsellers']) && $_GET['bestsellers']=='yes') echo 'selected=""';?> ><?php echo $languageProduct['Yes'];?></option>
					<option value="no" <?php if(isset($_GET['bestsellers']) && $_GET['bestsellers']=='no') echo 'selected=""';?> ><?php echo $languageProduct['No'];?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<input name="code" value="<?php echo (isset($_GET['code']))?$_GET['code']:'';?>" placeholder="<?php echo $languageProduct['CodeProduct'];?>" style="float:left;margin-right: 5px;"/> 
			</td>
			<td>
				<select style="float:left;margin-right: 5px;" name="manufacturer">
					<option value=""><?php echo $languageProduct['Manufacturer'];?></option>
					<?php
						if(!empty($listManufacturerNew)){
							foreach ($listManufacturerNew as $cat) {
								if(!isset($_GET['manufacturer']) || $cat['id']!=$_GET['manufacturer'])
								{
									echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
								}
								else
								{
									echo '<option selected="" value="'.$cat['id'].'">'.$cat['name'].'</option>';
								}
							}
						}
					?>
				</select> 
			</td>
			<td>
				<input name="priceFrom" value="<?php echo $priceFrom;?>" placeholder="<?php echo $languageProduct['Saleprice'].$languageProduct['From'];?>" style="margin-right: 5px;"/> 
				- 
				<input name="priceTo" value="<?php echo $priceTo;?>" placeholder="<?php echo $languageProduct['Saleprice'].$languageProduct['To'];?>" style="margin-left: 5px;"/> 
			</td>
		</tr>
		<tr>
			<td colspan="3" align="center">
				<input class="input" type="submit" value="<?php echo $languageProduct['Search'];?>">
			</td>
		</tr>
	</table>
</form>
</center>
<br/>
<form action="" method="post" name="duan" class="taovienLimit">

    <table id="listTin" cellspacing="0" class="tableList">
    	<input type="hidden" value="saveProducts" name="saveProducts" >
        <tr>
	        <th align="center" width="50"><?php echo $languageProduct['Image'];?></th>
            <th align="center" width="200"><?php echo $languageProduct['ProductName'];?></th>
            <!-- <th align="center"><?php echo $languageProduct['CodeProduct'];?></th> -->
            <th align="center"><?php echo $languageProduct['Saleprice'];?></th>
            <th align="center"><?php echo $languageProduct['ProductCategory'];?></th>
            <!-- <th align="center"><?php echo $languageProduct['Quantity'];?></th> -->
            <th align="center"><?php echo $languageProduct['View'];?></th>
            <th align="center"><?php echo $languageProduct['Status'];?></th>
            <th align="center" width="50"><?php echo $languageProduct['Priority'];?></th>
            <th align="center" width="160"><?php echo $languageProduct['Choose'];?></th>
        </tr>

        <?php
            $confirm= $languageProduct['AreYouSureYouWantToRemove'];
            $lock= array(0=>$languageProduct['Active'],
            			 1=>$languageProduct['Deactivate']);

            foreach($listData as $tin)
            {
            
            	$tin['Product']['lock']= (isset($tin['Product']['lock']))? (int)$tin['Product']['lock']:0;
	            
	            $listCatNoti= array();

	            if(isset($tin['Product']['category']) && count($tin['Product']['category'])>0){
		            foreach($tin['Product']['category'] as $catNoti)
	            	{   
	            		if(isset($listCatNew[$catNoti]['name'])){
		                	array_push($listCatNoti, $listCatNew[$catNoti]['name']);
		            	}
	                }
            	}

            	if(!isset($tin['Product']['images'][0]))
	            {
	                $imgThumb= $urlHomes.'/app/Plugin/product/images/no_image-100x100.jpg';
	            }else{
	            	$imgThumb= $tin['Product']['images'][0];
	            }

	            $view= (isset($tin['Product']['view']))? (int)$tin['Product']['view']:0;
	            $selected0 ='';
	            $selected1 = '';
	            if($tin['Product']['lock'] == 0){
	            	$selected0 = "selected";
	            }else{
	            	$selected1= "selected";
	            }
                echo '<tr>
                		  <td><img src="'.$imgThumb.'" width="50" /></td>
                          <td><a target="_blank" href="'.getLinkProduct().$tin['Product']['slug'].'.html">'.$tin['Product']['title'].'</a></td>
                    
                         	<td><input name="price_'.$tin['Product']['id'].'" value="'.@$tin['Product']['price'].'" style="width:80px" /></td>
                          <td>'.implode(", ", $listCatNoti).'</td>
                         <td>'.$view.'</td>
                           <td>
	                          <select name="lock_'.$tin['Product']['id'].'">
	                          		<option '.$selected0.' value="0">Kích hoạt</option>
	                          		<option '.$selected1.' value="1">Khóa</option>
	                          </select>
                          </td>
                          <td><input name="priority_'.$tin['Product']['id'].'" value="'.@$tin['Product']['priority'].'" style="width:50px" /></td>
                          <td align="center">
								<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/product-product-addProduct.php/'.$tin['Product']['id'].'" class="input"  >'.$languageProduct['Edit'].'</a>  
								<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/product-deleteProduct.php/'.$tin['Product']['id'].'" class="input" onclick="return confirm('."'".$confirm."'".');"  >'.$languageProduct['Delete'].'</a>
						  </td>

                        </tr>';
            }

        ?>
        <tr>
        	<td colspan="10" align="center">
        		<input type="submit" value="<?php echo $languageProduct['Save'].' '.$languageProduct['Products'];?>" />
        	</td>
        </tr>

    </table>
	<p>
	    <?php
	    	if($page>5){
				$startPage= $page-5;
			}else{
				$startPage= 1;
			}

			if($totalPage>$page+5){
				$endPage= $page+5;
			}else{
				$endPage= $totalPage;
			}
			
			echo '<a href="'.$urlPage.$back.'">'.$languageProduct['PreviousPage'].'</a> ';
			for($i=$startPage;$i<=$endPage;$i++){
				echo ' <a href="'.$urlPage.$i.'">'.$i.'</a> ';
			}
			echo ' <a href="'.$urlPage.$next.'">'.$languageProduct['NextPage'].'</a> ';

			echo $languageProduct['TotalPage'].': '.$totalPage;
	    ?>
	</p>
</form>





</div>