<?php
	$menus= array();
	$menus[0]['title']= 'Question Answer';
	$menus[0]['sub'][0]= array('name'=>'Add Question','url'=>$urlPlugins.'admin/questionAnswer-addQuestion.php','classIcon'=>'fa-search','permission'=>'addQuestion');
    $menus[0]['sub'][1]= array('name'=>'List Question','url'=>$urlPlugins.'admin/questionAnswer-listQuestion.php','classIcon'=>'fa-search','permission'=>'listQuestion');
    $menus[0]['sub'][2]= array('name'=>'List Category Question','url'=>$urlPlugins.'admin/questionAnswer-listCategoryQuestion.php','classIcon'=>'fa-search','permission'=>'listCategoryQuestion');
    
    addMenuAdminMantan($menus);

	function listQuestionAnswer()
	{
		$conditions = array ('active'=>1);
		$modelQuestion= new Question();
		
		$page= (int) $_GET['page'];
    	if($page<=0) $page=1;
    	$limit= 30;
        $listNotices= $modelQuestion->getPage($page,$limit,$conditions);
        
        $urlController= $modelQuestion->getUrlController();
        
        $show= '<script type="text/javascript">
					function showQuestion(idQuestion)
					{
						$.ajax({
					      type: "POST",
					      url: "'.$urlController['urlPlugins'].'?url=question-answer/viewQuestion.php&layout=default",
					      data: { idQuestion:idQuestion}
					    }).done(function( msg ) { 	
						  		$("#themData").html(msg);	
						  		$("#themData").lightbox_me({
							    centered: true, 
							    onLoad: function() { 
							        $("#themData").find("input:first").focus()
							        }
							    });
						 });
					}
				</script> 
				<style>
					#themData, #editData {
					    background-color: #FFFFFF;
					    border-radius: 5px;
					    display: none;
					    padding: 10px;
					    max-with: 800px;
					    max-height: 500px;
					    overflow: auto;
					}
				</style>
				<div id="themData"></div>
        		<ul style="margin-left: 12px;">';
					
		foreach($listNotices as $news)
		{ 
			$today= getdate($news['Question']['time']);
			$today= $today['mday'].'/'.$today['mon'].'/'.$today['year'];
	
			$show= $show.'<li style="list-style: disc outside none;"><a href="javascript:void(0);" onclick="showQuestion('."'".$news['Question']['id']."'".');">'.$news['Question']['title'].'<span> ('.$today.')</span></a></li>';
		}
		$show= $show.'</ul>';
		
		return $show;
	}
	
?>