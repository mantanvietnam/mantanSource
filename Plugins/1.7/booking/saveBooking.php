<?php
	$modelOption= new Option();
	$booking= $modelOption->getOption('bookingSettings');
	
	$dataSend= $this->data;
	
	$email= $dataSend['email'];	
	$fone= $dataSend['fone'];
	
	$numberDay= $dataSend['numberDay'];	
		
	$numberRoom= $dataSend['numberRoom'];
	$date= $dataSend['date'].'/'.$dataSend['month'].'/'.$dataSend['year'];	
	
	if($email!='' || $fone!='')
	{
		$modelbooking= new Booking();
        
		$modelbooking->saveBooking($date,$email,$fone,$numberDay,$numberRoom);
		
		if($booking['Option']['value']['sendEmail']==1)
		{
			$content='Ngày đặt: '.$date.'. Số ngày: '.$numberDay.'. Số phòng: '.$numberRoom.'. Email: '.$email.'. Phone: '.$fone;
			
			require('lib/nusoap.php');
			$client = new nusoap_client("http://mobileshop.htsoft.vn/sendEmail/api.php/?wsdl",true);
			$result = $client->call("sendEmail",array("email"=>$contactSite['Option']['value']['email'],"title"=> 'Booking from website ',"content"=> $content));
			
			//var_dump($result);
			//mail($contactSite['Option']['value']['email'], 'Booking from website', $content);
		}
	}
	
	$modelOption->redirect($urlHomes.'?booking=1');
?>