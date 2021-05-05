<?php
	function viewHistoryAgencyAdmin($input)
    {
        global $urlHomes;
        global $isRequestPost;
        global $contactSite;
        global $urlNow;
        global $modelOption;
        global $metaTitleMantan;
        $metaTitleMantan= 'Lịch sử hoạt động của đại lý';
        

        $dataSend = $input['request']->data;
        $modelHistoryagency= new Historyagency();
        $modelAgency= new Agency();
        $mess= '';
        $data= array();

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('viewHistoryAgencyAdmin', $_SESSION['infoStaff']['Staff']['permission']))){
            	if(!empty($_GET['id'])){
            		$agency= $modelAgency->getAgency($_GET['id'],array('product','code','phone'));
            		
	                $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
	                if($page<1) $page=1;
	                $limit= 15;
	                $conditions=array('idAgency'=>$_GET['id']);
	                $order = array('created'=>'DESC');
	                $fields= array();
	                
	                $listData= $modelHistoryagency->getPage($page, $limit , $conditions, $order, $fields );

	                $totalData= $modelHistoryagency->find('count',array('conditions' => $conditions));
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
	                    if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
	                        $urlPage= $urlPage.'&page=';
	                    }else{
	                        $urlPage= $urlPage.'page=';
	                    }
	                }else{
	                    $urlPage= $urlPage.'?page=';
	                }

	                setVariable('listData',$listData);
	                setVariable('agency',$agency);

	                setVariable('page',$page);
	                setVariable('totalPage',$totalPage);
	                setVariable('back',$back);
	                setVariable('next',$next);
	                setVariable('urlPage',$urlPage);
	            }else{
	            	$modelHistoryagency->redirect($urlHomes.'listAgency');
	            }
            }else{
                $modelHistoryagency->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelHistoryagency->redirect($urlHomes.'admin?status=-2');
        }
    } 
?>