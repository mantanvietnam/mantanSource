<?php

function randomExam() {
    global $urlHomes;

    if (checkAdminLogin()) {
        $modelQuestions = new Questions;
        $modelTests = new Tests;
        if (isset($_GET['idTest'])) {

            $dataTest = $modelTests->getTest($_GET['idTest']);
            $listQuestion = $modelQuestions->listQuestions($dataTest['Tests']['id'], $dataTest['Tests']['numberQuestion']);

            if (!empty($listQuestion)) {
                shuffle($listQuestion);
                foreach ($listQuestion as $key => $question) {
                    shuffle($listQuestion[$key]['Questions']['select']);
                }
                $_SESSION['listQuestionTest'] = $listQuestion;
            }
        }
        setVariable('listQuestion', $listQuestion);
        setVariable('dataTest', $dataTest);
    } else {
        $modelTests->redirect($urlHomes . 'admins');
    }
}

//loại đề thi - author:josvuduong
function listTypeTest($input) {
    global $modelOption;
		global $urlHomes;
	
		if(checkAdminLogin()){
			$listData= $modelOption->getOption('typeTest');

			setVariable('listData',$listData);
		}else{
			$modelOption->redirect($urlHomes);
		}
    
}
function saveTypeTest($input)
	{
		global $modelOption;
		global $urlHomes;
		global $isRequestPost;
		global $urlPlugins;
		global $isRequestPost;

		if(checkAdminLogin() && $isRequestPost){
			$dataSend= $input['request']->data;
		
			$name= (isset($dataSend['name']))?$dataSend['name']:'';
			$type= (isset($dataSend['type']))?$dataSend['type']:'';
			
			if($name != '' && $type=='save')
			{
				$idCatEdit= (isset($dataSend['idCatEdit']))?$dataSend['idCatEdit']:'' ;
				$parent= (isset($dataSend['parent']))?(int) $dataSend['parent']:'';
				$slug= (isset($dataSend['slug']))?$dataSend['slug']:'';
				$show= (isset($dataSend['show']))?$dataSend['show']:'';
				$image= (isset($dataSend['image']))?$dataSend['image']:'';
				$description= (isset($dataSend['description']))?$dataSend['description']:'';
				$nameSeo= (isset($dataSend['nameSeo']))?$dataSend['nameSeo']:'';
				$key= (isset($dataSend['key']))?$dataSend['key']:'';
				
                                $groups= $modelOption->getOption('typeTest');
		   		
		   		if(!empty($groups['Option']['value']['category'])){
		   			$number= getNumberSlugCategory($groups['Option']['value']['category'],$slug,0);
		   		}else{
		   			$number= 0;
		   		}

		   		$slugStart= $slug;
		   		if($number>0)
		   		{
			   		$slug= $slug.'-'.$number;
		   		}
		   		
				if($idCatEdit=='')
				{
					if(isset($groups['Option']['value']['tCategory'])){
						$groups['Option']['value']['tCategory']+= 1;
					}else{
						$groups['Option']['value']['tCategory']= 1;
					}
					$save= array(
									'name'=>$name,
									'id'=>$groups['Option']['value']['tCategory'],
									'slug'=>$slug,
									'show'=>$show,
									'image'=>$image,
									'description'=>$description,
									'nameSeo'=>$nameSeo,
									'key'=>$key							
								); 	 
					if($parent==0)
					{
						$groups['Option']['value']['category'][ $groups['Option']['value']['tCategory'] ]= $save;
					}  	
					else
					{
						$groups['Option']['value']['category']= addCat($groups['Option']['value']['category'],$parent,$save);	
					}	
					
					$idCatEdit= $groups['Option']['value']['tCategory'];
				}
				else
				{
					$idCatEdit= (int) $idCatEdit;
					
					$cats= getcat($groups['Option']['value']['category'],$idCatEdit);
					if($cats)
					{
						if($cats['slug']!=$slugStart)
						{
							$cats['slug']= $slug;
						}
						$cats['name']= $name;
						$cats['show']= $show;
						$cats['image']= $image;
						$cats['description']= $description;
						$cats['nameSeo']= $nameSeo;
						$cats['key']= $key;
						
						$groups['Option']['value']['category']= deleteCat($groups['Option']['value']['category'],$idCatEdit,$parent,0);
						$groups['Option']['value']['category']= addCat($groups['Option']['value']['category'],$parent,$cats);
						
					}
				}
				$modelOption->saveOption('typeTest', $groups['Option']['value']);
				
			}
			else if($type=='saveProperties')
			{
				$idCatEdit= (int) $dataSend['idCatEdit'];
				$groups= $modelOption->getOption('typeTest');
				$cats= getcat($groups['Option']['value']['category'],$idCatEdit);
				if($cats)
				{
					$parent= getParentCat($groups,$idCatEdit);
					
					$cats['properties']= array();
					$listProperties= $modelOption->getOption('propertiesProduct');

					if(isset($listProperties['Option']['value']['allData']) && count($listProperties['Option']['value']['allData'])>0){
						foreach($listProperties['Option']['value']['allData'] as $components)
						{
							if(isset($_POST['properties'.$components['id']]) && $_POST['properties'.$components['id']]==1)
							{
								$cats['properties'][$components['id']]= array();
								
								if(isset($components['allData']) && count($components['allData'])>0){
									foreach($components['allData'] as $allData)
									{
										if(isset($_POST['value'.$components['id'].'-'.$allData['id']]) && $_POST['value'.$components['id'].'-'.$allData['id']]==1)
										{
											array_push($cats['properties'][$components['id']], $allData['id']);
										}
									}
								}
							}
						}
					}
					
					$groups['Option']['value']['category']= deleteCat($groups['Option']['value']['category'],$idCatEdit,$parent['id'],0);
					$groups['Option']['value']['category']= addCat($groups['Option']['value']['category'],$parent['id'],$cats);

					$modelOption->saveOption('typeTest', $groups['Option']['value']);
				}
				
			}
			else if($type=='delete')
			{
				$idCat= (int) $dataSend['idDelete'];
				
				$groups= $modelOption->getOption('typeTest');
		   		
				$cats= getcat($groups['Option']['value']['category'],$idCat);
				if($cats)
				{
					$groups['Option']['value']['category']= deleteCat($groups['Option']['value']['category'],$idCat,-1,0);
					$modelOption->saveOption('typeTest', $groups['Option']['value']);
				}
			}
			else if($type=='change')
			{
				$type= $dataSend['typeChange'];
			    $idMenu= (int) $dataSend['idMenu'];
			    
			    $groups= $modelOption->getOption('typeTest');
			    $groups['Option']['value']['category']= sapXepCat($type,$idMenu,$groups['Option']['value']['category']);
		        $modelOption->saveOption('typeTest', $groups['Option']['value']);
			}
			
			$modelOption->redirect($urlPlugins.'admin/testSystem-admin-listTypeTest.php');

		}else{
			$modelOption->redirect($urlHomes);
		}
	}
function typeTest2($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlPlugins;
    global $urlHomes;
    if (checkAdminLogin()) {
        $typeTest = $modelOption->getOption('typeTest');
        if (!empty($_GET['idEdit'])) {
            $idEdit = $_GET['idEdit'];
            $data = $typeTest['Option']['value']['allData'][$idEdit];
        } else {
            $data = '';
        }
        if (!empty($typeTest['Option']['value']['allData'])) {
            $listTypeTest = $typeTest['Option']['value']['allData'];
        } else {
            $listTypeTest = '';
        }
        if ($isRequestPost) {
            $dataSend = $input['request']->data;
            if (!empty($dataSend['name']) > 0) {
                if ($dataSend['id'] == '') {
                    if (empty($dataSend['parent'])) {


                        if (!isset($typeTest['Option']['value']['tData'])) {
                            $typeTest['Option']['value']['tData'] = 1;
                        } else {
                            $typeTest['Option']['value']['tData'] += 1;
                        }
                        $typeTest['Option']['value']['allData'][$typeTest['Option']['value']['tData']] = array
                            (
                            'id' => $typeTest['Option']['value']['tData'],
                            'name' => $dataSend['name'],
                            'description' => $dataSend['description'],
                            'image' => $dataSend['image'],
                        );
                    } else {
                        if (!isset($typeTest['Option']['value']['tData'])) {
                            $typeTest['Option']['value']['tData'] = 1;
                        } else {
                            $typeTest['Option']['value']['tData'] += 1;
                        }
                        $typeTest['Option']['value']['allData'][$dataSend['parent']]['sub'] = array(
                            $typeTest['Option']['value']['tData']=>array(
                                'id' => $typeTest['Option']['value']['tData'],
                                'name' => $dataSend['name'],
                                'description' => $dataSend['description'],
                                'image' => $dataSend['image'],
                                )
                            );
                    }
                } else {
                    $idEdit = (int) $_GET['idEdit'];
                    $typeTest['Option']['value']['allData'][$idEdit]['name'] = $dataSend['name'];
                    $typeTest['Option']['value']['allData'][$idEdit]['description'] = $dataSend['description'];
                    $typeTest['Option']['value']['allData'][$idEdit]['image'] = $dataSend['image'];
                }
                $modelOption->saveOption('typeTest', $typeTest['Option']['value']);
            } else {
                $modelOption->redirect($urlPlugins . 'admin/testSystem-admin-typeTest.php');
            }
        }
        setVariable('listTypeTest', $listTypeTest);
        setVariable('typeTest', $typeTest);
//debug($typeTest);
    
        setVariable('data', $data);
    } else {
        $modelOption->redirect($urlHomes . 'admins');
    }
}

//xóa loại đề thi - author:josvuduong
function deleteTypeTest() {
    global $modelOption;
    global $urlPlugins;
    global $urlHomes;
    if (checkAdminLogin()) {
        $typeTest = $modelOption->getOption('typeTest');
        $idDelete = (int) $_GET['idDelete'];
        if (!empty($typeTest['Option']['value']['allData'][$idDelete])) {
            unset($typeTest['Option']['value']['allData'][$idDelete]);
            $modelOption->saveOption('typeTest', $typeTest['Option']['value']);
            $modelOption->redirect($urlPlugins . 'admin/testSystem-admin-typeTest.php?status=3');
        } else {
            $modelOption->redirect($urlPlugins . 'admin/testSystem-admin-typeTest.php?status=-3');
        }
    } else {
        $modelOption->redirect($urlHomes . 'admins');
    }
}

//list account student - author:ductrinh
function listStudent() {
    global $urlPage;
    global $urlNow;
    if (checkAdminLogin()) {
        $modelStudent = new Student;
        // $listAcc = $modelStudent->find('all');
        // setVariable('listAcc',$listAcc);

        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();
        $listStudent = $modelStudent->getPage($page, $limit, $conditions);
        $totalData = $modelStudent->find('count', array('conditions' => $conditions));
        $balance = $totalData % $limit;
        $totalPage = ($totalData - $balance) / $limit;
        if ($balance > 0)
            $totalPage+=1;
        $back = $page - 1;
        $next = $page + 1;
        if ($back <= 0)
            $back = 1;
        if ($next >= $totalPage)
            $next = $totalPage;

        if (isset($_GET['page'])) {
            $urlPage = str_replace('&page=' . $_GET['page'], '', $urlNow);
            $urlPage = str_replace('page=' . $_GET['page'], '', $urlPage);
        } else {
            $urlPage = $urlNow;
        }
        if (strpos($urlPage, '?') !== false) {
            if (count($_GET) > 1) {
                $urlPage = $urlPage . '&page=';
            } else {
                $urlPage = $urlPage . 'page=';
            }
        } else {
            $urlPage = $urlPage . '?page=';
        }

        setVariable('listStudent', $listStudent);
        // setVariable('dataTest', $dataTest);
        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);
    } else {
        $modelTests->redirect('/admins');
    }
}

//delete account student - author:ductrinh
function deleteStudent() {
    global $urlPlugins;
    if (checkAdminLogin()) {
        if (isset($_GET['idDeleteStudent'])) {
            $modelTests = new Student;
            $idDelete = new mongoId($_GET['idDeleteStudent']);
            $modelTests->delete($idDelete);
        }
        $modelTests->redirect($urlPlugins . 'admin/testSystem-admin-listStudent.php?status=3');
    } else {
        $modelTests->redirect('/admins');
    }
}

//edit account student - author:ductrinh
function editStudent() {
    global $urlPlugins;
    if (checkAdminLogin()) {
        if (isset($_GET['idEditStudent'])) {
            $modelTests = new Student;
            $idEdit = new mongoId($_GET['idEditStudent']);
            $data = $modelTests->getStudent($idEdit);
            setVariable('data', $data);
            if (isset($_POST['username'])) {
                $fullname = $_POST['fullname'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $passwordAgain = $_POST['passwordAgain'];
                $email = $_POST['email'];
                $sex = $_POST['sex'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $id = $_GET['idEditStudent'];

                if ($password == $passwordAgain) {
                    $password = md5($_POST['password']);
                    $modelStudent = new Student;
                    $modelStudent->saveNewStudent($fullname, $username, $password, $email, $sex, $phone, $address, $id);
                    $modelStudent->redirect($urlPlugins . 'admin/testSystem-admin-listStudent.php?status=2');
                }
            }
        }
    } else {
        $modelTests->redirect('/admins');
    }
}

//quản lý điểm thi - author:josvuduong
function viewPoint() {
    global $urlPlugins;
    $modelTests = new Tests;
    $modelStudent = new Student;
    if (checkAdminLogin()) {
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();
        $listTest = $modelTests->getPage($page, $limit, $conditions);
        if (isset($_GET['idTest'])) {
            $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
            if ($page <= 0)
                $page = 1;
            $limit = 15;
            $conditions = array('ketqua.' . $_GET['idTest'] => array('$ne' => null));
            $dataStudent = $modelStudent->getPage($page, $limit, $conditions);
            setVariable('dataStudent', $dataStudent);
        }

        setVariable('listTest', $listTest);
    } else {
        $modelTests->redirect('/admins');
    }
}

//them câu hỏi- xóa- author:josvuduong
function deleteQuestion() {
    global $urlPlugins;
    if (checkAdminLogin()) {
        $modelTests = new Tests;
        if (isset($_GET['idDeleteQuestion']) && $_GET['idTest']) {
            $data = $modelTests->getTest($_GET['idTest']);
            if (!empty($data['Tests']['question'])) {
                unset($data['Tests']['question'][$_GET['idDeleteQuestion']]);
                if ($modelTests->save($data)) {
                    $modelTests->redirect($urlPlugins . 'admin/testSystem-admin-addQuestion.php?idTest=' . $_GET['idTest'] . '&status=3');
                }
            }
        }
    } else {
        $modelTests->redirect('/admins');
    }
}

//danh sách câu hỏi
function listQuestions() {
    global $urlPlugins;
    if (checkAdminLogin()) {
        $modelQuestions = new Questions;
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 999;
        $conditions = array();
        if (!empty($_GET['idTest'])) {
            $idTest = $_GET['idTest'];
            $conditions = array('idTest' => $idTest);
        }
        $listQuestions = $modelQuestions->getPage($page, $limit, $conditions);
        setVariable('listQuestions', $listQuestions);
    } else {
        $modelTests->redirect('/admins');
    }
}

//them câu hỏi
function addQuestion($input) {
    global $urlHomes;
    global $urlPlugins;
    global $isRequestPost;
    global $modelOption;
    global $urlNow;

    if (checkAdminLogin()) {
        $modelQuestions = new Questions;
        $modelTests = new Tests;


        if ($isRequestPost) {
            $dataSend = $input['request']->data;
//            pr($dataSend);die;
            if (!empty($dataSend['id'])) {
                $save = $modelQuestions->getQuestions($dataSend['id']);
            }
            if (!empty($_GET['idTest']) && !empty($dataSend['title']) && !empty($dataSend['select1']) && !empty($dataSend['select2']) && !empty($dataSend['select3']) && !empty($dataSend['select4']) && !empty($dataSend['result'])) {
                $save['Questions']['idTest'] = $_GET['idTest'];
                $save['Questions']['title'] = $dataSend['title'];
                $save['Questions']['select'] = array(
                    array('key' => 'A', 'value' => $dataSend['select1']),
                    array('key' => 'B', 'value' => $dataSend['select2']),
                    array('key' => 'C', 'value' => $dataSend['select3']),
                    array('key' => 'D', 'value' => $dataSend['select4']),
                );
                $save['Questions']['result'] = $dataSend['result'];

                $modelQuestions->save($save);

                $modelQuestions->redirect($urlPlugins . 'admin/testSystem-admin-listQuestions.php?idTest=' . $_GET['idTest'] . '&status=1');
            }
        }

        if (!empty($_GET['idEdit'])) {
            $idEdit = $_GET['idEdit'];
            $dataQuestion = $modelQuestions->getQuestions($idEdit);
        } else {
            $dataQuestion = array();
        }

        setVariable('dataQuestion', $dataQuestion);
    } else {
        $modelTests->redirect('/admins');
    }
}

//danh sách dề thi - thêm,sửa - author:josvuduong
function listTest($input) {
    global $urlHomes;
    global $urlPlugins;
    global $isRequestPost;
    global $modelOption;
    global $urlNow;
    if (checkAdminLogin()) {
        $modelTests = new Tests;
        $listTypeTest= $modelOption->getOption('typeTest');
               
        if (isset($_GET['idEditTest'])) {
            $dataTest = $modelTests->getTest($_GET['idEditTest']);
        } else {
            $dataTest = '';
        }
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0)
            $page = 1;
        $limit = 15;
        $conditions = array();
        $listTest = $modelTests->getPage($page, $limit, $conditions);
        $totalData = $modelTests->find('count', array('conditions' => $conditions));
        $balance = $totalData % $limit;
        $totalPage = ($totalData - $balance) / $limit;
        if ($balance > 0)
            $totalPage+=1;
        $back = $page - 1;
        $next = $page + 1;
        if ($back <= 0)
            $back = 1;
        if ($next >= $totalPage)
            $next = $totalPage;

        if (isset($_GET['page'])) {
            $urlPage = str_replace('&page=' . $_GET['page'], '', $urlNow);
            $urlPage = str_replace('page=' . $_GET['page'], '', $urlPage);
        } else {
            $urlPage = $urlNow;
        }
        if (strpos($urlPage, '?') !== false) {
            if (count($_GET) > 1) {
                $urlPage = $urlPage . '&page=';
            } else {
                $urlPage = $urlPage . 'page=';
            }
        } else {
            $urlPage = $urlPage . '?page=';
        }

        if ($isRequestPost) {

            $dataSend = $input['request']->data;
            if (empty($dataSend['id'])) {

                if (!empty($dataSend['name'])) {
                    $name = $dataSend['name'];

                    if (!empty($dataSend['description'])) {
                        $description = $dataSend['description'];
                    } else {
                        $description = '';
                    }
                    if (!empty($dataSend['typeTest'])) {
                        $typeTest = $dataSend['typeTest'];
                    } else {
                        $typeTest = '';
                    }
                    if (!empty($dataSend['numberQuestion'])) {
                        $numberQuestion = $dataSend['numberQuestion'];
                    } else {
                        $numberQuestion = '';
                    }
                    if (!empty($dataSend['hot'])) {
                        $hot = $dataSend['hot'];
                    } else {
                        $hot = 0;
                    }
                    if (!empty($dataSend['images'])) {
                        $images = $dataSend['images'];
                    } else {
                        $images = '';
                    }
                    if (!empty($dataSend['time'])) {
                        $time = $dataSend['time'];
                    } else {
                        $time = 0;
                    }
                    if (!empty($dataSend['lock'])) {
                        $lock = $dataSend['lock'];
                    } else {
                        $lock = 0;
                    }
                    if ($modelTests->saveNewTest($name, $typeTest, $numberQuestion, $description, $lock, $hot, $images, $time)) {
                        $modelTests->redirect($urlPlugins . 'admin/testSystem-admin-listTest.php?status=1');
                    }
                }
            } else {
                if (!empty($_GET['idEditTest'])) {
                    $idEdit = $_GET['idEditTest'];
                }
                if (!empty($dataSend['name'])) {
                    $save['Tests']['name'] = $dataSend['name'];

                    if (!empty($dataSend['typeTest'])) {
                        $save['Tests']['typeTest'] = $dataSend['typeTest'];
                    } else {
                        $save['Tests']['typeTest'] = '';
                    }
                    if (!empty($dataSend['description'])) {
                        $save['Tests']['description'] = $dataSend['description'];
                    } else {
                        $save['Tests']['description'] = '';
                    }
                    if (!empty($dataSend['numberQuestion'])) {
                        $save['Tests']['numberQuestion'] = $dataSend['numberQuestion'];
                    } else {
                        $save['Tests']['numberQuestion'] = '';
                    }
                    if (!empty($dataSend['time'])) {
                        $save['Tests']['time'] = $dataSend['time'];
                    } else {
                        $save['Tests']['time'] = '';
                    }
                    if (!empty($dataSend['hot'])) {
                        $save['Tests']['hot'] = $dataSend['hot'];
                    } else {
                        $save['Tests']['hot'] = 0;
                    }
                    if (!empty($dataSend['images'])) {
                        $save['Tests']['images'] = $dataSend['images'];
                    } else {
                        $save['Tests']['images'] = '';
                    }

                    if (!empty($dataSend['lock'])) {
                        $save['Tests']['lock'] = $dataSend['lock'];
                    } else {
                        $save['Tests']['lock'] = 0;
                    }
                    $dk['_id'] = new MongoId($idEdit);

                    if ($modelTests->updateAll($save['Tests'], $dk)) {

                        $modelTests->redirect($urlPlugins . 'admin/testSystem-admin-listTest.php?status=2');
                    } else {
                        $modelTests->redirect($urlPlugins . 'admin/testSystem-admin-listTest.php?status=-2');
                    }
                }
            }
        }
        setVariable('listTest', $listTest);
        setVariable('listTypeTest', $listTypeTest);
        
        setVariable('dataTest', $dataTest);
        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);
    } else {
        $modelTests->redirect('/admins');
    }
}

// xóa đề thi -author:josvuduong
function deleteTest() {
    global $urlPlugins;

    if (checkAdminLogin()) {
        if (isset($_GET['idDeleteTest'])) {
            $modelTests = new Tests;
            $idDelete = new mongoId($_GET['idDeleteTest']);
            $modelTests->delete($idDelete);
        }
        $modelTests->redirect($urlPlugins . 'admin/testSystem-admin-listTest.php?status=3');
    } else {
        $modelTests->redirect('/admins');
    }
}

?>