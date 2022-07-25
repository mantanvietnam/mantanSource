<link href="<?php echo $urlHomes.'app/Plugin/quayso/view/admin/style.css';?>" rel="stylesheet">
<?php
	$breadcrumb= array( 'name'=> 'Quay số',
						'url'=>$urlPlugins.'admin/quayso-view-admin-listManager.php',
						'sub'=>array('name'=>'Người quản lý')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>
<br/>

<div id="content" class="clear">
<center>
<form action="" method="get">
	<table width="100%" cellspacing="0" class="tableList">
		<tr>
			<td>
				<p>Điện thoại</p>
				<input name="phone" value="<?php echo @$_GET['phone'];?>" style=""/>
			</td>
			<td>
				<p>Email</p>
				<input name="email" value="<?php echo @$_GET['email'];?>" style=""/>
			</td>
			<td align="center">
				<input class="input" type="submit" value="Tìm kiếm">
			</td>
		</tr>
	</table>
</form>
</center>
<br/>
<form action="" method="post" name="duan" class="taovienLimit">
    <table id="listTin" cellspacing="0" class="tableList">
        <tr>
	        <th align="center">Họ tên</th>
            <th align="center">Liên hệ</th>
            <th align="center">Số dư</th>
            <th align="center">Gói dịch vụ</th>
            <th align="center" width="160" colspan="2">Lựa chọn</th>
        </tr>

        <?php
            foreach($listData as $item)
            {
            	if($item['Manager']['typeBuy']=='buyMonth'){
            		$deadline= '<p>'.date('d/m/Y', $item['Manager']['deadlineBuy']).'</p>';
            	}else{
            		$deadline= '';
            	}
                echo '	<tr>
                		  	<td>'.$item['Manager']['fullname'].'</td>
                		  	<td>
                		  		'.$item['Manager']['phone'].'
                		  		<p>'.$item['Manager']['email'].'</p>
                		  	</td>
                		  	<td>'.number_format($item['Manager']['coin']).'</td>
                		  	<td>'.@$item['Manager']['typeBuy'].$deadline.'</td>

							<td align="center">
								<a href="'.$urlPlugins.'admin/quayso-view-admin-addMoneyManager.php/?id='.$item['Manager']['id'].'" class="input"  >Nạp tiền</a>
						  	</td>
						  	
						  	<td align="center">
								<a href="'.$urlPlugins.'admin/quayso-view-admin-changePackManager.php/?id='.$item['Manager']['id'].'" class="input">Đổi gói</a>
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
			
			echo '<a href="'.$urlPage.$back.'">Previous</a> ';
			for($i=$startPage;$i<=$endPage;$i++){
				echo ' <a href="'.$urlPage.$i.'">'.$i.'</a> ';
			}
			echo ' <a href="'.$urlPage.$next.'">Next</a> ';

			echo 'Tổng số trang: '.$totalPage;
	    ?>
	</p>
</form>





</div>