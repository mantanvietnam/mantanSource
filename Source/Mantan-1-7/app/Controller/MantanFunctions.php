<?php
session_name('CAKEPHP');
session_start(); 
global $checkMantanHeader;
global $userAdmins;
global $modelOption;
global $modelNotice;
global $modelAlbum;
global $modelAdmin;
global $modelVideo;
global $modelUser;
global $urlAdmins;
global $urlOptions;
global $urlNotices;
global $urlAlbums;
global $urlPlugins;
global $urlVideos;
global $urlUsers;
global $urlHomes;
global $urlNow;
global $urlThemeActive;
global $urlLocalThemeActive;
global $urlLocal;
global $webRoot;
global $infoSite;
global $contactSite;
global $smtpSite;
global $routesPlugin;
global $routesTheme;
global $metaTitleMantan;
global $metaKeywordsMantan;
global $metaDescriptionMantan;
global $metaImageMantan;
global $isHome;
global $isCategory;
global $isPost;
global $isPage;
global $isSearch;
global $isPlugin;
global $isRequestPost;
global $isRequestPut;
global $isRequestGet;
global $isRequestAjax;
global $hookFunctionMantan;
global $hookMenuAdminMantan;
global $hookMenusAppearanceMantan;
global $tmpVariable;
global $categoryNotice;
global $infoNotice;
global $infoMantanSource;
global $variableGlobal;
global $dataInput;

$checkMantanHeader= false;
$userAdmins= null;
$modelOption= null;
$modelNotice= null;
$modelAlbum= null;
$modelAdmin= null;
$modelVideo= null;
$modelUser= null;
$urlAdmins= null;
$urlOptions= null;
$urlNotices= null;
$urlAlbums= null;
$urlPlugins= null;
$urlVideos= null;
$urlUsers= null;
$urlHomes= null;	
$urlNow= null;
$urlThemeActive= null;
$urlLocalThemeActive= null;
$urlLocal= null;
$webRoot= null;
$infoSite= null;
$contactSite= null;
$smtpSite= null;
$routesPlugin= null;	
$routesTheme= null;
$metaTitleMantan= null;
$metaKeywordsMantan= null;	
$metaDescriptionMantan= null;	
$metaImageMantan= '';	
$isHome= false;
$isCategory= false;
$isPost= false;
$isPage= false;
$isSearch= false;
$isPlugin= false;
$isRequestPost= false;
$isRequestPut= false;
$isRequestGet= false;
$isRequestAjax= false;
$hookFunctionMantan= array();
$hookMenuAdminMantan= array();
$hookMenusAppearanceMantan= array();
$tmpVariable= array();
$categoryNotice= array();
$infoNotice= array();
$infoMantanSource= null;
$dataInput= array();

$variableGlobal= array('modelUser','urlUsers','routesTheme','smtpSite','dataInput','checkMantanHeader', 'userAdmins', 'modelOption', 'modelNotice', 'modelAlbum', 'modelAdmin', 'modelVideo', 'urlAdmins', 'urlOptions', 'urlNotices', 'urlAlbums', 'urlPlugins', 'urlVideos', 'urlHomes', 'urlNow', 'urlThemeActive', 'urlLocalThemeActive', 'urlLocal', 'webRoot', 'infoSite', 'contactSite', 'routesPlugin', 'metaTitleMantan', 'metaKeywordsMantan', 'metaDescriptionMantan', 'metaImageMantan', 'isHome', 'isCategory', 'isPost', 'isPage', 'isSearch', 'isPlugin', 'isRequestPost', 'isRequestPut', 'isRequestGet', 'isRequestAjax', 'hookFunctionMantan', 'hookMenuAdminMantan', 'hookMenusAppearanceMantan', 'tmpVariable', 'categoryNotice', 'infoNotice', 'infoMantanSource');
 
if (!function_exists('gd_info')) {
     echo ' [ERROR] GD extension is NOT enabled.';die;
}

// Admins
function checkAdminLogin()
{
	return isset($_SESSION['infoAdminLogin']);
}

function addMenuAdminMantan($menus= array())
{
	global $urlNow;
	global $hookFunctionMantan;
	global $hookMenuAdminMantan;
	
	if(isset($hookFunctionMantan['addMenuAdminMantan']))
	{
		$hookFunctionMantan['addMenuAdminMantan']($menus);
	}else{
		if(!is_array($hookMenuAdminMantan)) $hookMenuAdminMantan= array();
		$hookMenuAdminMantan= array_merge($hookMenuAdminMantan, $menus); 
	}
	
}   

// System	
function arrayMap($array, $call='htmlspecialchars')
{
	if (is_array($array)) {
		foreach ($array as $key => &$value) {
			if (is_array($value)) {
				$value = arrayMap($value, $call) ;
			} elseif (is_object($value)) {
				$value = $value ;
			} else {
				foreach (explode(',', $call) as $function) {
					$exFun = explode('|', $function);
					if (isset($exFun[1])){
						if($exFun[1]($value)){
							$value = $exFun[0]($value) ;
						}else{
							$value = $value ;
						}
					}else{
						$value = $function($value) ;
					}
				}
			}
		}
	} else {
		foreach (explode(',', $call) as $function) {
			$array = $function($array) ;
		}
	}
	return $array ;
}

function replaceFunction($oldFunction,$newFunction)
{
	global $hookFunctionMantan;
	$hookFunctionMantan[$oldFunction]= $newFunction;
}

function setVariable($key,$value)
{
	global $tmpVariable;
	$tmpVariable[$key]= $value;
}
		
function mantan_header()
{
	global $checkMantanHeader;
	global $infoMantanSource;
	global $infoSite;
	$checkMantanHeader= true;
	if(!isset($infoMantanSource['verName'])) $infoMantanSource['verName']= 'v1.6';
	echo '  <meta name="generator" content="Mantan '.$infoMantanSource['verName'].'" />
			<meta name="application-name" content="Mantan '.$infoMantanSource['verName'].'">
			<meta name="Publisher" CONTENT="Mantan '.$infoMantanSource['verName'].'">
	'.@$infoSite['Option']['value']['embedScript'];
}	

function showErrorMantanHeader()
{
	global $checkMantanHeader;
	if(!$checkMantanHeader)
	{
		echo '<script type="text/javascript">alert("Inserts <?php mantan_header();?> before the head");</script>';
	}
}

function getHeader()
{
	global $variableGlobal;
	
	foreach($variableGlobal as $variable){
		global $$variable;
	}
	
	include($urlLocalThemeActive.'header.php');
}

function getFooter()
{
	global $variableGlobal;
	
	foreach($variableGlobal as $variable){
		global $$variable;
	}
	
	include($urlLocalThemeActive.'footer.php');
}

function getSidebar()
{	
	global $variableGlobal;
	
	foreach($variableGlobal as $variable){
		global $$variable;
	}
	
	include($urlLocalThemeActive.'sidebar.php');
}

function getFileTheme($file)
{	
	global $variableGlobal;
	
	foreach($variableGlobal as $variable){
		global $$variable;
	}
	
	include($urlLocalThemeActive.$file);
}

// Notices
function getListNoticeCategory()
{
	global $modelOption;
	$categoryNotice= $modelOption->getOption('categoryNotice');
	
	if(!empty($categoryNotice['Option']['value']['category'])){
		return $categoryNotice['Option']['value']['category'];
	}
	
	return array();
}

function changeNoticeCategoryToList($category,$parent=0)
{
	foreach($category as $key=>$cat)
    {
    	$category[$key]= array  ( 'id' => @$cat['id'],
    							  'name' => @$cat['name'],
						    	  'slug' => @$cat['slug'],
						    	  'key' => @$cat['key'],
						    	  'description' => @$cat['description'],
    							  'url' => getUrlNoticeCategory($cat['id'],$cat['slug']),
							      'parent' => $parent,
							      'image' => @$cat['image']
							    );
	    if(isset($cat['sub']) && count($cat['sub'])>0)
	    {
	    	$category=$category+changeNoticeCategoryToList($cat['sub'],$cat['id']);
	    }
    }
    return $category;
}

function getUrlNotice($id='',$slug='')
{
	global $modelNotice;
	global $urlHomes;
	global $infoSite;
	
	if($slug!=''){
		//return $urlHomes.$infoSite['Option']['value']['seoURL']['notices'].'/'.$slug.'.html';
		return $urlHomes.$slug.'.html';
	}elseif($id!=''){
		$id= new MongoId($id);
		$data= $modelNotice->getNotice($id);
		//return $urlHomes.$infoSite['Option']['value']['seoURL']['notices'].'/'.$data['Notice']['slug'].'.html';
		return $urlHomes.$data['Notice']['slug'].'.html';
	}else{
		return $urlHomes.$infoSite['Option']['value']['seoURL']['notices'].'/';
	}
}   

function getUrlNoticeCategory($id='',$slug='')
{
	global $modelNotice;
	global $modelOption;
	global $urlHomes;
	global $infoSite;
	
	if($slug!=''){
		//return $urlHomes.$infoSite['Option']['value']['seoURL']['notices'].'/'.$infoSite['Option']['value']['seoURL']['cat'].'/'.$slug.'.html';
		return $urlHomes.$slug.'.html';
	}elseif($id!=''){
		$id= (int) $id;
		$category= $modelOption->getOption('categoryNotice');
		$category= $modelOption->getcat($category['Option']['value']['category'],$id);
		
		//return $urlHomes.$infoSite['Option']['value']['seoURL']['notices'].'/'.$infoSite['Option']['value']['seoURL']['cat'].'/'.$category['slug'].'.html';
		return $urlHomes.$category['slug'].'.html';
	
	}else{
		return $urlHomes.$infoSite['Option']['value']['seoURL']['notices'].'/'.$infoSite['Option']['value']['seoURL']['cat'].'/';
	}
}     

function getUrlAlbum($id='',$slug='')  
{
	global $modelAlbum;
	global $urlHomes;
	global $infoSite;
	
	if($slug!=''){
		//return $urlHomes.$infoSite['Option']['value']['seoURL']['albums'].'/'.$slug.'.html';
		return $urlHomes.$slug.'.html';
	}elseif($id!=''){
		$id= new MongoId($id);
		$data= $modelAlbum->getAlbum($id);
		//return $urlHomes.$infoSite['Option']['value']['seoURL']['albums'].'/'.$data['Album']['slug'].'.html';
		return $urlHomes.$data['Album']['slug'].'.html';
	}else{
		return $urlHomes.$infoSite['Option']['value']['seoURL']['albums'].'/';
	}
}   

function getUrlUserLogin()
{
	global $infoSite;
	global $urlHomes;
	return $urlHomes.$infoSite['Option']['value']['seoURL']['users'].'/'.$infoSite['Option']['value']['seoURL']['login'].'/';
}

function getUrlUserRegister()
{
	global $infoSite;
	global $urlHomes;
	return $urlHomes.$infoSite['Option']['value']['seoURL']['users'].'/'.$infoSite['Option']['value']['seoURL']['register'].'/';
}

function getUrlVideo($id='',$slug='')  
{
	global $modelVideo;
	global $urlHomes;
	global $infoSite;
	
	if($slug!=''){
		//return $urlHomes.$infoSite['Option']['value']['seoURL']['videos'].'/'.$slug.'.html';
		return $urlHomes.$slug.'.html';
	}elseif($id!=''){
		$id= new MongoId($id);
		$data= $modelVideo->getVideo($id);
		//return $urlHomes.$infoSite['Option']['value']['seoURL']['videos'].'/'.$data['Video']['slug'].'.html';
		return $urlHomes.$data['Video']['slug'].'.html';
	}else{
		return $urlHomes.$infoSite['Option']['value']['seoURL']['videos'].'/';
	}
}    

function getUrlNoticeSearch($key='')
{
	global $urlHomes;
	global $infoSite;
	
	if($key!=''){
		return $urlHomes.$infoSite['Option']['value']['seoURL']['notices'].'/'.$infoSite['Option']['value']['seoURL']['search'].'?key='.$key;
	}else{
		return $urlHomes.$infoSite['Option']['value']['seoURL']['notices'].'/'.$infoSite['Option']['value']['seoURL']['search'].'/';
	}
}       

function addMenusAppearance($category)
{
	/* $category= array(array(  'title'=>'Product',
								'sub'=>array(
											    array (
											      'url' => $urlPlugins.'cat/car.html',
											      'name' => 'Car'
											    ), 
											    array (
											      'url' => $urlPlugins.'cat/moto.html',
											      'name' => 'Moto',
											      'sub' => array ('url' => $urlPlugins.'cat/honda.html',
															      'name' => 'Honda'
															     )
											    )
											)
								)
						);
	*/
	global $hookMenusAppearanceMantan;
	if(!is_array($hookMenusAppearanceMantan)) $hookMenusAppearanceMantan= array();
	
	$hookMenusAppearanceMantan= array_merge($hookMenusAppearanceMantan,$category);
}

function addBreadcrumbAdmin($menu= array())
{
	global $hookFunctionMantan;
	
	if(isset($hookFunctionMantan['addBreadcrumbAdmin']))
	{
		$hookFunctionMantan['addBreadcrumbAdmin']($menu);
	}
	else
	{
		echo '  <div class="row">
	                <div class="col-lg-12">
	                    <h1 class="page-header">
	                    	<a href="'.$menu['url'].'">'.$menu['name'].'</a>';
	                    	
	                    	while(isset($menu['sub']['name']) && $menu['sub']['name']!='')
	                    	{
	                    		if(!isset($menu['sub']['url'])){
		                    		$menu['sub']['url']= '';
	                    		}
		                    	echo ' :: <a href="'.$menu['sub']['url'].'">'.$menu['sub']['name'].'</a>';
		                    	$menu= $menu['sub'];
	                    	}
	                    	
	                    	 
	     echo           '</h1>
	                </div>
	            </div>';
	}
}

function showEditorInput($idEditor='',$nameEditor='',$content='',$loadJs=1)
{
	global $webRoot;
	global $hookFunctionMantan;
	global $webRoot;
	
	if(isset($hookFunctionMantan['showEditorInput']))
	{
		$hookFunctionMantan['showEditorInput']($idEditor,$nameEditor,$content,$loadJs);
	}
	else
	{
		if($loadJs)
		{
			echo "<script type='application/javascript'>
						var urlWebrootMantan= '".$webRoot."';
					</script>";
			echo '<script language="javascript" src="'.$webRoot.'ckeditor/ckeditor.js" type="text/javascript"></script>';
		}
		echo '  <textarea style="border: 1px solid #abadb3;height: auto;"  name="'.$nameEditor.'" id="'.$idEditor.'">'.$content.'</textarea>
				<script type="text/javascript">
					CKEDITOR.replace( "'.$idEditor.'"); 
				</script>';
	}
}

function showUploadFile($idInput='',$nameInput='',$value='',$number='')
{ 
	global $webRoot;
	global $hookFunctionMantan;
	global $languageMantan;
	
	if(isset($hookFunctionMantan['showUploadFile']))
	{
		$hookFunctionMantan['showUploadFile']($idInput,$nameInput,$value,$number);
	}
	else
	{
?>
	<script type="text/javascript" src="<?php echo $webRoot;?>ckfinder/ckfinder.js"></script>
	<script type="text/javascript">
		function BrowseServerImage<?php echo $number;?>()
		{
			var finder = new CKFinder();
			finder.basePath = '../';	
			finder.selectActionFunction = SetFileFieldImage<?php echo $number;?>;
			finder.popup();
		}

		function SetFileFieldImage<?php echo $number;?>( fileUrl )
		{
			document.getElementById( '<?php echo $idInput;?>' ).value = fileUrl;
		}
	</script>
	<div class="row">
		<div class="col-xs-8 col-sm-8">
			<input class="form-control" type="text" name="<?php echo $nameInput;?>" id='<?php echo $idInput;?>' value="<?php echo $value;?>" />
		</div>
		<div class="col-xs-2 col-sm-2">
			<input type="button" class="btn btn-default" value="Upload" onclick="BrowseServerImage<?php echo $number;?>();" />
		</div>
	</div>
	
	
<?php 
	}
}


function getMenusDefault()
{
	global $modelOption;
	$listData= $modelOption->getOption('defaultMenuMantan');
	if(isset($listData['Option']['value']))
	{
		$menus= $modelOption->getOptionById($listData['Option']['value']);
		if(!empty($menus['Option']['value']['category'])) return $menus['Option']['value']['category'];
	}
	
	$menus= $modelOption->getOption('menus');
	if(!empty($menus['Option']['value']['category'])) return $menus['Option']['value']['category'];

	return array();
}

function exportExcel($table=array(),$data=array())
{
    /*
    $table = array(
        array('label' => __('User'), 'filter' => true),
        array('label' => __('Type'), 'filter' => true),
        array('label' => __('Date')),
        array('label' => __('Description'), 'width' => 50, 'wrap' => true),
        array('label' => __('Modified'))
    );
    
    $data= array(
        array('Manh','17/9/1989','Good','male')
    );
    */
    $Exports = new ExportsController;
    $Exports->constructClasses();
    $Exports->excel($table,$data);
}

function createSlugMantan($text)
{
	$marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
	"ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
	,"ế","ệ","ể","ễ",
	"ì","í","ị","ỉ","ĩ",
	"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
	,"ờ","ớ","ợ","ở","ỡ",
	"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
	"ỳ","ý","ỵ","ỷ","ỹ",
	"đ",
	"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
	,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
	"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
	"Ì","Í","Ị","Ỉ","Ĩ",
	"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
	,"Ờ","Ớ","Ợ","Ở","Ỡ",
	"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
	"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
	"Đ"," ","·","/","_",",",":",";",".","&","%","@","'",'"',"?","+","*","~","!","#","$","^","’");
	
	$marKoDau=array("a","a","a","a","a","a","a","a","a","a","a"
	,"a","a","a","a","a","a",
	"e","e","e","e","e","e","e","e","e","e","e",
	"i","i","i","i","i",
	"o","o","o","o","o","o","o","o","o","o","o","o"
	,"o","o","o","o","o",
	"u","u","u","u","u","u","u","u","u","u","u",
	"y","y","y","y","y",
	"d",
	"A","A","A","A","A","A","A","A","A","A","A","A"
	,"A","A","A","A","A",
	"E","E","E","E","E","E","E","E","E","E","E",
	"I","I","I","I","I",
	"O","O","O","O","O","O","O","O","O","O","O","O"
	,"O","O","O","O","O",
	"U","U","U","U","U","U","U","U","U","U","U",
	"Y","Y","Y","Y","Y",
	"D","-","","","-","","","","","","","","","","","","","","","","","","");
	
	$text= str_replace('-',' ',$text);
	$text= preg_replace('/\s\s+/', ' ', trim($text));
	$text= str_replace($marTViet,$marKoDau,$text);

	if($text !== mb_convert_encoding( mb_convert_encoding($text, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') ) {
		$text = mb_convert_encoding($text, 'UTF-8', mb_detect_encoding($text));
	}

    $text = htmlentities($text, ENT_NOQUOTES, 'UTF-8');

    $text = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\\1', $text);

    $text = html_entity_decode($text, ENT_NOQUOTES, 'UTF-8');

    $text = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $text);

    $text = strtolower( trim($text, '-') );

	return strtolower($text);
}

function getDomainUrl()
{
	$domainURL = 'http';

   	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$domainURL .= "s";}

   	$domainURL .= "://";

   	if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443"){
        $domainURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].'/';
   	} else {
        $domainURL .= $_SERVER["SERVER_NAME"].'/';
   	}

   	return $domainURL;
}

function curPageURL($type=0)
{

   $pageURL = 'http';

   if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}

   $pageURL .= "://";

   if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443")

   {

        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];

   } else

   {

        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

   }
   
   if($type==1)
   {
       return $pageURL;
   }
   else
   {
   	    return urlencode($pageURL);
   }
}

function sendDataConnectMantan($url,$data=null,$header=array(),$typeData='form', $typeSend= 'POST')
    {
    	/*
    	$headers = array(
            'Authorization: key=' .self::$API_ACCESS_KEY,
            'Content-Type: application/json');
		*/
            
	    if($data){
	   		$stringSend= '';
	   		if($typeData=='form'){
	   			$stringSend= array();
		   		foreach($data as $key=>$value){
		   			$stringSend[]= $key.'='.$value;
		   		}
		   		

		   		$stringSend= implode('&', $stringSend);
		   	}elseif($typeData=='raw'){
		   		$stringSend= json_encode($data);
		   	}
	   		
			$ch = curl_init();

			if(strtoupper($typeSend)=='PUT'){
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($ch, CURLOPT_PUT, 1);
				$header[]= 'Content-Length: '.strlen($stringSend);
				//$stringSend= http_build_query($data);
				//$stringSend= json_encode($data);
			}else{
				curl_setopt($ch, CURLOPT_POST, 1);
			}

			curl_setopt($ch, CURLOPT_URL,$url);
			
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$stringSend);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec ($ch);

			curl_close ($ch);

			return $server_output;
	    }else{
	    	$opts = array(
				'http'=>array(
				    'method'=>"GET",
				    'header'=>""
				)
			);

			if(!empty($header)){
				$opts['http']['header'].= implode('&', $header);
			}

			$context = stream_context_create($opts);
		   	return file_get_contents($url, false, $context);
	    }
    }
?>