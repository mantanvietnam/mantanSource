<?php
	$breadcrumb= array( 'name'=>'Appointment Management',
						'url'=>$urlPlugins.'admin/appointment-listAppointments.php',
						'sub'=>array('name'=>'Appointment List')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>

<div id="content">
<style>
.tableList{
	width: 100%;
	margin-bottom: 20px;
	border-collapse: collapse;
    border-spacing: 0;
    border-top: 1px solid #bcbcbc;
    border-left: 1px solid #bcbcbc;
}
.tableList td{
	padding: 5px;
	border-bottom: 1px solid #bcbcbc;
    border-right: 1px solid #bcbcbc;
}
</style>
<form action="" method="post" name="duan" class="taovienLimit">

    <table id="listTin" cellspacing="0" class="tableList">

        <tr>
        	<td align="center">Date</td>
            <td align="center">Full Name</td>

            <td align="center">Email</td>
            
            <td align="center">Phone</td>

            <td align="center" width="250">Ngày hẹn</td>
            
            <td align="center" width="250">Giờ hẹn</td>

            <td align="center" width="160">Choice</td>

        </tr>

        <?php
        	
	        $confirm= 'Are you sure you want to remove ?';
            foreach($listData as $tin)
            {
            	$format = "d M Y";
				$date=date('d-m-Y h:i:s', $tin['Appointment']['created']->sec); 

				echo '<tr>
						  <td>'.$date.'</td>
                                                      
						  <td>'.$tin['Appointment']['pm_app_form_name'].'</td>
                                                      
						  <td>'.$tin['Appointment']['pm_app_form_email'].'</td>
						  
						  <td>'.$tin['Appointment']['pm_app_form_phone'].'</td>

						  <td>'.$tin['Appointment']['pm_app_form_date'].'</td>
                                                      
						  <td>'.$tin['Appointment']['pm_app_form_time'].'</td>
						  
						  <td align="center"> 
								<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/appointment-deleteAppointment.php/'.$tin['Appointment']['id'].'" class="input" onclick="return confirm('."'".$confirm."'".');"  >Delete</a>
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
			
			echo '<a href="'.$urlNow.$back.'">Previous Page</a> ';
			for($i=$startPage;$i<=$endPage;$i++){
				echo ' <a href="'.$urlNow.$i.'">'.$i.'</a> ';
			}
			echo ' <a href="'.$urlNow.$next.'">Next Page</a> ';
	    ?>
	</p>
</form>





</div>