<?php
	if (!empty($listData))
	foreach ($listData as $data)
		echo '
			<div class="checkbox-custom chekbox-primary">
				<input id="" name="local[]" type="checkbox" value="'.$data['Localtion']['id'].'"/>
				<label for="">'.$data['Localtion']['name'].'</label>
			</div> 
		';
?>