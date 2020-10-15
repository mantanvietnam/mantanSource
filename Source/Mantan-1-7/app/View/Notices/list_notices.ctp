<?php
	$breadcrumb= array( 'name'=>$languageMantan['news'],
						'url'=>$urlNotices.'listNotices',
						'sub'=>array('name'=>$languageMantan['allPosts'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 	
	<div class="thanhcongcu">
	
	    <div class="congcu">
	
	        <a href="<?php echo $urlNotices;?>addNotices">
	
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

	<?php
			function listCat($cat,$sau,$idCat)
			{
				if($cat['id']>0)
				{
					if($cat['id'] != $idCat)
					{
						echo '<option value="'.$cat['id'].'">';
					}
					else
					{
						echo '<option  selected="selected" value="'.$cat['id'].'">';
					}
					
					for($i=1;$i<=$sau;$i++)
					{
						echo '&nbsp&nbsp&nbsp&nbsp';
					}
					echo $cat['name'].'</option>';
				}
				foreach($cat['sub'] as $sub)
				{
					listCat($sub,$sau+1,$idCat);
				}
			}
	?>
	
	<form action="" method="get" class="taovienLimit">
		<?php echo $languageMantan['categories'];?>
		<select name="category" id="category" class="form-control" style="width: auto;display: inline;margin-bottom: 15px;">
		<option value="-1"><?php echo $languageMantan['all'];?></option>
		<?php
			foreach($chuyenmuc as $cat)
			{
				listCat($cat,1,$_GET['category']);
	
			}	
		?>
		</select>
		<input type="text" value="<?php if(isset($_GET['key'])) echo $_GET['key'];?>" id="key" name="key" style="width: 200px;display: inline;" class="form-control" placeholder="<?php echo $languageMantan['keyWord'];?>">
		<input class="btn btn-default" type="submit" value="<?php echo $languageMantan['search'];?>">
	</form>
	
    <table id="listTin" cellspacing="0" class="table table-striped">

        <tr>

            <td align="center"><?php echo $languageMantan['title'];?></td>

            <td align="center" width="75"><?php echo $languageMantan['event'];?></td>
            <td align="center"><?php echo $languageMantan['view'];?></td>

            <td align="center" width="225"><?php echo $languageMantan['choose'];?></td>

        </tr>
        <?php
	        
            foreach($listNotices as $tin)

            {
                    echo '<tr>

                              <td><a target="_blank" href="'.getUrlNotice($tin['Notice']['id']).'">'.$tin['Notice']['title'].'</a></td>
                              <td align="center">';



                    if($tin['Notice']['event']==1) echo '<img src="'.$webRoot.'images/Actions-dialog-ok-icon.png" />';

                    else echo '<img src="'.$webRoot.'images/Actions-edit-delete-icon.png" />';

                    echo    '</td>
                    			<td>'.$tin['Notice']['view'].'</td>
                    			<td align="center">
                    			<a class="btn btn-default" href="'.$urlNotices.'addNotices/'.$tin['Notice']['id'].'">'.$languageMantan['edit'].'</a>
                    			&nbsp;
                    			<input class="btn btn-default" type="button" value="'.$languageMantan['delete'].'" onclick="deleteData('."'".$tin['Notice']['id']."'".');">
                    			</td>
                            </tr>';


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
			
			echo '<a href="'.$urlPage.$back.'">'.$languageMantan['previousPage'].'</a> ';
			for($i=$startPage;$i<=$endPage;$i++){
				echo ' <a href="'.$urlPage.$i.'">'.$i.'</a> ';
			}
			echo ' <a href="'.$urlPage.$next.'">'.$languageMantan['nextPage'].'</a> ';

			echo $languageMantan['totalPage'].': '.$totalPage;
	    ?>
	</p>
	
</div>

<script type="text/javascript">

var urlWeb="<?php echo $urlNotices;;?>";
var urlNow="<?php echo $urlNow;?>";

function deleteData(idDelete)
{
    var check= confirm('<?php echo $languageMantan['areYouSureYouWantToRemove'];?>');
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
