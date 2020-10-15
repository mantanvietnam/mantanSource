
<?php
	$breadcrumb= array( 'name'=>$languageMantan['news'],
						'url'=>$urlNotices.'listPages',
						'sub'=>array('name'=>$languageMantan['pages'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?>   
    <script type="text/javascript">

	var urlWeb="<?php echo $urlNotices;;?>";
	var urlNow="<?php echo $urlNow;?>";
	
	function deleteData(idDelete)
	{
	    var check= confirm('Bạn có chắc chắn muốn xóa trang này không ?');
		if(check)
		{
			$.ajax({
		      type: "POST",
		      url: urlWeb+"deleteNotice",
		      data: { id:idDelete}
		    }).done(function( msg ) { 	
			  		window.location= urlNow;	
			 })
			 .fail(function() {
					window.location= urlNow;
				});  
		}
	}  
	
	</script>
	
	<div class="thanhcongcu">
	
	    <div class="congcu">
	
	        <a href="<?php echo $urlNotices;?>addPage">
	
	          <span>
	
	            <img src="<?php echo $webRoot;?>images/add.png" />
	
	          </span>
	
	            <br/>
	
	            <?php echo $languageMantan['add'];?>
	
	        </a>
	
	    </div>
	    
	</div>
	
	<div class="clear"></div>
	
	<div id="content">
		<form action="" method="get" class="taovienLimit">
			<input type="text" value="<?php if(isset($_GET['key'])) echo $_GET['key'];?>" id="key" name="key" style="width: 200px;display: inline;" class="form-control" placeholder="<?php echo $languageMantan['keyWord'];?>">
			<input class="btn btn-default" type="submit" value="<?php echo $languageMantan['search'];?>">
		</form>
		<br/>
		<table id="listTin" cellspacing="0"  class="table table-striped">
	
	        <tr>
	
	            <td><b><?php echo $languageMantan['title'];?></b></td>
	
	            <td><b><?php echo $languageMantan['permalinks'];?></b></td>
	            <td align="center"><?php echo $languageMantan['view'];?></td>
	            <td align="center" width="225"><b><?php echo $languageMantan['choose'];?></b></td>
	
	        </tr>
	
	
	
	        <?php
	
	            foreach($listNotices as $tin)
	
	            {
	
	                    echo '<tr>
	
	                              <td><a target="_blank" href="'.getUrlNotice($tin['Notice']['id']).'">'.$tin['Notice']['title'].'</a></td>
	                              <td>'.$tin['Notice']['slug'].'</td>
	                              <td>'.$tin['Notice']['view'].'</td>
	                              <td align="center">
	                              	<a  class="btn btn-default" href="'.$urlNotices.'addPage/'.$tin['Notice']['id'].'">'.$languageMantan['edit'].'</a>
	                    			&nbsp;
	                    			<input class="btn btn-default" type="button" value="'.$languageMantan['delete'].'" onclick="deleteData('."'".$tin['Notice']['id']."'".');">	                              </td>
	
	                            </tr>';
	
	
	            }
	
	        ?>
	
	    </table>
		<p>
	    <?php
	
	    echo "&nbsp;";
	
	    echo $this->Paginator->prev('« '.$languageMantan['previousPage'].' ', null, null, array('class' => 'disabled')); //Shows the next and previous links
	
	    echo " | ".$this->Paginator->numbers()." | "; //Shows the page numbers
	
	    echo $this->Paginator->next(' '.$languageMantan['nextPage'].' »', null, null, array('class' => 'disabled')); //Shows the next and previous links
	
	    echo " Page ".$this->Paginator->counter(); // prints X of Y, where X is current page and Y is number of pages
	
	    ?>
		</p>
	
	</div>
