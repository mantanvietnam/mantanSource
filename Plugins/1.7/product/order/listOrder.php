<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
  $(function() {
  	$( "#fromDate" ).datepicker({
	  dateFormat: "dd-mm-yy"
	});

	$( "#toDate" ).datepicker({
	  dateFormat: "dd-mm-yy"
	});
  });
</script>

<?php
	global $languageProduct;

	$breadcrumb= array( 'name'=>$languageProduct['Orders'],
						'url'=>$urlPlugins.'admin/product-order-listOrder.php',
						'sub'=>array('name'=>$languageProduct['AllData'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 


<div class="clear"></div>
<div id="content">
	<form action="" method="get">
		<table width="100%" cellspacing="0" class="tableList">
			<tr>
				<td>
					<input name="email" value="<?php echo (isset($_GET['email']))?$_GET['email']:'';?>" placeholder="<?php echo $languageProduct['Email'];?>" style="float:left;margin-right: 5px;"/>
				</td>
				<td>
					<input name="phone" value="<?php echo (isset($_GET['phone']))?$_GET['phone']:'';?>" placeholder="<?php echo $languageProduct['Phone'];?>" style="float:left;margin-right: 5px;"/>
				</td>
				<td>
					<input name="fromDate" id="fromDate" value="<?php echo (isset($_GET['fromDate']))?$_GET['fromDate']:'';?>" placeholder="<?php echo $languageProduct['FromDate'];?>" style="float:left;margin-right: 5px;"/>
				</td>
				<td>
					<input name="toDate" id="toDate" value="<?php echo (isset($_GET['toDate']))?$_GET['toDate']:'';?>" placeholder="<?php echo $languageProduct['ToDate'];?>" style="float:left;margin-right: 5px;"/>
				</td>
				
			</tr>
			
			<tr>
				<td colspan="4" align="center">
					<input class="input" type="submit" value="<?php echo $languageProduct['Search'];?>">
				</td>
			</tr>
		</table>
	</form>
	<div class="clear"></div>
    <table id="listTin" cellspacing="0" class="tableList">
        <tr>
        	<td align="center"><?php echo $languageProduct['Date'];?></td>
            <td align="center" width="200"><?php echo $languageProduct['Customers'];?></td>
            <td align="center"><?php echo $languageProduct['TotalAmount'];?></td>
            <td align="center"><?php echo $languageProduct['Phone'];?></td>
            <td align="center"><?php echo $languageProduct['Address'];?></td>
            <td align="center"><?php echo $languageProduct['Status'];?></td>
            <td align="center" width="160"><?php echo $languageProduct['Choose'];?></td>
        </tr>

        <?php
            $confirm= $languageProduct['AreYouSureYouWantToRemove'];
            
            foreach($listData as $tin)
            {
            	switch($tin['Order']['lock']){
            		case 0: $lock= $languageProduct['StatusNew'];break;
            		case 1: $lock= $languageProduct['StatusDone'];break;
            		case 2: $lock= $languageProduct['StatusProcess'];break;
            		case 3: $lock= $languageProduct['StatusCancel'];break;
            	}

	            $format = "d M Y";
				$date=date('d-m-Y h:i:s', $tin['Order']['created']->sec);
                if(!isset($tin['Order']['transportFee'])) $tin['Order']['transportFee']= 0;
	            
                echo '<tr>
                		  <td>'.$date.'</td>
                          <td>'.$tin['Order']['fullname'].'</td>
                          <td>
                          	- '.$languageProduct['Saleprice'].': '.number_format($tin['Order']['totalMoney']).' '.@$listTypeMoney['Option']['value']['allData'][$product['typeMoneyId']]['name'].'
                          	<br/>
                          	- '.$languageProduct['TransportFee'].': '.number_format($tin['Order']['transportFee']).' '.@$listTypeMoney['Option']['value']['allData'][$product['typeMoneyId']]['name'].'
                          </td>
                          <td>'.$tin['Order']['phone'].'</td>
                          <td>'.$tin['Order']['address'].'</td>
                          <td>'.$lock.'</td>
                          
                          <td align="center">
                          		<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/product-order-printOrder.php?layout=default&id='.$tin['Order']['id'].'" class="input" target="_blank" >'.$languageProduct['Print'].'</a> 
								<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/product-order-infoOrder.php?id='.$tin['Order']['id'].'" class="input"  >'.$languageProduct['View'].'</a>  
								<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/product-order-deleteOrder.php?id='.$tin['Order']['id'].'" class="input" onclick="return confirm('."'".$confirm."'".');"  >'.$languageProduct['Delete'].'</a>
						  </td>

                        </tr>';
            }

        ?>


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
</div>