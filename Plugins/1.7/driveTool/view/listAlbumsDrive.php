<?php
	$breadcrumb= array( 'name'=>'Drive Tool',
						'url'=>$urlPlugins.'admin/driveTool-view-listAlbumsDrive.php',
						'sub'=>array('name'=>'List album')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 

<div class="clear"></div>

<div id="content">
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
	<?php echo @$mess;?>
    <table id="listTin" cellspacing="0" class="tableList">

        <tr>
        	<td align="center">Album</td>
            <td align="center">Drive</td>
        </tr>

        <?php
        	
            foreach($listAlbum as $tin)
            {
				echo '<tr>
						  <td>'.$tin['Album']['title'].'</td>
						  <td>
						  	<form method="post">
						  		<input type="hidden" value="'.$tin['Album']['id'].'" name="idAlbum" />
						  		<p>ID thư mục</p>
						  		<input type="text" value="'.@$listDrive['Option']['value'][$tin['Album']['id']].'" name="idFolderDrive"  />
						  		<input type="submit" value="Đồng bộ" />
						  	</form>
						  </td>


					</tr>';
            }

        ?>


    </table>





</div>