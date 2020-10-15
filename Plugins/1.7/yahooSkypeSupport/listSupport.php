<style>
.tableList{
	width: 100%;
	margin-bottom: 20px;
	border-collapse: collapse;
    border-spacing: 0;
    border-top: 1px solid #bcbcbc;
    border-left: 1px solid #bcbcbc;
}
.tableList td{
	padding: 5px;
	border-bottom: 1px solid #bcbcbc;
    border-right: 1px solid #bcbcbc;
}
</style>

<?php
	$breadcrumb= array( 'name'=>'Hỗ trợ trực tuyến',
						'url'=>$urlPlugins.'admin/yahooSkypeSupport-listSupport.php',
						'sub'=>array('name'=>'Danh sách nick')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 
    
	  <div class="thanhcongcu">
	      <div class="congcu" onclick="addDataNew();">
	        <span>
	          <input type="image"  src="<?php echo $webRoot;?>images/add.png" />
	        </span>
	        <br/>
	        Thêm
	      </div>
	      
	  </div>
	  <div class="clear"></div>
	  <br />
	  
	  <div class="taovien" >
	    <form action="" method="post" name="listForm">
			<p style="color: red;"><?php echo $mess;?></p>
	    	<script type="text/javascript" src="http://www.skypeassets.com/i/scom/js/skype-uri.js"></script>
	        <table id="listTable" cellspacing="0" class="tableList">
	
	                <tr>
	                  <td align="center" width="30">ID</td>
	                  <td align="center" >Nick hỗ trợ</td>
	                  <td align="center" >Nhóm hỗ trợ</td>
	                  <td align="center" >Thông tin</td>
	                  <td align="center" >Kiểu hiển thị</td>
	                  <td align="center" width="130">Chọn</td>
	                </tr>
	                <?php
						if(isset($listData['Option']['value']['allData']) && count($listData['Option']['value']['allData'])>0){
							foreach($listData['Option']['value']['allData'] as $components)
							{ 
	                ?>
	                        <tr>
	                          <td align="center" ><?php echo $components['id'];?></td>
	                          <td height="40" id="name<?php echo $components['id'];?>"><?php echo $components['nick'];?></td>
	                          <td><?php echo @$listDataCategory['Option']['value']['allData'][ $components['category'] ]['name'];?></td>
	                          <td><?php echo $components['info'];?></td>
	                          <td align="center">
	                          	  <?php if($components['typeNick']=='yahoo'){ ?>
		                          <a href="ymsgr:sendim?<?php echo $components['nick'];?>">
			                          <img border="0" src="http://opi.yahoo.com/online?u=<?php echo $components['nick'];?>&amp;m=g&amp;t=<?php echo $components['style'];?>">
			                      </a>
			                      <?php }else if($components['typeNick']=='skype'){ ?>
			                        
									<div id="SkypeButton_Call_<?php echo $components['nick'].'_'.$components['id'];?>">
									  <script type="text/javascript">
									    Skype.ui({
									      "name": "chat",
									      "element": "SkypeButton_Call_<?php echo $components['nick'].'_'.$components['id'];?>",
									      "participants": ["<?php echo $components['nick'];?>"],
									      "imageSize": 32
									    });
									  </script>
									</div>
			                      <?php }?>
	                          </td>
	                          <td align="center" >
	                            <input class="input" type="button" value="Sửa" onclick="changeName(<?php echo $components['id'];?>,'<?php echo $components['nick'];?>','<?php echo $components['info'];?>',<?php echo $components['style'];?>,<?php echo $components['category'];?>,'<?php echo $components['typeNick'];?>');">
								&nbsp;
								<input class="input" type="button" value="Xóa" onclick="deleteData('<?php echo $components['id'];?>');">
	                          </td>
	                        </tr>
	                    <?php 
							}
						}
	                ?>
	
	        </table>
	    </form>
	  </div>
	  <div id="themData">
	      <form method="post" action="" name="listForm">
	      	<input type="hidden" value="" name="id" id="idData" />
	      	<input type="hidden" value="save" name="type" />
	      	<input type="hidden" value="1" name="redirect" />
		  	<p>Nick hỗ trợ</p>
		  	<input type='text' id='nick' name="nick" value='' placeholder="VD: tranmanhbk179" style="width: 200px;" />
		  	<p>Thông tin</p>
		  	<input type='text' id='info' name="info" value='' placeholder="VD: Mr.Mạnh 01636741174" style="width: 200px;" />
		  	<br/><br/>
		  	<p>Nhóm hỗ trợ</p>
		  	<select name="category" id='category'> 
		  	<?php
		  		foreach($listDataCategory['Option']['value']['allData'] as $components)
		  		{
			  		echo '<option value="'.$components['id'].'">'.$components['name'].'</option>';
		  		}
		  	?>
		  	</select>
		  	<br/><br/>
		  	<table width="200">
			  	<tr>
			  		<td align="center">Kiểu nick</td>
				  	<td width="50%" align="center">Kiểu hiển thị</td>
				  	
			  	</tr>
			  	<tr>
			  		<td align="center">
					  	<select name="typeNick" id='typeNick'> 
						  	<option value="yahoo">Yahoo</option>
						  	<option value="skype">Skype</option>
					  	</select>
				  	</td>
				  	<td align="center">
					  	<select name="style" id='style'> 
						  	<?php
						  		for($i=0;$i<=24;$i++)
						  		{
							  		echo '<option value="'.$i.'">'.$i.'</option>';
						  		}
						  	?>
					  	</select>
				  	</td>
				  	
			  	</tr>
		  	</table>
		  	
		  	<br/>
		  	<center><input type='submit' value='Lưu' class='input' /></center>
	      </form>
	  </div>
	
<script type="text/javascript">
	var urlNow="<?php echo $urlNow;?>";
	
	function setCheckedValue(radioObj) {
		if(!radioObj)
	    {
			return;
	    }
		var radioLength = radioObj.length;
	
		for(var i = 0; i < radioLength; i++)
	    {
			radioObj[i].checked = false;
		}
	}

	function changeName(id,nick,info,style,category,typeNick)
	{
		setCheckedValue(document.forms['listForm'].elements['style']);
		setCheckedValue(document.forms['listForm'].elements['category']);
		setCheckedValue(document.forms['listForm'].elements['typeNick']);
		
		document.getElementById("idData").value= id;
		document.getElementById("nick").value= nick;
		document.getElementById("info").value= info;
		
		var x=document.getElementById("style");
		for (j=0;j<x.length;j++)
		{
			if(style == x.options[j].value)
			{
				x.options[j].selected= "selected";
				break;
			}
		}
		
		x=document.getElementById("category");
		for (j=0;j<x.length;j++)
		{
			if(category == x.options[j].value)
			{
				x.options[j].selected= "selected";
				break;
			}
		}
		
		x=document.getElementById("typeNick");
		for (j=0;j<x.length;j++)
		{
			if(typeNick == x.options[j].value)
			{
				x.options[j].selected= "selected";
				break;
			}
		}
		
		$('#themData').lightbox_me({
	    centered: true, 
	    onLoad: function() { 
	        $('#themData').find('input:first').focus()
	        }
	    });
	}
	
	function addDataNew()
	{
		document.getElementById("idData").value= '';
		document.getElementById("nick").value= '';
		document.getElementById("info").value= '';
		document.getElementById("style").value= '';
		
	    $('#themData').lightbox_me({
	    centered: true, 
	    onLoad: function() { 
	        $('#themData').find('input:first').focus()
	        }
	    });
	}
	
	function deleteData(id)
	{
	      var r= confirm("Bạn có chắc chắn muốn xóa không ?");
	      if(r==true)
	      {
	          $.ajax({
			      type: "POST",
			      url: urlNow,
			      data: { id:id,type:'delete',redirect:0}
			    }).done(function( msg ) { 	
					alert('Xóa dữ liệu thành công');
				  	window.location= urlNow;	
				 })
				 .fail(function() {
						window.location= urlNow;
					});  
	      }
	
	}
	</script>
</div>