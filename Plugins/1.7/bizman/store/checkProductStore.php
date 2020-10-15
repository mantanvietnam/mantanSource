<?php
	if(isset($_POST['storeIdCheck']))
	{	
		foreach($listProductStore as $product)
		{
			if($product['productInfo']) 
			{
				foreach($product['productInfo'] as $productInfo)
				{
					echo 'Sản phẩm <b>'.$productInfo['productCode'].'</b>: số lượng <b>'.$productInfo['totalStock'].'</b> kho '.$productInfo['storeId'];
				}
			}
			else echo 'Không tồn tại sản phẩm <b>'.$product['productCode'].'</b> trong kho';
		}
	}
	else
	{
		if($listProductStore)
		{
			foreach($listProductStore as $product)
			{
				echo 'Sản phẩm <b>'.$product['productCode'].'</b>: số lượng <b>'.$product['totalStock'].'</b>';
			}
		}
		else
		{
			echo 'Không tồn tại sản phẩm <b>'.$_POST['productCode'].'</b> trong kho';
		}
	}
	
	
	
?>