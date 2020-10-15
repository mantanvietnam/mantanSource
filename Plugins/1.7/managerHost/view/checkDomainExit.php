<?php
	if($_POST['domain']!=''){
		//echo '0';
		//echo file_get_contents("http://www.whois.net.vn/whois.php?domain=".$_POST['domain']); 
		
		// get data matbao
		/*
		$content = file_get_contents("http://whois.matbao.vn/rss/".$_POST['domain']."/0");  
		$x = new SimpleXmlElement($content);  
		if($x->channel->status == 'Available'){
			// Chua dang ky
			echo 1;
		}else{
			echo 0;
		}
		*/
		
		// get data tenten
		
		$content = (int) file_get_contents("https://tenten.vn/api/check/?domain=".$_POST['domain']);  
		
		if($content==1){
			// chua dang ky
			echo 1;
		}else{
			echo 0;
		}
		
		
	} else {
		echo 0;
	}
?>