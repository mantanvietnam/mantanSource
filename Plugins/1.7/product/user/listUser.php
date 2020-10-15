<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">

<?php
    global $languageProduct;
    
	$breadcrumb= array( 'name'=>$languageProduct['UserList'],
						'url'=>$urlPlugins.'admin/product-user-listUser.php',
						'sub'=>array('name'=>$languageProduct['AllData'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>

<div id="content">

    <form action="" method="post" name="duan" class="taovienLimit">

        <table id="listTin" cellspacing="0" class="tableList">

            <tr>
                <td align="center"><?php echo $languageProduct['Date'];?></td>
    	        <td align="center"><?php echo $languageProduct['Account'];?></td>
                <td align="center"><?php echo $languageProduct['FullName'];?></td>
                <td align="center"><?php echo $languageProduct['Birthday'];?></td>
                <td align="center"><?php echo $languageProduct['Email'];?></td>
                <td align="center"><?php echo $languageProduct['Phone'];?></td>
                <td align="center"><?php echo $languageProduct['Address'];?></td>
                <td align="center" width="160"><?php echo $languageProduct['Choose'];?></td>

            </tr>

            <?php
            	
                $confirm= $languageProduct['AreYouSureYouWantToRemove'];
                
                foreach($listData as $tin)
                {	      
                    $format = "d M Y";
                    $date=date('d-m-Y', $tin['User']['created']->sec);       
                    echo '<tr>
                              <td>'.$date.'</td>
                              <td>'.$tin['User']['user'].'</td>
                              <td>'.$tin['User']['fullname'].'</td>
                              <td>'.@$tin['User']['birthday'].'</td>
                              <td>'.$tin['User']['email'].'</td>
                              <td>'.$tin['User']['phone'].'</td>
                              <td>'.$tin['User']['address'].'</td>
                              <td align="center">
    								<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/product-user-addUser.php?id='.$tin['User']['id'].'" class="input"  >'.$languageProduct['Edit'].'</a>  
    								<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/product-user-deleteUser.php?id='.$tin['User']['id'].'" class="input" onclick="return confirm('."'".$confirm."'".');"  >'.$languageProduct['Delete'].'</a>
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
    </form>
</div>