<link href="<?php echo $urlHomes.'app/Plugin/questionAnswer/style.css';?>" rel="stylesheet">
<?php
  $breadcrumb= array( 'name'=>'Question Answer',
            'url'=>$urlPlugins.'admin/questionAnswer-listQuestion.php',
            'sub'=>array('name'=>'List Question')
            );
  addBreadcrumbAdmin($breadcrumb);
?>
<div class="clear"></div>

<div id="content">

<form action="" method="post" name="duan" class="taovienLimit" >

    <table id="listTin" cellspacing="0" class="tableList">

        <tr>

            <td align="center">Người gửi</td>

            <td align="center">Email</td>
            
            <td align="center">Điện thoại</td>
            
            <td align="center">Trạng thái</td>

            <td align="center">Tiêu đề</td>

            <td align="center" width="160">Lựa chọn</td>

        </tr>

        <?php
        	if(!empty($listData)){
            foreach($listData as $tin)
            {
	            	$confirm= 'Bạn có chắc chắn muốn xóa câu hỏi này không?';
	            	if($tin['Question']['active'])
	            	{
		            	$status= "Đã trả lời";
	            	}
	            	else
	            	{
		            	$status= "Chưa trả lời";
	            	}
                    echo '<tr>

                              <td>'.$tin['Question']['fullName'].'</td>

                              <td>'.$tin['Question']['email'].'</td>
                              
                              <td>'.$tin['Question']['fone'].'</td>
                              
                              <td>'.$status.'</td>

                              <td>'.$tin['Question']['title'].'</td>
                              
                              <td align="center">
                                <a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/questionAnswer-replyQuestion.php/?id='.$tin['Question']['id'].'" class="input"  >Edit</a>  
                                <a style="padding: 4px 8px;" href="'.$urlPlugins.'admin/questionAnswer-deleteQuestion.php/?id='.$tin['Question']['id'].'" class="input" onclick="return confirm('."'".$confirm."'".');"  >Delete</a>
                              </td>

                            </tr>';
                

            }
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

      echo 'Total Page: '.$totalPage;
      ?>
  </p>
</form>





</div>