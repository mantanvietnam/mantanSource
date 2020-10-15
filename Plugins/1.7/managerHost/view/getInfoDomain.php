<?php
	if($_POST['domain']!=''){
		//echo file_get_contents( "http://www.whois.net.vn/whois.php?domain=".$_POST['domain']."&act=getwhois");
		$data= file_get_contents( "https://tenten.vn/api/whois/?domain=".$_POST['domain']);
		echo nl2br($data);
		/*
		$url= "https://tenten.vn/api/whois/?domain=".$_POST['domain'];
		$ch = curl_init( $url );
		# Setup request to send json via POST.
		//curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded\r\n'));
		# Return response instead of printing.
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		# Send request.
		$result = curl_exec($ch);
		curl_close($ch);
		# Print response.
		echo $result;
		*/
	} else {
		echo 'Không tìm thấy dữ liệu';
	}
?>