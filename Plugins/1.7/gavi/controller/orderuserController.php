<?php
	function listOrderUser($input)
    {
        global $urlHomes;
        global $isRequestPost;
        global $contactSite;
        global $urlNow;
        global $modelOption;
        global $metaTitleMantan;
        $metaTitleMantan= 'Danh sách đơn hàng bán lẻ';
        

        $dataSend = $input['request']->data;
        $modelOrderuser= new Orderuser();
        $modelAgency= new Agency();
        $modelProduct= new Product();
        $mess= '';
        $data= array();

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listOrderUser', $_SESSION['infoStaff']['Staff']['permission']))){
                

                $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
                if($page<1) $page=1;
                $limit= 15;
                $conditions=array();
                $order = array('created'=>'DESC');
                $fields= array();
                $statusOrder= getStatusOrder();
                
                if(!empty($_GET['codeAgency'])){
                    $conditions['codeAgency']= strtoupper($_GET['codeAgency']);
                }

                if(!empty($_GET['codeOrder'])){
                    $conditions['code']= strtoupper($_GET['codeOrder']);
                }

                if(!empty($_GET['idStatus'])){
                    $conditions['status']= (int) $_GET['idStatus'];
                }
                
                if(!empty($_GET['excel'])){
                    $table = array(
                                    array('label' => __('Ngày tạo'), 'width' => 25),
                                    array('label' => __('Mã đơn'), 'width' => 10),
                                    array('label' => __('Đại lý'), 'width' => 40),
                                    array('label' => __('Số tiền'), 'width' => 20),
                                    array('label' => __('Số lượng'), 'width' => 20),
                                    array('label' => __('Sản phẩm'), 'width' => 40),
                                    array('label' => __('Trạng thái'), 'width' => 30),
                    );
                    $listDataExcel = $modelOrderuser->find('all',array('conditions'=>$conditions,'order'=>$order));

                    $listAgency= array();
                    if($listDataExcel){
                        foreach($listDataExcel as $key=>$data){
                            if(empty($listAgency[$data['Orderuser']['agencyID']])){
                                $listAgency[$data['Orderuser']['agencyID']]= $modelAgency->getAgency($data['Orderuser']['agencyID'],array('code','level','phone','fullName'));
                            }
                        }
                    }

                    $data= array();
                    $listProduct= array();
                    if(!empty($listDataExcel)){
                        foreach ($listDataExcel as $key => $value) {
                            $listProductShow= '';
                            if(!empty($value['Orderuser']['productID'])){
                                if(empty($listProduct[$value['Orderuser']['productID']])){
                                    $listProduct[$value['Orderuser']['productID']]= $modelProduct->getProduct($value['Orderuser']['productID']);
                                }
                            }
                            $data[]= array( 
                                $value['Orderuser']['dateCreate']['text'],
                                $value['Orderuser']['code'],
                                'C'.$listAgency[$value['Orderuser']['agencyID']]['Agency']['level'].'.'.$listAgency[$value['Orderuser']['agencyID']]['Agency']['fullName'].' - '.$listAgency[$value['Orderuser']['agencyID']]['Agency']['phone'].' ('.$listAgency[$value['Orderuser']['agencyID']]['Agency']['code'].')',
                                number_format($value['Orderuser']['money']),
                                number_format($value['Orderuser']['quantity']),
                                $listProduct[$value['Orderuser']['productID']]['Product']['name'],
                                $statusOrder[$value['Orderuser']['status']]['name']
                            );
                        }
                    }
                    $exportsController = new ExportsController();
                    $exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Danh-sach-don-hang-ban-le')));
                }

                $listData= $modelOrderuser->getPage($page, $limit , $conditions, $order, $fields );

                $listAgency= array();
                $listProduct= array();

                if($listData){
                    foreach($listData as $key=>$data){
                        if(empty($listAgency[$data['Orderuser']['agencyID']])){
                            $listAgency[$data['Orderuser']['agencyID']]= $modelAgency->getAgency($data['Orderuser']['agencyID'],array('code','level','phone','fullName'));
                        }

                        if(!empty($data['Orderuser']['productID'])){
                            if(empty($listProduct[$data['Orderuser']['productID']])){
                                $listProduct[$data['Orderuser']['productID']]= $modelProduct->getProduct($data['Orderuser']['productID']);
                            }
                        }
                    }
                }

                $totalData= $modelOrderuser->find('count',array('conditions' => $conditions));
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
                setVariable('listAgency',$listAgency);
                setVariable('listProduct',$listProduct);
                setVariable('statusOrder',$statusOrder);

                setVariable('page',$page);
                setVariable('totalPage',$totalPage);
                setVariable('back',$back);
                setVariable('next',$next);
                setVariable('urlPage',$urlPage);
                setVariable('mess',$mess);
            }else{
                $modelOrder->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOrder->redirect($urlHomes.'admin?status=-2');
        }
    } 

    function addOrderUser($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $contactSite;
        global $smtpSite;
        $metaTitleMantan= 'Thêm đơn hàng bán lẻ';

        $modelAgency= new Agency();
        $modelLog= new Log();
        $modelProduct= new Product();
        $modelOrderuser= new Orderuser();
        $modelEmail= new Email();

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('addOrderUser', $_SESSION['infoStaff']['Staff']['permission']))){

                $mess= '';
                $data= array();
                $listBank= getListBank();
                $listProduct= $modelProduct->find('all',array('conditions'=>array('status'=>'active')));
                $data= array();
                if(!empty($_GET['id'])){
                    $data= $modelOrderuser->getOrderuser($_GET['id']);
                }
                $listAgency= $modelAgency->find('all',array('fields'=>array('fullName','code','phone','level'),'conditions'=>array('status'=>'active')));

                if ($isRequestPost) {
                    $dataSend= arrayMap($input['request']->data);
                    debug($dataSend);die;
                    if(!empty($dataSend['name']) && !empty($dataSend['address']) && !empty($dataSend['phone']) && !empty($dataSend['productID']) && !empty($dataSend['quantity']) && !empty($dataSend['money']) && !empty($dataSend['agencyID'])){

                        if(empty($data)){
                            $code= $modelOption->getOption('codeOrderUserGavi');
                            $code['Option']['value']['count']= (isset($code['Option']['value']['count']))?$code['Option']['value']['count']+1:1;
                            $data['Orderuser']['code']= 'DHU'.$code['Option']['value']['count'];
                            $modelOption->saveOption('codeOrderUserGavi',$code['Option']['value']);

                            $data['Orderuser']['dateCreate']['text']= date('d/m/Y');
                            $data['Orderuser']['dateCreate']['time']= time();
                        }

                        $data['Orderuser']['name']= $dataSend['name'];
                        $data['Orderuser']['address']= $dataSend['address'];
                        $data['Orderuser']['phone']= $dataSend['phone'];
                        $data['Orderuser']['productID']= $dataSend['productID'];
                        $data['Orderuser']['agencyID']= $dataSend['agencyID'];
                        $data['Orderuser']['quantity']= (int) str_replace('.', '', $dataSend['quantity']);
                        $data['Orderuser']['money']= (int) str_replace('.', '', $dataSend['money']);
                        $data['Orderuser']['status']= 1; // đơn hàng mới getStatusOrder

                        if($modelOrderuser->save($data)){
                            $agency= $modelAgency->getAgency($dataSend['agencyID']);
                            $product= $modelProduct->getProduct($dataSend['productID']);

                            $mess= 'Lưu đơn hàng bán lẻ thành công, mã đơn hàng '.$data['Orderuser']['code'];

                            $saveEmail['Email']['subject']= 'Thông báo có đơn hàng bán lẻ mới, mã đơn '.$data['Orderuser']['code'];
                            $saveEmail['Email']['content']= 'Bạn có đơn hàng bán lẻ mới, thông tin đơn hàng như sau:<br/><br/>Mã đơn hàng: '.$data['Orderuser']['code'].'<br/>Tên khách hàng: '.$dataSend['name'].'<br/>Điện thoại: '.$dataSend['phone'].'<br/>Địa chỉ: '.$dataSend['address'].'<br/>Sản phẩm: '.$product['Product']['name'].'<br/>Số lượng: '.$dataSend['quantity'].'<br/>Giá trị đơn hàng: '.$dataSend['money'].'đ';
                            $saveEmail['Email']['time']= time();
                            $saveEmail['Email']['timeUpdate']= time();
                            $saveEmail['Email']['type']= 'system';
                            $saveEmail['Email']['codeAgency']= @$agency['Agency']['code'];
                            $saveEmail['Email']['idAgency']= @$agency['Agency']['id'];
                            $saveEmail['Email']['phoneAgency']= @$agency['Agency']['phone'];
                            $saveEmail['Email']['nameFrom']= 'Hệ thống';
                            $saveEmail['Email']['listView']= array();
                            $modelEmail->create();
                            $modelEmail->save($saveEmail);

                            if(!empty($agency['Agency']['email'])){
                                $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                                $to = array($agency['Agency']['email']);
                                $cc = array();
                                $bcc = array();

                                $subject = $saveEmail['Email']['subject'];

                                $content = $saveEmail['Email']['content'];

                                $modelAgency->sendMail($from, $to, $cc, $bcc, $subject, $content);
                            }
                        }
                    }else{
                        $mess= 'Bạn không được để trống thông tin bắt buộc';
                    }
                }   

                setVariable('mess',$mess);
                setVariable('listProduct',$listProduct);
                setVariable('data',$data);
                setVariable('listAgency',$listAgency);
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }
?>