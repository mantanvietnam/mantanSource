	<?php getHeader();?>

    <!-- Breadcrumps -->
    <div class="breadcrumbs">
        <div class="row">
            <div class="col-sm-6">
                <h1>Quản lý doanh thu</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li>Bạn đang ở: </li>
                    <li><a href="<?php echo $urlHomes;?>">Trang chủ</a></li>
                    <li class="active">Quản lý doanh thu</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- End of Breadcrumps -->

    <section class="domainfeatures white">
        <div class="row">
            <div class="col-sm-12">
                <h2>Doanh thu của bạn</h2>
				<?php
					$link= $urlHomes.'?refCode='.$_SESSION['infoUser']['User']['id'];
					$percent= $_SESSION['infoUser']['User']['percent']*100;
					echo '<p>Link giới thiệu: <a target="_blank" title="Link giới thiệu nhận hoa hồng" href="'.$link.'">'.$link.'</a></p>
						  <p>Số dư tài khoản: '.number_format($_SESSION['infoUser']['User']['coin']).'đ - Bạn được hưởng '.$percent.'% hoa hồng</p>';
				?>
            </div>
        </div>

        <div class="domains-table">
            <div class="row">
                <div class="col-sm-12">
                    <table data-wow-delay="0.3s" id="tld-table" class="tablesorter responsive wow fadeInUp tablesaw tablesaw-stack tableCheckDomain" data-mode="stack">
                        <thead>
                            <tr>
                                <th>MÃ DỊCH VỤ</th>
                                <th>DỊCH VỤ</th>
                                <th>THỜI GIAN SỬ DỤNG</th>
								<th>PHÍ DỊCH VỤ</th>
                                <th>HOA HỒNG</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php
	                        	if(count($listData)==0){
		                        	echo '<tr><td colspan="5" align="center" style="text-align: center !important;">Bạn chưa giới thiệu được khách hàng nào</td></tr>';
	                        	}else{
		                        	foreach($listData as $data){
			                        	echo '  <tr>
					                                <td class="alignLeft">'.$data['Revenue']['order_id'].'</td>
					                                <td class="alignLeft">'.$data['Revenue']['product_name'].'</td>
					                                <td class="alignLeft">'.$data['Revenue']['timeUsed'].'</td>
													<td class="alignLeft">'.number_format($data['Revenue']['priceTotal']).'đ</td>
													<td class="alignLeft">'.number_format($data['Revenue']['reward']).'đ</td>
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