<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">
  
<?php global $languageProduct;?>
<div id="content">
	<form action="<?php echo $urlPlugins;?>admin/product-order-saveOrderProduct_updateOrder.php" method="post" name="dangtin" enctype="multipart/form-data">
	    
	    <div id="tabs">
			<div id="tabs-1">
				<table  cellpadding="10" cellspacing="5" width="100%">
					<tr>
						<td valign="top">
							<p><b><?php echo $languageProduct['FullName'];?></b></p>
							<input type="text" id="fullname" name="fullname" placeholder="<?php echo $languageProduct['FullName'];?>" value="<?php echo $news['Order']['fullname'];?>" style="width: 100%;"/>
						</td>
						<td valign="top">
							<p><b><?php echo $languageProduct['Email'];?></b></p>
							<input type="text" id="email" name="email" placeholder="<?php echo $languageProduct['Email'];?>" value="<?php echo $news['Order']['email'];?>" style="width: 100%;"/>
						</td>
					</tr>
					<tr>
						<td valign="top">	
							<p><b><?php echo $languageProduct['Phone'];?></b></p>
							<input type="text" id="phone" name="phone" placeholder="<?php echo $languageProduct['Phone'];?>" value="<?php echo $news['Order']['phone'];?>" style="width: 100%;"/>
						</td>
						<td valign="top">
							<p><b><?php echo $languageProduct['Address'];?></b></p>
							<input type="text" id="address" name="address" placeholder="<?php echo $languageProduct['Address'];?>" value="<?php echo $news['Order']['address'];?>" style="width: 100%;"/>	
						</td>
					</tr>
					<tr>
						<td valign="top" colspan="2">	
							<p><b><?php echo $languageProduct['Note'];?></b></p>
							<textarea name="note" placeholder="<?php echo $languageProduct['Note'];?>" style="width: 100%;" rows="5"><?php echo $news['Order']['note'];?></textarea>					
						</td>
					</tr>
				</table>
			</div>
			<div id="tabs-2">
				<div class="taovienLimit" style="width: 100%;float: none;">
					<table cellspacing="0" class="tableList" width="100%">
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