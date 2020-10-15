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

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'STT')
	            ->setCellValue('B1', 'Tài khoản')
	            ->setCellValue('C1', 'Họ và tên')
	            ->setCellValue('D1', 'Email')
	            ->setCellValue('E1', 'Điện thoại')
	            ->setCellValue('F1', 'Địa chỉ')
	            ;
$objPHPExcel->getActiveSheet()->getStyle("A1:F1")->getFont()->setBold(true);
	// Miscellaneous glyphs, UTF-8

	
	// Lay du lieu
	$modelUser= new User();
	$listData= $modelUser->find('all');

	$i = 2;
	$dem=0;
	foreach($listData as $data)
	{
		$dem++;
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $dem)
		->setCellValueExplicit('B'.$i, (string) $data['User']['user'],PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValue('C'.$i, $data['User']['fullname'])
		->setCellValue('D'.$i, $data['User']['email'])
		->setCellValueExplicit('E'.$i, (string) $data['User']['phone'],PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValue('F'.$i, $data['User']['address'])
		;
		$i++;
	}
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Mantan');


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);


	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="ExportUser.xls"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
?>