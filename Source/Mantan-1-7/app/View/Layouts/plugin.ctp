<?php 
	if($routesType=='Plugin'){
		include($urlLocal['urlLocalPlugin'].'/'.$urlFilePlugin);
	}elseif($routesType=='Theme'){
		include($urlLocal['urlLocalTheme'].'/'.$urlFilePlugin);
	}
?>