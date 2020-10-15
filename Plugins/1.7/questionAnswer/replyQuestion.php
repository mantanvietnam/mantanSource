<script type="text/javascript">
    function saveData()
    {

        document.dangtin.submit();

    }
</script>

<link href="<?php echo $urlHomes.'app/Plugin/questionAnswer/style.css';?>" rel="stylesheet">
<?php
  $breadcrumb= array( 'name'=>'Question Answer',
            'url'=>$urlPlugins.'admin/questionAnswer-listQuestion.php',
            'sub'=>array('name'=>'Replly Question')
            );
  addBreadcrumbAdmin($breadcrumb);
?>

<div class="clear"></div>

<div class="thanhcongcu">

    

    <div class="congcu" onclick="saveData();">

        <span id="save">

          <input type="image"  src="<?php echo $webRoot;?>images/save.png" />

        </span>

        <br/>

        Lưu

    </div>

    

</div>

<div class="clear"></div>

<div id="content">


<form  action="" method="post" name="dangtin" >

    <input type="hidden" value="<?php echo $question['Question']['id'];?>" name="idQuestion" />
    <div class="taovienLimit">
    	<p style="color: red;"><?php echo $mess;?></p>
	    <table id="listTin" cellspacing="0" class="tableList">
	
	        <tr>
	            <td width="100">Người gửi</td>
	            <td><?php echo $question['Question']['fullName'];?></td>
	        </tr>
	
	        <tr>
	            <td>Email</td>
	            <td><?php echo $question['Question']['email'];?></td>
	        </tr>
	
	        <tr>
	            <td>Số điện thoại</td>
	            <td><?php echo $question['Question']['fone'];?></td>
	        </tr>

	        <tr>
	            <td>Địa chỉ</td>
	            <td><?php echo $question['Question']['address'];?></td>
	        </tr>

	        <tr>
	            <td>Chuyên mục</td>
	            <td><?php echo @$questionAnswerCategory['Option']['value']['allData'][$question['Question']['category']]['name'];?></td>
	        </tr>
	        
	        <tr>
	            <td>Tiêu đề</td>
	            <td><input type="text" name="title" value="<?php echo $question['Question']['title'];?>" style="width: 100%;" /></td>
	        </tr>
	        
	        <tr>
	            <td>Câu hỏi</td>
	            <td><?php echo $question['Question']['content'];?></td>
	        </tr>
	    </table>
    </div>
    <div class="clear"></div>
    <div style="margin-left: 15px;">
		<p>Trả lời</p>
		<?php
		    showEditorInput('answer','answer',@$question['Question']['answer'],1);
		?>
    </div>		

    

</form>



</div>