	<?php getHeader();?>

    <!-- Breadcrumps -->
    <div class="breadcrumbs">
        <div class="row">
            <div class="col-sm-6">
                <h1>Lịch sử giao dịch</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li>Bạn đang ở: </li>
                    <li><a href="<?php echo $urlHomes;?>">Trang chủ</a></li>
                    <li class="active">Lịch sử giao dịch</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- End of Breadcrumps -->

    <section class="domainfeatures white">

        <div class="row">
            <div class="col-sm-12">
                <h2>Danh sách lịch sử giao dịch của bạn</h2>
                <p>Mọi thắc mắc xin gửi về email <?php echo $contactSite['Option']['value']['email'];?></p>
            </div>
        </div>

        <div class="domains-table">
            <div class="row">
                <div class="col-sm-12">
                    <table data-wow-delay="0.3s" id="tld-table" class="tablesorter responsive wow fadeInUp tablesaw tablesaw-stack tableCheckDomain" data-mode="stack">
                        <thead>
                            <tr>
                                <th>NGÀY ĐẶT</th>
                                <th>THÔNG TIN ĐƠN HÀNG</th>
                                <th>MÃ GIẢM GIÁ</th>
                                <th>TỔNG TIỀN</th>
                                <th>THANH TOÁN</th>
                                <th>TRẠNG THÁI</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php
	                        	if(count($listData)==0){
		                        	echo '<tr><td colspan="6" align="center" style="text-align: center !important;">Bạn chưa có giao dịch nào</td></tr>';
	                        	}else{
		                        	foreach($listData as $data){
										$data['Order']['created']= getdate($data['Order']['created']->sec);
										$data['Order']['created']= $data['Order']['created']['mday'].'/'.$data['Order']['created']['mon'].'/'.$data['Order']['created']['year'];

		                        		$data['Order']['infoOrder']['pay']= $typePay[$data['Order']['infoOrder']['pay']];
										$data['Order']['processStatus']= $typeProcessStatus[$data['Order']['processStatus']];
										$data['Order']['payStatus']= $typePayStatus[$data['Order']['payStatus']];
										
			                        	echo '  <tr>
					                                <td class="alignLeft">'.$data['Order']['created'].'</td>
					                                <td class="alignLeft">';
													foreach($data['Order']['listOrder'] as $order){
														echo '<b>'.$order['Product']['title'].'</b><br/>';
														echo nl2br($order['Product']['info']).'<br/><br/>';
													}
										echo		'</td>
					                                <td class="alignLeft">'.$data['Order']['infoOrder']['codeGift'].'</td>
					                                <td class="alignLeft">'.number_format($data['Order']['infoOrder']['totalOrder']).'đ</td>
					                                <td class="alignLeft">'.$data['Order']['infoOrder']['pay'].'</td>
					                                <td class="alignLeft">'.$data['Order']['payStatus'].' | '.$data['Order']['processStatus'].'</td>
					                            </tr>';
		                        	}
	                        	}
                        	?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <?php getFooter();?>