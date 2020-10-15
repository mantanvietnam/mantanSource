<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
	$(function() {
	$( "#tabs" ).tabs();
	});
</script>

<style>
	#tabs{
		width: 100%;
	}
	.tableShow td{
		padding: 10px;
	}
	.classInput{
		width: 85%;
	}
</style>

<?php
	$breadcrumb= array( 'name'=>'All Seo',
						'url'=>$urlPlugins.'admin/allSEO-setting.php',
						'sub'=>array('name'=>'Setting')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 
  
    <script type="text/javascript">
	
	    function saveData()
	    {
	        document.dangtin.submit();
	
	    }
	</script>
	
	
	<div class="thanhcongcu">
	    <div class="congcu" onclick="saveData();">
	        <input type="hidden" id="idChange" value="" />
	        <span id="save">
	          <input type="image" src="<?php echo $webRoot;?>images/save.png" />
	        </span>
	        <br/>
	        Save
	    </div>
	
	</div>
	
	<div class="clear"></div>
	
	<div id="content">

	<form action="" method="post" name="dangtin" enctype="multipart/form-data">
		<p><?php echo $mess;?></p>
	    <div id="tabs">
			<ul>
				<li><a href="#tabs-1">General</a></li>
				<li><a href="#tabs-2">Category</a></li>
				<li><a href="#tabs-3">Post - Page</a></li>
				<li><a href="#tabs-4">Expand</a></li>
			</ul>
			<div id="tabs-1">
				<table width="100%" class="tableShow">
					<tr>
						<td valign="top" width="170px">Image Default:</td>
						<td valign="top">
							<?php                    
							    showUploadFile('image','image',@$listData['Option']['value']['general']['image'],0);
							?>
						</td>
					</tr>
					<tr>
						<td valign="top" width="170px">Meta Title:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['general']['title'];?>" name="generalTitle" class="classInput" placeholder="%title%" />
						</td>
					</tr>
					
					<tr>
						<td valign="top">Meta Keyword:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['general']['keyword'];?>" name="generalKeyword" class="classInput" placeholder="%keyword%" />
						</td>
					</tr>
					
					<tr>
						<td valign="top">Meta Description:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['general']['description'];?>" name="generalDescription" class="classInput" placeholder="%description%" />
						</td>
					</tr>
				</table>
				<br/><br/>
				<ul>
					<li>%title%: default title system</li>
					<li>%keyword%: default keyword system</li>
					<li>%description%: default description system</li>
				</ul>
			</div>
			
			<!-- Category -->
			<div id="tabs-2">
				<table width="100%" class="tableShow">
					<tr>
						<td valign="top" width="170px">Meta Title:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['category']['title'];?>" name="categoryTitle" class="classInput" placeholder="%title%" />
						</td>
					</tr>
					
					<tr>
						<td valign="top">Meta Keyword:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['category']['keyword'];?>" name="categoryKeyword" class="classInput" placeholder="%keyword%" />
						</td>
					</tr>
					
					<tr>
						<td valign="top">Meta Description:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['category']['description'];?>" name="categoryDescription" class="classInput" placeholder="%description%" />
						</td>
					</tr>
				</table>
				<br/><br/>
				<ul>
					<li>%title%: default title system</li>
					<li>%keyword%: default keyword system</li>
					<li>%description%: default description system</li>
					<li>%categoryName%: the default is the name of news categories</li>
					<li>%categoryKeyword%: the default is the name of news keyword</li>
					<li>%categoryDescription%: the default is the name of news description</li>
					<li>%page%: default number page</li>
					<li>%pageMore%: default number page larger one</li>
				</ul>
			</div>
			
			<!-- Post -->
			<div id="tabs-3">
				<table width="100%" class="tableShow">
					<tr>
						<td valign="top" width="170px">Meta Title:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['post']['title'];?>" name="postTitle" class="classInput" placeholder="%title%" />
						</td>
					</tr>
					
					<tr>
						<td valign="top">Meta Keyword:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['post']['keyword'];?>" name="postKeyword" class="classInput" placeholder="%keyword%" />
						</td>
					</tr>
					
					<tr>
						<td valign="top">Meta Description:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['post']['description'];?>" name="postDescription" class="classInput" placeholder="%description%" />
						</td>
					</tr>
				</table>
				<br/><br/>
				<ul>
					<li>%title%: default title system</li>
					<li>%keyword%: default keyword system</li>
					<li>%description%: default description system</li>
					<li>%postName%: default post title</li>
					<li>%postKeyword%: default post keyword</li>
					<li>%postDescription%: default post description</li>
				</ul>
			</div>
			
			<!-- Expand -->
			<div id="tabs-4">
				<table width="100%" class="tableShow">
					<tr>
						<td valign="top" width="170px">Meta Title:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['expand']['title'];?>" name="expandTitle" class="classInput" placeholder="%title%" />
						</td>
					</tr>
					
					<tr>
						<td valign="top">Meta Keyword:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['expand']['keyword'];?>" name="expandKeyword" class="classInput" placeholder="%keyword%" />
						</td>
					</tr>
					
					<tr>
						<td valign="top">Meta Description:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['expand']['description'];?>" name="expandDescription" class="classInput" placeholder="%description%" />
						</td>
					</tr>
				</table>
				<br/><br/>
				<ul>
					<li>%title%: default title system</li>
					<li>%keyword%: default keyword system</li>
					<li>%description%: default description system</li>
				</ul>
			</div>
		</div>
	</form>
</div>
