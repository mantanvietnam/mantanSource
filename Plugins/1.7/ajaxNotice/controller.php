<?php 
	function ajaxNotice()
	{
		$modelNotice=new Notice();
		$page=(int) $_POST['page'];
		$idCat=(int) $_POST['idCat'];
		//debug ($page);
 		$dk= array('lock'=>array('$ne'=>1),
 					'category' => $idCat);
        $listData=$modelNotice->find('all', array(
								'conditions' => $dk,
                                'limit' => 10,
								'page'=> $page,
                                'order' => array('time' => 'desc'),
                                )
        );
        //debug ($listData);
        setVariable('listData',$listData);
	}
?>