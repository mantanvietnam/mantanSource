<?php
	global $routesPlugin;
	// Admin
	$routesPlugin['admin']= 'gavi/view/admin/admin.php';
	$routesPlugin['logout']= 'gavi/view/admin/logout.php';
	$routesPlugin['infoStaff']= 'gavi/view/admin/infoStaff.php';
	$routesPlugin['changePassStaff']= 'gavi/view/admin/changePassStaff.php';
	$routesPlugin['dashboard']= 'gavi/view/admin/dashboard.php';
	$routesPlugin['forgetPassStaff']= 'gavi/view/admin/forgetPassStaff.php';
	$routesPlugin['forgetPassStaffProcess']= 'gavi/view/admin/forgetPassStaffProcess.php';

	$routesPlugin['listCategory']= 'gavi/view/admin/listCategory.php';
	$routesPlugin['addCategory']= 'gavi/view/admin/addCategory.php';
	$routesPlugin['deleteCategory']= 'gavi/view/admin/deleteCategory.php';

	$routesPlugin['listProduct']= 'gavi/view/admin/listProduct.php';
	$routesPlugin['addProduct']= 'gavi/view/admin/addProduct.php';
	$routesPlugin['deleteProduct']= 'gavi/view/admin/deleteProduct.php';
	
	$routesPlugin['listWarehouse']= 'gavi/view/admin/listWarehouse.php';
	$routesPlugin['addWarehouse']= 'gavi/view/admin/addWarehouse.php';
	$routesPlugin['deleteWarehouse']= 'gavi/view/admin/deleteWarehouse.php';
	$routesPlugin['viewWarehouse']= 'gavi/view/admin/viewWarehouse.php';
	$routesPlugin['addProductToWarehouse']= 'gavi/view/admin/addProductToWarehouse.php';
	$routesPlugin['deleteProductToWarehouse']= 'gavi/view/admin/deleteProductToWarehouse.php';
	
	$routesPlugin['listAgency']= 'gavi/view/admin/listAgency.php';
	$routesPlugin['addAgency']= 'gavi/view/admin/addAgency.php';
	$routesPlugin['editAgency']= 'gavi/view/admin/editAgency.php';
	$routesPlugin['getAgencyAPI']= 'gavi/view/admin/getAgencyAPI.php';
	$routesPlugin['lockAgency']= 'gavi/view/admin/lockAgency.php';
	$routesPlugin['changeAgency']= 'gavi/view/admin/changeAgency.php';
	
	$routesPlugin['viewWarehouseAgencyAdmin']= 'gavi/view/admin/viewWarehouseAgencyAdmin.php';
	$routesPlugin['viewRevenueAgencyAdmin']= 'gavi/view/admin/viewRevenueAgencyAdmin.php';
	$routesPlugin['viewWalletAgencyAdmin']= 'gavi/view/admin/viewWalletAgencyAdmin.php';
	$routesPlugin['viewHistoryAgencyAdmin']= 'gavi/view/admin/viewHistoryAgencyAdmin.php';

	$routesPlugin['notificationPay']= 'gavi/view/admin/notificationPay.php';
	$routesPlugin['hideNotificationPay']= 'gavi/view/admin/hideNotificationPay.php';
	$routesPlugin['addMoneyAgency']= 'gavi/view/admin/addMoneyAgency.php';
	$routesPlugin['historyExchange']= 'gavi/view/admin/historyExchange.php';
	$routesPlugin['drawMoney']= 'gavi/view/admin/drawMoney.php';
	$routesPlugin['updateRequestPay']= 'gavi/view/admin/updateRequestPay.php';
	$routesPlugin['activeNotificationPay']= 'gavi/view/admin/activeNotificationPay.php';

	$routesPlugin['listOrderAdmin']= 'gavi/view/admin/listOrderAdmin.php';
	$routesPlugin['cancelOrderAdmin']= 'gavi/view/admin/cancelOrderAdmin.php';
	$routesPlugin['activeOrderAdmin']= 'gavi/view/admin/activeOrderAdmin.php';
	$routesPlugin['printOrderAdmin']= 'gavi/view/admin/printOrderAdmin.php';
	
	$routesPlugin['listShipAdmin']= 'gavi/view/admin/listShipAdmin.php';
	$routesPlugin['viewShipAdmin']= 'gavi/view/admin/viewShipAdmin.php';
	
	$routesPlugin['listMail']= 'gavi/view/admin/listMail.php';
	$routesPlugin['sendMail']= 'gavi/view/admin/sendMail.php';
	$routesPlugin['viewMail']= 'gavi/view/admin/viewMail.php';
	
	$routesPlugin['changeMoneyAgencyAdmin']= 'gavi/view/admin/changeMoneyAgencyAdmin.php';

	$routesPlugin['listStaffAgency']= 'gavi/view/admin/listStaffAgency.php';
	$routesPlugin['addStaffAgency']= 'gavi/view/admin/addStaffAgency.php';
	
	$routesPlugin['searchAgencyAjax']= 'gavi/view/admin/searchAgencyAjax.php';
	
	$routesPlugin['requestUpdateLevel']= 'gavi/view/admin/requestUpdateLevel.php';
	$routesPlugin['activeRequestUpdateLevel']= 'gavi/view/admin/activeRequestUpdateLevel.php';
	$routesPlugin['cancelRequestUpdateLevel']= 'gavi/view/admin/cancelRequestUpdateLevel.php';

	// Agency
	$routesPlugin['login']= 'gavi/view/agency/login.php';
	$routesPlugin['dashboardAgency']= 'gavi/view/agency/dashboardAgency.php';
	$routesPlugin['logoutAgency']= 'gavi/view/agency/logoutAgency.php';
	
	$routesPlugin['wallet']= 'gavi/view/agency/wallet.php';
	$routesPlugin['walletAddMoney']= 'gavi/view/agency/walletAddMoney.php';
	$routesPlugin['walletNotification']= 'gavi/view/agency/walletNotification.php';
	$routesPlugin['pay']= 'gavi/view/agency/pay.php';
	$routesPlugin['listPay']= 'gavi/view/agency/listPay.php';
	$routesPlugin['deletePay']= 'gavi/view/agency/deletePay.php';
	$routesPlugin['walletHistory']= 'gavi/view/agency/walletHistory.php';
	$routesPlugin['historyDivineStore']= 'gavi/view/agency/historyDivineStore.php';
	
	$routesPlugin['listOrderBuy']= 'gavi/view/agency/listOrderBuy.php';
	$routesPlugin['addOrder']= 'gavi/view/agency/addOrder.php';
	$routesPlugin['cancelOrderAgency']= 'gavi/view/agency/cancelOrderAgency.php';
	$routesPlugin['viewWarehouseAgency']= 'gavi/view/agency/viewWarehouseAgency.php';

	$routesPlugin['addShip']= 'gavi/view/agency/addShip.php';
	$routesPlugin['listShip']= 'gavi/view/agency/listShip.php';
	$routesPlugin['viewShipAgency']= 'gavi/view/agency/viewShipAgency.php';
	$routesPlugin['deleteShipAgency']= 'gavi/view/agency/deleteShipAgency.php';
	
	$routesPlugin['listOrderSell']= 'gavi/view/agency/listOrderSell.php';
	$routesPlugin['refuseOrderAgency']= 'gavi/view/agency/refuseOrderAgency.php';
	$routesPlugin['activeOrderAgency']= 'gavi/view/agency/activeOrderAgency.php';

	$routesPlugin['agency']= 'gavi/view/agency/agency.php';
	$routesPlugin['detailAgency']= 'gavi/view/agency/detailAgency.php';
	$routesPlugin['agencySub']= 'gavi/view/agency/agencySub.php';
	
	$routesPlugin['qrcode']= 'gavi/view/agency/qrcode.php';
	$routesPlugin['createQR']= 'gavi/view/agency/createQR.php';
	$routesPlugin['activeQRCode']= 'gavi/view/agency/activeQRCode.php';
	$routesPlugin['cancelQRCodeAgency']= 'gavi/view/agency/cancelQRCodeAgency.php';
	
	$routesPlugin['createAgency']= 'gavi/view/agency/createAgency.php';

	$routesPlugin['account']= 'gavi/view/agency/account.php';
	$routesPlugin['profile']= 'gavi/view/agency/profile.php';
	$routesPlugin['address']= 'gavi/view/agency/address.php';
	$routesPlugin['bank']= 'gavi/view/agency/bank.php';
	$routesPlugin['changePassword']= 'gavi/view/agency/changePassword.php';
	
	$routesPlugin['revenue']= 'gavi/view/agency/revenue.php';
	
	$routesPlugin['shield']= 'gavi/view/agency/shield.php';
	
	$routesPlugin['listEmailAgency']= 'gavi/view/agency/listEmailAgency.php';
	$routesPlugin['viewEmailAgency']= 'gavi/view/agency/viewEmailAgency.php';
	$routesPlugin['addEmailAgency']= 'gavi/view/agency/addEmailAgency.php';
	
	$routesPlugin['forgetPassAgency']= 'gavi/view/agency/forgetPassAgency.php';
	$routesPlugin['forgetPassAgencyProcess']= 'gavi/view/agency/forgetPassAgencyProcess.php';
	
	$routesPlugin['saveRequestLevel']= 'gavi/view/agency/saveRequestLevel.php';
?>