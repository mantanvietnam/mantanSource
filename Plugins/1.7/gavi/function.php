<?php
$menus = array();
$menus[0]['title'] = 'Quản lý Gavi';

$menus[0]['sub'][0] = array('name' => 'Danh sách nhân viên', 'url' => $urlPlugins . 'admin/gavi-admin-staff-listStaff.php','permission'=>'listStaffAdmin');
$menus[0]['sub'][1] = array('name' => 'Lịch sử hoạt động', 'url' => $urlPlugins . 'admin/gavi-admin-log-listLog.php','permission'=>'listLog');
addMenuAdminMantan($menus);

global $productBonus;
global $productPenalties;

$productBonus= 2000; //số tiền thưởng cho đại lý cha ngang cấp đại lý con
$productPenalties= 100000; // số tiền phạt trên 1 lốc hàng bị trả lại

function getListAgency()
{
	// money_product : tiền mua sản phẩm cần thiết để lên cấp
	// money_deposit : tiền đặt cọc cần thiết để lên cấp
	// money_level : tiền tối thiểu để lên cấp
	
	return array(	'1'=>array('id'=>1,'name'=>'Đại lý cấp 1','money_product'=>36000000,'money_deposit'=>5000000,'color'=>'#be5051','money_bonus'=>2000000,'money_level'=>100000000),
					'2'=>array('id'=>2,'name'=>'Đại lý cấp 2','money_product'=>16800000,'money_deposit'=>3000000,'color'=>'#9dba54','money_bonus'=>800000,'money_level'=>50000000),
					'3'=>array('id'=>3,'name'=>'Đại lý cấp 3','money_product'=>4800000,'money_deposit'=>1000000,'color'=>'#8064a1','money_bonus'=>300000,'money_level'=>30000000),
					'4'=>array('id'=>4,'name'=>'Đại lý cấp 4','money_product'=>1200000,'money_deposit'=>0,'color'=>'rgba(22, 149, 251, 0.65)','money_bonus'=>100000,'money_level'=>0),
				);
}

function getTypeExchange()
{
	return array(	'1'=>array('id'=>1,'name'=>'Đại lý nạp tiền'),
					'2'=>array('id'=>2,'name'=>'Phạt tiền do ship hàng bị trả lại'),
					'3'=>array('id'=>3,'name'=>'Đại lý rút tiền'),
					'4'=>array('id'=>4,'name'=>'Tạo mã QR'),
					'5'=>array('id'=>5,'name'=>'Thưởng giới thiệu đại lý'),
					'6'=>array('id'=>6,'name'=>'Tiền bán hàng'),
					'7'=>array('id'=>7,'name'=>'Tiền mua hàng'),
					'8'=>array('id'=>8,'name'=>'Thưởng phát triển đại lý'),
					'9'=>array('id'=>9,'name'=>'Hoàn tiền'),
					'10'=>array('id'=>10,'name'=>'Tiền giao hàng'),
					'11'=>array('id'=>10,'name'=>'Nâng cấp đại lý'),
				);
}

function getStatusOrder()
{
	return array(	'1'=>array('id'=>1,'name'=>'Đơn hàng mới'),
					'2'=>array('id'=>2,'name'=>'Đơn hàng đã xử lý thành công'),
					'3'=>array('id'=>3,'name'=>'Đơn hàng bị từ chối'),
				);
}

function getStatusShip()
{
	return array(	'1'=>array('id'=>1,'name'=>'Yêu cầu mới'),
					'2'=>array('id'=>2,'name'=>'Yêu cầu đang xử lý'),
					'3'=>array('id'=>3,'name'=>'Yêu cầu bị từ chối'),
					'4'=>array('id'=>4,'name'=>'Hàng bị trả lại'),
					'5'=>array('id'=>5,'name'=>'Yêu cầu xử lý thành công'),
				);
}

function getStatusDefault()
{
	return array(	'new'=>array('id'=>'new','name'=>'Chờ phê duyệt'),
					'done'=>array('id'=>'done','name'=>'Yêu cầu xử lý thành công'),
					'cancel'=>array('id'=>'cancel','name'=>'Yêu cầu bị hủy bỏ'),
				);
}

function getListBank()
{
	return array(	'1'=>array('id'=>1,'name'=>'Vietcombank - NH Ngoai Thuong'),
					'2'=>array('id'=>2,'name'=>'Agribank - NH Nong Nghiep va PTNT VN'),
					'3'=>array('id'=>3,'name'=>'BIDV - NH Dau Tu va Phat Trien Viet Nam'),
					'4'=>array('id'=>4,'name'=>'Techcombank - NH Ky Thuong'),
					'5'=>array('id'=>5,'name'=>'Vietinbank - NH Cong Thuong Viet Nam'),
					'6'=>array('id'=>6,'name'=>'Sacombank - NH Sai Gon Thuong Tin'),
					'7'=>array('id'=>7,'name'=>'ACB - NH A Chau'),
					'8'=>array('id'=>8,'name'=>'HSBC - NH HSBC Viet Nam'),
					'9'=>array('id'=>9,'name'=>'DongA Bank - NH Dong A'),
					'10'=>array('id'=>10,'name'=>'CITIBANK - NH CitiBank Viet Nam'),
					'11'=>array('id'=>11,'name'=>'MBBank - NH Quan Doi'),
					'12'=>array('id'=>12,'name'=>'Maritime Bank - NH Hang Hai'),
					'13'=>array('id'=>13,'name'=>'ANZ - NH ANZ Viet Nam'),
					'14'=>array('id'=>14,'name'=>'TPBank - NH Tien Phong'),
					'15'=>array('id'=>15,'name'=>'VIB - NH Quoc Te'),
					'16'=>array('id'=>16,'name'=>'Eximbank - NH Xuat Nhap Khau Viet Nam'),
					'17'=>array('id'=>17,'name'=>'Standard Chartered - NH Standard Chartered Viet Nam'),
					'18'=>array('id'=>18,'name'=>'SHB - NH Sai Gon Ha Noi'),
					'19'=>array('id'=>19,'name'=>'HDBank - NH Phat Trien TP HCM'),
					'20'=>array('id'=>20,'name'=>'SeaBank - NH Dong Nam A'),
					'21'=>array('id'=>21,'name'=>'LienVietPostBank - NH Buu Dien Lien Viet'),
					'22'=>array('id'=>22,'name'=>'ABBank - NH An Binh'),
					'23'=>array('id'=>23,'name'=>'SCB - NH Sai Gon'),
					'24'=>array('id'=>24,'name'=>'OCB - NH Phuong Dong'),
					'25'=>array('id'=>25,'name'=>'NH Taipei Fubon'),
					'26'=>array('id'=>26,'name'=>'PVcomBank - NH Dai Chung Viet Nam'),
					'27'=>array('id'=>27,'name'=>'Oceanbank - NH Dai Duong'),
					'28'=>array('id'=>28,'name'=>'PG Bank - NH Xang Dau Petrolimex'),
					'29'=>array('id'=>29,'name'=>'GP Bank - NH Dau Khi Toan Cau'),
					'30'=>array('id'=>30,'name'=>'BaoViet Bank - NH Bao Viet'),
					'31'=>array('id'=>31,'name'=>'NCB - NH Quoc Dan'),
					'32'=>array('id'=>32,'name'=>'Vietabank - NH Viet A'),
					'33'=>array('id'=>33,'name'=>'Nasbank - NH Bac A'),
					'34'=>array('id'=>34,'name'=>'NamABank - NH Nam A'),
					'35'=>array('id'=>35,'name'=>'Viet Bank - NH Viet Nam Thuong Tin'),
					'36'=>array('id'=>36,'name'=>'IVB - NH TNHH Indovina'),
					'37'=>array('id'=>37,'name'=>'Viet Capital Bank - NH Ban Viet Gia Dinh'),
					'38'=>array('id'=>38,'name'=>'Public Bank - NH Public Bank Viet Nam'),
					'39'=>array('id'=>39,'name'=>'Saigon Bank - NH Sai Gon Cong Thuong'),
					'40'=>array('id'=>40,'name'=>'KienLong Bank - NH Kien Long'),
					'41'=>array('id'=>41,'name'=>'Korea Exchange Bank'),
					'42'=>array('id'=>42,'name'=>'VRB - Ngan hang Lien Doanh Viet Nga'),
				);
}

function getListCity()
{
	return array(	
					'62'=>array('id'=>62,'name'=>'Hà Nội','gps'=>'21.025905,105.846576','bsx'=>array(29,30,31,32,33)),
					'63'=>array('id'=>63,'name'=>'TP Hồ Chí Minh','gps'=>'10.820645,106.632518','bsx'=>array(50,51,52,53,54,55,56,57,58,59)),
					'60'=>array('id'=>60,'name'=>'Đà Nẵng','gps'=>'16.053866,108.203836','bsx'=>array(43)),
					'61'=>array('id'=>61,'name'=>'Hải Phòng','gps'=>'20.843685,106.694454','bsx'=>array(15,16)),
					'59'=>array('id'=>59,'name'=>'Cần Thơ','gps'=>'10.044264,105.748773','bsx'=>array(65)),

					'1'=>array('id'=>1,'name'=>'An Giang','gps'=>'10.503183,105.119829','bsx'=>array(67)),
					'2'=>array('id'=>2,'name'=>'Bà Rịa - Vũng Tàu','gps'=>'10.563561,107.276515','bsx'=>array(72)),
					'3'=>array('id'=>3,'name'=>'Bắc Giang','gps'=>'21.362262,106.176664','bsx'=>array(13,98)),
					'4'=>array('id'=>4,'name'=>'Bắc Kạn','gps'=>'22.240912,105.819391','bsx'=>array(97)),
					'5'=>array('id'=>5,'name'=>'Bạc Liêu','gps'=>'9.291818,105.467610','bsx'=>array(94)),
					'6'=>array('id'=>6,'name'=>'Bắc Ninh','gps'=>'21.136271,106.083659','bsx'=>array(99)),
					'7'=>array('id'=>7,'name'=>'Bến Tre','gps'=>'10.137806,106.565089','bsx'=>array(71)),
					'8'=>array('id'=>8,'name'=>'Bình Định','gps'=>'14.169255,108.899803','bsx'=>array(77)),
					'9'=>array('id'=>9,'name'=>'Bình Dương','gps'=>'11.207645,106.578304','bsx'=>array(61)),
					'10'=>array('id'=>10,'name'=>'Bình Phước','gps'=>'11.680601,106.825329','bsx'=>array(93)),
					'11'=>array('id'=>11,'name'=>'Bình Thuận','gps'=>'10.947979,107.826546','bsx'=>array(86)),
					'12'=>array('id'=>12,'name'=>'Cà Mau','gps'=>'8.820449,105.084218','bsx'=>array(69)),
					'13'=>array('id'=>13,'name'=>'Cao Bằng','gps'=>'22.803639,105.711757','bsx'=>array(11)),
					'14'=>array('id'=>14,'name'=>'Đắk Lắk','gps'=>'12.865012,108.003386','bsx'=>array(47)),
					'15'=>array('id'=>15,'name'=>'Đắk Nông','gps'=>'12.107715,107.830821','bsx'=>array(48)),
					'16'=>array('id'=>16,'name'=>'Điện Biên','gps'=>'21.752904,103.101496','bsx'=>array(27)),
					'17'=>array('id'=>17,'name'=>'Đồng Nai','gps'=>'10.714318,107.005192','bsx'=>array(60)),
					'18'=>array('id'=>18,'name'=>'Đồng Tháp','gps'=>'10.581382,105.688341','bsx'=>array(66)),
					'19'=>array('id'=>19,'name'=>'Gia Lai','gps'=>'13.870961,108.282026','bsx'=>array(81)),
					'20'=>array('id'=>20,'name'=>'Hà Giang','gps'=>'22.522165,104.765151','bsx'=>array(23)),
					'21'=>array('id'=>21,'name'=>'Hà Nam','gps'=>'20.447984,105.919875','bsx'=>array(90)),
					'22'=>array('id'=>22,'name'=>'Hà Tĩnh','gps'=>'18.264984,105.696628','bsx'=>array(38)),
					'23'=>array('id'=>23,'name'=>'Hải Dương','gps'=>'20.781788,106.289502','bsx'=>array(34)),
					'24'=>array('id'=>24,'name'=>'Hậu Giang','gps'=>'9.790570,105.576663','bsx'=>array(95)),
					'25'=>array('id'=>25,'name'=>'Hòa Bình','gps'=>'20.730707,105.474031','bsx'=>array(28)),
					'26'=>array('id'=>26,'name'=>'Hưng Yên','gps'=>'20.833808,106.010205','bsx'=>array(89)),
					'27'=>array('id'=>27,'name'=>'Khánh Hòa','gps'=>'12.307491,108.871089','bsx'=>array(79)),
					'28'=>array('id'=>28,'name'=>'Kiên Giang','gps'=>'10.009664,105.197401','bsx'=>array(68)),
					'29'=>array('id'=>29,'name'=>'Kon Tum','gps'=>'14.313554,107.920630','bsx'=>array(82)),
					'30'=>array('id'=>30,'name'=>'Lai Châu','gps'=>'22.324320,102.843735','bsx'=>array(25)),
					'31'=>array('id'=>31,'name'=>'Lâm Đồng','gps'=>'11.641015,107.497746','bsx'=>array(49)),
					'32'=>array('id'=>32,'name'=>'Lạng Sơn','gps'=>'21.820741,106.547897','bsx'=>array(12)),
					'33'=>array('id'=>33,'name'=>'Lào Cai','gps'=>'22.513893,103.856868','bsx'=>array(24)),
					'34'=>array('id'=>34,'name'=>'Long An','gps'=>'10.695005,105.960820','bsx'=>array(62)),
					'35'=>array('id'=>35,'name'=>'Nam Định','gps'=>'20.413892,106.162605','bsx'=>array(18)),
					'36'=>array('id'=>36,'name'=>'Nghệ An','gps'=>'19.395257,104.889498','bsx'=>array(37)),
					'37'=>array('id'=>37,'name'=>'Ninh Bình','gps'=>'20.247371,105.970816','bsx'=>array(35)),
					'38'=>array('id'=>38,'name'=>'Ninh Thuận','gps'=>'11.708233,108.886415','bsx'=>array(85)),
					'39'=>array('id'=>39,'name'=>'Phú Thọ','gps'=>'21.307744,105.125561','bsx'=>array(19)),
					'40'=>array('id'=>40,'name'=>'Quảng Bình','gps'=>'17.650996,106.225225','bsx'=>array(73)),
					'41'=>array('id'=>41,'name'=>'Quảng Nam','gps'=>'15.582603,107.985250','bsx'=>array(92)),
					'42'=>array('id'=>42,'name'=>'Quảng Ngãi','gps'=>'15.033132,108.631560','bsx'=>array(76)),
					'43'=>array('id'=>43,'name'=>'Quảng Ninh','gps'=>'21.151562,107.203928','bsx'=>array(14)),
					'44'=>array('id'=>44,'name'=>'Quảng Trị','gps'=>'16.725876,107.103291','bsx'=>array(74)),
					'45'=>array('id'=>45,'name'=>'Sóc Trăng','gps'=>'9.605473,105.973519','bsx'=>array(83)),
					'46'=>array('id'=>46,'name'=>'Sơn La','gps'=>'9.600734,105.978154','bsx'=>array(26)),
					'47'=>array('id'=>47,'name'=>'Tây Ninh','gps'=>'11.357658,106.130780','bsx'=>array(70)),
					'48'=>array('id'=>48,'name'=>'Thái Bình','gps'=>'20.506917,106.374343','bsx'=>array(17)),
					'49'=>array('id'=>49,'name'=>'Thái Nguyên','gps'=>'21.587135,105.824038','bsx'=>array(20)),
					'50'=>array('id'=>50,'name'=>'Thanh Hóa','gps'=>'20.091208,105.301704','bsx'=>array(36)),
					'51'=>array('id'=>51,'name'=>'Thừa Thiên Huế','gps'=>'16.344361,107.581729','bsx'=>array(75)),
					'52'=>array('id'=>52,'name'=>'Tiền Giang','gps'=>'10.438860,106.253686','bsx'=>array(63)),
					'53'=>array('id'=>53,'name'=>'Trà Vinh','gps'=>'9.934929,106.336861','bsx'=>array(84)),
					'54'=>array('id'=>54,'name'=>'Tuyên Quang','gps'=>'22.058060,105.244858','bsx'=>array(22)),
					'55'=>array('id'=>55,'name'=>'Vĩnh Long','gps'=>'10.244966,105.958561','bsx'=>array(64)),
					'56'=>array('id'=>56,'name'=>'Vĩnh Phúc','gps'=>'21.301371,105.591167','bsx'=>array(88)),
					'57'=>array('id'=>57,'name'=>'Yên Bái','gps'=>'21.718615,104.929472','bsx'=>array(21)),
					'58'=>array('id'=>58,'name'=>'Phú Yên','gps'=>'13.096341,109.292911','bsx'=>array(78)),
		);
}

function getTreeAgency($listAgency=array()){
	$modelAgency= new Agency();

	if(!empty($listAgency)){
		foreach($listAgency as $key=>$agency){
			$conditions= array('idAgencyFather'=>$agency['Agency']['id'],'status'=>'active','fullName'=>array('$ne'=>''));
			if(!empty($_GET['code'])){
                $conditions['code']= strtoupper($_GET['code']);
            }

            if(!empty($_GET['level'])){
                $conditions['level']= (int) $_GET['level'];
            }
           
			$subAgency= $modelAgency->find('all',array('fields'=>array('fullName','phone','code','idAgencyFather','level','dateStart','avatar'),'conditions'=>$conditions));

			$listAgency[$key]['Agency']['sub']= getTreeAgency($subAgency);
		}
	}

	return $listAgency;
}

function getListPermissionAgency()
{
	return array(	array(	'name'=>'Quản lý sản phẩm',
							'sub'=>array(	array(	'name'=>'Danh sách sản phẩm',
													'permission'=>'listProduct'
											),
											array(	'name'=>'Thêm, sửa sản phẩm',
													'permission'=>'addProduct'

											),
											array(	'name'=>'Xóa sản phẩm',
													'permission'=>'deleteProduct'

											),
										)
					),
					array(	'name'=>'Quản lý danh mục sản phẩm',
							'sub'=>array(	array(	'name'=>'Danh sách danh mục sản phẩm',
													'permission'=>'listCategory'
											),
											array(	'name'=>'Thêm, sửa danh mục sản phẩm',
													'permission'=>'addCategory'

											),
											array(	'name'=>'Xóa danh mục sản phẩm',
													'permission'=>'deleteCategory'

											),
										)
					),
					array(	'name'=>'Quản lý đại lý',
							'sub'=>array(	array(	'name'=>'Danh sách đại lý',
													'permission'=>'listAgency'
											),
											array(	'name'=>'Thêm mới đại lý',
													'permission'=>'addAgency'

											),
											array(	'name'=>'Sửa thông tin đại lý',
													'permission'=>'editAgency'

											),
											array(	'name'=>'Khóa tài khoản đại lý',
													'permission'=>'lockAgency'

											),
											array(	'name'=>'Điều chuyển đại lý',
													'permission'=>'changeAgency'

											),
											array(	'name'=>'Xem hàng tồn kho của đại lý',
													'permission'=>'viewWarehouseAgencyAdmin'

											),
											array(	'name'=>'Xem doanh thu của đại lý',
													'permission'=>'viewRevenueAgencyAdmin'

											),
											array(	'name'=>'Xem ví tiền, duyệt tiền đại lý',
													'permission'=>'viewWalletAgencyAdmin'

											),
											array(	'name'=>'Xem lịch sử điều chuyển đại lý',
													'permission'=>'viewHistoryAgencyAdmin'

											),
											array(	'name'=>'Xem danh sách yêu cầu nâng cấp đại lý',
													'permission'=>'requestUpdateLevel'

											),
										)
					),
					array(	'name'=>'Quản lý giao dịch',
							'sub'=>array(	array(	'name'=>'Xem lịch sử giao dịch',
													'permission'=>'historyExchange'
											),
											array(	'name'=>'Xem danh sách yêu cầu rút tiền',
													'permission'=>'drawMoney'

											),
											array(	'name'=>'Xử lý yêu cầu rút tiền',
													'permission'=>'updateRequestPay'

											),
											array(	'name'=>'Xem thông báo nạp tiền',
													'permission'=>'notificationPay'

											),
											array(	'name'=>'Xử lý nạp tiền tự động',
													'permission'=>'activeNotificationPay'

											),
											array(	'name'=>'Từ chối yêu cầu rút tiền',
													'permission'=>'hideNotificationPay'

											),
										)
					),
					array(	'name'=>'Quản lý kho hàng',
							'sub'=>array(	array(	'name'=>'Xem danh sách kho hàng',
													'permission'=>'listWarehouse'
											),
											array(	'name'=>'Thêm, sửa kho hàng',
													'permission'=>'addWarehouse'

											),
											array(	'name'=>'Xóa kho hàng',
													'permission'=>'deleteWarehouse'

											),
											array(	'name'=>'Xem số lượng hàng hóa trong kho',
													'permission'=>'viewWarehouse'

											),
											array(	'name'=>'Thêm hàng vào kho',
													'permission'=>'addProductToWarehouse'

											),
											array(	'name'=>'Xem danh sách đại lý ký gửi hàng trong kho',
													'permission'=>'viewDepositWarehouse'

											),
										)
					),
					array(	'name'=>'Quản lý đơn hàng',
							'sub'=>array(	array(	'name'=>'Xem danh sách đơn hàng',
													'permission'=>'listOrderAdmin'
											),
											array(	'name'=>'Duyệt đơn bán hàng',
													'permission'=>'activeOrderAdmin'

											),
											array(	'name'=>'Từ chối đơn bán hàng',
													'permission'=>'cancelOrderAdmin'

											),
										)
					),
					array(	'name'=>'Quản lý đơn vận chuyển',
							'sub'=>array(	array(	'name'=>'Xem danh sách đơn vận chuyển',
													'permission'=>'listShipAdmin'
											),
											array(	'name'=>'Xem yêu cầu và xử lý đơn bán hàng',
													'permission'=>'viewShipAdmin'

											),
										)
					),
					array(	'name'=>'Quản lý hộp thư',
							'sub'=>array(	array(	'name'=>'Xem danh sách hộp thư đi',
													'permission'=>'listMail'
											),
											array(	'name'=>'Gửi thư thông báo',
													'permission'=>'sendMail'

											),
											array(	'name'=>'Xem nội dung thư',
													'permission'=>'viewMail'

											),
										)
					),
				);
}

function getLevelAgencyFather($levelNew,$idAgencyFather='')
{
	$modelAgency= new Agency();
	if(!empty($idAgencyFather)){
		$agencyFather= $modelAgency->getAgency($idAgencyFather);
		if($levelNew<$agencyFather['Agency']['level']){
			return getLevelAgencyFather($levelNew,$agencyFather['Agency']['idAgencyFather']);
		}else{
			return $idAgencyFather;
		}
	}else{
		return '';
	}
}

function getIdAgencyFatherOrder($levelNew,$idAgencyFather='')
{
	$modelAgency= new Agency();
	if(!empty($idAgencyFather)){
		$agencyFather= $modelAgency->getAgency($idAgencyFather);
		if($levelNew==$agencyFather['Agency']['level']){
			return getIdAgencyFatherOrder($levelNew,$agencyFather['Agency']['idAgencyFather']);
		}else{
			return $idAgencyFather;
		}
	}else{
		return '';
	}
}

function convert_number_to_words($number) 
{
 
    $hyphen      = ' ';
    $conjunction = '  ';
    $separator   = ' ';
    $negative    = 'âm ';
    $decimal     = ' phẩy ';
    $dictionary  = array(
    0                   => 'Không',
    1                   => 'Một',
    2                   => 'Hai',
    3                   => 'Ba',
    4                   => 'Bốn',
    5                   => 'Năm',
    6                   => 'Sáu',
    7                   => 'Bảy',
    8                   => 'Tám',
    9                   => 'Chín',
    10                  => 'Mười',
    11                  => 'Mười một',
    12                  => 'Mười hai',
    13                  => 'Mười ba',
    14                  => 'Mười bốn',
    15                  => 'Mười năm',
    16                  => 'Mười sáu',
    17                  => 'Mười bảy',
    18                  => 'Mười tám',
    19                  => 'Mười chín',
    20                  => 'Hai mươi',
    30                  => 'Ba mươi',
    40                  => 'Bốn mươi',
    50                  => 'Năm mươi',
    60                  => 'Sáu mươi',
    70                  => 'Bảy mươi',
    80                  => 'Tám mươi',
    90                  => 'Chín mươi',
    100                 => 'trăm',
    1000                => 'nghìn',
    1000000             => 'triệu',
    1000000000          => 'tỷ',
    1000000000000       => 'nghìn tỷ',
    1000000000000000    => 'nghìn triệu triệu',
    1000000000000000000 => 'tỷ tỷ'
    );
     
    if (!is_numeric($number)) {
    return false;
    }
     
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
    // overflow
    trigger_error(
    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
    E_USER_WARNING
    );
    return false;
    }
     
    if ($number < 0) {
    return $negative . convert_number_to_words(abs($number));
    }
     
    $string = $fraction = null;
     
    if (strpos($number, '.') !== false) {
    list($number, $fraction) = explode('.', $number);
    }
     
    switch (true) {
    case $number < 21:
    $string = $dictionary[$number];
    break;
    case $number < 100:
    $tens   = ((int) ($number / 10)) * 10;
    $units  = $number % 10;
    $string = $dictionary[$tens];
    if ($units) {
    $string .= $hyphen . $dictionary[$units];
    }
    break;
    case $number < 1000:
    $hundreds  = $number / 100;
    $remainder = $number % 100;
    $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
    if ($remainder) {
    $string .= $conjunction . convert_number_to_words($remainder);
    }
    break;
    default:
    $baseUnit = pow(1000, floor(log($number, 1000)));
    $numBaseUnits = (int) ($number / $baseUnit);
    $remainder = $number % $baseUnit;
    $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
    if ($remainder) {
    $string .= $remainder < 100 ? $conjunction : $separator;
    $string .= convert_number_to_words($remainder);
    }
    break;
    }
     
    if (null !== $fraction && is_numeric($fraction)) {
    $string .= $decimal;
    $words = array();
    foreach (str_split((string) $fraction) as $number) {
    $words[] = $dictionary[$number];
    }
    $string .= implode(' ', $words);
    }
     
    return $string;
}

?>