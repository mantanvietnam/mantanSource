<style type="text/css">
	.tableList{
		width: 100%;
		margin-bottom: 20px;
		border-collapse: collapse;
	    border-spacing: 0;
	    border-top: 1px solid #bcbcbc;
	    border-left: 1px solid #bcbcbc;
	}
	.tableList td,.tableList th{
		padding: 5px;
		border-bottom: 1px solid #bcbcbc;
	    border-right: 1px solid #bcbcbc;
	}
	.tableList th{
		text-align: center;
	}
	.tableList td td{
		padding: 5px;
		border: none !important;
	}
	.listComponents{clear: both;list-style: none;}
	.titleProperties{clear: both;margin: 0;padding-top: 10px;}
	.listComponents li{float: left;margin-right: 10px;}
	.noBorder td{
		border: none !important;
	}
	#tabs{
			width: 100%;
		}
	.tableShow td{
		padding: 10px;
		word-break: break-all;
	}
	.classInput{
		width: 85%;
	}
</style>
<?php
	$breadcrumb= array( 'name'=>'Setup Color',
						'url'=>$urlPlugins.'admin/setupColor-setup.php',
						'sub'=>array('name'=>'Setup')
					  );
	addBreadcrumbAdmin($breadcrumb);
?>
<script type="text/javascript" src="<?php echo $webRoot;?>ckfinder/ckfinder.js"></script>
<script type="text/javascript">
	function BrowseServerImage()
	{
		var finder = new CKFinder();
		finder.basePath = '../';	
		finder.selectActionFunction = SetFileFieldImage;
		finder.popup();
	}
	function SetFileFieldImage( fileUrl )
	{
		document.getElementById( 'img' ).value = fileUrl;
	}
</script>
    
<div class="thanhcongcu">
    <div class="congcu" onclick="addDataNew('','','','','');">
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
		<div style="margin-bottom:10px;">
			<input type="text" name="codeColor" placeholder="Mã hiển thị" />
			<input type="submit" value="Tìm" />
		</div>
        <table id="listTable" cellspacing="0" class="tableList">
                <tr>
                	<td align="center" width="30">STT</td>
                  <td align="center" width="30">Mã hiển thị</td>
                  <td align="center" width="150">Mã màu</td>
                  <td align="center" width="150">Ảnh</td>
                  <td align="center" width="30">Chọn</td>
                </tr>
                <?php
                	//debug ($listData);
                	if(isset($listData) && count($listData)>0){
                		$dem=0;
                    	foreach($listData as $components)
                    	{ 
                    		$dem++
                	?>
	                        <tr id="trList">
	                        <td align="center" ><?php echo $dem;?></td>
	                          <td align="center" ><?php if (isset($components['Color']['code'])) echo $components['Color']['code'];?></td>
	                          <td height="40"><?php if (isset($components['Color']['color'])) echo $components['Color']['color'];?></td>
	                          <td height="40"><img style="height: 30px;" src="<?php if (isset($components['Color']['img'])) echo $components['Color']['img'];?>" /></td>
	                           <td align="center" width="165" >
	                            <input class="input" type="button" value="Sửa" onclick="addDataNew(<?php echo '\''.$components['Color']['code'].'\',\''.$components['Color']['color'].'\',\''.$components['Color']['img'].'\',\''.$components['Color']['id'].'\'';?>);">
								&nbsp;
								<input class="input" type="button" value="Xóa" onclick="deleteData(<?php echo '\''.$components['Color']['id'].'\'';?>);">
	                          </td>            
	                        </tr>
                    <?php 
                    	}
                	}
                ?>

        </table>
        <p>
	    	<?php
		    	if($page>5){
					$startPage= $page-5;
				}else{
					$startPage= 1;
				}

				if($totalPage>$page+5){
					$endPage= $page+5;
				}else{
					$endPage= $totalPage;
				}
				
				echo '<a href="'.$urlNow.$back.'">Previous Page</a> ';
				for($i=$startPage;$i<=$endPage;$i++){
					if ($i==$page)
						echo ' <a href="'.$urlNow.$i.'"><strong style="color:red;">'.$i.'</strong></a> ';
					else
						echo ' <a href="'.$urlNow.$i.'">'.$i.'</a> ';
				}
				echo ' <a href="'.$urlNow.$next.'">Next Page</a> ';
		    ?>
		</p>
    </form>
</div>

<div id="themData">
    <form method="post" action="<?php echo $urlPlugins;?>admin/setupColor-saveSetup.php">
    	Cài đặt mã màu
      	<input type="hidden" value="" name="id" id="id" />
      	<input type="hidden" value="save" name="type" id="type" />
	  	<br /><br /><input type='text' id='code' name="code" value='' placeholder="Mã hiển thị" />
	  	<br /><br /><input type='text' id='color' name="color" value='' placeholder="Mã màu" />
	  	<br /><br /><input type='text' id='img' name="img" value='' placeholder="Đường dẫn ảnh" />
		&nbsp;&nbsp;<input type="button" value="Tải ảnh" onclick="BrowseServerImage();" />
	  	<br /><br /><input type='submit' value='Lưu' class='input' />
    </form>
</div>
	
<script type="text/javascript">
	var urlNow="<?php echo $urlNow; ?>";
	function addDataNew(code,color,img,id)
	{
		document.getElementById("id").value= id;
		document.getElementById("code").value= code;
		document.getElementById("color").value= color;
		document.getElementById("img").value= img;
		
	    $('#themData').lightbox_me({
	    centered: true, 
	    onLoad: function() { 
	        $('#themData').find('input:first').focus()
	        }
	    });
	}
	function deleteData(id)
	{	
	    var r= confirm("<?php echo 'Bạn chắc chắn xóa?';?>");
	    if(r==true)
	      	{
	          	$.ajax({
			    	type: "POST",
					url: "<?php echo $urlPlugins;?>admin/setupColor-saveSetup.php",
					data: { id:id,type:'delete'}
			    }).done(function( msg ) { 	
			  		window.location= urlNow;
				 })
				.fail(function() {
					window.location= urlNow;
				});  
	      }	
	}
</script>