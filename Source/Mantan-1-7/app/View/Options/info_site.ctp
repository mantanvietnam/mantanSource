<?php
	$breadcrumb= array( 'name'=>$languageMantan['setting'],
						'url'=>$urlOptions.'infoSite',
						'sub'=>array('name'=>$languageMantan['information'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
	<script>
		$(function() {
			$( "#tabs" ).tabs();
		});
    </script>
	
    <script type="text/javascript">
		function saveData()
		{
			var domain= document.getElementById("domain").value;
			var email= document.getElementById("email").value;
			var title= document.getElementById("title").value;
			var account= document.getElementById("account").value;
			var password= document.getElementById("password").value;
			var host= document.getElementById("host").value;
			var port= document.getElementById("port").value;
			
			if(domain=='' || email=='' || title=='' || account=='' || password=='' || host=='' || port=='' )
			{
				document.getElementById("status").innerHTML= "<p style='color: red;'><?php echo $languageMantan['youMustFillOutTheInformationBelow'];?></p>";
			}
			else
			{
				document.listForm.submit();
			}
		}
	</script>
	  <div class="thanhcongcu">
	
	      <div class="congcu" onclick="saveData();">
	        <input type="hidden" id="idChange" value="" />
	        <span id="save">
	          <input type="image" src="<?php echo $webRoot;?>images/save.png" />
	        </span>
	        <br/>
	        <?php echo $languageMantan['save'];?>
	      </div>
	      
	
	  </div>
	  <div class="clear" id='status'>
		  <?php
		  	if(isset($_GET['return'])){
			  	$return= $_GET['return'];
		  	} else {
			  	$return= '';
		  	}
			
	
	        if( $return==1)
	        {
	          echo "<p style='color: red;'>".$languageMantan['saveSuccess']."</p>";
	        }
	        else if( $return==3)
	        {
	          echo "<p style='color: red;'>".$languageMantan['saveFailed']."</p>";
	        }
	        
	        $urlBase= Router::url('/');
 	
		 	if(strpos(strtolower($urlBase),'index.php/'))
		 	{
			 	$urlBase= substr_replace($urlBase, '', -11);  
		 	}
		 	else
		 	{
			 	$urlBase= substr_replace($urlBase, '', -1);  
		 	}
		 	$placeholder= $_SERVER['SERVER_NAME'].$urlBase;
		 	
	        if(!isset($infoSite['Option']['value']['domain']) || $infoSite['Option']['value']['domain']=='')
	        {
			 	$infoSite['Option']['value']['domain']= $placeholder;
	        }
		  ?>
	  </div>
	  <div class="clear"></div>
	  <form action="<?php echo $urlOptions;?>saveInfoSite" method="post" name="listForm">
	  <div id="tabs">
		   <ul>
			<li><a href="#tabs-1"><?php echo $languageMantan['generalSettings'];?></a></li>
			<li><a href="#tabs-2"><?php echo $languageMantan['smtpSettings'];?></a></li>
			<li><a href="#tabs-3"><?php echo $languageMantan['seoSettings'];?></a></li>
			<li><a href="#tabs-4"><?php echo $languageMantan['seoURL'];?></a></li>
		  </ul>
		  <div class="taovien" id="tabs-1">
			
				<table id="listTable" width="650" cellspacing="0" cellpadding="0" class="table table-striped">
				  <tr>
					<td align="right" width="170"><?php echo $languageMantan['webstieName'];?> (*)</td>
					<td align="left"><input required class="form-control" type="text" value="<?php echo @$infoSite['Option']['value']['title'];?>" name="title" id="title" /></td>
				  </tr>
				  
				  <tr>
					<td align="right" ><?php echo $languageMantan['domainName'];?> (*)</td>
					<td align="left"><input required placeholder="<?php echo @$placeholder;?>" class="form-control" type="text" value="<?php echo @$infoSite['Option']['value']['domain'];?>" name="domain" id="domain" /></td>
				  </tr>
				  <tr>
					<td align="right" ><?php echo $languageMantan['address'];?></td>
					<td align="left">
						<textarea class="form-control" rows="5" name="address" id="address"><?php echo @$contact['Option']['value']['address'];?></textarea>
					</td>
				  </tr>
				  <tr>
					<td align="right" ><?php echo $languageMantan['email'];?> (*)</td>
					<td align="left"><input class="form-control" required type="text" value="<?php echo @$contact['Option']['value']['email'];?>" name="email" id="email" /></td>
				  </tr>
				  <tr>
					<td align="right" ><?php echo $languageMantan['telephoneNumber'];?></td>
					<td align="left"><input class="form-control" type="text" value="<?php echo @$contact['Option']['value']['fone'];?>" name="fone" id="fone" /></td>
				  </tr>
				  <tr>
					<td align="right" ><?php echo $languageMantan['faxNumber'];?></td>
					<td align="left"><input class="form-control" type="text" value="<?php echo @$contact['Option']['value']['fax'];?>" name="fax" id="fax" /></td>
				  </tr>
			  </table>
			
		  </div>
		  <div id="tabs-2">
			<table id="listTable" width="650" cellspacing="0" cellpadding="0" class="table table-striped">
				  <tr>
					<td align="right" width="180"><?php echo $languageMantan['account'] .'('.$languageMantan['email'].')';?> (*)</td>
					<td align="left"><input placeholder="mantansource@gmail.com" required class="form-control" type="text" value="<?php echo @$smtpSite['Option']['value']['account'];?>" name="account" id="account" /></td>
				  </tr>
				  
				  <tr>
					<td align="right" ><?php echo $languageMantan['password'];?> (*)</td>
					<td align="left"><input placeholder="" class="form-control" required type="password" value="<?php echo @$smtpSite['Option']['value']['password'];?>" name="password" id="password" /></td>
				  </tr>
				  <tr>
					<td align="right" ><?php echo $languageMantan['show'];?></td>
					<td align="left"><input placeholder="Mantan Source" class="form-control" type="text" value="<?php echo @$smtpSite['Option']['value']['show'];?>" name="show" id="show" /></td>
				  </tr>
				  <tr>
					<td align="right" ><?php echo $languageMantan['host'];?> (*)</td>
					<td align="left"><input placeholder="ssl://smtp.gmail.com" required class="form-control" type="text" value="<?php echo @$smtpSite['Option']['value']['host'];?>" name="host" id="host" /></td>
				  </tr>
				  <tr>
					<td align="right" ><?php echo $languageMantan['port'];?> (*)</td>
					<td align="left"><input placeholder="465" required class="form-control" type="text" value="<?php echo @$smtpSite['Option']['value']['port'];?>" name="port" id="port" /></td>
				  </tr>
			  </table>
		  </div>
		  <div class="taovien" id="tabs-3">
				<table id="listTable" width="650" cellspacing="0" cellpadding="0" class="table table-striped">
				  <tr>
					<td width="150" align="right" ><?php echo $languageMantan['keyWord'];?></td>
					<td align="left"><input class="form-control" type="text" value="<?php echo @$infoSite['Option']['value']['key'];?>" name="key" id="key" /></td>
				  </tr>
				  <tr>
					<td align="right" ><?php echo $languageMantan['description'];?></td>
					<td align="left"><input class="form-control" type="text" value="<?php echo @$infoSite['Option']['value']['description'];?>" name="description" id="description" /></td>
				  </tr>
				  <tr>
					<td align="right" ><?php echo $languageMantan['PostsOnThePage'];?></td>
					<td align="left"><input class="form-control" type="text" value="<?php echo @$infoSite['Option']['value']['postsOnThePage'];?>" name="postsOnThePage" id="postsOnThePage" /></td>
				  </tr>
				  <tr>
					<td align="right" ><?php echo $languageMantan['embedScript'];?></td>
					<td align="left">
						<textarea class="form-control" rows="5" name="embedScript" id="embedScript"><?php echo @$infoSite['Option']['value']['embedScript'];?></textarea>
					</td>
				  </tr>
			  </table>
			
		  </div>
		  <div class="taovien" id="tabs-4">
				<table id="listTable" width="650" cellspacing="0" cellpadding="0" class="table table-striped">
				  <tr>
					<td width="150" align="right" >notices = </td>
					<td align="left"><input class="form-control" type="text" value="<?php echo @$infoSite['Option']['value']['seoURL']['notices'];?>" name="seoURL[notices]" /></td>
				  </tr>
				  <tr>
					<td align="right" >cat = </td>
					<td align="left"><input class="form-control" type="text" value="<?php echo @$infoSite['Option']['value']['seoURL']['cat'];?>" name="seoURL[cat]" /></td>
				  </tr>
				  <tr>
					<td align="right" >albums = </td>
					<td align="left"><input class="form-control" type="text" value="<?php echo @$infoSite['Option']['value']['seoURL']['albums'];?>" name="seoURL[albums]" /></td>
				  </tr>
				  <tr>
					<td align="right" >videos = </td>
					<td align="left"><input class="form-control" type="text" value="<?php echo @$infoSite['Option']['value']['seoURL']['videos'];?>" name="seoURL[videos]" /></td>
				  </tr>
				  <tr>
					<td align="right" >search = </td>
					<td align="left"><input class="form-control" type="text" value="<?php echo @$infoSite['Option']['value']['seoURL']['search'];?>" name="seoURL[search]" /></td>
				  </tr>
				  <tr>
					<td align="right" >users = </td>
					<td align="left"><input class="form-control" type="text" value="<?php echo @$infoSite['Option']['value']['seoURL']['users'];?>" name="seoURL[users]" /></td>
				  </tr>
				  <tr>
					<td align="right" >login = </td>
					<td align="left"><input class="form-control" type="text" value="<?php echo @$infoSite['Option']['value']['seoURL']['login'];?>" name="seoURL[login]" /></td>
				  </tr>
				  <tr>
					<td align="right" >register = </td>
					<td align="left"><input class="form-control" type="text" value="<?php echo @$infoSite['Option']['value']['seoURL']['register'];?>" name="seoURL[register]" /></td>
				  </tr>
			  </table>
			
		  </div>
	</div>
	</form>