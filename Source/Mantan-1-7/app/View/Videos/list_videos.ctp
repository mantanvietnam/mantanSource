<?php
	$breadcrumb= array( 'name'=>$languageMantan['video'],
						'url'=>$urlVideos,
						'sub'=>array('name'=>$languageMantan['all'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?>   
	<script type="text/javascript" src="<?php echo $urlHomes;?>/app/webroot/ckfinder/ckfinder.js"></script>
	<script type="text/javascript">
		var urlWeb="<?php echo $urlVideos;?>";
		var urlNow="<?php echo $urlNow;?>";
		
		function addDataNew()
		{
			document.getElementById("title").value= '';
			document.getElementById("codeVideo").value= '';
			document.getElementById("idVideo").value= '';
			document.getElementById("image").value= '';
			document.getElementById("description").value= '';
			
		    $('#themData').lightbox_me({
		    centered: true, 
		    onLoad: function() { 
		        $('#themData').find('input:first').focus()
		        }
		    });
		}
		
		function deleteData(id)
		{
			var r= confirm("<?php echo $languageMantan['areYouSureYouWantToRemove'];?>");
			if(r==true)
			{
				$.ajax({
			      type: "POST",
			      url: urlWeb+"deleteData",
			      data: { id:id}
			    }).done(function( msg ) { 	
				  		window.location= urlNow;	
				 })
				 .fail(function() {
						window.location= urlNow;
					}); 
			}
		}
		
		function editData(id,code)
		{
			document.getElementById("title").value= document.getElementById("name"+id).innerHTML ;
			document.getElementById("codeVideo").value= code ;
			document.getElementById("idVideo").value= id;
			document.getElementById("image").value= document.getElementById("image"+id).src ;
			document.getElementById("description").value= document.getElementById("description"+id).innerHTML ;
			
			$('#themData').lightbox_me({
		    centered: true, 
		    onLoad: function() { 
		        $('#themData').find('input:first').focus()
		        }
		    });
		}
	</script>
	
	<div class="thanhcongcu">
	      <div class="congcu"  onclick="addDataNew();">
	          <span>
	            <img src="<?php echo $webRoot;?>images/add.png" />
	          </span>
	          <br/>
	          <?php echo $languageMantan['add'];?>
	      </div>
	      
	  </div>
	  <div class="clear"></div>
	  <div id="content">
	  
	  <form action="" method="post" name="listData">
	    <?php
	        if($listData)
	        {
	    ?>
	    	<table class="table table-striped">
		    	<tr>
			    	<td width="200"><?php echo $languageMantan['ilustration'];?></td>
			    	<td><?php echo $languageMantan['title'];?></td>
					<td><?php echo $languageMantan['description'];?></td>
			    	<td width="165"><?php echo $languageMantan['choose'];?></td>
		    	</tr>
		    	<?php
                  foreach($listData as $video)
                  { 
				  ?>
                  	<tr>
	                  	<td>
		                  	<a target="_blank" href="http://www.youtube.com/watch?v=<?php echo $video['Video']['code'];?>">
	                            <img id="image<?php echo $video['Video']['id'];?>" width="200px" src="<?php echo $video['Video']['image'];?>">
	                        </a>
	                  	</td>
	                  	<td><a id="name<?php echo $video['Video']['id'];?>"  href="<?php echo getUrlVideo($video['Video']['id'],$video['Video']['slug']);?>" target="_blank"><?php echo $video['Video']['name'];?></a></td>
						<td id="description<?php echo $video['Video']['id'];?>" ><?php echo $video['Video']['description'];?></td>
	                  	<td>
		                  	<input class="btn btn-default" onclick="deleteData('<?php echo $video['Video']['id'];?>')" type="button" value="<?php echo $languageMantan['delete'];?>" />
                          &nbsp;
                            <input class="btn btn-default" onclick="editData('<?php echo $video['Video']['id'];?>','<?php echo $video['Video']['code'];?>')" type="button" value="<?php echo $languageMantan['edit'];?>" />
	                  	</td>
                  	</tr>
                  <?php }?>
	    	</table>
	              
	
	    <?php }
	
	    ?>
	
	   </form>
	   <div class="clear"></div>
	   
	   <?php
	        echo "&nbsp;";
	        echo $this->Paginator->prev('« '.$languageMantan['previousPage'].' ', null, null, array('class' => 'disabled')); //Shows the next and previous links
	        echo " | ".$this->Paginator->numbers()." | "; //Shows the page numbers
	        echo $this->Paginator->next(' '.$languageMantan['nextPage'].' »', null, null, array('class' => 'disabled')); //Shows the next and previous links
	        echo " Page ".$this->Paginator->counter(); // prints X of Y, where X is current page and Y is number of pages
	    ?>
	    
		<div class="clear"></div>
		<div id="themData">
		  <form method="post" action="<?php echo $urlVideos;?>saveData" name="dangtin">
		  	  <input type="hidden" value="" name="id" id="idVideo" />
		      <p><b><?php echo $languageMantan['title'];?></b></p>
		      <input type="text" name="name" value="" id="title" class="form-control"/>
		      <p><b><?php echo $languageMantan['youtubeCode'];?></b></p>
		      <input type="text" name="code" value="" id="codeVideo" class="form-control"/>
			  <p><b><?php echo $languageMantan['ilustration'];?></b></p>
		      <?php showUploadFile('image','image');?>
			  <p style="clear: both;"><b><?php echo $languageMantan['description'];?></b></p>
			  <input type="text" name="description" value="" id="description" class="form-control" style="width:250px;"/>
		      <br/>
		      <p><input type='submit' value='<?php echo $languageMantan['save'];?>' class="btn btn-default" /></p>
		  </form>
	  </div>
	    
	</div>
	