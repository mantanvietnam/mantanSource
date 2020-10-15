
<?php
	$breadcrumb= array( 'name'=>'Slider Banner',
						'url'=>$urlPlugins.'admin/sliderBanner-setting.php',
						'sub'=>array('name'=>'Setting')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
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

<script type="text/javascript">

	var urlWeb="<?php echo $urlOptions;?>";
	
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
        <?php echo $languageMantan['save'];?>
    </div>
</div>

<p class="clear" id='status'>
	<font color='red'><?php echo $mess;?></font>
</p>
	
<div class="taovien clear">
    <form action="" method="post" name="listForm">
        <table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
          <tr>
            <td align="right" width="100">Slider hiển thị</td>
            <td align="left">
	            <select name="idSelectSliderBanner">
		            <option value=''>Tắt slider</option>
		            <?php
			            foreach($allSlider as $slider)
			            {
				            if($slider['Album']['id']!=$idSlider['Option']['value']['id'])
				            {
					            echo '<option value="'.$slider['Album']['id'].'">'.$slider['Album']['title'].'</option>';
				            }
				            else
				            {
					            echo '<option selected="" value="'.$slider['Album']['id'].'">'.$slider['Album']['title'].'</option>';
				            }
			            }
		            ?>
	            </select>
            </td>
          </tr>
          
          <tr>
            <td align="right" >Chiều rộng</td>
            <td align="left"><input style="width: 300px;" placeholder="VD: 100px hoặc 100%" type="text" value="<?php echo @$idSlider['Option']['value']['width'];?>" name="width" id="width" /></td>
          </tr>
          <tr>
            <td align="right" >Chiều cao</td>
            <td align="left"><input style="width: 300px;" placeholder="VD: 100px hoặc 100%" type="text" value="<?php echo @$idSlider['Option']['value']['height'];?>" name="height" id="height" /></td>
          </tr>
      </table>
    </form>
</div>
