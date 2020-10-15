<?php
	function saveGPSMarketerAPI($input)
	{
		$modelMarketer = new Marketer();

		$dataSend = arrayMap($input['request']->data);
	    if(!empty($dataSend['lat']) && !empty($dataSend['long'])){
	    	$conditions = array('team'=>$dataSend['team']);
	    	$data= $modelMarketer->find('first',array('conditions'=>$conditions));

	    	if($data){
		    	$data['Marketer']['lat']= $dataSend['lat'];
		    	$data['Marketer']['long']= $dataSend['long'];
		    	$data['Marketer']['team']= $dataSend['team'];

		    	if($modelMarketer->save($data)){
		    		echo 1;
		    	}else{
		    		echo 0;
		    	}
		    }else{
		    	echo 0;
		    }
	        
	    }else{
	        echo 0;
	    }
	}

	function getAllMarketerAPI($input)
	{
		$modelMarketer = new Marketer();

		$listData= $modelMarketer->find('all');

		echo json_encode($listData);
	}

	function saveTokenDeviceMarketerAPI($input)
	{
		$modelMarketer = new Marketer();
		$dataSend = arrayMap($input['request']->data);
		$conditions = array('team'=>$dataSend['team']);
		$data= $modelMarketer->find('first',array('conditions'=>$conditions));

	    if($data){
	    	$data['Marketer']['tokenDevice']= $dataSend['tokenDevice'];
	    	if($modelMarketer->save($data)){
	    		echo 1;
	    	}else{
	    		echo 0;
	    	}
	    }else{
	    	echo 0;
	    }
	}

	function saveHotelMarketerAPI($input)
	{
		$modelMarketer = new Marketer();
		$dataSend = arrayMap($input['request']->data);
		$conditions = array('team'=>$dataSend['team']);
	    $data= $modelMarketer->find('first',array('conditions'=>$conditions));

	    if($data){
		    if(isset($data['Marketer']['totalHotel'])){
		    	$data['Marketer']['totalHotel']++;
		    }else{
		    	$data['Marketer']['totalHotel']= 1;
		    }

		    //$data['Marketer']['tokenDevice']= $dataSend['tokenDevice'];

		    if($modelMarketer->save($data)){
	    		echo 1;

	    		$listData= $modelMarketer->find('all',array('fields'=>array('tokenDevice'),'conditions'=>array('team'=>array('$ne'=>$dataSend['team']))));
	    		if($listData){
	    			$listToken= array();
	    			foreach($listData as $value){
	    				if(!empty($value['Marketer']['tokenDevice'])){
	    					$listToken[]= $value['Marketer']['tokenDevice'];
	    				}
	    			}
	    			if(!empty($listToken)){
	    				$data= array('mess'=>'Đội '.$dataSend['team'].' đã lấy được dữ liệu nhà nghỉ '.$dataSend['nameHotel']);
	    				sendMessageNotifi($data,$listToken);
	    			}
	    		}
	    	}else{
	    		echo 0;
	    	}
	    }else{
	    	echo 0;
	    }
	}
?>