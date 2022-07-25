<!DOCTYPE html>
<html>
<head>
	<title>Chương trình quay thưởng sự kiện <?php echo $infoCampaign['Campaign']['name'];?></title>
	
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</head>
<style>
	body {
		position: relative;
		height: 100vh;
		width: 100vw;
		color: #000;
		background-color: #f7d425;
	}
	body:before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: url('<?php echo $infoCampaign["Campaign"]["image"]; ?>');
		background-size: 100% 100%;
		background-repeat: no-repeat;
		-webkit-filter: blur(0px);
	    -o-filter: blur(0px);
	    -moz-filter: blur(0px);
	    filter: blur(0px);
	    z-index: -1;
	}

	.numberQT {
		font-size: 90px;
	}

	#textNTT {
		font-weight: bold;
		margin-top: 20px;
		font-size: 30px;
		margin-bottom: 20px;
	}

	.manmo_spiner img {
		max-height: 250px;
	}

	.wr_box_spin {
		display: flex;
		justify-content: space-around;
		margin: auto;
	}

	.my_m_t_30 {
		margin-top: 30px;
	}

	.wr_fowhidden {
		max-height: calc(100vh - 320px);
		overflow: auto;
	}


	.text-center > i {
		color: yellow;
		margin: 0 10px;
	}

	ol.wr_fowhidden {
		box-shadow: 0 0 20px yellow inset;
		border-radius: 4px;
		padding-left: 55px;
	}

	ol.wr_fowhidden li {
		font-weight: 500;
		margin: 10px 0!important;
		cursor: pointer;
	}

	ol.wr_fowhidden li:hover {
		font-weight: bold;
	}

	.wr_fowhidden::-webkit-scrollbar-track
	{
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
		border-radius: 10px;
		background-color: #F5F5F5;
	}

	.wr_fowhidden::-webkit-scrollbar
	{
		width: 12px;
		background-color: #F5F5F5;
	}

	.wr_fowhidden::-webkit-scrollbar-thumb
	{
		border-radius: 10px;
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
		background-color: #D62929;
	}
	.lockScreen{
		width: 100%;
		height: 100%;
		position: fixed;
		top: 0;
		z-index: 99;
		opacity: 0.8;
		background: #000;
		color: #fff;
	}

	@media only screen and (max-width: 1024px) {
		.wr_list_user_hist h3 {
			font-size: 16px;
		}

		.manmo_spiner img {
			max-height: 200px;
		}

		.numberQT {
			font-size: 70px;
		}

		.wr_fowhidden {
			max-height: calc(100vh - 260px);
			overflow: auto;
		}
	}

	@media only screen and (max-width: 768px) {
		.hidden_768 {
			display: none;
		}

		.show_768 {
			width: 400px;
		}

		.manmo_spiner img {
			max-height: 150px;
		}

		.numberQT {
			font-size: 50px;
		}

		.wr_fowhidden {
			max-height: calc(100vh - 365px);
			overflow: auto;
		}

		#textNTT {
			font-size: 22px;
		}
	}

	@media only screen and (min-width: 769px) {
		.pc_hidden {
			display: none;
		}
	}

	@media only screen and (max-width: 576px) {
		.manmo_spiner img {
			max-height: 85px;
		}
		#textNTT {
			font-size: 18px;
		}
	}


</style>
<body>
	<div class="container" style="margin: 0 auto;max-width: 100%;padding-top: 15px;">
		<center class="manmo_spiner">
			<img src="<?php echo $infoCampaign['Campaign']['logo'];?>">
		</center>
  		<div class="row justify-content-center">
	  			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 col-4 hidden_768">
	  				<div class="wr_list_user_hist">
		      			<h3 class="text-center" style="color: #<?php echo $infoCampaign['Campaign']['colorText'];?>;"><i class="fa fa-star" aria-hidden="true"></i><b>DANH SÁCH NGƯỜI CHƠI</b><i class="fa fa-star" aria-hidden="true"></i></h3>
		      			<ol class="wr_fowhidden" style="color: #<?php echo $infoCampaign['Campaign']['colorText'];?>;">
		      				<?php
		      				if(!empty($listAllUser) && $checkManager){
		      					foreach($listAllUser as $item){
		      						echo '<li>'.$item['User']['fullName'].' mã dự thưởng '.$item['User']['codeQT'].'</li>';
		      					}
		      				}
		      				?>
		      			</ol>
		      		</div>
	    		</div>
  				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-4 text-center show_768">
  					<div class="wr_box_spin" style="color: #<?php echo $infoCampaign['Campaign']['colorText'];?>;">
  						<b id="number1" class="numberQT">0</b>
		      			<b id="number2" class="numberQT">0</b>
		      			<b id="number3" class="numberQT">0</b>
		      			<b id="number4" class="numberQT">0</b>
  					</div>
  					<div class="wr_box_spin my_m_t_30">
		      			<button type="button" class="btn btn-danger" onclick="quaythuong();" id="btnQT">QUAY THƯỞNG</button>
		    		</div>
		    		<div class="text-center my_m_t_30">
		      			<center id="textNTT"></center>
		    		</div>
	    		</div>

	    		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 col-4 hidden_768">
	    			<div class="wr_list_user_hist">
	    				<h3 class="text-center" style="color: #<?php echo $infoCampaign['Campaign']['colorText'];?>;"><i class="fa fa-trophy" aria-hidden="true"></i><b>LỊCH SỬ QUAY THƯỞNG</b><i class="fa fa-trophy" aria-hidden="true"></i></h3>
		      			<ol class="wr_fowhidden" style="color: #<?php echo $infoCampaign['Campaign']['colorText'];?>;">
		      				<?php
		      				if(!empty($listUserWin) && $checkManager){
		      					foreach($listUserWin as $item){
		      						echo '<li>Ngày quay '.date('d/m/Y H:i', $item['User']['time']).' người thắng '.$item['User']['fullName'].' mã dự thưởng '.$item['User']['codeQT'].'</li>';
		      					}
		      				}
		      				?>
		      			</ol>
	    			</div>
	    		</div>
  		</div>
  		<div class="row">
  			<div class="col-xs-12 col-sm-6 wr_list_user_hist pc_hidden">
	    				<h3 class="text-center" style="color: #<?php echo $infoCampaign['Campaign']['colorText'];?>;"><i class="fa fa-star" aria-hidden="true"></i><b>DANH SÁCH NGƯỜI CHƠI</b><i class="fa fa-star" aria-hidden="true"></i></h3>
		      			<ol class="wr_fowhidden" style="color: #<?php echo $infoCampaign['Campaign']['colorText'];?>;">
		      				<?php
		      				if(!empty($listAllUser) && $checkManager){
		      					foreach($listAllUser as $item){
		      						echo '<li>'.$item['User']['fullName'].' mã dự thưởng '.$item['User']['codeQT'].'</li>';
		      					}
		      				}
		      				?>
		      			</ol>
	    			</div>
	    	<div class="col-xs-12 col-sm-6 wr_list_user_hist pc_hidden">
	    				<h3 class="text-center" style="color: #<?php echo $infoCampaign['Campaign']['colorText'];?>;"><i class="fa fa-trophy" aria-hidden="true"></i><b>LỊCH SỬ QUAY THƯỞNG</b><i class="fa fa-trophy" aria-hidden="true"></i></h3>
		      			<ol class="wr_fowhidden" style="color: #<?php echo $infoCampaign['Campaign']['colorText'];?>;">
		      				<?php
		      				if(!empty($listUserWin) && $checkManager){
		      					foreach($listUserWin as $item){
		      						echo '<li>Ngày quay '.date('d/m/Y H:i', $item['User']['time']).' người thắng '.$item['User']['fullName'].' mã dự thưởng '.$item['User']['codeQT'].'</li>';
		      					}
		      				}
		      				?>
		      			</ol>
	    			</div>
  		</div>
  		
	</div>

	<script type="text/javascript">
		const audio = new Audio("/app/Plugin/quayso/view/home/Xo-So-Mien-Bac-Nhac-Chuong.mp3");
		var number1, number2, number3, number4;
		
		var idCampaign= '<?php echo $infoCampaign['Campaign']['id'];?>';
		var textKQ= "<?php echo $kq;?>";
		var nameKQ= "<?php echo $namekq;?>";
		var idUserKQ= "<?php echo $idUserkq;?>";

		var timeGame= 10;
		var timeGame1,timeGame2,timeGame3,timeGame4;
		timeGame1= timeGame*1000;
		timeGame2= timeGame1*1.5;
		timeGame3= timeGame1*2;
		timeGame4= timeGame1*2.5;

		var actionQuay= false;

		function quaythuong() {
			$('#btnQT').attr("disabled", true);
			$('#btnQT').html('ĐANG QUAY');

			if(!actionQuay){
				$.ajax({
	                type: "POST",
	                url: '/saveKQQT',
	                data: {idCampaign:idCampaign, idUserKQ:idUserKQ}
	            }).done(function (msg) {
	                document.getElementById('textNTT').innerHTML= '';
		  			audio.play();
		  			number1= setInterval(chayso, 100,1);
		  			number2= setInterval(chayso, 100,2);
		  			number3= setInterval(chayso, 100,3);
		  			number4= setInterval(chayso, 100,4);

		  			setTimeout(stopQT, timeGame1, 1);
		  			setTimeout(stopQT, timeGame2, 2);
		  			setTimeout(stopQT, timeGame3, 3);
		  			setTimeout(stopQT, timeGame4, 4);
	            })
	            .fail(function () {
	                alert('Kết nối mạng không thành công');
	            });
	        }else{
	        	window.location= '<?php echo $urlNow;?>';
	        }
		}

		function chayso(number)
		{
			var rand= Math.floor(Math.random() * 10);
			document.getElementById('number'+number).innerHTML = rand;
		}

		function stopQT(idNumber)
		{
			if(idNumber==1){
				clearInterval(number1);
				document.getElementById('number'+1).innerHTML= textKQ[0];
			}else if(idNumber==2){
				clearInterval(number2);
				document.getElementById('number'+2).innerHTML= textKQ[1];
			}else if(idNumber==3){
				clearInterval(number3);
				document.getElementById('number'+3).innerHTML= textKQ[2];
			}else if(idNumber==4){
				clearInterval(number4);
				document.getElementById('number'+4).innerHTML= textKQ[3];
				document.getElementById('textNTT').innerHTML= 'NGƯỜI TRÚNG THƯỞNG LÀ .....';

				setTimeout(loadUser, 5000);
				//audio.pause();
				//audio.currentTime = 0;
			}
		}

		function loadUser()
		{
			document.getElementById('textNTT').innerHTML= nameKQ;
			actionQuay= true;
			$('#btnQT').html('RELOAD');
			$('#btnQT').removeAttr("disabled");
		}
	</script>

	<?php 
		if(!$checkManager){
			echo '<div class="lockScreen text-center">
					<div class="container">
						<form method="post" action="">
						  <div class="form-group" style="margin-top: 100px;">
						    <label>Mã bảo mật</label>
						    <input type="password" required class="form-control" id="" name="codeSecurity" placeholder="" style="width: 200px;margin: 0 auto;">
						  </div>
						  
						  <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Xác nhận</button>
						</form>
					</div>
				</div>';
		}
	?>
</body>
</html>


