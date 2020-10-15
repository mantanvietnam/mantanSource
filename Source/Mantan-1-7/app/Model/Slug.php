<?php
class Slug extends AppModel
{

	var $name = 'Slug';

	function deleteSlug($slug='')
	{
		if(!empty($slug)){
			$this->deleteAll(array('slug' => $slug), false);

			$this->writeFileSlug();
		}
	}

	function writeFileSlug()
	{
		$listData= $this->find('all');

		if(file_exists('../Config/database.php')){
			$urlLocalConfig= '../Config/';
		}else{
			$urlLocalConfig= 'app/Config/';
		}
		
		// write file routesSlug.php
		$string= '<?php ';
		if(!empty($listData)){
			foreach($listData as $data){
				$string .= 'Router::connect($urlBase."'.$data['Slug']['slug'].'.html", array("controller" => "'.$data['Slug']['controller'].'", "action" => "'.$data['Slug']['action'].'"));
				';
			}
		}
		$string.= ' ?>';
		$file = fopen($urlLocalConfig.'routesSlug.php','w');
		fwrite($file,$string);
		fclose($file);
	}
	
	function saveSlug($slug='',$idSlug='',$controller='plugins', $action='index')
	{
		if(!empty($slug)){
			$slugNew= $slug;
			$number= 0;
			$data= null;
			do{
				$data= $this->find('first',array('conditions'=>array('slug'=>$slugNew)));

				if($data && $data['Slug']['id']!=$idSlug){
					$number++;
					$slugNew= $slug.'-'.$number;
				}
			}while ($data && $data['Slug']['id']!=$idSlug);

			if(empty($data) || $data['Slug']['id']!=$idSlug) {
				$save['Slug']['slug']= $slugNew;
				$save['Slug']['controller']= $controller;
				$save['Slug']['action']= $action;
			
				$this->save($save);
				$idSlug= $this->getLastInsertID();

				$this->writeFileSlug();
			}

			return array('slug'=>$slugNew,'idSlug'=>$idSlug);
		}
	}
}
?>