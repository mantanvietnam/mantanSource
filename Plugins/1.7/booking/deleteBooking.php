<?php
	if($var1)
	{
		$idDelete= new MongoId($var1);
		$modelBooking= new Booking();
		$modelBooking->delete($idDelete);
	}
	$modelBooking->redirect($urlPlugins.'admin/booking-listBooking.php');
?>