<?php include "header.php";?>
<div class="col-md-3 left_col">
	<?php include "sidebar.php";?>
</div>

<?php include "top.php";?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
  .ui-autocomplete-loading {
    background: white url("/app/Plugin/gavi/view/admin/images/ui-anim_basic_16x16.gif") right center no-repeat;
  }
  .ui-draggable, .ui-droppable {
	background-position: top;
  }
</style>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
<script>
  $( function() {
    $( "#codeAgencyTo" ).autocomplete({
      source: function( request, response ) {
        $.ajax( {
          url: "/searchAgencyAjax",
          dataType: "json",
          data: {
            term: request.term
          },
          success: function( data ) {
            response( data );
          }
        } );
      },
      minLength: 2,
      select: function( event, ui ) {
        //log( "Selected: " + ui.item.value + " aka " + ui.item.id );
      }
    } );
  } );
</script>

<div class="right_col" role="main">
	<div class="">
		<form action="" id="add_agency_form" class="form-horizontal form-label-left" method="post" >
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Điều chuyển đại lý</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>

						<div class="x_content">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="agency_exchange_to">Đại lý chuyển:<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="codeAgencyFrom" required="required" class="form-control col-md-7 col-xs-12" id="agency_exchange_to" placeholder="Mã đại lý chuyển" type="text" value="<?php echo @$_GET['code'];?>">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12 agency-exchange"><i class="fa fa-exchange" aria-hidden="true"></i></label>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="codeAgencyTo">Đại lý đến:</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="codeAgencyTo" class="form-control col-md-7 col-xs-12" id="codeAgencyTo" placeholder="Mã đại lý đến" type="text" autocomplete="off" value="">
								</div>
								<div class="col-md-offset-3 col-md-6 col-sm-6 col-sm-offset-3 col-xs-12 note-exchange">
									Chú ý: Để trống nếu chuyển đại lý về công ty								
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="agency_exchange_to">Mật khẩu admin:<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input name="pass" required="required" class="form-control col-md-7 col-xs-12" id="agency_exchange_to" placeholder="Nhập mật khẩu của admin để xác thực" type="password" value="" autocomplete="off">
								</div>
							</div>

							<div class="ln_solid"></div>
							<div class="form-group btn-submit-group">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									<button class="btn btn-success width-100" type="submit">Lưu lại</button>
									<a href="/listAgency" class="btn btn-primary width-100">Hủy bỏ</a>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</form>	
	</div>
</div>
<?php if(!empty($mess)){ ?>
	<div id="showM" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Thông báo</h4>
				</div>
				<div class="modal-body">
					<div class="showMess"><?php echo $mess; ?></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default setfocus" data-dismiss="modal" autofocus>Đóng</button>
				</div>
			</div>

		</div>
	</div>
<?php }?>
<?php include "footer.php";?>
