<?php
	global $tmpVariable;
	if(count($tmpVariable)>0){
		foreach($tmpVariable as $key=>$value)
		{
			$$key= $value;
		}
	}

	if(file_exists($urlLocal['urlLocalPlugin'].'/'.$urlFilePlugin)){
		include($urlLocal['urlLocalPlugin'].'/'.$urlFilePlugin);
	}
?>