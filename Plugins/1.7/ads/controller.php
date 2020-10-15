<?php
	function saveAdsSetting()
	{
		global $modelOption;
		global $urlPlugins;
		$info= array('show'=>(int) $_POST['show'],'imageLeft'=>$_POST['imageLeft'],'linkLeft'=>$_POST['linkLeft'],'imageRight'=>$_POST['imageRight'],'linkRight'=>$_POST['linkRight']);
		$modelOption->saveOption('adsSetting',$info);		
		$modelOption->redirect($urlPlugins.'admin/ads-adsSetting.php');	
	}
?>