<?php
	function showBooking()
	{ 
		global $urlThemeActive;
		global $urlHomes;
		$today= getdate();
	?>
		<form method="post" action="<?php echo $urlHomes.'saveBooking';?>">
			<h3>Đặt phòng</h3>
			<table width="239" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td class="first">
							Ngày đặt<br>
							<select class="date" name="date">
								<?php
									for($i=1;$i<=31;$i++)
									{
										if($i!=$today['mday'])
										{
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
										else
										{
											echo '<option selected value="'.$i.'">'.$i.'</option>';
										}
									}
								?>
							</select>
						</td>
						<td class="second"><br>
							<select name="month">
								<?php
									for($i=1;$i<=12;$i++)
									{
										if($i!=$today['mon'])
										{
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
										else
										{
											echo '<option selected value="'.$i.'">'.$i.'</option>';
										}
									}
								?>
							</select>
							
							<select class="year" name="year">
								<?php
									for($i=$today['year'];$i<=$today['year']+10;$i++)
									{
										if($i!=$today['year'])
										{
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
										else
										{
											echo '<option selected value="'.$i.'">'.$i.'</option>';
										}
									}
								?>																	
							</select>
						</td>
					</tr>
					<tr>
						<td class="first">
							Số ngày<br>
							<select name="numberDay">
								<?php
									for($i=1;$i<=100;$i++)
									{
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
								?>
							</select>
						</td>
						<td class="third">
							Số phòng<br>
							<select name="numberRoom">
								<?php
									for($i=1;$i<=100;$i++)
									{
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
								?>									
							</select>
						</td>
					</tr>
					<tr>
						<td class="first">
							Email<br>
							<input type="text" name="email">
						</td>
						<td class="third">
							Số điện thoại<br>
							<input type="text" name="fone">
						</td>
					</tr>
					<tr>
						<td class="reset" colspan="2">
							<div class="button">
								<input type="submit" value="Đặt phòng" />
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="button" style="margin-bottom:15px;"></div>					
		</form>
	<?php }
?>