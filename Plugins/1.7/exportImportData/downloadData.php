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
	            ->setCellValue('A1', 'Mã hàng')
	            ->setCellValue('B1', 'Tên sản phẩm')
	            ->setCellValue('C1', 'Danh mục sản phẩm')
	            ->setCellValue('D1', 'Giá bán')
	            ->setCellValue('E1', 'Giá thị trường')
	            ->setCellValue('F1', 'Số lượng')
	            ->setCellValue('G1', 'Xem')
	            ->setCellValue('H1', 'Hình ảnh')
	            ->setCellValue('I1', 'Mô tả ngắn')
	            ->setCellValue('J1', 'Từ khóa')
	            ;

	// Miscellaneous glyphs, UTF-8

	
	// Lay du lieu
	global $modelOption;
	$modelProduct= new Product();
	if (isset($_POST['check_list']))
	{
		$cat=$_POST['check_list'];
		$dem=-1;
		foreach ($cat as $i)
		{
			$dem++;
			$cat[$dem]=(int) $i;
		}
		if ($cat[0]!=0)
			$conditions=array('category' =>array('$in'=> $cat));
	}
	$listData=$modelProduct->find('all',array('conditions'=>$conditions));
	//debug ($conditions);
	$listProductCategory= $modelOption->getOption('productCategory');
	$listCat=convertCategoryMantan($listProductCategory['Option']['value']['category']);

	$i = 2;
	foreach($listData as $data)
	{
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $data['Product']['code'])
		->setCellValue('B'.$i, $data['Product']['title'])
		->setCellValue('C'.$i, $listCat[$data['Product']['category'][0]]['name'])
		->setCellValue('D'.$i, $data['Product']['price'])
		->setCellValue('E'.$i, $data['Product']['priceOther'])
		->setCellValue('F'.$i, $data['Product']['quantity'])
		->setCellValue('G'.$i, $data['Product']['view'])
		->setCellValue('H'.$i, $data['Product']['images'][0])
		->setCellValue('I'.$i, $data['Product']['description'])
		->setCellValue('J'.$i, $data['Product']['key'])
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
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
?>