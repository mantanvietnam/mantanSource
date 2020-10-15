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
    $breadcrumb = array('name' => 'Mobile App Api',
        'url' => $urlPlugins . 'admin/mobileAppApi-setting.php',
        'sub' => array('name' => 'Settings')
    );
    addBreadcrumbAdmin($breadcrumb);
?>  
<script type="text/javascript">
	
	function save()
	{
	    document.listForm.submit();
	}
</script>
<div class="thanhcongcu">

    <div class="congcu" onclick="save();">
        <input type="hidden" id="idChange" value="" />
        <span id="save">
            <input type="image" src="<?php echo $webRoot;?>images/save.png" />
        </span>
        <br/>
        <?php echo $languageMantan['save'];?>
    </div>
</div>

<div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
	<?php
		echo $mess;
	?>
</div>
	
<div class="taovien">
    <form action="" method="post" name="listForm">
    	<table class="tableList">
           
    	<?php
            if(count($listPage)>0){
                echo '  <tr>
                            <td>
                                    <p><b>About us page</b></p>
                                <select name="idAboutPage">
                                    <option value="">Select about us</option>';
                                    foreach($listPage as $page){
                                        if(isset($data['Option']['value']['idAboutPage']) && $data['Option']['value']['idAboutPage']==$page['Notice']['id']){
                                            echo '<option selected value="'.$page['Notice']['id'].'">'.$page['Notice']['title'].'</option>'; 
                                        }else{
                                            echo '<option value="'.$page['Notice']['id'].'">'.$page['Notice']['title'].'</option>';
                                        }
                                    }
                echo '          </select>
                </td>
            </tr>';
            }
    	?>
    		
    	</table>
    </form>
</div>
