<?php
	$breadcrumb= array( 'name'=>$languageMantan['userList'],
						'url'=>$urlUsers.'listUser',
						'sub'=>array('name'=>$languageMantan['information'])
					  );
	addBreadcrumbAdmin($breadcrumb);
?>  

<div class="clear" style="height: 10px;margin-left: 15px;margin-bottom: 15px;" id='status'>
	<?php
		$return= (isset($_GET['status']))?$_GET['status']:'';

        if( $return==1)
        {
          echo "<font color='red'>".$languageMantan['saveSuccess']."</font>";
        }
        else if( $return==-1)
        {
          echo "<font color='red'>".$languageMantan['saveFailed']."</font>";
        }
	?>
</div>
	
<div class="taovien">
    <form action="<?php echo $urlUsers.'saveUserAdmin';?>" method="post" name="listForm">
    	<input type="hidden" value="<?php echo @$data['User']['id'];?>" name="idUser" />
    	<p><input type="submit" value="<?php echo $languageMantan['save'];?>" /></p>
    	
        <table id="listTin" cellspacing="0" class="table table-striped">
          <tr>
            <td align="right" width="130"><?php echo $languageMantan['account'];?> (*)</td>
            <td align="left">
				<?php 
					if(isset($data['User']['user'])){ 
						echo $data['User']['user'];
					}else{
						echo '<input class="form-control" type="text" value="" name="user" id="user" required />';
					}
				?>
			</td>
          </tr>
          
          <tr>
            <td align="right" ><?php echo $languageMantan['fullName'];?> (*)</td>
            <td align="left"><input required class="form-control" type="text" value="<?php echo @$data['User']['fullname'];?>" name="fullname" id="fullname" /></td>
          </tr>
          
          <tr>
            <td align="right" ><?php echo $languageMantan['email'];?> (*)</td>
            <td align="left"><input required class="form-control" type="email" value="<?php echo @$data['User']['email'];?>" name="email" id="email" /></td>
          </tr>
          <tr>
            <td align="right" ><?php echo $languageMantan['address'];?></td>
            <td align="left">
            	<textarea class="form-control" rows="5" name="address" id="address"><?php echo @$data['User']['address'];?></textarea>
            </td>
          </tr>
          <tr>
            <td align="right" ><?php echo $languageMantan['telephoneNumber'];?> (*)</td>
            <td align="left"><input required class="form-control" type="text" value="<?php echo @$data['User']['phone'];?>" name="phone" id="phone" /></td>
          </tr>
          <tr>
            <td align="right" ><?php echo $languageMantan['newPassword'];?></td>
            <td align="left"><input class="form-control" type="text" value="" name="password" id="password" /></td>
          </tr>
      </table>
      
      <p><input type="submit" value="<?php echo $languageMantan['save'];?>" /></p>
    </form>
</div>
