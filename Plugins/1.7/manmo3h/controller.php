<?php
    
    function saveDKManagerManMo($input){
        global $urlHomes;
        global $isRequestPost;
        global $contactSite;
        global $smtpSite;
        global $modelOption;

        $modelDK= new DK;
        if($isRequestPost){
            $dataSend= arrayMap($input['request']->data);
            $name=@$dataSend['name'];
            $email=@$dataSend['email'];
            $fone=@$dataSend['fone'];
            $adrees=@$dataSend['adrees'];
            $web=isset($dataSend['web'])?$dataSend['web']:'';
            $type=@$dataSend['type'];
            $note=@$dataSend['note'];

            $utm_source=$_SESSION['utm_source'];
            $utm_content=$_SESSION['utm_content'];
            $utm_campaign=$_SESSION['utm_campaign'];
            
            $save=array(
                'name'=>$name,
                'email'=>$email,
                'fone'=>$fone,
                'adrees'=>$adrees,
                'web'=>$web,
                'type'=>$type,
                'note'=>$note,
                'utm_source'=>$utm_source,
                'utm_content'=>$utm_content,
                'utm_campaign'=>$utm_campaign,
                'time'=>time(),
                'from'=>'dangky',

            );
            $modelDK->create();
            if($modelDK->save($save)){
            	$contact= $modelOption->getOption('contactSettings');
            	$from= array($contact['Option']['value']['email'] =>  $contact['Option']['value']['displayName']);
				$to= array($contact['Option']['value']['email']);
				$cc= array('khanhha390@gmail.com');
				$bcc= array();
				$subject= '['.$contact['Option']['value']['displayName'].'] Khách hàng đăng ký dùng thử ManMo 3H';
				$content='	Full name: '.$name.'<br/> 
							Address: '.$adrees.'<br/> 
							Email: '.$email.'<br/> 
							Phone: '.$fone.'<br/>
							Website: '.$web.'<br/>
							Type: '.$type.'<br/>
                            Note: '.$note.'<br/>
                            ';

				
				$modelDK->sendMail($from,$to,$cc,$bcc,$subject,$content);
				$modelDK->redirect($urlHomes.'?code=1');
            	/*
                $regManager= sendDataConnectMantan('http://quanlyluutru.com/regManagerAPI',$dataSend);
                //echo $regManager;
                $regManager= json_decode($regManager);
                //debug($regManager);die;
                if($regManager['code']==1){
                    $modelDK->redirect($urlHomes.'?code=1');
                }else{
                    $modelDK->redirect($urlHomes.'?code=-1');
                }
                */
            }else{
                $modelDK->redirect($urlHomes.'?code=-2');
            }
        }
    }
function listDK($input)
    {
        global $urlNow;
        global $urlHomes;
        $modelDK= new DK();

        if(checkAdminLogin()){
            $page= (isset($_GET['page']))? (int) $_GET['page']:1;
            if($page<=0) $page=1;
            $limit= 15;
            $listNotices= $modelDK->getPage($page,$limit);

            $totalData= $modelDK->find('count');
            
            $balance= $totalData%$limit;
            $totalPage= ($totalData-$balance)/$limit;
            if($balance>0)$totalPage+=1;
            if($totalPage<1) $totalPage=1;
            
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
                if(count($_GET)>1){
                    $urlPage= $urlPage.'&page=';
                }else{
                    $urlPage= $urlPage.'page=';
                }
            }else{
                $urlPage= $urlPage.'?page=';
            }
            
            setVariable('listNotices',$listNotices);
            
            setVariable('page',$page);
            setVariable('totalPage',$totalPage);
            setVariable('back',$back);
            setVariable('next',$next);
            setVariable('urlPage',$urlPage);
        }else{
            $modelDK->redirect($urlHomes);
        }
    }
    function deleteDK(){
        $modelDK= new DK();
        global $urlHomes;
        global $urlPlugins;
        if(checkAdminLogin()){
            if(isset($_GET['idDelete']))
            {
                $idDelete= new MongoId($_GET['idDelete']);
                
                $modelDK->delete($idDelete);
            }
            $modelDK->redirect($urlPlugins.'admin/manmo3h-listDK.php?code=1');
        }else{
            $modelDK->redirect($urlPlugins.'admin/manmo3h-listDK.php?code=-1');
        }
    }

    function saveNoteDKAjax($input){
        $modelDK= new DK();
        global $urlHomes;
        global $urlPlugins;
        if(checkAdminLogin()){
            if(isset($_GET['idOrder']))
            {
                $id= new MongoId($_GET['idOrder']);
                $dk= array('_id'=>$id);
                $save['$set']['note']= $_GET['note'];
                
                if($modelDK->updateAll($save,$dk)){
                }
            }
        }
    }
?>