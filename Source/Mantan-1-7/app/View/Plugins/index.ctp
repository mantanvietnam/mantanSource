<?php
	global $tmpVariable;
	if(count($tmpVariable)>0)
	{
		foreach($tmpVariable as $key=>$value)
		{
			$$key= $value;
		}
	}
	if($urlFilePlugin)
	{
		if($routesType=='Plugin'){
			if(file_exists(__DIR__.'/../../Plugin/'.$urlFilePlugin)){
				include(__DIR__.'/../../Plugin/'.$urlFilePlugin);
			}
		}elseif($routesType=='Theme'){
			if(file_exists(__DIR__.'/../../Theme/'.$urlFilePlugin)){
				include(__DIR__.'/../../Theme/'.$urlFilePlugin);
			}
		}

	}
?>