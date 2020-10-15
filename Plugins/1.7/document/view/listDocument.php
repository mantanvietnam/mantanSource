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
	$breadcrumb= array( 'name'=>'Document',
						'url'=>$urlPlugins.'admin/document-view-listDocument.php',
						'sub'=>array('name'=>'List Document')
					  );
	addBreadcrumbAdmin($breadcrumb);
?> 
    
	  <div class="thanhcongcu">
	      <a href="<?php echo $urlPlugins.'admin/document-view-addDocument.php';?>">
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
	    	<script type="text/javascript" src="http://www.skypeassets.com/i/scom/js/skype-uri.js"></script>
	        <table id="listTable" cellspacing="0" class="tableList">
					
	                <tr>
	                  <td align="center" >Tên tài liệu</td>
	                  <td align="center" >Loại tài liệu</td>
	                  <td align="center" width="130">Chọn</td>
	                </tr>
	                <?php
	                	$confirm= 'Are you sure you want to remove ?';
	                    foreach($listNotices as $components)
	                    { 
	                ?>
	                        <tr>
	                          <td height="40" id="name<?php echo $components['Document']['id'];?>">
	                          	<a href="<?php echo $components['Document']['file'];?>">
	                          		<?php echo $components['Document']['name'];?>
	                          	</a>
	                          </td>
	                          <td><?php echo @$listDataCategory['Option']['value']['allData'][ $components['Document']['category'] ]['name'];?></td>
	                          
	                          <td align="center" >
	                            <a style="padding: 4px 8px;" href="<?php echo $urlPlugins.'admin/document-view-addDocument.php/'.$components['Document']['id'] ?>" class="input" >Edit</a>
                              		&nbsp;&nbsp;
									<a style="padding: 4px 8px;" href="<?php echo $urlPlugins.'admin/document-deleteDocument.php/'.$components['Document']['id'] ?>" class="input" onclick="return confirm('Are you sure you want to remove ?');"  >Delete</a>
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