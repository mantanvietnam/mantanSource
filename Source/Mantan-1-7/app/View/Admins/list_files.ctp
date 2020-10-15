<?php global $webRoot;?>

<?php
	$breadcrumb= array( 'name'=>$languageMantan['fileManagement'],
						'url'=>$urlAdmins.'listFiles',
						'sub'=>array('name'=>$languageMantan['all'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>
<div id="content"></div>

<script type="text/javascript" src="<?php echo $webRoot;?>ckfinder/ckfinder.js"></script>
<script type="text/javascript">
	function BrowseServerImage()
	{
		var finder = new CKFinder();
		finder.basePath = '../';	
		
		finder.appendTo( "content" );
	}

	BrowseServerImage();
		
</script>