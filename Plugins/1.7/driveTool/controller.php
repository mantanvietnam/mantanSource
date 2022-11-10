<?php 
function listAlbumsDrive($input)
{
	global $urlHomes;
	global $modelOption;
	global $modelAlbum;
	global $isRequestPost;
	
	if(checkAdminLogin()){
		$settingDrive= $modelOption->getOption('settingDrive');
		$listDrive= $modelOption->getOption('listDrive');

		$mess= '';

		$listAlbum = $modelAlbum->find('all');

		if($isRequestPost){
			$dataSend= $input['request']->data;

			if(!empty($dataSend['idAlbum']) && !empty($dataSend['idFolderDrive']) && !empty($settingDrive['Option']['value']['apiKey'])){
				$listDrive['Option']['value'][$dataSend['idAlbum']] = $dataSend['idFolderDrive'];
				$modelOption->saveOption('listDrive', $listDrive['Option']['value']);

				$listFile = file_get_contents("https://www.googleapis.com/drive/v2/files?q='".$dataSend['idFolderDrive']."'+in+parents&key=".$settingDrive['Option']['value']['apiKey']);

				$listFile = json_decode($listFile, true);

				if(!empty($listFile['items'])){
					$infoAlbum = $modelAlbum->getAlbum($dataSend['idAlbum']);
					$image= [];

					foreach ($listFile['items'] as $key => $value) {
						$image[]= array('src'=>$value['webContentLink'],'alt'=>'','link'=>'','title'=>'','description'=>'');
					}

					$infoAlbum['Album']['img'] = $image;

					$modelAlbum->save($infoAlbum);

					$mess= 'Đồng bộ thành công';
				}
			}
		}
		
		setVariable('listAlbum',$listAlbum);
		setVariable('listDrive',$listDrive);
		setVariable('mess',$mess);
		
	}else{
		$modelOption->redirect($urlHomes);
	}
}

function settingDrive($input)
{
	global $urlHomes;
	global $modelOption;
	global $isRequestPost;
	
	if(checkAdminLogin()){
		$data= $modelOption->getOption('settingDrive');
		$mess= '';
		
		if($isRequestPost){

			$dataSend= $input['request']->data;
			$data['Option']['value']['apiKey']= isset($dataSend['apiKey'])?$dataSend['apiKey']:'';
			
			
			$modelOption->saveOption('settingDrive', $data['Option']['value']);
			
			$mess= 'Save Success';
		}
		
		setVariable('data',$data);
		setVariable('mess',$mess);
	}else{
		$modelOption->redirect($urlHomes);
	}
}
?>