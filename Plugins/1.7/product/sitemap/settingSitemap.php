<?php
	global $languageProduct;

	$breadcrumb= array( 'name'=>$languageProduct['SitemapSettings'],
						'url'=>$urlPlugins.'admin/product-sitemap-settingSitemap.php',
						'sub'=>array('name'=>$languageProduct['AllData'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?>     
	
<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">

<div id="content clear">
    <div style="padding: 10px;padding-left: 15px;">
        <?php
        	if(isset($_GET['return'])){
	            switch($_GET['return'])
	            {
	              case 1:  echo '<font color="red">'.$languageProduct['SaveSuccessful'].'</font>'; break;
	              case -1: echo '<font color="red">'.$languageProduct['SaveFailed'].'</font>'; break;
	            }
        	}
			
			echo '<p>Url Sitemap: <a target="_blank" href="'.$urlHomes.'app/Plugin/product/sitemap/sitemap.xml">'.$urlHomes.'app/Plugin/product/sitemap/sitemap.xml</a></p>';
        ?>
    </div>
    <form action="<?php echo $urlPlugins.'admin/product-sitemap-createSiteMap.php';?>" method="post" name="account" class="taovienLimit">
        <table cellspacing="0" class="tableList">
            <tr>
                <td width="160"><?php echo $languageProduct['ChangeFrequency'];?></td>
                <td>
	                <select name="freq">

						<option value="" <?php if(isset($listData['Option']['value']['freq']) && $listData['Option']['value']['freq']=='') echo 'selected=""'; ?> >None</option>
						
						<option value="always" <?php if(isset($listData['Option']['value']['freq']) && $listData['Option']['value']['freq']=='always') echo 'selected=""'; ?> >Always</option>
						
						<option value="hourly" <?php if(isset($listData['Option']['value']['freq']) && $listData['Option']['value']['freq']=='hourly') echo 'selected=""'; ?> >Hourly</option>
						
						<option value="daily" <?php if(isset($listData['Option']['value']['freq']) && $listData['Option']['value']['freq']=='daily') echo 'selected=""'; ?> >Daily</option>
						
						<option value="weekly" <?php if(isset($listData['Option']['value']['freq']) && $listData['Option']['value']['freq']=='weekly') echo 'selected=""'; ?> >Weekly</option>
						
						<option value="monthly" <?php if(isset($listData['Option']['value']['freq']) && $listData['Option']['value']['freq']=='monthly') echo 'selected=""'; ?> >Monthly</option>
						
						<option value="yearly" <?php if(isset($listData['Option']['value']['freq']) && $listData['Option']['value']['freq']=='yearly') echo 'selected=""'; ?> >Yearly</option>
						
						<option value="never" <?php if(isset($listData['Option']['value']['freq']) && $listData['Option']['value']['freq']=='never') echo 'selected=""'; ?> >Never</option>
					
					</select>
                </td>
            </tr>
            <tr>
                <td><?php echo $languageProduct['LastModification'];?></td>
                <td>
	                <p>
	                	<input type="radio" value="0" name="lastmod" <?php if(isset($listData['Option']['value']['lastmod']) && $listData['Option']['value']['lastmod']==0) echo 'checked=""'; ?> > None
	                </p>
	                <p>
		                <input type="radio" value="1" name="lastmod" <?php if(isset($listData['Option']['value']['lastmod']) && $listData['Option']['value']['lastmod']==1) echo 'checked=""'; ?> > Use server's response 
	                </p>
	                <p>
		                <input type="radio" value="2" name="lastmod" <?php if(isset($listData['Option']['value']['lastmod']) && $listData['Option']['value']['lastmod']==2) echo 'checked=""'; ?> > Use this date/time: <input type="text" value="<?php echo @$listData['Option']['value']['lastmodtime'];?>" size="30" name="lastmodtime" placeholder="Timestamp">
	                </p>
                </td>
            </tr>
            <tr>
                <td><?php echo $languageProduct['Priority'];?></td>
                <td>
                	<p>
	                	<input type="radio" value="0" name="priority" <?php if(isset($listData['Option']['value']['priority']) && $listData['Option']['value']['priority']==0) echo 'checked=""'; ?> > None 
						<input type="radio" value="1" name="priority" <?php if(isset($listData['Option']['value']['priority']) && $listData['Option']['value']['priority']==1) echo 'checked=""'; ?> > Customized
                	</p>
                	<div>
                		<table>
	                		<tr>
		                		<td>Category</td>
		                		<td><input type="text" value="<?php echo @$listData['Option']['value']['priorityCategory'];?>" size="30" name="priorityCategory" placeholder="0.8"></td>
	                		</tr>
	                		<tr>
		                		<td>Product detail</td>
		                		<td><input type="text" value="<?php echo @$listData['Option']['value']['priorityDetail'];?>" size="30" name="priorityDetail" placeholder="0.5"></td>
	                		</tr>
                		</table>
                	</div>
                </td>
            </tr>
            <tr>
	            <td colspan="2"><input type="submit" value="Create Sitemap" /></td>
            </tr>
        </table>
    </form>

  </div>