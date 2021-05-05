<?php
function listProduct($input)
{
    global $urlHomes;
    global $isRequestPost;
    global $contactSite;
    global $urlNow;
    global $modelOption;
    global $metaTitleMantan;
    $metaTitleMantan= 'Danh sách sản phẩm';
    

    $dataSend = $input['request']->data;
    $modelProduct= new Product();
    $mess= '';
    $data= array();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listProduct', $_SESSION['infoStaff']['Staff']['permission']))){
            
            if(!empty($_GET['status'])){
                switch ($_GET['status']) {
                    case 'deleteProductDone':$mess= 'Xóa sản phẩm thành công';break;
                    case 'deleteProductFail':$mess= 'Xóa sản phẩm thất bại do lỗi hệ thống';break;
                    case 'deleteProductFailNotEmply':$mess= 'Xóa sản phẩm thất bại do vẫn còn đại lý bán sản phẩm này';break;
                }
            }

            $listCategoryProduct= $modelOption->getOption('listCategoryGavi');

            $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
            if($page<1) $page=1;
            $limit= 15;
            $conditions=array();
            $conditions = array('status'=>'active');
            $order = array('created'=>'DESC');
            $fields= array('name','code','quantity','idCategory','image','price');
            if(!empty($_GET['name'])){
                $key= createSlugMantan($_GET['name']);
                $conditions['slug']= array('$regex' => $key);
            }
            if(!empty($_GET['code'])){
                $code=trim($_GET['code']);
                $conditions['code']= array('$regex' => $code);
            }
            if(!empty($_GET['idCategory'])){
                $idCategory=trim($_GET['idCategory']);
                $conditions['idCategory']=(int)$idCategory;
            }
            
            $listData= $modelProduct->getPage($page, $limit , $conditions, $order, $fields );

            $totalData= $modelProduct->find('count',array('conditions' => $conditions));
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
            setVariable('listCategoryProduct',$listCategoryProduct);

            setVariable('page',$page);
            setVariable('totalPage',$totalPage);
            setVariable('back',$back);
            setVariable('next',$next);
            setVariable('urlPage',$urlPage);
            setVariable('mess',$mess);
        }else{
            $modelProduct->redirect($urlHomes.'dashboard');
        }
    }else{
        $modelProduct->redirect($urlHomes.'admin?status=-2');
    }
}

// thêm sản phẩm mới
function addProduct($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    $metaTitleMantan= 'Thông tin sản phẩm';

    $modelProduct= new Product();
    $modelLog= new Log();

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('addProduct', $_SESSION['infoStaff']['Staff']['permission']))){

            $mess= '';
            $data= array();
            if(!empty($_GET['id'])){
                $data= $modelProduct->getProduct($_GET['id']);
            }

            $listCategoryProduct= $modelOption->getOption('listCategoryGavi');
            $listWarehouseProduct= $modelOption->getOption('listWarehouseGavi');
            $listAgency = getListAgency();

            if ($isRequestPost) {
                $dataSend= arrayMap($input['request']->data);
                
                if(!empty(trim($dataSend['name']))){
                    $checkProductCode= $modelProduct->getProductCode($dataSend['code'],array('code'));

                    if(empty($checkProductCode) || (!empty($_GET['id']) && $_GET['id']==$checkProductCode['Product']['id'] ) ){
                        foreach($dataSend['priceAgency'] as $key=>$priceAgency){
                            $dataSend['priceAgency'][$key]= (int) str_replace('.', '', $priceAgency);
                        }

                        if(empty($_GET['id'])){
                            $data['Product']['status']= 'active';
                            $data['Product']['quantity']= 0;
                        }

                        $data['Product']['slug']= createSlugMantan($dataSend['name']);
                        $data['Product']['name']= trim($dataSend['name']);
                        $data['Product']['code']= trim($dataSend['code']);
                        $data['Product']['idCategory']=(int)$dataSend['idCategory'];
                        $data['Product']['image']= $dataSend['image'];
                        $data['Product']['price']= (int) str_replace('.', '', $dataSend['price']); 
                        $data['Product']['description']= $dataSend['description'];
                        $data['Product']['unit']= $dataSend['unit'];
                        $data['Product']['productContainer']= (int) str_replace('.', '', $dataSend['productContainer']); 
                        $data['Product']['priceShipContainer']= (int) str_replace('.', '', $dataSend['priceShipContainer']); 
                        $data['Product']['freeShipContainer']= (int) str_replace('.', '', $dataSend['freeShipContainer']); 
                        
                        //$data['Product']['quantity']= $dataSend['quantity'];
                        $data['Product']['priceAgency']= $dataSend['priceAgency'];

                        if($modelProduct->save($data)){
                            $mess= 'Lưu thành công';

                            $saveLog['Log']['time']= time();
                            $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' cài đặt sản phẩm mới có mã: '.$data['Product']['code'];
                            $modelLog->save($saveLog);

                            if(empty($_GET['id'])){
                                $data= array();
                            }
                        }else{
                            $mess= 'Lưu thất bại';
                        }

                    }else{
                        $mess= 'Mã sản phẩm đã tồn tại';
                    }
                }else{
                    $mess= 'Bạn không được để trống tên sản phẩm';
                }
            }   
            setVariable('mess',$mess);
            setVariable('data',$data);
            setVariable('listCategoryProduct',$listCategoryProduct);
            setVariable('listWarehouseProduct',$listWarehouseProduct);
            setVariable('listAgency',$listAgency);

        }else{
            $modelOption->redirect($urlHomes.'dashboard');
        }
    }else{
        $modelOption->redirect($urlHomes.'admin?status=-2');
    }
}

// cập nhập số lượng sản phẩm
function updateProduct($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    $metaTitleMantan= 'Thông tin sản phẩm';

    $modelProduct= new Product();
    $modelLog= new Log();

    if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('updateProduct', $_SESSION['infoStaff']['Staff']['permission']))){
            $dataSend= arrayMap($input['request']->data);
         if(!empty($dataSend['id'])){
             if ($isRequestPost) {
                 if(!empty($dataSend['number'])){
                     $data['$inc']['quantity']= (int) str_replace('.', '', $dataSend['number']);
                     $dk= array('_id'=>new MongoId($dataSend['id']) );

                     if($modelProduct->updateAll($data,$dk)){
                            // lưu lịch sử thay đổi số lượng hàng
                      $saveLog['Log']['time']= time();
                      $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' cập nhập sản phẩm cũ có mã là '.$data['Product']['code'].', số lượng cập nhập '.$dataSend['number'];
                      $modelLog->save($saveLog);
                  }
              }
          }   

      }
  }
}
}

function deleteProduct($input)
{
    global $modelOption;
    global $urlHomes;
    global $isRequestPost;
    global $metaTitleMantan;
    global $urlNow;
    $metaTitleMantan= 'Khóa sản phẩm';

    if(!empty($_SESSION['infoStaff'])){
        if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('deleteProduct', $_SESSION['infoStaff']['Staff']['permission']))){
            $dataSend= $input['request']->data;
            $mess= '';
            $modelProduct= new Product();
            $modelAgency= new Agency();
            $modelLog= new Log();

            if(!empty($_GET['id'])){
                $checkProductAgency= $modelAgency->find('count',array('conditions'=>array('product.'.$_GET['id']=>array('$gt' => 0))));

                if($checkProductAgency==0){
                    if($modelProduct->delete($_GET['id'])){
                        // lưu lịch sử tạo sản phẩm
                        $saveLog['Log']['time']= time();
                        $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' xóa sản phẩm có ID là '.$_GET['id'];
                        $modelLog->save($saveLog);

                        $modelOption->redirect($urlHomes.'listProduct?status=deleteProductDone');
                    }else{
                        $modelOption->redirect($urlHomes.'listProduct?status=deleteProductFail');
                    }
                }else{
                    $modelOption->redirect($urlHomes.'listProduct?status=deleteProductFailNotEmply');
                }
            }else{
                $modelOption->redirect($urlHomes.'listProduct');
            }
        }else{
            $modelOption->redirect($urlHomes.'dashboard');
        }
    }else{
        $modelOption->redirect($urlHomes.'admin?status=-2');
    }
}
function infoProduct(){
   global $modelOption;
   global $urlHomes;
   global $isRequestPost;
   global $metaTitleMantan;
   $metaTitleMantan= 'Xem sản phẩm';

   $modelProduct= new Product();
   $modelSupplier = new Supplier();
   $modelLog= new Log();

   if(!empty($_SESSION['infoStaff'])){
    if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('infoProduct', $_SESSION['infoStaff']['Staff']['permission']))){

        $mess= '';
        $data= array();
        if(!empty($_GET['id'])){
            $data= $modelProduct->getProduct($_GET['id']);
            setVariable('data',$data);
            if(!empty($data['Product']['idSupplier'])){
                $supplier= $modelSupplier->getSupplier($data['Product']['idSupplier'],$fields=array('name') );
                setVariable('supplier',$supplier);

            }
        }

        
        $listChannelProduct= $modelOption->getOption('listChannelProduct');
        $listCategoryProduct= $modelOption->getOption('listCategoryProduct');
        setVariable('listChannelProduct',$listChannelProduct);
        setVariable('listCategoryProduct',$listCategoryProduct);

    }else{
        $modelOption->redirect($urlHomes.'admin?status=-2');
    }
  }else{
    $modelOption->redirect($urlHomes.'admin?status=-2');
  }
}

    function listCategory($input)
    {
        global $modelOption;
        global $urlHomes;

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listCategory', $_SESSION['infoStaff']['Staff']['permission']))){
                $listData= $modelOption->getOption('listCategoryGavi');
                $mess= '';

                if(!empty($_GET['delete'])){
                    switch ($_GET['delete']) {
                        case 1:$mess='Xóa danh mục sản phẩm thành công';break;
                        case -1:$mess='Xóa danh mục sản phẩm thất bại vì vẫn còn sản phẩm thuộc danh mục này';break;
                    }
                }

                setVariable('listData',$listData);
                setVariable('mess',$mess);
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes);
        }
    }

    function addCategory($input)
    {
        global $modelOption;
        global $urlPlugins;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;

        $metaTitleMantan= 'Thêm danh mục';

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('addCategory', $_SESSION['infoStaff']['Staff']['permission']))){
                $mess= '';
                $listData= $modelOption->getOption('listCategoryGavi');

                if($isRequestPost){
                    $dataSend= $input['request']->data;
                    if(!empty($dataSend['name'])){
                        $name= $dataSend['name'];
                        $slug = createSlugMantan($dataSend['name']);
                            
                        if(empty($_GET['id']))
                        {
                            if(!empty($listData['Option']['value']['tData'])){
                                $listData['Option']['value']['tData'] += 1;
                            }else{
                                $listData['Option']['value']['tData'] = 1;
                            }
                            
                            $listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]= array( 'id'=> $listData['Option']['value']['tData'], 'name'=>$name,'slug'=>$slug );
                        }else{
                            $idClassEdit= (int) $_GET['id'];
                            $listData['Option']['value']['allData'][$idClassEdit]['name']= $name;
                            $listData['Option']['value']['allData'][$idClassEdit]['slug']= $slug;
                        }
                        
                        $modelOption->saveOption('listCategoryGavi',$listData['Option']['value']);
                        $mess= 'Lưu dữ liệu thành công';
                        
                        //$modelOption->redirect('/listCategory');
                    }else{
                        $mess= 'Không được để trống tên chuyên mục';
                    }
                }

                setVariable('mess',$mess);
                setVariable('data',@$listData['Option']['value']['allData'][$_GET['id']]);
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect('/admin');
        }
    }

    function deleteCategory($input)
    {
        global $modelOption;
        global $urlPlugins;
        global $urlHomes;
        global $metaTitleMantan;

        $metaTitleMantan= 'Xóa danh mục';
        $modelProduct= new Product();

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('deleteCategory', $_SESSION['infoStaff']['Staff']['permission']))){
                $idDelete= (int) $_GET['id'];
                $checkProduct= $modelProduct->find('count',array('conditions'=>array('idCategory'=>$idDelete)));

                if($checkProduct==0){
                    $listData= $modelOption->getOption('listCategoryGavi');
                    unset($listData['Option']['value']['allData'][$idDelete]);
                    $modelOption->saveOption('listCategoryGavi',$listData['Option']['value']);

                    $modelOption->redirect('/listCategory?delete=1');
                }else{
                    $modelOption->redirect('/listCategory?delete=-1');
                }
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect('/admin');
        }
    }
?>