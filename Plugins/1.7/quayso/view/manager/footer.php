<p class="text-muted f_text">TOP TOP DIGIRAL SOLUTION © Copyright 2022</p>
</section>
<?php if(!empty($mess)){ ?>
    <div id="showM" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông báo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="showMess"><?php echo $mess; ?></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
<?php }?>

<script>
    var h = $(window).innerHeight();
    var w = $(window).innerWidth();
    var header_m = $('.header_m').innerHeight();
    var menu_mobile = $('.menu_mobile').innerHeight();
    var content_body = $('.content-body').innerHeight();
    var f_text = $('.f_text').innerHeight();

    //console.log(ab);
    //console.log(h);
    if (w>1200){
        var ab = header_m + content_body;
    } else{
        var ab = 48 + content_body;
    }
    if(ab < (h-50)){
        //$('.f_text').css({'position':'fixed', 'bottom': '0', 'width': '100%'});
        $('.f_text').css({'position':'static', 'bottom': '0', 'width': '100%'});
    } else{
        $('.f_text').css({'position':'static', 'bottom': '0', 'width': '100%'});
    }
</script>
<!-- Vendor -->

<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.browser.mobile.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/bootstrap.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/nanoscroller.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/bootstrap-datepicker.js"></script> 
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/magnific-popup.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.placeholder.js"></script>

<!-- Specific Page Vendor -->
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery-ui-1.10.4.custom.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.ui.touch-punch.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.appear.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/bootstrap-colorpicker.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/bootstrap-multiselect.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.easypiechart.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.flot.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.flot.tooltip.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.flot.pie.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.flot.categories.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.flot.resize.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.sparkline.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/raphael.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/morris.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/gauge.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/snap.svg.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/liquid.meter.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.vmap.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.vmap.sampledata.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.vmap.world.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.vmap.africa.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.vmap.asia.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.vmap.australia.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.vmap.europe.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.vmap.north-america.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.vmap.south-america.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/select2.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.dataTables.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/datatables.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/jquery.autosize.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/bootstrap-fileupload.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/dataTables.tableTools.min.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/examples.datatables.tabletools.js"></script>




<!-- Theme Base, Components and Settings -->
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/theme.js"></script>

<!-- Theme Custom -->
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/theme.custom.js"></script>

<!-- Theme Initialization Files -->
<script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/theme.init.js"></script>



<!-- lịch managerListOrderProcess -->
<!-- <script type="text/javascript" src="<?php echo $urlHomes . 'app/Plugin/quayso/script_ca.js' ; ?>"></script>
    <script src='http://dimsemenov.com/plugins/magnific-popup/dist/jquery.magnific-popup.min.js?v=0.9.9'></script> -->


    <!-- Examples -->
    <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/examples.dashboard.js"></script>
    <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/examples.datatables.editable.js"></script>
    <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/examples.datatables.editabledate.js"></script>
    <!--
    <script type='text/javascript'>window._sbzq||function(e){e._sbzq=[];var t=e._sbzq;t.push(["_setAccount",12726]);var n=e.location.protocol=="https:"?"https:":"http:";var r=document.createElement("script");r.type="text/javascript";r.async=true;r.src=n+"//static.subiz.com/public/js/loader.js";var i=document.getElementsByTagName("script")[0];i.parentNode.insertBefore(r,i)}(window);</script>
    -->


    <!-- <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/number-divider.js"></script> -->
    <script src="<?php echo $urlHomes . 'app/Plugin/quayso/view/manager'; ?>/js/number-divider.js"></script>
    <script>
        $(document).ready(function() {
           $('.input_money').divide({delimiter: ',',
            divideThousand: true});


       });
        function toggle(source) {
            var checkboxes = document.querySelectorAll('.checkAl input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }
        function toggle1(source) {
            var checkboxes = document.querySelectorAll('.checkAl1 input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }
        function toggle2(source) {
            var checkboxes = document.querySelectorAll('.checkAl2 input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }

        function toggle3(source) {
            var checkboxes = document.querySelectorAll('.checkAl3 input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }

    </script>

<script>
  $( function() {

    $('.timepicker').timepicker({
        timeFormat: 'HH:mm',
        interval: 5,
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });


  } );
</script>

<script type="text/javascript">
function copyToClipboard(idCopy,messId) {
    var textCopy = $('#'+idCopy).html();
    textCopy = textCopy.replace(/(<([^>]+)>)/ig,"");
    // Create a "hidden" input
    var aux = document.createElement("input");

    // Assign it the value of the specified element
    aux.setAttribute("value", textCopy);

    // Append it to the body
    document.body.appendChild(aux);

    // Highlight its content
    aux.select();

    // Copy the highlighted text
    document.execCommand("copy");

    // Remove it from the body
    document.body.removeChild(aux);

    // show mess
    $('#'+messId).html('Đã sao chép');

    setInterval(emptyMess, 3000,messId);

}
</script>

</body>
</html>