<?php
	Configure::write('debug', 0);
	//error_reporting(E_ALL);
	//ini_set('display_errors', TRUE);
	//ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Asia/Saigon');

	if (PHP_SAPI == 'cli')
		die('This example should only be run from a Web Browser');

	/** Include PHPExcel */
	global $urlLocal;
	require_once $urlLocal['urlLocalPlugin'].'exportImportData/phpExcel/PHPExcel.php';


	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Thời gian')
	            ->setCellValue('B1', 'Khách hàng')
	            ->setCellValue('C1', 'Số điện thoại')
	            ->setCellValue('D1', 'Email')
	            ->setCellValue('E1', 'Địa chỉ')
	            ->setCellValue('F1', 'Ghi chú')
	            ->setCellValue('G1', 'Tổng tiền')
	            ->setCellValue('H1', 'Sản phẩm')
	            ;

	// Miscellaneous glyphs, UTF-8

	
	// Lay du lieu
	global $modelOption;
	$modelProduct= new Product();
	$modelOrder= new Order();
	$conditions=array('lock' =>(int) $_POST['lock']);
	$listData=$modelOrder->find('all',array('conditions'=>$conditions));
	//debug ($listData);
	$i = 2;
	foreach($listData as $data)
	{
		$sp='';
		foreach ($data['Order']['listProduct'] as $productOrder) {
			$product=$modelProduct->getProduct($productOrder['id']);
			$sp=$sp.'Sản phẩm: '.$product['Product']['title'].' - Số lượng: '.$productOrder['number'].' - Thành tiền: '.$productOrder['price'].'. ';
		}
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, date('d-m-Y h:i:s', $data['Order']['created']->sec))
		->setCellValue('B'.$i, $data['Order']['fullname'])
		->setCellValue('C'.$i, $data['Order']['phone'])
		->setCellValue('D'.$i, $data['Order']['email'])
		->setCellValue('E'.$i, $data['Order']['address'])
		->setCellValue('F'.$i, $data['Order']['note'])
		->setCellValue('G'.$i, $data['Order']['totalMoney'])
		->setCellValue('H'.$i, $sp)
		;
		$i++;
	}
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('VKO');


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);


	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="Export.xls"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
?>