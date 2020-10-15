<?php getHeader();?>
<div id="content">
    <div class="row">
        <div class="col-sm-3">
            <?php getSidebar();?>
        </div>
        <div class="col-sm-9 main-content cart" style="padding-left: 0;">
            <div class="row">
                <div class="col-md-6">
                    <div class="news_category_title">
                        <h1 style="font-size: 25px; margin: 20px 0; font-family: 'RobotoMedium'; color: #053D1E; ">Lịch sử mua hàng</h1>
                    </div>
                </div>
                <div class="col-md-6" style="margin-top: 10px;">
                    <a href="#" class="begin_payment pull-right"></a>
                    <a href="#" class="continue_shoping pull-right"></a>
                </div>
            </div>
            
            <table id="carts" class="table table-striped dataTable table-bordered" />
                <thead>
                    <tr>
                        <th class="col-center">Ngày mua</th>
                        <th class="col-center">Sản phẩm - Số lượng</th>
                        <th class="">Tổng tiền</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if(!empty($tmpVariable['listData'])){
						foreach($tmpVariable['listData'] as $key=>$data)
						{
				            $date=date('d-m-Y h:i:s', $data['Order']['created']->sec);
                            
                            echo '  <tr>
                                        <td>'.$date.'</td>
                                        <td>';
                                        
                                        if(!empty($data['Order']['listProduct'])){
                                            foreach($data['Order']['listProduct'] as $product){
                                                echo '  <div class="row">
                                                            <div class="col-md-2"> 
                                                                 <img width="70" src="'.@$product['image'].'" width="100%"/>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <h1>'.$product['name'].'</h1>
                                                                <p>SL: &nbsp;<b>'.$product['number'].'</b></p>
                                                            </div>
                                                        </div>';
                                            }
                                        }
                                        
                            echo        '</td>
                                        <td>'.number_format($data['Order']['totalMoney']).'</td>
                                    </tr>';
                        }
                    }else{ 
                        echo '  <tr>
                                    <td colspan="12" align="center">Chưa có đơn hàng nào</td>
                                </tr>';
                        
                    }
                ?>
                </tbody>
            </table>
            
            <div class="row">
                <div class="col-md-6">
                    
                </div>
                <div class="col-md-6">
                    
                      <ul class="pagination pull-right" style="margin-right: 10px;">
                            <?php
                                $end=$tmpVariable['totalPage']
                            ?>
                        <li>
                          <a href="<?php echo $tmpVariable['urlPage'].$tmpVariable['back']; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                          </a>
                        </li>
                        <?php
                            for ($i=$tmpVariable['headPage']; $i <= $tmpVariable['endPage']; $i++) { 
                                echo '<li';
                                if ($i==$tmpVariable['page'])
                                    echo ' class="active" ';
                                echo '><a href="'.$tmpVariable['urlPage'].$i.'">'.$i.'</a></li>';
                            }
                        ?>
                        <li>
                          <a href="<?php echo $tmpVariable['urlPage'].$tmpVariable['next']; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                          </a>
                        </li>
                      </ul>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php getFooter(); ?>               