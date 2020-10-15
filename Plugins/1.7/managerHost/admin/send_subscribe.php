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
<?php
	$breadcrumb= array( 'name'=>'Danh sách email',
						'url'=>$urlPlugins.'admin/managerHost-admin-list_subscribe.php',
						'sub'=>array('name'=>'Gửi mail thông báo')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
    <script type="text/javascript">
	
	function save()
	{
	    document.listForm.submit();
	}
	</script>
	  <div class="thanhcongcu">
	
	      <div class="congcu" onclick="save();">
	        <input type="hidden" id="idChange" value="" />
	        <span id="save">
	          <input type="image" src="<?php echo $webRoot;?>images/save.png" />
	        </span>
	        <br/>
	        Gửi
	      </div>
	      
	
	  </div>
	  <div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
		  <?php echo "<font color='red'>".$mess."</font>";?>
	  </div>
	
	  <div class="taovien">
	    <form action="" method="post" name="listForm">
	        <table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
	          <tr>
	            <td align="right" width="200" >Đối tượng nhận thông báo</td>
	            <td align="left">
		            <input type="radio" value="1" name="typeUser" <?php if($typeUser==1) echo 'checked=""';?> > Khách đăng ký nhận thông báo 
		            &nbsp;&nbsp;
		            <input type="radio" value="2" name="typeUser" <?php if($typeUser==2) echo 'checked=""';?> > Khách hàng đăng ký có tài khoản
		            &nbsp;&nbsp;
		            <input type="radio" value="3" name="typeUser" <?php if($typeUser==3) echo 'checked=""';?> > Gửi mail riêng
		            <br/><br/>
		            <p>
			            <input type="text" style="width: 100%;" value="<?php echo $otherUser;?>" name="otherUser" placeholder="Email khác, cách nhau dấu phẩy" />
		            </p>
	            </td>
	          </tr>
	          
	          <tr>
	            <td align="right" >Tiêu đề mail</td>
	            <td align="left"><input required="" style="width: 100%;" type="text" value="<?php echo $title;?>" name="title" id="title" /></td>
	          </tr>
			  
			  <tr>
	            <td align="right" >Nội dung email</td>
	            <td align="left"><?php showEditorInput('content','content',$content);?></td>
	          </tr>
	      </table>
	    </form>
	  </div>
