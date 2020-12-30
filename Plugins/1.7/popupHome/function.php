<?php
	$menus= array();
	$menus[0]['title']= 'Popup Content';
    $menus[0]['sub'][0]= array('name'=>'Popup Setting','classIcon'=>'fa-link','url'=>$urlPlugins.'admin/popupHome-setting.php','permission'=>'settingPopupHome');
    addMenuAdminMantan($menus);
    
	function showPopupHome()
	{
		global $modelOption;
		global $infoSite;
		global $urlHomes;
		
		$data= $modelOption->getOption('popupHome');
		if($data['Option']['value']['status']==1 && empty($_SESSION['showPopup']))
		{ 
		?>
			<div class="modal" tabindex="-1" role="dialog" id="myModalPopUP1">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title">Thông báo</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <?php echo $data['Option']['value']['content'];?>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
			      </div>
			    </div>
			  </div>
			</div>
			
			<script type="text/javascript">
				$('#myModalPopUP1').modal('show')
			</script>
		<?php $_SESSION['showPopup']= true; }
	}
?>