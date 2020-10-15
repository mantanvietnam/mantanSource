<?php
	$menus= array();
	$menus[0]['title']= 'Feedback';
    $menus[0]['sub'][0]= array('name'=>'Customer feedback','classIcon'=>'fa-comments-o','url'=>$urlPlugins.'admin/feedback-listFeedback.php','permission'=>'listFeedbackSetting');
    
    addMenuAdminMantan($menus);

    $category= array(array( 'title'=>'Feedback',
							'sub'=>array(	array (
										      'url' => $urlHomes.'feedbacks',
										      'name' => 'List Feedback'
										    )
										)
						  )
					);
	addMenusAppearance($category);
    
    function getListFeedback($limit= null)
    {
	    $modelFeedback= new Feedback();

	    $array= array('limit' => $limit,
                      'order' => array('created' => 'desc')
                    );

	    return $modelFeedback->find('all',$array);    
    }
?>