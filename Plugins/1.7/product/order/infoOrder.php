<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>
<script type="text/javascript">
    function saveData()
    {
        document.dangtin.submit();

    }
</script>

<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">

<?php
	global $languageProduct;

	$breadcrumb= array( 'name'=>$languageProduct['Orders'],
						'url'=>$urlPlugins.'admin/product-order-listOrder.php',
						'sub'=>array('name'=>$languageProduct['OrderInformation'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 
  
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
	<form action="<?php echo $urlPlugins;?>admin/product-order-saveOrderProduct_updateOrder.php" method="post" name="dangtin" enctype="multipart/form-data">
		<?php
			if(isset($_GET['status'])){
				switch($_GET['status'])
				{
					case 1: echo '<p style="color:red;">'.$languageProduct['SaveSuccessful'].'</p>';break;
				}
			}
		?>
	    <input type="hidden" value="<?php echo $news['Order']['id'];?>" name="id" />
	    
	    <div id="tabs">
			<ul>
				<li><a href="#tabs-1"><?php echo $languageProduct['CustomerInformation'];?></a></li>
				<li><a href="#tabs-2"><?php echo $languageProduct['ProductList'];?></a></li>
			</ul>
			<div id="tabs-1">
				<table  cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top">
							<p><b><?php echo $languageProduct['OrderStatus'];?></b></p>
							<input type="radio" name="lock" value="0" <?php if($news['Order']['lock']==0) echo 'checked=""';?> /> <?php echo $languageProduct['StatusNew'];?> 
							<input type="radio" name="lock" value="2" <?php if($news['Order']['lock']==2) echo 'checked=""';?> /> <?php echo $languageProduct['StatusProcess'];?> 
							<input type="radio" name="lock" value="1" <?php if($news['Order']['lock']==1) echo 'checked=""';?> /> <?php echo $languageProduct['StatusDone'];?> 
							<input type="radio" name="lock" value="3" <?php if($news['Order']['lock']==3) echo 'checked=""';?> /> <?php echo $languageProduct['StatusCancel'];?> 
							
							<p><b><?php echo $languageProduct['FullName'];?></b></p>
							<input type="text" id="fullname" name="fullname" placeholder="<?php echo $languageProduct['FullName'];?>" value="<?php echo $news['Order']['fullname'];?>" style="width: 500px;"/>
							
							<p><b><?php echo $languageProduct['Email'];?></b></p>
							<input type="text" id="email" name="email" placeholder="<?php echo $languageProduct['Email'];?>" value="<?php echo $news['Order']['email'];?>" style="width: 500px;"/>
							
							<p><b><?php echo $languageProduct['Phone'];?></b></p>
							<input type="text" id="phone" name="phone" placeholder="<?php echo $languageProduct['Phone'];?>" value="<?php echo $news['Order']['phone'];?>" style="width: 500px;"/>
							
							<p><b><?php echo $languageProduct['Address'];?></b></p>
							<input type="text" id="address" name="address" placeholder="<?php echo $languageProduct['Address'];?>" value="<?php echo $news['Order']['address'];?>" style="width: 500px;"/>	
							
							<p><b><?php echo $languageProduct['Note'];?></b></p>
							<textarea name="note" placeholder="<?php echo $languageProduct['Note'];?>" cols="80" rows="5"><?php echo $news['Order']['note'];?></textarea>					
						</td>
					</tr>
				</table>
			</div>
			<div id="tabs-2">
				<div class="taovienLimit" style="width: 100%;float: none;">
					<table cellspacing="0" class="tableList">
						<thead>
							<tr>
								<td><?php echo $languageProduct['Number'];?></td>
								<td><?php echo $languageProduct['Image'];?></td>
								<td><?php echo $languageProduct['ProductName'];?></td>
								<td><?php echo $languageProduct['Quantity'];?></td>
								<td><?php echo $languageProduct['Mass'];?> (kg)</td>
								<td><?php echo $languageProduct['Saleprice'];?></td>
								<td><?php echo $languageProduct['CodeDiscount'];?></td>
							</tr>
						</thead>
						<tbody>
							<?php
								$number= 0;
								
								foreach($news['Order']['listProduct'] as $product)
								{
									$number++;
									echo '<tr>
												<td>'.$number.'</td>
												<td>
													<a href="'.$product['images'][0].'" class="nivo-lightbox cart-thumbnail"><img class="img-responsive" width="200" src="'.$product['images'][0].'" alt=""></a>
												</td>
												<td>'.$product['title'].'</td>
												<td>'.$product['number'].'</td>
												<td>'.number_format($product['mass'],2).'</td>
												<td>'.number_format($product['price']).' '.@$listTypeMoney['Option']['value']['allData'][$product['typeMoneyId']]['name'].'</td>
												
												<td>'.$product['codeDiscount'].'</td>
											</tr>';
								}
							?>
							<tr>
								<td colspan="3"></td>
								<td align="right"><b><?php echo $languageProduct['TotalAmount'];?></b></td>
								<td><?php echo number_format($news['Order']['totalMass'],2);?></td>
								<td align="left" colspan="2">
									 <?php 
									 	echo '- '.$languageProduct['Saleprice'].': '.number_format($news['Order']['totalMoney']).' '.@$listTypeMoney['Option']['value']['allData'][$product['typeMoneyId']]['name'].'
									 		 <br/>
									 		 - '.$languageProduct['TransportFee'].': '.number_format($news['Order']['transportFee']).' '.@$listTypeMoney['Option']['value']['allData'][$product['typeMoneyId']]['name']
									 	;
									 ?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</form>
</div>	