<link href="<?php echo $urlHomes.'app/Plugin/bizman/style.css';?>" rel="stylesheet">
<?php
	$breadcrumb= array( 'name'=>'Bizman Product',
						'url'=>$urlPlugins.'admin/bizman-sync-syncSetting.php',
						'sub'=>array('name'=>'Cài đặt')
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
        Save
	</div>
</div>
	
<div class="taovien clear">
	<p class="textRed"><?php echo $mess;?></p>
    <form action="" method="post" name="listForm">
        <table id="listTable" cellspacing="0" cellpadding="0" class="tableList">
          <tr>
            <td align="right" width="200" >Phương thức lấy giá & số lượng</td>
            <td align="left">
              <input type="radio" name="checkPrice" value="web" <?php if(!isset($data['Option']['value']['checkPrice']) || $data['Option']['value']['checkPrice']=='web') echo 'checked';?> /> Lấy giá trên web 
              <input type="radio" name="checkPrice" value="bizman" <?php if(isset($data['Option']['value']['checkPrice']) && $data['Option']['value']['checkPrice']=='bizman') echo 'checked';?> /> Kiểm tra giá dưới Bizman 
            </td>
          </tr>
          <tr>
            <td align="right">IP Host Bizman</td>
            <td align="left"><input placeholder="VD: 112.78.11.116:9008" style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['ipHostBizman'];?>" name="ipHostBizman" id="ipHostBizman" /></td>
          </tr>
          <tr>
            <td align="right">Thời điểm đồng bộ cuối</td>
            <td align="left">
              <input style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['dateSync'];?>" name="dateSync" id="dateSync" />
              <?php
                if(isset($data['Option']['value']['dateSync'])){
                  $day= getdate($data['Option']['value']['dateSync']);
                  echo $day['hours'].':'.$day['minutes'].' ngày '.$day['mday'].'/'.$day['mon'].'/'.$day['year'];
                }
              ?>
            </td>
          </tr>
          <tr>
            <td align="right">Số ký tự mã hàng lấy từ mã Bizman</td>
            <td align="left">
              <input placeholder="VD: 6" style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['lengthCode'];?>" name="lengthCode" id="lengthCode" />
              Để -1 nếu muốn lấy hết
            </td>
          </tr>
          <tr>
            <td align="right">Ký tự đánh dấu loại bỏ trong tên sản phẩm</td>
            <td align="left">
              <input placeholder="VD: -" style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['keyFlag'];?>" name="keyFlag" id="keyFlag" />
              Để trống nếu muốn lấy hết
            </td>
          </tr>
          <tr>
            <td align="right">Số lượng sản phẩm tồn min</td>
            <td align="left">
              <input placeholder="VD: 10" style="width: 300px;" type="text" value="<?php echo @$data['Option']['value']['productMin'];?>" name="productMin" id="productMin" />
            </td>
          </tr>
      </table>
    </form>
</div>
