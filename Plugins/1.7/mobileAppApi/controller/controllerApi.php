<?php
function getProductHotAPI($input) {
    global $urlHomes;
    $listData = array();

    if (class_exists('Product')) {
        $modelProduct = new Product();

        $page = (isset($input['request']->data['page'])) ? (int) $input['request']->data['page'] : 1;
        $limit = (isset($input['request']->data['limit'])) ? (int) $input['request']->data['limit'] : null;
        $conditions = array('hot' => 1);

        $listData = $modelProduct->getPage($page, $limit, $conditions);
        $listData= checkInfoProductAPI($listData);
    }

    setVariable('listData', $listData);
}

function getProductNewAPI($input) {
    global $urlHomes;
    $listData = array();

    if (class_exists('Product')) {
        $modelProduct = new Product();

        $page = (isset($input['request']->data['page'])) ? (int) $input['request']->data['page'] : 1;
        $limit = (isset($input['request']->data['limit'])) ? (int) $input['request']->data['limit'] : null;
        $conditions = array();

        $listData = $modelProduct->getPage($page, $limit, $conditions);

        $listData= checkInfoProductAPI($listData);
    }

    setVariable('listData', $listData);
}

function getProductByCategoryAPI($input) {
    $listData = array();

    if (class_exists('Product')) {
        global $modelOption;
        global $urlHomes;
        $modelProduct = new Product();

        $page = (isset($input['request']->data['page'])) ? (int) $input['request']->data['page'] : 1;
        $limit = (isset($input['request']->data['limit'])) ? (int) $input['request']->data['limit'] : null;
        $conditions = array();
        $listData= array();

        // get list id category
        $listProductCategory = $modelOption->getOption('productCategory');
        if (isset($input['request']->data['idCat']) && isset($listProductCategory['Option']['value']['category']) && count($listProductCategory['Option']['value']['category']) > 0) {
            $idCat = (int) $input['request']->data['idCat'];
            $categorySearch = $modelProduct->getcat($listProductCategory['Option']['value']['category'], $idCat);
            $listId = array($idCat);
            $listId = getSubIdCategory($categorySearch, $listId);

            $conditions = array('category' => array('$in' => $listId));

            $listData = $modelProduct->getPage($page, $limit, $conditions);

            $listData= checkInfoProductAPI($listData);
        }
    }

    setVariable('listData', $listData);
}

function getProductByManufacturerAPI($input) {
    $listData = array();

    if (class_exists('Product')) {
        global $modelOption;
        global $urlHomes;
        $modelProduct = new Product();

        $page = (isset($input['request']->data['page'])) ? (int) $input['request']->data['page'] : 1;
        $limit = (isset($input['request']->data['limit'])) ? (int) $input['request']->data['limit'] : null;
        $conditions = array();
        $listData= array();

        // get list id category
        $listProductCategory = $modelOption->getOption('productManufacturer');
        if (isset($input['request']->data['idManufacturer']) && isset($listProductCategory['Option']['value']['category']) && count($listProductCategory['Option']['value']['category']) > 0) {
            $idCat = (int) $input['request']->data['idManufacturer'];
            $categorySearch = $modelProduct->getcat($listProductCategory['Option']['value']['category'], $idCat);
            $listId = array($idCat);
            $listId = getSubIdCategory($categorySearch, $listId);

            $conditions = array('category' => array('$in' => $listId));

            $listData = $modelProduct->getPage($page, $limit, $conditions);

            $listData= checkInfoProductAPI($listData);
        }
    }

    setVariable('listData', $listData);
}

function getProductByIdAPI($input) {
    global $urlHomes;
    $listData = array();

    if (class_exists('Product')) {
        $modelProduct = new Product();
        if (!empty($input['request']->data['id'])) {
            $listData = $modelProduct->getProduct($input['request']->data['id']);

            if(!empty($listData)){
                $listData= checkInfoProductAPI(array($listData));
                $listData= $listData[0];
            }
        }
    }

    setVariable('listData', $listData);
}

function getProductRelatedById($input) {
    global $urlHomes;
    $listData = array();

    if (class_exists('Product')) {
        $modelProduct = new Product();
        $listData = array();
        $data = $modelProduct->getProduct($input['request']->data['id']);
        if (isset($input['request']->data['id']) && isset($data['Product']['otherProductID']) && mb_strlen(trim($data['Product']['otherProductID'])) > 0) {
            $otherProductID = explode(',', $data['Product']['otherProductID']);
            foreach ($otherProductID as $otherID) {
                $listData[] = $modelProduct->getProduct($otherID);
            }
        } elseif (isset($data['Product']['manufacturerId'])) {
            $conditions = array('manufacturerId' => $data['Product']['manufacturerId']);
            $listData = $modelProduct->getOtherData(8, $conditions);
        }

        $listData= checkInfoProductAPI($listData);
    }

    setVariable('listData', $listData);
}

function getProductByCodeAPI($input) {
    global $urlHomes;
    $listData = array();

    if (class_exists('Product')) {
        $modelProduct = new Product();
        $conditions = array();
        if (!empty($input['request']->data['code'])) {
            $conditions['code'] = $input['request']->data['code'];
            $listData = $modelProduct->getOtherData($limit = 1, $conditions);

            $listData= checkInfoProductAPI($listData);
        }
    }

    setVariable('listData', $listData);
}

function getProductByKeyAPI($input) {
    global $urlHomes;
    $listData = array();

    if (class_exists('Product')) {
        $modelProduct = new Product();
        $conditions = array();
        $limit = null;

        if (isset($input['request']->data['key']) && isset($input['request']->data['value'])) {
            $conditions[$input['request']->data['key']] = $input['request']->data['value'];

            $listData = $modelProduct->getOtherData($limit, $conditions);

            $listData= checkInfoProductAPI($listData);
        }
    }

    setVariable('listData', $listData);
}

function getCategoryProductAPI($input) {
    global $modelOption;

    $listData = array();

    if (class_exists('Product')) {
        $listData = $modelOption->getOption('productCategory');
    }

    setVariable('listData', $listData);
}

function getManufacturerProductAPI($input) {
    global $modelOption;
    $listData = array();

    if (class_exists('Product')) {
        $listData = $modelOption->getOption('productManufacturer');
    }

    setVariable('listData', $listData);
}

function getAdditionalAttributesProductAPI($input) {
    
}

function getTypeMoneyAPI($input) {

    global $modelOption;
    $listData = array();

    if (class_exists('Product')) {
        $listData = $modelOption->getOption('productTypeMoney');
    }

    setVariable('listData', $listData);
}

function getProductDiscountAPI($input) {
    global $urlHomes;
    $listData = array();

    if (class_exists('Product')) {
        $modelProduct = new Product();

        $today = getdate();
        $conditions['dateDiscountStart'] = array('$lte' => $today[0]);
        $conditions['dateDiscountEnd'] = array('$gte' => $today[0]);
        $conditions['lock'] = 0;

        $page = (isset($input['request']->data['page'])) ? (int) $input['request']->data['page'] : 1;
        $limit = (isset($input['request']->data['limit'])) ? (int) $input['request']->data['limit'] : null;

        $listData = $modelProduct->getPage($page, $limit, $conditions);

        $listData= checkInfoProductAPI($listData);
    }

    setVariable('listData', $listData);
}

function getProductSearchAPI($input) {
    global $urlHomes;
    $listData = array();
    $conditions = array();

    if (class_exists('Product')) {
        $modelProduct = new Product();
        global $modelOption;
        $page = (isset($input['request']->data['page'])) ? (int) $input['request']->data['page'] : 1;
        $limit = (isset($input['request']->data['limit'])) ? (int) $input['request']->data['limit'] : null;

        if (isset($input['request']->data['key']) && $input['request']->data['key'] != '') {
            $key = createSlugMantan($input['request']->data['key']);
            $conditions['$or'][0]['slug'] = array('$regex' => $key);
            $conditions['$or'][1]['slugKeys'] = array('$regex' => $key);
            $conditions['$or'][2]['code'] = array('$regex' => $key);
            $conditions['$or'][3]['alias'] = array('$regex' => $key);
        }

//        // tim theo gia
//        if (isset($input['request']->data['price']) && $input['request']->data['price'] != '') {
//            $price = explode(';', $input['request']->data['price']);
//
//            $priceFrom = (int) $price[0];
//            $priceTo = (int) $price[1];
//
//            $conditions['price'] = array('$gte' => $priceFrom, '$lte' => $priceTo);
//        }

        $listCategory = $modelOption->getOption('productCategory');

        if (isset($input['request']->data['categoryId']) && $input['request']->data['categoryId'] != '') {
            $idCat = (int) $input['request']->data['categoryId'];
            $infoCategory = $modelProduct->getcat($listCategory['Option']['value']['category'], $idCat);

            $categorySearch = array($idCat);
            $categorySearch = getSubIdCategory($infoCategory, $categorySearch);
        } else {
            $categorySearch = array();
        }
        if ($categorySearch) {
            $conditions['category'] = array('$in' => $categorySearch);
        }

//        $listManufacturer = $modelOption->getOption('productManufacturer');
//        $manufacturerSearch = array();
//        if (isset($listManufacturer["Option"]["value"]['allData']) && count($listManufacturer["Option"]["value"]['allData']) > 0) {
//            foreach ($listManufacturer["Option"]["value"]['allData'] as $cat) {
//                $manufacturerSearch = getCheckCategorySearch($cat, $manufacturerSearch, 'manufacturer');
//            }
//        }
//        if ($manufacturerSearch) {
//            $conditions['manufacturerId'] = array('$in' => $manufacturerSearch);
//        }


        $listData = $modelProduct->getPage($page, $limit, $conditions);

        $listData= checkInfoProductAPI($listData);
    }

    setVariable('listData', $listData);
}

function getShopInfoAPI($input) {
    global $modelOption;
    $listData = array();

    if (class_exists('Product')) {
        $settingFacebook = $modelOption->getOption('settingFacebook');
        $contact = $modelOption->getOption('contact');
        $infoSite = $modelOption->getOption('infoSite');

        $listData['title'] = $infoSite['Option']['value']['title'];
        $listData['domain'] = $infoSite['Option']['value']['domain'];
        $listData['key'] = $infoSite['Option']['value']['key'];
        $listData['description'] = $infoSite['Option']['value']['description'];
        $listData['address'] = $contact['Option']['value']['address'];
        $listData['email'] = $contact['Option']['value']['email'];
        $listData['fone'] = $contact['Option']['value']['fone'];
        $listData['fax'] = $contact['Option']['value']['fax'];
        $listData['idApp'] = $settingFacebook['Option']['value']['idApp'];
        $listData['linkFanpage'] = $settingFacebook['Option']['value']['linkFanpage'];
        $listData['nameFanpage'] = $settingFacebook['Option']['value']['nameFanpage'];
    }
    setVariable('listData', $listData);
}

function getAboutPageAPI($input) {
    global $modelOption;
    global $modelNotice;
    $listData = array();

    if (class_exists('Product')) {
        $data = $modelOption->getOption('mobileAppApiSettings');
        $id = $data['Option']['value']['idAboutPage'];
        $listData = $modelNotice->getNotice($id);
    }
	$listData['Notice']['content'] .= '<hr/><center>Chịu trách nhiệm nội dung: Ông Trần Ngọc Mạnh<br/>Bản quyền sản phẩm thuộc về Công ty cổ phần công nghệ số Mantan Việt Nam</center>';
    setVariable('listData', $listData['Notice']['content']);
}

function getNotificationAPI($input)
{
    $listData = array();
    $modelNotification= new Notification();

    $page = 1;
    $limit = null;
    $today= getdate();

    if(isset($input['request']->data['timeCheck']) && $input['request']->data['timeCheck']>0){
        $conditions['timePost']= array('$gte' => $input['request']->data['timeCheck']);
    }else{
        $conditions= array();
    }

    $listData = array('timeCheck'=>$today[0],'listData'=>$modelNotification->getPage($page, $limit, $conditions));

    setVariable('listData', $listData);

}

function sendCartAPI($input)
{   
    global $modelOption;
    global $smtpSite;
    global $contactSite;
    global $languageProduct;

    $listData = array();
    $listData = array('code'=>-1);
    
    if (class_exists('Product')) {
        $modelOrder= new Order();
        $modelProduct = new Product();
        $dataSend= arrayMap($input['request']->data);

        $fullname= (isset($dataSend['fullname']))?$dataSend['fullname']:'';      
        $email= (isset($dataSend['email']))?$dataSend['email']:'';      
        $phone= (isset($dataSend['phone']))?$dataSend['phone']:'';     
        $address= (isset($dataSend['address']))?$dataSend['address']:'';     
        $note= (isset($dataSend['note']))?$dataSend['note']:'';      
        $userId= (isset($dataSend['userId']))?$dataSend['userId']:'';
        $totalMoney= (isset($dataSend['totalMoney']))?(int)$dataSend['totalMoney']:0;

        $dataSend['product']= $modelProduct->getProduct($dataSend['productId']); 

        if($dataSend['product']){
            $listOrderProduct= array($dataSend['product']);

            if($fullname!='' && $phone!='' && count($listOrderProduct)>0)
            {
                

                $listProduct= array();
                foreach($listOrderProduct as $key=>$data)
                {
                    if(!isset($data['Product']['numberOrder'])) $data['Product']['numberOrder']= 1;
                    
                    if(isset($dataSend['codeDiscountInput']) && $dataSend['codeDiscountInput']!='' && in_array($dataSend['codeDiscountInput'], $data['Product']['codeDiscount']))
                    {
                        $listProduct[$data['Product']['id']]= array('id'=>$data['Product']['id'],'number'=>$data['Product']['numberOrder'],'price'=>$data['Product']['priceDiscount'],'codeDiscount'=>$dataSend['codeDiscountInput']);
                        $listOrderProduct[$key]['Product']['codeDiscountInput']= $dataSend['codeDiscountInput'];
                        $listOrderProduct[$key]['Product']['numberOrder']= $data['Product']['numberOrder'];
                        $_SESSION['codeDiscountInput']= $dataSend['codeDiscountInput'];
                    }
                    else
                    {
                        $listProduct[$data['Product']['id']]= array('id'=>$data['Product']['id'],'number'=>$data['Product']['numberOrder'],'price'=>$data['Product']['price']);
                    }
                }
                
                $modelOrder->saveOrder($fullname,$email,$phone,$address,$note,$listProduct,$userId,$totalMoney);

                // send email for user and admin
                $_SESSION['orderProducts']= $listOrderProduct;

                $from= array($contactSite['Option']['value']['email'] =>  $smtpSite['Option']['value']['show']);
                $to= array(trim($email),trim($contactSite['Option']['value']['email']));
                $cc= array();
                $bcc= array();
                $subject= '['.$smtpSite['Option']['value']['show'].'] '.$languageProduct['OrderSuccess'];
                
                $listTypeMoney= $modelOption->getOption('productTypeMoney');
                $content= getContentEmailOrderSuccess($fullname,$email,$phone,$address,$note,$listTypeMoney);

                $modelOrder->sendMail($from,$to,$cc,$bcc,$subject,$content);
                
                $listData = array('code'=>1);
            }
            else
            {
                $listData = array('code'=>0);
            }
        }
    }
    setVariable('listData', $listData);
}

function checkCodeDiscountAPI($input)
{
    global $modelOption;
    $listData = array('code'=>0,'price'=>100000000);
    $today= getdate();

    if (class_exists('Product')) {
        $modelProduct= new Product();

        if(isset($input['request']->data['idProduct'])){
            $data= $modelProduct->getProduct($input['request']->data['idProduct']);
            if(isset($data['Product']['codeDiscount']) &&  
                isset($data['Product']['dateDiscountStart']) && 
                isset($data['Product']['dateDiscountEnd']) &&
                isset($input['request']->data['codeDiscount']) &&
                $input['request']->data['codeDiscount']!='' && 
                in_array($input['request']->data['codeDiscount'], $data['Product']['codeDiscount']) && 
                $today[0]>= $data['Product']['dateDiscountStart'] && 
                $today[0]<= $data['Product']['dateDiscountEnd'])
            {
                $listData = array('code'=>1,'price'=>$data['Product']['priceDiscount']);
            }
        }
    }

    setVariable('listData', $listData);
}
?>