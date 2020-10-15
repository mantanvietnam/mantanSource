<?php
	function listQuestion($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		
		if(checkAdminLogin()){
        	$modelQuestion= new Question();

			$page= (isset($_GET['page']))? (int) $_GET['page']:1;
        	if($page<=0) $page=1;
        	$limit= 15;
        	$conditions= array();
        	
	        $listData= $modelQuestion->getPage($page,$limit,$conditions);

            $totalData= $modelQuestion->find('count',array('conditions' => $conditions));
		
			$balance= $totalData%$limit;
			$totalPage= ($totalData-$balance)/$limit;
			if($balance>0)$totalPage+=1;
			
			$back=$page-1;$next=$page+1;
			if($back<=0) $back=1;
			if($next>=$totalPage) $next=$totalPage;
			
			if(isset($_GET['page'])){
				$urlPage= str_replace('&page='.$_GET['page'], '', $urlNow);
				$urlPage= str_replace('page='.$_GET['page'], '', $urlPage);
			}else{
				$urlPage= $urlNow;
			}

			if(strpos($urlPage,'?')!== false){
				if(count($_GET)>=1){
					$urlPage= $urlPage.'&page=';
				}else{
					$urlPage= $urlPage.'page=';
				}
			}else{
				$urlPage= $urlPage.'?page=';
			}

			setVariable('listData',$listData);
			setVariable('page',$page);
			setVariable('totalPage',$totalPage);
			setVariable('back',$back);
			setVariable('next',$next);
			setVariable('urlPage',$urlPage);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function deleteQuestion($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;

		if(checkAdminLogin()){
			if(!empty($_GET['id']))
			{
				$idDelete= new MongoId($_GET['id']);
				$modelQuestion= new Question();
				$modelQuestion->delete($idDelete);
			}
			$modelQuestion->redirect($urlPlugins.'admin/questionAnswer-listQuestion.php');
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function replyQuestion($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;
		
		if(checkAdminLogin()){
			if(!empty($_GET['id'])){
				$modelQuestion= new Question();
				$mess= '';
				
				if($isRequestPost){
					$dataSend= $input['request']->data;

					$idQuestion= new MongoId($dataSend['idQuestion']);
				    $answer= $dataSend['answer'];
				    $title= $dataSend['title'];
				     
				    $modelQuestion->saveReply($title,$idQuestion,$answer);
				    $mess= 'Lưu thành công';
				}

				$idQuestion= new MongoId($_GET['id']);
				$question= $modelQuestion->getQuestion($idQuestion);

				global $modelOption;
				$questionAnswerCategory= $modelOption->getOption('questionAnswerCategory');

				setVariable('questionAnswerCategory',$questionAnswerCategory);
				setVariable('question',$question);
				setVariable('mess',$mess);
			}else{
				$modelOption->redirect($urlPlugins.'admin/questionAnswer-listQuestion.php');
			}
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function addQuestion($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		global $urlPlugins;
		
		if(checkAdminLogin()){
			$questionAnswerCategory= $modelOption->getOption('questionAnswerCategory');

			$modelQuestion= new Question();
			$mess= '';
			
			if($isRequestPost){
				$dataSend= $input['request']->data;

				$email= $dataSend['email'];	
				$fullName= $dataSend['fullName'];	
				$fone= $dataSend['fone'];	
				$content= $dataSend['content'];
				$title= $dataSend['title'];	
				$address= $dataSend['address'];	
				$category= $dataSend['category'];	

				$modelQuestion->saveQuestion($title,$fullName,$email,$fone,$content,$address,$category);
				$mess= '<h5 style="color: green;" ><span class="glyphicon glyphicon-ok"></span> Lưu câu hỏi thành công!</h5>';
			}

			setVariable('questionAnswerCategory',$questionAnswerCategory);
			setVariable('mess',$mess);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function listCategoryQuestion($input)
	{
		global $modelOption;
		global $urlHomes;

		if(checkAdminLogin()){
			$listData= $modelOption->getOption('questionAnswerCategory');

			setVariable('listData',$listData);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function saveCategory($input)
	{
		global $modelOption;
		global $urlPlugins;
		global $urlHomes;

		if(checkAdminLogin()){
			$dataSend= $input['request']->data;
			$name= $dataSend['name'];
			$type= $dataSend['type'];
			$slug = createSlugMantan($dataSend['name']);
			
			if($name!='' && $type=='save')
			{
				$listData= $modelOption->getOption('questionAnswerCategory');
				
				if($dataSend['id']=='')
				{
					if(empty($listData['Option']['value']['tData'])){
						$listData['Option']['value']['tData']= 1;
					}else{
						$listData['Option']['value']['tData'] += 1;
					}

					$listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]= array( 'id'=> $listData['Option']['value']['tData'], 'name'=>$name,'slug'=>$slug );
				}
				else
				{
					$idClassEdit= (int) $dataSend['id'];
					$listData['Option']['value']['allData'][$idClassEdit]['name']= $name;
					$listData['Option']['value']['allData'][$idClassEdit]['slug']= $slug;
				}
				
				$modelOption->saveOption('questionAnswerCategory',$listData['Option']['value']);
				
			}
			else if($type=='delete')
			{
				$idDelete= (int) $dataSend['id'];
				$listData= $modelOption->getOption('questionAnswerCategory');
				unset($listData['Option']['value']['allData'][$idDelete]);
				$modelOption->saveOption('questionAnswerCategory',$listData['Option']['value']);
			}
			
			if($dataSend['redirect']>0)
			{
				$modelOption->redirect($urlPlugins.'admin/questionAnswer-listCategoryQuestion.php');
			}
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

?>