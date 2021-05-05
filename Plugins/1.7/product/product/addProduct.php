<?php
	global $languageProduct;
?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>

<link href="<?php echo $urlHomes.'app/Plugin/product/style.css';?>" rel="stylesheet">

<?php
	function listCatShow($cat,$sau,$idCM)
	{
		if($cat['id']>0)
		{
			echo '<p style="padding-left: 10px;"  >';
			for($i=1;$i<=$sau;$i++)
			{
				echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			}

			if(in_array($cat['id'], $idCM) )
			{
				echo '<input type="checkbox" checked="checked" name="check_list[]" value="'.$cat['id'].'" />&nbsp&nbsp'.$cat['name'];
			}
			else
			{
				echo '<input type="checkbox" name="check_list[]" value="'.$cat['id'].'" />&nbsp&nbsp'.$cat['name'];
			}
			echo '</p>';
		}

		if(isset($cat['sub']) && count($cat['sub'])>0){
			foreach($cat['sub'] as $sub)
			{
				listCatShow($sub,$sau+1,$idCM);
			}
		}
	}
	
	function listCat($cat,$sau,$parent,$idSelect)
	{
		if($cat['id']>0)
		{
			if($idSelect!=$cat['id'])
			{
				echo '<option id="'.$parent.'" value="'.$cat['id'].'">';
			}
			else
			{
				echo '<option selected="" id="'.$parent.'" value="'.$cat['id'].'">';
			}
			
			for($i=1;$i<=$sau;$i++)
			{
				echo '&nbsp&nbsp&nbsp&nbsp';
			}
			echo $cat['name'].'</option>';
		}

		if(isset($cat['sub']) && count($cat['sub'])>0){
			foreach($cat['sub'] as $sub)
			{
				listCat($sub,$sau+1,$cat['id'],$idSelect);
			}
		}
	}
?>

<?php
	$breadcrumb= array( 'name'=>$languageProduct['ProductList'],
						'url'=>$urlPlugins.'admin/product-product-listProduct.php',
						'sub'=>array('name'=>$languageProduct['AddProduct'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 
  
    <script type="text/javascript">
	
	    function saveData()
	    {
	        var tieude= document.getElementById("title").value;
	        
	        if(tieude == '')
	        {
		        alert('<?php echo $languageProduct['YouMustFillOutTheInformationBelow'];?>');
	        }
	        else
	        {
	
	            document.dangtin.submit();
	
	        }
	
	    }
		
		function editDate(ngay,thang,nam)
	    {
		    
		    var i,str;
		    str= '<select name="ngay">';
		    for(i=1;i<=31;i++)
		    {
			    if(i!=ngay)
			    {
				    str= str+'<option value="'+i+'"><?php echo $languageMantan['date'];?> '+i+'</option>';
			    }
			    else
			    {
				    str= str+'<option selected="selected" value="'+i+'"><?php echo $languageMantan['date'];?> '+i+'</option>';
			    }
		    }
		    str= str+'</select>&nbsp;&nbsp;';
		    
		    str= str+ '<select name="thang">';
		    for(i=1;i<=12;i++)
		    {
			    if(i!=thang)
			    {
				    str= str+'<option value="'+i+'"><?php echo $languageMantan['month'];?> '+i+'</option>';
			    }
			    else
			    {
				    str= str+'<option selected="selected" value="'+i+'"><?php echo $languageMantan['month'];?> '+i+'</option>';
			    }
		    }
		    str= str+'</select>&nbsp;&nbsp;';
		    
		    str= str+ '<select name="nam">';
		    for(i=nam-10;i<=nam+10;i++)
		    {
			    if(i!=nam)
			    {
				    str= str+'<option value="'+i+'"><?php echo $languageMantan['year'];?> '+i+'</option>';
			    }
			    else
			    {
				    str= str+'<option selected="selected" value="'+i+'"><?php echo $languageMantan['year'];?> '+i+'</option>';
			    }
		    }
		    str= str+'</select>&nbsp;&nbsp;';
		    
		    document.getElementById("ngayDang").innerHTML= str;
	    }
	</script>
	
	
	<div class="thanhcongcu">
	    <div class="congcu" onclick="saveData();">
	        <input type="hidden" id="idChange" value="" />
	        <span id="save">
	          <input type="image" src="<?php echo $webRoot;?>images/save.png" />
	        </span>
	        <br/>
	        <?php echo $languageProduct['Save'];?>
	    </div>
	
	</div>
	
	<div class="clear"></div>
	
	<div id="content">
	<script LANGUAGE="JavaScript">
		function countCharacter(field,count){
		var dodai = field.value.length;
		count.value = field.value.length
		}
	</script>
	<form action="<?php echo $urlPlugins;?>admin/product-saveProduct.php" method="post" name="dangtin" enctype="multipart/form-data">
	
	    <input type="hidden" value="<?php echo (isset($news['Product']['id']))?$news['Product']['id']:'';?>" name="id" />
	    
	    
	    <div id="tabs">
			<ul>
				<li><a href="#tabs-1"><?php echo $languageProduct['ProductDescription'];?></a></li>
				<li><a href="#tabs-2"><?php echo $languageProduct['ProductInformation'];?></a></li>
				<li><a href="#tabs-3"><?php echo $languageProduct['Image'];?></a></li>
				<li><a href="#tabs-4"><?php echo $languageProduct['Discounts'];?></a></li>
				<li><a href="#tabs-5"><?php echo $languageProduct['AdditionalAttributes'];?></a></li>
				<li><a href="#tabs-6"><?php echo $languageProduct['OtherInformation'];?></a></li>
				
			</ul>
			<!-- Product Description -->
			
			<div id="tabs-1">
				<table width="100%">
					<tr>
						<td valign="top">
							<div style="margin-right: 40px;margin-bottom: 10px;width: 100%">
								<p><b><?php echo $languageProduct['ProductName'];?></b><span style="color:#bbb;"> - Số ký : <input readonly type="text" name="leftName" size=3 maxlength=3 value="0" disabled="disabled" style="border: 0;background: #fff;"></span></p>
								<div style="width: 90%;">
								<input style="" type="text" name="title" value="<?php echo (isset($news['Product']['title']))?$news['Product']['title']:'' ;?>" class="form-control"  id="title" onKeyDown="countCharacter(this.form.title, this.form.leftName);" onKeyUp="countCharacter(this.form.title,this.form.leftName);"/>

								</div>
							

							</div>
							<div style="float:left;width: 100%;">
								<p style="clear: both;"><b><?php echo $languageProduct['NameForSeo'];?></b><span style="color:#bbb;"> - Số ký : <input readonly type="text" name="leftNameSeo" size=3 maxlength=3 value="0" disabled="disabled" style="border: 0;background: #fff;"></span></p>

								<div style="width: 90%;">
								<input style="" type="text" name="nameSeo" value="<?php echo (isset($news['Product']['nameSeo']))?$news['Product']['nameSeo']:'' ;?>" class="form-control"  id="nameSeo" onKeyDown="countCharacter(this.form.nameSeo, this.form.leftNameSeo);" onKeyUp="countCharacter(this.form.nameSeo,this.form.leftNameSeo);" />

								</div>
							
							</div>
							
							<div style="float:left;margin-right: 40px;margin-bottom: 10px;clear: both;">
								<p><b><?php echo $languageProduct['Bestsellers'];?></b></p>
								<input type="radio" name="hot" value="0" <?php if(isset($news['Product']['hot']) && $news['Product']['hot']==0) echo 'checked=""';?> /> <?php echo $languageProduct['No'];?> 
								<input type="radio" name="hot" value="1" <?php if(isset($news['Product']['hot']) && $news['Product']['hot']==1) echo 'checked=""';?> /> <?php echo $languageProduct['Yes'];?> 
							
							</div>
							<div style="float:left;">
								<p><b><?php echo $languageMantan['datePosted'];?></b></p>
								<p id="ngayDang">
									<?php
										
										if(isset($news['Product']['timeUp']) && $news['Product']['timeUp']>0)
										{
											$today= getdate($news['Product']['timeUp']);
											$str= '<select name="ngay">';
											for($i=1;$i<=31;$i++)
											{
												if($i!=$today['mday'])
												{
													$str= $str.'<option value="'.$i.'">'.$languageMantan['date'].' '.$i.'</option>';
												}
												else
												{
													$str= $str.'<option selected="selected" value="'.$i.'">'.$languageMantan['date'].' '.$i.'</option>';
												}
											}
											$str= $str.'</select>&nbsp;&nbsp;';
											
											$str= $str. '<select name="thang">';
											for($i=1;$i<=12;$i++)
											{
												if($i!=$today['mon'])
												{
													$str= $str.'<option value="'.$i.'">'.$languageMantan['month'].' '.$i.'</option>';
												}
												else
												{
													$str= $str.'<option selected="selected" value="'.$i.'">'.$languageMantan['month'].' '.$i.'</option>';
												}
											}
											$str= $str.'</select>&nbsp;&nbsp;';
											
											$str= $str. '<select name="nam">';
											for($i=$today['year']-10;$i<=$today['year']+10;$i++)
											{
												if($i!=$today['year'])
												{
													$str= $str.'<option value="'.$i.'">'.$languageMantan['year'].' '.$i.'</option>';
												}
												else
												{
													$str= $str.'<option selected="selected" value="'.$i.'">'.$languageMantan['year'].' '.$i.'</option>';
												}
											}
											$str= $str.'</select>&nbsp;&nbsp;';
											
											echo $str;
										}
										else
										{
											$today= getdate();
											echo $today['mday'].'/'.$today['mon'].'/'.$today['year'];
											echo '  &nbsp;&nbsp;&nbsp;
													<a href="javascript:void(0)" onclick="editDate('.$today['mday'].','.$today['mon'].','.$today['year'].');" style="text-decoration: underline;">'.$languageMantan['edit'].'</a>';
										}
										
									?>
									
								</p>
							</div>
							
							<p style="clear: both;"><b><?php echo $languageProduct['Alias'];?></b></p>
							<input type="text" value="<?php echo (isset($news['Product']['alias']))?$news['Product']['alias']:'';?>" name="alias" id="alias" class="form-control" />
							<p style="clear: both;"><b><?php echo $languageProduct['ShortDescription'];?></b><span style="color:#bbb;"> - Số ký tự : <input readonly type="text" name="leftDescription" size=3 maxlength=3 value="0" disabled="disabled" style="border: 0;background: #fff;"></span></p>
							<textarea class="form-control"  name="description"  id="description" onKeyDown="countCharacter(this.form.description, this.form.leftDescription);" onKeyUp="countCharacter(this.form.description,this.form.leftDescription);" cols="59" rows="10"><?php echo (isset($news['Product']['description']))?$news['Product']['description']:'';?></textarea>
							<p><b><?php echo $languageProduct['Keywords'];?></b></p>
							<textarea class="form-control" rows="5" name="key" id='key'><?php echo (isset($news['Product']['key']))?$news['Product']['key']:'';?></textarea>
						</td>
						<td valign="top" style="padding-left: 15px;">
							<p><b><?php echo $languageProduct['ProductCategory'];?></b></p>
							<?php
								if(isset($listCategory['Option']['value']['category']) && count($listCategory['Option']['value']['category'])>0){
									if(isset($news['Product']['category'])){
										$categorySelect= $news['Product']['category'];
									}else{
										$categorySelect= array();
									}

									foreach($listCategory['Option']['value']['category'] as $cat){
										listCatShow($cat,0,$categorySelect);
									}
								}
					        ?>
						</td>
					</tr>
				</table>
			</div>
			
			<!-- Product Information -->
			<div id="tabs-2">
				<?php showEditorInput('info','info',@$news['Product']['info']);?>
			</div>
			
			<!-- Image -->
			<div id="tabs-3">
				<?php
					for($i=0;$i<=11;$i++)
					{
						if(!isset($news['Product']['images'][$i])){
							$images[$i]= $urlHomes.'/app/Plugin/product/images/no_image-100x100.jpg';
						}else{ 
							$images[$i]= $news['Product']['images'][$i];
						}
					}
				?>
				<table width="100%">
					<tr>
						<td>
							<img src="<?php echo $images[0];?>" width="100" style="float: left; margin-right: 5px;"/> 
							<div style="margin-top: 37px;">
								<?php showUploadFile('image0','image0',@$news['Product']['images'][0],0);?>
							</div>
						</td>
						<td>
							<img src="<?php echo $images[1];?>" width="100" style="float: left; margin-right: 5px;"/> 
							<div style="margin-top: 37px;">
								<?php showUploadFile('image1','image1',@$news['Product']['images'][1],1);?>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<img src="<?php echo $images[2];?>" width="100" style="float: left; margin-right: 5px;"/> 
							<div style="margin-top: 37px;">
								<?php showUploadFile('image2','image2',@$news['Product']['images'][2],2);?>
							</div>
						</td>
						<td>
							<img src="<?php echo $images[3];?>" width="100" style="float: left; margin-right: 5px;"/> 
							<div style="margin-top: 37px;">
								<?php showUploadFile('image3','image3',@$news['Product']['images'][3],3);?>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<img src="<?php echo $images[4];?>" width="100" style="float: left; margin-right: 5px;"/> 
							<div style="margin-top: 37px;">
								<?php showUploadFile('image4','image4',@$news['Product']['images'][4],4);?>
							</div>
						</td>
						<td>
							<img src="<?php echo $images[5];?>" width="100" style="float: left; margin-right: 5px;"/> 
							<div style="margin-top: 37px;">
								<?php showUploadFile('image5','image5',@$news['Product']['images'][5],5);?>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<img src="<?php echo $images[6];?>" width="100" style="float: left; margin-right: 5px;"/> 
							<div style="margin-top: 37px;">
								<?php showUploadFile('image6','image6',@$news['Product']['images'][6],6);?>
							</div>
						</td>
						<td>
							<img src="<?php echo $images[7];?>" width="100" style="float: left; margin-right: 5px;"/> 
							<div style="margin-top: 37px;">
								<?php showUploadFile('image7','image7',@$news['Product']['images'][7],7);?>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<img src="<?php echo $images[8];?>" width="100" style="float: left; margin-right: 5px;"/> 
							<div style="margin-top: 37px;">
								<?php showUploadFile('image8','image8',@$news['Product']['images'][8],8);?>
							</div>
						</td>
						<td>
							<img src="<?php echo $images[9];?>" width="100" style="float: left; margin-right: 5px;"/> 
							<div style="margin-top: 37px;">
								<?php showUploadFile('image9','image9',@$news['Product']['images'][9],9);?>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<img src="<?php echo $images[10];?>" width="100" style="float: left; margin-right: 5px;"/> 
							<div style="margin-top: 37px;">
								<?php showUploadFile('image10','image10',@$news['Product']['images'][10],10);?>
							</div>
						</td>
						<td>
							<img src="<?php echo $images[11];?>" width="100" style="float: left; margin-right: 5px;"/> 
							<div style="margin-top: 37px;">
								<?php showUploadFile('image11','image11',@$news['Product']['images'][11],11);?>
							</div>
						</td>
					</tr>
				</table>
			</div>
			
			<!-- Discounts -->
			<div id="tabs-4">
				<table>
					<tr>
						<td width="460">
							<p><?php echo $languageProduct['FromDate'];?></p>
							<select name="dateStart">
								<option value=""><?php echo $languageProduct['SelectADate'];?></option>
								<?php
									if(isset($news['Product']['dateDiscountStart'])) $dateDiscountStart= getdate($news['Product']['dateDiscountStart']);
									for($i=1;$i<=31;$i++)
									{
										if(!isset($dateDiscountStart['mday']) || $i!=$dateDiscountStart['mday'])
										{
											echo '<option value="'.$i.'">'.$languageProduct['Date'].' '.$i.'</option>';
										}
										else
										{
											echo '<option selected="" value="'.$i.'">'.$languageProduct['Date'].' '.$i.'</option>';
										}
									}
								?>
							</select> 
							<select name="monthStart">
								<option value=""><?php echo $languageProduct['SelectAMonth'];?></option>
								<?php
									for($i=1;$i<=12;$i++)
									{
										if(!isset($dateDiscountStart['mon']) || $i!=$dateDiscountStart['mon'])
										{
											echo '<option value="'.$i.'">'.$languageProduct['Month'].' '.$i.'</option>';
										}
										else
										{
											echo '<option selected="" value="'.$i.'">'.$languageProduct['Month'].' '.$i.'</option>';
										}
									}
								?>
							</select> 
							<select name="yearStart">
								<option value=""><?php echo $languageProduct['SelectAYear'];?></option>
								<?php
									$today= getdate();
									for($i=$today['year'];$i<=$today['year']+10;$i++)
									{
										if(!isset($dateDiscountStart['year']) || $i!=$dateDiscountStart['year'])
										{
											echo '<option value="'.$i.'">'.$languageProduct['Year'].' '.$i.'</option>';
										}
										else
										{
											echo '<option selected="" value="'.$i.'">'.$languageProduct['Year'].' '.$i.'</option>';
										}
									}
								?>
							</select>
						</td>
						<td>
							<p><?php echo $languageProduct['ToDate'];?></p>
							<select name="dateEnd">
								<option value=""><?php echo $languageProduct['SelectADate'];?></option>
								<?php
									if(isset($news['Product']['dateDiscountEnd'])) $dateDiscountEnd= getdate($news['Product']['dateDiscountEnd']);
									for($i=1;$i<=31;$i++)
									{
										if(!isset($dateDiscountEnd['mday']) || $i!=$dateDiscountEnd['mday'])
										{
											echo '<option value="'.$i.'">'.$languageProduct['Date'].' '.$i.'</option>';
										}
										else
										{
											echo '<option selected="" value="'.$i.'">'.$languageProduct['Date'].' '.$i.'</option>';
										}
									}
								?>
							</select> 
							<select name="monthEnd">
								<option value=""><?php echo $languageProduct['SelectAMonth'];?></option>
								<?php
									for($i=1;$i<=12;$i++)
									{
										if(!isset($dateDiscountEnd['mon']) || $i!=$dateDiscountEnd['mon'])
										{
											echo '<option value="'.$i.'">'.$languageProduct['Month'].' '.$i.'</option>';
										}
										else
										{
											echo '<option selected="" value="'.$i.'">'.$languageProduct['Month'].' '.$i.'</option>';
										}
									}
								?>
							</select> 
							<select name="yearEnd">
								<option value=""><?php echo $languageProduct['SelectAYear'];?></option>
								<?php
									$today= getdate();
									for($i=$today['year'];$i<=$today['year']+10;$i++)
									{
										if(!isset($dateDiscountEnd['year']) || $i!=$dateDiscountEnd['year'])
										{
											echo '<option value="'.$i.'">'.$languageProduct['Year'].' '.$i.'</option>';
										}
										else
										{
											echo '<option selected="" value="'.$i.'">'.$languageProduct['Year'].' '.$i.'</option>';
										}
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<p><?php echo $languageProduct['PriceDiscount'];?></p>
							<input type="text" name="priceDiscount" id='priceDiscount' value="<?php echo (isset($news['Product']['priceDiscount']))?$news['Product']['priceDiscount']:'' ;?>" style="width: 300px;" />
						</td>
						<td>
							<p><?php echo $languageProduct['CodeDiscount'];?></p>
							<input type="text" placeholder="Eg: trx100,tr52hk,6tuy43" name="codeDiscount" id='codeDiscount' value="<?php if(isset($news['Product']['codeDiscount'])) echo implode(',', $news['Product']['codeDiscount']);?>" style="width: 300px;" />
						</td>
					</tr>
					<tr>
						<td>
							<p>Số lượng giảm</p>
							<input type="hidden" name="numberDiscountActive" id='numberDiscountActive' value="<?php echo (isset($news['Product']['numberDiscountActive']))?$news['Product']['numberDiscountActive']:0 ;?>" style="width: 300px;" />
							<input type="text" name="numberDiscount" id='numberDiscount' value="<?php echo (isset($news['Product']['numberDiscount']))?$news['Product']['numberDiscount']:'' ;?>" style="width: 300px;" />
						</td>
						<td></td>
					</tr>
				</table>
			</div>
			
			<!-- Additional Attributes -->
			<div id="tabs-5">
				<?php
					if(!$listProperties)
					{
						echo $languageProduct['NoAdditionalAttributes'];
					}
					else
					{
						if(count($listProperties['Option']['value']['allData'])>0){
							foreach($listProperties['Option']['value']['allData'] as $components){
								echo '<p class="titleProperties"><b>'.$components['name'].'</b></p>';

								if($components['typeShow']==3){
									echo '<input type="text" value="'.@$news['Product']['properties'][$components['id']].'" name="value'.$components['id'].'" />';
								}else{
									echo '<ul class="listComponents">';
										  	if(isset($components['allData']) && count($components['allData'])>0){
											  	foreach($components['allData'] as $allData)
											  	{
											  		$check= '';
											  		if(isset($news['Product']['properties'][$components['id']]) && in_array($allData['id'], $news['Product']['properties'][$components['id']])) $check= 'checked';
											  		
											  		switch($components['typeShow'])
											  		{
												  		// Radio
												  		case 1: $nameInput='value'.$components['id'];
												  				$typeInput= 'radio';
												  				$valueInput= $allData['id'];
												  				break;
												  		// Check box
												  		case 2: $nameInput='value'.$components['id'].'[]';
												  				$typeInput= 'checkbox';
												  				$valueInput= $allData['id'];
												  				break;
											  		}
											  		
												  	echo '<li><input '.$check.' type="'.$typeInput.'" name="'.$nameInput.'" value="'.$valueInput.'" /> '.$allData['name'].'</li>';
											  	}
										  	}
									echo '</ul>';
								}
							}
						}
						
					}
				?>
			</div>
			
			<!-- Other Information -->
			<div id="tabs-6">
				<table class="noBorder tableList">
					<tr>
						<td valign="top">
							<p><?php echo $languageProduct['CodeProduct'];?></p>
							<input type="text" class="form-control" onkeyup="checkCodeProduct();" name="code" id='code' value="<?php echo (isset($news['Product']['code']))?$news['Product']['code']:'';?>"  />
							<p id="messCodeProduct" style="color: red;"></p>
						</td>
						<td valign="top">
							<p><?php echo $languageProduct['Mass'];?> (kg)</p>
							<input type="number" class="form-control" name="mass" id='mass' value="<?php echo (isset($news['Product']['mass']))?$news['Product']['mass']:'';?>" />
						</td>
						<td valign="top">
							<p><?php echo $languageProduct['Manufacturer'];?></p>
							<select name="manufacturerId" class="form-control" >
								<?php
									if(isset($listManufacturer['Option']['value']['category']) && count($listManufacturer['Option']['value']['category'])>0){
										foreach($listManufacturer['Option']['value']['category'] as $cat)
										{
											listCat($cat,0,0,@$news['Product']['manufacturerId']);
		
										}	
									}
								?>
							</select>
						</td>
						<td rowspan="3" valign="top" style="padding-left: 15px;">
							  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
							  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
							  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
							  <style>
							  .ui-autocomplete-loading {
							    background: white url("https://jqueryui.com/resources/demos/autocomplete/images/ui-anim_basic_16x16.gif") right center no-repeat;
							  }
							  </style>
							  <script>
							  $(function() {
							    function split( val ) {
							      return val.split( /,\s*/ );
							    }
							    function extractLast( term ) {
							      return split( term ).pop();
							    }
							 
							    $( "#birds" )
							      // don't navigate away from the field on tab when selecting an item
							      .bind( "keydown", function( event ) {
							        if ( event.keyCode === $.ui.keyCode.TAB &&
							            $( this ).autocomplete( "instance" ).menu.active ) {
							          event.preventDefault();
							        }
							      })
							      .autocomplete({
							        source: function( request, response ) {
							          $.getJSON( "<?php echo $urlHomes.'searchAjaxProductOther'?>", {
							            term: extractLast( request.term )
							          }, response );
							        },
							        search: function() {
							          // custom minLength
							          var term = extractLast( this.value );
							          if ( term.length < 2 ) {
							            return false;
							          }
							        },
							        focus: function() {
							          // prevent value inserted on focus
							          return false;
							        },
							        select: function( event, ui ) {
							          var terms = split( this.value );
							          // remove the current input
							          terms.pop();
							          // add the selected item
							          terms.push( ui.item.label );
							          // add placeholder to get the comma-and-space at the end
							          terms.push( "" );
							          this.value = terms.join( "," );

							          var otherProductID= $('#otherProductID').val();
							          if(otherProductID!=''){
							          	$('#otherProductID').val(otherProductID+','+ui.item.id);
							      	  }else{
							      	  	$('#otherProductID').val(ui.item.id);
							      	  }

							          return false;
							        }
							      });
							  });
							  </script>

							<div class="ui-widget">
							    <p>Sản phẩm liên quan</p>
							    <textarea id="birds" size="50" cols="40" rows="7" name="otherProductTitle"><?php echo (isset($news['Product']['otherProductTitle']))?$news['Product']['otherProductTitle']:'';?></textarea>
							    <input id="otherProductID" type="hidden" name="otherProductID" value="<?php echo (isset($news['Product']['otherProductID']))?$news['Product']['otherProductID']:'';?>" />
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<p><?php echo $languageProduct['Saleprice'];?></p>
							<input type="number" name="price" id='price' value="<?php echo (isset($news['Product']['price']))?$news['Product']['price']:'';?>" style="width: 100px;" />
						</td>
						<td>
							<p><?php echo $languageProduct['MarketPrice'];?></p>
							<input type="number" name="priceOther" id='priceOther' value="<?php echo (isset($news['Product']['priceOther']))?$news['Product']['priceOther']:'';?>" style="width: 100px;" />
						</td>
						<td>
							<p><?php echo $languageProduct['Currency'];?></p>
							<select name="typeMoneyId">
								<?php
									if(isset($listTypeMoney['Option']['value']['allData']) && count($listTypeMoney['Option']['value']['allData'])>0){
										foreach($listTypeMoney['Option']['value']['allData'] as $components)
										{
											if($components['id']!=$news['Product']['typeMoneyId'])
											{
												echo '<option value="'.$components['id'].'">'.$components['name'].'</option>';
											}
											else
											{
												echo '<option value="'.$components['id'].'" selected="">'.$components['name'].'</option>';
											}
										}
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<p><?php echo $languageProduct['Quantity'];?></p>
							<input type="number" name="quantity" id='quantity' value="<?php echo (isset($news['Product']['quantity']))?$news['Product']['quantity']:'';?>" style="width: 100px;" />
						</td>
						<td>
							<p><?php echo $languageProduct['Warranty'];?></p>
							<input type="text" name="warranty" id='warranty' value="<?php echo (isset($news['Product']['warranty']))?$news['Product']['warranty']:'';?>" style="width: 100px;" />
						</td>
						<td>
							<p><?php echo $languageProduct['Status'];?></p>
							<select name="lock">
								<option value="0" <?php if(isset($news['Product']['lock']) && $news['Product']['lock']==0) echo 'selected=""';?> ><?php echo $languageProduct['Active'];?></option>
								<option value="1" <?php if(isset($news['Product']['lock']) && $news['Product']['lock']==1) echo 'selected=""';?> ><?php echo $languageProduct['Deactivate'];?></option>
							</select>
						</td>
					</tr>
					
				</table>
			</div>
			
			
		</div>
	</form>
</div>

<script type="text/javascript">
	function checkCodeProduct()
	{
		var code= $('#code').val();

		$.ajax({
		  method: "GET",
		  url: "/checkCodeProductAPI",
		  data: { code: code }
		})
		  .done(function( msg ) {
		  	console.log(msg);
		  	if(msg=='1'){
		  		$('#messCodeProduct').html('Mã code này đã tồn tại');
		  	}else{
		  		$('#messCodeProduct').html('&nbsp;');
		  	}
		  });
	}
</script>
