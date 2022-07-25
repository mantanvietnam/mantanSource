<?php
	global $modelOption;
	
	$routesPlugin['register']= 'quayso/view/manager/manager/managerRegister.php';
	$routesPlugin['login']= 'quayso/view/manager/manager/managerLogin.php';
	$routesPlugin['forgetPassword']= 'quayso/view/manager/manager/managerForgetPassword.php';
	$routesPlugin['logout']= 'quayso/view/manager/manager/managerLogout.php';
	$routesPlugin['changePass']= 'quayso/view/manager/manager/managerChangePass.php';
	$routesPlugin['profile']= 'quayso/view/manager/manager/managerProfile.php';
	$routesPlugin['history']= 'quayso/view/manager/manager/managerHistory.php';

	$routesPlugin['scanQR']= 'quayso/view/manager/checkin/managerScanQR.php';
	$routesPlugin['checkin']= 'quayso/view/manager/checkin/managerCheckin.php';
	$routesPlugin['deleteCheckin']= 'quayso/view/manager/checkin/managerDeleteCheckin.php';

	$routesPlugin['addMoney']= 'quayso/view/manager/manager/managerAddMoney.php';
	$routesPlugin['processAddMoneyDone']= 'quayso/view/manager/manager/managerProcessAddMoneyDone.php';
	$routesPlugin['processAddMoneyCancel']= 'quayso/view/manager/manager/managerProcessAddMoneyCancel.php';

	$routesPlugin['campaign']= 'quayso/view/manager/campaign/managerListCampaign.php';
	$routesPlugin['addCampaign']= 'quayso/view/manager/campaign/managerAddCampaign.php';

	$routesPlugin['user']= 'quayso/view/manager/user/managerListUser.php';
	$routesPlugin['addUser']= 'quayso/view/manager/user/managerAddUser.php';
	$routesPlugin['userWin']= 'quayso/view/manager/user/managerListUserWin.php';
	$routesPlugin['deleteUser']= 'quayso/view/manager/user/managerDeleteUser.php';

	$routesPlugin['deleteUserWin']= 'quayso/view/manager/user/managerDeleteUserWin.php';
	$routesPlugin['deleteAllUserCampain']= 'quayso/view/manager/user/managerDeleteAllUserCampain.php';
	$routesPlugin['deleteAllUserWinCampain']= 'quayso/view/manager/user/managerDeleteAllUserWinCampain.php';
	$routesPlugin['deleteAllUserChecinCampain']= 'quayso/view/manager/user/managerDeleteAllUserChecinCampain.php';


	$routesPlugin['addUserAPI']= 'quayso/view/manager/user/addUserAPI.php';
	$routesPlugin['saveKQQT']= 'quayso/view/manager/user/saveKQQT.php';
	
	$routesPlugin['guide']= 'quayso/view/manager/guide/managerGuide.php';

	$routesPlugin['spin']= 'quayso/view/home/spin.php';
	$routesPlugin['error']= 'quayso/view/home/error.php';
	$routesPlugin['checkinCampaign']= 'quayso/view/home/checkinCampaign.php';
	$routesPlugin['random']= 'quayso/view/home/random.php';

	$routesPlugin['payWithMoMo']= 'quayso/view/manager/manager/managerPayWithMoMo.php';
	$routesPlugin['payWithBank']= 'quayso/view/manager/manager/managerPayWithBank.php';
	
?>