<?php
	global $languageProduct;
?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">

<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>

<script type="text/javascript">
    function saveData()
    {
        document.dangtin.submit();

    }
</script>

<?php
	$breadcrumb= array( 'name'=>$languageProduct['SeoSettings'],
						'url'=>$urlPlugins.'admin/product-seo-settingSeo.php',
						'sub'=>array('name'=>$languageProduct['AllData'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 
  
 
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
	<form action="<?php echo $urlPlugins;?>admin/product-seo-saveSettingSeo.php" method="post" name="dangtin" enctype="multipart/form-data">
	
	    <div id="tabs">
			<ul>
				<li><a href="#tabs-1"><?php echo $languageProduct['CategoryPage'];?></a></li>
				<li><a href="#tabs-2"><?php echo $languageProduct['DetailPage'];?></a></li>
				<li><a href="#tabs-3"><?php echo $languageProduct['SearchPage'];?></a></li>
				<li><a href="#tabs-4"><?php echo $languageProduct['ManufacturerPage'];?></a></li>
				<li><a href="#tabs-5"><?php echo $languageProduct['SeoPath'];?></a></li>
			</ul>
			
			<!-- Category -->
			<div id="tabs-1">
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
					<li>%categoryName%: default category name</li>
					<li>%categoryKeyword%: default category keyword</li>
					<li>%categoryDescription%: default category description</li>
					<li>%page%: default number page</li>
					<li>%pageMore%: default number page larger one</li>
				</ul>
			</div>
			
			<!-- Detail -->
			<div id="tabs-2">
				<table width="100%" class="tableShow">
					<tr>
						<td valign="top" width="170px">Meta Title:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['detail']['title'];?>" name="detailTitle" class="classInput" placeholder="%title%" />
						</td>
					</tr>
					
					<tr>
						<td valign="top">Meta Keyword:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['detail']['keyword'];?>" name="detailKeyword" class="classInput" placeholder="%keyword%" />
						</td>
					</tr>
					
					<tr>
						<td valign="top">Meta Description:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['detail']['description'];?>" name="detailDescription" class="classInput" placeholder="%description%" />
						</td>
					</tr>
				</table>
				<br/><br/>
				<ul>
					<li>%title%: default title system</li>
					<li>%keyword%: default keyword system</li>
					<li>%description%: default description system</li>
					<li>%productName%: default product name</li>
					<li>%productKeyword%: default product keyword</li>
					<li>%productDescription%: default product description</li>
				</ul>
			</div>
			
			<!-- Search -->
			<div id="tabs-3">
				<table width="100%" class="tableShow">
					<tr>
						<td valign="top" width="170px">Meta Title:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['search']['title'];?>" name="searchTitle" class="classInput" placeholder="%title%" />
						</td>
					</tr>
					
					<tr>
						<td valign="top">Meta Keyword:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['search']['keyword'];?>" name="searchKeyword" class="classInput" placeholder="%keyword%" />
						</td>
					</tr>
					
					<tr>
						<td valign="top">Meta Description:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['search']['description'];?>" name="searchDescription" class="classInput" placeholder="%description%" />
						</td>
					</tr>
				</table>
				<br/><br/>
				<ul>
					<li>%title%: default title system</li>
					<li>%keyword%: default keyword system</li>
					<li>%description%: default description system</li>
					<li>%keySearch%: default keyword search</li>
					<li>%page%: default number page</li>
					<li>%pageMore%: default number page larger one</li>
				</ul>
			</div>
			
			<!-- Manufacturer -->
			<div id="tabs-4">
				<table width="100%" class="tableShow">
					<tr>
						<td valign="top" width="170px">Meta Title:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['manufacturer']['title'];?>" name="manufacturerTitle" class="classInput" placeholder="%title%" />
						</td>
					</tr>
					
					<tr>
						<td valign="top">Meta Keyword:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['manufacturer']['keyword'];?>" name="manufacturerKeyword" class="classInput" placeholder="%keyword%" />
						</td>
					</tr>
					
					<tr>
						<td valign="top">Meta Description:</td>
						<td valign="top">
							<input type="text" value="<?php echo @$listData['Option']['value']['manufacturer']['description'];?>" name="manufacturerDescription" class="classInput" placeholder="%description%" />
						</td>
					</tr>
				</table>
				<br/><br/>
				<ul>
					<li>%title%: default title system</li>
					<li>%keyword%: default keyword system</li>
					<li>%description%: default description system</li>
					<li>%manufacturerName%: default manufacturer name</li>
					<li>%manufacturerKeyword%: default manufacturer keyword</li>
					<li>%manufacturerDescription%: default manufacturer description</li>
					<li>%page%: default number page</li>
					<li>%pageMore%: default number page larger one</li>
				</ul>
			</div>

			<!-- SeoPath -->
			<div id="tabs-5">
				<table width="100%" class="tableShow">
					<tr>
						<td valign="top">
							product = <input type="text" value="<?php echo @$listData['Option']['value']['seoPath']['product'];?>" name="seoPathProduct" class="classInput" placeholder="product" />
						</td>
					</tr>
					
					<tr>
						<td valign="top">
							cat = <input type="text" value="<?php echo @$listData['Option']['value']['seoPath']['cat'];?>" name="seoPathCat" class="classInput" placeholder="category" />
						</td>
					</tr>

					<tr>
						<td valign="top">
							manufacturer = <input type="text" value="<?php echo @$listData['Option']['value']['seoPath']['manufacturer'];?>" name="seoPathManufacturer" class="classInput" placeholder="manufacturer" />
						</td>
					</tr>

					<tr>
						<td valign="top">
							cart = <input type="text" value="<?php echo @$listData['Option']['value']['seoPath']['cart'];?>" name="seoPathCart" class="classInput" placeholder="cart" />
						</td>
					</tr>

					<tr>
						<td valign="top">
							login = <input type="text" value="<?php echo @$listData['Option']['value']['seoPath']['login'];?>" name="seoPathLogin" class="classInput" placeholder="login" />
						</td>
					</tr>

					<tr>
						<td valign="top">
							logout = <input type="text" value="<?php echo @$listData['Option']['value']['seoPath']['logout'];?>" name="seoPathLogout" class="classInput" placeholder="logout" />
						</td>
					</tr>

					<tr>
						<td valign="top">
							register = <input type="text" value="<?php echo @$listData['Option']['value']['seoPath']['register'];?>" name="seoPathRegister" class="classInput" placeholder="register" />
						</td>
					</tr>

					<tr>
						<td valign="top">
							search = <input type="text" value="<?php echo @$listData['Option']['value']['seoPath']['search'];?>" name="seoPathSearch" class="classInput" placeholder="search" />
						</td>
					</tr>

					<tr>
						<td valign="top">
							discount = <input type="text" value="<?php echo @$listData['Option']['value']['seoPath']['discount'];?>" name="seoPathDiscount" class="classInput" placeholder="discount" />
						</td>
					</tr>

					<tr>
						<td valign="top">
							allProduct = <input type="text" value="<?php echo @$listData['Option']['value']['seoPath']['allProduct'];?>" name="seoPathAllProduct" class="classInput" placeholder="allProduct" />
						</td>
					</tr>
                    
                    <tr>
						<td valign="top">
							userInfo = <input type="text" value="<?php echo @$listData['Option']['value']['seoPath']['userInfo'];?>" name="seoPathUserInfo" class="classInput" placeholder="userInfo" />
						</td>
					</tr>
                    
                    <tr>
						<td valign="top">
							history = <input type="text" value="<?php echo @$listData['Option']['value']['seoPath']['history'];?>" name="seoPathHistory" class="classInput" placeholder="history" />
						</td>
					</tr>
				</table>
			</div>
		</div>
	</form>
</div>
