<?php
	$breadcrumb= array( 'name'=>'Booking Management',
						'url'=>$urlPlugins.'admin/booking-listBooking.php',
						'sub'=>array('name'=>'Booking List')
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

            <td align="center">Date booking</td>
            <td align="center">Number day</td>
            <td align="center">Number room</td>
            <td align="center">Phone</td>
            <td align="center">Email</td>
            <td align="center" width="160">Choice</td>

        </tr>

        <?php
        	$modelBooking= new Booking();
        	$page= (int) $_GET['page'];
        	if($page<=0) $page=1;
        	$limit= 15;
	        $listNotices= $modelBooking->getPage($page,$limit);
	        $confirm= 'Are you sure you want to remove ?';
            foreach($listNotices as $tin)
            {
                    echo '<tr>

                              <td>'.$tin['Booking']['date'].'</td>
                              <td>'.$tin['Booking']['numberDay'].'</td>
                              <td>'.$tin['Booking']['numberRoom'].'</td>
                              <td>'.$tin['Booking']['fone'].'</td>
                              <td>'.$tin['Booking']['email'].'</td>
                              
                              <td align="center"> 
									<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/booking-deleteBooking.php/'.$tin['Booking']['id'].'" class="input" onclick="return confirm('."'".$confirm."'".');"  >Delete</a>
							  </td>

                            </tr>';
                

            }

        ?>


    </table>
	<p>
    <?php
		$totalBooking= $modelBooking->find('count');
		
		$balance= $totalBooking%$limit;
		$totalPage= ($totalBooking-$balance)/$limit;
		if($balance>0)$totalPage+=1;
		
		$back=$page-1;$next=$page+1;
		if($back<=0) $back=1;
		if($next>=$totalPage) $next=$totalPage;
		
		$urlNow= str_replace('&page='.$_GET['page'], '', $urlNow);
		$urlNow= str_replace('?page='.$_GET['page'], '', $urlNow);
		
		echo '<a href="'.$urlNow.'&page='.$back.'">Trước</a> ';
		echo $page.'/'.$totalPage;
		echo ' <a href="'.$urlNow.'&page='.$next.'">Sau</a> ';

    ?>
	</p>
</form>





</div>