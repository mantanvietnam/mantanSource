	<?php getHeader();?>

    <!-- Breadcrumps -->
    <div class="breadcrumbs">
        <div class="row">
            <div class="col-sm-6">
                <h1>Quản lý dịch vụ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li>Bạn đang ở: </li>
                    <li><a href="<?php echo $urlHomes;?>">Trang chủ</a></li>
                    <li class="active">Dịch vụ bạn đang sử dụng</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- End of Breadcrumps -->

    <section class="domainfeatures white">

        <div class="row">
            <div class="col-sm-12">
                <h2>Danh sách dịch vụ bạn đang sử dụng</h2>
                <p>Hệ thống tự động xóa tên miền và tài khoản Hosting - VPS sau 30 ngày quá hạn</p>
            </div>
        </div>

        <div class="domains-table">
            <div class="row">
                <div class="col-sm-12">
                    <table data-wow-delay="0.3s" id="tld-table" class="tablesorter responsive wow fadeInUp tablesaw tablesaw-stack tableCheckDomain" data-mode="stack">
                        <thead>
                            <tr>
                                <th>DỊCH VỤ</th>
                                <th>TÌNH TRẠNG</th>
                                <th>NGÀY KÍCH HOẠT</th>
                                <th>NGÀY HẾT HẠN</th>
								<th>PHÍ GIA HẠN</th>
								<th>MÔ TẢ</th>
                                <th>THÔNG TIN</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php
	                        	if(count($listData)==0){
		                        	echo '<tr><td colspan="7" align="center" style="text-align: center !important;">Bạn chưa có dịch vụ nào trong hệ thống</td></tr>';
	                        	}else{
		                        	foreach($listData as $data){
										$data['Service']['status']= $typeStatusDomain[$data['Service']['status']];
										$timeStart= getdate($data['Service']['timeStart']);
										$data['Service']['timeStart']= $timeStart['mday'].'/'.$timeStart['mon'].'/'.$timeStart['year'];
										
										$timeEnd= getdate($data['Service']['timeEnd']);
										$data['Service']['timeEnd']= $timeEnd['mday'].'/'.$timeEnd['mon'].'/'.$timeEnd['year'];
										
										$info= nl2br($data['Service']['info']);
										if($data['Service']['typeService']==1){
											$info= $info.'<p><img src="http://www.prapi.net/pr.php?url='.$data['Service']['info'].'" /></p>';
										}
										
			                        	echo '  <tr>
					                                <td class="alignLeft">'.$data['Service']['product_name'].'</td>
					                                <td class="alignLeft">'.$data['Service']['status'].'</td>
					                                <td class="alignLeft">'.$data['Service']['timeStart'].'</td>
					                                <td class="alignLeft">'.$data['Service']['timeEnd'].'</td>
													<td class="alignLeft">'.number_format($data['Service']['priceMainten']).'đ</td>
					                                <td class="alignLeft">'.$info.'</td>
					                                <td class="alignLeft">
														- Họ tên: '.$data['Service']['name'].'<br/>
														- Email quản trị: '.$data['Service']['emailManager'].'<br/>
														- Email nhận thông báo: '.$data['Service']['notification'].'<br/>
														- Điện thoại: '.$data['Service']['phone'].'<br/>
														- Địa chỉ: '.$data['Service']['address'].'<br/><br/>
														<b>Tài khoản quản trị</b><br/>
														- Trang quản trị: '.$data['Service']['urlPanel'].'<br/>
														- Tài khoản: '.$data['Service']['account'].'<br/>
													</td>
					                            </tr>';
		                        	}
	                        	}
                        	?>
                        </tbody>
                    </table>
					<p>
					<?php
						
						if(isset($_GET['page'])){
							$urlNow= str_replace('&page='.$_GET['page'], '', $urlNow);
							$urlNow= str_replace('?page='.$_GET['page'], '', $urlNow);
						}
						if(strpos($urlNow,'?')!== false)
						{
							$urlNow= $urlNow.'&page=';
						}
						else
						{
							$urlNow= $urlNow.'?page=';
						}
						
						echo '<a href="'.$urlNow.$back.'">Trang trước</a> ';
						echo $page.'/'.$totalPage;
						echo ' <a href="'.$urlNow.$next.'">Trang sau</a> ';

					?>
					</p>
                </div>
            </div>
        </div>
    </section>

    <?php getFooter();?>