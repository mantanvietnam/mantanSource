	<?php getHeader();?>

    <!-- Breadcrumps -->
    <div class="breadcrumbs">
        <div class="row">
            <div class="col-sm-6">
                <h1>Giỏ hàng</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li>Bạn đang ở: </li>
                    <li><a href="<?php echo $urlHomes;?>">Trang chủ</a></li>
                    <li class="active">Giỏ hàng</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- End of Breadcrumps -->

    <section class="domainfeatures white">

        <div class="row">
            <div class="col-sm-12">
                <h2>Đơn hàng của bạn</h2>
                <p>
                	<a href="<?php echo $urlHomes.'hosting-plans';?>">
	                	<input type="button" value="MUA HOST" class="btn btn-danger">
                	</a>
                	<a href="<?php echo $urlHomes.'check-domains';?>">
	                	<input type="button" value="MUA TÊN MIỀN" class="btn btn-danger">
                	</a>
                	<a href="<?php echo $urlHomes.'cloud-vps';?>">
	                	<input type="button" value="MUA VPS" class="btn btn-danger">
                	</a>
					<a href="<?php echo $urlNotices.'cat/khuyen-mai.html';?>">
	                	<input type="button" value="MÃ GIẢM GIÁ" class="btn btn-danger">
                	</a>
                </p>
                <p>Nhập mã <b>freehostbasic</b> để được miễn phí <a href="/hosting-plans">Basic Hosting</a> khi mua <a href="/check-domains">tên miền .com</a></p>
            </div>
        </div>

        <div class="domains-table">
            <div class="row">
                <div class="col-sm-12">
                    <table data-wow-delay="0.3s" id="tld-table" class="tablesorter responsive wow fadeInUp tablesaw tablesaw-stack tableCheckDomain" data-mode="stack">
                        <thead>
                            <tr>
                                <th>DỊCH VỤ</th>
                                <th>PHÍ KHỞI TẠO</th>
                                <th>PHÍ DUY TRÌ/NĂM</th>
                                <th>VAT</th>
                                <th>THỜI GIAN</th>
                                <th>MÔ TẢ</th>
                                <th>XÓA</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php
	                        	if(count($listOrder)==0){
		                        	echo '<tr><td colspan="6" align="center" style="text-align: center !important;">Giỏ hàng trống</td></tr>';
	                        	}else{
	                        		$total= 0;
									$number= -1;
									$saving= 0;
									
		                        	foreach($listOrder as $order){
										$number++;
										if(isset($_SESSION['codeGiftUser']) && $_SESSION['codeGiftUser']!='' && isset($order['Product']['discount'])){
											$priceMainten= $order['Product']['discount'];
											$priceVat= (isset($order['Product']['discountVat']))?$order['Product']['discountVat']:$order['Product']['discount']*0.1;
											$saving= $saving+$order['Product']['priceMainten']-$order['Product']['discount'];
										}else{
											$priceMainten= $order['Product']['priceMainten'];
											$priceVat= (isset($order['Product']['priceVat']))?$order['Product']['priceVat']:$order['Product']['priceMainten']*0.1;
										}
										
										if($order['Product']['year']>1){
		                        			$total= $total+ $order['Product']['priceInstall']+$priceMainten+$priceVat+ ($order['Product']['priceMainten']+$order['Product']['priceVat'])*($order['Product']['year']-1);
			                        	}else{
			                        		$total= $total+ $order['Product']['priceInstall']+($priceMainten+$priceVat)*$order['Product']['year'];
			                        	}

			                        	echo '  <tr>
					                                <td>'.$order['Product']['title'].'</td>
					                                <td class="alignLeft">'.number_format($order['Product']['priceInstall']).'đ</td>
							                        <td class="alignLeft">';
							                        
							                        if($order['Product']['year']>1 && isset($_SESSION['codeGiftUser']) && $_SESSION['codeGiftUser']!='' && isset($order['Product']['discount'])){
								                        echo '- Năm đầu: '.number_format($priceMainten).'đ<br/>';
								                        echo '- Năm sau: '.number_format($order['Product']['priceMainten']).'đ';
							                        }else{
								                        echo number_format($priceMainten).'đ';
							                        }
							                        
							             echo       '</td><td class="alignLeft">';

							             			if($order['Product']['year']>1 && isset($_SESSION['codeGiftUser']) && $_SESSION['codeGiftUser']!='' && isset($order['Product']['discount'])){
								                        echo '- Năm đầu: '.number_format($priceVat).'đ<br/>';
								                        echo '- Năm sau: '.number_format($order['Product']['priceVat']).'đ';
							                        }else{
								                        echo number_format($priceVat).'đ';
							                        }

					                     echo       '</td><td>
														<select name="year" onchange="updateYear(this,'.$number.')">';
															$year= array('0.25'=>'3 tháng',
																	     '0.5'=>'6 tháng',
																	     '1'=>'1 năm',
																	     '2'=>'2 năm',
																	     '3'=>'3 năm',
																	     '4'=>'4 năm',
																	     '5'=>'5 năm',
																	     '6'=>'6 năm',
																	     '7'=>'7 năm',
																	     '8'=>'8 năm',
																	     '9'=>'9 năm',
																	     '10'=>'10 năm',
																		);

															$yearDomain= array(
																	     '1'=>'1 năm',
																	     '2'=>'2 năm',
																	     '3'=>'3 năm',
																	     '4'=>'4 năm',
																	     '5'=>'5 năm',
																	     '6'=>'6 năm',
																	     '7'=>'7 năm',
																	     '8'=>'8 năm',
																	     '9'=>'9 năm',
																	     '10'=>'10 năm',
																		);

															if($order['Product']['typeService']!='1'){
																foreach($year as $key=>$value){
																	if($key!=$order['Product']['year']){
																		echo '<option value="'.$key.'">'.$value.'</option>';
																	}else{
																		echo '<option selected value="'.$key.'">'.$value.'</option>';
																	}
																}
															}else{
																foreach($yearDomain as $key=>$value){
																	if($key!=$order['Product']['year']){
																		echo '<option value="'.$key.'">'.$value.'</option>';
																	}else{
																		echo '<option selected value="'.$key.'">'.$value.'</option>';
																	}
																}
															}
															
										echo			'</select>
													</td>
					                                <td class="alignLeft">'.nl2br($order['Product']['info']).'</td>
					                                <td><a href="'.$urlHomes.'delete-product-cart/'.$number.'"><input class="btn btn-danger" type="button" value="XÓA" /></a></td>
					                            </tr>';
		                        	}
		                        	
		                        	echo '  <tr>
				                                <td colspan="3">';
												
												if(isset($codeGift) && $codeGift!=''){
													echo 'Mã khuyến mại được sử dụng: <input type="button" value="'.$codeGift.'" class="btn btn-danger"> <a href="'.$urlHomes.'remove-gift-code">Nhập mã khác</a>';
												}else{
													echo '<form action="'.$urlHomes.'add-gift-code" method="post">Mã giảm giá <input type="text" value="" autocomplete="false" name="code" /> <input type="submit" value="GIẢM GIÁ" class="btn btn-primary"></form> <p style="color:red;float: left;">'.$messAddCode.'</p>';
												}
				                                
									echo		'</td>
				                                <td colspan="3">
				                                	<p><b>Tổng tiền:</b> '.number_format($total).'đ</p>';
				                                	if($saving>0){
					                                	echo '<p><b>Tiết kiệm:</b> '.number_format($saving).'đ</p>';
				                                	}
				                    echo        '</td>
				                                <td><a href="'.$urlHomes.'checkout"><input type="submit" value="THANH TOÁN" class="btn btn-primary"></a></td>
				                            </tr>';
	                        	}
                        	?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
	<script>
		function updateYear(select,number)
		{
			$.ajax({
				method: "POST",
				url: "<?php echo $urlHomes.'update-cart';?>",
				data: {'year':select.value, 'number':number}
			}).done(function() {
				location.reload(); 
			});
		}
	</script>
    <?php getFooter();?>