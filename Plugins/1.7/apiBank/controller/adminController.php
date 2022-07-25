<?php 
function tpbank($input)
{
	global $urlHomes;
	global $modelOption;
	global $isRequestPost;
	
	if(checkAdminLogin()){
		$data= $modelOption->getOption('tpbankSetting');
		$mess= '';
		
		if($isRequestPost){

			$dataSend= $input['request']->data;

			$data['Option']['value']['account']= $dataSend['account'];
			$data['Option']['value']['pass']= $dataSend['pass'];
			$data['Option']['value']['stk']= $dataSend['stk'];
			$data['Option']['value']['key']= $dataSend['key'];

			$modelOption->saveOption('tpbankSetting', $data['Option']['value']);
			
			$mess= 'Save Success';
		}
		
		setVariable('data',$data);
		setVariable('mess',$mess);
	}else{
		$modelOption->redirect($urlHomes);
	}
}
?>