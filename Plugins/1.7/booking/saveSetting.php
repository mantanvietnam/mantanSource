<?php
	$data= $modelOption->getOption('bookingSettings');
	
	$dataSend= $this->data;
	$data['Option']['value']['info']= $dataSend['info'];
	$data['Option']['value']['map']= $dataSend['map'];
	
	$data['Option']['value']['sendEmail']= (int) $_POST['sendEmail'];
	
	$modelOption->saveOption('bookingSettings', $data['Option']['value']);
	$modelOption->redirect($urlPlugins.'admin/booking-setting.php?status=1');
?>