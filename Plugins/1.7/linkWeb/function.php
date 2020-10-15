<?php
	$menus= array();
	$menus[0]['title']= 'Link web';
    $menus[0]['sub'][0]= array('name'=>'Liên kết web','classIcon'=>'fa-link','url'=>$urlPlugins.'admin/linkWeb-listLinkWeb.php','permission'=>'listLinkWeb'
	,'permission'=>'listLinkWebSetting');
    $menus[0]['sub'][1]= array('name'=>'Nhóm liên kết','classIcon'=>'fa-users','url'=>$urlPlugins.'admin/linkWeb-categoryLinkWeb.php','permission'=>'groupLinkWeb',
	'permission'=>'categoryLinkWebSetting');
    
    addMenuAdminMantan($menus);

    function getLinkWebCategory()
    {
    	global $modelOption;
    	return $modelOption->getOption('linkWebCategory');
    }
    
	function showListLink()
	{
		global $modelOption;
		$listData= $modelOption->getOption('linkWeb');
		$dem= 0;
		$demRow= 0;
		$class= '';
		
		foreach($listData['Option']['value']['allData'] as $components)
		{
			if($components['image'])
			{
				$dem++;
				if($dem%4==1)
				{
					$demRow++;
					if($demRow==1) $class= 'active';
					else $class= '';
					echo '<div class="item '.$class.'">';
				} 
				echo '  <div class="col-sm-3">
							<figure>
								<a target="_blank" href="'.$components['link'].'">
									<img src="'.$components['image'].'" alt="'.$components['name'].'">
									<figcaption>
										<h4>'.$components['name'].'</h4>
									</figcaption>
								</a>							
							</figure>	
						</div>';
				if($dem%4==0) echo '</div> <!-- /.active /.item -->';
			}
			
		}
		if($dem%4!=0) echo '</div> <!-- /.active /.item -->';
	}
	
	function getListLinkWeb($idCategory='')
	{
		global $modelOption;
		$listData= $modelOption->getOption('linkWeb');
		$list= array();

		if(isset($listData['Option']['value']['allData'])){
			foreach($listData['Option']['value']['allData'] as $components){
				if($components['category']==$idCategory){
					$list[]= $components;
				}
			}
		}

		return $list;
	}
?>