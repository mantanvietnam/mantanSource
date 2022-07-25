<!DOCTYPE html>
<html>
<head>
	<title>Checkin sự kiện <?php echo $infoCampaign['Campaign']['name'];?></title>
	
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
	<div class="container" style="margin: 0 auto;max-width: 100%;">
		<center class="manmo_spiner">
			<img src="<?php echo $infoCampaign['Campaign']['logo'];?>">
		</center>
  		<div class="row justify-content-center">
  			<div class="text-center">
				<div class="container">
					<?php if(empty($infoUser)){ ?>
					<form method="post" action="">
					  <div class="form-group" style="margin-top: 100px;">
					  	<p><?php echo $mess;?></p>
					    <label>Nhập mã số của bạn</label>
					    <input type="text" class="form-control" id="" name="codeUser" required placeholder="" style="width: 200px;margin: 0 auto;">
					    <p><b>Chú ý: nhập đúng mã dự thưởng của bạn, nhập sai sẽ mất cơ hội quay số trúng thưởng</b></p>
					  </div>
					  
					  <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Xác nhận</button>
					</form>
					<?php }else{
						echo '<p style="margin-top: 100px;">Chào mừng '.$infoUser['User']['fullName'].' đã checkin thành công tại sự kiện '.$infoCampaign['Campaign']['name'].'</p>';
					} ?>
				</div>
			</div>
  		</div>
  		
  		
	</div>

	
</body>
</html>


