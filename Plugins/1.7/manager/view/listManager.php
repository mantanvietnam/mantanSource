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
	$breadcrumb= array( 'name'=>'Nhân sự',
						'url'=>$urlPlugins.'admin/manager-view-listManager.php',
						'sub'=>array('name'=>'Danh sách')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 
    
	  <div class="thanhcongcu">
	      <a href="<?php echo $urlPlugins.'admin/manager-view-addManager.php';?>">
	      <div class="congcu">
	        <span>
	          <input type="image"  src="<?php echo $webRoot;?>images/add.png" />
	        </span>
	        <br/>
	        Thêm
	      </div>
		</a> 
	      
	  </div>
	  <div class="clear"></div>
	  <br />


	  <div class="taovien" >
	    <form action="" method="post" name="listForm">
	        <table id="listTable" cellspacing="0" class="tableList">
					
	                <tr>
	                  <td align="center" >Ảnh đại diện</td>
	                  <td align="center" >Tên nhân viên</td>
	                  <td align="center" >Phòng ban</td>
	                  <td align="center" >Chức vụ</td>
	                  <td align="center" width="130">Chọn</td>
	                </tr>
	                <?php
	                	$confirm= 'Are you sure you want to remove ?';
	                    foreach($listData as $components)
	                    { 
	                ?>
	                        <tr>
	                        	<td><img src="<?php echo $components['Manager']['avatar'];?>" width="100" /></td>
	                          <td><?php echo $components['Manager']['name'];?></td>
	                          <td><?php echo @$listDataCategory['Option']['value']['allData'][ $components['Manager']['category'] ]['name'];?></td>
	                          <td><?php echo $components['Manager']['chucvu'];?></td>
	                          <td align="center" >
	                            <a style="padding: 4px 8px;" href="<?php echo $urlPlugins.'admin/manager-view-addManager.php/'.$components['Manager']['id'] ?>" class="input" >Edit</a>
                              		&nbsp;&nbsp;
									<a style="padding: 4px 8px;" href="<?php echo $urlPlugins.'admin/manager-deleteManager.php/'.$components['Manager']['id'] ?>" class="input" onclick="return confirm('Are you sure you want to remove ?');"  >Delete</a>
	                          </td>
	                        </tr>
	                    <?php 
	                    }
	                ?>
	
	        </table>
	    </form>
	    <?php
	      
	      if(isset($_GET['page'])){
	       $urlNow= str_replace('&page='.$tmpVariable['page'], '', $urlNow);
	       $urlNow= str_replace('?page='.$tmpVariable['page'], '', $urlNow);
	      }
	      if(strpos($urlNow,'?')!== false)
	      {
	       $urlNow= $urlNow.'&page=';
	      }
	      else
	      {
	       $urlNow= $urlNow.'?page=';
	      }
	      
	      echo '<a href="'.$urlNow.$tmpVariable['back'].'">Trang trước</a> ';
	      echo $tmpVariable['page'].'/'.$tmpVariable['totalPage'];
	      echo ' <a href="'.$urlNow.$tmpVariable['next'].'">Trang sau</a> ';

	     ?>
	  </div>
</div>