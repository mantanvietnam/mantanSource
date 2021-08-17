<?php
	$menus= array();
	$menus[0]['title']= 'Facebook';
    $menus[0]['sub'][0]= array('name'=>'Facebook Setting','classIcon'=>'fa-facebook-square','url'=>$urlPlugins.'admin/facebook-setting.php','permission'=>'facebookSetting');
	$menus[0]['sub'][1]= array('name'=>'Bài đăng Facebook','classIcon'=>'fa-facebook-square','url'=>$urlPlugins.'admin/facebook-listPostFacebook.php','permission'=>'listPostFacebook');
    addMenuAdminMantan($menus);
    
	function showCommentFacebook($urlComment,$numberComment)
	{ 
		global $modelOption;
		$data= $modelOption->getOption('settingFacebook');
		$idAppFacebook= (isset($data['Option']['value']['idApp']))? $data['Option']['value']['idApp']:'';

		if($idAppFacebook!=''){
	?>
		<div id="fb-root"></div>
		<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v9.0&appId=<?php echo $idAppFacebook;?>&autoLogAppEvents=1"></script>

		<div class="fb-comments" data-href="<?php echo $urlComment;?>" data-width="100%" data-numposts="<?php echo $numberComment;?>"></div>
	<?php }
	}
	
	function getPostFacebook($limit=3)
	{
		global $modelOption;
		$listData= $modelOption->getOption('listPostFacebook');
		$newData= array();

		if(!empty($listData['Option']['value']['allData'])){
			$allData= array_reverse($listData['Option']['value']['allData'], true);
			$dem= 0;
			foreach($allData as $item){
				$dem++;
				if($dem<=$limit){
					$newData[]= $item;
				}else{
					break;
				}
			}
		}

		return $newData;
	}

	function showLikeFanpage()
	{ 
		global $modelOption;
		$data= $modelOption->getOption('settingFacebook');

		if(isset($data['Option']['value']['linkFanpage'])){
			$urlPangape= $data['Option']['value']['linkFanpage'];
		}else{
			$urlPangape= '';
		}

		if(isset($data['Option']['value']['idApp'])){
			$idAppFacebook= $data['Option']['value']['idApp'];
		}else{
			$idAppFacebook= '';
		}

		if(isset($data['Option']['value']['nameFanpage'])){
			$nameFanpage= $data['Option']['value']['nameFanpage'];
		}else{
			$nameFanpage= '';
		}

		if($urlPangape != ''){
	?>
		<!-- F A C E B O O K  A P I -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v9.0&appId=<?php echo $idAppFacebook;?>";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

		<div class="fb-page" data-href="<?php echo $urlPangape;?>" data-tabs="messages" data-height="350" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo $urlPangape;?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $urlPangape;?>"><?php echo $nameFanpage;?></a></blockquote></div>
		
	<?php }
	}
	
	function showShareFacebook($urlShare=null)
	{ 
		global $modelOption;
		global $urlNow;
		
		$data= $modelOption->getOption('settingFacebook');
		$idAppFacebook= (isset($data['Option']['value']['idApp']))? $data['Option']['value']['idApp']:'';

		if(!$urlShare){
			if(isset($data['Option']['value']['urlShare']) &&  $data['Option']['value']['urlShare']=='url_other'){
				$urlShare= $data['Option']['value']['url_share_facebook'];
			}else{
				$urlShare= $urlNow;
			}
		}

		if($idAppFacebook!=''){
	?>
	<style>
		.showButton{float:left;margin-right: 5px;}
	</style>
	<div class="showButton">
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&appId=<?php echo $idAppFacebook;?>&version=v9.0";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

		<div class="fb-share-button" data-href="<?php echo $urlShare;?>" data-width="150" data-type="button_count"></div>
	</div>
	<?php }
	}
		
	function showContentShareFacebook($title='',$description='',$site_name='',$image='',$type='website')
	{
		global $modelOption;
		global $urlNow;
		global $metaTitleMantan;
		global $metaKeywordsMantan;
		global $metaDescriptionMantan;
		global $metaImageMantan;
		global $infoSite;
		global $urlHomes;
		
		$data= $modelOption->getOption('settingFacebook');
        
        if($data){
    		$idAppFacebook= $data['Option']['value']['idApp'];
    		$idAdminFacebook= $data['Option']['value']['idAdmin'];
    		
    		if($data['Option']['value']['urlShare']=='url_currently'){
    			$urlShare= $urlNow;
    		}elseif($data['Option']['value']['urlShare']=='url_other'){
    			$urlShare= $data['Option']['value']['url_share_facebook'];
    		}
    		
    		if(empty($metaImageMantan)) $metaImageMantan= $data['Option']['value']['image'];
    		
    		if($title=='') $title= $metaTitleMantan;
    		if($description=='') $description= $metaDescriptionMantan;
    		if($image=='') $image= $metaImageMantan;
    		if($site_name=='') $site_name= $infoSite['Option']['value']['title'];

    		if(!empty($image) && strpos($image, 'http') === false && strpos($image, 'https') === false ) $image= $urlHomes.$image;
    		
    		echo '  <!-- Facebook Meta Tags -->
    				<meta property="og:title" content="'.$title.'"/>
    				<meta property="og:type" content="'.$type.'"/>
    				<meta property="og:description" content="'.$description.'"/>
    				<meta property="og:url" content="'.$urlShare.'"/>
    				<meta property="og:site_name" content="'.$site_name.'"/>
    				<meta property="og:image" content="'.$image.'" />
    				<meta property="og:image:alt" content="Hình ảnh '.$title.'" />
    				<meta property="fb:admins" content="'.$idAdminFacebook.'" />
    				<meta property="fb:app_id" content="'.$idAppFacebook.'" /> 
    				<meta property="og:image:width" content="900" />
					<meta property="og:image:height" content="603" />

				    <!-- Twitter Meta Tags -->
				    <meta name="twitter:card" content="summary_large_image">
				    <meta name="twitter:title" content="'.$title.'">
				    <meta name="twitter:description" content="'.$description.'">
				    <meta name="twitter:image" content="'.$image.'">
    			';

    		/*
    		echo "
					<script>
					  window.fbAsyncInit = function() {
					    FB.init({
					      appId      : '".$idAppFacebook."',
					      cookie     : true,
					      xfbml      : true,
					      version    : 'v9.0'
					    });
					      
					    FB.AppEvents.logPageView();   
					      
					  };

					  (function(d, s, id){
					     var js, fjs = d.getElementsByTagName(s)[0];
					     if (d.getElementById(id)) {return;}
					     js = d.createElement(s); js.id = id;
					     js.src = 'https://connect.facebook.net/en_US/sdk.js';
					     fjs.parentNode.insertBefore(js, fjs);
					   }(document, 'script', 'facebook-jssdk'));
					</script>";
			*/
        }
	}
	
	function showLikeFacebook($urlLike=null)
	{ 
		global $modelOption;
		global $urlNow;

		$data= $modelOption->getOption('settingFacebook');
		$idAppFacebook= (isset($data['Option']['value']['idApp']))? $data['Option']['value']['idApp']:'';
		
		if(!$urlLike)
		{
			$urlLike= (isset($data['Option']['value']['linkFanpage']))?$data['Option']['value']['linkFanpage']:$urlNow;
		}

		if($idAppFacebook!=''){
	?>
	<style>
		.showButton{float:left;margin-right: 5px;}
	</style>
	<div class="showButton">
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&appId=<?php echo $idAppFacebook;?>&version=v9.0";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		
		<div class="fb-like" data-href="<?php echo $urlLike;?>" data-layout="button_count" data-width="150" data-action="like" data-show-faces="true" data-share="false"></div>
	</div>
	<?php }
	}
	
	function showButtonGPlus()
	{ ?>
	<style>
		.showButton{float:left;margin-right: 5px;}
	</style>
	<div class="showButton">
		<!-- Đặt thẻ này vào nơi bạn muốn Nút +1 kết xuất. -->
		<div class="g-plusone" data-size="medium"></div>
		
		<!-- Đặt thẻ này sau thẻ Nút +1 cuối cùng. -->
		<script type="text/javascript">
		  window.___gcfg = {lang: 'vi'};
		
		  (function() {
		    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		    po.src = 'https://apis.google.com/js/platform.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>
	</div>
	<?
	}
	function showButtonTweet()
	{ ?>
	<script>window.twttr = (function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0],
	    t = window.twttr || {};
	  if (d.getElementById(id)) return t;
	  js = d.createElement(s);
	  js.id = id;
	  js.src = "https://platform.twitter.com/widgets.js";
	  fjs.parentNode.insertBefore(js, fjs);
	 
	  t._e = [];
	  t.ready = function(f) {
	    t._e.push(f);
	  };
	 
	  return t;
	}(document, "script", "twitter-wjs"));</script>
	<a class="twitter-share-button"
	  href="https://twitter.com/intent/tweet">
	Tweet</a>
	<?php }
?>