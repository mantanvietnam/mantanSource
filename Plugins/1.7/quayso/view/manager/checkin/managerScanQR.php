<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/header.php'; ?> 

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/qr-scanner@1.4.1/qr-scanner.umd.min.js"></script>
<style>
	.cam-show {

	}
	#camShow {
		max-height: calc(100vh - 147px);
		width: 100%;
		margin: auto;
	}
</style>

<section role="main" class="content-body" id="fullscreen">

<!-- start: page -->

<section class="panel">
    <ul class="title_p list-inline">
        <li><a href="/campaign"><i class="fa fa-home"></i> Chiến dịch</a></li>
        <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
        <li>Quét QR checkin</li>
    </ul>
    
    <div class="panel-body"> 
    	<div class="row align-items-center">
            <div class="col-md-12">
            	<center><p>Đưa mã QR trước camera để thực hiện quét</p></center>
            	<div class="cam-show">
					<center><video id="camShow"></video></center>
				</div>
            </div>
        </div>
    </div>
</section>

<!-- end: page -->
</section>

<div id="modalQRCamera" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thông báo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
           	<div class="modal-body">
		        <p class="contentQRCamera"></p>
		    </div>
		    <div class="modal-footer">
	          <a class="linkQRCamera buttonMM" href="">Đồng ý</a>
	        </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	function setResult(result) {
		if(result.data!=''){
			audio.play();
			$('.contentQRCamera').text('Yêu cầu truy cập: '+result.data);
			$('.linkQRCamera').attr('href',result.data);
			$('#modalQRCamera').modal('show');
		}
    }

    const audio = new Audio("/app/Plugin/quayso/view/manager/audio/bipQR.mp3");
	const video = document.getElementById('camShow');
	
	const scanner = new QrScanner(video, result => setResult(result), {
        onDecodeError: error => {
        },
        highlightScanRegion: true,
        highlightCodeOutline: true,
    });

	if(QrScanner.hasCamera()){
		scanner.start();
	}
</script>


<?php include $urlLocal['urlLocalPlugin'] . 'quayso/view/manager/footer.php'; ?>