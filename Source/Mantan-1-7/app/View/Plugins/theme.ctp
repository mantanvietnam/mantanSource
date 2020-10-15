<?php
	global $tmpVariable;
	foreach($tmpVariable as $key=>$value)
	{
		$$key= $value;
	}
	
	if(file_exists($urlLocal['urlLocalTheme'].'/'.$urlFileTheme)){
		include($urlLocal['urlLocalTheme'].'/'.$urlFileTheme);
	}
?>