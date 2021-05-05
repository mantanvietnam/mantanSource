<?php
    function listWarehouse($input)
    {
        global $modelOption;
        global $urlHomes;

        if(!empty($_SESSION['infoStaff'])){
            $listData= $modelOption->getOption('listWarehouseGavi');

            setVariable('listData',$listData);
        }else{
            $modelOption->redirect($urlHomes);
        }
    }

    function addWarehouse($input)
    {
        global $modelOption;
        global $urlPlugins;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;

        $metaTitleMantan= 'Thêm kho';

        if(!empty($_SESSION['infoStaff'])){
            $mess= '';
            $listData= $modelOption->getOption('listWarehouseGavi');

            if($isRequestPost){
                $dataSend= $input['request']->data;
                if(!empty($dataSend['name'])){
                    $name= $dataSend['name'];
                    $address= $dataSend['address'];
                    $slug = createSlugMantan($dataSend['name']);
                        
                    if(empty($_GET['id']))
                    {
                        if(!empty($listData['Option']['value']['tData'])){
                            $listData['Option']['value']['tData'] += 1;
                        }else{
                            $listData['Option']['value']['tData'] = 1;
                        }
                        
                        $listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]= array( 'id'=> $listData['Option']['value']['tData'], 'name'=>$name,'slug'=>$slug,'address'=>$address );
                    }else{
                        $idClassEdit= (int) $_GET['id'];
                        $listData['Option']['value']['allData'][$idClassEdit]['name']= $name;
                        $listData['Option']['value']['allData'][$idClassEdit]['slug']= $slug;
                        $listData['Option']['value']['allData'][$idClassEdit]['address']= $address;
                    }
                    
                    $modelOption->saveOption('listWarehouseGavi',$listData['Option']['value']);
                    $mess= 'Lưu dữ liệu thành công';
                    
                    //$modelOption->redirect('/listCategory');
                }else{
                    $mess= 'Không được để trống tên chuyên mục';
                }
            }

            setVariable('mess',$mess);
            setVariable('data',@$listData['Option']['value']['allData'][$_GET['id']]);
        }else{
            $modelOption->redirect('/admin');
        }
    }

    function deleteWarehouse($input)
    {
        global $modelOption;
        global $urlPlugins;
        global $urlHomes;
        global $metaTitleMantan;

        $metaTitleMantan= 'Xóa kho';

        if(!empty($_SESSION['infoStaff'])){
            $idDelete= (int) $_GET['id'];
            $listData= $modelOption->getOption('listWarehouseGavi');
            unset($listData['Option']['value']['allData'][$idDelete]);
            $modelOption->saveOption('listWarehouseGavi',$listData['Option']['value']);

            $modelOption->redirect('/listWarehouse?delete=1');
        }else{
            $modelOption->redirect('/admin');
        }
    }

    function viewWarehouseAgencyAdmin($input)
    {
        global $modelOption;
        global $urlPlugins;
        global $urlHomes;
        global $metaTitleMantan;

        $metaTitleMantan= 'Xem hàng tồn kho của đại lý';

        if(!empty($_SESSION['infoStaff'])){
            if(!empty($_GET['id'])){
                $modelAgency= new Agency();
                $modelProduct= new Product();

                $agency= $modelAgency->getAgency($_GET['id'],array('product','code','phone'));
                
                $listProduct= array();
                if(!empty($agency['Agency']['product'])){
                    foreach($agency['Agency']['product'] as $idProduct=>$quantity){
                        $product= $modelProduct->getProduct($idProduct,array('name','code','image','unit'));
                        if($product){
                            $listProduct[]= array(  'name'=>$product['Product']['name'],
                                                    'code'=>$product['Product']['code'],
                                                    'image'=>$product['Product']['image'],
                                                    'unit'=>$product['Product']['unit'],
                                                    'quantity'=>$quantity,
                                                ); 
                        }
                    }
                }

                setVariable('listProduct',$listProduct);
                setVariable('agency',$agency);
            }else{
                $modelOption->redirect('/listAgency');
            }
        }else{
            $modelOption->redirect('/admin');
        }
    }

    function viewWarehouse($input)
    {
        global $urlHomes;
        global $isRequestPost;
        global $contactSite;
        global $urlNow;
        global $modelOption;
        global $metaTitleMantan;
        $metaTitleMantan= 'Danh sách hàng trong kho';
        

        $dataSend = $input['request']->data;
        $modelImport= new Import();
        $mess= '';
        $data= array();

        if(!empty($_SESSION['infoStaff']) && !empty($_GET['id'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('viewWarehouse', $_SESSION['infoStaff']['Staff']['permission']))){

                $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
                if($page<1) $page=1;
                $limit= 15;
                $conditions= array('idWarehouse'=>$_GET['id']);
                $order = array('created'=>'DESC');
                $fields= array();
                
                
                $listData= $modelImport->getPage($page, $limit , $conditions, $order, $fields );

                $totalData= $modelImport->find('count',array('conditions' => $conditions));
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

                setVariable('page',$page);
                setVariable('totalPage',$totalPage);
                setVariable('back',$back);
                setVariable('next',$next);
                setVariable('urlPage',$urlPage);
                setVariable('mess',$mess);
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }

    function addProductToWarehouse($input)
    {
        global $modelOption;
        global $urlPlugins;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;

        $metaTitleMantan= 'Thêm hàng vào kho';

        if(!empty($_SESSION['infoStaff'])){
            $mess= '';
            $modelProduct= new Product();
            $modelImport= new Import();

            $listWarehouse= $modelOption->getOption('listWarehouseGavi');
            $listProduct= $modelProduct->find('all');

            if($isRequestPost){
                $dataSend= $input['request']->data;
                $product= $modelProduct->getProduct($dataSend['idProduct']);
                
                $save['Import']['idWarehouse']= $dataSend['idWarehouse'];
                $save['Import']['idProduct']= $dataSend['idProduct'];
                $save['Import']['codeProduct']= $product['Product']['code'];
                $save['Import']['nameProduct']= $product['Product']['name'];
                $save['Import']['quantity']= (int) str_replace('.', '', $dataSend['quantity']);
                $save['Import']['quantityNow']= $save['Import']['quantity'];

                $save['Import']['dateExpiration']['text']= $dataSend['dateExpiration'];
                $dateExpiration= explode('/', $dataSend['dateExpiration']);
                $save['Import']['dateExpiration']['time']= mktime(23,59,59,$dateExpiration[1],$dateExpiration[0],$dateExpiration[2]);

                $save['Import']['dateInput']['text']= $dataSend['dateInput'];
                $dateInput= explode('/', $dataSend['dateInput']);
                $save['Import']['dateInput']['time']= mktime(0,0,0,$dateInput[1],$dateInput[0],$dateInput[2]);

                if($modelImport->save($save)){
                    $saveProduct['$inc']['warehouse.'.$dataSend['idWarehouse']]= $save['Import']['quantity'];
                    $saveProduct['$inc']['quantity']= $save['Import']['quantity'];

                    $conditionsProduct= array('_id'=> new MongoId($dataSend['idProduct']) );
                    if($modelProduct->updateAll($saveProduct,$conditionsProduct)){
                        $mess= 'Lưu dữ liệu thành công';
                    }else{
                        $mess= 'Cập nhập dữ liệu vào sản phẩm bị lỗi';
                    }
                }else{
                    $mess= 'Lữu dữ liệu vào kho bị lỗi';
                }
            }

            setVariable('mess',$mess);
            setVariable('listWarehouse',$listWarehouse);
            setVariable('listProduct',$listProduct);
        }else{
            $modelOption->redirect('/admin');
        }
    }

    function deleteProductToWarehouse($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $urlNow;
        $metaTitleMantan= 'Xóa lô hàng';

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('deleteProductToWarehouse', $_SESSION['infoStaff']['Staff']['permission']))){
                $dataSend= $input['request']->data;
                $mess= '';
                $modelImport= new Import();
                $modelLog= new Log();
                $modelProduct= new Product();

                if(!empty($_GET['id'])){
                    $import= $modelImport->getImport($_GET['id']);

                    if($modelImport->delete($_GET['id'])){
                        // lưu lịch sử tạo sản phẩm
                        $saveLog['Log']['time']= time();
                        $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' xóa lô hàng có ID là '.$_GET['id'];
                        $modelLog->save($saveLog);

                        $saveProduct['$inc']['warehouse.'.$import['Import']['idWarehouse']]= 0-$import['Import']['quantity'];
                        $saveProduct['$inc']['quantity']= 0-$import['Import']['quantity'];

                        $conditionsProduct= array('_id'=> new MongoId($import['Import']['idProduct']) );
                        $modelProduct->updateAll($saveProduct,$conditionsProduct);

                        $modelOption->redirect($urlHomes.'viewWarehouse?status=deleteProductDone&id='.$_GET['idWarehouse']);
                    }else{
                        $modelOption->redirect($urlHomes.'viewWarehouse?status=deleteProductFail&id='.$_GET['idWarehouse']);
                    }

                }else{
                    $modelOption->redirect($urlHomes.'listWarehouse');
                }
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }

    // ---------------------------------------------------------------------------------------------
    function viewWarehouseAgency($input)
    {
        global $urlHomes;
        global $modelOption;
        global $isRequestPost;
        global $urlNow;
        global $contactSite;
        global $smtpSite;

        if(!empty($_SESSION['infoAgency'])){
            $modelAgency= new Agency();
            $modelProduct= new Product();

            $agency= $modelAgency->getAgency($_SESSION['infoAgency']['Agency']['id'],array('product'));
            
            $listProduct= array();
            if(!empty($agency['Agency']['product'])){
                foreach($agency['Agency']['product'] as $idProduct=>$quantity){
                    $product= $modelProduct->getProduct($idProduct,array('name','code','image','unit'));
                    if($product){
                        $listProduct[]= array(  'name'=>$product['Product']['name'],
                                                'code'=>$product['Product']['code'],
                                                'image'=>$product['Product']['image'],
                                                'unit'=>$product['Product']['unit'],
                                                'quantity'=>$quantity,
                                            ); 
                    }
                }
            }

            setVariable('listProduct',$listProduct);
            setVariable('tabFooter','viewWarehouseAgency');
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }

    function historyDivineStore($input)
    {
        global $urlHomes;
        global $modelOption;
        global $isRequestPost;
        global $urlNow;

        if(!empty($_SESSION['infoAgency'])){
            $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
            if($page<1) $page=1;
            $limit= 15;
            $conditions=array('toAgency'=>$_SESSION['infoAgency']['Agency']['id'],'status'=>2);
            $order = array('created'=>'DESC');
            $fields= array();
            $modelOrder= new Order();
            $mess= '';

            if(!empty($_GET['dateStart'])){
                $dateStart= explode('/', $_GET['dateStart']);
                $date= mktime(0,0,0,$dateStart[1],$dateStart[0],$dateStart[2]);
                $conditions['dateCreate.time']['$gte']= $date;
            }

            if(!empty($_GET['dateEnd'])){
                $dateEnd= explode('/', $_GET['dateEnd']);
                $date= mktime(23,59,59,$dateEnd[1],$dateEnd[0],$dateEnd[2]);
                $conditions['dateCreate.time']['$lte']= $date;
            }

            if(!empty($_GET['phoneAgency'])){
                $conditions['phoneAgency']= $_GET['phoneAgency'];
            }
            
            $listData= $modelOrder->getPage($page, $limit , $conditions, $order, $fields );

            $totalData= $modelOrder->find('count',array('conditions' => $conditions));
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

            setVariable('page',$page);
            setVariable('totalPage',$totalPage);
            setVariable('back',$back);
            setVariable('next',$next);
            setVariable('urlPage',$urlPage);
            setVariable('mess',$mess);
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }
?>