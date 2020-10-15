<?php
	$breadcrumb= array( 'name'=>$languageMantan['account'],
						'url'=>$urlAdmins.'listAccount',
						'sub'=>array('name'=>$languageMantan['powers'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?>     
	<script type="text/javascript">
	
	function saveData()
	{
	
	    document.account.submit();
	
	}
	
	</script>
	
	<div class="thanhcongcu">
	      <div class="congcu">
	        <span id="save">
	          <input type="image" onclick="saveData();" src="<?php echo $webRoot;?>images/save.png" />
	        </span>
	        <br/>
	        <?php echo $languageMantan['save'];?>
	      </div>
	</div>
  <div class="clear"></div>
  <div id="content">
    <div style="padding: 10px;padding-left: 15px;">
        <?php
        	if(isset($_GET['return'])){
	            switch($_GET['return'])
	            {
	              case 1:  echo '<font color="red">'.$languageMantan['saveSuccess'].'</font>'; break;
	              case -1: echo '<font color="red">'.$languageMantan['saveFailed'].'</font>'; break;
	              case -3: echo '<font color="red">'.$languageMantan['saveFailed'].'</font>'; break;
	            }
			}
        ?>
    </div>
    
    <form action="<?php echo $urlAdmins;?>savePowers" method="post" name="account" class="taovienLimit">
        <input type="hidden" value="<?php echo $account['Admin']['id'];?>" name="id" />
        <table cellspacing="0" class="table table-striped">
            <tr>
                <td width="160"><?php echo $languageMantan['account'];?></td>
                <td><?php echo $account['Admin']['user'];?></td>
            </tr>
            <tr>
                <td><?php echo $languageMantan['email'];?></td>
                <td><?php echo @$account['Admin']['email'];?></td>
            </tr>
            <tr>
                <td><?php echo $languageMantan['powers'];?></td>
                <td>
                	<ul style="margin: 0;list-style: none outside none;padding:0;">
	                <?php 
	                	global $hookMenuAdminMantan;
		                foreach($hookMenuAdminMantan as $menus)
						{
							echo '<p style="color: red;">'.$menus['title'].'</p>';
							if(isset($menus['sub']) && count($menus['sub'])>0)
							{
								foreach($menus['sub'] as $menu)
								{
									if(!isset($menu['sub']) || count($menu['sub'])==0)
									{
										$checked='';
										if(isset($account['Admin']['powers']) && in_array($menu['permission'], $account['Admin']['powers'])) $checked= 'checked';
										echo '  <li>
													<input type="checkbox" '.$checked.' value="'.$menu['permission'].'" name="check_list[]" /> '.$menu['name'].'
							                    </li>';
									}
									else
									{
										$checked='';
										if(isset($account['Admin']['powers']) && in_array($menu['permission'], $account['Admin']['powers'])) $checked= 'checked';
										echo ' <li>
							                        <input '.$checked.' type="checkbox" value="'.$menu['permission'].'" name="check_list[]" /> '.$menu['name'].'
							                        <ul style="margin-left: 20px;list-style: none outside none;padding:0;">';
							                        foreach($menu['sub'] as $sub)
							                        {
							                        	$checked='';
														if(isset($account['Admin']['powers']) && in_array($sub['permission'], $account['Admin']['powers'])) $checked= 'checked';
							                        	echo '  <li>
									                                <input '.$checked.' type="checkbox" value="'.$sub['permission'].'" name="check_list[]" /> '.$sub['name'].'
									                            </li>';
							                        }
							            echo        '</ul>
							                    </li>';
									}
								}
							}
						}
	                ?>
                	</ul>
                </td>
            </tr>
        </table>
    </form>

  </div>

