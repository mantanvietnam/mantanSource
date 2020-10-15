	<?php getHeader();?>

    <!-- Breadcrumps -->
    <div class="breadcrumbs">
        <div class="row">
            <div class="col-sm-6">
                <h1>Thanh toán</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li>Bạn đang ở: </li>
                    <li><a href="<?php echo $urlHomes;?>">Trang chủ</a></li>
                    <li class="active">Thanh toán</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- End of Breadcrumps -->

    <section class="domainfeatures white">

        <div class="row">
            <div class="col-sm-12">
                <h2>Thông tin đơn hàng</h2>
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
                </p>
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
                                <th>PHÍ CHUYỂN ĐỎI</th>
                                <th>THỜI GIAN</th>
                                <th>MÔ TẢ</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php
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

									$year= array('year0.25'=>'3 tháng',
											     'year0.5'=>'6 tháng',
											     'year1'=>'1 năm',
											     'year2'=>'2 năm',
											     'year3'=>'3 năm',
											     'year4'=>'4 năm',
											     'year5'=>'5 năm',
											     'year6'=>'6 năm',
											     'year7'=>'7 năm',
											     'year8'=>'8 năm',
											     'year9'=>'9 năm',
											     'year10'=>'10 năm',
												);

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

									 echo      '</td>
												<td class="alignLeft">'.number_format($order['Product']['priceTransfer']).'đ</td>
												<td>'.$year['year'.$order['Product']['year']].'</td>
												<td class="alignLeft">'.nl2br($order['Product']['info']).'</td>
											</tr>';
								}
								
								echo '  <tr>
											<td colspan="4">';
											
											if(isset($codeGift) && $codeGift!=''){
												echo 'Mã khuyến mại được sử dụng: <input type="button" value="'.$codeGift.'" class="btn btn-danger">';
											}
											
								echo		'</td>
											<td colspan="3">
												<p><b>Tổng tiền:</b> '.number_format($total).'đ</p>';
												if($saving>0){
													echo '<p><b>Tiết kiệm:</b> '.number_format($saving).'đ</p>';
												}
								echo        '</td>
										</tr>';
							
								$_SESSION['totalOrder']= $total;
                        	?>
                        </tbody>
                    </table>
                </div>
				
				<form method="post" action="">
					<div class="col-sm-5">
						<h3>Thông tin người quản lý</h3>
						<div id="contactform" class="alignLeft">
								<p><label for="name">Họ tên:*</label> <input value="<?php echo $infoUserLogin['User']['name'];?>" required type="text" class="form-control" name="name" id="name" tabindex="1" /></p>
								<p><label for="email">Email quản trị:*</label> <input value="<?php echo $infoUserLogin['User']['email'];?>" required type="email" class="form-control" name="email" id="email" tabindex="2" /></p>
								<p><label for="notification">Email nhận thông báo:*</label> <input value="<?php echo $infoUserLogin['User']['email'];?>" required type="text" class="form-control" name="notification" id="notification" tabindex="3" /></p>
								<p><label for="phone">Điện thoại:</label> <input value="<?php echo $infoUserLogin['User']['phone'];?>" type="tel" class="form-control" name="phone" id="phone" tabindex="4" /></p>
								<p><label for="address">Địa chỉ:</label> <input value="<?php echo $infoUserLogin['User']['address'];?>" type="text" class="form-control" name="address" id="address" tabindex="5" /></p>
								<p><input name="submit" type="submit" id="submit" class="submit" value="ĐẶT HÀNG" tabindex="6" /></p>
						</div>
					</div>
					
					<div class="col-sm-7">
						<h3>Phương thức thanh toán</h3>
						<div id="contactform" class="alignLeft">
							<p>
								<ul style="list-style: none;">
									<li><input type="radio" name="pay" id="pay" tabindex="7" value="bank" onclick="selectPay('bank');" checked /> Chuyển khoản ngân hàng</li>
									<!--
									<li><input type="radio" name="pay" id="pay" tabindex="8" value="card" onclick="selectPay('payPal');" /> Chuyển qua PayPal</li>
									<li><input type="radio" name="pay" id="pay" tabindex="9" value="card" onclick="selectPay('card');" /> Credit/Debit/Prepaid Card</li>
									-->
									<li><input type="radio" name="pay" id="pay" tabindex="10" value="cash" onclick="selectPay('cash');" /> Tiền mặt</li>
									<li><input type="radio" name="pay" id="pay" tabindex="11" value="coin" onclick="selectPay('coin');" /> Trừ tiền trong tài khoản</li>
								</ul>
							</p>
							<div id="bank">
								<b>Chú ý:</b> Nội dung chuyển khoản cần ghi rõ thanh toán mua tên miền hay gói hosting, vps nào, số điện thoại hoặc email đăng ký để tránh nhầm với người dùng khác
								<?php echo $infoBank;?>
							</div>
							
							<div id="payPal" style="display: none;">
							
							</div>
							
							<div id="card" style="display: none;">
								<p>
									<label for="name">Name on card:*</label> 
									<input value="" type="text" class="form-control" name="cc_name" id="cc_name" />
								</p>
								<p>
									<label for="name">Card number:*</label> 
									<input value="" type="text" class="form-control" name="cc_number" id="cc_number" />
								</p>
								<p>
									<label for="name">Card Type</label> 
									<select class="form-control" name="cc_type">
										<option value="VISA">VISA</option>
										<option value="MasterCard">MasterCard</option>
										<option value="AMEX">AMEX</option>
										<option value="Discover">Discover</option>
										<option value="JCB">JCB</option>
										<option value="DCI">Diners Club International</option>
										<option value="AstroPayCard">AstroPayCard</option>							
									</select>
								</p>
								<p>
									<label for="name">Expiration date</label> 
									<select id="cc_month" name="cc_month">
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">August</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">November</option>
										<option value="12">December</option>
									</select>
									
									<select id="cc_month" name="cc_month">
										<?php
											$today= getdate();
											for($i=$today['year'];$i<=$today['year']+30;$i++){
												echo '<option value="'.$i.'">'.$i.'</option>';
											}
										?>
									</select>
								</p>
								<p>
									<label for="name">Card verification value number:*</label> 
									<input value="" type="text" class="form-control" name="cc_cvv" id="cc_cvv" />
								</p>
							</div>
							
							<div id="cash" style="display: none;">
								<p>Thanh toán trực tiếp tại văn phòng công ty:</p>
								<ul style="margin-left: 10px;">
									<li>Địa chỉ: <?php echo $contactSite['Option']['value']['address'];?></li>
									<li>Điện thoại: <?php echo $contactSite['Option']['value']['fone'];?></li>
									<li>Email: <?php echo $contactSite['Option']['value']['email'];?></li>
								</ul>
							</div>
							
							<div id="coin" style="display: none;">
								<p>Số dư tài khoản: <?php echo number_format($_SESSION['infoUser']['User']['coin']);?>đ<p>
								<p>Số tiền này có được bằng cách bạn nạp trực tiếp vào tài khoản để trừ dần hoặc giới thiệu cho bạn bè của bạn về dịch vụ của Mantan Host và nhận hoa hồng</p>
								<p>Link giới thiệu: <a target="_blank" title="Link giới thiệu nhận hoa hồng" href="<?php echo $linkRefCode;?>"><?php echo $linkRefCode;?></a></p>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </section>
    
    <script type="text/javascript">
	    function selectPay(type)
	    {
	    	$("#bank").hide();
			$("#paypal").hide();
	    	$("#card").hide();
	    	$("#cash").hide();
	    	$("#coin").hide();
	    	
		    $("#"+type).show();
	    }
    </script>
    <?php getFooter();?>