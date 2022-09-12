<?php 
function getHistoryTPBank($input)
{
	global $modelOption;

	$modelHistoryBank = new HistoryBank();

	$tpbankSetting= $modelOption->getOption('tpbankSetting');

	$username= $tpbankSetting['Option']['value']['account'];
	$password= $tpbankSetting['Option']['value']['pass'];
	$stk_tpbank= $tpbankSetting['Option']['value']['stk'];
	$keyApp= strtoupper($tpbankSetting['Option']['value']['key']);

	$token= get_token_tpbank($username,$password);
	$token= json_decode($token, true);
	
	if(!empty($token['access_token'])){
		$ngay_bat_dau_check = date('Ymd',strtotime('-1 day'));
		$ngay_ket_thuc_check = date('Ymd',strtotime('+2 day'));

		$listHistory= get_history_tpbank($token['access_token'],$stk_tpbank,$ngay_bat_dau_check,$ngay_ket_thuc_check);
		$listHistory= json_decode($listHistory, true);
		
		if(!empty($listHistory['transactionInfos'])){
			foreach ($listHistory['transactionInfos'] as $key => $value) {
				$value['description'] = strtoupper($value['description']);
				
				if($value['creditDebitIndicator']=='CRDT' && strlen(strstr($value['description'], $keyApp)) > 0){
					$checkHistoryBank= $modelHistoryBank->find('count', array('conditions'=>array('transaction.id'=>$value['id'])));

					if(empty($checkHistoryBank)){
						$descriptions = explode(';', $value['description']);
						
						if(count($descriptions)==1){
							$descriptions = explode('.', $descriptions[0]);
						}

						if(count($descriptions)==1){
							$descriptions = explode('-', $descriptions[0]);
						}

						$description = '';

						foreach ($descriptions as $key => $item) {
							if(strlen(strstr($item, $keyApp)) > 0){
								$description= $item;
								break;
							}
						}

						$save['HistoryBank']['bank']= 'tpbank';
						$save['HistoryBank']['transaction']['id']= $value['id'];
						$save['HistoryBank']['transaction']['arrangementId']= $value['arrangementId'];
						$save['HistoryBank']['transaction']['reference']= $value['reference'];
						$save['HistoryBank']['transaction']['description']= $description;
						$save['HistoryBank']['transaction']['bookingDate']= $value['bookingDate'];
						$save['HistoryBank']['transaction']['amount']= (int) $value['amount'];
						$save['HistoryBank']['transaction']['currency']= $value['currency'];
						$save['HistoryBank']['transaction']['creditDebitIndicator']= $value['creditDebitIndicator'];

						if($modelHistoryBank->save($save)){
							if(function_exists('process_add_money')){
								process_add_money($value['amount'], $description);
							}
						}
					}
				}
			}
		}
	}
}
?>