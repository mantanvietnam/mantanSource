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
	$breadcrumb= array( 'name'=>'API Bank',
						'url'=>$urlPlugins.'admin/apiBank-view-setting-tpbank.php',
						'sub'=>array('name'=>'TPBank')
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
	    <span id="save">
	      <input type="image" src="<?php echo $webRoot;?>images/save.png" />
	    </span>
	    <br/>
	    Lưu
  	</div>
</div>
	  
<div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
	<font color='red'><?php echo @$mess;?></font>
</div>
	
<div class="taovien row">
    <form action="" method="post" name="listForm">
    	<div class="col-12 col-sm-12 col-md-12">
    		<label for="">Tài khoản</label>
    		<input type="text" name="account" value="<?php echo @$data['Option']['value']['account'];?>" class="form-control">
    	</div>
    	
    	<div class="col-12 col-sm-12 col-md-12">
    		<label for="">Mật khẩu</label>
    		<input type="text" name="pass" value="<?php echo @$data['Option']['value']['pass'];?>" class="form-control">
    	</div>

    	<div class="col-12 col-sm-12 col-md-12">
    		<label for="">Số tài khoản</label>
    		<input type="text" name="stk" value="<?php echo @$data['Option']['value']['stk'];?>" class="form-control">
    	</div>
    	
    	<div class="col-12 col-sm-12 col-md-12">
    		<label for="">Từ khóa cho app</label>
    		<input type="text" name="key" value="<?php echo @$data['Option']['value']['key'];?>" class="form-control">
    	</div>
    </form>
</div>
