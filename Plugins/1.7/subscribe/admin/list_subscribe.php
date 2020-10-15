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
						'url'=>$urlPlugins.'admin/subscribe-admin-list_subscribe.php',
						'sub'=>array('name'=>'Danh sách')
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
	        Lưu
	      </div>
	      
	
	  </div>
	  <div class="clear" style="margin-left: 15px;margin-bottom: 15px;" id='status'>
		  <?php echo "<p style='color: red;'>".$mess."</p>";?>
	  </div>
	
	  <div class="taovien">
	    <form action="" method="post" name="listForm">
		    <p>Những người đăng ký nhận thông báo: <?php if(isset($data['Option']['value']['listSubscribe'])) echo count($data['Option']['value']['listSubscribe']);else echo '0';?></p>
		    
	        <textarea rows="20" style="width: 90%" name="listSubscribe"><?php if(isset($data['Option']['value']['listSubscribe'])) echo implode(',', $data['Option']['value']['listSubscribe']);?></textarea>
	    </form>
	  </div>
