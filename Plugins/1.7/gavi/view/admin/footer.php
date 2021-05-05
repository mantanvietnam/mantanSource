<footer>
	<div class="pull-right">
		Gavi System
	</div>
	<div class="clearfix"></div>
</footer>
</div>
</div>


<!-- FastClick -->
<script src="/app/Plugin/gavi/view/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="/app/Plugin/gavi/view/vendors/nprogress/nprogress.js"></script>
<!-- Chart.js -->
<script src="/app/Plugin/gavi/view/vendors/Chart.js/dist/Chart.min.js"></script>
<!-- gauge.js -->
<script src="/app/Plugin/gavi/view/vendors/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="/app/Plugin/gavi/view/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="/app/Plugin/gavi/view/vendors/iCheck/icheck.min.js"></script>
<!-- Skycons -->
<script src="/app/Plugin/gavi/view/vendors/skycons/skycons.js"></script>
<!-- Flot -->
<script src="/app/Plugin/gavi/view/vendors/Flot/jquery.flot.js"></script>
<script src="/app/Plugin/gavi/view/vendors/Flot/jquery.flot.pie.js"></script>
<script src="/app/Plugin/gavi/view/vendors/Flot/jquery.flot.time.js"></script>
<script src="/app/Plugin/gavi/view/vendors/Flot/jquery.flot.stack.js"></script>
<script src="/app/Plugin/gavi/view/vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="/app/Plugin/gavi/view/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="/app/Plugin/gavi/view/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="/app/Plugin/gavi/view/vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="/app/Plugin/gavi/view/vendors/DateJS/build/date.js"></script>
<!-- JQVMap -->
<script src="/app/Plugin/gavi/view/vendors/jqvmap/dist/jquery.vmap.js"></script>
<script src="/app/Plugin/gavi/view/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="/app/Plugin/gavi/view/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="/app/Plugin/gavi/view/vendors/moment/min/moment.min.js"></script>
<script src="/app/Plugin/gavi/view/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- Custom Theme Scripts -->
<script src="/app/Plugin/gavi/view/build/js/custom.min.js"></script>

<!-- <script src="https://www.jqueryscript.net/demo/Easy-jQuery-Input-Mask-Plugin-inputmask/dist/jquery.inputmask.bundle.min.js"></script>
<script src="/app/Plugin/gavi/view/vendors/jquery/ace-elements.min.js"></script>
<script src="/app/Plugin/gavi/view/vendors/jquery/ace.min.js"></script>
<script src="/app/Plugin/gavi/view/vendors/jquery/jquery.maskedinput.min.js"></script> -->


<link rel="stylesheet" type="text/css" href="http://kiosk.webmantan.com/app/Plugin/kiosk/view/manager/css/jquery.datetimepicker.css"/>
<script src="http://kiosk.webmantan.com/app/Plugin/kiosk/view/manager/js/jquery.datetimepicker.full.js"></script>

<script src="/app/Plugin/gavi/view/vendors/jquery/number-divider.js"></script>
<script>
	$(document).ready(function() {
		$('.input_money').divide({delimiter: '.',
			divideThousand: true});

		// $("input.input_date").inputmask();
	});

	StartDate = '2000/03/01';

	$.datetimepicker.setLocale('vi');
	$('.datetimepicker').datetimepicker({
		dayOfWeekStart : 1,
		
		disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
		format:'d/m/Y',
		// startDate:	'2018/01/08',

		lang: 'vi',
		// minDate: new Date()
		minDate: StartDate

	});

	// xóa thời gian
	$('.xdsoft_timepicker').css({'display': 'none'});
	$('.datetimepicker').attr("maxlength", '10');


</script>


<script src="https://www.jqueryscript.net/demo/jQuery-Plugin-For-Displaying-A-Tree-Of-Data-In-A-Table-treetable/vendor/jquery-ui.js"></script>
<script src="https://www.jqueryscript.net/demo/jQuery-Plugin-For-Displaying-A-Tree-Of-Data-In-A-Table-treetable/javascripts/src/jquery.treetable.js"></script>
<link rel="stylesheet" type="text/css" href="https://www.jqueryscript.net/demo/jQuery-Plugin-For-Displaying-A-Tree-Of-Data-In-A-Table-treetable/stylesheets/jquery.treetable.theme.default.css">




<script>
	$("#example-basic").treetable({ expandable: true });

	$("#example-basic-static").treetable();

	$("#example-basic-expandable").treetable({ expandable: true });

	$("#example-advanced").treetable({ expandable: true });

	$("#example-advanced tbody").on("mousedown", "tr", function() {
		$(".selected").not(this).removeClass("selected");
		$(this).toggleClass("selected");
	});

	$("#example-advanced .file, #example-advanced .folder").draggable({
		helper: "clone",
		opacity: .75,
		refreshPositions: true,
		revert: "invalid",
		revertDuration: 300,
		scroll: true
	});

	$("#example-advanced .folder").each(function() {
		$(this).parents("tr").droppable({
			accept: ".file, .folder",
			drop: function(e, ui) {
				var droppedEl = ui.draggable.parents("tr");
				$("#example-advanced").treetable("move", droppedEl.data("ttId"), $(this).data("ttId"));
			},
			hoverClass: "accept",
			over: function(e, ui) {
				var droppedEl = ui.draggable.parents("tr");
				if(this != droppedEl[0] && !$(this).is(".expanded")) {
					$("#example-advanced").treetable("expandNode", $(this).data("ttId"));
				}
			}
		});
	});

	$("form#reveal").submit(function() {
		var nodeId = $("#revealNodeId").val()

		try {
			$("#example-advanced").treetable("reveal", nodeId);
		}
		catch(error) {
			alert(error.message);
		}

		return false;
	});

</script>

<script src="https://www.cssscript.com/demo/collapsible-folder-tree-pure-javascript-jslists/jsLists.min.js"></script>

<script>
	document.getElementById('aa1').addEventListener('click', function(e){
		alert('You clicked link: ' + e.target.id);
	},true);
	JSLists.applyToList('simple_list', 'ALL');
</script>

<script>
	// Select the main list and add the class "hasSubmenu" in each LI that contains an UL
	$('.dai_ly ul').each(function(){
		$this = $(this);
		$this.find("li").has("ul").addClass("hasSubmenu");
	});
	$('li:last-child').each(function(){
		$this = $(this);
		if ($this.children('.dai_ly ul').length === 0){
			$this.closest('.dai_ly ul').css("border-left", "1px solid gray");
		} else {
			$this.closest('.dai_ly ul').children("li").not(":last").css("border-left","1px solid gray");
			$this.closest('.dai_ly ul').children("li").last().children("a").addClass("addBorderBefore");
			$this.closest('.dai_ly ul').css("margin-top","20px");
			$this.closest('.dai_ly ul').find("li").children("ul").css("margin-top","20px");
		};
	});
	$('.dai_ly ul li').each(function(){
		$this = $(this);
		$this.mouseenter(function(){
			$( this ).children("a").css({"font-weight":"bold","color":"#336b9b"});
		});
		$this.mouseleave(function(){
			$( this ).children("a").css({"font-weight":"normal","color":"#428bca"});
		});
	});
	$('.dai_ly ul li.hasSubmenu').each(function(){
		$this = $(this);
		$this.prepend("<a href='#'><i class='fa fa-minus-circle'></i><i style='display:none;' class='fa fa-plus-circle'></i></a>");
		$this.children("a").not(":last").removeClass().addClass("toogle");
	});
	$('.dai_ly ul li.hasSubmenu a.toogle').click(function(){
		$this = $(this);
		$this.closest("li").children("ul").toggle("slow");
		$this.children("i").toggle();
		return false;
	});
</script>

<script>
	$(function() {
		$('#colorselector').change(function(){
			$('.regis_add_ship_item').hide();
			$('#' + $(this).val()).show();
		});
	});
</script>

<script>
 $("#showM").on('shown.bs.modal', function(){
  $(this).find('button').focus();
 });
 $(window).on('load',function(){
  $('#showM').modal('show');
  $('.modal-dialog').draggable({
   handle: ".modal-header"
  });
 });

 $('input, textarea').blur(function(){
   $(this).val($.trim($(this).val()));
  });
</script>



</body>
</html>
