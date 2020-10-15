<?php
    $menus= array();
	$menus[0]['title']= 'Đồng bộ dữ liệu Bizman';
	
    $menus[0]['sub'][0]= array('name'=>'Đồng bộ sản phẩm','url'=>$urlPlugins.'admin/bizman-sync-syncProduct.php','permission'=>'syncProductBizman');		   
    $menus[0]['sub'][1]= array('name'=>'Đồng bộ danh mục sản phẩm','url'=>$urlPlugins.'admin/bizman-sync-syncCategory.php','permission'=>'syncCategoryBizman');
    $menus[0]['sub'][2]= array('name'=>'Danh sách kho hàng','url'=>$urlPlugins.'admin/bizman-store-listStore.php','permission'=>'listStoreBizman');
    $menus[0]['sub'][3]= array('name'=>'Cài đặt đồng bộ','url'=>$urlPlugins.'admin/bizman-sync-syncSetting.php','permission'=>'syncSettingBizman');
    addMenuAdminMantan($menus);
    
    global $settingProduct;
    global $modelOption;
	
	$settingProduct= $modelOption->getOption('settingProduct');

    function sendDataBizman($url,$data=null)
    {
	   if($data)
	   {
			$ch = curl_init( $url );
			# Setup request to send json via POST.
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			# Return response instead of printing.
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			# Send request.
			$result = curl_exec($ch);
			curl_close($ch);
			# Print response.
			return $result;
	   }
	   else
	   {
		   return file_get_contents($url);
	   }
    }

    function sendDataBizmanClientTag($url='',$data=null)
    {
    	include("curl.class.php");

		// curl \
		//     -X POST \
		//     -d "{"id":"1","content":"Hello world!","date":"2015-06-30 19:42:21"}" \
		//     "https://httpbin.org/post"

		$curl = new Curl();
		$curl->addHeader('Content-Type: application/json');
		$curl->addHeader('ClientTag: anna150916' );
		$return= $curl->post($url, $data);



		return $return;
    }
    
    function writeLogConnect($urlLocal,$function,$content)
    {
    	
    }
  
    
    // Kiểm tra giá vốn vật tư hàng hóa trên hệ thống BizMan - Add
    function CheckCostprice($productCode,$storeId='') // Error save
    {
    	$dataSend = json_encode( array(array( "productCode"=>$productCode,
											  "storeId"=>$storeId
											)
									  )
							   );
							   
	    $modelOption= new Option();
	    $ipHostBizman= $modelOption->getOption('settingProductBizman');
	    if($ipHostBizman['Option']['value']['ipHostBizman'])
		{
			$url = 'http://'.$ipHostBizman['Option']['value']['ipHostBizman'].'/ActionService.svc/CheckCostprice';
			$return= sendDataBizman($url,$dataSend);
			//writeLogConnect($urlLocal,'CheckCostprice',$return);
			return $return;
		}
    }
    
    // Lấy toàn bộ kho trên hệ thống 
    function GetAllListStore() 
    {
	    $modelOption= new Option();
	    $ipHostBizman= $modelOption->getOption('settingProductBizman');
	    //var_dump($ipHostBizman['Option']['value']['ipHostBizman']);
	    if($ipHostBizman['Option']['value']['ipHostBizman'])
		{
			$url = 'http://'.$ipHostBizman['Option']['value']['ipHostBizman'].'/ActionService.svc/GetAllListStore';
			//var_dump($url);
			$return= sendDataBizman($url);
			//writeLogConnect($urlLocal,'GetAllListStore',$return);
			//var_dump($return);
			return $return;
			
		}
    }

    // Lấy thông tin sản phẩm theo mã hàng
    function GetProductBySKU($store=array(), $code='')
    {
    	$dataSend = json_encode( array( 'KHOID' => $store, 
										'SKU' => $code
									  )
							   );
						   
	    $modelOption= new Option();
	    $ipHostBizman= $modelOption->getOption('settingProductBizman');
	    if($ipHostBizman['Option']['value']['ipHostBizman'])
		{
			$url = 'http://'.$ipHostBizman['Option']['value']['ipHostBizman'].'/ActionService.svc/GetProductBySKU';
			$return= sendDataBizman($url,$dataSend);
			//$return= sendDataBizmanClientTag($url,$dataSend);

			//writeLogConnect($urlLocal,'GetStockByStoreId',$return);
			return $return;
		}
    }

    // Lấy thông tin các sản phẩm cùng alias
    function GetProductIncludeImgByAlias($alias='')
    {
    	$dataSend = json_encode( array( 'Alias' => $alias, 
											
									  )
							   );
							   
	    $modelOption= new Option();
	    $ipHostBizman= $modelOption->getOption('settingProductBizman');
	    if($ipHostBizman['Option']['value']['ipHostBizman'])
		{
			$url = 'http://'.$ipHostBizman['Option']['value']['ipHostBizman'].'/ActionService.svc/GetProductIncludeImgByAlias';
			$return= sendDataBizman($url,$dataSend);
			//writeLogConnect($urlLocal,'GetStockByStoreId',$return);
			return $return;
		}
    }
    
    // Kiểm tra số lượng sản phẩm trong tổng kho, từng kho - Add
    function GetStockByStoreId($productCode,$storeId) // ok
    {
    	$dataSend = json_encode( array(array( 'productCode' => $productCode, 
											  'storeId' => $storeId
											)
									  )
							   );
							   
	    $modelOption= new Option();
	    $ipHostBizman= $modelOption->getOption('settingProductBizman');
	    if($ipHostBizman['Option']['value']['ipHostBizman'])
		{
			$url = 'http://'.$ipHostBizman['Option']['value']['ipHostBizman'].'/ActionService.svc/GetStockByStoreId';
			$return= sendDataBizman($url,$dataSend);
			//writeLogConnect($urlLocal,'GetStockByStoreId',$return);
			return $return;
		}
    }
    
    // Kiểm tra tổng số lượng sản phẩm trong tổng kho 
    function GetTotalStockInAllStores($productCode) 
    {
    	$dataSend = json_encode( array($productCode) );
							   
	    $modelOption= new Option();
	    $ipHostBizman= $modelOption->getOption('settingProductBizman');
	    if($ipHostBizman['Option']['value']['ipHostBizman'])
		{
			$url = 'http://'.$ipHostBizman['Option']['value']['ipHostBizman'].'/ActionService.svc/GetTotalStockInAllStores';
			$return= sendDataBizman($url,$dataSend);
			//writeLogConnect($urlLocal,'GetTotalStockInAllStores',$return);
			return $return;
		}
    }
    
    // Đẩy đơn hàng từ hệ thống website xuống hệ thống kho
    function AddOrder($dataSend)
    {			   
	    $modelOption= new Option();
	    $ipHostBizman= $modelOption->getOption('settingProductBizman');
	    if($ipHostBizman['Option']['value']['ipHostBizman'])
		{
			$url = 'http://'.$ipHostBizman['Option']['value']['ipHostBizman'].'/ActionService.svc/AddOrder';
			$return= sendDataBizman($url,$dataSend);
			//writeLogConnect($urlLocal,'AddOrder',$return);
			return $return;
		}
    }
    
    // Hàm lấy sản phẩm đang khuyến mãi trong ngày (Down-Top)
    function LoadProductByPromotionActive($Date,$KHOID)
    {
    	$dataSend = json_encode( array( "Date"=>$Date,
										"Khoid"=>$KHOID
									  )
							   );
					   
	    $modelOption= new Option();
	    $ipHostBizman= $modelOption->getOption('settingProductBizman');
	    if($ipHostBizman['Option']['value']['ipHostBizman'])
		{
			$url = 'http://'.$ipHostBizman['Option']['value']['ipHostBizman'].'/ActionService.svc/LoadProductByPromotionActive';
			$return= sendDataBizman($url,$dataSend);
			//writeLogConnect($urlLocal,'LoadProductByPromotionActive',$return);
			return $return;
		}
    }
    
    // Lay san pham duoc phan trang
    function LoadProductListPaging($Page,$PageLimit,$KHOID)
    {
    	$dataSend = json_encode( array( "Page"=>$Page,
										"PageLimit"=>$PageLimit,
										"KHOID"=>$KHOID
									  )
							   );
							   
	    $modelOption= new Option();
	    $ipHostBizman= $modelOption->getOption('settingProductBizman');
	    if($ipHostBizman['Option']['value']['ipHostBizman'])
		{
			$url = 'http://'.$ipHostBizman['Option']['value']['ipHostBizman'].'/ActionService.svc/LoadProductListPaging';
			$return= sendDataBizman($url,$dataSend);
			//writeLogConnect($urlLocal,'LoadProductListPaging',$return);
			return $return;
		}
    }
    
    // Hàm đếm tổng số sản phẩm trong hệ thống đang sử dụng (Down-Top)
    function GetCountProductActive()
    {
	    $modelOption= new Option();
	    $ipHostBizman= $modelOption->getOption('settingProductBizman');
	    if($ipHostBizman['Option']['value']['ipHostBizman'])
		{
			$url = 'http://'.$ipHostBizman['Option']['value']['ipHostBizman'].'/ActionService.svc/GetCountProductActive';
			$return= sendDataBizman($url);
			//writeLogConnect($urlLocal,'GetCountProductActive',$return);
			return $return;
		}
    }
    
    // Lay thong tin khach hang theo mobile
    function GetCustomerByMobile($mobile)
    {
	    $modelOption= new Option();
	    $ipHostBizman= $modelOption->getOption('settingProductBizman');
	    if($ipHostBizman['Option']['value']['ipHostBizman'])
		{
			$url = 'http://'.$ipHostBizman['Option']['value']['ipHostBizman'].'/ActionService.svc/GetCustomerByMobile?mobile='.$mobile;
			$return= sendDataBizman($url,$dataSend);
			//writeLogConnect($urlLocal,'GetCustomerByMobile',$return);
			return $return;
		}
    }
    
	// Lay thong tin san pham qua ID (Down-Top)
	function GetProductInfoByProductId($ProductID)
	{
		global $settingProduct;
		
		$dataSend = json_encode( array( "ProductID"=>$ProductID
									  )
							   );
							   
	    $modelOption= new Option();
		if(isset($settingProduct['Option']['value']['ipHostBizman']) && $settingProduct['Option']['value']['ipHostBizman']!=''){
			$ipHostBizman= $settingProduct;
		}else{
			$ipHostBizman= $modelOption->getOption('settingProductBizman');
		}
	    if($ipHostBizman['Option']['value']['ipHostBizman'])
		{
			$url = 'http://'.$ipHostBizman['Option']['value']['ipHostBizman'].'/ActionService.svc/GetProductInfoByProductId';
			$return= sendDataBizman($url,$dataSend);
			//writeLogConnect($urlLocal,'GetProductInfoByProductId',$return);
			return $return;
		}
	}

	// Lay danh sach danh muc san pham (Down-Top)
	function LoadAllProductCatelogy()
	{
	    $modelOption= new Option();
	    $ipHostBizman= $modelOption->getOption('settingProductBizman');
	    if($ipHostBizman['Option']['value']['ipHostBizman'])
		{
			$url = 'http://'.$ipHostBizman['Option']['value']['ipHostBizman'].'/ActionService.svc/LoadAllProductCatelogy';
			$return= sendDataBizman($url);
			//writeLogConnect($urlLocal,'LoadAllProductCatelogy',$return);
			return $return;
		}
	}
	// Dong bo hoa san pham voi web (Down-Top)
	function SyncProductWeb($Date)
	{
		$dataSend = json_encode( array( "Date"=>$Date
									  )
							   );
							   
	    $modelOption= new Option();
	    $ipHostBizman= $modelOption->getOption('settingProductBizman');
	    if($ipHostBizman['Option']['value']['ipHostBizman'])
		{
			$url = 'http://'.$ipHostBizman['Option']['value']['ipHostBizman'].'/ActionService.svc/SyncProductWeb';
			$return= sendDataBizman($url,$dataSend);
			//var_dump($dateSync);echo '<br/>';
			//var_dump($url);echo '<br/>';
			//writeLogConnect($urlLocal,'SyncProductWeb',$return);
			return $return;
		}
	}

	function SyncProductWebByAlias($Date)
	{
		$dataSend = json_encode( array( "Date"=>$Date
									  )
							   );
							   
	    $modelOption= new Option();
	    $ipHostBizman= $modelOption->getOption('settingProductBizman');
	    if($ipHostBizman['Option']['value']['ipHostBizman'])
		{
			$url = 'http://'.$ipHostBizman['Option']['value']['ipHostBizman'].'/ActionService.svc/SyncProductWebByAlias';
			$return= sendDataBizman($url,$dataSend);
			//var_dump($dateSync);echo '<br/>';
			//var_dump($url);echo '<br/>';
			//writeLogConnect($urlLocal,'SyncProductWeb',$return);
			return $return;
		}
	}
	// Check thong tin mot list san pham duoi bizman
	function checkInfoProductBizman($listData= array())
	{
		$modelOption= new Option();
	    $ipHostBizman= $modelOption->getOption('settingProductBizman');

	    if($ipHostBizman['Option']['value']['checkPrice']=='bizman'){
	    	if(count($listData)>0){
	    		$productPromotion=   LoadProductByPromotionActive(null,$ipHostBizman['Option']['value']['storeDefault']);
	    		$productPromotion= json_decode($productPromotion,true);

	    		$listProductPromotion= array();
	    		if(!empty($productPromotion)){
	    			foreach($productPromotion as $promotion){
	    				$listProductPromotion[$promotion['productId']]= $promotion;
	    			}
	    		}

	    		foreach($listData as $number=>$data){
	    			if(isset($data['Product']['idBizman'])){
		    			$dataBizman= GetProductInfoByProductId($data['Product']['idBizman']);
						$dataBizman= json_decode($dataBizman,true);

						if(count($dataBizman['PriceAndQuantityInfo'])>0){
							$totalQuantity= 0;

							if(count($dataBizman['PriceAndQuantityInfo'])>0){
								foreach($dataBizman['PriceAndQuantityInfo'] as $infoStore)
								{
									$totalQuantity += $infoStore['QUANTITY'];
									if(count($dataBizman['PriceAndQuantityInfo'])==1 ||  $infoStore['KHOID']==$ipHostBizman['Option']['value']['storeDefault'])
									{
										$listData[$number]['Product']['price']= $infoStore['PRICE'];

										if(isset($listProductPromotion[$listData[$number]['Product']['idBizman']])){
											$listData[$number]['Product']['priceDiscount']= $listProductPromotion[$listData[$number]['Product']['idBizman']]['specialPrice'];
										}
									}
								}
							}
							$listData[$number]['Product']['quantity']= $totalQuantity;
						}
					}
	    		}
	    	}
	    }

	    return $listData;
	}

	function getGUID(){
	    if (function_exists('com_create_guid')){
	        return com_create_guid();
	    }else{
	        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
	        $charid = strtoupper(md5(uniqid(rand(), true)));
	        $hyphen = chr(45);// "-"
	        $uuid = chr(123)// "{"
	            .substr($charid, 0, 8).$hyphen
	            .substr($charid, 8, 4).$hyphen
	            .substr($charid,12, 4).$hyphen
	            .substr($charid,16, 4).$hyphen
	            .substr($charid,20,12)
	            .chr(125);// "}"
	        return $uuid;
	    }
	}
?>