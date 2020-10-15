<?php
Configure::write('debug', 0);
global $urlLocal;
global $urlHomes;
global $urlPlugins;
$modelProduct= new Product();
require_once $urlLocal['urlLocalPlugin'].'exportImportData/phpExcel/PHPExcel.php';
/*$url=$urlHomes.$_POST['file'];
$url=str_replace("//", "/", $url);
$url=str_replace(":/", "://", $url);*/
//debug (dirname(__FILE__));
$dir=dirname(__FILE__);
$dir=str_replace("/app/Plugin/exportImportData", "", $dir);
$dir=$dir.$_POST['file'];
//debug ($dir);
$filename = $dir;
$inputFileType = PHPExcel_IOFactory::identify($filename);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
 
$objReader->setReadDataOnly(true);
 
/**  Load $inputFileName to a PHPExcel Object  **/
$objPHPExcel = $objReader->load("$filename");

$total_sheets=$objPHPExcel->getSheetCount();
 
$allSheetName=$objPHPExcel->getSheetNames();
$objWorksheet  = $objPHPExcel->setActiveSheetIndex(0);
$highestRow    = $objWorksheet->getHighestRow();
$highestColumn = $objWorksheet->getHighestColumn();
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
$arraydata = array();
for ($row = 2; $row <= $highestRow;++$row)
{
    for ($col = 0; $col <$highestColumnIndex;++$col)
    {
        $value=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
        $arraydata[$row-2][$col]=$value;
    }
}
function to_slug($str) {
    $str = trim(mb_strtolower($str));
    $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
    $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
    $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
    $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
    $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
    $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
    $str = preg_replace('/(đ)/', 'd', $str);
    $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
    $str = preg_replace('/([\s]+)/', '-', $str);
    return $str;
}
foreach ($arraydata as $data)
{
	$product['code']=$data[0];
	$product['title']=$data[1];
	$product['slug']=to_slug($product['title']);
	$product['price']=$data[2];
	$product['priceOther']=$data[3];
	$product['quantity']=$data[4];
	$product['images'][0]=$data[5];
	$product['description']=$data[6];
	$product['key']=$data[7];
	$product['lock']=0;
	$product['view']=0;
	$product['category']=$_POST['check_list'];

	$modelProduct->create();
	$modelProduct->saveProduct($product['title'],$product['code'],0,$product['description'],$product['key'],$product['slug'],'',0,$product['price'],$product['priceOther'],1,$product['quantity'],'',$product['category'],$product['images']);
}
$modelProduct->redirect($urlPlugins.'admin/product-product-listProduct.php');
?>