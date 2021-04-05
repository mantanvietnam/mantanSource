<?php
	global $modelOption;
	$listData= $modelOption->getOption('seoProduct');
	$product= (isset($listData['Option']['value']['seoPath']['product']) && $listData['Option']['value']['seoPath']['product']!='')?$listData['Option']['value']['seoPath']['product']:'product';
	$cat= (isset($listData['Option']['value']['seoPath']['cat']) && $listData['Option']['value']['seoPath']['cat']!='')?$listData['Option']['value']['seoPath']['cat']:'cat';
	$manufacturer= (isset($listData['Option']['value']['seoPath']['manufacturer']) && $listData['Option']['value']['seoPath']['manufacturer']!='')?$listData['Option']['value']['seoPath']['manufacturer']:'manufacturer';
	$cart= (isset($listData['Option']['value']['seoPath']['cart']) && $listData['Option']['value']['seoPath']['cart']!='')?$listData['Option']['value']['seoPath']['cart']:'cart';
	$login= (isset($listData['Option']['value']['seoPath']['login']) && $listData['Option']['value']['seoPath']['login']!='')?$listData['Option']['value']['seoPath']['login']:'login';
	$logout= (isset($listData['Option']['value']['seoPath']['logout']) && $listData['Option']['value']['seoPath']['logout']!='')?$listData['Option']['value']['seoPath']['logout']:'logout';
	$register= (isset($listData['Option']['value']['seoPath']['register']) && $listData['Option']['value']['seoPath']['register']!='')?$listData['Option']['value']['seoPath']['register']:'register';
	$search= (isset($listData['Option']['value']['seoPath']['search']) && $listData['Option']['value']['seoPath']['search']!='')?$listData['Option']['value']['seoPath']['search']:'search';
	$discount= (isset($listData['Option']['value']['seoPath']['discount']) && $listData['Option']['value']['seoPath']['discount']!='')?$listData['Option']['value']['seoPath']['discount']:'discount';
	$allProduct= (isset($listData['Option']['value']['seoPath']['allProduct']) && $listData['Option']['value']['seoPath']['allProduct']!='')?$listData['Option']['value']['seoPath']['allProduct']:'allProduct';
    $userInfo= (isset($listData['Option']['value']['seoPath']['userInfo']) && $listData['Option']['value']['seoPath']['userInfo']!='')?$listData['Option']['value']['seoPath']['userInfo']:'userInfo';
	$history= (isset($listData['Option']['value']['seoPath']['history']) && $listData['Option']['value']['seoPath']['history']!='')?$listData['Option']['value']['seoPath']['history']:'history';
	$routesPlugin['addCategory']= 'product/category/addCategory.php';
	$routesPlugin[$product]= 'product/view/productDetail.php';
	$routesPlugin[$cat]= 'product/view/category.php';
	$routesPlugin[$manufacturer]= 'product/view/manufacturer.php';
	$routesPlugin[$cart]= 'product/view/cart.php';
	$routesPlugin[$login]= 'product/view/login.php';
	$routesPlugin[$logout]= 'product/view/logout.php';
	$routesPlugin[$register]= 'product/view/register.php';
	$routesPlugin[$search]= 'product/view/search.php';
	$routesPlugin['createSitemap']= 'product/sitemap/createSiteMap.php';
	$routesPlugin[$discount]= 'product/view/productDiscount.php';
	$routesPlugin[$allProduct]= 'product/view/allProduct.php';
	$routesPlugin['checkLogin']= 'product/loginUser/checkLogin.php';
	$routesPlugin['saveUser']= 'product/loginUser/saveUser.php';
    $routesPlugin[$userInfo]= 'product/view/userInfo.php';
    $routesPlugin[$history]= 'product/view/history.php';

	$routesPlugin['saveOrderProduct']= 'product/order/saveOrderProduct.php';
	$routesPlugin['saveOrderProduct_addProduct']= 'product/order/saveOrderProduct_addProduct.php';
	$routesPlugin['saveOrderProduct_addOrder']= 'product/order/saveOrderProduct_addOrder.php';
	$routesPlugin['saveOrderProduct_clearCart']= 'product/order/saveOrderProduct_clearCart.php';
	$routesPlugin['saveOrderProduct_deleteProductCart']= 'product/order/saveOrderProduct_deleteProductCart.php';
	$routesPlugin['saveOrderProduct_reloadOrder']= 'product/order/saveOrderProduct_reloadOrder.php';

	$routesPlugin['syncMoneyApi']= 'product/api/syncMoneyApi.php';
	$routesPlugin['syncAdditionalAttributesApi']= 'product/api/syncAdditionalAttributesApi.php';
	$routesPlugin['syncCategoryApi']= 'product/api/syncCategoryApi.php';
	$routesPlugin['syncManufacturerApi']= 'product/api/syncManufacturerApi.php';
	$routesPlugin['syncProductApi']= 'product/api/syncProductApi.php';

	$routesPlugin['searchAjax']= 'product/view/searchAjax.php';
	$routesPlugin['searchAjaxProductOther']= 'product/product/searchAjaxProductOther.php';
	$routesPlugin['checkCodeProductAPI']= 'product/product/checkCodeProductAPI.php';
	
?>