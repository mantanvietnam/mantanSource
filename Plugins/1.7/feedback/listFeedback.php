<?php
	$breadcrumb= array( 'name'=>'Customer feedback',
						'url'=>$urlPlugins.'admin/feedback-listFeedback.php',
						'sub'=>array('name'=>'Feedback List')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 

<div class="thanhcongcu">
	<a href="<?php echo $urlPlugins.'admin/feedback-addFeedback.php/';?>">
      <div class="congcu" onclick="addDataNew();">
        <span>
          <input type="image"  src="<?php echo $webRoot;?>images/add.png" />
        </span>
        <br/>
        Thêm
      </div>
	</a>      
</div>
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
			<td align="center">Avatar</td>
            <td align="center">Full Name</td>
            <td align="center">Positions</td>
			<td align="center">Content</td>
      <td align="center">Link</td>
			<td align="center" width="130">Choice</td>
        </tr>

        <?php
        	
	        $confirm= 'Are you sure you want to remove ?';
            foreach($listNotices as $tin)
            {
                    echo '<tr>

                              <td><img src="'.$tin['Feedback']['avatar'].'" width="100" /></td>
                              <td>'.$tin['Feedback']['fullName'].'</td>
                              <td>'.$tin['Feedback']['positions'].'</td>
                              <td>'.$tin['Feedback']['content'].'</td>
                              <td>'.@$tin['Feedback']['link'].'</td>
                              
                              <td align="center"> 
                              		<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/feedback-addFeedback.php/'.$tin['Feedback']['id'].'" class="input" >Edit</a>
                              		&nbsp;&nbsp;
                									<a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/feedback-deleteFeedback.php/'.$tin['Feedback']['id'].'" class="input" onclick="return confirm('."'".$confirm."'".');"  >Delete</a>
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
      
      echo '<a href="'.$urlPage.$back.'">Previous Page</a> ';
      for($i=$startPage;$i<=$endPage;$i++){
        echo ' <a href="'.$urlPage.$i.'">'.$i.'</a> ';
      }
      echo ' <a href="'.$urlPage.$next.'">Next Page</a> ';
      ?>
  </p>
</form>





</div>