<?php
	
	$returnSend= '';
	$modelOption= new Option();
	$contact= $modelOption->getOption('contactSettings');
	
	$dataSend= $this->data;
	
	$email= $dataSend['email'];	
	$fullName= $dataSend['fullName'];	
	$fone= $dataSend['fone'];	
	$content= $dataSend['content'];
	$address= $dataSend['address'];	
	
	if($fullName)
	{
		$modelContact= new Contact();
        
		$modelContact->saveContact($fullName,$email,$fone,$content,$address);
		$returnSend= '<p style="color:red;">Gửi liên hệ thành công !</p>';
		
		if($contact['Option']['value']['sendEmail']==1)
		{
			$content='Full name: '.$fullName.'. Address: '.$address.'. Email: '.$email.'. Phone: '.$fone.'. Content: '.$content;
			
			mail($contactSite['Option']['value']['email'], 'Contact from website', $content);
		}
	}
	
	
?>
	
<style>
	.tableShow input,.tableShow textarea {
	    border: 1px solid #436381;
	    font-size: 11px;
	    margin-right: 10px;
	    width: 300px;
	}
	.tableShow{
		width: 100%;
		border: 0 !important;
	}
	.tableShow tr{
		background: none !important;
	}
	.tableShow td{
		padding: 8px;
	}
</style>
<script type="text/javascript">
	function checkTitle()
	{
		var title= document.getElementById("title").value;
		if(title != "")
		{
			return true;
		}
		else
		{
			alert("Bạn chưa điền tiêu đề !");
			return false;
		}
	}
</script> 

<?php getHeader();?>
	<div id="content">
		<div class="inside">
			<div id="fullContent">
				<div class="block">
					<h4>Liên hệ</h4>
					<?php echo $returnSend;?>
					<form role="form" style="margin-right: 15px;margin-left: 15px;clear:both;" class="custom-form row" onsubmit="return checkTitle();" method="post" action="">
						<div class="col-xs-12">
							<table class="tableShow">
								<tr>
									<td width="100" valign="top">Tên đầy đủ (*)</td>
									<td width="250">
										<input type="text" class="form-control" id="fullname" name="fullName" placeholder="Tên đầy đủ" required>
									</td>
									<td rowspan="6" valign="top">
										<?php echo $contact['Option']['value']['info'];?>
										<br/><br/>
										<?php echo $contact['Option']['value']['map'];?>
									</td>
								</tr>
								<tr>
									<td valign="top">Địa chỉ (*)</td>
									<td>
										<input type="text" class="form-control" id="address" name="address" placeholder="Địa chỉ" required>
									</td>
								</tr>
								<tr>
									<td valign="top">Email (*)</td>
									<td>
										<input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
									</td>
								</tr>
								<tr>
									<td valign="top">Điện thoại (*)</td>
									<td>
										<input type="text" class="form-control" id="fone" name="fone" placeholder="Điện thoại" required>
									</td>
								</tr>
								<tr>
									<td valign="top">Tin nhắn (*)</td>
									<td>
										<textarea id="message" class="form-control" rows="5" placeholder="Ghi chú" name="content" required></textarea>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<button type="submit" onclick="return checkTitle();" class="custom-btn btn-float">Gửi</button>
									</td>
								</tr>
							</table>
						</div><!-- / col-sm-6 -->
					</form>
				</div>
			</div>
			<!-- end center -->
			<?php echo getSidebar();?>
			<!-- end photogallery-->
		</div>
	</div>
	<!-- end content -->
<?php getFooter();?>		

