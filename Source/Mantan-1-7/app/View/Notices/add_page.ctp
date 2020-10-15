<?php
	$breadcrumb= array( 'name'=>$languageMantan['pages'],
						'url'=>$urlNotices.'listPages',
						'sub'=>array('name'=>$languageMantan['addNew'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  
  
    <script type="text/javascript">

	    var urlWeb="<?php echo $urlNotices;?>";
			
	    function saveThemNotices()
	    {
	        var tieude= document.getElementById("title").value;
	        
	        if(tieude == '')
	        {
		        alert('<?php echo $languageMantan['youMustFillOutTheInformationBelow'];?>');
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
	
	
	    <div class="congcu" onclick="saveThemNotices();">
	
	        <span id="save">
	
	          <input type="image" src="<?php echo $webRoot;?>images/save.png" />
	
	        </span>
	
	        <br/>
	
	        <?php echo $languageMantan['save'];?>
	
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
	<form action="<?php echo $urlNotices;?>savePages" method="post" name="dangtin" enctype="multipart/form-data">
	
	    <input type="hidden" value="<?php if(isset($news['Notice']['id'])) echo $news['Notice']['id'];?>" name="id" />
	    
	    <table class="table" cellspacing="0">
	
	        <tr>
	
	            <td width="70%" colspan="2">
					<p><b><?php echo $languageMantan['title'];?> (*)</b><span style="color:#bbb;"> - Số ký tự : <input readonly type="text" name="leftName" size=3 maxlength=3 value="0" disabled="disabled" style="border: 0;background: #fff;"></span></p>
						<p>
						<input style="" type="text" name="title" value="<?php echo (isset($news['Notice']['title']))?$news['Notice']['title']:'' ;?>" class="form-control"  id="title" onKeyDown="countCharacter(this.form.title, this.form.leftName);" onKeyUp="countCharacter(this.form.title,this.form.leftName);" />

					</p>
				</td>
				
	            <td rowspan="3">
					<p><b><?php echo $languageMantan['description'];?></b><span style="color:#bbb;"> - Số ký tự : <input readonly type="text" name="leftDescription" size=3 maxlength=3 value="0" disabled="disabled" style="border: 0;background: #fff;"></span></p>
			<textarea name="introductory"  id="introductory" onKeyDown="countCharacter(this.form.introductory, this.form.leftDescription);" onKeyUp="countCharacter(this.form.introductory,this.form.leftDescription);" class="form-control" rows="5"><?php if(isset($news['Notice']['introductory'])) echo $news['Notice']['introductory'];?></textarea>
				</td>
	
	        </tr>
			
			<tr>
				<td height="85">
					<p><?php echo $languageMantan['keyWord'];?></p>
					<p>
						<input type="text" name="key" id='key' value="<?php if(isset($news['Notice']['key'])) echo $news['Notice']['key'];?>" class="form-control" />
					</p>
				</td>
				
				<td>
					<p><?php echo $languageMantan['author'];?></p>
					<p><input type="text" class="form-control" name="author" id='author' value="<?php if(isset($news['Notice']['author'])) echo $news['Notice']['author'];?>" /></p>
				</td>
			</tr>
	
	        <tr>
				<td height="85">
					<p><?php echo $languageMantan['ilustration'];?></p>
					<p>
						<?php 
							if(isset($news['Notice']['image'])){
								$image= $news['Notice']['image'];
							}else{
								$image= '';
							}
							showUploadFile('image','image',$image);
						?>
					</p>
				</td>
				
	            <td>
					<p><b><?php echo $languageMantan['datePosted'];?></b></p>
					<p id="ngayDang">
						<?php
							
							if(isset($news['Notice']['time']) && $news['Notice']['time']>0)
							{
								$today= getdate($news['Notice']['time']);
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
				</td>
	
	            
	
	        </tr>
	
	        <tr>
	
	            <td colspan="3">
					<p><?php echo $languageMantan['content'];?></p>
					<p>
						<?php
							if(isset($news['Notice']['content'])){
								$content= $news['Notice']['content'];
							}else{
								$content= '';
							}
							showEditorInput('contentPage','content',$content);
						?>
					</p>
				</td>
	        </tr>
	    </table>
	
	</form>
	
	
	</div>
