<?php
	$breadcrumb= array( 'name'=>$languageMantan['userList'],
						'url'=>$urlUsers.'listUser',
						'sub'=>array('name'=>$languageMantan['all'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>
<div class="thanhcongcu">
	
	    <div class="congcu">
	
	        <a href="<?php echo $urlUsers;?>addUser">
	
	          <span>
	
	            <img src="<?php echo $webRoot;?>images/add.png" />
	
	          </span>
	
	            <br/>
	
	            <?php echo $languageMantan['add'];?>
	
	        </a>
	
	    </div>
	
	</div>
	
	<div class="clear"></div>
<div id="content">

    <form action="" method="post" name="duan" class="taovienLimit">

        <table id="listTin" cellspacing="0" class="table table-striped">

            <tr>
                <td align="center"><?php echo $languageMantan['date'];?></td>
    	        <td align="center"><?php echo $languageMantan['account'];?></td>
                <td align="center"><?php echo $languageMantan['fullName'];?></td>
                <td align="center"><?php echo $languageMantan['email'];?></td>
                <td align="center"><?php echo $languageMantan['telephoneNumber'];?></td>
                <td align="center"><?php echo $languageMantan['address'];?></td>
                <td align="center" width="160"><?php echo $languageMantan['choose'];?></td>

            </tr>

            <?php
            	
                $confirm= $languageMantan['areYouSureYouWantToRemove'];
                
                foreach($listData as $tin)
                {	      
                    $format = "d M Y";
                    $date=date('d-m-Y h:i:s', $tin['User']['created']->sec);       
                    echo '<tr>
                              <td>'.$date.'</td>
                              <td>'.$tin['User']['user'].'</td>
                              <td>'.$tin['User']['fullname'].'</td>
                              <td>'.$tin['User']['email'].'</td>
                              <td>'.$tin['User']['phone'].'</td>
                              <td>'.nl2br($tin['User']['address']).'</td>
                              <td align="center">
    								<a style="padding: 4px 8px;" href="'.$urlUsers.'addUser/'.$tin['User']['id'].'" class="input"  >'.$languageMantan['edit'].'</a>  
    								<a style="padding: 4px 8px;" href="'.$urlUsers.'deleteUser?id='.$tin['User']['id'].'" class="input" onclick="return confirm('."'".$confirm."'".');"  >'.$languageMantan['delete'].'</a>
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
                
                echo '<a href="'.$urlPage.$back.'">'.$languageMantan['previousPage'].'</a> ';
                for($i=$startPage;$i<=$endPage;$i++){
                    echo ' <a href="'.$urlPage.$i.'">'.$i.'</a> ';
                }
                echo ' <a href="'.$urlPage.$next.'">'.$languageMantan['nextPage'].'</a> ';

                echo $languageMantan['totalPage'].': '.$totalPage;
            ?>
    	</p>
    </form>
</div>